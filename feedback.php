<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$dbname = "registration"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (name, company_name, email, mobile, feedback) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $company_name, $email, $mobile, $feedback);

// Set parameters and execute
$name = $_POST['name'];
$company_name = $_POST['company_name']; // Get company name from the form
$email = $_POST['email'];
$mobile = $_POST['mobile']; // Get mobile number from the form
$feedback = $_POST['feedback'];

if ($stmt->execute()) {
    echo "<script>alert('Thank you for your feedback!'); window.location.href='sample.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


