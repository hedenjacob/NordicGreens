-- Opret kategorier tabel
CREATE TABLE categories (
  id INT PRIMARY KEY,
  name VARCHAR(255)
);

-- Indsæt kategorier
INSERT INTO categories (id, name) VALUES
(1, 'Tomat'),
(2, 'Agurk'),
(3, 'Rød peber'),
(4, 'Salat');

-- Opret produkter tabel
CREATE TABLE products (
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  description TEXT,
  price DECIMAL(10, 2),
  category_id INT,
  image VARCHAR(255),
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Indsæt produkter
INSERT INTO products (id, name, description, price, category_id, image) VALUES
(1, 'Produkt 1', 'Beskrivelse af produkt 1', 10.99, 1, 'produkt1.jpg'),
(2, 'Produkt 2', 'Beskrivelse af produkt 2', 8.99, 2, 'produkt2.jpg'),
(3, 'Produkt 3', 'Beskrivelse af produkt 3', 12.99, 3, 'produkt3.jpg'),
(4, 'Produkt 4', 'Beskrivelse af produkt 4', 9.99, 1, 'produkt4.jpg'),
(5, 'Produkt 5', 'Beskrivelse af produkt 5', 7.77, 1, 'produkt5.jpg'),
(6, 'Produkt 6', 'Beskrivelse af Produkt 6', 24.99, 2, 'produkt6.jpg'),
(7, 'Produkt 7', 'Beskrivelse af produkt 7', 30.00, 3, 'produkt7.jpg'),
(8, 'Produkt 8', 'Beskrivelse af produkt 8', 27.00, 2, 'produkt8.jpg');


Overstående ændring af datastruktur. 
Gør brug af overstående datastruktur. Fremfor den tidligere brugte. 



products.php
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
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Forbindelse mislykkedes: " . $conn->connect_error);
    }

    // Hent kategorier fra databasen
    $sql_categories = "SELECT * FROM categories";
    $result_categories = $conn->query($sql_categories);

    $categories = array(); // Opret et array til at gemme kategorierne

    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[$row['id']] = $row['name']; // Gem kategoriens navn med dens id som nøgle
        }
    }

    // Hent produkter fra databasen
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    ?>
    <div class="sidebar">
        <h2>Kategorier</h2>
        <ul>
            <li><a href="products.php">Alle produkter</a></li>
            <?php
            foreach ($categories as $id => $name) {
                echo '<li><a href="?category=' . $id . '">' . $name . '</a></li>';
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
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p>' . $row['description'] . '</p>';
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





footer.php:
<link rel="stylesheet" type="text/css" href="footer.css">

<footer>
    <div class="footer-left">
        <p class="company-name">Nordic Greens A/S.</p>
        <p class="copyright">&copy; 2023. Alle rettigheder forbeholdt.</p>
        <p class="privacy-terms">Privacy terms</p>
    </div>

    <div class="footer-middle">
        <p>Produkter</p>
        <ul>
            <?php
            // Opret forbindelse til databasen
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Forbindelse mislykkedes: " . $conn->connect_error);
            }

            // Hent kategorier fra databasen
            $sql_categories = "SELECT * FROM categories";
            $result_categories = $conn->query($sql_categories);

            $categories = array(); // Opret et array til at gemme kategorierne

            if ($result_categories->num_rows > 0) {
                while ($row = $result_categories->fetch_assoc()) {
                    $categories[$row['id']] = $row['name']; // Gem kategoriens navn med dens id som nøgle
                }
            }

            foreach ($categories as $id => $name) {
                echo '<li><a href="products.php?category=' . $id . '">' . $name . '</a></li>';
            }

            $conn->close();
            ?>
        </ul>
    </div>

    <div class="footer-middle">
        <p>Kontakt</p>
        <ul>
            <li><a href="#">Om os</a></li>
            <li><a href="#">Kontaktformular</a></li>
            <li><a href="#">Socials</a></li>
            <li><a href="#">FAQ</a></li>
        </ul>
    </div>

    <div class="footer-right">
        <p>Vilkår og sikkerhed</p>
        <ul>
            <li><a href="#">Cookiepolitik - ændr dit samtykke</a></li>
            <li><a href="#">Handelsbetingelser</a></li>
            <li><a href="#">Persondatapolitik</a></li>
            <li><a href="#">Tryghedsgaranti</a></li>
        </ul>
    </div>
</footer>
