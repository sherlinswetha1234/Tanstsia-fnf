<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-weight: bold;
            background: linear-gradient(135deg, #00aaff, #e2e4e7, orange);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            padding: 30px;
            background-color: white;
            border: 2px solid #87ceeb;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            margin: 100px 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-size: 36px;
            position: relative;
        }

        h1::after {
            content: "";
            display: block;
            width: 50px;
            height: 3px;
            background-color: black;
            margin: 15px auto 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .form-group label span.required {
            color: red;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #87ceeb;
            border-radius: 5px;
            background-color: white;
            font-size: 17px;
            color: #333;
            box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:hover,
        .form-group select:hover {
            border-color: #ffa500;
            box-shadow: 0 0 10px rgba(255, 165, 0, 0.5);
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ffa500;
            box-shadow: 0 0 10px rgba(255, 165, 0, 0.7);
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #ffa500;
            box-shadow: 0 6px 12px rgba(255, 165, 0, 0.5);
        }

        .submit-btn:active {
            background-color: #ff8c00;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(2px);
        }

        .form-group2 {
            display: flex;
            align-items: center;
        }

        .form-group2 input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-group2 label {
            margin: 0;
        }

        .form-group2 a {
            color: #ffa500;
            text-decoration: none;
        }

        .form-group2 a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 16px;
        }

        .nested-dropdown {
            display: none;
            margin-top: 10px;
        }

        .feedback-container {
            display: none;
            margin-top: 10px;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 38px;
            cursor: pointer;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Register</h1>
        <form id="registrationForm" action="connect.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
                <label for="registerAs">Register User As<span class="required">*</span></label>
                <select id="registerAs" name="registerAs" required>
                    <option value="">Select</option>
                    <option value="manufacturer" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'manufacturer') ? 'selected' : ''; ?>>Manufacturer</option>
                    <option value="service" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'service') ? 'selected' : ''; ?>>Service</option>
                    <option value="trader" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'trader') ? 'selected' : ''; ?>>Trader</option>
                    <option value="educational" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'educational') ? 'selected' : ''; ?>>Educational</option>
                    <option value="individual" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'individual') ? 'selected' : ''; ?>>Individual</option>
                    <option value="association" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'association') ? 'selected' : ''; ?>>Association</option>
                    <option value="others" <?php echo (isset($_POST['registerAs']) && $_POST['registerAs'] == 'others') ? 'selected' : ''; ?>>Others</option>
                </select>
                <?php if (isset($errors['registerAs'])): ?>
                    <p class="error"><?php echo $errors['registerAs']; ?></p>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="sector">Sector<span class="required">*</span></label>
                <select id="sector" name="sector" required>
                    <option value="">Please Select</option>
                    <option value="CHEMICAL" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'CHEMICAL') ? 'selected' : ''; ?>>Chemical</option>
                    <option value="ELECTRICAL AND ELECTRONICS" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'ELECTRICAL AND ELECTRONICS') ? 'selected' : ''; ?>>Electrical and Electronics</option>
                    <option value="ENGINEERING" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'ENGINEERING') ? 'selected' : ''; ?>>Engineering</option>
                    <option value="AGRICULTURE" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'AGRICULTURE') ? 'selected' : ''; ?>>Agriculture</option>
                    <option value="HERBAL" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'HERBAL') ? 'selected' : ''; ?>>Herbal</option>
                    <option value="INFORMATION TECHNOLOGY" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'INFORMATION TECHNOLOGY') ? 'selected' : ''; ?>>Information Technology</option>
                    <option value="LEATHER" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'LEATHER') ? 'selected' : ''; ?>>Leather</option>
                    <option value="PACKAGING" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'PACKAGING') ? 'selected' : ''; ?>>Packaging</option>
                    <option value="PLASTIC" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'PLASTIC') ? 'selected' : ''; ?>>Plastic</option>
                    <option value="RUBBER" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'RUBBER') ? 'selected' : ''; ?>>Rubber</option>
                    <option value="SERVIVE & OTHER" <?php echo (isset($_POST['sector']) && $_POST['sector'] == 'SERVIVE & OTHER') ? 'selected' : ''; ?>>Service & Other</option>
                </select>
                <?php if (isset($errors['sector'])): ?>
                    <p class="error"><?php echo $errors['sector']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="firstName">First Name<span class="required">*</span></label>
                <input type="text" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" placeholder="Enter First Name" required>
                <?php if (isset($errors['firstName'])): ?>
                    <p class="error"><?php echo $errors['firstName']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name<span class="required">*</span></label>
                <input type="text" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>" placeholder="Enter Last Name" required>
                <?php if (isset($errors['lastName'])): ?>
                    <p class="error"><?php echo $errors['lastName']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email ID<span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" placeholder="Enter Email ID" required>
                <small id="emailHelp" style="display:none; color:red;">Please enter a valid email id</small>
    <?php if (isset($errors['email'])): ?>
        <p class="error"><?php echo $errors['email']; ?></p>
    <?php endif; ?>
