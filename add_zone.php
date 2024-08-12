<?php
include './include/footer.php';

?>
<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='zone';
include './include/header.php';

?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="zone.php">Zone</a></li>
        <li class="breadcrumb-item active">Add Zone</li>
    </ul>
</div>

<div style=" margin-left: 20%; width: 60%; margin-top: 10%;">
    
    <form action="add_zone.php" name="categoryform" method="post" onsubmit="return validateform()" enctype="multipart/form-data">
        <h2>Add Categories</h2>
        <hr>
  <div class="form-group">
    <label for="zone">Zones:</label>
    <input type="text" class="form-control" name="zone_name" placeholder="Enter Zone Name" id="zone">
  </div>
        
        
                <div class="form-group">
    <label>City:</label>
    <select name="city" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM city");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['city'];?>
    </option>
        
    <?php }?>
    </select>
        </div>


        <div class="form-group">
    <label>Car in header:</label>
    <select name="car_name" >
       <?php
require_once './db/dbcon.php';
$result = $dbh->prepare("SELECT * FROM car");
$result->execute();
$row = $result->fetchall();
foreach ($row as $val) {
?>
    <option>
        <?php  echo $val['car_name'];?>
    </option>
        
    <?php }?>
    </select>
        </div>
  
  
        <input type="submit" class="btn btn-primary" name="submit" value="Add Zone">
</form>
    <script>
    function validateform(){
    var x = document.forms['categoryform']['zone'].value;
    if(x==""){
        alert('Zone Name must be filled!');
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
    
    $sql ="insert into zone(city,zone_name,car_name)values(:city,:zone_name,:car_name)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":city",$_POST['city'],PDO::PARAM_STR);
    $query->bindParam(":zone_name",$_POST['zone_name'],PDO::PARAM_STR);
    $query->bindParam(":car_name",$_POST['car_name'],PDO::PARAM_STR);
    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
                   echo "<script>window.location='http://localhost/King_Force/zone.php';</script>";

        } else {
        echo "<script>alert('Please try again ');</script>";
    }
}
?>