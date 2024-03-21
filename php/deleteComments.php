<?php
require_once "connect_db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit(); // Ensure script stops execution after redirection
}

$comment_id = $_POST['comment_id'];
    $query2 = pg_prepare($conn, "delete", "DELETE FROM comments WHERE commentid = $1");
    $stmt2 = pg_execute($conn, "delete", array($comment_id));

    if ($stmt2) {
        header('Location: ../html/Home.php');
        exit();
    } else {
        echo "Failed to delete the comment.";
    }

pg_close($conn);
?>
