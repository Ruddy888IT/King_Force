<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
$sql = "delete from zone WHERE id=:id";
$query = $dbh->prepare($sql);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query -> execute();

echo "<script> alert('Zone Was Deleted')</script>";
   echo "<script>window.location='http://localhost/King_Force/zone.php';</script>";

} else {
    
     echo "<script> alert('Please try again')</script>";
header("location:zone.php");
}

