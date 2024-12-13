<?php
session_start();
require 'cfg/dbconnect.php'; // Include your database connection file

// Check if the client is logged in
if (isset($_SESSION['client_id'])) {
    $client_id = $_SESSION['client_id'];
    
    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch client details from the database
    $query = "SELECT * FROM client WHERE ClientID = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    // If no client found, redirect to login or error page
    if (!$client) {
        header('Location: login.php');
        exit();
    }

    // Assign client details to variables
    $first_name = $client['FirstName'];
    $last_name = $client['LastName'];
    $phone_number = $client['PhoneNumber'];
    $email = $client['Email'];
    $address = $client['Address'];
    $gender = $client['Gender'];
    $profile_image = $client['ProfileImage'];

    // Set the profile image path or default if not available
    $profile_pic_path = !empty($profile_image) ? "uploads/Profile-picture/" . $profile_image : "uploads/Profile-picture/default-pfp.jpg";
} else {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="cssfolder/view_profile.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="profile-container">
        <h2>Profile Details</h2>
        <div class="profile-info">
            <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture" class="profile-pic-large" style="width: 250px">
            <p><strong>Name:</strong> <?php echo $first_name . ' ' . $last_name; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone_number; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        </div>

        <!-- Edit Button -->
        <a href="Edit_profile.php" class="edit-profile-button">Edit Profile</a>
    </div>
</body>
</html>