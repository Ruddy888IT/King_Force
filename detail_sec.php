<?php
session_start();

if ($_SESSION['username']==true){
    
    
} else {
    header('location:admin_login.php');
}

$page='sec';
include './include/header.php';

?>


<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Force Company For Security and Guards</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: -40%;
            margin-left: 17%;
        }
        h2 {
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
        }
        .detail-label {
            font-weight: bold;
            color: #6c757d;
        }
        .detail-value {
            color: #495057;
        }
        img {
            max-width: 100%;
            border-radius: 5px;
        }

        @media print {
        .image-container {
            float: right;
        }
    }
    </style>
</head>
<body >



    <div class="container" id="printContent">
    <?php
require_once './db/dbcon.php';
if(isset($_GET['id'])){
$d1result = $dbh->prepare("SELECT * FROM secinfo where id=:id");
$d1result->bindParam(":id",$_GET['id']);
$d1result->execute();
$d1row = $d1result->fetch();

}else{
    header("location:sec.php");
}
?>
        <h2 style="padding-top: 30px;">King Force Company For Security and Guards</h2>
        <div class="row">
            <div class="col-md-4 image-container">
                <img src="uploads/<?php echo $d1row['img']?>" alt="User Picture">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <p class="detail-label">Name:</p>
                        <p class="detail-value"><?php echo $d1row['name']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Age:</p>
                        <p class="detail-value"><?php echo $d1row['age']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Gender:</p>
                        <p class="detail-value"><?php echo $d1row['sex']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Weight:</p>
                        <p class="detail-value"><?php echo $d1row['weight']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Height:</p>
                        <p class="detail-value"><?php echo $d1row['tall']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Home Location:</p>
                        <p class="detail-value"><?php echo $d1row['home']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Work Zone Location:</p>
                        <p class="detail-value"><?php echo $d1row['workzone']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Kind:</p>
                        <p class="detail-value"><?php echo $d1row['seckind']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Type:</p>
                        <p class="detail-value"><?php echo $d1row['sectype']?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="detail-label">Salary:</p>
                        <p class="detail-value"><?php echo $d1row['salary']?></p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="text-center mt-3">
    <button class="btn btn-warning" style="position: absolute;left:90%;bottom:25px;" onclick="printContent()">Print </button>
    </div>

    <script>
    function printContent() {
        var content = document.getElementById('printContent').innerHTML;
        var printWindow = window.open('', '_blank');
        if (printWindow) {
            printWindow.document.open();
            printWindow.document.write('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Print</title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        } else {
            console.error("Failed to open print window.");
        }
    }
</script>


</body>
</html>
