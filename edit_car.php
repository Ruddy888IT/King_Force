<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'car';
include './include/header.php';
?>


<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
    $id = $_GET['id']; 
$result = $dbh->prepare("SELECT * FROM car WHERE id=:id");
$result->execute(['id' => $id]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="car.php">Car</a></li>
        <li class="breadcrumb-item active">Edit Car</li>
    </ul>
</div>

<form method="post" style="position: absolute;left: 30%;top:25%;"  onsubmit="return validateform()" enctype="multipart/form-data">
    <h2>Edit Car Informations</h2>
        <hr>
    <div class="form-group">
    <label for="car_name">Car Name:</label>
    <input type="text" class="form-control" name="car_name" value="<?php echo $row['car_name']?>" placeholder="Enter Car Name" id="car">
  </div>

  <div class="form-group">
    <label for="model">Model:</label>
    <input type="number" class="form-control" name="model" value="<?php echo $row['model']?>" placeholder="Enter Model" id="Model">
  </div>

  <div class="form-group">
    <label for="car_number">Car Number:</label>
    <input type="text" class="form-control" name="car_number" value="<?php echo $row['car_number']?>" placeholder="Enter Car Number" id="car_number">
  </div>
<br><br>


<div class="form-group">
    <label for="thumbnail">Picture:</label>
    <input type="file" name="img">

  </div>

<input type="submit" name="submit" class="btn btn-primary" value="submit">
</form>

<script>
    function validateform(){
    var x = document.forms['categoryform']['car_name'].value;
    if(x==""){
        alert('Car Name must be filled!');
        return false;
        
    }
    }
    </script>

<?php
if(isset($_POST['submit'])){
require_once './db/dbcon.php';

$admin=$_SESSION['username'];
$img_name = rand(10, 100000) . "-" . $_FILES['img']['name'];
$tmp_img = $_FILES['img']['tmp_name'];
$folder = "uploads/car/";
if (move_uploaded_file($tmp_img, $folder . $img_name)) {

$sql ="update car set car_name=:car_name,model=:model,car_number=:car_number,img=:img where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":car_name",$_POST['car_name']);
$query->bindParam(":model",$_POST['model']);
$query->bindParam(":img", $img_name, PDO::PARAM_STR);

$query->bindParam(":car_number",$_POST['car_number']);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();

 echo "<script>alert('Update Car Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/car.php';</script>";
}
}}
else{
header("location:car.php"); }
?>