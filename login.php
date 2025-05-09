<?php
// login.php — User Login
session_start();
include 'header.php';
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM Users WHERE email = ? AND password = ?";
    $stmt = odbc_prepare($conn, $sql);
    $exec = odbc_execute($stmt, [$email, $password]);

    if ($exec && $row = odbc_fetch_array($stmt)) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<link rel="stylesheet" href="assets/css/style.css">

<body>
<h2>Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>New user? <a href='register.php'>Register here</a></p>
</body>
</html>
