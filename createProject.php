<?php
// createProject.php — Admin creates a new project
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    include 'header.php';
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: auth/login.php");
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    echo "❌ You do not have permission to access this page.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $admin_id = $_SESSION['user_id'];

    $sql = "INSERT INTO Projects (project_name, description, created_by) VALUES (?, ?, ?)";
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$name, $description, $admin_id])) {
        echo "✅ Project created. <a href='dashboard.php'>Back</a>";
    } else {
        echo "❌ Failed: " . odbc_errormsg($conn);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Project</title></head>
<body>
<h2>Create New Project</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Project Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button type="submit">Create</button>
</form>
</body>
</html>
