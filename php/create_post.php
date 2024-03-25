<?php
//session_id("userSession");
session_start();
if (! isset($_SESSION["username"])){
    header('Location: '."../html/login.php"); // redirect the user to the register page if they have not already logged in
}
// Connect to the database
require_once "connect_db.php";

$createPostSTMT = pg_prepare($conn, "insert_post", "INSERT INTO post (username, text) VALUES ($1, $2) RETURNING postid");
$AddTagSTMT = pg_prepare($conn, "add_tag", "INSERT INTO tags (tagname, postid) VALUES ($1, $2)");

$username = $_SESSION['username'];
$text = $_POST['text'];
$tags = $_POST['tags'];
$tags_split = explode(',', $tags);
$tags_trimmed = array_map('trim', $tags_split);

$result = pg_execute($conn, "insert_post", array($username, $text));
    if ($result) {
        header('Location: '."../html/Home.php");
    $postid = pg_fetch_result($result, 0, 'postid');

} else {
    echo "Error: " . pg_last_error($conn);
    die();
}

foreach ($tags_trimmed as $tag){
    pg_execute($conn, "add_tag", array($tag,$postid));
}

$uploaddir = '../post_images/';
$uploadfile = $uploaddir . "post_image". $postid . ".png";
//Add the image associated with the post to the post_images directory with the the number of the post_id linked to the image so it can be found easily
if(move_uploaded_file($_FILES['post_image']['tmp_name'], $uploadfile)){
    header('Location: '."../html/Home.php");
}else{
echo "Possible file upload attack!\n";
}
$username = $_SESSION['username'];

$date = date("Y-m-d");
$killTime = new DateTime();
$killTime->modify('+3 weeks');

$mess =  "$username added new post <a href = '../html/Home.php'>See here</a>";
        $notificationQuery = pg_prepare($conn, "add_notification", "INSERT INTO notifications 
(username, timestamp, killtime, notifmessage) 
VALUES ($1, $2, $3, $4) RETURNING notificationID");
$notificationResult = pg_execute($conn, "add_notification", array($username, $date, $killTime->format('Y-m-d'), $mess));

        // Close the connection
        pg_close($conn);
        header('Location: '."../html/Home.php");
       
       
       ?>