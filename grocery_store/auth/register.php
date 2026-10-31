<?php
session_start();
require "../config/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../customers/index.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first   = trim($_POST['first_name']);
    $last    = trim($_POST['last_name']);
    $age     = (int)$_POST['age'];
    $address = trim($_POST['address']);
    $email   = trim($_POST['email']);
    $pass    = $_POST['password'];

    // Check if the email is already used
    $check = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($age < 1) {
        $error = "Please enter a valid age.";
    } elseif (strlen($pass) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($pass !== $_POST['confirm_password']) {
        $error = "Passwords do not match.";
    } elseif ($check->fetch()) {
        $error = "That email is already registered.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,age,address,email,password) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$first, $last, $age, $address, $email, password_hash($pass, PASSWORD_DEFAULT)]);
        header("Location: login.php?msg=registered");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Grocery Store - Register</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <div class="box">
            <h1>Grocery Store</h1>
            <h3>Create an Account</h3>
            <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form method="post">
                <input name="first_name" placeholder="First name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                <input name="last_name" placeholder="Last name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                <input name="age" type="number" min="1" placeholder="Age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
                <input name="address" placeholder="Address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
                <input name="email" type="email" placeholder="Email address" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <input name="password" type="password" placeholder="Password (min. 6 characters)" required>
                <input name="confirm_password" type="password" placeholder="Confirm password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </body>
</html>
