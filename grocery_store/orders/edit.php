<?php
require "../config/auth.php";
$id = (int)($_GET['id'] ?? $_POST['order_id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE orders SET customer_id=?, item_name=?, quantity=?, total_price=?, order_date=?, updated_by=?, last_updated=NOW() WHERE order_id=?");
    $stmt->execute([$_POST['customer_id'], $_POST['item_name'], $_POST['quantity'], $_POST['total_price'], $_POST['order_date'], $_SESSION['user_id'], $id]);
    log_action($pdo, 'UPDATE', 'orders', $id, "Updated order '" . $_POST['item_name'] . "'");
    header("Location: index.php"); exit;
}
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id=?");
$stmt->execute([$id]);
$o = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$o) { die("Order not found."); }
$customers = $pdo->query("SELECT customer_id, full_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);
$products  = $pdo->query("SELECT product_name, price FROM products ORDER BY product_name")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Edit Order Information</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Edit Order Information</h1>
        <form method="post">
            <select name="customer_id">
                <?php foreach ($customers as $c): ?>
                <option value="<?= $c['customer_id'] ?>" <?= $c['customer_id'] == $o['customer_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="item_name" id="item" list="productList" value="<?= htmlspecialchars($o['item_name']) ?>" autocomplete="off" required>
            <datalist id="productList">
                <?php foreach ($products as $pr): ?>
                <option value="<?= htmlspecialchars($pr['product_name']) ?>">
                <?php endforeach; ?>
            </datalist>
            <input name="quantity" id="qty" type="number" min="1" value="<?= $o['quantity'] ?>" required>
            <input name="total_price" id="total" type="number" step="0.01" value="<?= $o['total_price'] ?>" required>
            <input name="order_date" type="date" value="<?= $o['order_date'] ?>" required>
            <button type="submit">Update</button> <button id="can"><a href="index.php">Cancel</a></button>
        </form>
        <?php $sideClass = 'floating'; include "../includes/products_sidebar.php"; ?>
    </div>
    <script>
        // product name => unit price
        const prices = <?= json_encode(array_column($products, 'price', 'product_name')) ?>;
        const item  = document.getElementById('item');
        const qty   = document.getElementById('qty');
        const total = document.getElementById('total');
        function calc() {
            const p = prices[item.value];
            if (p !== undefined && qty.value) { total.value = (p * qty.value).toFixed(2); }
        }
        item.addEventListener('input', calc);
        qty.addEventListener('input', calc);
    </script>
</body>
</html>
