<?php
$page_title = 'Change email';
//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit();
}

require_once "../php/connect_db.php";

$username = $_SESSION["username"];

$errors = array();

// Check if name is set in the POST data
if (!isset($_POST["name"]) ) {
    $errors[] = 'Name is required.';
} else {
    // Trim and sanitize the name input
    $name = $_POST["name"];
  
    //  check if the name contains only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors[] = 'Enter a valid name (only letters and spaces are allowed).';
    }
}

// Proceed only if there are no errors
if (empty($errors)) {
    
    
    // Update the name in the database
    $query = pg_prepare($conn, "update_name", "UPDATE accounts SET name= $1 WHERE username = $2");
    $result = pg_execute($conn, "update_name", array($name, $username));
    
    if ($result) {
        header('Location: ../html/settings.php');
        exit();
    } else {
        echo "Error updating record: " . pg_last_error($conn);
        header('Location: ../html/settings.php');
        exit();
    }
} else {
    // Display errors to the user
    echo '<script type="text/JavaScript">alert("';
    foreach ($errors as $msg) {
        echo " - $msg ";
    }
    echo 'Please try again.");</script>';
}

// Close database connection
pg_close($conn);
?>
