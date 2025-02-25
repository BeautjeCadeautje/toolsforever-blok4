<?php
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo "Invalid request method.";
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No brand ID provided.";
    exit;
}

require 'database.php';

try {
    $id = $_GET['id'];

    // Prepare and execute DELETE query using PDO
    $sql = "DELETE FROM brands WHERE brand_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: brands_index.php");
        exit;
    } else {
        echo "Failed to delete brand.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
