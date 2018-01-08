<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop datase

$sql = "DROP DATABASE CompanyDatabase";
if ($conn->query($sql) === TRUE) {
    echo "Database dropped successfully<br /><br />";
} else {
    echo "Error dropping database: " . $conn->error;
}

// Create database
$sql = "CREATE DATABASE CompanyDatabase";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br /><br />";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select DATABASE
$sql = "USE CompanyDatabase";
if ($conn->query($sql) === TRUE) {
    echo "Database selected successfully<br /><br />";
} else {
    echo "Error selecting database: " . $conn->error;
}

// sql to create table

$sql = "CREATE TABLE Products(
    ProductID INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    ProductName VARCHAR(30) NOT NULL,
    Description VARCHAR(35) NOT NULL,
    ColorsAvaliable VARCHAR(30) NOT NULL,
    QtyInStock INT(11),
    Price FLOAT(11)
)";


if ($conn->query($sql) === TRUE) {
    echo "Table KennelFood created successfully<br /><br />";
} else {
    echo "Error creating table: " . $conn->error;
}

// Populate table

$sql = "INSERT INTO Products (ProductName, Description, ColorsAvaliable, QtyInStock, Price)
VALUES  ('Winter Coat','Flannel coat for winter runs','blue,yellow', 3, 21.50),
        ('Invisible fence','Smart soluion for restless dogs', 'black,red',6, 102.10),
        ('Hiking backpack','Great peace for long trainls','pink,red',56, 34.40),
        ('Long leash','Strong build for XL dogs','silver,orage',13, 12.65),
        ('Tin Bowl','Durable dog kitchenware','silver',34, 16.65),
        ('Winter shoes','Protection from elements','black,yellow',90, 34.65),
        ('Electronic color','Great gadget to your friend','white,blue,green',13, 12.65)";;


if ($conn->query($sql) === TRUE) {
    echo "New records created successfully<br /><br />";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// create table for Orders

$sql = "CREATE TABLE Customers (
    CustomerID INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    FirstName VARCHAR(15) NOT NULL,
    LastName VARCHAR(15) NOT NULL,
    Address VARCHAR(15) NOT NULL,
    City VARCHAR(10) NOT NULL,
    State VARCHAR(2) NOT NULL,
    Zip INT(11) NOT NULL,
    Email VARCHAR(20)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Customers created successfully<br /><br />";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// create table for Orders

$sql = "CREATE TABLE Orders (
    OrderID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    CustomerID INT NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    ProductID INT NOT NULL,
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    Quantity INT NOT NULL,
    Color VARCHAR(15) NOT NULL,
    Total FLOAT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Orders created successfully<br /><br />";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
