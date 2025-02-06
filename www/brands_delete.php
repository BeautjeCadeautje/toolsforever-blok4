<?php


if ($_SERVER["REQUEST_METHOD"] != "GET") {
    echo "WTFFF";
    exit;
}

if (isset($_GET['id'])) {

    require 'database.php';
    $id = $_GET["id"];

    $sql = "DELETE FROM brands WHERE brand_id = $id";

    mysqli_query($conn, $sql);

    header("location: brands_index.php");
}
