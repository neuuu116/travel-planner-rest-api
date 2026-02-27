-- Trip Packages Database Schema
-- Run this in phpMyAdmin or MySQL CLI to create the database and table

-- Create database
CREATE DATABASE IF NOT EXISTS travel_planner;

USE travel_planner;

-- Create trip_packages table
CREATE TABLE IF NOT EXISTS trip_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    duration_days INT DEFAULT 3,
    price DECIMAL(10,2) NOT NULL,
    highlights JSON NOT NULL,
    image_url VARCHAR(500) DEFAULT '',
    rating DECIMAL(2,1) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);