
<?php
require 'cfg/dbconnect.php';

session_start();

// Initialize a flag for the modal display
$showModal = false;

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname   = $_POST['firstname'];
    $lastname    = $_POST['lastname'];
    $phonenumber = $_POST['phonenumber'];
    $address      = $_POST['address'];
    $email       = $_POST['email'];
    $password      = $_POST['password'];
    $gender    = $_POST['gender'];

    // MD5 hashing of the password
    $hashed_password = md5($password);

    // Insert new user into the database
    $query = "INSERT INTO client (FirstName, LastName, PhoneNumber, Email, password, Address, Gender) 
    VALUES ('$firstname', '$lastname', '$phonenumber', '$email', '$hashed_password', '$address', '$gender')";

    if ($conn->query($query)) {
        $showModal = true; // Set modal flag
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- == CSS == -->
<link rel="stylesheet" href="cssfolder/SignUp.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<title>Test</title>
</head>
<body>
<div class="container">
            <div class="text">Create Account</div>
            <form action="" method="POST">
                <!-- Section Header -->
                <div class="section-header">Personal Details</div>

                <!-- Form Group -->
                <div class="form-group">
                    <label for="firstname">First Name <span>*</span></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter First Name" required>

                    <label for="lastname">Last Name <span>*</span></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter Last Name" required>

                    <label for="phonenumber">Mobile Number <span>*</span></label>
                    <input type="text" id="phonenumber" name="phonenumber" placeholder="Enter Mobile Number" required>

                    <label for="address">Address <span>*</span></label>
                    <input type="text" id="address" name="address" placeholder="Address" required>

                    <label for="email">Email <span>*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>

                    <label>Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Enter Password" required>

                    <label>Gender <span>*</span></label>
                    <div class="gender-options">
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="Female" required>
                        <label for="female">Female</label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="index.php" class="cancel-btn">Cancel</a>
                    <button type="submit" name="submit" class="submit-btn">Create</button>
                </div>
            </form>
        </div>
</body>
</html>