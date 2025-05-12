<?php
// manageUsers.php — Admin view & deactivate users
session_start();
include '../includes/header.php';
include '../includes/db.php';



if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['deactivate'])) {
    $uid = $_GET['deactivate'];
    odbc_exec($conn, "UPDATE Users SET status = 'inactive' WHERE user_id = $uid");
    header("Location: manageUsers.php");
    exit;
}

$users = odbc_exec($conn, "SELECT user_id, username, email, role, status FROM Users");
?>
<!DOCTYPE html>
<html>
<head><title>Manage Users</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>User Management</h2>
<table border="1">
<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Action</th></tr>
<?php while ($row = odbc_fetch_array($users)): ?>
<tr>
    <td><?= $row['user_id'] ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['role'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if ($row['status'] === 'active'): ?>
        <a href="?deactivate=<?= $row['user_id'] ?>">Deactivate</a>
        <?php else: ?>Inactive<?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>