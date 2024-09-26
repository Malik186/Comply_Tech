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
$host = 'localhost';
$dbName = 'mdskenya_comply_tech';
$username = 'mdskenya_malik186';
$password = 'Malik@Ndoli186';
$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Delete the log and terminate the session
$stmt = $db->prepare("DELETE FROM user_activity_logs WHERE id = :log_id");
$stmt->bindParam(':log_id', $log_id);
$stmt->execute();

// Terminate the session associated with the log (if possible)
// Note: This requires additional implementation if sessions are stored in a database

echo json_encode(['status' => 'success', 'message' => 'Log entry deleted.']);
?>
