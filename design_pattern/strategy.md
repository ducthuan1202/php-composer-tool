# Strategy pattern - Mẫu chiến lược

Các class có các method cùng tên

```php

class Worker {
    public function sing(){
        echo 'worker sing';
    }
}

class Developer {
    public function sing(){
        echo 'developer sing';
    }
}

if(rand() > 0.5){
    $people = new Worker();
} else {
    $people = new Developer();
}

$people->sing();
```
