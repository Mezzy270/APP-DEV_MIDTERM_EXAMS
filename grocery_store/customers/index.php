<?php
require "../config/auth.php";
$customers = $pdo->query("SELECT c.*,
                                 CONCAT(a.first_name,' ',a.last_name) AS added_name,
                                 CONCAT(u.first_name,' ',u.last_name) AS updated_name
                          FROM customers c
                          LEFT JOIN users a ON c.added_by = a.user_id
                          LEFT JOIN users u ON c.updated_by = u.user_id
                          ORDER BY c.customer_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
    <title>Grocery Store - Customer</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
<body>
    <?php include "../includes/navbar.php"; ?>
<div class="page">
    <h1>Grocery Store - Customer's Information</h1>
    <p><a class="btn" id="ac" href="add.php">+ Add Customer</a></p>
        <div class="table-wrap"><table>
        <tr><th>ID</th><th>Full Name</th><th>Email Address</th><th>Phone Number</th><th>Address</th><th>Added By</th><th>Date &amp; Time Added</th><th>Last Updated By</th><th>Last Updated (Date &amp; Time)</th><th>Actions</th></tr>
        <?php foreach ($customers as $c): ?>
            <tr>
                <td><?= $c['customer_id'] ?></td>
                <td><?= htmlspecialchars($c['full_name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['address']) ?></td>
                <td><?= htmlspecialchars($c['added_name'] ?? '—') ?></td>
                <td><?= date('M d, Y h:i:s A', strtotime($c['date_added'])) ?></td>
                <td><?= htmlspecialchars($c['updated_name'] ?? '—') ?></td>
                <td><?= date('M d, Y h:i:s A', strtotime($c['last_updated'])) ?></td>
                <td><a class="btn" id="ed" href="edit.php?id=<?= $c['customer_id'] ?>">Edit</a>
                <a class="btn del" id="de" href="delete.php?id=<?= $c['customer_id'] ?>" onclick="return confirm('Delete this customer and all their orders?')">Delete</a></td>
            </tr>
        <?php endforeach; ?>
        </table></div>
    </div>
</body>
</html>
