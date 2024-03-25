<?php
require_once "connect_db.php";
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ' . "../html/login.html");
    exit();
}
    $postid = $_POST['post_id'];
    $query = pg_prepare($conn, "delete", "DELETE FROM post where postid = $1");
    $stmt = pg_execute($conn, "delete", array($postid));

    if ($stmt) {
        header('Location: ../html/Home.php');
        exit();
    } else {
        echo "Failed to delete the post";
    }

pg_close($conn);
?>
