<?php
$host = "localhost";
$user = "root"; // or your MySQL username
$password = ""; // your MySQL password
$database ="inventory_db";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
