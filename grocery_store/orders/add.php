<?php
require "../config/auth.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start at 1 and keep going until we find an unused ID
    $newId = 1;
    $check = $pdo->prepare("SELECT order_id FROM orders WHERE order_id = ?");
    $check->execute([$newId]);
    while ($check->fetch()) {
        $newId++;
        $check->execute([$newId]);
    }

    $stmt = $pdo->prepare("INSERT INTO orders (order_id, customer_id, item_name, quantity, total_price, order_date, added_by, updated_by) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([$newId, $_POST['customer_id'], $_POST['item_name'], $_POST['quantity'], $_POST['total_price'], $_POST['order_date'], $_SESSION['user_id'], $_SESSION['user_id']]);
    log_action($pdo, 'INSERT', 'orders', $newId, "Added order '" . $_POST['item_name'] . "'");
    header("Location: index.php"); exit;
}
$customers = $pdo->query("SELECT customer_id, full_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);
$products  = $pdo->query("SELECT product_name, price FROM products ORDER BY product_name")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Order</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Add Order</h1>
        <form method="post">
            <select name="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $c): ?>
                <option value="<?= $c['customer_id'] ?>"><?= htmlspecialchars($c['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="item_name" id="item" list="productList" placeholder="Item name (pick from the list)" autocomplete="off" required>
            <datalist id="productList">
                <?php foreach ($products as $pr): ?>
                <option value="<?= htmlspecialchars($pr['product_name']) ?>">
                <?php endforeach; ?>
            </datalist>
            <input name="quantity" id="qty" type="number" min="1" placeholder="Quantity" required>
            <input name="total_price" id="total" type="number" step="0.01" placeholder="Total price" required>
            <input name="order_date" type="date" required>
            <button type="submit">Save Changes</button>
            <a id="can" href="index.php">Cancel</a>
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
