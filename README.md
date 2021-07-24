## Sử dụng

$name = Tương ứng trong file config, ví dụ bạn muốn tạo 1 google client bằng tài khoản A, thì đặt tên google_a = thông tin của tài khoản A (bao gồm credentials, scopes, và đường dẫn lưu token)

``` php
use Redmix0901\GoogleToken\Facades\Goten;

$google_client = Goten::use($name)->getClient();
```
Trước khi sử dụng hãy lưu ý chạy lệnh sau để lấy token

``` php
php artisan goten:get-token google_a
```