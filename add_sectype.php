
<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='sectype';
include './include/header.php';

?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="sectype.php">Security Type</a></li>
        <li class="breadcrumb-item active">Add Security Type</li>
    </ul>
</div>

<div style=" margin-left: 20%; width: 60%; margin-top: 10%;">
    
    <form action="add_sectype.php" name="categoryform" method="post" onsubmit="return validateform()" enctype="multipart/form-data">
        <h2>Add Security Type</h2>
        <hr>
  <div class="form-group">
    <label for="sectype">Security Type:</label>
    <input type="text" class="form-control" name="sectype" placeholder="Enter Security Type" id="sectype">
  </div>

  <div class="form-group">
    <label for="thumbnail">Picture:</label>
    <input type="file" name="img">

  </div>
  
        <input type="submit" class="btn btn-primary" name="submit" value="Add">
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
</div>
<?php
include './include/footer.php';
?>

<?php
if(isset($_POST['submit'])){    
    require_once './db/dbcon.php';
    $admin=$_SESSION['username'];
    $img_name = rand(10, 100000) . "-" . $_FILES['img']['name'];
    $tmp_img = $_FILES['img']['tmp_name'];
    $folder = "uploads/sectype/";
    if (move_uploaded_file($tmp_img, $folder . $img_name)) {
    $sql ="insert into sectype(sectype,img)values(:sectype,:img)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":sectype",$_POST['sectype'],PDO::PARAM_STR);
    $query->bindParam(":img", $img_name,PDO::PARAM_STR);
    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
                   echo "<script>window.location='http://localhost/King_Force/sectype.php';</script>";

        } else {
        echo "<script>alert('Please try again ');</script>";
    }
}
}
?>

<?php
include './include/footer.php';

?>