<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'admin';
include './include/header.php';
?>

<?php
if (!empty($_GET['id'])) {
    require_once './db/dbcon.php';
    $id = $_GET['id'];  // Corrected variable assignment
    $result = $dbh->prepare("SELECT * FROM user WHERE id=:id");
    $result->execute(['id' => $id]);
    $row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="admin.php">Admin</a></li>
        <li class="breadcrumb-item active">Update Admin Information</li>
    </ul>
</div>

<div style="margin-left: 18.5%; width: 60%; margin-top: 10%;">
   
   
<form method="post" style="position: absolute;left: 30%;top:25%;" onsubmit="return validateform()" enctype="multipart/form-data">
         <h2>Update Admin Informations</h2>
      <hr>
      
      <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" value="<?php echo $row['username'];?>" placeholder="Username" id="username">
  </div>
        
  <div class="form-group">
  <label for="email">Email:</label>
  <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>" placeholder="Email" id="email">
</div>
        
        <div class="form-group">
    <label for="password">Password:</label>
    <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $row['password']?>">
  </div>
       
      
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form> 

    
    <script>
        function validateform() {
            var t = document.forms['categoryform']['username'].value;
            var y = document.forms['categoryform']['email'].value;
            var z = document.forms['categoryform']['password'].value;
            if (t == "") {
                alert('Username must be filled!');
                return false;
            }
            if (y == "") {
                alert('Email must be filled!');
                return false;
            }
            if (z == "") {
                alert('Password must be filled!');
                return false;
            }
        }
    </script>
</div>


<?php
if(isset($_POST['submit'])){
require_once './db/dbcon.php';
$sql ="update user set username=:username,password=:password,
email=:email where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":username",$_POST['username']);
$query->bindParam(":password",$_POST['password'],PDO::PARAM_STR);
$query->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();
 echo "<script>alert('Update Admin Informtion is Successful')</script>";
       echo "<script>window.location='http://localhost/King_Force/admin.php';</script>";
}}
else{
header("location:admin.php"); }
?>