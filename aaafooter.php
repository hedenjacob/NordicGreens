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
      $dbname = "shoppingcart";

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Forbindelse mislykkedes: " . $conn->connect_error);
      }

      // Hent kategorier fra databasen
      $sql_categories = "SELECT DISTINCT kategori FROM products";
      $result_categories = $conn->query($sql_categories);

      if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
          $category = $row['kategori'];
          echo '<li><a href="products.php?category=' . $category . '">' . $category . '</a></li>';
        }
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
