<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location:admin_login.php');
    exit();
}

$page = 'zone';
include './include/header.php';
require_once './db/dbcon.php';

// Determine the current page
$num_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $num_per_page;

// Get the selected city filter and search query
$selected_city = isset($_GET['city']) ? $_GET['city'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch records with pagination, filtering, and search
$sql = "SELECT * FROM zone WHERE 1=1";
if ($selected_city) {
    $sql .= " AND city = :city";
}
if ($search_query) {
    $sql .= " AND zone_name LIKE :search_query";
}
$sql .= " LIMIT :start_from, :num_per_page";

$statement = $dbh->prepare($sql);
if ($selected_city) {
    $statement->bindValue(':city', $selected_city, PDO::PARAM_STR);
}
if ($search_query) {
    $statement->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
}
$statement->bindValue(':start_from', $start_from, PDO::PARAM_INT);
$statement->bindValue(':num_per_page', $num_per_page, PDO::PARAM_INT);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch all cities for the filter dropdown
$cities_sql = "SELECT DISTINCT city FROM city";
$cities_statement = $dbh->prepare($cities_sql);
$cities_statement->execute();
$cities = $cities_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="margin-left: 18.5%; width: 80%;">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="Home_Dashboard.php">Home</a></li>
        <li class="breadcrumb-item active"><a href="zone.php">Zone</a></li>
    </ul>
</div>

<div style="margin-left: 20%; width: 50%; margin-top: 5%;">
    <div class="text-right">
        <button class="btn btn-primary"><a href="add_zone.php" style="color: white;">Add Zone</a></button>
    </div>
    <form method="GET" action="zone.php" style="margin-left: 10%; margin-top: 5%; display: flex; gap: 10px; align-items: flex-end;">
        <div class="form-group" style="flex: 1;">
            <label for="city">Filter by City:</label>
            <select name="city" id="city" class="form-control" onchange="this.form.submit()">
                <option value="">All Cities</option>
                <?php foreach ($cities as $city) { ?>
                    <option value="<?php echo htmlspecialchars($city['city']); ?>" <?php echo ($selected_city === $city['city']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($city['city']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group" style="flex: 2;">
            <label for="search">Search Zone Name:</label>
            <input type="text" name="search" id="search" class="form-control" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Enter zone name">
        </div>
        <button type="submit" class="btn btn-secondary" style="margin-bottom: 17px;">Search</button>
    </form>

    <div id="print-header" style="text-align: center; display: none;">
        <div>King Force Company</div>
        <div id="print-datetime"></div>
    </div>
    <table id="data-table" class="table table-bordered" style="margin-left: 10%; margin-top: 5%;">
        <tr>
            <th>City Name</th>
            <th>Zone Name</th>
            <th>Car in here</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                <th class="no-print">Delete</th>
                <th class="no-print">Update</th>
            <?php } ?>
        </tr>
        <?php foreach ($row as $val) { ?>
            <tr>
                <td><?php echo htmlspecialchars($val['city']); ?></td>
                <td><?php echo htmlspecialchars($val['zone_name']); ?></td>
                <td><?php echo htmlspecialchars($val['car_name']); ?></td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                    <td class="no-print"><a href="delete_zone.php?id=<?php echo $val['id']; ?>" class="btn btn-danger">Delete</a></td>
                    <td class="no-print"><a href="edit_zone.php?id=<?php echo $val['id']; ?>" class="btn btn-info">Edit</a></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>

    <!-- Pagination Links -->
    <ul class="pagination" style="margin-left: 55%;">
        <?php
        // Calculate the total number of pages
        $count_sql = "SELECT COUNT(*) as total FROM zone WHERE 1=1";
        if ($selected_city) {
            $count_sql .= " AND city = :city";
        }
        if ($search_query) {
            $count_sql .= " AND zone_name LIKE :search_query";
        }
        $count_statement = $dbh->prepare($count_sql);
        if ($selected_city) {
            $count_statement->bindValue(':city', $selected_city, PDO::PARAM_STR);
        }
        if ($search_query) {
            $count_statement->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
        }
        $count_statement->execute();
        $total_records = $count_statement->fetch()['total'];
        $total_pages = ceil($total_records / $num_per_page);
        ?>

        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="zone.php?page=<?php echo ($page - 1); ?>&city=<?php echo urlencode($selected_city); ?>&search=<?php echo urlencode($search_query); ?>">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="zone.php?page=<?php echo $i; ?>&city=<?php echo urlencode($selected_city); ?>&search=<?php echo urlencode($search_query); ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>

        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="zone.php?page=<?php echo ($page + 1); ?>&city=<?php echo urlencode($selected_city); ?>&search=<?php echo urlencode($search_query); ?>">Next</a>
        </li>
        <li> <button class="btn btn-secondary" onclick="printTable()" style="margin-left: 50px;">Print</button></li>
    </ul>
</div>

<?php
include './include/footer.php';
?>

<script>
function printTable() {
    document.getElementById('print-header').style.display = 'block';
    document.getElementById('print-datetime').innerText = 'Date: ' + new Date().toLocaleDateString() + ' Time: ' + new Date().toLocaleTimeString();

    var printContents = document.getElementById('data-table').outerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = document.getElementById('print-header').outerHTML + printContents;
    window.print();
    document.body.innerHTML = originalContents;
    document.getElementById('print-header').style.display = 'none';
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #data-table, #data-table th:not(.no-print), #data-table td:not(.no-print) {
        visibility: visible;
    }
    #data-table {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn, .form-group, .no-print, .breadcrumb {
        display: none;
    }
    #print-header {
        display: block !important;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
}
</style>
