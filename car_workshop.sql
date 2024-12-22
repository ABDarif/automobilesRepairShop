-- Create database
CREATE DATABASE IF NOT EXISTS car_workshop;
USE car_workshop;

-- Create Mechanics table
CREATE TABLE IF NOT EXISTS mechanics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    max_appointments INT DEFAULT 4,
    current_appointments INT DEFAULT 0
);

-- Create Clients table
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    car_license VARCHAR(50) NOT NULL UNIQUE,
    car_engine VARCHAR(50) NOT NULL UNIQUE,
    appointment_date DATE NOT NULL,
    mechanic_id INT NOT NULL,
    FOREIGN KEY (mechanic_id) REFERENCES mechanics(id) ON DELETE CASCADE
);

-- Insert Sample Mechanics
INSERT INTO mechanics (name, max_appointments, current_appointments) VALUES
('John Doe', 4, 0),
('Jane Smith', 4, 0),
('Mike Brown', 4, 0),
('Emily Davis', 4, 0),
('Chris Wilson', 4, 0);