<?php
// submitBugSolution.php — Staff submits a solution message for a bug
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $solution = trim($_POST['solution']);

    $sql = "INSERT INTO Comments (bug_id, user_id, message, is_internal) VALUES (?, ?, ?, 1)";
    $stmt = odbc_prepare($conn, $sql);

    if (odbc_execute($stmt, [$bug_id, $_SESSION['user_id'], $solution])) {
        echo "✅ Solution submitted. <a href='viewAssignedBugs.php'>Back</a>";
    } else {
        echo "❌ Failed to submit solution.";
    }
    exit;
}

$bugs = odbc_exec($conn, "SELECT bug_id, title FROM Bugs WHERE assigned_to = " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head><title>Submit Bug Solution</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>Submit Solution for Assigned Bug</h2>
<form method="POST">
    <label>Select Bug:</label>
    <select name="bug_id">
        <?php while ($row = odbc_fetch_array($bugs)): ?>
        <option value="<?= $row['bug_id'] ?>">#<?= $row['bug_id'] ?> - <?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <textarea name="solution" placeholder="Describe your solution..." required></textarea><br>
    <button type="submit">Submit Solution</button>
</form>
</body>
</html>
