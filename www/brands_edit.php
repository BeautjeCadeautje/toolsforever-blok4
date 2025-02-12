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

$sql = "SELECT * FROM brands WHERE brand_id = $id";

$result = mysqli_query($conn, $sql);

$brand = mysqli_fetch_assoc($result);
// $tool = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tools WHERE tool_id = $id"));
require 'header.php';
?>

<main>
    <h1>wijzig Merk</h1>
    <div class="container">
        <form action="brands_edit_process.php" method="post">
            <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id'] ?>">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="brand_name" value="<?php echo $brand['brand_name'] ?>">
            </div>

            <button type="submit" class="btn btn-success">Wijzig</button>
        </form>
    </div>
</main>
<?php require 'footer.php' ?>