CREATE DATABASE IF NOT EXISTS mission_system;
USE mission_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- 新增一個 admin 帳號與 user 帳號（密碼為 test123）
INSERT INTO users (username, password, role) VALUES
('admin1', SHA2('test123', 256), 'admin'),
('user1', SHA2('test123', 256), 'user');
