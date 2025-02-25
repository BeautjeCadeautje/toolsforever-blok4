<?php

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    echo "WTFFF";
    exit;
}

if (isset($_GET['id'])) {

    require 'database.php';
    $id = $_GET["id"];

    try {
        // Prepare and execute the delete statement
        $sql = "DELETE FROM tools WHERE tool_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();


        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
