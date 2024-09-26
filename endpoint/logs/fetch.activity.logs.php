<?php
// File: fetch_activity_logs.php
session_start();

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user']['user_id'];

// Database connection (reuse the same connection details)
$host = 'localhost';
$dbName = 'mdskenya_comply_tech';
$username = 'mdskenya_malik186';
$password = 'Malik@Ndoli186';
$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch user activity logs
$stmt = $db->prepare("SELECT id, browser_info, ip_address, login_time, session_id FROM user_activity_logs WHERE user_id = :user_id ORDER BY login_time DESC");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => 'success', 'logs' => $logs]);
?>
