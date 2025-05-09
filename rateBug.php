<?php
// rateBug.php — Customer rates a resolved bug
session_start();
include 'header.php';
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bug_id = $_POST['bug_id'];
    $stars = $_POST['stars'];
    $feedback = trim($_POST['feedback']);
    $cid = $_SESSION['user_id'];

    $sql = "INSERT INTO Ratings (bug_id, customer_id, stars, feedback) VALUES (?, ?, ?, ?)";
    $stmt = odbc_prepare($conn, $sql);
    if (odbc_execute($stmt, [$bug_id, $cid, $stars, $feedback])) {
        echo "✅ Rating submitted. <a href='viewOwnBugs.php'>Back</a>";
    } else {
        echo "❌ Failed to submit rating.";
    }
    exit;
}

$bugs = odbc_exec($conn, "SELECT bug_id, title FROM Bugs WHERE customer_id = " . $_SESSION['user_id'] . " AND status_id = 4"); // 4 = Resolved
?>
<!DOCTYPE html>
<html>
<head><title>Rate Bug</title></head>
<body>
<h2>Rate a Resolved Bug</h2>
<form method="POST">
    <label>Bug:</label>
    <select name="bug_id">
        <?php while ($b = odbc_fetch_array($bugs)): ?>
        <option value="<?= $b['bug_id'] ?>">#<?= $b['bug_id'] ?> - <?= htmlspecialchars($b['title']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <label>Stars (1-5):</label>
    <input type="number" name="stars" min="1" max="5" required><br>
    <textarea name="feedback" placeholder="Write your feedback..."></textarea><br>
    <button type="submit">Submit Rating</button>
</form>
</body>
</html>