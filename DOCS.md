# Docs

## Interface
Trong PHP, `Interface` là một `Object`. Là tập hợp các phương thức public mà các lớp con triển khai phải có. Các phương thức chỉ bao gồm tên, tham số, không được chứa body;

```php
# Interface 
interface IUser {
    public function getName();
    public function computed($number);
}

# class 
class User implements IUser {
    public function getName(){
        return md5(time());
    }
    public function computed($number){
        return $number * 2;
    }
}
```

## Class Abastraction
Là một lớp trừu tượng, bao gồm cả các `function`, `property` ... Nếu có từ khóa `abastrct` phía trước `function`, thì nó là phương thức bắt buộc lớp con kế thừa phải khai báo. Abstract có thể chứa các phương thức cụ thể để dùng chung có các lớp con 

```php 
# Absctract
abstract class Attribute{
    // những phương thức mà các lớp con kế thừa bắt buộc phải khai báo
    abstract public function getName();
    abstract protected function getID();

    // phương thức chung
    public function printInfo(){
        echo sprintf('%s - %s', $this->getName(), $this->getID());
    }
}

# class
class User extends Attribute
{
    public function getName(){
        return __CLASS__;
    }
    protected function getID(){
        return md5(time());
    }
}
```

## Traits
Là tập hợp những `function`, `property`, ... được tiêm vào 1 class.

```php
# Trait
trait Tool {
    public static function getDir(){
        return __DIR__;
    }
}

# class
class User extends Attribute implements IAction
{
    use Tool;
}

# use
echo User::getDir();
```

## Final
Là từ khóa khai báo `class`, `function`, `property` là cuối cùng, không thể dùng để extends hoặc ghi đè giá trị được nữa.

# REGEX 
- `\d` ký tự số từ 0-9
- `\D` không phải ký tự số
- 
- `\s` khoảng trắng, dấu cách
- `\S` không phải là khoảng trắng
- 
- `\w` ký tự chữ (a-zA-Z0-9)
- `\W` không phải ký tự chữ
- 
- `?` 0 || 1
- `*` 0 || n
- `+` 1 || n
- 
- `.` ký tự bất kỳ

Một số ví dụ
```php
# kiểm ra chuỗi là ngày trong tuần
$pattern = '/(mon|tue|wed|thu|fri|sat|sun)?(day)/i';

# check tên, bắt đầu với 'Th' nhưng theo sau không phải là 'uận', 'úy'
$pattern = '/th(?!\(uận|úy))/i';

# kiểm tra 1 chuỗi là dạng `năm-tháng-ngày`
$pattern = '/(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})/';

# nếu bắt đầu với 'q', thì phải là 'qu', nếu không thì phải bắt đầu với f
$pattern = '/^(?(?=q)qu|f)/';

# preg match giá trị ra mảng $matches
preg_match($pattern, $str, $matches);

# lọc chỉ lấy những giá trị là key đã định nghĩa trên pattern và giá trị khác rỗng.
$onlyNamed = array_filter($matches, fn ($value, $key) => !is_numeric($key) && !empty($value), ARRAY_FILTER_USE_BOTH);

# tìm kiếm và thay thế với chữ viết HOA
$line = preg_replace_callback('/(?P<name>(thuan|tung|tam))/', fn ($matches) => strtoupper($matches['name']), 'nguyen duc thuan');
// => nguyen duc THUAN 
```