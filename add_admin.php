<?php
session_start();
if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='admin';
include './include/header.php';

?>
<div style="margin-left: 18.5%; width: 80%;">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active"><a href="admin.php">Admin</a></li>
           <li class="breadcrumb-item active">Add New Admin</li>
        </ul>

    </div>
<div style=" margin-left: 25%; width: 60%;">
    
    
    <form action="add_admin.php" name="categoryform"  method="post" onsubmit="return validateform()">
        <h2>Add New Admin</h2>
        <hr>
  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" placeholder="Username" id="username">
  </div>
        
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" placeholder="Email" id="email">
  </div>
        
        <div class="form-group">
    <label for="password">Password:</label>
    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
  </div>
        

  <div class="form-group">
    <label>Role:</label>
    <select name="role" >
      
    <option>
     User
    </option>
     <option>
     Admin
    </option>
        
 
    </select>
        </div>
       
        <input type="submit" class="btn btn-primary" name="submit" value="Add">
</form>
    
    <script>
    function validateform(){
    var t = document.forms['categoryform']['username'].value;
    var y = document.forms['categoryform']['email'].value;
    var z = document.forms['categoryform']['password'].value;
    var r = document.forms['categoryform']['role'].value;
        if(t==""){
        alert('Username must be filled!');
        return false;
    }
     if(y==""){
        alert('Email must be filled!');
        return false;
    }
     if(z==""){
        alert('Password must be filled!');
        return false;
    }
    if(p==""){
        alert('Role must be filled!');
        return false;
    }
     
    }
    </script>
</div>
<?php
include './include/footer.php';

?>
<?php


if(isset($_POST['submit'])){
    require_once './db/dbcon.php';
    
    $sql ="insert into user(username,email,password,role)values(:username,:email,:password,:role)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":username",$_POST['username']);
    $query->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
    $query->bindParam(":password",$_POST['password'],PDO::PARAM_STR);
    $query->bindParam(":role",$_POST['role'],PDO::PARAM_STR);
    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
        echo "<script>window.location='http://localhost/King_Force/admin.php';</script>";

    } else {
        echo "<script>alert('Please try again ');</script>";
    }
}
    
   
    
   

?>