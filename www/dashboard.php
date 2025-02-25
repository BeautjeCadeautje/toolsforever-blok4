<?php
// Path: www/dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page, please login as administrator.";
    exit;
}

require 'header.php';
require 'database.php';

try {
    // Prepare and execute queries securely
    $queries = [
        'total_users' => "SELECT COUNT(id) AS total FROM users",
        'total_employees' => "SELECT COUNT(id) AS total FROM users WHERE role = 'employee'",
        'total_tools' => "SELECT COUNT(tool_id) AS total FROM tools"
    ];

    $results = [];

    foreach ($queries as $key => $query) {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results[$key] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
} catch (PDOException $e) {
    echo "Fout bij het ophalen van gegevens: " . $e->getMessage();
    exit;
}
?>

<main class="dashboard">
    <h1>Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Welkom <?php echo htmlspecialchars($_SESSION['firstname']); ?></h2>
                <p>Je bent ingelogd als <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-group">
                <h2>Totaal aantal gebruikers</h2>
                <p><?php echo $results['total_users']; ?></p>
            </div>
            <div class="card-group">
                <h2>Totaal aantal medewerkers</h2>
                <p><?php echo $results['total_employees']; ?></p>
            </div>
            <div class="card-group">
                <h2>Totaal aantal soorten gereedschap</h2>
                <p><?php echo $results['total_tools']; ?></p>
            </div>
        </div>
    </div>
</main>

<?php require 'footer.php'; ?>
