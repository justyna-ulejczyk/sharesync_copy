<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "register.php");
    exit(); // Ensure script stops execution after redirection
}

require_once "connect_db.php";

if (isset($_POST['delete_comment'])) {
    // Get necessary variables
    $username = $_SESSION["username"];
    $postID = $_SESSION["postid"];
    $timestamp = $_POST["timestamp"];

    // Implement your code to delete the comment from the database
    $stmt = pg_prepare($conn, "delete_query", "DELETE FROM comments WHERE username = $1 AND postID = $2 AND timestamp = $3");
    $delete_result = pg_execute($conn, "delete_query", array($username, $postID, $timestamp));

    if ($delete_result) {
        header('Location: ../html/Home.php');
        exit();
    } else {
        // Handle the case where deletion failed
        echo "Failed to delete the comment.";
    }
}

pg_close($conn);
?>
