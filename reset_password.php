<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure this path is correct

// Database connection
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if it's a request to send the reset link or reset the password
    if (isset($_POST['email'])) {
        // Sending reset link
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(32)); // Generate a secure token
        $expires = date("U") + 3600; // Token expires in 1 hour

        // Save token and expiration time to the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $email, $token, $expires);
        $stmt->execute();

        // Construct reset link
        $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'shrlnswetha@gmail.com'; // SMTP username
            $mail->Password   = 'mdze trqj vptu eszk'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('your-email@gmail.com', 'Mailer');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "You requested a password reset. Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Reset link has been sent to your email.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    } elseif (isset($_POST['token']) && isset($_POST['password'])) {
        // Resetting password
        $token = $_POST['token'];
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Verify the token
        $query = "SELECT email FROM password_resets WHERE token = ? AND expires >= ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $token, date("U"));
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($email);
            $stmt->fetch();

            // Update the user's password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param('ss', $newPassword, $email);
            $stmt->execute();

            // Remove the reset token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param('s', $token);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Password has been reset successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
        }
    }
}
?>
