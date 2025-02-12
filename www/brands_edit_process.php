<?php

if (!isset($_POST['brand_id'])) {
    echo 'geen brand id';
    exit;
}
if (!isset($_POST['brand_name'])) {
    echo 'geen brand name';
    exit;
}




$brand_id = $_POST['brand_id'];
$brand_name = $_POST['brand_name'];



require 'database.php';

$sql = "UPDATE brands SET
brand_name = '$brand_name'
WHERE brand_id = $brand_id";

mysqli_query($conn, $sql);
