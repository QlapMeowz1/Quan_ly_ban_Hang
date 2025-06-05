-- Database cho Website Bán Linh Kiện Máy Tính
-- Tạo database
CREATE DATABASE computer_parts_store;
USE computer_parts_store;

-- Bảng danh mục sản phẩm
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL,
    category_description TEXT,
    parent_category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_category_id) REFERENCES categories(category_id)
);

-- Bảng thương hiệu
CREATE TABLE brands (
    brand_id INT PRIMARY KEY AUTO_INCREMENT,
    brand_name VARCHAR(100) NOT NULL UNIQUE,
    brand_logo VARCHAR(255),
    brand_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng nhà cung cấp
CREATE TABLE suppliers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng sản phẩm
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(200) NOT NULL,
    product_code VARCHAR(50) UNIQUE,
    category_id INT NOT NULL,
    brand_id INT,
    supplier_id INT,
    description TEXT,
    specifications JSON,
    price DECIMAL(12,2) NOT NULL,
    cost_price DECIMAL(12,2),
    stock_quantity INT DEFAULT 0,
    min_stock_level INT DEFAULT 5,
    weight DECIMAL(8,2),
    dimensions VARCHAR(50),
    warranty_period INT DEFAULT 12, -- tháng
    status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id),
    INDEX idx_product_code (product_code),
    INDEX idx_category (category_id),
    INDEX idx_brand (brand_id),
    INDEX idx_status (status)
);

-- Bảng hình ảnh sản phẩm
CREATE TABLE product_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_alt VARCHAR(255),
    is_primary BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Bảng khách hàng
CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    status ENUM('active', 'inactive', 'blocked') DEFAULT 'active',
    email_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username)
);

-- Bảng địa chỉ khách hàng
CREATE TABLE customer_addresses (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    address_type ENUM('home', 'office', 'other') DEFAULT 'home',
    recipient_name VARCHAR(100),
    phone VARCHAR(20),
    address_line1 VARCHAR(200) NOT NULL,
    address_line2 VARCHAR(200),
    city VARCHAR(50) NOT NULL,
    district VARCHAR(50),
    ward VARCHAR(50),
    postal_code VARCHAR(10),
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Bảng giỏ hàng
CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (customer_id, product_id)
);

-- Bảng mã giảm giá
CREATE TABLE coupons (
    coupon_id INT PRIMARY KEY AUTO_INCREMENT,
    coupon_code VARCHAR(50) UNIQUE NOT NULL,
    coupon_name VARCHAR(100),
    discount_type ENUM('percentage', 'fixed_amount') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    minimum_order_amount DECIMAL(12,2) DEFAULT 0,
    maximum_discount_amount DECIMAL(12,2),
    usage_limit INT,
    used_count INT DEFAULT 0,
    valid_from DATETIME NOT NULL,
    valid_until DATETIME NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng đơn hàng
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    customer_id INT NOT NULL,
    order_status ENUM('pending', 'confirmed', 'processing', 'shipping', 'delivered', 'cancelled', 'returned') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_method ENUM('cod', 'bank_transfer', 'credit_card', 'e_wallet') NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    shipping_fee DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(12,2) NOT NULL,
    coupon_id INT,
    shipping_address TEXT NOT NULL,
    billing_address TEXT,
    notes TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    confirmed_at TIMESTAMP NULL,
    shipped_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id),
    INDEX idx_order_number (order_number),
    INDEX idx_customer (customer_id),
    INDEX idx_status (order_status),
    INDEX idx_order_date (order_date)
);

-- Bảng chi tiết đơn hàng
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    product_code VARCHAR(50),
    quantity INT NOT NULL,
    unit_price DECIMAL(12,2) NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Bảng thanh toán
CREATE TABLE payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    payment_method ENUM('cod', 'bank_transfer', 'credit_card', 'e_wallet') NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    amount DECIMAL(12,2) NOT NULL,
    transaction_id VARCHAR(100),
    gateway_response TEXT,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Bảng đánh giá sản phẩm
CREATE TABLE product_reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    order_id INT,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(200),
    review_text TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    UNIQUE KEY unique_review (product_id, customer_id, order_id)
);

