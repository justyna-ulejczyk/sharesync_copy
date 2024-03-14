<?php
# Set page title and display header section.
$page_title = 'Change email';
//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit();
}

require_once "../php/connect_db.php";

$username = $_SESSION["username"];
// Prepare and execute the SQL statement

# Initialize an error array.

$errors = array();

if (!empty($_POST['email1']) && !empty($_POST['email2'])) {
    $email1 = trim($_POST['email1']);
    $email2 = trim($_POST['email2']);

    if ($email1 != $email2) {
        $errors[] = 'Email addresses do not match.';
    } elseif (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter correct email.';
    } else {
        
        $email =  $_POST['email1'];
        
    }
} else {
    $errors[] = 'Both email fields are required.';
}





# On success update email in 'accounts' database table.
if (empty($errors)) {
    $query = pg_prepare($conn, "update_email", "UPDATE accounts SET email = $1 WHERE username = $2");
    $result = pg_execute($conn, "update_email", array($email, $username));
    
    if ($result) {
        header('Location: ../html/settings.php');
        exit();
    } else {
        echo "Error updating record: " . pg_last_error($conn);
        header('Location: ../html/settings.php');
        exit();
    }
} else {
    echo '<script type="text/JavaScript">alert("';
    foreach ($errors as $msg) {
        echo " - $msg ";
    }
    echo 'Please try again.");</script>';
}

# Close database connection.
pg_close($conn);

?>
