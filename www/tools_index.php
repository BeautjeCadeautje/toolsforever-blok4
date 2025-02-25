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

require 'database.php'; // This now contains the PDO connection `$conn`

// Prepare and execute the SQL query using PDO
$sql = "SELECT tools.tool_id, tools.tool_name, tools.tool_category, tools.tool_price, 
               COALESCE(brands.brand_name, 'Onbekend') AS brand_name 
        FROM tools 
        LEFT JOIN brands ON tools.tool_brand = brands.brand_id";

$stmt = $conn->query($sql); // PDO query execution
$tools = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as an associative array

require 'header.php';
?>

<main>
    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Merk</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($tool['tool_name']); ?></td>
                    <td><?php echo htmlspecialchars($tool['tool_category']); ?></td>
                    <td><?php echo htmlspecialchars($tool['tool_price']); ?></td>
                    <td><?php echo htmlspecialchars($tool['brand_name']); ?></td>
                    <td>
                        <a href="tools_detail.php?id=<?php echo $tool['tool_id']; ?>">Bekijk</a>
                        <a href="tools_edit.php?id=<?php echo $tool['tool_id']; ?>">Wijzig</a>
                        <a href="tools_delete.php?id=<?php echo $tool['tool_id']; ?>"
                            onclick="return confirm('Are you sure?')">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require 'footer.php'; ?>
