<?php
// addComment.php — Staff or Customer adds a comment to a bug
session_start();
include '../includes/header.php';
include '../includes/db.php';


if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['customer', 'staff'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $message = trim($_POST['message']);
    $is_internal = ($_SESSION['role'] === 'staff') ? 1 : 0;

    $sql = "INSERT INTO Comments (bug_id, user_id, message, is_internal) VALUES (?, ?, ?, ?)";
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$bug_id, $_SESSION['user_id'], $message, $is_internal])) {
        echo "✅ Comment posted. <a href='../bugs/bugList.php'>Back</a>";
    } else {
        echo "❌ Failed to post comment.";
    }
    exit;
}

$bug_result = odbc_exec($conn, "SELECT bug_id, title FROM Bugs");
?>
<!DOCTYPE html>
<html>
<head><title>Add Comment</title></head>
<link rel="stylesheet" href="../assets/css/style.css">
<body>
<h2>Add Comment</h2>
<form method="POST">
    <label>Select Bug:</label>
    <select name="bug_id">
        <?php while ($row = odbc_fetch_array($bug_result)): ?>
        <option value="<?= $row['bug_id'] ?>">#<?= $row['bug_id'] ?> - <?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <textarea name="message" placeholder="Enter your comment" required></textarea><br>
    <button type="submit">Post Comment</button>
</form>
</body>
</html>
