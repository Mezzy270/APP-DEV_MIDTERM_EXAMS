<?php
require "../config/auth.php";
$id = (int)($_GET['id'] ?? 0);

// Get the details first so we can write them in the activity log
$stmt = $pdo->prepare("SELECT full_name FROM customers WHERE customer_id=?");
$stmt->execute([$id]);
$name = $stmt->fetchColumn();

if ($name !== false) {
    $count = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE customer_id=?");
    $count->execute([$id]);
    $orders = $count->fetchColumn();

    $stmt = $pdo->prepare("DELETE FROM customers WHERE customer_id=?");
    $stmt->execute([$id]);
    log_action($pdo, 'DELETE', 'customers', $id, "Deleted customer '$name' (and $orders order/s)");
}
header("Location: index.php");
