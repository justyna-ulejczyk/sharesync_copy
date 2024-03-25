<?php

require_once "connect_db.php";

$filename = $_POST['filename'];
$groupid = $_POST['groupid'];
$split = $_POST['split'];

if($split==1){
    unlink("../splits/$groupid" . $filename . ".rtf");
$delete_fileSTMT = pg_prepare($conn, "delete_file", "DELETE FROM splitfiles WHERE filename=$1");
$delete_fileRESULT = pg_execute($conn, "delete_file", array(($filename . ".rtf")));
} else{
    unlink("../groups/$groupid/" . $filename . ".rtf");
    $delete_fileSTMT = pg_prepare($conn, "delete_file", "DELETE FROM files WHERE filename=$1");
    $delete_fileRESULT = pg_execute($conn, "delete_file", array(($filename . ".rtf")));
}