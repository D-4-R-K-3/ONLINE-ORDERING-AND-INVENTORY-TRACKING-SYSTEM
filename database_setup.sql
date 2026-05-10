-- Online Ordering and Inventory Tracking System - Database Setup
-- Run this SQL file to setup the complete database

-- Create Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL UNIQUE,
  `description` text,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20),
  `address` text,
  `role` enum('Admin','Staff','Customer') DEFAULT 'Customer',
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `sku` varchar(50) NOT NULL UNIQUE,
  `price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2),
  `image` varchar(255),
  `status` enum('Available','Discontinued') DEFAULT 'Available',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Inventory Table
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL UNIQUE,
  `quantity_on_hand` int DEFAULT 0,
  `quantity_reserved` int DEFAULT 0,
  `quantity_available` int DEFAULT 0,
  `reorder_level` int DEFAULT 10,
  `reorder_quantity` int DEFAULT 50,
  `alert_status` enum('Normal','Low Stock','Out of Stock') DEFAULT 'Normal',
  `last_restock_date` datetime,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Orders Table
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_number` varchar(50) NOT NULL UNIQUE,
  `order_date` datetime NOT NULL,
  `delivery_address` text NOT NULL,
  `total_items` int DEFAULT 0,
  `subtotal` decimal(10,2) DEFAULT 0,
  `tax_amount` decimal(10,2) DEFAULT 0,
  `shipping_fee` decimal(10,2) DEFAULT 0,
  `total_amount` decimal(10,2) DEFAULT 0,
  `status` enum('Pending','Confirmed','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `payment_status` enum('Unpaid','Paid','Refunded') DEFAULT 'Unpaid',
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  
  KEY `status` (`status`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Order Items Table
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Inventory History Table
CREATE TABLE IF NOT EXISTS `inventory_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `quantity_change` int NOT NULL,
  `quantity_before` int NOT NULL,
  `quantity_after` int NOT NULL,
  `reference_id` int,
  `notes` text,
  `created_by` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `inventory_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_history_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Data

-- Insert Categories
INSERT INTO `categories` (`name`, `description`, `status`) VALUES
('Electronics', 'Electronic gadgets and devices', 'Active'),
('Clothing', 'Apparel and fashion items', 'Active'),
('Home & Garden', 'Home and garden products', 'Active'),
('Books', 'Books and educational materials', 'Active'),
('Sports', 'Sports equipment and accessories', 'Active');

-- Insert Users (passwords are hashed: 'admin123', 'staff123', 'customer123')
INSERT INTO `users` (`username`, `email`, `password`, `first_name`, `last_name`, `phone`, `role`, `status`) VALUES
('admin', 'admin@example.com', '$2y$10$NIqpHROXXf.vw6JUXAa02.5lONTIFsPxNWpkTmaPY4n9EQxOiEVRC', 'Admin', 'User', '09123456789', 'Admin', 'Active'),
('staff', 'staff@example.com', '$2y$10$ofws9lLaTRVHW1Op1JO04um/G/lYvhtCwVaRTDcSVQW5bXkAGw8b6', 'Staff', 'Member', '09123456790', 'Staff', 'Active'),
('customer', 'customer@example.com', '$2y$10$C1pL8OPp8a86lc4LA7rkX.xb6qAy1K7d47GFV/fm0.YOWUUGMWjGS', 'John', 'Doe', '09123456791', 'Customer', 'Active'),
('customer2', 'customer2@example.com', '$2y$10$C1pL8OPp8a86lc4LA7rkX.xb6qAy1K7d47GFV/fm0.YOWUUGMWjGS', 'Jane', 'Smith', '09123456792', 'Customer', 'Active');

-- Insert Products
INSERT INTO `products` (`category_id`, `name`, `description`, `sku`, `price`, `cost`, `status`) VALUES
(1, 'Wireless Headphones', 'High-quality wireless headphones with noise cancellation', 'ELEC-001', 45.99, 25.00, 'Available'),
(1, 'USB-C Cable', 'Durable USB-C charging and data cable', 'ELEC-002', 12.99, 4.00, 'Available'),
(2, 'Cotton T-Shirt', 'Comfortable 100% cotton t-shirt', 'CLOT-001', 19.99, 8.00, 'Available'),
(2, 'Blue Jeans', 'Classic blue denim jeans', 'CLOT-002', 49.99, 20.00, 'Available'),
(3, 'Garden Tool Set', 'Complete set of essential garden tools', 'HOME-001', 39.99, 18.00, 'Available'),
(4, 'Programming Book', 'Learn PHP and Web Development', 'BOOK-001', 29.99, 12.00, 'Available'),
(5, 'Basketball', 'Official size basketball', 'SPOR-001', 24.99, 12.00, 'Available'),
(1, 'Portable Phone Charger', '20000mAh portable power bank', 'ELEC-003', 35.99, 18.00, 'Available');

-- Insert Inventory
INSERT INTO `inventory` (`product_id`, `quantity_on_hand`, `quantity_reserved`, `quantity_available`, `reorder_level`, `reorder_quantity`, `alert_status`) VALUES
(1, 50, 5, 45, 10, 50, 'Normal'),
(2, 200, 10, 190, 20, 100, 'Normal'),
(3, 150, 8, 142, 15, 75, 'Normal'),
(4, 80, 3, 77, 10, 50, 'Normal'),
(5, 30, 2, 28, 5, 25, 'Normal'),
(6, 45, 1, 44, 5, 25, 'Normal'),
(7, 25, 2, 23, 5, 20, 'Normal'),
(8, 15, 0, 15, 10, 50, 'Low Stock');

-- Insert Sample Order
INSERT INTO `orders` (`customer_id`, `order_number`, `order_date`, `delivery_address`, `total_items`, `subtotal`, `tax_amount`, `shipping_fee`, `total_amount`, `status`, `payment_status`) VALUES
(3, 'ORD-20250509001', NOW(), '123 Main Street, City, Country', 2, 80.98, 6.48, 5.00, 92.46, 'Processing', 'Paid');

-- Insert Order Items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `unit_price`, `total_price`) VALUES
(1, 1, 1, 45.99, 45.99),
(1, 3, 2, 19.99, 39.98);

-- Insert Inventory History
INSERT INTO `inventory_history` (`product_id`, `transaction_type`, `quantity_change`, `quantity_before`, `quantity_after`, `reference_id`, `notes`, `created_by`) VALUES
(1, 'Order', -1, 46, 45, 1, 'Sold via Order ORD-20250509001', 2),
(3, 'Order', -2, 144, 142, 1, 'Sold via Order ORD-20250509001', 2);
