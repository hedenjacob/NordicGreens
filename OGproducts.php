<!DOCTYPE html>
<html>
<head>
    <title>Produkter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="products.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Hjem</a></li>
            <li><a href="products.php">Produkter</a></li>
            <li><a href="cart.php">Indkøbskurv</a></li>
        </ul>
    </nav>
</header>
<div class="container">
    <div class="sidebar">
        <h2>Kategorier</h2>
        <ul>
            <li><a href="#">Kategori 1</a></li>
            <li><a href="#">Kategori 2</a></li>
            <li><a href="#">Kategori 3</a></li>
            <li><a href="#">Kategori 4</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Produkt kategori</h1>
        <div class="products">
            <?php
            // Opret forbindelse til databasen
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "shoppingcart";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Forbindelse mislykkedes: " . $conn->connect_error);
            }

            // Hent produkter fra databasen
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Vis produkter
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<img src="images/' . $row['img'] . '" alt="' . $row['name'] . '">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p>' . $row['desc'] . '</p>';
                    echo '<p class="price">Pris: ' . $row['price'] . ' DKK</p>';
                    echo '<button class="add-to-cart">Føj til kurv</button>';
                    echo '</div>';
                }
            } else {
                echo "Ingen produkter fundet.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