</div>

            <div class="form-group">
                <label for="password">Password<span class="required">*</span></label>
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye eye-icon" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                <small id="passwordHelp" style="display:none; color:red;">Password must be at least 8 characters long and include at least one uppercase letter and one number.</small>
                <?php if (isset($errors['password'])): ?>
                    <p class="error"><?php echo $errors['password']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile No.<span class="required">*</span></label>
                <input type="tel" id="mobile" name="mobile" value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>" placeholder="Enter Mobile No." required>
                <small id="mobileHelp" style="display:none; color:red;">Mobile number must be exactly 10 digits.</small>
                <?php if (isset($errors['mobile'])): ?>
                    <p class="error"><?php echo $errors['mobile']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="pincode">Pincode<span class="required">*</span></label>
                <input type="text" id="pincode" name="pincode" value="<?php echo isset($_POST['pincode']) ? htmlspecialchars($_POST['pincode']) : ''; ?>" placeholder="Enter Pincode" required>
                <small id="pincodeHelp" style="display:none; color:red;">Pincode must be exactly 6 digits.</small>
                <?php if (isset($errors['pincode'])): ?>
                    <p class="error"><?php echo $errors['pincode']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="district">District<span class="required">*</span></label>
                <select id="district" name="district" required>
                <option value="">Please Select</option>
