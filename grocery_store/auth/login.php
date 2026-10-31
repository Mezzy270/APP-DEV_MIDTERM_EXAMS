<?php
session_start();
require "../config/db.php";

// Already logged in? Skip the login page.
if (isset($_SESSION['user_id'])) {
    header("Location: ../customers/index.php");
    exit;
}

$error = "";
$message = "";
if (($_GET['msg'] ?? '') === 'registered') { $message = "Registration successful! You can now log in."; }
if (($_GET['msg'] ?? '') === 'loggedout')  { $message = "You have been logged out."; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([trim($_POST['email'])]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'] . " " . $user['last_name'];
        header("Location: ../customers/index.php");
        exit;
    } else {
        $error = "Incorrect email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Grocery Store - Login</title>
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <div class="box">
            <h1>Grocery Store</h1>
            <h3>Login</h3>
            <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <?php if ($message): ?><div class="ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>
            <form method="post">
                <input name="email" type="email" placeholder="Email address" required>
                <input name="password" type="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>No account yet? <a href="register.php">Register here</a></p>
        </div>
    </body>
</html>
