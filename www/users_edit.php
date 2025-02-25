<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

// Check if the user is an administrator
if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

require 'database.php';

// Check if 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "ID is a required parameter, ID not found.";
    exit;
}

$id = $_GET['id'];

try {
    // Prepare the SQL query to fetch user details based on ID
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Execute the query with the ID parameter
    $stmt->execute([':id' => $id]);

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists
    if (!$user) {
        echo "User not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

require 'header.php';
?>

<main>
    <h1>Wijzig User</h1>
    <div class="container">
        <form action="users_edit_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <div>
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>

            <div>
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div>
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password (leave empty to keep existing)">
            </div>

            <div>
                <label for="address">Adres:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>

            <div>
                <label for="city">Stad:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
            </div>

            <div>
                <label for="role">Rol:</label>
                <select id="role" name="role" required>
                    <option value="<?php echo htmlspecialchars($user['role']); ?>"><?php echo htmlspecialchars($user['role']); ?></option>
                    <option value="administrator">Administrator</option>
                    <option value="employee">Werknemer</option>
                </select>
            </div>

            <input type="submit" value="Edit User">
        </form>
    </div>
</main>

<?php require 'footer.php'; ?>