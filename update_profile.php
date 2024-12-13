<?php
session_start();
require 'cfg/dbconnect.php'; // Include your database connection file

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form was submitted (for updating profile image)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // File upload logic
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
                    if ($stmt->execute()) {
                        // Success - redirect or show success message
                        header('Location: UserProfile.php');
                        exit();
                    } else {
                        echo "Error updating profile image.";
                    }
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            echo "No file uploaded or an error occurred.";
        }
    }
} else {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}
?>
