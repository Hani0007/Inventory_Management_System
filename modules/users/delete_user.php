<?php
include '../../config/db.php';
$user_Id = $_GET['id'];
$sql = $conn->prepare("DELETE FROM users WHERE Id = ?");
$sql->bind_param('i',$user_Id);
if($sql->execute()){
header('Location:user_main.php');


}








?>