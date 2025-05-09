<?php
// viewOwnBugs.php — Show All Bugs Submitted by Customer
session_start();
include 'header.php';
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['user_id'];
$sql = "SELECT B.bug_id, B.title, B.severity, BS.status_name, P.project_name, B.created_at
        FROM Bugs B
        JOIN Bug_Statuses BS ON B.status_id = BS.status_id
        JOIN Projects P ON B.project_id = P.project_id
        WHERE B.customer_id = ?";
$stmt = odbc_prepare($conn, $sql);
odbc_execute($stmt, [$customer_id]);
?>
<!DOCTYPE html>
<html>
<head><title>My Bugs</title></head>
<link rel="stylesheet" href="assets/css/style.css">

<body>
<h2>My Submitted Bugs</h2>
<table border="1">
    <tr><th>Bug ID</th><th>Title</th><th>Severity</th><th>Status</th><th>Project</th><th>Created</th></tr>
    <?php while ($row = odbc_fetch_array($stmt)): ?>
        <tr>
            <td><?= $row['bug_id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= $row['severity'] ?></td>
            <td><?= $row['status_name'] ?></td>
            <td><?= $row['project_name'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