<option value="Ariyalur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Ariyalur') ? 'selected' : ''; ?>>Ariyalur</option>
<option value="Chengalpattu" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Chengalpattu') ? 'selected' : ''; ?>>Chengalpattu</option>
<option value="Chennai" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Chennai') ? 'selected' : ''; ?>>Chennai</option>
<option value="Coimbatore" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Coimbatore') ? 'selected' : ''; ?>>Coimbatore</option>
<option value="Cuddalore" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Cuddalore') ? 'selected' : ''; ?>>Cuddalore</option>
<option value="Dharmapuri" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Dharmapuri') ? 'selected' : ''; ?>>Dharmapuri</option>
<option value="Dindigul" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Dindigul') ? 'selected' : ''; ?>>Dindigul</option>
<option value="Erode" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Erode') ? 'selected' : ''; ?>>Erode</option>
<option value="Kallakurichi" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Kallakurichi') ? 'selected' : ''; ?>>Kallakurichi</option>
<option value="Kanchipuram" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Kanchipuram') ? 'selected' : ''; ?>>Kanchipuram</option>
<option value="Kanyakumari" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Kanyakumari') ? 'selected' : ''; ?>>Kanyakumari</option>
<option value="Karur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Karur') ? 'selected' : ''; ?>>Karur</option>
<option value="Krishnagiri" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Krishnagiri') ? 'selected' : ''; ?>>Krishnagiri</option>
<option value="Madurai" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Madurai') ? 'selected' : ''; ?>>Madurai</option>
<option value="Nagapattinam" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Nagapattinam') ? 'selected' : ''; ?>>Nagapattinam</option>
<option value="Namakkal" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Namakkal') ? 'selected' : ''; ?>>Namakkal</option>
<option value="Nilgiris" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Nilgiris') ? 'selected' : ''; ?>>Nilgiris</option>
<option value="Perambalur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Perambalur') ? 'selected' : ''; ?>>Perambalur</option>
<option value="Pudukkottai" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Pudukkottai') ? 'selected' : ''; ?>>Pudukkottai</option>
<option value="Ramanathapuram" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Ramanathapuram') ? 'selected' : ''; ?>>Ramanathapuram</option>
<option value="Ranipet" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Ranipet') ? 'selected' : ''; ?>>Ranipet</option>
<option value="Salem" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Salem') ? 'selected' : ''; ?>>Salem</option>
<option value="Sivaganga" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Sivaganga') ? 'selected' : ''; ?>>Sivaganga</option>
<option value="Tenkasi" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tenkasi') ? 'selected' : ''; ?>>Tenkasi</option>
<option value="Thanjavur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Thanjavur') ? 'selected' : ''; ?>>Thanjavur</option>
<option value="Theni" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Theni') ? 'selected' : ''; ?>>Theni</option>
<option value="Thiruvallur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Thiruvallur') ? 'selected' : ''; ?>>Thiruvallur</option>
<option value="Thiruvarur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Thiruvarur') ? 'selected' : ''; ?>>Thiruvarur</option>
<option value="Thoothukudi" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Thoothukudi') ? 'selected' : ''; ?>>Thoothukudi</option>
<option value="Tiruchirappalli" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tiruchirappalli') ? 'selected' : ''; ?>>Tiruchirappalli</option>
<option value="Tirunelveli" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tirunelveli') ? 'selected' : ''; ?>>Tirunelveli</option>
<option value="Tirupattur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tirupattur') ? 'selected' : ''; ?>>Tirupattur</option>
<option value="Tiruppur" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tiruppur') ? 'selected' : ''; ?>>Tiruppur</option>
<option value="Tiruvannamalai" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Tiruvannamalai') ? 'selected' : ''; ?>>Tiruvannamalai</option>
<option value="Vellore" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Vellore') ? 'selected' : ''; ?>>Vellore</option>
<option value="Villupuram" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Villupuram') ? 'selected' : ''; ?>>Villupuram</option>
<option value="Virudhunagar" <?php echo (isset($_POST['district']) && $_POST['district'] == 'Virudhunagar') ? 'selected' : ''; ?>>Virudhunagar</option>

                    <!-- Add more districts as needed -->
                </select>
                <?php if (isset($errors['district'])): ?>
                    <p class="error"><?php echo $errors['district']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="state">State<span class="required">*</span></label>
                <select id="state" name="state" required>
                    <option value="">Please Select</option>
                    <option value="Tamil Nadu" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Tamil Nadu') ? 'selected' : ''; ?>>Tamil Nadu</option>
                    
                </select>
                <?php if (isset($errors['state'])): ?>
                    <p class="error"><?php echo $errors['state']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="productDescription">Product Description<span class="required">*</span></label>
                <input type="text" id="productdescription" name="productdescription" placeholder="Describe your products" required></textarea>
            </div>

            <label for="product_image">Product Image:</label><br>
    <input type="file" id="product_images" name="product_image[]" accept="image/*"multiple ><br><br>

       
    
        <button type="submit" class="submit-btn">Register</button>

        </form>
    </div>
    <script>
            const imageInput = document.getElementById('imageInput');
            const preview = document.getElementById('preview');

            // Preview selected images
            imageInput.addEventListener('change', function() {
                preview.innerHTML = ''; // Clear previous images
                const files = imageInput.files;

                if (files.length > 10) {
                    alert('You can only upload up to 10 images.');
                    imageInput.value = ''; // Reset input
                    return;
                }

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px'; // Adjust image size
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            });
        </script>
    



    <script>
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var toggleIcon = document.getElementById('togglePassword');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.add('fa-eye-slash');
            toggleIcon.classList.remove('fa-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.add('fa-eye');
            toggleIcon.classList.remove('fa-eye-slash');
        }
    }

    // Client-side validation for password, pincode, mobile number, and email
    document.querySelector('form').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var passwordHelp = document.getElementById('passwordHelp');
        var passwordValid = /^(?=.*[A-Z])(?=.*\d).{8,}$/.test(password); // At least 8 characters, 1 uppercase, 1 number
        
        var pincode = document.getElementById('pincode').value;
        var pincodeHelp = document.getElementById('pincodeHelp');
        var pincodeValid = /^[0-9]{6}$/.test(pincode); // Pincode validation (6 digits)

        var mobile = document.getElementById('mobile').value;
        var mobileHelp = document.getElementById('mobileHelp');
        var mobileValid = /^[0-9]{10}$/.test(mobile); // Mobile number validation (10 digits)

        var email = document.getElementById('email').value;
        var emailHelp = document.getElementById('emailHelp');
        var emailValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email); // Email format validation

        var isValid = true;

        // Password validation
        if (!passwordValid) {
            passwordHelp.style.display = 'block';
            isValid = false;
        } else {
            passwordHelp.style.display = 'none';
        }

        // Pincode validation
        if (!pincodeValid) {
            pincodeHelp.style.display = 'block';
            isValid = false;
        } else {
            pincodeHelp.style.display = 'none';
        }

        // Mobile validation
        if (!mobileValid) {
            mobileHelp.style.display = 'block';
            isValid = false;
        } else {
            mobileHelp.style.display = 'none';
        }

        // Email validation
        if (!emailValid) {
            emailHelp.style.display = 'block';
            isValid = false;
        } else {
            emailHelp.style.display = 'none';
        }

        // Prevent form submission if any field is invalid
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
 


 </body>
</html>