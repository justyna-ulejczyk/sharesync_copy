<?php
//session_id("userSession");
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ./login.php');
    exit(); // Make sure to exit after redirection to prevent further execution
}

require_once "../php/connect_db.php";

$username = $_SESSION["username"];

# Clear existing variables.
$_SESSION = array();
# Destroy the session.
session_destroy();

# Redirect to the login page.
header('Location: ../html/login.php');
exit(); // Make sure to exit after redirection to prevent further execution
?>
