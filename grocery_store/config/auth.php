<?php
// Include this at the top of every protected page.
session_start();
require __DIR__ . "/db.php";

// Not logged in? Go to the login page.
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Saves who did what (used for insert, update, delete)
function log_action($pdo, $action, $table, $recordId, $details) {
    $stmt = $pdo->prepare("INSERT INTO activity_log (user_id, action, table_name, record_id, details) VALUES (?,?,?,?,?)");
    $stmt->execute([$_SESSION['user_id'], $action, $table, $recordId, $details]);
}
