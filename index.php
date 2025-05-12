<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BugTrack Home</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Welcome to BugTrack</h1>
    <p>Please <a href="auth/login.php">Login</a> or <a href="auth/register.php">Register</a> to continue.</p>
</body>
</html>
