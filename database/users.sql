CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15) UNIQUE,
    password VARCHAR(255) NOT NULL,
    two_factor_secret VARCHAR(32),
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    
    -- Thông tin cá nhân
    full_name VARCHAR(100),
    avatar_url VARCHAR(255),
    bio TEXT,
    gender ENUM('male', 'female', 'other'),
    birthdate DATE,
    
    -- Thông tin tài khoản
    balance DECIMAL(15, 2) DEFAULT 0.00,
    points INT UNSIGNED DEFAULT 0,
    role ENUM('user', 'admin', 'mod') DEFAULT 'user',
    account_status ENUM('active', 'suspended', 'banned') DEFAULT 'active',
    
    -- Bảo mật & Xác thực
    email_verified_at TIMESTAMP NULL,
    phone_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100),
    password_reset_token VARCHAR(100),
    password_reset_expires TIMESTAMP NULL,
    
    -- Theo dõi hoạt động
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45),
    failed_login_attempts INT UNSIGNED DEFAULT 0,
    last_failed_login_at TIMESTAMP NULL,
    
    -- Theo dõi thiết bị
    user_agent TEXT,
    device_info JSON,
    last_devices JSON, -- Lưu 5 thiết bị đăng nhập gần nhất
    
    -- Token & Sessions
    api_token VARCHAR(100),
    refresh_token VARCHAR(100),
    session_id VARCHAR(100),
    
    -- Tích hợp mạng xã hội
    google_id VARCHAR(100),
    facebook_id VARCHAR(100),
    
    -- Cài đặt người dùng
    preferences JSON, -- Lưu các cài đặt như ngôn ngữ, theme, notifications
    notification_settings JSON,
    privacy_settings JSON,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL, -- Soft delete
    
    -- Indexes
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_username (username),
    INDEX idx_status (account_status),
    INDEX idx_created (created_at),
    INDEX idx_role (role),
    
    -- Full-text search
    FULLTEXT INDEX ft_search (username, full_name, email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trigger để cập nhật updated_at
DELIMITER //
CREATE TRIGGER before_users_update 
    BEFORE UPDATE ON users
    FOR EACH ROW 
BEGIN
    SET NEW.updated_at = CURRENT_TIMESTAMP;
END;//
DELIMITER ;

-- Bảng lưu lịch sử đăng nhập
CREATE TABLE IF NOT EXISTS user_login_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    login_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT,
    device_info JSON,
    login_status ENUM('success', 'failed') DEFAULT 'success',
    failure_reason VARCHAR(255),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_login (user_id, login_at)
);

-- Bảng lưu lịch sử thay đổi
CREATE TABLE IF NOT EXISTS user_activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    action VARCHAR(50),
    description TEXT,
    changes JSON,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_activity (user_id, created_at)
);

-- Bảng ví điện tử
CREATE TABLE IF NOT EXISTS wallets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    balance DECIMAL(15, 2) DEFAULT 0.00,
    frozen_balance DECIMAL(15, 2) DEFAULT 0.00,
    currency VARCHAR(10) DEFAULT 'VND',
    wallet_type ENUM('main', 'bonus', 'savings') DEFAULT 'main',
    last_transaction_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_wallet (user_id, wallet_type)
);

-- Bảng giao dịch
CREATE TABLE IF NOT EXISTS transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_code VARCHAR(50) UNIQUE,
    user_id BIGINT UNSIGNED,
    wallet_id BIGINT UNSIGNED,
    amount DECIMAL(15, 2) NOT NULL,
    balance_before DECIMAL(15, 2),
    balance_after DECIMAL(15, 2),
    type ENUM('deposit', 'withdraw', 'transfer', 'receive', 'payment', 'refund') NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    description TEXT,
    reference_id VARCHAR(100),
    payment_method VARCHAR(50),
    fee DECIMAL(10, 2) DEFAULT 0.00,
    
    -- Thông tin người nhận nếu là chuyển khoản
    recipient_id BIGINT UNSIGNED NULL,
    recipient_info JSON,
    
    -- Metadata bổ sung
    metadata JSON,
    admin_note TEXT,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wallet_id) REFERENCES wallets(id),
    FOREIGN KEY (recipient_id) REFERENCES users(id),
    
    INDEX idx_user_trans (user_id, created_at),
    INDEX idx_status (status),
    INDEX idx_type (type),
    INDEX idx_code (transaction_code)
);

