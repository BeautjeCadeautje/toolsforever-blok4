<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method.";
    exit;
}

// Validate input
if (!isset($_POST['brand_id']) || empty($_POST['brand_id'])) {
    echo 'Geen brand ID.';
    exit;
}

if (!isset($_POST['brand_name']) || empty($_POST['brand_name'])) {
    echo 'Geen brand naam.';
    exit;
}

require 'database.php';

try {
    $brand_id = $_POST['brand_id'];
    $brand_name = $_POST['brand_name'];

    // Prepare and execute the update query using PDO
    $sql = "UPDATE brands SET brand_name = :brand_name WHERE brand_id = :brand_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':brand_name', $brand_name, PDO::PARAM_STR);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: brands_index.php");
        exit;
    } else {
        echo "Bijwerken mislukt!";
    }
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
    exit;
}
?>
