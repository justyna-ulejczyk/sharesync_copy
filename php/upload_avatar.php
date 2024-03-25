<?php

session_start();
if (!isset($_SESSION["username"])){
    header('Location: '."../html/login.php"); // redirect the user to the register page if they have not already logged in
    exit(); // Stop further execution
}

// Connect to the database
require_once "connect_db.php";

$username = $_SESSION["username"];
$uploaddir = '../profile_pic/';
$uploadfile = $uploaddir . "profile_pic_" . $username . ".png"; 

// Check if the file already exists, if yes, delete it
if (file_exists($uploadfile)) {
    unlink($uploadfile); // Delete the existing file
}

if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadfile)) {
    header ('Location: ../html/Settings.php'); // Return the path to the uploaded image
} else {
    echo "Error uploading file.";
}

header('Location: ' . '/html/settings.php');