<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; // Debugging line to confirm connection

// Start session
session_start();

// Check if login form was submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $inputPassword = $_POST['password']; // Capture user input password separately

    // Sanitize email
    $email = $conn->real_escape_string($email);

    // Query to retrieve user details for the given email
    $query = "SELECT id, password FROM membreg WHERE email = '$email'";
    $result = $conn->query($query);

    // Check if any row was returned
    if ($result->num_rows > 0) {
        // Fetch the stored password and ID from the database
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $userId = $row['id'];

        // Direct comparison if passwords are plain text (not secure)
        if ($inputPassword === $storedPassword) {
            // Store user ID in session
            $_SESSION['user_id'] = $userId;

            // Redirect to profile page
            header("Location: sample.html");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "No account found with that email. Please register.";
    }

    $result->free();
}

// Close connection
$conn->close();
?>
