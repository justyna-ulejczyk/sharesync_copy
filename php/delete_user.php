<?php
require_once "../php/connect_db.php";

//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit(); // Make sure to exit after redirecting
}
$login_username = $_SESSION["username"];

$stmt = pg_prepare($conn, "delete_query", "DELETE FROM accounts WHERE username = $1");
$results = pg_execute($conn, "delete_query", array($login_username));
if($results){
   
    // Redirect to logout page
    header('Location: ../php/logout_php.php');
    exit();
} else {
    // Handle the case where deletion fails, if necessary
}

pg_close($conn);
?>
