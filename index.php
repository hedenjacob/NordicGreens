<!DOCTYPE html>
<html>
<head>
    <title>Nordic Greens</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <header>
      <div class="logo">
        <img src="./assets/logo.png" alt="Nordic Greens Logo">
        <h1>Nordic Greens</h1>
      </div>
      <div class="login">
        <button>Login</button>
      </div>
    </header>

    <nav>
      <ul>
        <li><a href="products.php">Produkter</a></li>
        <li><a href="#">Kontakt</a></li>
        <li><a href="#">Om os</a></li>
      </ul>
    </nav>

    <div class="content">
      <section id="core-competencies">
        <h2>Vores kernekompetencer</h2>
        <p>Fyldetekst her...</p>
      </section>

      <section id="product-carousel">
        <h2>Produktkarusel</h2>
        <div class="carousel-container">
          <div class="carousel-track">
            <div class="carousel-item">
              <img src="./assets/cucumber.jpg" alt="Produkt 1">
              <p>Produkt 1 beskrivelse</p>
            </div>
            <div class="carousel-item">
              <img src="./assets/redp.jpg" alt="Produkt 2">
              <p>Produkt 2 beskrivelse</p>
            </div>
            <div class="carousel-item">
              <img src="./assets/tomato.jpg" alt="Produkt 3">
              <p>Produkt 3 beskrivelse</p>
            </div>
            <!-- Tilføj flere carousel-items efter behov -->
          </div>
        </div>
        <div class="carousel-controls">
          <button id="prev-btn">&lt;</button>
          <button id="next-btn">&gt;</button>
        </div>
      </section>

      <section id="product-recommendations">
  <h2>Produkt anbefalinger</h2>
  <div class="product-list">
    <?php
    // Opret forbindelse til databasen
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "shoppingcart";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Tjek forbindelsen
    if ($conn->connect_error) {
        die("Forbindelsen mislykkedes: " . $conn->connect_error);
    }

    // Hent kun tre produkter fra databasen
    $sql = "SELECT * FROM products LIMIT 3";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $img = $row['img'];
        $desc = $row['desc'];
        ?>
        <div class="product">
          <p><?php echo $name; ?></p>
          <img src="images/<?php echo $img; ?>" alt="Produkt">
          <p><?php echo $desc; ?></p>
        </div>
        <?php
      }
    } else {
      echo "Ingen produkter fundet.";
    }

    // Luk forbindelsen til databasen
    $conn->close();
    ?>
  </div>
  <div class="view-all-btn">
  <button class="view-all-button">Se alle produkter</button>
</div>
</section>
</div>
<script src="caro.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>