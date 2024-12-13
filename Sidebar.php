<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

// Include the database connection
require 'cfg/dbconnect.php';

// Default values for the user
$userName = 'Guest';
$userRole = 'Admin';
$profile_image = 'default-pfp.jpg'; // Default profile image

// Debugging: Check if session variables are set
error_log("Session user_id: " . $_SESSION['user_id'] . ", user_role: " . $_SESSION['user_role']); // Debugging session variables

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the user data from the database
    $stmt = $conn->prepare("SELECT user_firstname, user_lastname, user_type, profile_image FROM users WHERE user_id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the user exists, retrieve their data
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userName = htmlspecialchars($user['user_firstname'] . ' ' . $user['user_lastname']); // Full name
            $userRole = htmlspecialchars($user['user_type']); // User role (e.g., Admin, Employee)
            $profile_image = !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'default-pfp.jpg'; // Fallback to default image
        } else {
            // Debugging message for failed fetch
            error_log("No user found for User ID: $user_id");
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare SQL statement: " . $conn->error);
    }
} else {
    // Handle the case when the session is not set
    error_log("Session user_id not found.");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- == CSS == -->
    <link rel="stylesheet" href="cssfolder/Sidebar.css">

    <!-- == Boxicons CSS == -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <!-- Display the profile image -->
                    <img src="uploads/Profile-picture/<?php echo $profile_image; ?>" alt="Profile Image" />
                </span>

                <div class="text header-text">
                    <span class="name"><?php echo $userName; ?></span> <!-- Display user name -->
                    <span class="profession"><?php echo $userRole; ?></span> <!-- Display user role -->
                </div>
            </div>
            
            <i class='bx bx-menu toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="Dashboard.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="Client.php">
                            <i class='bx bx-book-heart icon'></i>
                            <span class="text nav-text">Client</span>
                        </a>
                    </li>
                    
                    <?php if ($userRole !== 'Vet' && $userRole !== 'Staff'): ?>
                        <li class="nav-link">
                            <a href="Accounts.php">
                                <i class='bx bx-group icon'></i>
                                <span class="text nav-text">Accounts</span>
                            </a>
                        </li>
                    <?php endif; ?>


                    <li class="nav-link">
                        <a href="Appointments.php">
                            <i class='bx bxs-calendar icon'></i>
                            <span class="text nav-text">Appointment</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="Reports.php">
                            <i class='bx bxs-report icon'></i>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="UserProfile.php">
                            <i class='bx bx-face icon'></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="nav-link">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>
</body>
</html>
