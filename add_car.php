
<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='car';
include './include/header.php';

?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="car.php">Car</a></li>
        <li class="breadcrumb-item active">Add Car</li>
    </ul>
</div>

<div style=" margin-left: 20%; width: 60%; margin-top: 10%;">
    
    <form action="add_car.php" name="categoryform" method="post" onsubmit="return validateform()" enctype="multipart/form-data">
        <h2>Add Car</h2>
        <hr>
  <div class="form-group">
    <label for="car_name">Car Name:</label>
    <input type="text" class="form-control" name="car_name" placeholder="Enter Car Name" id="car">
  </div>
  

  <div class="form-group">
    <label for="car_model">Car Model (By Year):</label>
    <input type="number" class="form-control" name="model" placeholder="Enter Car Model" id="car_model">
  </div>

  <div class="form-group">
    <label for="car_number">Car Number:</label>
    <input type="text" class="form-control" name="car_number" placeholder="Enter Car Number" id="car_number">
  </div>

  <div class="form-group">
    <label for="thumbnail">Picture:</label>
    <input type="file" name="img">

  </div>
  

        <input type="submit" class="btn btn-primary" name="submit" value="Add">
</form>
    <script>
    function validateform(){
    var x = document.forms['categoryform']['car_name'].value;
    if(x==""){
        alert('Car Name must be filled!');
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
    $folder = "uploads/car/";
    if (move_uploaded_file($tmp_img, $folder . $img_name)) {
    $sql ="insert into car(car_name,model,car_number,img)values(:car_name,:model,:car_number,:img)";
    $query = $dbh->prepare($sql);
    $query->bindParam(":car_name",$_POST['car_name'],PDO::PARAM_STR);
    $query->bindParam(":model",$_POST['model'],PDO::PARAM_STR);
    $query->bindParam(":car_number",$_POST['car_number'],PDO::PARAM_STR);
    $query->bindParam(":img", $img_name, PDO::PARAM_STR);

    $query->execute();
    $last = $dbh->lastInsertId();
    if($last){
        echo "<script>alert('Insert is Successful');$last</script>";
                   echo "<script>window.location='http://localhost/King_Force/car.php';</script>";

        } else {
        echo "<script>alert('Please try again ');</script>";
    }
}
}
?>

<?php
include './include/footer.php';

?>