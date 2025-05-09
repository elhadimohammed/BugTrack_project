<?php
// dashboard.php — Welcome Page + Role Check
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <link rel="stylesheet" href="assets/css/style.css">

<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (<?= ucfirst($_SESSION['role']) ?>)</h2>
<ul>
    <?php if ($_SESSION['role'] === 'customer'): ?>
        <li><a href="submitBugReport.php">Submit Bug</a></li>
        <li><a href="viewOwnBugs.php">View My Bugs</a></li>
        <li><a href="viewBugStatus.php">View Bug Status</a></li>
        <li><a href="rateBug.php">rate resolved bug</a></li>
        <li><a href="addComment.php">Add Comment</a></li>
    <?php elseif ($_SESSION['role'] === 'staff'): ?>
        <li><a href="viewAssignedBugs.php">View Assigned Bugs</a></li>
        <li><a href="submitBugSolution.php">submit Bug Solution </a></li>
        <li><a href="resolveBug.php">Mark resolved bug</a></li>
         <li><a href="reassignBug.php">assign to another staff</a></li>
         <li><a href="addComment.php">Add Comment</a></li>
         <li><a href="viewComments.php">view Comments</a></li>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <li><a href="generateBugReport.php">Summary report</a></li>
        <li><a href="bugList.php">view All Bug </a></li>
        <li><a href="manageUsers.php">Manage Users</a></li>
          <li><a href="assignBug.php">assign bug to staff</a></li>
        <li><a href="createProject.php">create Project</a></li>
    <?php endif; ?>
    <li><a href="logout.php">Logout</a></li>
</ul>
</body>
</html>
