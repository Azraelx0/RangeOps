# This file is a vulnerable connection method for our sql database used in the sql injection lab

<?php
# Change these config variables as needed
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'vuln_db';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function setup_database() {
    global $conn;
    
    $create_db = "CREATE DATABASE IF NOT EXISTS vuln_db";
    mysqli_query($conn, $create_db);
    mysqli_select_db($conn, 'vuln_db');
    
    $create_users = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $create_users);
    
    $create_products = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2),
        category VARCHAR(50)
    )";
    mysqli_query($conn, $create_products);
    
    $check_users = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $row = mysqli_fetch_assoc($check_users);

    # add users/products as needed
    if ($row['count'] == 0) {
        mysqli_query($conn, "INSERT INTO users (username, password, email, role) VALUES 
            ('admin', 'admin123', 'admin@example.com', 'admin'),
            ('john', 'password', 'john@example.com', 'user'),
            ('jane', 'password123', 'jane@example.com', 'user')
            ('mike', 'testpass321', 'mike@example.com', 'user')");
        mysqli_query($conn, "INSERT INTO products (name, description, price, category) VALUES 
            ('Laptop', 'High-performance laptop', 999.99, 'Electronics'),
            ('Mouse', 'Wireless mouse', 29.99, 'Electronics'),
            ('Keyboard', 'Mechanical keyboard', 89.99, 'Electronics'),
            ('Monitor', '27-inch 4K monitor', 399.99, 'Electronics'),
            ('Headphones', 'Noise-cancelling headphones', 199.99, 'Electronics')");
    }
}

?>
