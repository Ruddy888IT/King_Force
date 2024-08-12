<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'zone';
include './include/header.php';
?>


<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
    $id = $_GET['id']; 
$result = $dbh->prepare("SELECT * FROM zone WHERE id=:id");
$result->execute(['id' => $id]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="Zone.php">Zone</a></li>
        <li class="breadcrumb-item active">Edit Zone</li>
    </ul>
</div>

<form method="post" style="position: absolute;left: 30%;top:25%;"  onsubmit="return validateform()" enctype="multipart/form-data">
    <h2>Edit Zone Information</h2>
        <hr>
    <div class="form-group">
    <label for="zone">Zone Name:</label>
    <input type="text" class="form-control" name="zone_name" value="<?php echo $row['zone_name']?>" placeholder="Enter Zone Name" id="zone">
  </div>
<br><br>

   <div class="form-group">
    <label>City:</label>
    <select name="city" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM city");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['city'];?>
    </option>
        
    <?php }?>
    </select>
        </div>


        <div class="form-group">
    <label>Car Name:</label>
    <select name="car_name" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM car");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['car_name'];?>
    </option>
        
    <?php }?>
    </select>
        </div>


<input type="submit" name="submit" class="btn btn-primary" value="submit">
</form>

<script>
    function validateform(){
    var x = document.forms['categoryform']['zone_name'].value;
    if(x==""){
        alert('Zone Name must be filled!');
        return false;
        
    }
    }
    </script>

<?php
if(isset($_POST['submit'])){
require_once './db/dbcon.php';
$sql ="update zone set city=:city,zone_name=:zone_name,car_name=:car_name where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":zone_name",$_POST['zone_name']);
$query->bindParam(":city",$_POST['city']);
$query->bindParam(":car_name",$_POST['car_name']);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();

 echo "<script>alert('Update Zone Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/zone.php';</script>";

}}
else{
header("location:zone.php"); }
?>