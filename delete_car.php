<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
$sql = "delete from car WHERE id=:id";
$query = $dbh->prepare($sql);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query -> execute();

echo "<script> alert('Car Information Was Deleted')</script>";
   echo "<script>window.location='http://localhost/King_Force/car.php';</script>";

} else {
    
     echo "<script> alert('Please try again')</script>";
header("location:car.php");
}

