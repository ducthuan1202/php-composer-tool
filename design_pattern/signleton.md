# Singleton pattern

là kiểu khởi tạo 1 lần

```php

class Database{
    private static $instance;

    public static function getInstance(){
        if(!self::$instance){
            self::$instace = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');
        }
        return self::$instance;
    }
}

$db1 = Database::getInstance();
$db2 = Database::getInstance();
// $db1 === $db2
```
