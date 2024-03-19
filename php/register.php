<?php
if (isset($_POST['register'])) {
    // Connect to the database
  require_once "connect_db.php";

    // Prepare and execute the SQL statement
    $stmt = pg_prepare($conn, "insert_account", 
    "INSERT INTO accounts (name, username, email, password, typeofaccount) VALUES ($1, $2, $3, $4, $5) RETURNING username");
    
    // Get the form data
    $name = $_POST["name"];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $account_type = $_POST['typeofaccount'];

    // Hash the password
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Execute the SQL statement
    $result = pg_execute($conn, "insert_account", 
    array($name, $username, $email, $password, $account_type));

    // Check the result
    if ($result) {
        echo "New account created successfully!";
        $username = pg_fetch_result($result, 0, 'username');
        
        session_start();
        $_SESSION['username'] = $username;

        // File handling
        $upload_dir = '../profile_pic/';
        $profile_pic_name = "profile_pic_" . $username . ".png";
        $upload_file = $upload_dir . $profile_pic_name;

        // Copy the file reg.png to the desired location
        if (copy('../profile_pic/reg.jpg', $upload_file)) {
            header('Location: ../html/Home.php'); // Redirect to Home page
        } else {
            echo "Error copying file.";
        }

        header('Location: '."../html/Home.php");
    } else {
        echo "Error: " . pg_last_error($conn);
    }

    // Close the connection
    pg_close($conn);
}
