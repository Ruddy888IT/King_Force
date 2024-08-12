<?php
session_start();
if ($_SESSION['username'] == true) {

} else {
    header('location:admin_login.php');
}

$page = 'sec';
include './include/header.php';

?>
<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="security.php">Security</a></li>
        <li class="breadcrumb-item active">Add Security</li>
    </ul>
</div>

<div style="margin-left: 25%; width: 60%;">
    <form action="add_sec.php" name="categoryform" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <h2>Add Security information</h2>
        <hr>
        <div class="form-group">
            <label for="name">Security Name:</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Security Name" id="name">
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" name="age" placeholder="Enter Age" id="age">
        </div>

        <div class="form-group">
            <label>Sex:</label>
            <select name="sex">
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Weight:</label>
            <input type="number" class="form-control" name="weight" placeholder="Enter Weight" id="weight">
        </div>

        <div class="form-group">
            <label for="tall">Tall:</label>
            <input type="number" class="form-control" name="tall" placeholder="Enter Tall" id="tall">
        </div>

        <div class="form-group">
            <label for="salary">Salary:</label>
            <div id="salary-note" class="alert alert-info" role="alert">
                Please enter the salary according to the selected security type:
                <ul>
                    <li>Security: 400,000 - 500,000</li>
                    <li>Team Leader: 550,000 - 700,000</li>
                    <li>Supervisor: 750,000 - 900,000</li>
                </ul>
            </div>
            <input type="number" class="form-control" name="salary" placeholder="Enter Salary" id="salary">
        </div>

        <div class="form-group">
            <label>Security Type:</label>
            <select name="seckind" id="seckind">
                <?php
                require_once './db/dbcon.php';
                $result = $dbh->prepare("SELECT * FROM seckind");
                $result->execute();
                $row = $result->fetchAll();
                foreach ($row as $val) {
                ?>
                    <option value="<?php echo $val['seckind']; ?>"><?php echo $val['seckind']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Security Type:</label>
            <select name="sectype">
                <?php
                require_once './db/dbcon.php';
                $result = $dbh->prepare("SELECT * FROM sectype");
                $result->execute();
                $row = $result->fetchAll();
                foreach ($row as $val) {
                ?>
                    <option value="<?php echo $val['sectype']; ?>"><?php echo $val['sectype']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="home">Home Location:</label>
            <input type="text" class="form-control" name="home" placeholder="Enter Home Location" id="home">
        </div>

        <div class="form-group">
            <label for="img">Picture:</label>
            <input type="file" name="img">
        </div>

        <div class="form-group">
            <label>Work Location:</label>
            <select name="workzone">
                <?php
                require_once './db/dbcon.php';
                $result = $dbh->prepare("SELECT * FROM zone");
                $result->execute();
                $row = $result->fetchAll();
                foreach ($row as $val) {
                ?>
                    <option value="<?php echo $val['zone_name']; ?>"><?php echo $val['zone_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="admin">Admin:</label>
            <input type="text" class="form-control" disabled value="<?php echo $_SESSION['username']; ?>">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="Add">
    </form>

    <script>
        function validateForm() {
            var name = document.forms['categoryform']['name'].value;
            var age = document.forms['categoryform']['age'].value;
            var home = document.forms['categoryform']['home'].value;
            var salary = document.forms['categoryform']['salary'].value;
            var seckind = document.forms['categoryform']['seckind'].value;
            var salaryValid = validateSalary(seckind, salary);

            if (name == "") {
                alert('Security Name must be filled!');
                return false;
            }
            if (age == "") {
                alert('Age must be filled!');
                return false;
            }
            if (home == "") {
                alert('Home Location must be filled!');
                return false;
            }
            if (!salaryValid) {
                return false;
            }
            return true;
        }

        function validateSalary(seckind, salary) {
            salary = parseInt(salary);
            if (seckind == "Security" && (salary < 400000 || salary > 500000)) {
                alert('Security salary must be between 400,000 and 500,000.');
                return false;
            }
            if (seckind == "Team Leader" && (salary < 550000 || salary > 700000)) {
                alert('Team Leader salary must be between 550,000 and 700,000.');
                return false;
            }
            if (seckind == "Supervisor" && (salary < 750000 || salary > 900000)) {
                alert('Supervisor salary must be between 750,000 and 900,000.');
                return false;
            }
            return true;
        }
    </script>
</div>
<?php
include './include/footer.php';

if (isset($_POST['submit'])) {
    require_once './db/dbcon.php';
    $admin = $_SESSION['username'];
    $img_name = rand(10, 100000) . "-" . $_FILES['img']['name'];
    $tmp_img = $_FILES['img']['tmp_name'];
    $folder = "uploads/";
    if (move_uploaded_file($tmp_img, $folder . $img_name)) {
        $sql = "INSERT INTO secinfo(name, age, sex, weight, tall, home, workzone, salary, seckind, sectype, admin, img) VALUES
            (:name, :age, :sex, :weight, :tall, :home, :workzone, :salary, :seckind, :sectype, :admin, :img)";
        $query = $dbh->prepare($sql);
        $query->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
        $query->bindParam(":age", $_POST['age'], PDO::PARAM_STR);
        $query->bindParam(":sex", $_POST['sex'], PDO::PARAM_STR);
        $query->bindParam(":weight", $_POST['weight'], PDO::PARAM_STR);
        $query->bindParam(":tall", $_POST['tall'], PDO::PARAM_STR);
        $query->bindParam(":home", $_POST['home'], PDO::PARAM_STR);
        $query->bindParam(":workzone", $_POST['workzone'], PDO::PARAM_STR);
        $query->bindParam(":salary", $_POST['salary'], PDO::PARAM_STR);
        $query->bindParam(":seckind", $_POST['seckind'], PDO::PARAM_STR);
        $query->bindParam(":sectype", $_POST['sectype'], PDO::PARAM_STR);
        $query->bindParam(":admin", $admin, PDO::PARAM_STR);
        $query->bindParam(":img", $img_name, PDO::PARAM_STR);
        $query->execute();
        $last = $dbh->lastInsertId();
        if ($last) {
            echo "<script>alert('Insert Security Information was successful');</script>";
            echo "<script>window.location='http://localhost/King_Force/security.php';</script>";
        } else {
            echo "<script>alert('Please try again');</script>";
        }
    }
}
?>
