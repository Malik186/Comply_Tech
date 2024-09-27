<?php
// File: delete_activity_log.php
session_start();

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

if (!isset($_POST['log_id']) || !isset($_POST['session_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$log_id = $_POST['log_id'];
$session_id = $_POST['session_id'];

// Database connection (reuse the same connection details)
$config = include '/home/mdskenya/config/comply_tech/config.php';

$pdo = new PDO(
    "mysql:host={$config['db_host']};dbname={$config['db_name']}",
    $config['db_username'],
    $config['db_password']
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Delete the log and terminate the session
$stmt = $pdo->prepare("DELETE FROM user_activity_logs WHERE id = :log_id");
$stmt->bindParam(':log_id', $log_id);
$stmt->execute();

// Terminate the session associated with the log (if possible)
// Note: This requires additional implementation if sessions are stored in a database

echo json_encode(['status' => 'success', 'message' => 'Log entry deleted.']);
?>
