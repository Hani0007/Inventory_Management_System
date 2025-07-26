<?php
include '../../config/db.php';
$product_id = $_GET['id'];
$sql= $conn->prepare("DELETE  FROM product WHERE Id = ?");
$sql->bind_param('i', $product_id);
if($sql->execute()){
// echo "<p style = 'color:red';>Deleted Successfully!</p>";
header('Location:product_main.php');

}




?>