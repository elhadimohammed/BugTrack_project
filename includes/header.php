<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$baseURL = "/BugTrack_project"; // Adjust to match your actual local folder name
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bug Tracker</title>
    <link rel="stylesheet" href="<?= $baseURL ?>/assets/css/style.css">
</head>
<body>
    <header>
        <h2>🪲 Bug Tracker System</h2>
        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (<?= $_SESSION['role'] ?>)</p>
            <nav>
                <a href="/dashboard.php">Dashboard</a>
                <a href="/auth/logout.php">Logout</a>
            </nav>
        <?php endif; ?>
        <hr>
    </header>
