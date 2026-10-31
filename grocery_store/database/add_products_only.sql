-- Run this if you already have the grocery_store database (keeps all your data).
USE grocery_store;

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
