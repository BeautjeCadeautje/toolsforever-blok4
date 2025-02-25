<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

require 'database.php';

// Get input values safely
$tool_id = $_POST['tool_id'];
$name = $_POST['tool_name'];
$category = $_POST['tool_category'];
$price = $_POST['tool_price'];
$brand = $_POST['tool_brand'];
$image = $_POST['tool_image'];

try {
    // Prepare the SQL statement using PDO
    $sql = "UPDATE tools 
            SET tool_name = :name, 
                tool_category = :category, 
                tool_price = :price, 
                tool_brand = :brand, 
                tool_image = :image 
            WHERE tool_id = :tool_id";

    $stmt = $conn->prepare($sql);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':brand', $brand);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':tool_id', $tool_id);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: tools_index.php");
        exit;
    } else {
        echo "Something went wrong";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
