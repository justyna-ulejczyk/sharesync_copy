<?php
require_once "../php/connect_db.php";
//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
}
$login_username = $_SESSION["username"];



session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
}


require_once "../php/connect_db.php";

$username = $_SESSION["username"];
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $account_username = $id;
}

$query= pg_prepare($conn, "delete", "DELETE FROM follows WHERE followee = $1 AND username = $2");
$stmt = pg_execute($conn, "delete", array($account_username,$login_username ));

if ( $stmt) {
        
    // Group deleted successfully
    header("Location: ../html/profile.php?id=$account_username");

} else {
// Error occurred, display an error message
echo "Error executing deletion.";
}

// Close statement
$stmt = null;
pg_close($conn);
?>