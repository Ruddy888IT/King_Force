<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'seckind';
include './include/header.php';
?>


<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
    $id = $_GET['id']; 
$result = $dbh->prepare("SELECT * FROM seckind WHERE id=:id");
$result->execute(['id' => $id]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="seckind.php">Security Kind</a></li>
        <li class="breadcrumb-item active">Edit Security Kind</li>
    </ul>
</div>

<form method="post" style="position: absolute;left: 30%;top:25%;"  onsubmit="return validateform()" enctype="multipart/form-data">
    <h2>Edit Security Kind</h2>
        <hr>
    <div class="form-group">
    <label for="seckind">Security Kind:</label>
    <input type="text" class="form-control" name="seckind" value="<?php echo $row['seckind']?>" placeholder="Enter Security Kind" id="seckind">
  </div>


  <br><br>
<input type="submit" name="submit" class="btn btn-primary" value="submit">
</form>

<script>
    function validateform(){
    var x = document.forms['categoryform']['seckind'].value;
    if(x==""){
        alert('Security Kind must be filled!');
        return false;
        
    }
    }
    </script>

<?php
if(isset($_POST['submit'])){
require_once './db/dbcon.php';


$sql ="update seckind set seckind=:seckind where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":seckind",$_POST['seckind']);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();

 echo "<script>alert('Update Security Kind Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/seckind.php';</script>";

}
}

else{
header("location:seckind.php"); }
?>