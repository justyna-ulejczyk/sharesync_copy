
<?php

require_once "../php/connect_db.php";

//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit(); // Make sure to exit after redirecting
}
$login_username = $_SESSION["username"];
session_write_close();
session_id("groupSession");
session_start();
// Get passed product genre and assign it to a variable.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION["groupid"] = $id;
}
$groupid = $_SESSION["groupid"];

// Corrected variable names
$followee = $_GET['name'];
$group = $_SESSION['groupid']; // Using session variable directly

//check if not following user yet
$stmtFollowee = pg_prepare($conn, "check", "SELECT followee FROM follows WHERE followee = $1 AND username = $2");
$stmtEx = pg_execute($conn, "check", array($followee, $login_username));

if($stmtEx !== false) {
    // Check if there are any rows returned
    if(pg_num_rows($stmtEx) > 0) {
        echo "You already follow $followee";
    }else{ if($followee==$login_username){
        echo "you cannot follow yourself...";
        header ("Location: ../html/profile.php");
    }else{

// Assuming $conn is properly initialized
$stmt = pg_prepare($conn, "followers", "INSERT INTO  follows (username, followee) VALUES ($1, $2)");
$result = pg_execute($conn, "followers", array( $login_username, $followee)); // Using $result instead of $result2
if ($result) {
   header ("Location: ../html/profile.php?id=$followee");
} else {
    echo "Error: " . pg_last_error($conn);
    die();
    }}}}
 
 // adding to notifications table 

$date = date("Y-m-d");
$killTime = new DateTime();
$killTime->modify('+3 weeks');

$mess =  "$login_username started following  $followee";
$notificationQuery = pg_prepare($conn, "add_notification", "INSERT INTO notifications 
(username, timestamp, killtime, notifmessage) 
VALUES ($1, $2, $3, $4) RETURNING notificationID");
$notificationResult = pg_execute($conn, "add_notification", array($login_username, $date, $killTime->format('Y-m-d'), $mess));

pg_close($conn);
?>