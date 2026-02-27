🌍 Travel Planner – RESTful CRUD Web Application

A full-stack Travel Planner web application built using PHP, MySQL, HTML, CSS, and Vanilla JavaScript.
The system allows users to manage trip packages through a clean card-based interface with complete CRUD functionality.

🚀 Project Overview
This application allows users to:
✅ View trip packages
✅ Add new trips
✅ Edit existing trips
✅ Delete trips
✅ Filter by destination
✅ Sort by price and rating

The frontend communicates with a custom-built REST API using the Fetch API and JSON.
🏗️ Tech Stack
🎨 Frontend
HTML5
CSS3
JavaScript (Vanilla JS)
Fetch API
Async/Await

⚙️ Backend
PHP (Custom RESTful API)
MySQL
Prepared Statements

📡 API Architecture

This project implements a RESTful API using different HTTP methods:
Method	Operation	Description
GET	Read	Fetch trip packages
POST	Create	Add new trip
PUT	Update	Edit existing trip
DELETE	Delete	Remove trip
🔄 Important Update (PUT Method Enhancement)

Initially, the backend API supported:
GET
POST
DELETE
However, it did not support the PUT method, which is required for updating records in a RESTful system.

Enhancements Made:
Added a PUT handler in api.php
Read raw request data using:
file_get_contents("php://input");
Implemented database update using a prepared UPDATE statement
Configured CORS headers to allow PUT requests
Added OPTIONS preflight handling for browser compatibility

This enhancement made the system fully REST-compliant and enabled true update functionality.
📂 Project Structure
travel-planner-rest-api/
│
├── index.php        # Frontend UI + JavaScript logic
├── api.php          # REST API backend
├── config.php       # Database connection
├── schema.sql       # Database schema
├── seed.sql         # Sample data
└── README.md
🗄️ Database Setup
1️⃣ Create Database
CREATE DATABASE travel_planner;
USE travel_planner;
2️⃣ Create Table
CREATE TABLE trip_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    duration_days INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    rating DECIMAL(3,1) DEFAULT 0,
    highlights TEXT,
    image_url TEXT
);
🔁 Application Flow

User interacts with the UI

JavaScript sends HTTP request using fetch()

api.php processes the request

MySQL database performs the operation

JSON response is returned

Frontend dynamically updates the interface

🔐 Security Features

✅ Prepared statements (Prevents SQL Injection)

✅ Input sanitization using htmlspecialchars()

✅ CORS configuration

✅ ID validation before update/delete

✅ Structured error handling

▶️ How To Run
🖥️ Using XAMPP

Place project folder inside htdocs

Start Apache and MySQL

Visit:

http://localhost/travel-planner-rest-api/index.php
💻 Using PHP Built-in Server

Run:

php -S localhost:8000

Then visit:

http://localhost:8000/index.php
📚 Key Concepts Implemented

REST API Design

CRUD Operations

HTTP Methods

JSON Data Exchange

Async/Await

DOM Manipulation
Backend-Frontend Communication

Idempotent Methods (PUT)
CORS Handling

🎯 Learning Outcomes
• Through this project, the following were achieved:
• Built a full-stack web application
Implemented a RESTful API in PHP
Integrated MySQL database
Added PUT method for proper update functionality
Designed dynamic UI rendering without page reload
Applied secure database practices

👩‍💻 Developed By
team spark
Full Stack Developer (In Progress 🚀)
