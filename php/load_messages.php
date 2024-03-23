<?php
require_once "../php/connect_db.php";
session_start();
$login_username = $_SESSION["username"];
$id = $_GET['id'];

$stmt = pg_prepare($conn, "read_message", "SELECT * FROM messages WHERE
                     (username = $1 AND recipient = $2) OR (username = $2 AND recipient = $1) ORDER BY messageID ASC");
$result = pg_execute($conn, "read_message", array($login_username, $id));
$numRows = pg_num_rows($result);

$data = "";

if ($numRows > 0) {
    $data.= "<p>Total Messages: $numRows</p>"; // Display total number of messages
    $data.= ' <div class="chatter-chat" id="chatter-chat">';
    while ($row = pg_fetch_assoc($result)) {
        $text = $row["text"];
        $sender = $row["username"];
        $recipient = $row["recipient"];
        if ($text) {
            if ($sender == $id) {
                $data.= '<div class="chatter-chat-sender">
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
                    $data.= '<div class="chatter-chat-reciever">
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
    $data.= '</div>'; // Close chatter-chat div
} else {
    $data.= '<div class="chatter-chat" id="chatter-chat">
            No Messages Yet
            </div>';
}

$data .= "<form class='chatter-send-message' id='messages' action='../php/send_message.php' method='post'>


<input type='text' id='recipient' name='recipient' value='$id' hidden
    style='display:none;'>

<input type='text' id='text' name='text' required=''>

<input type='text' class='username' name='username' value='$login_username'
    hidden style='display:none;'>
<button type='submit'><i class='fab fa-telegram-plane'></i></button>
</form>
</div></div>";

header('Content-Type: application/json');
echo json_encode($data);

?>
