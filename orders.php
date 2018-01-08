<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <meta name="keywords" content="dog, training">
    <meta name="description" content=" ">
    <meta name="author" content="Mederbek Toktosunov">
    <title>Orders</title>
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
            <li><a href="products.php">Products</a></li>
            <li class="current"><a href="orders.php">Orders</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <h1 id="page-title" align="center">Order Today</h1>
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

    $result = mysqli_query($conn,"SELECT * FROM Products");

    // Check connection
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    #array for the form with states
    $states = array(
    'AL','AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL',
    'IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE',
    'NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD',
    'TN','TX','UT','VT','VA','WA','WV','WI','WY');

    function displayRequired($fieldName) {
         echo "<center>The field \"$fieldName\" is required.<br /></center>\n";
    }
    function validateInput($data, $fieldName) {
         global $errorCount;
         if (empty($data)) {
              displayRequired($fieldName);
              ++$errorCount;
              $retval = "";
         } else { // Only clean up the input if it isn't empty
              $retval = trim($data);
              $retval = stripslashes($retval);
         }
         return($retval);
    }

    $DisplayForm = TRUE;

    if (isset($_POST['Submit'])) {
        $fName = validateInput($_POST['fName'],'First name');
        $lName = validateInput($_POST['lName'],'Last name');
        $Address = validateInput($_POST['Address'],'Address');;
        $City = validateInput($_POST['City'],'City');
        $State = validateInput($_POST['State'],'State');
        $Zip = validateInput($_POST['Zip'],'Zip');
        $Email = validateInput($_POST['Email'],'Email');
        $ProductID = validateInput($_POST['ProductID'],'ProductName');
        $Quantity = validateInput($_POST['Quantity'],'Quantity');
        $Color = validateInput($_POST['Color'],'Color');


        $row = mysqli_fetch_array($result);
        $Colors = $row['ColorsAvaliable'];
        $ColorArr = explode(",",$Colors);

        if (is_numeric($Zip) && is_numeric($Quantity)){
          if (     !empty($fName)
                && !empty($lName)
                && !empty($Address)
                && !empty($City)
                && !empty($State)
                && !empty($ProductID)
                && !empty($Color)
                && !empty($Quantity)) {

            if($row['QtyInStock'] < $Quantity){

              echo  "<center><bold>*Currently out of stock. " .
                    "Please, choose other product</bold></center><br>";
              $DisplayForm = TRUE;

            } else if (!in_array($Color,$ColorArr)){

              echo "<center><bold>*Sorry, this product does" .
              " not come in this color</bold></center><br>";
              $DisplayForm = TRUE;

            } else {
              $DisplayForm = FALSE;
            }
          } else {
            $DiplayForm = TRUE;
          }
        } else {
            if(is_numeric($Zip && !empty($Zip)))
              echo "<p><center>The field \"Zip\" has to be numeric</p>\n</center>";
            if(is_numeric($Quantity && !empty($Quantity)))
              echo "<p><center>The field \"Quantity\" has to be numeric</p>\n</center>";
              $DisplayForm = TRUE;
         }
    }

    if ($DisplayForm) {
    ?>

    <div id="form">
    <form name="Orders" action="orders.php" method="post">
       <p>
         <label>First name:</label>
         <input type="text" name="fName" size="30" value="<?php if (isset($_POST['Submit'])){echo $fName;} ?>"/><br /><br />
       </p>
       <p>
         <label>Last name:</label>
         <input type="text" name="lName" size="30" value="<?php if (isset($_POST['Submit'])){echo $lName;} ?>"/><br /><br />
      </p>
      <p>
       <label>Address:</label>
       <input type="text" name="Address" size="30" value="<?php if (isset($_POST['Submit'])){echo $Address;} ?>" /><br /><br />
       <label>City:</label>
       <input type="text" name="City" size="30" value="<?php if (isset($_POST['Submit'])){echo $City;} ?>"/><br /><br />
       <label>State:</label>

       <select class="" name="State">
          <option value="<?php echo $_POST['State'];?>"><?php if (isset($_POST['Submit'])){echo $State;} ?></option>
          <?php
          for($i=0;$i<50;$i++){
            echo "<option value=" . $states[$i] . ">" . $states[$i] . "</option>";
          }
          ?>
       </select></br></br>
       <label>Zip:</label>
       <input type='number' name="Zip" size="30" value="<?php if (isset($_POST['Submit'])){echo $Zip;} ?>"/><br /><br />

       <label>Email:</label>
       <input type='email' name="Email" size="30" value="<?php if (isset($_POST['Submit'])){echo $Email;} ?>"/><br /><br />

       <label>Product:</label>
       <select name="ProductID">
         <option>-</option>
         <?php
          $result = mysqli_query($conn,"SELECT * FROM Products");
          while($row = mysqli_fetch_array($result)){
            if($ProductID == $row['ProductID']){
              ?><option value="<?php echo $row['ProductID'];?>" selected><?php echo $row['ProductName'];?></option><?php
            } else {
              ?><option value="<?php echo $row['ProductID'];?>"><?php echo $row['ProductName']; ?></option><?php
            }
          }
        ?>
       </select><br/><br />
       <label>Color:</label>
       <select name="Color">
         <option>-</option>
         <?php
          if (isset($_POST['Submit'])){
          ?>
         <option value="white" <?php if($Color == "red"){echo "selected";}?>>white</option>
         <option value="red" <?php if($Color == "red"){echo "selected";}?>>red</option>
         <option value="yellow" <?php if($Color == "yellow"){echo "selected";}?>>yellow</option>
         <option value="black" <?php if($Color == "black"){echo "selected";}?>>black</option>
         <option value="green" <?php if($Color == "green"){echo "selected";}?>>green</option>
         <option value="silver" <?php if($Color == "silver"){echo "selected";}?>>silver</option>
         <option value="blue" <?php if($Color == "blue"){echo "selected";}?>>blue</option>
         <?php
          } else{
         ?>
            <option value="white">white</option>
            <option value="red">red</option>
            <option value="yellow">yellow</option>
            <option value="black">black</option>
            <option value="green">green</option>
            <option value="silver">silver</option>
            <option value="blue">blue</option>
        <?php
          }
          ?>

       </select><br /><br / />

       <label>Quantity</label>
       <input type="number" name="Quantity" value="<?php echo $Quantity; ?>"/><br /><br/>

       <center>
         <input type="radio" value = "ship"/>  Ship
         <input type="radio" value = "pick-up" checked="checked"/>  Pick up
         <br /><br /><br /><br />

       <?php mysqli_close($conn);?>
       <input type="reset" value="Cancel Order"/>
       <input type="submit" name="Submit" value="Place an Order"/>
        </center>
    </form>
  </div>
    <?php
    } else {

         // Developement connection
         // $conn=mysqli_connect($servername,$username,$password,$database,$port);

         // Production connection
         $conn = new mysqli($server, $username, $password, $db);
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }

         $sql = "INSERT INTO Customers (FirstName,LastName,Address,City,State,Zip,Email)
         VALUES  ('$fName','$lName','$Address','$City','$State','$Zip','$Email');";

         if ($conn->query($sql) === TRUE) {
             echo "<center>Your order has been submitted! You will be notified ";
             echo "when you can pick it up at the store</center><br />";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }

         $result = mysqli_query($conn,"SELECT * FROM Products");
         while($row = mysqli_fetch_array($result)){

           if($ProductID == $row['ProductID']){
            $Total = $Quantity * $row['Price'];
          }
        }

         $sql = "INSERT INTO Orders (CustomerID, ProductID, Quantity, Color, Total)
         VALUES  (LAST_INSERT_ID(),'$ProductID','$Quantity','$Color','$Total');";

         if ($conn->query($sql) === TRUE) {
             echo "<center>Orders must be paid for in store when picked up</center><br /><br />";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }

         mysqli_close($conn);
    }
    ?>
    <footer>
      <p>Designed by Mederbek Toktosunov &copy; 2017</p>
    </footer>

  </body>
  </html>
