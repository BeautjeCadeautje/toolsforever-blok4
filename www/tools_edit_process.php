<?php

if (!isset($_POST['tool_id'])) {
    echo 'geen tool id';
    exit;
}
if (!isset($_POST['tool_name'])) {
    echo 'geen tool name';
    exit;
}
if (!isset($_POST['tool_brand'])) {
    echo 'geen tool brand';
    exit;
}
if (!isset($_POST['tool_category'])) {
    echo 'geen tool category';
    exit;
}
if (!isset($_POST['tool_price'])) {
    echo 'geen tool price';
    exit;
}
if (!isset($_POST['tool_image'])) {
    echo 'geen tool image';
    exit;
}

$tool_id = $_POST['tool_id'];
$tool_name = $_POST['tool_name'];
$tool_brand = $_POST['tool_brand'];
$tool_category = $_POST['tool_category'];
$tool_price = $_POST['tool_price'];
$tool_image = $_POST['tool_image'];

require 'database.php';

try {
    // Prepare the update query
    $sql = "UPDATE tools SET
            tool_name = :tool_name,
            tool_brand = :tool_brand,
            tool_category = :tool_category,
            tool_price = :tool_price,
            tool_image = :tool_image
            WHERE tool_id = :tool_id";

    $stmt = $conn->prepare($sql);

    // Bind parameters to the query
    $stmt->bindParam(':tool_name', $tool_name, PDO::PARAM_STR);
    $stmt->bindParam(':tool_brand', $tool_brand, PDO::PARAM_INT); // Assuming brand is an integer
    $stmt->bindParam(':tool_category', $tool_category, PDO::PARAM_STR);
    $stmt->bindParam(':tool_price', $tool_price, PDO::PARAM_STR); // Assuming price is a string
    $stmt->bindParam(':tool_image', $tool_image, PDO::PARAM_STR);
    $stmt->bindParam(':tool_id', $tool_id, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

 
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
