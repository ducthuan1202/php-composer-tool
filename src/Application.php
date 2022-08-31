<?php

namespace Src;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\Uid\Uuid;
use Src\Database;

class Application
{

    public function start()
    {

        $uuid = Uuid::v4();

        $usersDB = $this->getUserFromDatabase();

        $usersNetwork = $this->getWithCookie();

        header('content-type: application/json');

        # $user = Arr::first($usersDB);
        # $date = new DateTime($user['created_at'], new DateTimeZone('UTC'));
        # $date = new DateTime($user['created_at']);

        echo json_encode([
            'request_id' => $uuid,
            'internal' => $usersDB,
            'external' => $usersNetwork,
        ]);
    }

    function getWithCookie()
    {

        // CURL tới 1 website làm bằng Laravel, sử dụng cookie login để gửi request
        $jar = CookieJar::fromArray([
            config('app.cookie_account.name') => config('app.cookie_account.value'),
        ], 'localhost');

        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout'  => 2.0,
            'cookies' => $jar,
        ]);

        $response = $client->request('GET', 'page-member');

        return json_decode($response->getBody(), true);
    }

    function getUsersFromNetwork()
    {
        # send request CURL
        $client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com',
            'timeout'  => 2.0,
        ]);

        // trigger_error('cannot fetch data from network', E_USER_NOTICE);

        # Send a request to https://jsonplaceholder.typicode.com/users
        $response = $client->request('GET', 'users');

        # request success
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        }

        $reason = $response->getReasonPhrase(); // OK

        return null;
    }

    public function getUserFromDatabase()
    {

        $queryBuilder = Database::getQueryBuilder();

        // throw new Exception('cannot get users from database', 500);

        # query 
        $queryBuilder
            ->from('users')
            ->select(['id', 'name', 'email', 'created_at'])
            ->where('email LIKE ?')->setParameter(0, '%@example.com')
            ->andWhere('id > ?')->setParameter(1, 30);

        $queryBuilder
            ->setFirstResult(0) // offset
            ->setMaxResults(15); // limit

        $data = $queryBuilder->fetchAllAssociative();

        return $data;
    }
}
