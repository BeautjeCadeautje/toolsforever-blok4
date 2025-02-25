<?php
session_start();
require 'database.php';

try {
    // Fetch all tools
    $sql = "SELECT * FROM tools";
    $stmt = $conn->query($sql);
    $tools = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

require 'header.php';
?>

<main>
    <div class="container">

        <!-- Show products here -->
        <?php foreach ($tools as $tool) : ?>
            <div class="product">
                <img src="<?php echo isset($tool['tool_image']) ? 'images/' . $tool['tool_image'] : 'https://placehold.co/200' ?>" alt="<?php echo htmlspecialchars($tool['tool_name']); ?>">
                <h3><?php echo htmlspecialchars($tool['tool_name']); ?></h3>
                <p>€ <?php echo number_format($tool['tool_price'] / 100, 2, ',', ''); ?></p>
                <a href="tools_detail.php?id=<?php echo $tool['tool_id']; ?>">Bekijk</a>
            </div>
        <?php endforeach; ?>

    </div>

</main>

<?php require 'footer.php'; ?>