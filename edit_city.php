<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'city';
include './include/header.php';
?>


<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
    $id = $_GET['id']; 
$result = $dbh->prepare("SELECT * FROM city WHERE id=:id");
$result->execute(['id' => $id]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="city.php">City</a></li>
        <li class="breadcrumb-item active">Edit city</li>
    </ul>
</div>

<form method="post" style="position: absolute;left: 30%;top:25%;"  onsubmit="return validateform()" enctype="multipart/form-data">
    <h2>Edit City Informations</h2>
        <hr>
    <div class="form-group">
    <label for="city">City:</label>
    <input type="text" class="form-control" name="city" value="<?php echo $row['city']?>" placeholder="Enter City Name" id="city">
  </div>
<br><br>

<input type="submit" name="submit" class="btn btn-primary" value="submit">
</form>

<script>
    function validateform(){
    var x = document.forms['categoryform']['city'].value;
    if(x==""){
        alert('City must be filled!');
        return false;
        
    }
    }
    </script>

<?php
if(isset($_POST['submit'])){
require_once './db/dbcon.php';
$sql ="update city set city=:city where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":city",$_POST['city']);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();

 echo "<script>alert('Update City Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/city.php';</script>";

}}
else{
header("location:city.php"); }
?>