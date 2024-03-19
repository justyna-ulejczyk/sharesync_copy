<?php

require_once "connect_db.php";
$username = $_POST["username"];
$privacy = $_POST["privacy"];

$update_groupnameSTMT = pg_prepare($conn, "update_account_visibility", "UPDATE accounts SET accountvisibility = $1 WHERE username = $2");
$update_groupnameRESULT = pg_execute($conn, "update_account_visibility", array($privacy, $username));