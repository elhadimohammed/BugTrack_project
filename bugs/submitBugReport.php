<?php
// submitBugReport.php — Customer Submits Bug with Optional Attachment
session_start();
include '../includes/header.php';
include '../includes/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $severity = $_POST['severity'];
    $project_id = intval($_POST['project_id']);
    $customer_id = $_SESSION['user_id'];
    $created_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO Bugs (title, description, severity, status_id, customer_id, project_id, created_at) VALUES (?, ?, ?, 1, ?, ?, ?)";
    $stmt = odbc_prepare($conn, $sql);
    $exec = odbc_execute($stmt, [$title, $description, $severity, $customer_id, $project_id, $created_at]);

    if ($exec) {
        $bug_id = odbc_exec($conn, "SELECT @@IDENTITY AS bug_id");
        $bug_row = odbc_fetch_array($bug_id);
        $bug_id_value = $bug_row['bug_id'];

        if (!empty($_FILES['attachment']['name'])) {
            $file_name = basename($_FILES['attachment']['name']);
            $upload_path = 'uploads/' . time() . '_' . $file_name;

            if (!is_dir('uploads')) mkdir('uploads');

            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $upload_path)) {
                $a_sql = "INSERT INTO Attachments (bug_id, file_path) VALUES (?, ?)";
                $a_stmt = odbc_prepare($conn, $a_sql);
                odbc_execute($a_stmt, [$bug_id_value, $upload_path]);
            }
        }

        echo "✅ Bug report submitted! <a href='submitBugReport.php'>Submit another</a>";
    } else {
        echo "❌ Submission failed: " . odbc_errormsg($conn);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Submit Bug</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>Submit Bug Report</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Bug Title" required><br>
    <textarea name="description" placeholder="Describe the issue..." required></textarea><br>
    <select name="severity" required>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select><br>
    <input type="number" name="project_id" placeholder="Project ID" required><br>
    <input type="file" name="attachment"><br>
    <button type="submit">Submit</button>
</form>
</body>
</html>
