CREATE DATABASE saas_product;

USE saas_product;

-- Table for users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for AI search logs
CREATE TABLE ai_search_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    query TEXT NOT NULL,
    response TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table for chatbot conversations
CREATE TABLE chatbot_conversations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT NOT NULL,
    bot_response TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table for accessibility settings
CREATE TABLE accessibility_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    text_size ENUM('small', 'medium', 'large') DEFAULT 'medium',
    high_contrast BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user';

CREATE TABLE IF NOT EXISTS ai_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    query TEXT NOT NULL,
    response TEXT NOT NULL,
    tokens_used INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE ai_logs ADD COLUMN IF NOT EXISTS tokens_used INT DEFAULT 0;

CREATE TABLE IF NOT EXISTS ai_error_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    error_message TEXT NOT NULL,
    error_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE ai_logs 
ADD COLUMN IF NOT EXISTS execution_time FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS user_agent TEXT DEFAULT NULL;

CREATE TABLE IF NOT EXISTS ai_cache (
    id INT AUTO_INCREMENT PRIMARY KEY,
    query TEXT UNIQUE NOT NULL,
    response TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
