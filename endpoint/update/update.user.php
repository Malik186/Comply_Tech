<?php
session_start();
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Content-Type: application/json");

// Database connection details
$host = "localhost";
$dbname = "mdskenya_comply_tech";
$username = "mdskenya_malik186";
$password = "Malik@Ndoli186";

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags($data));
}

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

// Get JSON data from the request
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

if ($data === null) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start building the update query
    $query = "UPDATE users SET ";
    $updateFields = [];
    $params = [":username" => $_SESSION['user']['username']];

    // Check each field and add it to the query only if it exists in the incoming data
    $allowedFields = ['email', 'phone', 'avatar', 'street', 'city', 'state', 'post_code'];
    foreach ($allowedFields as $field) {
        if (isset($data[$field]) && $data[$field] !== "") {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = sanitize_input($data[$field]);
        }
    }

    // If no fields to update, exit
    if (empty($updateFields)) {
        echo json_encode(["status" => "error", "message" => "No fields to update"]);
        exit;
    }

    // Complete the query
    $query .= implode(", ", $updateFields);
    $query .= " WHERE username = :username";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    // Update session data if email or phone were updated
    if (isset($data['email'])) {
        $_SESSION['user']['email'] = $data['email'];
    }
    if (isset($data['phone'])) {
        $_SESSION['user']['phone'] = $data['phone'];
    }

    echo json_encode(["status" => "success", "message" => "User information updated successfully"]);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>