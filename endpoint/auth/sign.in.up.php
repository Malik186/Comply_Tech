<?php
// File: sign.in.up.php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/Exception.php';
require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/PHPMailer.php';
require '/home/mdskenya/public_html/comply_tech/endpoint/auth/php_mailer/src/SMTP.php';

// Allow CORS from the front-end domain
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

// Function to validate the request origin
function validateOrigin() {
    $allowedDomain = 'https://complytech.mdskenya.co.ke';
    
    // Check if the HTTP_REFERER header is set and matches the allowed domain
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        if (strpos($referer, $allowedDomain) !== 0) {
            // Log unauthorized access attempt
            logError("Unauthorized access attempt from: " . $referer);
            // Return an error response
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized domain.']);
            exit;
        }
    } else {
        // If the HTTP_REFERER is not set, reject the request
        logError("Unauthorized access attempt with no referer.");
        echo json_encode(['status' => 'error', 'message' => 'No referer. Unauthorized domain.']);
        exit;
    }
}

try {
    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Validate the request origin
    validateOrigin();

    // Load the database configuration
    $config = include '/home/mdskenya/config/comply_tech/config.php'; // Adjust the path accordingly
    // Connect to the MySQL database using the loaded configuration
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_username'],
        $config['db_password']
    );

     // Set error mode to exceptions
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log received data for debugging
    logError("Received data: " . print_r($data, true));

    // Check if the data contains a password
    if (isset($data['password'])) {
        $password = $data['password'];

        // Handle sign-up request
        if (isset($data['email']) && isset($data['phone']) && isset($data['username'])) {
            $email = $data['email'];
            $phone = $data['phone'];
            $username = $data['username'];

            // Check if the username already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                echo json_encode(['status' => 'error', 'message' => 'Username already in use.']);
                exit;
            }

            // Check if the user already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo json_encode(['status' => 'error', 'message' => 'Email or phone number already in use.']);
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database
                $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $hashedPassword);

                if ($stmt->execute()) {
                    // Prepare email sending function
                    function sendWelcomeEmail($toEmail, $toName) {
                        $mail = new PHPMailer(true);
                        try {
                            //Server settings
                            $mail->isSMTP();
                            $mail->Host       = 'complytech.mdskenya.co.ke';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'no-reply@complytech.mdskenya.co.ke';
                            $mail->Password   = 'Comply_Tech_186_1999';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;

                            //Recipients
                            $mail->setFrom('no-reply@complytech.mdskenya.co.ke', 'ComplyTech Admin');
                            $mail->addAddress($toEmail, $toName);

                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = 'Welcome to ComplyTech!';
                            $mail->Body    = "
                            <h1>Welcome to ComplyTech, $toName!</h1>
                            <p>Thank you for signing up with us. We are thrilled to have you on board!</p>
                            <p>You can now log in and start using your account.</p>
                            <p>Best regards,<br>ComplyTech Team</p>";
                            $mail->AltBody = "Welcome to ComplyTech, $toName! Thank you for signing up with us. We are thrilled to have you on board!";

                            $mail->send();
                            return true;
                        } catch (Exception $e) {
                            logError("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                            return false;
                        }
                    }

                    // Send welcome email
                    if (sendWelcomeEmail($email, $username)) {
                        echo json_encode(['status' => 'success', 'message' => 'User registered successfully. Welcome email sent.']);
                    } else {
                        echo json_encode(['status' => 'success', 'message' => 'User registered successfully, but failed to send welcome email.']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to register user.']);
                }
            }
        } else {
            // Handle sign-in request
            $identifier = isset($data['email']) ? $data['email'] : $data['phone'];
            $field = isset($data['email']) ? 'email' : 'phone';
        
            $stmt = $pdo->prepare("SELECT * FROM users WHERE $field = :identifier");
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($user && password_verify($password, $user['password'])) {
                // Start session and set session variables
                $_SESSION['user'] = [
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'user_id' => $user['id'] // Store user ID in session
                ];
        
                // Capture browser and IP address info
                $browser = $_SERVER['HTTP_USER_AGENT'];
                $ip = $_SERVER['REMOTE_ADDR'];
                $session_id = session_id();
                $login_time = date('Y-m-d H:i:s');
        
                // Insert activity log into the database
                $logStmt = $pdo->prepare("INSERT INTO user_activity_logs (user_id, browser_info, ip_address, login_time, session_id) VALUES (:user_id, :browser_info, :ip_address, :login_time, :session_id)");
                $logStmt->bindParam(':user_id', $user['id']);
                $logStmt->bindParam(':browser_info', $browser);
                $logStmt->bindParam(':ip_address', $ip);
                $logStmt->bindParam(':login_time', $login_time);
                $logStmt->bindParam(':session_id', $session_id);
                $logStmt->execute();
        
                // Debugging output
                logError("Session started. Session variables: " . print_r($_SESSION, true));
        
                echo json_encode(['status' => 'success', 'message' => 'Sign-in successful.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password is required.']);
    }
} catch (PDOException $e) {
    logError("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
