<?php
session_start();
require 'database.php';

if (isset($_SESSION['voornaam']) && isset($_SESSION['achternaam'])) {
    echo htmlspecialchars($_SESSION['voornaam'] . " " . $_SESSION['achternaam']);
}

$time = time();
echo date('d-m-Y H:i:s', $time);

// Initialize an empty array for tools
$tools = [];

if (isset($_GET['search_submit']) && !empty($_GET['search'])) {
    $zoekterm = "%" . $_GET['search'] . "%"; // Wildcard search

    try {
        $stmt = $conn->prepare("SELECT * FROM tools WHERE tool_name LIKE :zoekterm");
        $stmt->bindParam(':zoekterm', $zoekterm, PDO::PARAM_STR);
        $stmt->execute();
        $tools = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Fout bij zoeken: " . $e->getMessage();
    }
}

// Get the total count of tools
try {
    $stmt = $conn->query("SELECT COUNT(*) AS aantal FROM tools");
    $resultaat_array = $stmt->fetch(PDO::FETCH_ASSOC);
    $aantal = $resultaat_array['aantal'];
} catch (PDOException $e) {
    echo "Fout bij ophalen van aantal tools: " . $e->getMessage();
}

echo $aantal;
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gevonden tools</title>
</head>

<body>
    <div class="container">
        <form action="" method="get">
            <input type="text" name="search" id="search" placeholder="Zoek naar gereedschap">
            <button type="submit" name="search_submit">Zoek</button>
        </form>
    </div>
    <div class="container">
        <h1>Resultaten</h1>
        <?php if (!empty($tools)) : ?>
            <ul>
                <?php foreach ($tools as $tool) : ?>
                    <li>
                        <strong><?php echo htmlspecialchars($tool['tool_name']); ?></strong> - 
                        €<?php echo number_format($tool['tool_price'] / 100, 2, ',', ''); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Geen resultaten gevonden.</p>
        <?php endif; ?>
    </div>
</body>

</html>
