<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <meta name="keywords" content="dog, training">
    <meta name="description" content=" ">
    <meta name="author" content="Mederbek Toktosunov">
    <title>Products</title>
    <link rel="stylesheet" href="./css/mystyle.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
  </head>
  <body>
  <header>
    <div class="container">
      <div id="branding">
        <img src="./img/Lucky.png">
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li class="current"><a href="products.php">Products</a></li>
          <li><a href="orders.php">Orders</a></li>
        </ul>
      </nav>
    </div>
  </header>
    <h1 id="page-title" align="center">Our Products</h1>
    <div align="center">
      <?php
      // require __DIR__."/vendor/autoload.php";
      //
      // $Loader = new josegonzalez\Dotenv\Loader(__DIR__."/.env");
      // // Parse the .env file
      // $Loader->parse();
      // //Send the parced .env file to the $_ENV variable
      // $Loader->toEnv();
      //
      // $servername = $_ENV['MYSQL_ADDRESS'];
      // $database = $_ENV['MYSQL_DB'];
      // $username = $_ENV['MYSQL_USER'];
      // $password = $_ENV['MYSQL_PASSWORD'];
      // $port = $_ENV['MYSQL_PORT'];

      $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

      $server = $url["host"];
      $username = $url["user"];
      $password = $url["pass"];
      $db = substr($url["path"], 1);

      $conn = new mysqli($server, $username, $password, $db);


      // Check connection
      if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $result = mysqli_query($conn,"SELECT * FROM Products");

      echo "<table border='1'>
      <tr>
      <th>Product</th>
      <th>Description</th>
      <th>Colors</th>
      <th>Stock</th>
      <th>Price</th>
      </tr>";

      while($row = mysqli_fetch_array($result))
      {
      echo "<tr>";
      echo "<td>" . $row['ProductName'] . "</td>";
      echo "<td>" . $row['Description'] . "</td>";
      echo "<td>" . $row['ColorsAvaliable'] . "</td>";
      echo "<td><center>" . $row['QtyInStock'] . "</center></td>";
      echo "<td>$" . $row['Price'] . "</td>";
      echo "</tr>";
      }
      echo "</table>";

      mysqli_close($conn);

  ?>
</div>
    <section id="showcase2">

      <!-- <img src="./img/puppies2.jpg" /> -->
    </section>
    <footer>
      <p>Designed by Mederbek Toktosunov &copy; 2017</p>
    </footer>
  </body>
  </html>
