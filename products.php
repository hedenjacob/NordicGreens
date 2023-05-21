<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Produkter</title>
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

  <div class="content">
    <aside class="sidebar">
      <h2>Kategorier</h2>
      <ul>
        <?php
          // Opret forbindelse til databasen
          $conn = mysqli_connect('localhost', 'root', 'root', 'database_navn');

          // Tjek om forbindelsen er etableret
          if (!$conn) {
            die("Forbindelse til databasen mislykkedes: " . mysqli_connect_error());
          }

          // Hent kategorier fra databasen
          $query = "SELECT * FROM kategorier";
          $result = mysqli_query($conn, $query);

          // Tjek om der er resultater
          if (mysqli_num_rows($result) > 0) {
            // Loop gennem resultaterne og vis kategorierne
            while ($row = mysqli_fetch_assoc($result)) {
              $kategori_id = $row['id'];
              $kategori_navn = $row['navn'];

              // Opret en link til hver kategori
              echo '<li><a href="products.php?kategori=' . $kategori_id . '">' . $kategori_navn . '</a></li>';
            }
          } else {
            echo "Ingen kategorier fundet.";
          }

          // Luk forbindelsen til databasen
          mysqli_close($conn);
        ?>
      </ul>
    </aside>

    <div class="main-content">
      <h1>Produkt kategori</h1>

      <?php
        // Opret forbindelse til databasen
        $conn = mysqli_connect('database_host', 'brugernavn', 'adgangskode', 'database_navn');

        // Tjek om forbindelsen er etableret
        if (!$conn) {
          die("Forbindelse til databasen mislykkedes: " . mysqli_connect_error());
        }

        // Tjek om en bestemt kategori er valgt
        if (isset($_GET['kategori'])) {
          $valgt_kategori = $_GET['kategori'];

          // Hent produkter fra den valgte kategori
          $query = "SELECT * FROM produkter WHERE kategori_id = $valgt_kategori";
        } else {
          // Hvis ingen kategori er valgt, hent alle produkter
          $query = "SELECT * FROM produkter";
        }

        // Udfør forespørgslen
        $result = mysqli_query($conn, $query);

        // Tjek om der er resultater
        if (mysqli_num_rows($result) > 0) {
          // Loop gennem resultaterne og vis produkterne
          while ($row = mysqli_fetch_assoc($result)) {
            $produkt_navn = $row['navn'];
            $produkt_beskrivelse = $row['beskrivelse'];
            $produkt_pris = $row['pris'];
            $produkt_billede = $row['billede'];

            echo '<div class="produkt-række">';
            echo '<img src="path/til/billeder/' . $produkt_billede . '" alt="' . $produkt_navn . '">';
            echo '<h3>' . $produkt_navn . '</h3>';
            echo '<p>' . $produkt_beskrivelse . '</p>';
            echo '<p class="price">' . $produkt_pris . ' DKK</p>';
            echo '<button class="køb-knap">Føj til kurv</button>';
            echo '</div>';
          }
        } else {
          echo "Ingen produkter fundet.";
        }

        // Luk forbindelsen til databasen
        mysqli_close($conn);
      ?>
    </div>
  </div>

  <footer>
    <?php include 'footer.php'; ?>
  </footer>
</body>

</html>
