<?php

// Database connection parameters
$dbhost = "mariadb";
$dbuser = "root";
$dbpass = "password";
$dbname = "tools4ever";

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);

    // Set PDO to throw exceptions in case of an error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully"; // Optional: Remove this in production
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
