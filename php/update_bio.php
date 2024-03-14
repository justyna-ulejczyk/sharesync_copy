<?php

require_once "connect_db.php";

//session_id("userSession");
session_start();
$bio = $_POST["bio"];
$username = $_SESSION["username"];
session_write_close();

$update_bioSTMT = pg_prepare($conn, "update_bio", "UPDATE accounts SET bio = $1 WHERE username = $2");
$update_bioRESULT = pg_execute($conn, "update_bio", array($bio, $username));

header('Location: ' . "../html/Settings.php");