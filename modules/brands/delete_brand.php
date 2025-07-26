<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

    $username = $_SESSION['Username'];
}
$brand_id = $_GET['id'];
$sql = $conn->prepare('DELETE FROM brands WHERE id = ?');
$sql->bind_param('i',$brand_id);
$sql->execute();
header('Location:brands_main.php');









?>