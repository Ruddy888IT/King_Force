<?php
session_start();
if ($_SESSION['username'] == true) {
    // Code inside if session is valid
} else {
    header('location:admin_login.php');
}

$page = 'sec';
include './include/header.php';
?>

<?php
if(!empty($_GET['id'])){
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM secinfo WHERE id=:id");
$result->execute(['id' => $_GET['id']]);
$row = $result->fetch();
?>

<div style="margin-left: 18.5%; width: 80%;">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
            <li class="breadcrumb-item active"><a href="security.php">Security</a></li>
           <li class="breadcrumb-item active">Edit Security</li>
        </ul>

    </div>


<form method="post" enctype="multipart/form-data" style="position: absolute;left: 30%;top:25%;" 
      enctype="multipart/form-data" name="categoryform" onsubmit="return validateform()">
    <h2>Edit Security Information</h2>
        <hr>
<div class="form-group">
    <label for="name">Security Name:</label>
    <input type="text" class="form-control" name="name" placeholder="Enter Security Name" id="name" value="<?php echo $row['name'];?>">
  </div>
        
<div class="form-group">
    <label for="number">Age:</label>
    <input type="number" class="form-control" name="age" placeholder="Enter Security age" id="age" value="<?php echo $row['age'];?>">
  </div>
        
                <div class="form-group">
    <label>Sex:</label>
    <select name="sex" >
      
    <option>
     Male
    </option>
     <option>
     Female
    </option>

    <div class="form-group">
    <label for="number">Weight:</label>
    <input type="number" class="form-control" name="weight" placeholder="Enter Security Weight" id="weight" value="<?php echo $row['weight'];?>">
  </div>

    <div class="form-group">
    <label for="number">Tall:</label>
    <input type="number" class="form-control" name="tall" placeholder="Enter Security Tall" id="tall" value="<?php echo $row['tall'];?>">
  </div>

<div class="form-group">
    <label for="name">Home Address:</label>
    <input type="text" class="form-control" name="home" placeholder="Enter Home Address" id="home" value="<?php echo $row['home'];?>">
  </div>
    
    <div class="form-group">
    <label for="number">Salary:</label>
    <input type="number" class="form-control" name="salary" placeholder="Enter Security Salary" id="salary" value="<?php echo $row['salary'];?>">
  </div>

  <div class="form-group">
    <label for="title">admin:</label>
<input type="text" class="form-control" name="admin"  id="admin" disabled value="<?php echo $row['admin'];}?>" >
  </div>



  <div class="form-group">
    <label>Security Type</label>
    <select name="seckind" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM seckind");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['seckind'];?>
    </option>
        
    <?php }?>
    </select>
        </div>

  
  <div class="form-group">
    <label>Security Type</label>
    <select name="sectype" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM sectype");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['sectype'];?>
    </option>
        
    <?php }?>
    </select>
        </div>

  

   <div class="form-group">
    <label>Work Location:</label>
    <select name="workzone" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM zone");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['zone_name'];?>
    </option>
        
    <?php }?>
    </select>
        </div>
    
    
    
        
  <div class="form-group">
    <label for="thumbnail">Picture:</label>
    <input type="file" name="img">

  </div>


        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>


   <script>
    function validateform(){
    var t = document.forms['categoryform']['name'].value;
    var y = document.forms['categoryform']['home'].value;
   
        if(t==""){
        alert('Security Name must be filled!');
        return false;
    }
     if(y==""){
        alert('Home Address must be filled!');
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
$folder = "uploads/";
if (move_uploaded_file($tmp_img, $folder . $img_name)) {
$sql ="update secinfo set name=:name,age=:age,sex=:sex,weight=:weight
    ,tall=:tall,home=:home,workzone=:workzone,salary=:salary,seckind=:seckind,sectype=:sectype,admin=:admin,img=:img where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":name",$_POST['name'],PDO::PARAM_STR);
$query->bindParam(":age",$_POST['age'],PDO::PARAM_STR);
$query->bindParam(":sex",$_POST['sex'],PDO::PARAM_STR);
$query->bindParam(":weight",$_POST['weight'],PDO::PARAM_STR);
$query->bindParam(":tall",$_POST['tall'],PDO::PARAM_STR);
$query->bindParam(":home",$_POST['home'],PDO::PARAM_STR);
$query->bindParam(":workzone",$_POST['workzone'],PDO::PARAM_STR);
$query->bindParam(":salary",$_POST['salary'],PDO::PARAM_STR);
$query->bindParam(":seckind",$_POST['seckind'],PDO::PARAM_STR);
$query->bindParam(":sectype",$_POST['sectype'],PDO::PARAM_STR);
$query->bindParam(":admin",$admin,PDO::PARAM_STR);
$query->bindParam(":img", $img_name, PDO::PARAM_STR);
$query-> bindParam(':id',$_GET['id'], PDO::PARAM_INT);
$query->execute();
echo "<script>alert('Update is Successful')</script>";
        echo "<script>window.location='http://localhost/King_Force/security.php';</script>";

}

else{
    echo "<script>alert('Update is Feild!')</script>";
        echo "<script>window.location='http://localhost/King_Force/Security.php';</script>";
 
}
}
?>
