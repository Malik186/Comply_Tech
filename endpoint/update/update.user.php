<?php
// File: update.user.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/Exception.php';
require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/PHPMailer.php';
require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/SMTP.php';

// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

try {
    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // MySQL database connection details
    $host = 'localhost'; 
    $dbName = 'mdskenya_comply_tech'; 
    $username = 'mdskenya_malik186'; 
    $password = 'Malik@Ndoli186'; 

    // Connect to the MySQL database
    $db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the request is a multipart form (for file uploads)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
        // Handle avatar upload
        $targetDir = "/home/mdskenya/public_html/comply_tech/endpoint/uploads/avatars/";
        $avatarFileName = basename($_FILES['avatar']['name']);
        $targetFile = $targetDir . $avatarFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image file is a valid image type
        $check = getimagesize($_FILES['avatar']['tmp_name']);
        if ($check === false) {
            echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, & PNG files are allowed.']);
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, file already exists.']);
            $uploadOk = 0;
        }

        // Move the uploaded file to the target directory if no errors
        if ($uploadOk && move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
            // Successfully uploaded the avatar
            $avatarPath = "/uploads/avatars/" . $avatarFileName; // Relative path to store in DB

            // Handle account details update
            if (isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['username'])) {
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $username = $_POST['username'];

                // Update the user's information in the database
                $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, phone = :phone, avatar = :avatar WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':avatar', $avatarPath);

                if ($stmt->execute()) {
                    // Update session data
                    $_SESSION['user']['username'] = $username;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['phone'] = $phone;
                    $_SESSION['user']['avatar'] = $avatarPath;

                    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload avatar.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing avatar.']);
    }
} catch (PDOException $e) {
    logError("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>
