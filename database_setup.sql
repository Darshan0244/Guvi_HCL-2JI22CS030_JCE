-- Database setup for MySQL
CREATE DATABASE IF NOT EXISTS user_management;
USE user_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- I will be using MongoDB for profiles collection
-- Collection: user_management.profiles
-- Document structure:
-- {
--   userId: int,
--   age: string,
--   dob: string,
--   contact: string,
--   address: string,
--   updatedAt: ISODate
-- }