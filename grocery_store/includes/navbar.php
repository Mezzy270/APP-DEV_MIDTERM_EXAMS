<div class="nav">
    <span class="brand">🛒 Grocery Store</span>
    <span>
        <span class="user">Logged in as <b><?= htmlspecialchars($_SESSION['user_name']) ?></b></span>
        <a href="../customers/index.php">Customers</a>
        <a href="../orders/index.php">Orders</a>
        <a href="../logs/index.php">Activity Log</a>
        <a class="logout" href="../auth/logout.php" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
    </span>
</div>
