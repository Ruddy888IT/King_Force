
<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='city';
include './include/header.php';

?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="city.php">City</a></li>
        <li class="breadcrumb-item active">Add City</li>
    </ul>
</div>

<div style=" margin-left: 20%; width: 60%; margin-top: 10%;">
    
    <form action="add_city.php" name="categoryform" method="post" onsubmit="return validateform()" enctype="multipart/form-data">
        <h2>Add City</h2>
        <hr>
  <div class="form-group">
    <label for="city">City Name:</label>
    <input type="text" class="form-control" name="city" placeholder="Enter City Name" id="city">
  </div>
  
        <input type="submit" class="btn btn-primary" name="submit" value="Add">
</form>
    <script>
    function validateform(){
    var x = document.forms['categoryform']['city'].value;
    if(x==""){
        alert('Category must be filled!');
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
    
    $sql ="insert into city(city)values(:city)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":city",$_POST['city'],PDO::PARAM_STR);
    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
                   echo "<script>window.location='http://localhost/King_Force/city.php';</script>";

        } else {
        echo "<script>alert('Please try again ');</script>";
    }
}
?>

<?php
include './include/footer.php';

?>