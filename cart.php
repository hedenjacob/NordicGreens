<?php
session_start();

// Opret forbindelse til databasen
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shoppingcart";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Forbindelse mislykkedes: " . $conn->connect_error);
}

// Håndter fjernelse og opdatering af produkter i kurven
if (isset($_POST['update_cart'])) {
    $cartId = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    if ($quantity <= 0) {
        // Fjern produkt fra kurven, hvis antallet er nul eller negativt
        $sql = "DELETE FROM cart WHERE id = '$cartId'";
    } else {
        // Opdater antallet af produktet i kurven
        $sql = "UPDATE cart SET quantity = $quantity WHERE id = '$cartId'";
    }

    if ($conn->query($sql) === TRUE) {
        // Kurven er blevet opdateret
        header("Location: cart.php"); // Genindlæs indkøbskurv-siden
        exit();
    } else {
        echo "Fejl under opdatering af kurven: " . $conn->error;
    }
} elseif (isset($_POST['remove_cart'])) {
    $cartId = $_POST['cart_id'];

    // Fjern produktet fra kurven
    $sql = "DELETE FROM cart WHERE id = '$cartId'";

    if ($conn->query($sql) === TRUE) {
        // Produktet er blevet fjernet fra kurven
        header("Location: cart.php"); // Genindlæs indkøbskurv-siden
        exit();
    } else {
        echo "Fejl under fjernelse af produktet fra kurven: " . $conn->error;
    }
}

// Hent produkter i kurven fra databasen
$sql = "SELECT cart.*, products.name, products.price, products.img
        FROM cart
        INNER JOIN products ON cart.id = products.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Indkøbskurv</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="cart.css">
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
    <h1>Indkøbskurv</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="cart-item">';
            echo '<img src="images/' . $row['img'] . '" alt="' . $row['name'] . '">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p>Antal: ' . $row['quantity'] . '</p>';
            echo '<p>Pris: ' . $row['price'] . ' DKK</p>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="cart_id" value="' . $row['id'] . '">';
            echo '<input type="number" name="quantity" value="' . $row['quantity'] . '" min="1">';
            echo '<button type="submit" name="update_cart">Opdater</button>';
            echo '<button type="submit" name="remove_cart">Fjern</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "Indkøbskurven er tom.";
    }

    $conn->close();
    ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
