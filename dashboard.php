<?php 
// db.php - Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Sell Products for Slider
$sql = "SELECT imagePath FROM sell";
$result = $conn->query($sql);
$sliderImages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sliderImages[] = $row['imagePath'];
    }
} else {
    $sliderImages = []; // No images available
}

// Handle Buy Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy'])) {
    $productName = $_POST['productName'];
    $productDesc = $_POST['productDesc'];
    $quantity = $_POST['quantity'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO buy (productName, productDesc, quantity, contactNumber, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $productName, $productDesc, $quantity, $contactNumber, $email);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // Ensure no further code is executed after redirection
}

// Handle Sell Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sell'])) {
    $productName = $_POST['sell-product-name'];
    $productDesc = $_POST['sell-product-description'];
    $quantity = $_POST['sell-quantity'];
    $imagePath = "";

    // Handle image upload
    if (!empty($_FILES['sellImages']['name'][0])) {
        $targetDir = "uploads/";
        $imagePath = $targetDir . basename($_FILES['sellImages']['name'][0]);
        move_uploaded_file($_FILES['sellImages']['tmp_name'][0], $imagePath);
    }

    $stmt = $conn->prepare("INSERT INTO sell (productName, productDesc, quantity, imagePath) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $productName, $productDesc, $quantity, $imagePath);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Fetch Buy Products
$buyProducts = $conn->query("SELECT * FROM buy");

// Fetch Sell Products
$sellProducts = $conn->query("SELECT * FROM sell");
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
       /* Basic Reset */
/* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4; /* Light background */
}

/* Overlay Styling */
.overlay {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7); /* Black background with transparency */
    z-index: 1000; /* Sit on top */
}

/* Modal Form Styling */


/* Close Button Styling */
.close-btn {
    cursor: pointer;
    color: #ff0000; /* Red color */
    font-size: 24px;
    float: right;
}

/* Heading Styling */
h3 {
    color: #007bff; /* Blue color */
    margin-bottom: 15px;
}

/* Form Group Styling */
label {
    font-size: 16px;
    color: #333333; /* Black text */
    display: block;
    margin: 10px 0 5px;
}

/* Buy Form Styling */
#buyForm { 
    display: none; /* Hidden by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff; /* White background */
    padding: 15px; /* Reduced padding */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1001; /* Sit on top of the overlay */
    width: 90%; /* Reduced width */
    max-width: 500px; /* Smaller maximum width */
    max-height: 70vh; /* Reduced maximum height */
    overflow-y: auto; /* Enable vertical scrolling if content exceeds height */
}

#buyForm h3 {
    color: #007bff; /* Blue color */
    margin-bottom: 15px; /* Reduced space below the heading */
    text-align: center; /* Center align heading */
    font-size: 20px; /* Smaller heading font size */
}

#buyForm label {
    font-size: 14px; /* Smaller font size */
    color: #333333; /* Black text */
    display: block; /* Ensure labels are on a new line */
    margin: 5px 0; /* Reduced space around labels */
}

#buyForm input[type="text"],
#buyForm input[type="number"],
#buyForm input[type="tel"],
#buyForm input[type="email"],
#buyForm textarea {
    width: calc(100% - 20px); /* Adjusted width for padding */
    padding: 8px; /* Reduced padding */
    margin: 2px 0 10px; /* Reduced space between fields */
    border: 1px solid #007bff; /* Blue border */
    border-radius: 4px;
    font-size: 12px; /* Smaller font size */
}

#buyForm button {
    width: 100%;
    background-color: #007bff; /* Blue background */
    color: white; /* White text */
    padding: 10px; /* Reduced padding */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px; /* Smaller font size */
    transition: background-color 0.3s;
    margin-top: 5px; /* Reduced space above button */
}

#buyForm button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}




    /* Close button styling */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #555; /* Grey color */
    }

    .close-btn:hover {
        color: #000; /* Darker color on hover */
    }
/* Sell Form Styling */
#sellForm {
    display: none; /* Hidden by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff; /* White background */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1001; /* Sit on top of the overlay */
    width: 90%;
    max-width: 500px; /* Maximum width */
}

