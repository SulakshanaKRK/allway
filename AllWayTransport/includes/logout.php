<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, proceed with logout
    session_destroy();

    // Redirect to the login page or any other desired page
    header("Location: login.php");
    exit();
} else {
    // User is not logged in, redirect to the login page or any other desired page
    header("Location: login.php");
    exit();
}
?>