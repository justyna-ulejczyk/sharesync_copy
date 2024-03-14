<?php
    session_id("userSession");
    //session_start();
    if (!isset($_SESSION["username"])) {
        header('Location: ' . "register.php");
    }

    require_once "connect_db.php";
    $username = $_SESSION["username"];

    // Prepare the SQL statement with a placeholder for the user ID
    $stmt = pg_prepare($conn, "select_user_profile", "SELECT * FROM accounts WHERE username=$1");
    if ($stmt === false) {
        die("Error preparing statement");
    }
    
    // Execute the prepared statement with the user ID
    $result = pg_execute($conn, "select_user_profile", array($username));
    if ($result === false) {
        die("Error executing statement");
    }
    
    // Check if there are any groups
    if (pg_num_rows($result) > 0) {
        
            $name = $row["username"]; // Check for correct database field name
            
         echo "<h2>{$name}</h2>";
        
        
    } else {
        echo "No groups yet...";
    }
    
    // Close the database connection
    pg_close($conn);
?>
