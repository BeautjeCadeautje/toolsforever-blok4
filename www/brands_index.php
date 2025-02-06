<?php
session_start();
require 'database.php';

$sql = "SELECT * FROM brands";
$result = mysqli_query($conn, $sql);
$brands = mysqli_fetch_all($result, MYSQLI_ASSOC);


require 'header.php';
?>

<main>
    <div class="container">
        <h1>Brands</h1>
    </div>
    <div class="container">
        <?php foreach ($brands as $brand) : ?>
            <div class="brand-info">
                <img src="<?php echo isset($brand['brand_image']) ? 'images/' . $brand['brand_image'] : 'https://placehold.co/200' ?>" alt="<?php echo $brand['brand_name'] ?>">
                <h3><?php echo $brand['brand_name'] ?></h3>


                <a href="brands_delete.php?id=<?php echo $brand['brand_id'] ?>"
                    onclick="return confirm('you sure bitch?')">Verwijder</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require 'footer.php' ?>