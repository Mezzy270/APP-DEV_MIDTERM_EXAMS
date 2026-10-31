<?php
require "../config/auth.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start at 1 and keep going until we find an unused ID
    $newId = 1;
    $check = $pdo->prepare("SELECT customer_id FROM customers WHERE customer_id = ?");
    $check->execute([$newId]);
    while ($check->fetch()) {
        $newId++;
        $check->execute([$newId]);
    }

    $stmt = $pdo->prepare("INSERT INTO customers (customer_id, full_name, email, phone, address, added_by, updated_by) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$newId, $_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_SESSION['user_id'], $_SESSION['user_id']]);
    log_action($pdo, 'INSERT', 'customers', $newId, "Added customer '" . $_POST['full_name'] . "'");
    header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Add Customer's Information</title>
    <link rel="stylesheet" href="../assets/style.css">
        </head>
    <body>
        <?php include "../includes/navbar.php"; ?>
<div class="page">
        <h1>Add Customer</h1>
        <form method="post">
            <input name="full_name" placeholder="Full name" required>
            <input name="email" type="email" placeholder="Email">
            <input name="phone" placeholder="Phone">
            <input name="address" placeholder="Address">
            <button type="submit">Save Changes</button> 
            <a id="can" href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