-- Bảng admin/nhân viên
CREATE TABLE admin_users (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('super_admin', 'admin', 'staff') DEFAULT 'staff',
    permissions JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng lịch sử nhập kho
CREATE TABLE inventory_history (
    history_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    type ENUM('import', 'export', 'adjustment') NOT NULL,
    quantity_change INT NOT NULL,
    quantity_before INT NOT NULL,
    quantity_after INT NOT NULL,
    reason VARCHAR(200),
    reference_id INT, -- order_id hoặc import_id
    admin_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (admin_id) REFERENCES admin_users(admin_id)
);

-- Bảng cấu hình website
CREATE TABLE site_settings (
    setting_id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng banner/slider
CREATE TABLE banners (
    banner_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200),
    image_url VARCHAR(255) NOT NULL,
    link_url VARCHAR(255),
    description TEXT,
    position ENUM('homepage_slider', 'sidebar', 'footer') DEFAULT 'homepage_slider',
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    start_date DATETIME,
    end_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chèn dữ liệu mẫu

-- Danh mục sản phẩm
INSERT INTO categories (category_name, category_description) VALUES
('CPU - Bộ vi xử lý', 'Bộ vi xử lý trung tâm cho máy tính'),
('Mainboard - Bo mạch chủ', 'Bo mạch chủ kết nối các linh kiện'),
('RAM - Bộ nhớ', 'Bộ nhớ truy cập ngẫu nhiên'),
('VGA - Card đồ họa', 'Card đồ họa xử lý hình ảnh'),
('SSD - Ổ cứng thể rắn', 'Ổ cứng thể rắn tốc độ cao'),
('HDD - Ổ cứng cơ học', 'Ổ cứng truyền thống'),
('PSU - Nguồn máy tính', 'Bộ nguồn cung cấp điện'),
('Case - Vỏ máy tính', 'Vỏ máy tính và phụ kiện'),
('Tản nhiệt', 'Quạt tản nhiệt CPU và case'),
('Phụ kiện', 'Cáp kết nối và phụ kiện khác');

-- Thương hiệu
INSERT INTO brands (brand_name, brand_description) VALUES
('Intel', 'Nhà sản xuất CPU và linh kiện máy tính hàng đầu'),
('AMD', 'Nhà sản xuất CPU và GPU chất lượng cao'),
('ASUS', 'Thương hiệu nổi tiếng về mainboard và linh kiện'),
('MSI', 'Chuyên về gaming và linh kiện hiệu năng cao'),
('Gigabyte', 'Nhà sản xuất mainboard và VGA uy tín'),
('Corsair', 'Chuyên về RAM, PSU và phụ kiện gaming'),
('Kingston', 'Thương hiệu RAM và SSD nổi tiếng'),
('Samsung', 'SSD và linh kiện công nghệ cao'),
('Western Digital', 'Chuyên về ổ cứng và lưu trữ'),
('NVIDIA', 'Nhà sản xuất GPU hàng đầu thế giới');

-- Nhà cung cấp
INSERT INTO suppliers (supplier_name, contact_person, phone, email, address) VALUES
('Công ty TNHH Phân Phối ABC', 'Nguyễn Văn A', '0901234567', 'contact@abc.com', '123 Đường ABC, Quận 1, TP.HCM'),
('Nhà Phân Phối XYZ', 'Trần Thị B', '0912345678', 'info@xyz.com', '456 Đường XYZ, Quận 3, TP.HCM');

-- Cấu hình website
INSERT INTO site_settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'Linh Kiện Máy Tính ABC', 'text', 'Tên website'),
('site_email', 'info@linhkien.com', 'text', 'Email liên hệ'),
('site_phone', '0901234567', 'text', 'Số điện thoại liên hệ'),
('shipping_fee', '30000', 'number', 'Phí vận chuyển mặc định'),
('free_shipping_threshold', '500000', 'number', 'Đơn hàng miễn phí ship'),
('tax_rate', '10', 'number', 'Thuế VAT (%)');

-- Tạo admin mặc định (password: admin123)
INSERT INTO admin_users (username, email, password_hash, full_name, role) VALUES
('admin', 'admin@linhkien.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản trị viên', 'super_admin');

-- Tạo triggers để tự động cập nhật số lượng tồn kho
DELIMITER //

CREATE TRIGGER update_stock_after_order
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE products 
    SET stock_quantity = stock_quantity - NEW.quantity
    WHERE product_id = NEW.product_id;
    
    INSERT INTO inventory_history (product_id, type, quantity_change, quantity_before, quantity_after, reason, reference_id)
    VALUES (NEW.product_id, 'export', -NEW.quantity, 
            (SELECT stock_quantity + NEW.quantity FROM products WHERE product_id = NEW.product_id),
            (SELECT stock_quantity FROM products WHERE product_id = NEW.product_id),
            'Bán hàng', NEW.order_id);
END//

DELIMITER ;

-- Tạo view để thống kê sản phẩm
CREATE VIEW product_stats AS
SELECT 
    p.product_id,
    p.product_name,
    p.stock_quantity,
    p.price,
    COALESCE(AVG(pr.rating), 0) as avg_rating,
    COUNT(pr.review_id) as review_count,
    COALESCE(SUM(oi.quantity), 0) as total_sold
FROM products p
LEFT JOIN product_reviews pr ON p.product_id = pr.product_id AND pr.status = 'approved'
LEFT JOIN order_items oi ON p.product_id = oi.product_id
GROUP BY p.product_id, p.product_name, p.stock_quantity, p.price;

-- Tạo view thống kê đơn hàng theo tháng
CREATE VIEW monthly_order_stats AS
SELECT 
    YEAR(order_date) AS year,
    MONTH(order_date) AS month,
    COUNT(*) AS total_orders,
    SUM(total_amount) AS total_revenue,
    AVG(total_amount) AS avg_order_value
FROM orders 
WHERE order_status != 'cancelled'
GROUP BY YEAR(order_date), MONTH(order_date)
ORDER BY year DESC, month DESC;