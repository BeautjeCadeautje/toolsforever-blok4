<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

require 'database.php';
require 'header.php';

try {
    // Fetch brands from the database
    $sql = "SELECT brand_id, brand_name FROM brands";
    $stmt = $conn->query($sql);
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<main>
    <h1>Nieuw Gereedschap</h1>
    <div class="container">
        <form action="tools_create_process.php" method="post">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="category">Categorie:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div>
                <label for="price">Prijs:</label>
                <input type="number" id="price" name="price" required step="0.01">
            </div>
            <div>
                <label for="brand">Merk:</label>
                <select id="brand" name="brand" required>
                    <option value="">Selecteer een merk</option>
                    <?php foreach ($brands as $brand) : ?>
                        <option value="<?= $brand['brand_id']; ?>"><?= htmlspecialchars($brand['brand_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="image">Afbeelding URL:</label>
                <input type="text" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-success">Toevoegen</button>
        </form>
    </div>
</main>

<?php require 'footer.php'; ?>
