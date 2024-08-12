<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'sectype';
include './include/header.php';
?>


<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
    $id = $_GET['id']; 
$result = $dbh->prepare("SELECT * FROM sectype WHERE id=:id");
$result->execute(['id' => $id]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="sectype.php">Security Type</a></li>
        <li class="breadcrumb-item active">Edit Security Type</li>
    </ul>
</div>

<form method="post" style="position: absolute;left: 30%;top:25%;"  onsubmit="return validateform()" enctype="multipart/form-data">
    <h2>Edit Security Type</h2>
        <hr>
    <div class="form-group">
    <label for="sectype">Security Type:</label>
    <input type="text" class="form-control" name="sectype" value="<?php echo $row['sectype']?>" placeholder="Enter Security type" id="sectype">
  </div>


<div class="form-group">
    <label for="thumbnail">Picture:</label>
    <input type="file" name="img">

  </div>
  <br><br>
<input type="submit" name="submit" class="btn btn-primary" value="submit">
</form>

<script>
    function validateform(){
    var x = document.forms['categoryform']['sectype'].value;
    if(x==""){
        alert('Security Type must be filled!');
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
$folder = "uploads/sectype/";
if (move_uploaded_file($tmp_img, $folder . $img_name)) {


$sql ="update sectype set sectype=:sectype,img=:img where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":sectype",$_POST['sectype']);
$query->bindParam(":img", $img_name, PDO::PARAM_STR);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();

 echo "<script>alert('Update Security Type Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/sectype.php';</script>";

}
}
}
else{
header("location:sectype.php"); }
?>