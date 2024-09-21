<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $registerAs = mysqli_real_escape_string($conn, $_POST['registerAs']);
    $sector = mysqli_real_escape_string($conn, $_POST['sector']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $productdescription = mysqli_real_escape_string($conn, $_POST['productdescription']);

    // Validate pincode
    if (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $errors[] = "Pincode must be exactly 6 digits.";
    }

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM membreg WHERE email = '$email'";
    $emailResult = mysqli_query($conn, $checkEmailQuery);
    if (mysqli_num_rows($emailResult) > 0) {
        $errors[] = "Email already exists. Try another.";
    }

    // Check if mobile number already exists
    $checkMobileQuery = "SELECT * FROM membreg WHERE mobile = '$mobile'";
    $mobileResult = mysqli_query($conn, $checkMobileQuery);
    if (mysqli_num_rows($mobileResult) > 0) {
        $errors[] = "Mobile number already exists. Try another.";
    }

    // Directory where images will be uploaded
    $targetDir = "uploads/";

    // Ensure the upload directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $uploadedFiles = [];

    // Handle multiple file uploads
    if (isset($_FILES['product_image']['name']) && !empty($_FILES['product_image']['name'][0])) {
        $fileCount = count($_FILES['product_image']['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = basename($_FILES['product_image']['name'][$i]);
            $targetFile = $targetDir . time() . '-' . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
            // Check file size (optional)
            if ($_FILES['product_image']['size'][$i] > 2000000) { // 2MB limit
                $errors[] = "File $fileName is too large.";
                continue;
            }
            
            // Allow certain file formats (optional)
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $errors[] = "File $fileName is not an allowed format.";
                continue;
            }

            // Save the file to the target directory
            if (move_uploaded_file($_FILES['product_image']['tmp_name'][$i], $targetFile)) {
                $uploadedFiles[] = $targetFile;
            } else {
                $errors[] = "Error uploading file $fileName.";
            }
        }
    }

    // Debugging: Check collected file paths
    if (!empty($uploadedFiles)) {
        echo "Uploaded Files: " . implode(', ', $uploadedFiles);
    } else {
        echo "No files uploaded.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $productImage = mysqli_real_escape_string($conn, implode(',', $uploadedFiles)); // Sanitize file paths
        $sql = "INSERT INTO membreg (registerAs, sector, firstName, lastName, email, password, mobile, pincode, district, state, productdescription, product_image)
                VALUES ('$registerAs', '$sector', '$firstName', '$lastName', '$email', '$password', '$mobile', '$pincode', '$district', '$state', '$productdescription', '$productImage')";
        
        // Debugging: Print SQL query
        echo "SQL Query: " . $sql;

        if (mysqli_query($conn, $sql)) {
            // Redirect to success page
            header("Location: success.php");
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
