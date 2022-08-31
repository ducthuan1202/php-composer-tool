# Packages

- [guzzlehttp/guzzle](https://docs.guzzlephp.org/en/stable/overview.html)
- [symfony/var-dumper](https://symfony.com/doc/current/components/var_dumper.html)
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)
- [doctrine/dbal](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/introduction.html)
- [symfony/uid](https://symfony.com/doc/current/components/uid.html)

# Install 
```
# send request (CURL)
composer require guzzlehttp/guzzle

# read .env file
composer require vlucas/phpdotenv

# doctrine query builder
composer require doctrine/dbal

# uuid
composer require symfony/uid

# dump data
composer require --dev symfony/var-dumper
```

## Utils

- MySQL
```sql

-- xem timezone cua DB hien tai --
SHOW VARIABLES LIKE '%time_zone%';

-- xem thời gian hiện tại trong DB, so sánh với giờ local để check timezone --
SELECT NOW();

-- set lại timezone cho toàn bộ DB là múi giờ +7
SET GOLBAL time_zone = '+07:00';

```