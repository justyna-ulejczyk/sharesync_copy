<?php

//session_id("userSession");
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "register.php");
}

require_once "connect_db.php";

if (isset($_POST['commentSubmit'])) {
    $user_id = $_SESSION["username"];
    $date = date('Y-m-d H:i:s');
    $comment = $_POST['text'];
    $post_id = $_POST['postid'];

    $query = "INSERT INTO comments(username, timestamp, text, postid) VALUES($1, $2, $3, $4) RETURNING commentid;";
    $result = pg_query_params($conn, $query, array($user_id, $date, $comment, $post_id));
    if ($result) {
        //adding notifications
        $postquery = pg_prepare($conn, "post_name", "SELECT * FROM post WHERE postid = $1");
        $postresult = pg_execute($conn, "post_name", array($post_id));
        $postRow = pg_fetch_assoc($postresult);
        $post_user = $postRow['username'];

        $user = $_SESSION['username'];
        $date = date("Y-m-d");
        $killTime = new DateTime();
        $killTime->modify('+3 weeks');

        $mess = "$user commented on $post_user's post <a href='../html/Home.php'>See here</a>";

        $notificationQuery = pg_prepare($conn, "add_notification", "INSERT INTO notifications 
                        (username, timestamp, killtime, notifmessage) 
                        VALUES ($1, $2, $3, $4) RETURNING notificationID");
        $notificationResult = pg_execute($conn, "add_notification", array($user, $date, $killTime->format('Y-m-d'), $mess));

        header('Location: ../html/Home.php');
        exit();
    }
}

// Close the connection
pg_close($conn);

?>
