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
//session_id("groupSession");
//session_start();
// Get passed product genre and assign it to a variable.
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION["groupid"] = $id;
}
$groupid = $_SESSION["groupid"];

// Corrected variable names
$name = $_POST['name'];
$group = $_SESSION['groupid']; // Using session variable directly

// Assuming $conn is properly initialized
$stmt = pg_prepare($conn, "members", "INSERT INTO accountToGroup (username, groupID) VALUES ($1, $2)");
$result = pg_execute($conn, "members", array($name, $group)); // Using $result instead of $result2

