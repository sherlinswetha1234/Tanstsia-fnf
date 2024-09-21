<?php
session_start(); // Start the session to manage session variables

// Check if form is submitted and files are uploaded
if (isset($_FILES['photos'])) {
    // Define a directory to save uploaded files
    $uploadDir = 'uploads/';

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadStatus = 1; // Variable to track if all files are uploaded successfully

    // Loop through each uploaded file
    foreach ($_FILES['photos']['name'] as $key => $fileName) {
        // Get the temporary file path
        $tmpFilePath = $_FILES['photos']['tmp_name'][$key];

        // Make sure we have a file path
        if ($tmpFilePath != "") {
            // Create a unique name for the file to avoid overwriting
            $newFilePath = $uploadDir . uniqid() . '-' . basename($fileName);

            // Move the file to the target directory
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                // File successfully uploaded
                echo "File " . basename($fileName) . " uploaded successfully!<br>";
            } else {
                // If any file fails to upload, set upload status to 0 (fail)
                $uploadStatus = 0;
                echo "Error uploading " . basename($fileName) . "!<br>";
            }
        }
    }

    // Check upload status and redirect accordingly
    if ($uploadStatus) {
        $_SESSION['photoUploaded'] = "true";
        header("Location: register.html?upload=success");
    } else {
        header("Location: register.html?upload=failure");
    }
    exit();
} else {
    echo "No files uploaded.";
}
?>