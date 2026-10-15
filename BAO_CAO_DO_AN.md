Năm học: 2026–2027

# LỜI MỞ ĐẦU

Cùng với sự phát triển của Internet, mua sắm trực tuyến trở thành hình thức phổ biến nhờ tính thuận tiện và khả năng tiếp cận nhiều sản phẩm. Đề tài Mạnh Fashion được thực hiện nhằm vận dụng kiến thức phân tích thiết kế hệ thống, lập trình web và cơ sở dữ liệu để xây dựng một website bán hàng thời trang ở quy mô đồ án.

Báo cáo trình bày yêu cầu, Use Case, cơ sở dữ liệu MySQL, kiến trúc Laravel, chức năng và quy trình kiểm thử. Sinh viên cần bổ sung ảnh chụp màn hình thực tế sau khi cài đặt và chạy website.

# CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI

## 1.1. Lý do chọn đề tài

Website bán hàng giúp cửa hàng giới thiệu sản phẩm, quản lý dữ liệu tập trung và hỗ trợ khách hàng đặt hàng từ xa. Thời trang phù hợp để minh họa danh mục, biến thể size/màu, giỏ hàng, đơn hàng và đánh giá.

## 1.2. Mục tiêu

- Xây dựng giao diện hiện đại, responsive.

- Đăng ký, đăng nhập và phân quyền khách hàng/quản trị viên.

- Hiển thị, tìm kiếm, lọc sản phẩm; quản lý giỏ hàng và đơn hàng.

- Xây dựng CRUD sản phẩm, đánh giá, liên hệ và lưu dữ liệu trong MySQL.

## 1.3. Phạm vi

Phiên bản cơ sở xử lý COD. Thanh toán ngân hàng/ví điện tử cần tích hợp cổng thanh toán thật và xác minh giao dịch trước khi sử dụng trên môi trường thực tế.

## 1.4. Công nghệ

HTML5, CSS3, JavaScript, PHP, Laravel, MySQL, Composer, VS Code và Git/GitHub.

# CHƯƠNG 2. PHÂN TÍCH YÊU CẦU

## 2.1. Tác nhân

Khách truy cập: xem trang chủ, danh sách/chi tiết sản phẩm, cửa hàng và liên hệ. Khách hàng: đăng ký/đăng nhập, tìm kiếm, giỏ hàng, đặt hàng, xem lịch sử đơn và đánh giá. Quản trị viên: quản lý sản phẩm, đơn hàng và thống kê.

## 2.2. Yêu cầu chức năng

- CN01: Đăng ký, đăng nhập, đăng xuất.

- CN02: Trang chủ, danh mục và sản phẩm nổi bật.

- CN03: Tìm kiếm, lọc danh mục, sắp xếp giá.

- CN04: Chi tiết sản phẩm, hình ảnh, giá, size, màu, tồn kho.

- CN05: Thêm, sửa số lượng, xóa sản phẩm trong giỏ.

- CN06: Nhập thông tin nhận hàng và đặt đơn COD.

- CN07: Xem lịch sử, trạng thái và chi tiết đơn hàng.

- CN08: Đánh giá sản phẩm/cửa hàng bằng sao và nhận xét.

- CN09: Gửi liên hệ và xem thông tin cửa hàng/bản đồ.

- CN10: Admin thêm, sửa, xóa hoặc ẩn sản phẩm.

- CN11: Admin cập nhật trạng thái đơn hàng.

- CN12: Dashboard số sản phẩm, đơn hàng, doanh thu đơn đã giao.

## 2.3. Yêu cầu phi chức năng

- Giao diện tương thích máy tính, tablet và điện thoại.

- Tiếng Việt sử dụng UTF-8/utf8mb4.

- Mật khẩu lưu dạng băm, dữ liệu đầu vào được kiểm tra phía server.

- Phân quyền admin; người dùng chỉ xem đơn của mình.

- Có khóa ngoại, chỉ mục và transaction khi tạo đơn.

## 2.4. Use Case tổng quát

Tác nhân Khách hàng liên kết với: Đăng ký/Đăng nhập, Xem/Tìm kiếm sản phẩm, Quản lý giỏ hàng, Đặt hàng/Thanh toán, Theo dõi đơn hàng, Đánh giá, Xem cửa hàng và Liên hệ. Tác nhân Quản trị viên liên kết với: Đăng nhập, Quản lý sản phẩm, Quản lý đơn hàng và Thống kê.

## 2.5. Đặc tả Use Case: Đặt hàng

