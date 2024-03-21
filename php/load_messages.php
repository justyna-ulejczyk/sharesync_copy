<?php

$login_username = $_SESSION["username"];


$stmt = pg_prepare($conn, "read_message", "SELECT * FROM messages WHERE
                     (username = $1 AND recipient = $2) OR (username = $2 AND recipient = $1) ORDER BY messageID ASC");
$result = pg_execute($conn, "read_message", array($login_username, $id));
$numRows = pg_num_rows($result);

if ($numRows > 0) {
    echo "<p>Total Messages: $numRows</p>"; // Display total number of messages
    echo ' <div class="chatter-chat" id="chatter-chat">';
    while ($row = pg_fetch_assoc($result)) {
        $text = $row["text"];
        $sender = $row["username"];
        $recipient = $row["recipient"];
        if ($text) {
            if ($sender == $id) {
                echo '<div class="chatter-chat-sender">
                        <div class="chatter-sender">
                            <div class="chatter-chat-info">
                                <img src="../profile_pic/profile_pic_' . $sender . '.png">
                                <p>' . $sender . '</p>
                            </div>
                            <div class="chat">
                                ' . $text . '
                            </div>
                        </div>
                    </div>';
            } else {
                if ($sender == $login_username) {
                    echo '<div class="chatter-chat-reciever">
                            <div class="chatter-reciever">
                                <div class="chatter-chat-info">
                                    <p>' . $sender . '</p>
                                    <img src="../profile_pic/profile_pic_' . $login_username . '.png">
                                </div>
                                <div class="chat">
                                    ' . $text . '
                                </div>
                            </div>
                        </div>';
                }
            }
        }
    }
    echo '</div>'; // Close chatter-chat div
} else {
    echo 'No Messages Yet';
}

?>

<script>
    // Function to scroll the chatter-chat div to its bottom
    function scrollChatterBoxToBottom() {
        var chatterChat = document.getElementById("chatter-chat");
        chatterChat.scrollTop = chatterChat.scrollHeight;
    }

    // Call the function to scroll chatter-chat div to its bottom after the page has loaded
    window.onload = function() {
        scrollChatterBoxToBottom();
    };
</script>