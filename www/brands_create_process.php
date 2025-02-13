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
 
//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}
require 'database.php';
 
$name = $_POST['name'];
 
 
 
$sql = "INSERT INTO brands (brand_name) VALUES ('$name')";
$result = mysqli_query($conn, $sql);
 
if ($result) {
   echo "Het is gelukt!";
}else {
    echo "Het is niet gelukt!";
}