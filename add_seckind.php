
<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='seckind';
include './include/header.php';

?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="seckind.php">Security Kind</a></li>
        <li class="breadcrumb-item active">Add Security Kind</li>
    </ul>
</div>

<div style=" margin-left: 20%; width: 60%; margin-top: 10%;">
    
    <form action="add_seckind.php" name="categoryform" method="post" onsubmit="return validateform()" enctype="multipart/form-data">
        <h2>Add Security Kind</h2>
        <hr>
  <div class="form-group">
    <label for="seckind">Security Kind:</label>
    <input type="text" class="form-control" name="seckind" placeholder="Enter Security Kind" id="seckind">
  </div>

  
        <input type="submit" class="btn btn-primary" name="submit" value="Add">
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
</div>
<?php
include './include/footer.php';
?>

<?php
if(isset($_POST['submit'])){    
    require_once './db/dbcon.php';
 
    $sql ="insert into seckind(seckind)values(:seckind)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":seckind",$_POST['seckind'],PDO::PARAM_STR);
    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
                   echo "<script>window.location='http://localhost/King_Force/seckind.php';</script>";

        } else {
        echo "<script>alert('Please try again ');</script>";
    }
}

?>

<?php
include './include/footer.php';

?>