<?php
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('location:admin_login.php');
    exit;
}

$page = 'admin';
include './include/header.php';
?>

<?php
include_once './db/dbcon.php';

// Set the number of records per page
$num_per_page = 5;

// Determine the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $num_per_page;

// Fetch records with pagination
$sql = "SELECT * FROM user LIMIT :start_from, :num_per_page";
$statement = $dbh->prepare($sql);
$statement->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$statement->bindValue(':num_per_page', $num_per_page, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="margin-left: 18.5%; width: 80%; ">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="admin.php">Admin</a></li>
    </ul>
</div>

<div style="margin-left: 20%; width: 50%; margin-top: 5%;">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
        <div class="text-right">
            <button class="btn btn-primary"><a href="add_admin.php" style="color: white;">Add New Admin</a></button>
        </div>
    <?php } ?>
    <table class="table table-bordered" style="margin-left: 20%;margin-top: 5%;">
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Role</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                <th>Delete</th>
                <th>Update</th>
            <?php } ?>
        </tr>
        <?php foreach ($row as $val) { ?>
            <tr>
                <td><?php echo htmlspecialchars($val['id']); ?></td>
                <td><?php echo htmlspecialchars($val['username']); ?></td>
                <td><?php echo str_repeat('*', strlen($val['password'])); ?></td>
                <td><?php echo htmlspecialchars($val['email']); ?></td>
                <td><?php echo htmlspecialchars($val['role']); ?></td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                    <td><a href="delete_admin.php?id=<?php echo $val['id']; ?>" class="btn btn-danger">Delete</a></td>
                    <td><a href="edit_admin.php?id=<?php echo $val['id']; ?>" class="btn btn-info">Edit</a></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>

    <ul class="pagination" style="margin-left: 55%">
        <?php
        // Calculate the total number of pages
        $count_sql = "SELECT COUNT(*) as total FROM user";
        $count_statement = $dbh->prepare($count_sql);
        $count_statement->execute();
        $total_records = $count_statement->fetch()['total'];
        $total_pages = ceil($total_records / $num_per_page);
        ?>

        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="admin.php?page=<?php echo ($page - 1); ?>">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="admin.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>

        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="admin.php?page=<?php echo ($page + 1); ?>">Next</a>
        </li>
    </ul>
</div>

<?php
include './include/footer.php';
?>
