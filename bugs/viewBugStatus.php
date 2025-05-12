<?php
session_start();
include '../includes/header.php';
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['bug_id'])) {
    $bug_id = intval($_GET['bug_id']);
} elseif (isset($_POST['bug_id'])) {
    $bug_id = intval($_POST['bug_id']);
} else {
    echo "<h3>❌ No bug ID provided.</h3>";
    exit;
}

$sql = "SELECT B.title, B.description, B.severity, S.status_name, B.created_at, B.resolved_at
        FROM Bugs B
        JOIN Bug_Statuses S ON B.status_id = S.status_id
        WHERE B.bug_id = ? AND B.customer_id = ?";

$stmt = odbc_prepare($conn, $sql);
$exec = odbc_execute($stmt, [$bug_id, $_SESSION['user_id']]);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bug Case Flow</title>
<link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .case-flow {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .case-flow h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .case-flow p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <link rel="stylesheet" href="/BugTrack_project - Copy/assets/css/style.css">
<div class="case-flow">
<?php
if ($exec && odbc_fetch_row($stmt)) {
    echo "<h2>✅ Bug Details</h2>";
    echo "<p><strong>Title:</strong> " . odbc_result($stmt, "title") . "</p>";
    echo "<p><strong>Description:</strong> " . odbc_result($stmt, "description") . "</p>";
    echo "<p><strong>Severity:</strong> " . odbc_result($stmt, "severity") . "</p>";
    echo "<p><strong>Status:</strong> " . odbc_result($stmt, "status_name") . "</p>";
    echo "<p><strong>Created At:</strong> " . odbc_result($stmt, "created_at") . "</p>";
    echo "<p><strong>Resolved At:</strong> " . (odbc_result($stmt, "resolved_at") ?: "Pending") . "</p>";
} else {
    echo "<h3>❌ No bug found with this ID, or you do not have permission to view it.</h3>";
}
?>
<br><a href="../dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
