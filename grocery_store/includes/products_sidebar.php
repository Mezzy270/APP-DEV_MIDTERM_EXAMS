<?php
$sideProducts = $pdo->query("SELECT product_name, price FROM products ORDER BY product_name")->fetchAll(PDO::FETCH_ASSOC);
?>
<aside class="products-side <?= $sideClass ?? '' ?>">
    <h3>🛍️ Products &amp; Prices</h3>
    <ul>
        <?php foreach ($sideProducts as $p): ?>
        <li>
            <span><?= htmlspecialchars($p['product_name']) ?></span>
            <b>₱<?= number_format($p['price'], 2) ?></b>
        </li>
        <?php endforeach; ?>
    </ul>
</aside>
