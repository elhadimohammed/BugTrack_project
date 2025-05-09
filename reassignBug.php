<?php
// reassignBug.php — Staff reassigns bug to another staff
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $new_staff_id = $_POST['new_staff'];

    $sql = "UPDATE Bugs SET assigned_to = ?, status_id = 2 WHERE bug_id = ? AND assigned_to = ?";
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$new_staff_id, $bug_id, $_SESSION['user_id']])) {
        echo "✅ Bug reassigned. <a href='viewAssignedBugs.php'>Back</a>";
    } else {
        echo "❌ Reassignment failed.";
    }
    exit;
}

$bugs = odbc_exec($conn, "SELECT bug_id, title FROM Bugs WHERE assigned_to = " . $_SESSION['user_id']);
$staff = odbc_exec($conn, "SELECT user_id, username FROM Users WHERE role = 'staff' AND user_id != " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head><title>Reassign Bug</title></head>
<body>
<h2>Reassign Bug</h2>
<form method="POST">
    <label>Select Bug:</label>
    <select name="bug_id">
        <?php while ($row = odbc_fetch_array($bugs)): ?>
        <option value="<?= $row['bug_id'] ?>">#<?= $row['bug_id'] ?> - <?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <label>Reassign to:</label>
    <select name="new_staff">
        <?php while ($s = odbc_fetch_array($staff)): ?>
        <option value="<?= $s['user_id'] ?>"><?= htmlspecialchars($s['username']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Reassign</button>
</form>
</body>
</html>