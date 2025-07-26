<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is not set</p>";
    exit;
} else {
    $username = $_SESSION['Username'];
}

$cat_id = $_GET['id'];

$sql = $conn->prepare("DELETE  FROM categories WHERE id = ?");
$sql->bind_param('i',$cat_id);
$sql->execute();
header('Location: category_main.php');
?>