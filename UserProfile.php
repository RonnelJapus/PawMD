<?php
session_start();
require 'cfg/dbconnect.php'; // Include your database connection file

// Default values
$userName = 'Guest';
$userRole = 'Admin';
$profile_image = 'uploads/Profile-picture/default-pfp.jpg'; // Default profile image if not available

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If no user found, redirect to login or error page
    if (!$user) {
        header('Location: login.php');
        exit();
    }

    // Assign user details to variables
    $userFirstName = $user['user_firstname'];
    $userLastName = $user['user_lastname'];
    $userEmail = $user['user_email'];
    $profile_image = $user['profile_image'];

    // Set the profile image path or default if not available
    $profile_pic_path = !empty($profile_image) ? "uploads/Profile-picture/" . $profile_image : "uploads/Profile-picture/default-pfp.jpg";
    
    // Check if the form was submitted (for updating profile image and user information)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle profile image update
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $upload_dir = "uploads/Profile-picture/";
            $file_name = basename($_FILES['profile_image']['name']);
            $file_path = $upload_dir . $file_name;

            // Ensure file is an image and has a valid extension
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions)) {
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path)) {
                    // Update the database with the new profile image
                    $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
                    $stmt->bind_param("si", $file_name, $user_id);
                    $stmt->execute();
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        }

        // Handle user information update
        if (isset($_POST['user_firstname']) && isset($_POST['user_lastname']) && isset($_POST['user_email'])) {
            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $user_email = $_POST['user_email'];

            // Update user information in the database
            $stmt = $conn->prepare("UPDATE users SET user_firstname = ?, user_lastname = ?, user_email = ? WHERE user_id = ?");
            $stmt->bind_param("sssi", $user_firstname, $user_lastname, $user_email, $user_id);
            $stmt->execute();
        }

        // Redirect after the update
        header('Location: UserProfile.php');
        exit();
    }
} else {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<?php include "Sidebar.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- == CSS == -->
<link rel="stylesheet" href="cssfolder/UserProfile.css">

<!-- == Boxicons CSS == -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<body>
<section class="home">
    <div class="text">Profile</div>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="#">Home</a>
        <span>/</span>
        <span>Profile</span>
    </nav>

    <div class="profile-info-container">
        <!-- Profile Image Section -->
        <div class="profile-image-container">
            <h2>Update Profile Image</h2>
            <!-- Profile Image Display -->
            <img src="<?php echo htmlspecialchars($profile_pic_path); ?>" alt="Profile Image" width="150" height="150">

            <!-- Form to update profile image -->
            <form action="UserProfile.php" method="POST" enctype="multipart/form-data">
                <label for="profile_image">Choose a profile image:</label>
                <input type="file" name="profile_image" id="profile_image" required>
                <button type="submit" class="submit-btn">Update Profile Image</button>
            </form>
        </div>

        <!-- User Info Form Section -->
        <div class="user-info-container">
            <h2>Update Your Information</h2>
            <form action="UserProfile.php" method="POST">
                <div class="input-group">
                    <label for="user_firstname">First Name</label>
                    <input type="text" name="user_firstname" id="user_firstname" value="<?php echo $userFirstName; ?>" required>
                </div>

                <div class="input-group">
                    <label for="user_lastname">Last Name</label>
                    <input type="text" name="user_lastname" id="user_lastname" value="<?php echo $userLastName; ?>" required>
                </div>

                <div class="input-group">
                    <label for="user_email">Email</label>
                    <input type="email" name="user_email" id="user_email" value="<?php echo $userEmail; ?>" required>
                </div>

                <button type="submit" class="submit-btn">Update Information</button>
            </form>
        </div>
    </div>
</section>
</body>
</html>

<script src="scriptToggle.js"></script>
