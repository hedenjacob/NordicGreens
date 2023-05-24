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

    // Hent kategorier fra databasen
    $sql_categories = "SELECT DISTINCT kategori FROM products";
    $result_categories = $conn->query($sql_categories);

    $categories = array(); // Opret et array til at gemme kategorierne

    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row['kategori']; // Tilføj hver kategori til arrayet
        }
    }

    // Hent produkter fra databasen
    $sql = "SELECT * FROM products";

    // Check om en kategori er valgt
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $sql .= " WHERE kategori = '$category'";
    }

    $result = $conn->query($sql);
    ?>
    <div class="sidebar">
        <h2>Kategorier</h2>
        <ul>
            <li><a href="products.php">Alle produkter</a></li>
            <?php
            foreach ($categories as $category) {
                echo '<li><a href="?category=' . $category . '">' . $category . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="content">
        <h1>Produkt kategori</h1>
        <div class="products">
            <?php
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