Tác nhân: khách hàng đã đăng nhập. Điều kiện trước: giỏ hàng có sản phẩm còn hàng. Luồng chính: mở giỏ → kiểm tra sản phẩm → nhập người nhận và địa chỉ → chọn COD → nhập voucher nếu có → hệ thống kiểm tra giá và tồn kho → tạo orders và order_items trong transaction → giảm tồn kho, xóa giỏ → hiển thị mã đơn. Ngoại lệ: giỏ trống, thông tin không hợp lệ, hết hàng hoặc transaction lỗi thì không hoàn tất đơn.

## 2.6. Đặc tả Use Case: CRUD sản phẩm

Admin đăng nhập, mở quản lý sản phẩm, chọn thêm/sửa/xóa, nhập dữ liệu, hệ thống kiểm tra danh mục/giá/biến thể, lưu MySQL và thông báo kết quả. Tài khoản khách không được phép truy cập khu vực quản trị.

# CHƯƠNG 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

## 3.1. Quy ước

Dùng MySQL/InnoDB và utf8mb4. Khóa chính id tự tăng, quan hệ dùng khóa ngoại, created_at và updated_at lưu thời gian tạo/cập nhật.

## 3.2. Bảng users

id BIGINT PK; name VARCHAR(100) NOT NULL; email VARCHAR(150) UNIQUE NOT NULL; password VARCHAR(255) chứa mật khẩu đã băm; phone VARCHAR(20) nullable; address VARCHAR(255) nullable; role VARCHAR(20) customer/admin; timestamps.

## 3.3. Bảng categories

id PK; name VARCHAR(100) NOT NULL; slug VARCHAR(120) UNIQUE; description TEXT nullable; timestamps.

## 3.4. Bảng products

id PK; category_id FK; name VARCHAR(200); slug VARCHAR(220) UNIQUE; description TEXT; price DECIMAL(12,2); image VARCHAR(255); is_active BOOLEAN; timestamps.

## 3.5. Bảng product_variants

id PK; product_id FK; size VARCHAR(10); color VARCHAR(50); stock INT không âm; sku VARCHAR(80) UNIQUE; timestamps. Ràng buộc unique theo product_id + size + color.

## 3.6. Bảng carts và cart_items

carts: id PK, user_id FK UNIQUE, timestamps. cart_items: id PK, cart_id FK, variant_id FK, quantity số nguyên dương, timestamps; unique theo cart_id + variant_id.

## 3.7. Bảng orders

id PK; user_id FK; order_code UNIQUE; recipient_name; phone; shipping_address; subtotal; discount_amount; shipping_fee; total_amount; payment_method; payment_status; status; note; timestamps. Tiền sử dụng DECIMAL(12,2).

## 3.8. Bảng order_items

id PK; order_id FK; product_id FK; variant_id FK nullable; product_name; size; color; unit_price; quantity; line_total; timestamps. Lưu tên và giá tại thời điểm mua để bảo toàn lịch sử.

## 3.9. Bảng reviews

id PK; user_id FK; product_id FK nullable; order_id FK nullable; review_type store/product; rating từ 1 đến 5; comment; timestamps.

## 3.10. Bảng contacts

id PK; name; email; phone; subject; message; status; timestamps.

## 3.11. Quan hệ và toàn vẹn dữ liệu

- categories 1–N products; products 1–N product_variants.

- users 1–1 carts; carts 1–N cart_items; variants 1–N cart_items.

- users 1–N orders; orders 1–N order_items; products 1–N order_items.

- users 1–N reviews; products 1–N reviews đối với đánh giá sản phẩm.

- Email và slug phải duy nhất; giá/tồn kho không âm; rating từ 1–5.

- Tổng tiền tính lại ở server; transaction tạo đơn và giảm tồn kho.

- Sản phẩm đã có lịch sử bán nên ẩn thay vì xóa vật lý.

# CHƯƠNG 4. THIẾT KẾ VÀ CÀI ĐẶT

## 4.1. Kiến trúc hệ thống

Trình duyệt gửi HTTP request tới Laravel routes. Controller kiểm tra dữ liệu và xử lý nghiệp vụ; Model Eloquent truy vấn MySQL; Blade render giao diện. Middleware giới hạn quyền truy cập admin.

## 4.2. Danh sách giao diện

- Trang chủ: banner, danh mục, sản phẩm nổi bật, khuyến mãi và đánh giá.

- Sản phẩm: tìm kiếm, lọc, sắp xếp, phân trang.

- Chi tiết: hình ảnh, giá, mô tả, size/màu/tồn kho, chính sách đổi trả và đánh giá.

