<?php
//session_id("userSession");
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ./login.php');
    exit();
}

require_once "../php/connect_db.php";

// Use the value from the hidden input field
$username = $_POST['username'];

$recipient = $_POST['recipient'];
$text = $_POST['text'];

$stmt = pg_prepare($conn, "sent_message", "INSERT INTO messages (username, recipient, text) VALUES ($1, $2, $3) RETURNING messageID");
$result = pg_execute($conn, "sent_message", array($username, $recipient, $text));

if ($result) {
    //echo "message created successfully!";
    $messageID = pg_fetch_result($result, 0, 'messageID');
//notififcations

$date = date("Y-m-d");
$killTime = new DateTime();
$killTime->modify('+3 weeks');
$mess =  "You got new message from $username!";
$notificationQuery = pg_prepare($conn, "add_notification", 
"INSERT INTO notifications 
(username, timestamp, killtime, notifmessage) 
VALUES ($1, $2, $3, $4) RETURNING notificationID");
$notificationResult = pg_execute($conn, "add_notification",
 array($recipient, $date, $killTime->format('Y-m-d'), $mess));

//end of notifications
    
} else {
    echo "Error: " . pg_last_error($conn);
    die();
}

// Close the connection
pg_close($conn);

header("Location: ../html/Messages.php?id=$recipient");
exit();


?>