<?php
session_start();

// Handle logout request
if (isset($_GET['logout'])) {
    // Call the logout script
    header("Location: logout.php");
    exit();
}

// Continue with the rest of the login form processing code
// ...

include_once 'dbh.inc.php';

// Process the login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute a database query
    $query = "SELECT * FROM Account WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        // User exists, check password
        $user = mysqli_fetch_assoc($result);
        if ($password == $user["password"]) {
            // Login successful
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['login_time'] = time(); // Store login time in session
            header("Location: ../bookNow.html"); // Redirect to the home page or any other desired page
            exit();
        } else {
            // Login failed - Incorrect password
            echo "Invalid password.";
        }
    } else {
        // Login failed - User not found
        echo "Invalid username.";
    }
}

// Check if the session has expired
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 2)) {
    // Session has expired, destroy the session and redirect to the login page or any other desired page
    session_destroy();
    header("Location: login.php");
    exit();
}
?>