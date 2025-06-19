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

## Bước 3: Tạo symbolic link cho storage
```bash
php artisan storage:link
```

## Bước 4: Thiết lập database
```bash
php artisan migrate
php artisan db:seed
```

## Lưu ý quan trọng:
- Thư mục `storage/app/public/brands/` và `storage/app/public/products/` đã được đưa vào Git
- Sau khi chạy `php artisan storage:link`, các ảnh sẽ tự động hiển thị
- Khi admin upload ảnh mới, cần commit và push để đồng bộ với team 