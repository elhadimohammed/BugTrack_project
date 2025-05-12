<?php
session_start();
include '../includes/header.php';
include("../includes/db.php");

if ($_SESSION['role'] !== 'admin') {
    exit("❌ Access denied. Admins only.");
}

echo "<h2>📊 Bug Tracking Summary Report</h2>";

// 1. Bugs per Project
echo "<h3>🐞 Bugs per Project</h3>";
$sql1 = "SELECT P.project_name, COUNT(B.bug_id) AS bug_count
         FROM Bugs B
         JOIN Projects P ON B.project_id = P.project_id
         GROUP BY P.project_name";
$r1 = odbc_exec($conn, $sql1);
echo "<ul>";
while (odbc_fetch_row($r1)) {
    echo "<li><strong>" . odbc_result($r1, "project_name") . ":</strong> " . odbc_result($r1, "bug_count") . " bugs</li>";
}
echo "</ul>";

// 2. Bugs by Status
echo "<h3>📌 Bugs by Status</h3>";
$sql2 = "SELECT S.status_name, COUNT(B.bug_id) AS total
         FROM Bugs B
         JOIN Bug_Statuses S ON B.status_id = S.status_id
         GROUP BY S.status_name";
$r2 = odbc_exec($conn, $sql2);
echo "<ul>";
while (odbc_fetch_row($r2)) {
    echo "<li><strong>" . odbc_result($r2, "status_name") . ":</strong> " . odbc_result($r2, "total") . "</li>";
}
echo "</ul>";

// 3. Bugs per Staff
echo "<h3>🧑‍💻 Bugs Assigned to Staff</h3>";
$sql3 = "SELECT U.username, COUNT(B.bug_id) AS assigned_bugs
         FROM Bugs B
         JOIN Users U ON B.assigned_to = U.user_id
         WHERE U.role = 'staff'
         GROUP BY U.username";
$r3 = odbc_exec($conn, $sql3);
echo "<ul>";
while (odbc_fetch_row($r3)) {
    echo "<li><strong>" . odbc_result($r3, "username") . ":</strong> " . odbc_result($r3, "assigned_bugs") . " bugs</li>";
}
echo "</ul>";
?>
