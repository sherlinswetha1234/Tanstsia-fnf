<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'connect.php';

// Include PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email from POST request
    $email = $_POST['email'];

    // Prepare SQL query to check if the email exists
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 1800; // Token valid for 30 minutes

        // Insert or update the reset token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires = VALUES(expires)");

        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('ssi', $email, $token, $expires);
        $stmt->execute();

        // Send the reset link to the user's email
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token"; // Replace with your domain
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = 'From: no-reply@example.com' . "\r\n" .
                   'Reply-To: no-reply@example.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com';                // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;
            $mail->Username   = 'shrlnswetha@gmail.com.com';          // SMTP username
            $mail->Password   = 'mdze trqj vptu eszk';             // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
            $mail->Port       = 587;                               // TCP port to connect to

            // Recipients
            $mail->setFrom('your-email@example.com', 'Mailer');
            $mail->addAddress($email);                            // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Reset link sent to your email address.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Failed to send email. Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email address not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
