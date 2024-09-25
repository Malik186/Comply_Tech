<?php
session_start();
// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=mdskenya_comply_tech", "mdskenya_malik186", "Malik@Ndoli186");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the username from the active session
    if (!isset($_SESSION['user']['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'No active user session found.']);
        exit;
    }
    $username = $_SESSION['user']['username'];

    // Prepare and execute the SQL query to fetch avatar data
    $stmt = $pdo->prepare("SELECT avatar FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['avatar']) {
        // Convert the BLOB data to base64
        $base64Avatar = base64_encode($result['avatar']);
        
        // Prepare the response
        $response = [
            'status' => 'success',
            'data' => [
                'avatar' => $base64Avatar
            ]
        ];
    } else {
        $response = ['status' => 'error', 'message' => 'No avatar found for the current user.'];
    }

    // Send the response as JSON
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>