<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page, please login as admin.";
    exit;
}

require 'database.php';

// Validate brand ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID is een verplichte parameter/id is niet gevonden.";
    exit;
}

$id = $_GET['id'];

try {
    // Prepare and execute the query using PDO
    $sql = "SELECT * FROM brands WHERE brand_id = :brand_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':brand_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$brand) {
        echo "Merk niet gevonden.";
        exit;
    }
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
    exit;
}

require 'header.php';
?>

<main>
    <h1>Wijzig Merk</h1>
    <div class="container">
        <form action="brands_edit_process.php" method="post">
            <input type="hidden" name="brand_id" value="<?php echo htmlspecialchars($brand['brand_id']); ?>">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="brand_name" value="<?php echo htmlspecialchars($brand['brand_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Wijzig</button>
        </form>
    </div>
</main>

<?php require 'footer.php'; ?>
