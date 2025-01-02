<?php
// Database configuration
$host = 'localhost';
$dbName = 'bhavya_demo';
$username = 'root';
$password = ''; // Add your password if required

try {
    // Create a new PDO instance for the database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    // Set PDO error mode to exception for better debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Print a success message
    // echo "Database connection successful!";
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>