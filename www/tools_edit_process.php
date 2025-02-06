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

$sql = "UPDATE tools SET
tool_name = '$tool_name',
tool_brand = '$tool_brand',
tool_category = '$tool_category',
tool_price = '$tool_price',
tool_image = '$tool_image'
WHERE tool_id = $tool_id";

mysqli_query($conn, $sql);
