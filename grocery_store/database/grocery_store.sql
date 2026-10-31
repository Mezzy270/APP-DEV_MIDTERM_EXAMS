-- FRESH INSTALL (creates everything from scratch)
CREATE DATABASE IF NOT EXISTS grocery_store;
USE grocery_store;

CREATE TABLE users (
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50)  NOT NULL,
    last_name  VARCHAR(50)  NOT NULL,
    age        INT          NOT NULL,
    address    VARCHAR(255),
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
    customer_id  INT AUTO_INCREMENT PRIMARY KEY,
    full_name    VARCHAR(100) NOT NULL,
    email        VARCHAR(100),
    phone        VARCHAR(20),
    address      VARCHAR(255),
    added_by     INT NULL,
    date_added   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_by   INT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by)   REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE orders (
    order_id     INT AUTO_INCREMENT PRIMARY KEY,
    customer_id  INT NOT NULL,
    item_name    VARCHAR(100) NOT NULL,
    quantity     INT NOT NULL,
    total_price  DECIMAL(10,2) NOT NULL,
    order_date   DATE NOT NULL,
    added_by     INT NULL,
    date_added   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_by   INT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (added_by)    REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by)  REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE activity_log (
    log_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NULL,
    action     VARCHAR(20)  NOT NULL,
    table_name VARCHAR(30)  NOT NULL,
    record_id  INT,
    details    VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- Price list shown on the Orders pages
CREATE TABLE products (
    product_id   INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    price        DECIMAL(10,2) NOT NULL
);

INSERT INTO products (product_name, price) VALUES
('Rice (1 kg)', 56.00),
('Eggs (1 dozen)', 108.00),
('Cooking Oil (1 L)', 98.00),
('Sugar (1 kg)', 85.00),
('Salt (500 g)', 18.00),
('Fresh Milk (1 L)', 95.00),
('Loaf Bread', 65.00),
('Instant Noodles', 14.00),
('Canned Sardines', 25.00),
('3-in-1 Coffee (10 sachets)', 55.00),
('Soy Sauce (1 L)', 42.00),
('Chicken (1 kg)', 220.00),
('Pork (1 kg)', 340.00),
('Bananas (1 kg)', 60.00),
('Soft Drink (1.5 L)', 75.00),
('Bottled Water (500 ml)', 15.00);
