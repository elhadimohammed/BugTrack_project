<?php
// db.php — SQL Server ODBC Connection (Using bugadmin)
$dsn = "Driver={SQL Server};Server=localhost\\SQLEXPRESS;Database=BugTrack_project;";
$user = "bugadmin";
$pass = "123456";

$conn = odbc_connect($dsn, $user, $pass);
if (!$conn) {
    die("❌ Connection failed: " . odbc_errormsg());
}
?>