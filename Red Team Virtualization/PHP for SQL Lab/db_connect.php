<?php
# Change these config variables as needed
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'vuln_db';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
