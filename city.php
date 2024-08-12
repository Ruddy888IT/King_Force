<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location:admin_login.php');
    exit();
}

$page = 'city';
include './include/header.php';
require_once './db/dbcon.php';

// Determine the current page
$num_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $num_per_page;

// Fetch records with pagination
$sql = "SELECT * FROM city LIMIT :start_from, :num_per_page";
$statement = $dbh->prepare($sql);
$statement->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$statement->bindValue(':num_per_page', $num_per_page, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="city.php">City</a></li>
    </ul>
</div>

<div style="margin-left: 20%; width: 50%; margin-top: 5%;">
    <div class="text-right">
        <button class="btn btn-primary"><a href="add_city.php" style="color: white;">Add City</a></button>
    </div>
   

    <table class="table table-bordered" id="cityTable" style="margin-left: 10%; margin-top: 5%;">
        <tr>
            <th>City Name</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                <th class="no-print">Delete</th>
                <th class="no-print">Update</th>
            <?php } ?>
        </tr>
        <?php foreach ($row as $val) { ?>
            <tr>
                <td><?php echo htmlspecialchars($val['city']); ?></td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                    <td class="no-print"><a href="delete_city.php?id=<?php echo $val['id']; ?>" class="btn btn-danger">Delete</a></td>
                    <td class="no-print"><a href="edit_city.php?id=<?php echo $val['id']; ?>" class="btn btn-info">Edit</a></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>

    <!-- Pagination Links -->
    <ul class="pagination" style="margin-left: 55%;">
        <?php
        // Calculate the total number of pages
        $count_sql = "SELECT COUNT(*) as total FROM city";
        $count_statement = $dbh->prepare($count_sql);
        $count_statement->execute();
        $total_records = $count_statement->fetch()['total'];
        $total_pages = ceil($total_records / $num_per_page);
        ?>

        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="city.php?page=<?php echo ($page - 1); ?>">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="city.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>

        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="city.php?page=<?php echo ($page + 1); ?>">Next</a>
        </li>
        <li> <!-- Print Button -->
    <div class="text-right" style="margin-left: 50px;">
        <button class="btn btn-secondary" onclick="printTable()">Print</button>
    </div></li>
    </ul>
</div>

<?php
include './include/footer.php';
?>

<script>
    function printTable() {
        var printContents = document.getElementById('cityTable').outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore JavaScript functionality
    }
</script>
