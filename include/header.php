<!doctype html>
<html lang=>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Admin Dashboard</title>
                
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
 integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
 crossorigin="anonymous">
 
 <link rel="stylesheet" href="file:///E:/bootstrap-5.1.3-
dist/css/bootstrap.min.css"/>
    <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style/home_css.css" rel="stylesheet" type="text/css">
    
    <!-- Material Icons Font -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



    <style>
    .nav-link.active .material-icons {
        color: gold;
    }

    .nav-link.active .golden {
        color: gold;
    }
</style>
    
    
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand  col-md-3 mr-0"
          
           href="
            <?php 
           if ($_SESSION['username']=='Mohamad' || 'mohamad'){ 
             echo 'https://www.facebook.com/profile.php?id=100005651627925';
           } 
            if($_SESSION['username']=='admin' || 'Admin') {
             echo 'https://www.facebook.com/kingforceCo';   
            }
             if($_SESSION['username']=='Bawan' || 'bawan') {
             echo 'https://www.facebook.com/profile.php?id=100007864786261';   
            }
            else{
                echo "<script>alert('Error 404 the page is not found')</script>";
            }
            ?>"
                   >The Current Admination is  <?php echo $_SESSION['username'];?></a>


        
        
                   <form action="security.php" method="GET" class="form-inline my-2 my-lg-1">
    <input class="form-control form-control-lg mr-sm-3"  type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-warning my-2 my-sm-0"  type="submit">
        <span class="material-icons">search</span>
    </button>
</form>
        
        <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap btn btn-warning">
          <a class="nav-link " href="logout.php" style="color:black;">Log out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              
            <li class="nav-item">
    <a class="nav-link <?php if($page=='home'){echo 'active';}?>" href="Home_Dashboard.php">
        <span class="material-icons">home</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Home</h5>
    </a>
</li>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['role'] !== 'User') { ?>
    <li class="nav-item">
        <a class="nav-link <?php if($page=='admin'){echo 'active';}?>" href="admin.php">
            <span class="material-icons">group</span>
            <h5 class="golden" style="display: inline-block; margin-left: 5px;">Users</h5>
        </a>
    </li>
<?php } ?>

<li class="nav-item">
    <a class="nav-link <?php if($page=='city'){echo 'active';}?>" href="city.php">
        <span class="material-icons">location_city</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Cities</h5>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php if($page=='car'){echo 'active';}?>" href="car.php">
        <span class="material-icons">emoji_transportation</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Cars</h5>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php if($page=='zone'){echo 'active';}?>" href="zone.php">
        <span class="material-icons">pin_drop</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Zones</h5>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php if($page=='seckind'){echo 'active';}?>" href="seckind.php">
        <span class="material-icons">format_list_bulleted</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Security Kind</h5>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?php if($page=='sectype'){echo 'active';}?>" href="sectype.php">
        <span class="material-icons">format_list_bulleted_add</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Security Type</h5>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link <?php if($page=='sec'){echo 'active';}?>" href="security.php">
        <span class="material-icons">assignment_ind</span>
        <h5 class="golden" style="display: inline-block; margin-left: 5px;">Security Info</h5>
    </a>
</li>


             
            </ul>

            
          </div>
        </nav>