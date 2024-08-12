<?php
// Define database connection constants
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('dbname', 'kingforce');

// Establish a database connection
try {
    $dbh = new PDO("mysql:host=".host.";dbname=".dbname, user, pass);
} catch (PDOException $e) {
    echo ("error:".$e->getMessage());
}

