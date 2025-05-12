<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = 'customer'; // default role

    $sql = "INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = odbc_prepare($conn, $sql);
    $result = odbc_execute($stmt, [$username, $email, $password, $role]);

    if ($result) {
        echo "✅ Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "❌ Error: " . odbc_errormsg($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>Register</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
</body>
</html>
