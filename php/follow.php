<?php

require_once "../php/connect_db.php";

session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["username"])) {
    header('Location: ./login.php');
    exit();
}

$login_username = $_SESSION["username"];

if (isset($_GET['id'])) {
    $_SESSION["groupid"] = $_GET['id'];
}

$groupid = $_SESSION["groupid"];
$followee = $_GET['name'];

if ($followee == $login_username) {
    echo "You cannot follow yourself.";
    header("Location: ../html/profile.php");
    exit();
}

// Check if the user is already following the followee
$stmtFollowee = pg_prepare($conn, "check_followee", "SELECT followee FROM follows WHERE followee = $1 AND username = $2");
$resultFollowee = pg_execute($conn, "check_followee", array($followee, $login_username));

if ($resultFollowee !== false && pg_num_rows($resultFollowee) > 0) {
    echo "You are already following $followee.";
} else {
    // Insert into follows table
    $stmtFollowers = pg_prepare($conn, "insert_followers", "INSERT INTO follows (username, followee) VALUES ($1, $2)");
    $resultFollowers = pg_execute($conn, "insert_followers", array($login_username, $followee));

    if ($resultFollowers) {
        header("Location: ../html/profile.php?id=$followee");
        exit();
    } else {
        echo "Error: " . pg_last_error($conn);
        exit();
    }
}

// Add to notifications table
$date = date("Y-m-d");
$killTime = new DateTime();
$killTime->modify('+3 weeks');

$mess = "$login_username started following $followee";
$notificationQuery = pg_prepare($conn, "add_notification", "INSERT INTO notifications (username, timestamp, killtime, notifmessage) VALUES ($1, $2, $3, $4) RETURNING notificationID");
$notificationResult = pg_execute($conn, "add_notification", array($login_username, $date, $killTime->format('Y-m-d'), $mess));

if (!$notificationResult) {
    echo "Error: " . pg_last_error($conn);
}

pg_close($conn);
?>
