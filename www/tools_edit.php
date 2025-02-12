<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

require 'database.php';

if (!isset($_GET['id'])) {
    echo "id is een verplichte parameter/id is niet gevonden";
    exit;
}

$id = $_GET['id'];

// Fetch tool details
$sql = "SELECT * FROM tools WHERE tool_id = $id";
$result = mysqli_query($conn, $sql);
$tool = mysqli_fetch_assoc($result);

// Fetch all brands
$sql_brands = "SELECT brand_id, brand_name FROM brands";
$result_brands = mysqli_query($conn, $sql_brands);

require 'header.php';
?>

<main>
    <h1>Wijzig Gereedschap</h1>
    <div class="container">
        <form action="tools_edit_process.php" method="post">
            <input type="hidden" name="tool_id" value="<?php echo $tool['tool_id'] ?>">

            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="tool_name" value="<?php echo htmlspecialchars($tool['tool_name']); ?>" required>
            </div>

            <div>
                <label for="category">Categorie:</label>
                <input type="text" id="category" name="tool_category" value="<?php echo htmlspecialchars($tool['tool_category']); ?>" required>
            </div>

            <div>
                <label for="price">Prijs:</label>
                <input type="number" id="price" name="tool_price" value="<?php echo htmlspecialchars($tool['tool_price']); ?>" required>
            </div>

            <div>
                <label for="brand">Merk:</label>
                <select id="brand" name="tool_brand" required>
                    <option value="">Selecteer een merk</option>
                    <?php while ($brand = mysqli_fetch_assoc($result_brands)) : ?>
                        <option value="<?php echo $brand['brand_id']; ?>"
                            <?php echo ($tool['tool_brand'] == $brand['brand_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="image">Afbeelding:</label>
                <input type="text" id="image" name="tool_image" value="<?php echo htmlspecialchars($tool['tool_image']); ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Wijzig</button>
        </form>
    </div>
</main>

<?php require 'footer.php'; ?>