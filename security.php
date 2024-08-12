<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: admin_login.php');
    exit(); // Always exit after a header redirect
}

$page = 'sec';
include './include/header.php';
require_once './db/dbcon.php';

// Determine the current page
$num_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $num_per_page;

// Retrieve the search query, sort order, and security kind filter
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
$securityKind = isset($_GET['kind']) ? $_GET['kind'] : '';

// Prepare the SQL statement to search for data in your database
$sql = "SELECT * FROM secinfo";

// If search query or security kind filter is provided, add WHERE clause
$conditions = [];
$params = [];
if (!empty($searchQuery)) {
    $conditions[] = "(name LIKE :searchQuery OR workzone LIKE :searchQuery OR home LIKE :searchQuery OR seckind LIKE :searchQuery OR sex LIKE :searchQuery OR sectype LIKE :searchQuery)";
    $params[':searchQuery'] = '%' . $searchQuery . '%';
}
if (!empty($securityKind)) {
    $conditions[] = "seckind = :securityKind";
    $params[':securityKind'] = $securityKind;
}
if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Add sorting
$sql .= " ORDER BY name " . ($sortOrder === 'DESC' ? 'DESC' : 'ASC');

// Add pagination
$sql .= " LIMIT :start_from, :num_per_page";

$statement = $dbh->prepare($sql);

// Bind parameters
foreach ($params as $key => $value) {
    $statement->bindValue($key, $value);
}
$statement->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$statement->bindValue(':num_per_page', $num_per_page, PDO::PARAM_INT);

// Execute the SQL statement
$statement->execute();

// Fetch the results
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="security.php">Security</a></li>
    </ul>
</div>

<div style="margin-left: 20%; width: 50%; margin-top: 3%;">
    <div class="text-right">
        <button class="btn btn-primary"><a href="add_sec.php" style="color: white;">Add Security</a></button>
    </div>
    <br><br>

    <!-- Sorting and Filtering -->
    <div class="text-right" >
        <form method="GET" action="security.php" class="form-inline"  style="margin-left: 10%; margin-top: 0%;" >
            <input type="hidden" name="page" value="1">
           <!-- <input type="text" name="query" class="form-control mb-2 mr-sm-2" placeholder="Search..." value="<?php echo htmlspecialchars($searchQuery); ?>"> -->
            <select name="sort" class="form-control mb-2 mr-sm-2">
                <option value="ASC" <?php if ($sortOrder === 'ASC') echo 'selected'; ?>>Sort by Name: A to Z</option>
                <option value="DESC" <?php if ($sortOrder === 'DESC') echo 'selected'; ?>>Sort by Name: Z to A</option>
            </select>
            <select name="kind" class="form-control mb-2 mr-sm-2">
                <option value="">All Kinds</option>
                <option value="security" <?php if ($securityKind === 'security') echo 'selected'; ?>>Security</option>
                <option value="teamleader" <?php if ($securityKind === 'teamleader') echo 'selected'; ?>>Team Leader</option>
                <option value="supervisor" <?php if ($securityKind === 'supervisor') echo 'selected'; ?>>Supervisor</option>
            </select>
            <button type="submit" class="btn btn-primary mb-2">Apply</button>
        </form>
    </div>
    <br><br>




    <table class="table table-bordered" id="securityTable" style="margin-left: 10%; margin-top: 0%;">
        <tr>
            <th>Name</th>
            <th>Security Kind</th>
            <th>Picture</th>
            <th>Details</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                <th>Admin</th>
            <?php } ?>
        </tr>
        <?php foreach ($row as $val) { ?>
            <tr>
                <td><?php echo htmlspecialchars($val['name']); ?></td>
                <td><?php echo htmlspecialchars($val['seckind']); ?></td>
                <td><img class="img img-thumbnail" src="uploads/<?php echo htmlspecialchars($val['img']); ?>" width="80"></td>
                <td><a href="detail_sec.php?id=<?php echo $val['id']; ?>" class="btn btn-success"> Details</a></td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                    <td><?php echo htmlspecialchars($val['admin']); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
    <br>
    <br>
    <ul class="pagination" style="margin-left: 55%">
        <?php
        // Calculate the total number of pages
        $count_sql = "SELECT COUNT(*) as total FROM secinfo";
        if ($conditions) {
            $count_sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $count_statement = $dbh->prepare($count_sql);
        foreach ($params as $key => $value) {
            $count_statement->bindValue($key, $value);
        }
        $count_statement->execute();
        $total_records = $count_statement->fetch()['total'];
        $total_pages = ceil($total_records / $num_per_page);
        ?>
        
        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="security.php?page=<?php echo ($page - 1); ?>">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="security.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>

        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="security.php?page=<?php echo ($page + 1); ?>">Next</a>
        </li>
        <li> 
                <!-- Print Button -->
                <div class="text-right" style="margin-left: 50px;">
        <button class="btn btn-secondary" onclick="printTable()">Print</button>
    </div>
</li>
    </ul>
    
</div>

<?php include './include/footer.php'; ?>

<script>
    function printTable() {
        var printContents = document.getElementById('securityTable').outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
