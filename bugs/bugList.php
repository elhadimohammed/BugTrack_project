<?php
// bugList.php — Admin views all bug reports
session_start();
include '../includes/header.php';
include '../includes/db.php';



if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$sql = "SELECT B.bug_id, B.title, B.severity, BS.status_name, U.username AS customer_name, P.project_name
        FROM Bugs B
        JOIN Bug_Statuses BS ON B.status_id = BS.status_id
        JOIN Users U ON B.customer_id = U.user_id
        JOIN Projects P ON B.project_id = P.project_id";
$stmt = odbc_prepare($conn, $sql);
odbc_execute($stmt, []);
?>
<!DOCTYPE html>
<html>
<head><title>All Bug Reports</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>All Reported Bugs</h2>
<table border="1">
<tr><th>ID</th><th>Title</th><th>Severity</th><th>Status</th><th>Customer</th><th>Project</th></tr>
<?php while ($row = odbc_fetch_array($stmt)): ?>
<tr>
    <td><?= $row['bug_id'] ?></td>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td><?= $row['severity'] ?></td>
    <td><?= $row['status_name'] ?></td>
    <td><?= htmlspecialchars($row['customer_name']) ?></td>
    <td><?= $row['project_name'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>