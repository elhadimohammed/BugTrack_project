<?php
// assignBug.php — Admin assigns bug to a staff member
session_start();
include 'header.php';
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $staff_id = $_POST['staff_id'];

    $sql = "UPDATE Bugs SET assigned_to = ?, status_id = 2 WHERE bug_id = ?"; // 2 = Assigned
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$staff_id, $bug_id])) {
        echo "✅ Bug assigned. <a href='bugList.php'>Back</a>";
    } else {
        echo "❌ Failed to assign bug.";
    }
    exit;
}

$bug_result = odbc_exec($conn, "SELECT bug_id, title FROM Bugs WHERE assigned_to IS NULL");
$staff_result = odbc_exec($conn, "SELECT user_id, username FROM Users WHERE role = 'staff'");
?>
<!DOCTYPE html>
<html>
<head><title>Assign Bug</title></head> 
<link rel="stylesheet" href="assets/css/style.css">
<body>
<h2>Assign Bug</h2>
<form method="POST">
    <label>Select Bug:</label><br>
    <select name="bug_id">
        <?php while ($row = odbc_fetch_array($bug_result)): ?>
        <option value="<?= $row['bug_id'] ?>">#<?= $row['bug_id'] ?> - <?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <label>Assign to Staff:</label><br>
    <select name="staff_id">
        <?php while ($row = odbc_fetch_array($staff_result)): ?>
        <option value="<?= $row['user_id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Assign</button>
</form>
</body>
</html>
