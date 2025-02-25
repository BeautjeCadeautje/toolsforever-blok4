<?php
session_start();

require 'database.php';

if (isset($_GET['id'])) {
    $tool_id = $_GET['id'];

    try {
        // Fetch tool details along with brand name
        $sql = "SELECT tools.tool_id, tools.tool_name, tools.tool_category, tools.tool_price, tools.tool_image, 
                       COALESCE(brands.brand_name, 'Onbekend') AS brand_name 
                FROM tools 
                LEFT JOIN brands ON tools.tool_brand = brands.brand_id 
                WHERE tools.tool_id = :tool_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tool_id', $tool_id, PDO::PARAM_INT);
        $stmt->execute();

        $tool = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

require 'header.php';
?>

<main>
    <div class="container">
        <?php if (isset($tool)) : ?>
            <div class="product-detail">
                <div class="row">
                    <div class="col">
                        <img src="<?php echo isset($tool['tool_image']) ? 'images/' . $tool['tool_image'] : 'https://placehold.co/200' ?>"
                             alt="<?php echo htmlspecialchars($tool['tool_name']); ?>">
                    </div>
                    <div class="col">
                        <h3><?php echo htmlspecialchars($tool['tool_name']); ?></h3>
                        <p><strong>Merk:</strong> <?php echo htmlspecialchars($tool['brand_name']); ?></p>
                        <p><strong>Categorie:</strong> <?php echo htmlspecialchars($tool['tool_category']); ?></p>
                        <p><strong>Prijs:</strong> € <?php echo number_format($tool['tool_price'] / 100, 2, ',', ''); ?></p>
                        <p>
                            <a href="add_to_cart.php?id=<?php echo $tool['tool_id']; ?>" class="btn">Bestel</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Tool not found.</p>
        <?php endif; ?>
    </div>
</main>

<?php require 'footer.php'; ?>
