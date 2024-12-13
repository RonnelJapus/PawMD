<?php
// Function to check if the user is an admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

// Function to redirect to a specific URL
function redirect($url) {
    header("Location: $url");
    exit();
}
?>
