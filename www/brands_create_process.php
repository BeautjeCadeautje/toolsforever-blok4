<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

// Check method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

require 'database.php';

// Get the input safely
$name = $_POST['name'];

try {
    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO brands (brand_name) VALUES (:name)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':name', $name);

    // Execute the query
    if ($stmt->execute()) {
        echo "Het is gelukt!";
    } else {
        echo "Het is niet gelukt!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
