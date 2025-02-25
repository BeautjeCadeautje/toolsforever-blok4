<?php

if (!isset($_POST['id'], $_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['role'])) {
    echo 'All fields are required.';
    exit;
}

// Sanitize and validate inputs
$id = intval($_POST['id']);  // Ensure it's an integer
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Securely hash the password
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$address = htmlspecialchars($_POST['address']);
$city = htmlspecialchars($_POST['city']);
$role = htmlspecialchars($_POST['role']);

require 'database.php';

try {
    // Update query using named placeholders
    $sql = "UPDATE users 
            SET email = :email, 
                password = :password, 
                firstname = :firstname, 
                lastname = :lastname, 
                address = :address, 
                city = :city, 
                role = :role
            WHERE id = :id";

    // Prepare the SQL query
    $stmt = $conn->prepare($sql);

    // Execute the query with parameters
    $stmt->execute([
        ':email' => $email,
        ':password' => $password,
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':address' => $address,
        ':city' => $city,
        ':role' => $role,
        ':id' => $id,
    ]);

    echo "User updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the connection (optional in PDO, but good practice)
?>
