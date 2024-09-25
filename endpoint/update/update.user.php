<?php
session_start();
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
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

    // Prepare the update query
    $query = "UPDATE users SET 
              email = :email,
              phone = :phone,
              avatar = :avatar,
              street = :street,
              city = :city,
              state = :state,
              post_code = :post_code
              WHERE username = :username";

    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindParam(":username", $_SESSION['user']['username']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":phone", $data['phone']);
    $stmt->bindParam(":avatar", $data['avatar']);
    $stmt->bindParam(":street", $data['street']);
    $stmt->bindParam(":city", $data['city']);
    $stmt->bindParam(":state", $data['state']);
    $stmt->bindParam(":post_code", $data['post_code']);

    // Execute the query
    $stmt->execute();

    // Update session data
    $_SESSION['user']['email'] = $data['email'];
    $_SESSION['user']['phone'] = $data['phone'];

    echo json_encode(["status" => "success", "message" => "User information updated successfully"]);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>