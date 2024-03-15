<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header('Location: ./login.php');
    exit(); // Exit to prevent further execution
}

// Unset specific session variables
unset($_SESSION["username"]);

// Destroy the session data
session_destroy();

// Redirect to the login page
header('Location: ../html/login.php');
exit(); // Exit to prevent further execution
?>
