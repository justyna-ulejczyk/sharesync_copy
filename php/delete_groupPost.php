<?php
require_once "../php/connect_db.php";
//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
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

$messageid = $_GET['mg'];
$query= pg_prepare($conn, "delete", "DELETE FROM groupmessage WHERE groupmessageid = $1");
$stmt = pg_execute($conn, "delete", array($messageid ));

if ( $stmt) {
        
    // Group deleted successfully
    header('Location: ../html/group-page.php');

} else {
// Error occurred, display an error message
echo "Error executing deletion.";
}

// Close statement
$stmt2 = null;

?>