#sellForm h3 {
    color: #007bff; /* Blue color */
}

#sellForm label {
    font-size: 16px;
    color: #333333; /* Black text */
}

#sellForm input[type="text"],
#sellForm input[type="number"],
#sellForm input[type="file"],
#sellForm textarea {
    width: calc(100% - 20px); /* Adjusted width for padding */
    padding: 10px;
    margin: 5px 0 15px; /* Space between fields */
    border: 1px solid #007bff; /* Blue border */
    border-radius: 4px;
    font-size: 14px;
}

#sellForm button {
    width: 100%;
    background-color: #007bff; /* Blue background */
    color: white; /* White text */
    padding: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

#sellForm button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
.slider-container {
    width: 100%;
    overflow: hidden;
    margin-top: 20px; /* Space between buttons and slider */
}

.slider {
    display: flex;
    transition: transform 2s ease;
}

.slider-item {
    min-width: 25%; /* 100% / 4 = 25% for four images */
    box-sizing: border-box;
    padding: 5px; /* Add some space between images */
}

.slider-item img {
    width: 100%; /* Ensure the image takes the full width of the container */
    height: 200px; /* Set a fixed height for uniformity */
    object-fit: cover; /* Ensures the image covers the area without distortion */
    border-radius: 8px; /* Optional: Add border radius */
}

        .display-sections {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.section {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    flex: 1; /* Makes sections take equal space */
    margin: 0 10px; /* Adds space between sections */
    overflow-y: auto;
}

.section h2 {
    text-align: center;
    color: #007bff; /* Header color */
    margin-bottom: 15px;
}

.submitted-item {
    margin-bottom: 15px; /* Space between items */
    padding: 10px;
    border: 1px solid #007bff; /* Border color */
    border-radius: 4px;
    transition: background-color 0.3s;
}

.submitted-item:hover {
    background-color: #f0f8ff; /* Light blue on hover */
}



    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header-container">
            <div class="logo">
                <img src="logo.jpeg" alt="TFSC Logo">
            </div>
            <div class="header-right">
                <a href="login.php" class="header-link"><strong>LOGIN</strong></a>
                <a href="register.php" class="header-link"><strong>REGISTER</strong></a>
                <i class="phone-icon"></i> +91 99401 02447
                <i class="email-icon"></i> tfsc@tanstiafnf.com
            </div>
        </header>

        <!-- Main Content -->
        <center>
        <main>
            <div class="search-box">
                <input type="text" placeholder="Search for the products">
                <button class="search-btn">Search</button>
            </div>
            <div>
                <button class="buyButton" id="buyButton">To Buy</button>
                <button class="sellButton" id="sellButton">To Sell</button>
            </div>
            <!-- Image Slider Container -->


        </center>
        <!-- Image Slider Container -->
        <div class="slider-container">
     <div class="slider" id="imageSlider">
        <?php
        if (!empty($sliderImages)) {
            foreach ($sliderImages as $imagePath) {
                echo '<div class="slider-item"><img src="' . $imagePath . '" alt="Product Image"></div>';
            }
        } else {
            echo '<p>No images available</p>';
        }
        ?>
      </div>
</div>
    </div>




        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Buy Form Modal -->
        <div id="buyForm" class="modal-form">
            <span class="close-btn" id="closeBuy">&times;</span>
            <form id="requirementForm" method="POST">
                <h3>Buy Product</h3>
                <label for="productName">Product Name:</label><br>
                <input type="text" id="productName" name="productName" required><br><br>

                <label for="productDesc">Product Description:</label><br>
                <textarea id="productDesc" name="productDesc" required></textarea><br><br>

                <label for="quantity">Quantity (min 10):</label><br>
                <input type="number" id="quantity" name="quantity" min="10" required><br><br>

                <label for="contactNumber">Contact Number:</label><br>
                <input type="tel" id="contactNumber" name="contactNumber" required><br><br>

                <label for="email">Email ID:</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <button type="submit" name="buy">Submit Request</button>
            </form>
        </div>

        <!-- Sell Form Modal -->
        <div id="sellForm" class="modal-form">
            <span class="close-btn" id="closeSell">&times;</span>
            <h3>Post Your Product</h3>
            <form id="productForm" method="POST" enctype="multipart/form-data">
                <label for="sell-product-name">Product Name:</label><br>
                <input type="text" id="sell-product-name" name="sell-product-name" required><br><br>

                <label for="sell-product-description">Product Description:</label><br>
                <textarea id="sell-product-description" name="sell-product-description" required></textarea><br><br>

                <label for="sell-quantity">Available Quantity:</label><br>
                <input type="number" id="sell-quantity" name="sell-quantity" required><br><br>

                <label for="sell-images">Images (optional):</label><br>
                <input type="file" id="sellImages" name="sellImages[]" multiple>
        
                <button type="submit" name="sell">Submit Product</button>
            </form>
        </div>
    
        <!-- Display Sections -->
        <div class="display-sections">
            <div class="section" id="requirements-section">
                <h2>Requirements</h2>
                <div id="requirements-list">
                    <?php while ($row = $buyProducts->fetch_assoc()): ?>
                        <div class="submitted-item">
                            <p><strong>Product Name:</strong> <?= $row['productName'] ?></p>
                            <p><strong>Description:</strong> <?= $row['productDesc'] ?></p>
                            <p><strong>Quantity:</strong> <?= $row['quantity'] ?></p>
                            
                        </div>
                    <?php endwhile; ?>
                    
                </div>
               
            </div>
            <div class="section" id="products-section">
                <h2>Available Products</h2>
                <div id="products-list">
                    <?php while ($row = $sellProducts->fetch_assoc()): ?>
                        <div class="submitted-item">
                            <p><strong>Product Name:</strong> <?= $row['productName'] ?></p>
                            <p><strong>Description:</strong> <?= $row['productDesc'] ?></p>
                            <p><strong>Available Quantity:</strong> <?= $row['quantity'] ?></p>
                            
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        </main>

        <!-- Footer -->
        <div class="footer-container">
            <div class="footer-section" id="contact-us">
                <a href ="contactus.php"><h4>Reach Us</h4></a>
                <p >If you have any questions, feel free to reach out to us.</p>
            </div>
            <div class="footer-section" id="about-us">
                <a href="aboutus.html"><h4>About Us</h4></a>
                <p >Learn more about our company and mission.</p>
            </div>
            <div class="footer-section" id="social-media">
                <a href ="feedback.php"><h4>Feedback</h4></a>
                <p >We would like to know your suggestions.</p>
            </div>
        </div>
    </div>
    <script>
let currentIndex = 0; // Current slide index
const slides = document.querySelectorAll('.slider-item'); // Select all slides
const totalSlides = slides.length; // Total number of slides

function showSlide(index) {
    // Calculate the transform value
    const offset = -index * 100; 
    document.querySelector('.slider').style.transform = 'translateX(' + offset + '%)'; // Slide to the selected index
}

// Automatic sliding
setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides; // Loop back to the first slide
    showSlide(currentIndex);
}, 3000); // Change slide every 3 seconds
</script>

<script>
    document.getElementById("buyButton").onclick = function() {
        document.getElementById("buyForm").style.display = "block";
        document.getElementById("overlay").style.display = "block"; // Show overlay
    }

    document.getElementById("sellButton").onclick = function() {
        document.getElementById("sellForm").style.display = "block";
        document.getElementById("overlay").style.display = "block"; // Show overlay
    }

    document.getElementById("closeBuy").onclick = function() {
        document.getElementById("buyForm").style.display = "none";
        document.getElementById("overlay").style.display = "none"; // Hide overlay
    }

    document.getElementById("closeSell").onclick = function() {
        document.getElementById("sellForm").style.display = "none";
        document.getElementById("overlay").style.display = "none"; // Hide overlay
    }

    // Close the modal if overlay is clicked
    document.getElementById("overlay").onclick = function() {
        document.getElementById("buyForm").style.display = "none";
        document.getElementById("sellForm").style.display = "none";
        document.getElementById("overlay").style.display = "none"; // Hide overlay
    }
</script>

</html>
