<?php
// resolveBug.php — Staff marks bug as resolved
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $sql = "UPDATE Bugs SET status_id = 4, resolved_at = GETDATE() WHERE bug_id = ? AND assigned_to = ?"; // 4 = Resolved
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$bug_id, $_SESSION['user_id']])) {
        echo "✅ Bug resolved. <a href='viewAssignedBugs.php'>Back</a>";
    } else {
        echo "❌ Failed to resolve bug.";
    }
    exit;
}

$bugs = odbc_exec($conn, "SELECT bug_id, title FROM Bugs WHERE assigned_to = " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head><title>Resolve Bug</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>Mark Bug as Resolved</h2>
<form method="POST">
    <label>Select Bug:</label>
    <select name="bug_id">
        <?php while ($row = odbc_fetch_array($bugs)): ?>
        <option value="<?= $row['bug_id'] ?>">#<?= $row['bug_id'] ?> - <?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Mark as Resolved</button>
</form>
</body>
</html>
