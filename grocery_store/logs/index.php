<?php
require "../config/auth.php";
$logs = $pdo->query("SELECT l.*, CONCAT(u.first_name,' ',u.last_name) AS user_name
                     FROM activity_log l
                     LEFT JOIN users u ON l.user_id = u.user_id
                     ORDER BY l.log_id DESC LIMIT 100")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Grocery Store - Activity Log</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Grocery Store - Activity Log</h1>
        <div class="table-wrap"><table>
            <tr><th>Date &amp; Time</th><th>User</th><th>Action</th><th>Table</th><th>Record ID</th><th>Details</th></tr>
            <?php foreach ($logs as $l): ?>
            <tr>
                <td><?= date('M d, Y h:i:s A', strtotime($l['created_at'])) ?></td>
                <td><?= htmlspecialchars($l['user_name'] ?? '—') ?></td>
                <td><span class="badge <?= strtolower($l['action']) ?>"><?= $l['action'] ?></span></td>
                <td><?= $l['table_name'] ?></td>
                <td><?= $l['record_id'] ?></td>
                <td><?= htmlspecialchars($l['details']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table></div>
    </div>
</body>
</html>
