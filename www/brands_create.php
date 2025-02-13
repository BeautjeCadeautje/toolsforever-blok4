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
require 'header.php';
?>

<main>
    <h1>Nieuw Merk</h1>
    <div class="container">
        <form action="brands_create_process.php" method="post">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name">
            </div>
            <button type="submit" class="btn btn-success">Toevoegen</button>
        </form>
    </div>
</main>
<?php require 'footer.php' ?>