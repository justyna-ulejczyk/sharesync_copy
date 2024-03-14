<?php
require_once "../php/connect_db.php";
//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit(); // Add exit() to prevent further execution
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
$get_groupnameSTMT = pg_prepare($conn, "get_groupname", "SELECT groupname FROM groups where groupid=$1");
$get_groupnameRESULT = pg_execute($conn, "get_groupname", array($groupid));
$row = pg_fetch_assoc($get_groupnameRESULT);
$_SESSION["groupname"] = $row["groupname"];
$groupname = $_SESSION["groupname"];
session_write_close();

// Retrieve text from the form
$text = $_POST['text'];

// Prepare and execute the SQL query
$stmt = pg_prepare($conn, "sent_message", "INSERT INTO groupmessage (username, groupid, text) VALUES ($1, $2, $3) RETURNING groupmessageid");
$result = pg_execute($conn, "sent_message", array($login_username, $groupid, $text));

if ($result) {
    //echo "message created successfully!";
    $messageID = pg_fetch_result($result, 0, 'groupmessageid');
} else {
    echo "Error: " . pg_last_error($conn);
    die();
}

// Close the connection
pg_close($conn);

header("Location: ../html/group-page.php");
exit();
?>
