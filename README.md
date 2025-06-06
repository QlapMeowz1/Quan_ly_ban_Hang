# 🛍️ Hệ Thống Quản Lý Bán Linh Kiện Máy Tính

## 📝 Mô tả  
Hệ thống quản lý bán linh kiện máy tính là một **website thương mại điện tử** được xây dựng bằng **Laravel**, cung cấp giải pháp toàn diện cho việc quản lý cửa hàng kinh doanh linh kiện máy tính như CPU, RAM, SSD, VGA, v.v.

## ✨ Tính năng chính

### 👤 Quản lý người dùng
- 🔐 Đăng ký và đăng nhập tài khoản  
- 🛡️ Phân quyền **Admin** và **User**  
- 👥 Quản lý thông tin cá nhân  
- 🔄 Đổi mật khẩu  

### 🛒 Quản lý sản phẩm
- 🗂️ Danh mục sản phẩm đa dạng (CPU, RAM, SSD, VGA, PSU, Case, v.v.)  
- 🔍 Tìm kiếm & lọc sản phẩm theo nhiều tiêu chí  
- 🖼️ Xem chi tiết sản phẩm với hình ảnh  
- 📦 Quản lý tồn kho linh kiện  

### 📦 Quản lý đơn hàng
- 🛍️ Giỏ hàng trực tuyến  
- 💳 Đặt hàng & thanh toán  
- 🚚 Theo dõi trạng thái đơn hàng  
- 📜 Xem lịch sử mua hàng  

### 🧑‍💼 Quản lý khách hàng
- 👤 Thông tin khách hàng  
- 📆 Lịch sử giao dịch  
- 🏠 Quản lý địa chỉ giao hàng  

## 🛠️ Công nghệ sử dụng

| Thành phần     | Công nghệ                |
|----------------|--------------------------|
| ⚙️ Backend     | Laravel 10.x             |
| 🎨 Frontend    | Blade + Tailwind CSS     |
| 🗃️ Database    | MySQL                    |
| 🔐 Auth        | Laravel UI               |
| 💸 Thanh toán | Tích hợp cổng thanh toán |

## 🚀 Hướng dẫn cài đặt

1. **Clone repository**:
```bash
git clone [repository-url]
```

2. **Cài đặt dependencies**:
```bash
composer install
npm install
```

3. **Cấu hình môi trường**:
```bash
cp .env.example .env
php artisan key:generate
```

4. **Cập nhật cấu hình database trong file `.env`**

5. **Chạy migration**:
```bash
php artisan migrate
```

6. **Chạy seed dữ liệu (nếu có)**:
```bash
php artisan db:seed
```

7. **Khởi động server**:
```bash
php artisan serve
npm run dev
```

## 📋 Yêu cầu hệ thống
- 🐘 PHP >= 8.1  
- 📦 Composer  
- 🟢 Node.js & NPM  
- 🐬 MySQL  
- 🧬 Git  

## 👥 Tác giả
- 💻 [Tên của bạn]

## 📄 License
- 📜 MIT License

## 📞 Liên hệ
- ✉️ Email: [hunter_rain@melmuop.space](mailto:hunter_rain@melmuop.space)  
- 🌐 Website: [https://melmuop.space](https://melmuop.space)
