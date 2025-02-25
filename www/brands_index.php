<?php
session_start();
require 'database.php';

try {
    // Fetch all brands using PDO
    $sql = "SELECT * FROM brands";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

require 'header.php';
?>

<main>
    <div class="container">
        <h1>Brands</h1>
    </div>
    <div class="container">
        <?php foreach ($brands as $brand) : ?>
            <div class="brand-info">
                <img src="<?= isset($brand['brand_image']) ? 'images/' . htmlspecialchars($brand['brand_image']) : 'https://placehold.co/200' ?>" 
                     alt="<?= htmlspecialchars($brand['brand_name']) ?>">
                <h3><?= htmlspecialchars($brand['brand_name']) ?></h3>

                <a href="brands_edit.php?id=<?= $brand['brand_id'] ?>">Wijzig</a>
                <a href="brands_delete.php?id=<?= $brand['brand_id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this brand?')">Verwijder</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require 'footer.php'; ?>
