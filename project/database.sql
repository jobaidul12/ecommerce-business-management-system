-- =====================================================
-- Ranga Dhaga Fashion Store — Database Schema
-- Run this in phpMyAdmin or MySQL CLI
-- =====================================================

CREATE DATABASE IF NOT EXISTS project_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE project_db;

-- ─── USERS ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    fullname   VARCHAR(100)  NOT NULL,
    email      VARCHAR(100)  NOT NULL UNIQUE,
    phone      VARCHAR(20),
    password   VARCHAR(255)  NOT NULL,
    created_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─── ORDERS ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS orders (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT          NULL,
    order_number    VARCHAR(30)  NOT NULL UNIQUE,
    customer_name   VARCHAR(100) NOT NULL,
    phone           VARCHAR(20)  NOT NULL,
    address         TEXT         NOT NULL,
    subtotal        DECIMAL(10,2) NOT NULL,
    delivery_charge DECIMAL(10,2) NOT NULL DEFAULT 60,
    total           DECIMAL(10,2) NOT NULL,
    payment_method  VARCHAR(50)  NOT NULL DEFAULT 'Cash on Delivery',
    status          ENUM('Pending','Confirmed','Processing','Shipped','Delivered','Cancelled')
                    NOT NULL DEFAULT 'Pending',
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─── ORDER ITEMS ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT          NOT NULL,
    product_id   INT          NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    product_img  VARCHAR(20)  DEFAULT '',
    price        DECIMAL(10,2) NOT NULL,
    quantity     INT          NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─── CONTACT MESSAGES ────────────────────────────────
CREATE TABLE IF NOT EXISTS contact_messages (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    message    TEXT         NOT NULL,
    is_read    TINYINT(1)   NOT NULL DEFAULT 0,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
