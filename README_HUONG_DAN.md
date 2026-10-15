# MẠNH FASHION — Laravel + MySQL

Đây là bộ mã nguồn bổ sung để chép vào một dự án Laravel mới. Không bao gồm `vendor/`; Composer cài thư viện trên máy bạn.

## A. Cài môi trường Windows
1. Cài XAMPP: https://www.apachefriends.org/ (PHP + MySQL).
2. Cài Composer: https://getcomposer.org/
3. Mở XAMPP Control Panel, bấm Start tại MySQL.
4. Mở CMD và kiểm tra `php -v`, `composer -V`. Nếu PHP không nhận, thêm `C:\xampp\php` vào PATH rồi mở terminal mới.

## B. Tạo dự án
```bash
composer create-project laravel/laravel manh-fashion
cd manh-fashion
```
Giải nén bộ starter này. Chép các thư mục `app`, `database`, `resources`, `routes`, `public` vào thư mục `manh-fashion`, chọn ghi đè file trùng tên. Không chép đè `vendor`, `bootstrap`, `artisan`, `public/index.php`.

## C. Tạo MySQL
Mở `http://localhost/phpmyadmin` → New → database `manh_fashion` → collation `utf8mb4_unicode_ci` → Create.

Mở file `.env` của Laravel và sửa:
```env
APP_NAME="Manh Fashion"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manh_fashion
DB_USERNAME=root
DB_PASSWORD=
```
Nếu MySQL có mật khẩu, nhập vào `DB_PASSWORD`.

## D. Chạy website
Tại terminal trong thư mục `manh-fashion`:
```bash
php artisan key:generate
php artisan config:clear
php artisan migrate --seed
php artisan serve
```
Mở http://127.0.0.1:8000

Tài khoản admin demo:
- Email: `admin@manhfashion.vn`
- Mật khẩu: `ManhFashion@123`

Đổi mật khẩu demo trước khi triển khai công khai.

## Chức năng trong bộ mã nguồn
Trang chủ, danh sách/chi tiết sản phẩm, tìm kiếm/lọc/sắp xếp, đăng ký/đăng nhập, giỏ hàng lưu MySQL, đặt đơn COD, lịch sử đơn hàng, đánh giá cửa hàng/sản phẩm, liên hệ, bản đồ, CRUD sản phẩm, cập nhật trạng thái đơn và dashboard.

Lưu ý:
- COD được xử lý trong đồ án. Ngân hàng/ví điện tử chưa phải thanh toán thật nếu chưa tích hợp cổng thanh toán và xác minh giao dịch.
- Ảnh mẫu lấy từ URL Unsplash, cần Internet. Có thể thay bằng ảnh được phép sử dụng trong `public/images`.
- Chụp ảnh website thật sau khi chạy và kiểm thử để đưa vào báo cáo; không ghi kết quả kiểm thử chưa thực hiện.
