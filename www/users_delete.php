<?php
session_start();
require 'database.php';

// Check if request method is GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo "Invalid request method.";
    exit;
}

// Check if 'id' is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "User ID is missing.";
    exit;
}

$id = intval($_GET['id']); // Convert to integer for safety

try {
    // Delete query using named placeholders
    $sql = "DELETE FROM users WHERE id = :id";

    // Prepare the SQL query
    $stmt = $conn->prepare($sql);

    // Execute the query with parameters
    $stmt->execute([':id' => $id]);


    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the connection (optional in PDO, but good practice)
