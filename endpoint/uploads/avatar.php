<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: application/json');

// Database connection 
$config = include '/home/mdskenya/config/comply_tech/config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['user']['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'No active user session found.']);
        exit;
    }
    $username = $_SESSION['user']['username'];

    $stmt = $pdo->prepare("SELECT avatar FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['avatar']) {
        
        $avatarData = $result['avatar'];
        
        // Check if the avatar data already includes the data URI scheme
        if (strpos($avatarData, 'data:image/') !== 0) {
            // If it doesn't, add the data URI scheme
            $avatarData = 'data:image/png;base64,' . $avatarData;
        }

        $response = [
            'status' => 'success',
            'data' => [
                'avatar' => $avatarData
            ]
        ];
    } else {
        $response = ['status' => 'error', 'message' => 'No avatar found for the current user.'];
    }

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>