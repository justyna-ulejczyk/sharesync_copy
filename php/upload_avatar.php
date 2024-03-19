<?php

session_start();
if (! isset($_SESSION["username"])){
    header('Location: '."../html/login.html"); // redirect the user to the register page if they have not already logged in
}
// Connect to the database
require_once "connect_db.php";

$username = $_SESSION["username"];
$uploaddir = '../profile_pic/';
$uploadfile = $uploaddir . "profile_pic_" . $username . ".png"; 
if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadfile)) {
    echo $uploadfile; // Return the path to the uploaded image
} else {
    echo "Error uploading file.";
}

?>