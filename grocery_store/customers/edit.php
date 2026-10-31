<?php
require "../config/auth.php";
$id = (int)($_GET['id'] ?? $_POST['customer_id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE customers SET full_name=?, email=?, phone=?, address=?, updated_by=?, last_updated=NOW() WHERE customer_id=?");
    $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_SESSION['user_id'], $id]);
    log_action($pdo, 'UPDATE', 'customers', $id, "Updated customer '" . $_POST['full_name'] . "'");
    header("Location: index.php"); exit;
}
$stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id=?");
$stmt->execute([$id]);
$c = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$c) { die("Customer not found."); }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Edit Customer Information</title>
    <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Edit Customer Information</h1>
        <form method="post">
            <input name="full_name" value="<?= htmlspecialchars($c['full_name']) ?>" required>
            <input name="email" type="email" value="<?= htmlspecialchars($c['email']) ?>">
            <input name="phone" value="<?= htmlspecialchars($c['phone']) ?>">
            <input name="address" value="<?= htmlspecialchars($c['address']) ?>">
            <button type="submit">Update</button> <button id="can"><a href="index.php">Cancel</a></button>
        </form>
    </div>
</body>
</html>
