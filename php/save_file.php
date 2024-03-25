<?php

require_once "connect_db.php";

$filename = $_POST['filename'];
$content = $_POST['content'];
$groupid = $_POST['groupid'];
$split = $_POST['split'];

if($split==1){
    file_put_contents("../splits/$groupid" . $filename . ".rtf", $content);
$get_filesSTMT = pg_prepare($conn, "get_files", "INSERT INTO splitfiles (groupid, filename, filetype) VALUES ($1, $2,$3)");
$get_filesRESULT = pg_execute($conn, "get_files", array($groupid, ($filename . ".rtf"), ".rtf"));
} else{
    file_put_contents("../groups/$groupid/" . $filename . ".rtf", $content);
    $get_filesSTMT = pg_prepare($conn, "get_files", "INSERT INTO files (groupid, filename, filetype) VALUES ($1, $2,$3)");
    $get_filesRESULT = pg_execute($conn, "get_files", array($groupid, ($filename . ".rtf"), ".rtf"));
}


