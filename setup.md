# Hướng dẫn thiết lập sau khi clone repo

## Bước 1: Cài đặt dependencies
```bash
composer install
npm install
```

## Bước 2: Thiết lập environment
```bash
cp .env.example .env
php artisan key:generate
```

## Bước 3: Thiết lập database
```bash
php artisan db:seed
```

## Bước 4: Tạo symbolic link cho storage
```bash
php artisan storage:link
```

## Bước 5: Chạy server
```bash
php artisan serve
```

## Lưu ý quan trọng về ảnh:

### ✅ Đã được thiết lập:
- Thư mục `storage/app/public/brands/` và `storage/app/public/products/` đã được đưa vào Git
- Symbolic link `public/storage/` đã được tạo sẵn và đưa vào Git
- Ảnh sẽ tự động hiển thị sau khi clone

### 🔄 Khi admin thêm ảnh mới:
1. Admin upload ảnh qua trang quản trị
2. Ảnh sẽ được lưu trong `storage/app/public/products/` hoặc `storage/app/public/brands/`
3. **QUAN TRỌNG:** Phải commit và push ảnh mới:
   ```bash
   git add storage/app/public/
   git commit -m "Thêm ảnh mới"
   git push
   ```

### 📁 Cấu trúc thư mục ảnh:
- **File ảnh thực tế:** `storage/app/public/products/` và `storage/app/public/brands/`
- **Truy cập từ web:** `public/storage/products/` và `public/storage/brands/`
- **Đường dẫn trong code:** `/storage/products/` và `/storage/brands/`

### 🚨 Nếu ảnh không hiển thị:
1. Kiểm tra file có tồn tại: `dir storage/app/public/products/`
2. Kiểm tra symbolic link: `dir public/storage/`
3. Nếu không có, chạy: `php artisan storage:link`
4. Kiểm tra database có khớp với tên file không 


//với người clone lại
git clone [repo-url]
cd ban-linh-kien
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link  # (Nếu cần)
php artisan serve