<?php
session_start();
require 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

// Check if user is an administrator
if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin.";
    exit;
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page.";
    exit;
}

// Check if all required fields are filled
$required_fields = ['firstname', 'lastname', 'email', 'role', 'address', 'city', 'backgroundColor', 'font'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "Please fill in all fields.";
        exit;
    }
}

// Sanitize inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password securely
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$role = htmlspecialchars($_POST['role']);
$address = htmlspecialchars($_POST['address']);
$city = htmlspecialchars($_POST['city']);
$is_active = 1;
$backgroundColor = htmlspecialchars($_POST['backgroundColor']);
$font = htmlspecialchars($_POST['font']);

try {
    $conn->beginTransaction();

    // Insert user into `users` table
    $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, role, address, city, is_active) 
                            VALUES (:email, :password, :firstname, :lastname, :role, :address, :city, :is_active)");
    $stmt->execute([
        ':email' => $email,
        ':password' => $password,
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':role' => $role,
        ':address' => $address,
        ':city' => $city,
        ':is_active' => $is_active
    ]);

    // Get the last inserted user ID
    $user_id = $conn->lastInsertId();

    // Insert user settings into `user_settings` table
    $stmt = $conn->prepare("INSERT INTO user_settings (user_id, backgroundColor, font) 
                            VALUES (:user_id, :backgroundColor, :font)");
    $stmt->execute([
        ':user_id' => $user_id,
        ':backgroundColor' => $backgroundColor,
        ':font' => $font
    ]);

    // Commit transaction
    $conn->commit();

    // Redirect to users index page
    header("Location: users_index.php");
    exit;
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Something went wrong: " . $e->getMessage();
}
?>
