<?php
session_start();
include 'header.php';
include 'db.php';

$sql = "SELECT C.bug_id, C.message, C.is_internal, C.created_at, U.username 
        FROM Comments C
        JOIN Users U ON C.user_id = U.user_id
        ORDER BY C.created_at DESC";

$result = odbc_exec($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Comments</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .comments-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007BFF;
            color: white;
        }

        h2 {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>

<div class="comments-container">
    <h2>📝 All Bug Comments</h2>

    <table>
        <tr>
            <th>Bug ID</th>
            <th>User</th>
            <th>Message</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
        <?php while ($row = odbc_fetch_array($result)): ?>
        <tr>
            <td>#<?= $row['bug_id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
            <td><?= $row['is_internal'] ? 'Internal (Staff)' : 'Customer' ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br><a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
