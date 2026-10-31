<?php
require "../config/auth.php";
$orders = $pdo->query("SELECT o.*, c.full_name,
                              CONCAT(a.first_name,' ',a.last_name) AS added_name,
                              CONCAT(u.first_name,' ',u.last_name) AS updated_name
                       FROM orders o
                       JOIN customers c ON o.customer_id = c.customer_id
                       LEFT JOIN users a ON o.added_by = a.user_id
                       LEFT JOIN users u ON o.updated_by = u.user_id
                       ORDER BY o.order_id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Grocery Store - Orders</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Grocery Store - Order's Information</h1>
        <p><a class="btn" id="ac" href="add.php">+ Add Order</a></p>
        <div class="layout"><div class="main"><div class="table-wrap"><table>
            <tr><th>Order ID</th><th>Customer</th><th>Item</th><th>Quantity</th><th>Total Price</th><th>Order Date</th><th>Added By</th><th>Date &amp; Time Added</th><th>Last Updated By</th><th>Last Updated (Date &amp; Time)</th><th>Actions</th></tr>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td><?= $o['order_id'] ?></td>
                <td><?= htmlspecialchars($o['full_name']) ?></td>
                <td><?= htmlspecialchars($o['item_name']) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= $o['total_price'] ?></td>
                <td><?= $o['order_date'] ?></td>
                <td><?= htmlspecialchars($o['added_name'] ?? '—') ?></td>
                <td><?= date('M d, Y h:i:s A', strtotime($o['date_added'])) ?></td>
                <td><?= htmlspecialchars($o['updated_name'] ?? '—') ?></td>
                <td><?= date('M d, Y h:i:s A', strtotime($o['last_updated'])) ?></td>
                <td><a class="btn" href="edit.php?id=<?= $o['order_id'] ?>">Edit</a>
                <a class="btn del" href="delete.php?id=<?= $o['order_id'] ?>" onclick="return confirm('Delete this order?')">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </table></div></div><?php include "../includes/products_sidebar.php"; ?></div>
    </div>
</body>
</html>
