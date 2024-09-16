<?php
// File: sign.in.up.php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/php_mailer/src/Exception.php';
require '/php_mailer/src/PHPMailer.php';
require '/php_mailer/src/SMTP.php';

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

    // MySQL database connection details
    $host = 'localhost'; // Usually 'localhost' or an IP address
    $dbName = 'mdskenya_comply_tech'; // The name of the database you manually created
    $username = 'mdskenya_malik186'; // Your MySQL username
    $password = 'Malik@Ndoli186'; // Your MySQL password

    // Connect to the MySQL database
    $db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                echo json_encode(['status' => 'error', 'message' => 'Username already in use.']);
                exit;
            }

            // Check if the user already exists
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
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
                $stmt = $db->prepare("INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();

                echo json_encode(['status' => 'success', 'message' => 'User registered successfully.']);

                function sendWelcomeEmail($toEmail, $toName) {
                    $mail = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail->isSMTP();                                    // Send using SMTP
                        $mail->Host       = 'complytech.mdskenya.co.ke';          // Set the SMTP server to send through (use your domain's SMTP)
                        $mail->SMTPAuth   = true;                           // Enable SMTP authentication
                        $mail->Username   = 'no-reply@complytech.mdskenya.co.ke'; // SMTP username
                        $mail->Password   = 'Comply_Tech_186_1999';          // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
                        $mail->Port       = 587;                            // TCP port to connect to

                        //Recipients
                        $mail->setFrom('no-reply@complytech.mdskenya.co.ke', 'ComplyTech Admin');
                        $mail->addAddress($toEmail, $toName);               // Add the recipient's email and name

                        // Content
                        $mail->isHTML(true);                                // Set email format to HTML
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

                // After user registration
                if ($stmt->execute()) {
                    // Send a welcome email
                    if (sendWelcomeEmail($email, $username)) {
                        echo json_encode(['status' => 'success', 'message' => 'User registered successfully. Welcome email sent.']);
                    } else {
                        echo json_encode(['status' => 'success', 'message' => 'User registered successfully, but failed to send welcome email.']);
                    }
                }

            }
        } else {
            // Handle sign-in request
            $identifier = isset($data['email']) ? $data['email'] : $data['phone'];
            $field = isset($data['email']) ? 'email' : 'phone';

            $stmt = $db->prepare("SELECT * FROM users WHERE $field = :identifier");
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Start session and set session variables
                $_SESSION['user'] = [
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    // Add any other user-related data you need to store in the session
                ];

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
