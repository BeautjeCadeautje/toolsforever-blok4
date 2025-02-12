<?php

if (!isset($_POST['id'])) {
    echo 'geen user id';
    exit;
}
if (!isset($_POST['email'])) {
    echo 'geen email';
    exit;
}
if (!isset($_POST['password'])) {
    echo 'geen password';
    exit;
}
if (!isset($_POST['firstname'])) {
    echo 'geen firstname';
    exit;
}
if (!isset($_POST['lastname'])) {
    echo 'geen lastname';
    exit;
}
if (!isset($_POST['address'])) {
    echo 'geen address';
    exit;
}
if (!isset($_POST['city'])) {
    echo 'geen city';
    exit;
}

if (!isset($_POST['role'])) {
    echo 'geen role';
    exit;
}



$id = $_POST['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$city = $_POST['city'];

$role = $_POST['role'];


require 'database.php';

$sql = "UPDATE users SET
email = '$email',
password = '$password',
firstname = '$firstname',
lastname = '$lastname',
address = '$address',
city = '$city',

role = '$role'
WHERE id = $id";

mysqli_query($conn, $sql);
