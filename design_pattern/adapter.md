# Adapter pattern - Mẫu chuyển đổi

Giả sử chúng ta có 1 thư viện thứ 3 với rất nhiều functions, nếu triển khai trực tiếp sẽ rất dễ gây rối.
Thay vào đó, chỉ nên sử dụng những thứ chúng ta cần, và gói nó là 1 function sau đó chỉ việc gọi ra sử dụng khi cần.

```php

class Facebook {
    public function postToWalk(string $sms){
        $api = new FacebookSDK();
        $api->post($sms);
    }
}

class FacebookSDK {
    public function post($sms){
        if($this->canPost()){
            $token = $this->getToken();
            $curl = curl_ini();
            # curl options ....
            curl_exec();
        }
    }

    public function getToken(){}

    public function canPost(){}
}

$fb = new Facebook();
$fb->postToWalk('new status');
```
