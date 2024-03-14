<?php
require_once("connect_db.php");
//session_id("userSession");
session_start();

// Get the raw POST data
$json_data = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($json_data, true);

$postid = $data['postid'];
$username = $_SESSION['username'];

$postLikesFromUserSTMT = pg_prepare($conn, "postLikesFromUser", "SELECT * FROM usertolikes WHERE postid = $1 AND username = $2");
$postLikesFromUserRESULT = pg_execute($conn, "postLikesFromUser", array($postid, $username));

$postLikesSTMT = pg_prepare($conn, "postLikes", "SELECT * FROM usertolikes WHERE postid = $1");
$postLikesRESULT = pg_execute($conn, "postLikes", array($postid));

$numOfLikes = pg_num_rows($postLikesRESULT);
$isLiked = pg_num_rows($postLikesFromUserRESULT) != 0;

if($isLiked){
    $removeLikeSTMT = pg_prepare($conn, "removeLike", "DELETE FROM usertolikes WHERE postid = $1 AND username = $2");
    $removeLikeRESULT = pg_execute($conn, "removeLike", array($postid, $username));
    $response = ['likesCount' => ($numOfLikes -1)];
} else{
    $addLikeSTMT = pg_prepare($conn, "addLike", "INSERT INTO usertolikes (postid, username) VALUES ($1, $2)");
    $addLikeRESULT = pg_execute($conn, "addLike", array($postid, $username));
    $response = ['likesCount' => ($numOfLikes +1)];
}

// Set the response headers
header('Content-Type: application/json');

// Send the response back to the client
echo json_encode($response);