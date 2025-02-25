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
if ($_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

// Validate and sanitize input
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid user ID.";
    exit;
}

$id = intval($_GET['id']); // Ensure it's an integer

try {
    // Use a SELECT query with named placeholders
    $sql = "SELECT users.*, user_settings.backgroundColor, user_settings.font 
            FROM users 
            LEFT JOIN user_settings ON user_settings.user_id = users.id 
            WHERE users.id = :id";

    // Prepare the SQL query
    $stmt = $conn->prepare($sql);

    // Execute the query with parameters
    $stmt->execute([':id' => $id]);

    // Fetch the result
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        require 'header.php';
?>
        <main>
            <div class="container">
                <div class="user-detail">
                    <h3><?php echo htmlspecialchars($user['firstname']); ?></h3>
                    <p><?php echo htmlspecialchars($user['lastname']); ?></p>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                    <p><?php echo htmlspecialchars($user['role']); ?></p>
                    <p><?php echo htmlspecialchars($user['address']); ?></p>
                    <p><?php echo htmlspecialchars($user['city']); ?></p>
                    <p><?php echo $user['is_active'] == 1 ? "Is actief" : "Is niet actief"; ?></p>
                    <!-- <p><?php echo htmlspecialchars($user['backgroundColor']); ?></p>
                    <p><?php echo htmlspecialchars($user['font']); ?></p> -->
                </div>
            </div>
        </main>
<?php
        require 'footer.php';
    } else {
        echo "Geen gebruiker gevonden.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the connection (optional in PDO, but good practice)
?>