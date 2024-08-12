<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
       
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

		<link rel="stylesheet" type="text/css" href="style.admin.css">
</head>
<body>

	<div class="container"> 
		<form action="admin_login.php" method="post" style=" width: 50%;
                margin-left: 25%;
                margin-top: 15%;">
  <div class="form-group">
      <h3 style="margin-left: 34%">Admin login</h3>
    <label for="username" style="margin-left: 40%">Username:</label>
    <input type="username" class="form-control" placeholder="Enter Username" name="username" id="username">
  </div>
  <div class="form-group">
    <label for="pwd" style="margin-left: 40%">Password:</label>
    <input type="password" class="form-control" placeholder="Enter password" name="password" id="pwd">
  </div>
  <button type="submit" name="submit" class="btn btn-primary" style="margin-left: 40%">Login</button>
</form>	

	</div>

</body>
</html>

<?php

include_once './db/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
    $stmt->execute(array(':username' => $username, ':password' => $password));

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // Assuming role is fetched from the database
        header("location: Home_Dashboard.php");
        exit;
    } else {
        echo "<script>alert('Invalid Username or Password, Please Try Again')</script>";
    }
}
?>
