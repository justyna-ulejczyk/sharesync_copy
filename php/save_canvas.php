<?php

require_once "connect_db.php";

$filename = $_POST['filename'];
$image_data = $_POST['image'];
$base64_image = substr($image_data, strpos($image_data, ',') + 1);
$image = base64_decode($base64_image);
$groupid = $_POST['groupid'];
$split = $_POST['split'];

if($split==1){
file_put_contents("../splits/$groupid/$filename".".png", $image);
$get_filesSTMT = pg_prepare($conn, "insert_file", "INSERT INTO splitfiles (groupid, filename, filetype) VALUES ($1, $2,$3)");
$get_filesRESULT = pg_execute($conn, "insert_file", array($groupid, ($filename . ".png"), ".png"));
} else{
    file_put_contents("../groups/$groupid/$filename".".png", $image);
    $get_filesSTMT = pg_prepare($conn, "insert_file", "INSERT INTO files (groupid, filename, filetype) VALUES ($1, $2,$3)");
    $get_filesRESULT = pg_execute($conn, "insert_file", array($groupid, ($filename . ".png"), ".png"));
}
