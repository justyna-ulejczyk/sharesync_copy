<?php
session_start();
require_once 'connect_db.php'; // Corrected the file extension


    $query = "SELECT username FROM accounts";
    $result = pg_query($conn, $query);

    $upload_dir = '../profile_pic/'; //i know that exists, as it is temp funcion
    $copyNeeded = true; // Flag to track if file copy is needed
    while ($row = pg_fetch_assoc($result)) {
        $username = $row['username'];
        echo "$username";
        // File handling
        $profile_pic_name = "profile_pic_" . $username . ".png";
        $upload_file = $upload_dir . $profile_pic_name;

        if (!file_exists($upload_file)) {
            
     // Copy the file reg.jpg to the desired location for all users who don't have it
        if (copy('../profile_pic/reg.jpg', $upload_file)) {
            echo "Files copied for users who didn't have it."; // Redirect to Home page
            exit; // Exit to prevent further execution
        } else {
            echo "Error copying file.";
        }
    }

}
?>


