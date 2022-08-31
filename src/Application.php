<?php

namespace Src;

use GuzzleHttp\Client;
use Symfony\Component\Uid\Uuid;
use Src\Database;

class Application
{

    public function start()
    {

        $uuid = Uuid::v4();

        $usersDB = $this->getUserFromDatabase();

        $usersNetwork = $this->getUserFromNetwork();

        header('content-type: application/json');
        
        echo json_encode([
            'request_id' => $uuid,
            'internal' => $usersDB,
            'external' => $usersNetwork,
        ]);
    }

    function getUserFromNetwork()
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
            ->select(['id', 'name', 'email'])
            ->where('email LIKE ?')->setParameter(0, '%@example.com')
            ->andWhere('id > ?')->setParameter(1, 30);

        $queryBuilder
            ->setFirstResult(0) // offset
            ->setMaxResults(15); // limit
        
        $data = $queryBuilder->fetchAllAssociative(); 

        return $data;
    }
}
