<?php
// dashboard.php — Welcome Page + Role Check
session_start();
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
<link rel="stylesheet" href="../assets/css/style.css">
<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (<?= ucfirst($_SESSION['role']) ?>)</h2>
<ul>
    <?php if ($_SESSION['role'] === 'customer'): ?>
        <li><a href="bugs/submitBugReport.php">Submit Bug</a></li>
        <li><a href="bugs/viewOwnBugs.php">View My Bugs</a></li>
        <li><a href="bugs/rateBug.php">rate resolved bug</a></li>
        <li><a href="comments/addComment.php">Add Comment</a></li>
    <?php elseif ($_SESSION['role'] === 'staff'): ?>
        <li><a href="bugs/viewAssignedBugs.php">View Assigned Bugs</a></li>
        <li><a href="bugs/submitBugSolution.php">submit Bug Solution </a></li>
        <li><a href="bugs/resolveBug.php">Mark resolved bug</a></li>
         <li><a href="bugs/reassignBug.php">assign to another staff</a></li>
         <li><a href="comments/addComment.php">Add Comment</a></li>
         <li><a href="comments/viewComments.php">view Comments</a></li>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <li><a href="bugs/generateBugReport.php">Summary report</a></li>
        <li><a href="bugs/bugList.php">view All Bug </a></li>
        <li><a href="users/manageUsers.php">Manage Users</a></li>
          <li><a href="bugs/assignBug.php">assign bug to staff</a></li>
        <li><a href="projects/createProject.php">create Project</a></li>
    <?php endif; ?>
    <li><a href="auth/logout.php">Logout</a></li>
</ul>
</body>
</html>
