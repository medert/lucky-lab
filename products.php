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
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $database = "CompanyDatabase";
      $port = "8888";

      $con=mysqli_connect($servername,$username,$password,$database,$port);

      // Check connection
      if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $result = mysqli_query($con,"SELECT * FROM Products");

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

      mysqli_close($con);

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
