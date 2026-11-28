<?php
// auth.php - Session check for login status
session_start();

// Check if the user is not logged in (no user ID in session)
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php"); // Change to your actual login page path
    exit();
}
?>
