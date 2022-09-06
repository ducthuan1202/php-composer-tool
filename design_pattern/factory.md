# Factory pattern - Mẫu nhà máy

các class sẽ implements chung 1 interface, và có 1 function thực hiện nhận tham số đầu vào là 1 interface

```php
interface Person {
    public function sing();
}

class Worker implements Person{
    public function sing(){
        echo 'worker sing';
    }
}

class Developer implements Person{
    public function sing(){
        echo 'developer sing';
    }
}

function doSomething(Person $person){
    $persion->sing();
}

doSomething(new Worker());
doSomething(new Developer());
```
