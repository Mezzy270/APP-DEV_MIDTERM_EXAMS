<?php
require "../config/auth.php";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT item_name FROM orders WHERE order_id=?");
$stmt->execute([$id]);
$item = $stmt->fetchColumn();

if ($item !== false) {
    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id=?");
    $stmt->execute([$id]);
    log_action($pdo, 'DELETE', 'orders', $id, "Deleted order '$item'");
}
header("Location: index.php");