- Đăng ký/đăng nhập; giỏ hàng; thanh toán; lịch sử đơn hàng.

- Cửa hàng/bản đồ; liên hệ; quản trị CRUD và quản lý trạng thái đơn.

## 4.3. Bảo mật

Form dùng CSRF protection; mật khẩu được băm; server validation kiểm tra dữ liệu; route admin kiểm tra role; route đơn hàng kiểm tra quyền sở hữu; giá và tổng tiền được tính ở server. Khi triển khai thật cần HTTPS, backup và bảo vệ file .env.

# CHƯƠNG 5. KIỂM THỬ

Các ca kiểm thử cần chạy và ghi kết quả thực tế:

- TC01: Đăng ký email mới → tạo tài khoản.

- TC02: Đăng ký email đã tồn tại → báo lỗi.

- TC03: Đăng nhập sai mật khẩu → không đăng nhập.

- TC04: Tìm kiếm sản phẩm → kết quả khớp từ khóa.

- TC05: Thêm sản phẩm đủ tồn kho → giỏ được cập nhật.

- TC06: Đặt COD hợp lệ → tạo orders/order_items.

- TC07: Đặt hàng vượt tồn kho → không tạo đơn.

- TC08: Admin thêm/sửa/xóa sản phẩm → dữ liệu cập nhật.

- TC09: Khách vào URL admin → bị từ chối.

- TC10: Khách mở đơn người khác → bị từ chối.

- TC11: Gửi đánh giá → bản ghi reviews được lưu.

- TC12: Gửi liên hệ → bản ghi contacts được lưu.

Bảng kết quả cần điền sau kiểm thử: Mã ca | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả thực tế | Đạt/Không đạt.

# CHƯƠNG 6. CÀI ĐẶT VÀ HƯỚNG DẪN SỬ DỤNG

## 6.1. Môi trường

Cài XAMPP (PHP/MySQL), Composer, VS Code và Git. Phiên bản PHP phải đáp ứng yêu cầu của phiên bản Laravel được Composer cài.

## 6.2. Các bước cài đặt

- Chạy composer create-project laravel/laravel manh-fashion.

- Chép các thư mục app, database, resources, routes, public từ gói starter vào dự án Laravel mới.

- Tạo database manh_fashion trong phpMyAdmin và cập nhật DB_* trong .env.

- Chạy php artisan key:generate; php artisan config:clear; php artisan migrate --seed; php artisan serve.

- Mở http://127.0.0.1:8000.

## 6.3. Tài khoản quản trị demo

Email: admin@manhfashion.vn. Mật khẩu: ManhFashion@123. Chỉ dùng cho học tập; cần đổi mật khẩu trước khi triển khai công khai.

## 6.4. Hướng dẫn khách hàng

Mở sản phẩm, chọn size/màu và số lượng, thêm vào giỏ, đăng nhập, nhập thông tin nhận hàng, xác nhận COD rồi theo dõi trạng thái tại mục Đơn hàng.

## 6.5. Hướng dẫn quản trị viên

Đăng nhập tài khoản admin, mở Quản trị, vào Quản lý sản phẩm để thêm/sửa/xóa hoặc ẩn; mở Quản lý đơn hàng để cập nhật trạng thái.

# CHƯƠNG 7. KẾT LUẬN VÀ HƯỚNG PHÁT TRIỂN

Đề tài xây dựng website bán hàng thời trang với danh mục, sản phẩm, tài khoản, giỏ hàng, đơn hàng, đánh giá, liên hệ và quản trị. Laravel và MySQL giúp tổ chức mã nguồn theo MVC, lưu dữ liệu tập trung và mở rộng thuận lợi.

Hướng phát triển: tích hợp cổng thanh toán thật, quản lý voucher bằng database, upload ảnh từ admin, gửi email xác nhận, kiểm thử tự động và triển khai HTTPS.

# TÀI LIỆU THAM KHẢO

1. Laravel Documentation: https://laravel.com/docs

2. PHP Manual: https://www.php.net/manual/

3. MySQL Documentation: https://dev.mysql.com/doc/

4. Composer Documentation: https://getcomposer.org/doc/

# PHỤ LỤC — ẢNH CHỤP GIAO DIỆN

Chèn ảnh chụp thực tế: (1) Trang chủ; (2) Danh sách sản phẩm; (3) Chi tiết; (4) Đăng nhập/đăng ký; (5) Giỏ hàng/thanh toán; (6) Đơn hàng; (7) Đánh giá cửa hàng; (8) Quản trị CRUD; (9) Cấu trúc bảng phpMyAdmin; (10) Kết quả kiểm thử.