-- Bảng lịch sử số dư
CREATE TABLE IF NOT EXISTS balance_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    wallet_id BIGINT UNSIGNED,
    transaction_id BIGINT UNSIGNED,
    balance_before DECIMAL(15, 2),
    balance_after DECIMAL(15, 2),
    change_amount DECIMAL(15, 2),
    change_type ENUM('increase', 'decrease'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (wallet_id) REFERENCES wallets(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    INDEX idx_wallet_history (wallet_id, created_at)
);

-- Bảng phương thức thanh toán
CREATE TABLE IF NOT EXISTS payment_methods (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    type ENUM('bank', 'card', 'ewallet', 'crypto'),
    provider VARCHAR(50),
    account_number VARCHAR(50),
    account_name VARCHAR(100),
    is_default BOOLEAN DEFAULT FALSE,
    is_verified BOOLEAN DEFAULT FALSE,
    metadata JSON,
    last_used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_payment (user_id, type)
);

-- Trigger để cập nhật số dư ví khi có giao dịch hoàn tất
DELIMITER //
CREATE TRIGGER after_transaction_complete
    AFTER UPDATE ON transactions
    FOR EACH ROW
BEGIN
    IF NEW.status = 'completed' AND OLD.status != 'completed' THEN
        -- Cập nhật số dư ví
        IF NEW.type IN ('deposit', 'receive', 'refund') THEN
            UPDATE wallets 
            SET balance = balance + NEW.amount,
                last_transaction_at = CURRENT_TIMESTAMP
            WHERE id = NEW.wallet_id;
        ELSEIF NEW.type IN ('withdraw', 'transfer', 'payment') THEN
            UPDATE wallets 
            SET balance = balance - NEW.amount,
                last_transaction_at = CURRENT_TIMESTAMP
            WHERE id = NEW.wallet_id;
        END IF;
        
        -- Ghi lịch sử số dư
        INSERT INTO balance_history (
            wallet_id, 
            transaction_id,
            balance_before,
            balance_after,
            change_amount,
            change_type
        ) VALUES (
            NEW.wallet_id,
            NEW.id,
            NEW.balance_before,
            NEW.balance_after,
            NEW.amount,
            CASE 
                WHEN NEW.type IN ('deposit', 'receive', 'refund') THEN 'increase'
                ELSE 'decrease'
            END
        );
    END IF;
END;//
DELIMITER ;

-- Bảng danh mục sản phẩm/dịch vụ
CREATE TABLE IF NOT EXISTS product_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE,
    description TEXT,
    parent_id BIGINT UNSIGNED NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES product_categories(id),
    INDEX idx_category_status (status)
);

-- Bảng sản phẩm/dịch vụ
CREATE TABLE IF NOT EXISTS products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    description TEXT,
    price DECIMAL(15, 2) NOT NULL,
    sale_price DECIMAL(15, 2),
    stock INT DEFAULT 0,
    type ENUM('digital', 'physical', 'service') NOT NULL,
    status ENUM('active', 'inactive', 'out_of_stock') DEFAULT 'active',
    metadata JSON, -- Thông tin thêm như: thời hạn, điều kiện sử dụng...
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES product_categories(id),
    INDEX idx_product_status (status),
    FULLTEXT INDEX ft_product_search (name, description)
);

-- Bảng đơn hàng
CREATE TABLE IF NOT EXISTS orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    order_code VARCHAR(50) UNIQUE,
    total_amount DECIMAL(15, 2) NOT NULL,
    discount_amount DECIMAL(15, 2) DEFAULT 0,
    final_amount DECIMAL(15, 2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    order_status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    transaction_id BIGINT UNSIGNED,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    INDEX idx_order_status (order_status),
    INDEX idx_payment_status (payment_status)
);

-- Chi tiết đơn hàng
CREATE TABLE IF NOT EXISTS order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED,
    product_id BIGINT UNSIGNED,
    quantity INT NOT NULL,
    unit_price DECIMAL(15, 2) NOT NULL,
    total_price DECIMAL(15, 2) NOT NULL,
    metadata JSON, -- Thông tin thêm của sản phẩm tại thời điểm mua
    
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_order_product (order_id, product_id)
);

-- Lịch sử sử dụng dịch vụ
CREATE TABLE IF NOT EXISTS service_usage_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    product_id BIGINT UNSIGNED,
    order_item_id BIGINT UNSIGNED,
    usage_type ENUM('activated', 'consumed', 'expired') NOT NULL,
    usage_amount INT DEFAULT 1,
    remaining_amount INT,
    expires_at TIMESTAMP NULL,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_item_id) REFERENCES order_items(id),
    INDEX idx_user_service (user_id, product_id)
);

-- Mã giảm giá
CREATE TABLE IF NOT EXISTS discount_codes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    type ENUM('percentage', 'fixed_amount') NOT NULL,
    value DECIMAL(10, 2) NOT NULL,
    min_order_amount DECIMAL(15, 2),
    max_discount_amount DECIMAL(15, 2),
    starts_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    usage_limit INT,
    used_count INT DEFAULT 0,
    status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_code_status (status)
);

-- Lịch sử sử dụng mã giảm giá
CREATE TABLE IF NOT EXISTS discount_usage_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    discount_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    order_id BIGINT UNSIGNED,
    discount_amount DECIMAL(15, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (discount_id) REFERENCES discount_codes(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);