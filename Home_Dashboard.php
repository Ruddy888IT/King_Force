<?php 
session_start();
if ($_SESSION['username'] != true){
    header('location:admin_login.php');
}
$page='home';
include './include/header.php';
?>
 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
        }
        .dashboard-item {
            width: 250px;
            height: 150px;
            margin: 20px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .dashboard-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .dashboard-item img {
            max-width: 100px;
            max-height: 80px;
            margin-bottom: 10px;
        }
    </style>
<div class="container">
    <h2 style="margin-top:2%;" class="text-center">King Force Company </h2>
    <div class="dashboard-container">
        <div class="dashboard-item bg-primary">
            <a style="color:#f8f9fa;font-size: 40px;" href="city.php">
            <span class="material-icons">location_city</span>

                <h4 >City</h4>
            </a>
        </div>
        <div class="dashboard-item bg-success">
            <a style="color:#f8f9fa;font-size: 40px;" href="car.php">
            <span class="material-icons">emoji_transportation</span>

            <h4>Cars</h4>
            </a>
        </div>
        <div class="dashboard-item bg-danger">
            <a style="color:#f8f9fa;font-size: 40px;" href="zone.php">
            <span class="material-icons">pin_drop</span>
                <h4>Zones</h4>
            </a>
        </div>
        <div class="dashboard-item bg-warning">
            <a style="color:#000000;font-size: 40px;" href="sectype.php">
            <span class="material-icons">format_list_bulleted_add</span>
                <h4>Security Type</h4>
            </a>
        </div>
        <div class="dashboard-item bg-secondary">
            <a style="color:#FFFFFF;font-size: 40px;" href="security.php">
            <span class="material-icons">assignment_ind</span>
            <h4>Security Info</h4>
            </a>
        </div>
        <div class="dashboard-item bg-info">
            <a style="color:#FFFFFF;font-size: 40px;" href="seckind.php">
            <span class="material-icons">format_list_bulleted_add</span>
            <h4>Security Kind</h4>
            </a>
        </div>
    </div>
</div>
</div>
</div>

<script>
    $(document).ready(function(){
        $(".animated-text").addClass("delay-1s");
        $(".animated-logo").addClass("delay-3s");
    });
</script>

<?php
include './include/footer.php';
?>
