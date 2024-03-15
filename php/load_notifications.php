<?php
$user = $_SESSION["username"];
session_write_close();
$notificationQuery = pg_prepare($conn, "list", "SELECT * FROM notifications WHERE username = $1 ORDER BY notificationID DESC limit 3");
$notificationResult = pg_execute($conn, "list", array($user));
$NumbRows = pg_num_rows($notificationResult);

$notifications = array(); // Array to hold all notifications

if ($NumbRows > 0) {
    while ($row = pg_fetch_assoc($notificationResult)) {
        $notificationID = $row['notificationid'];
        $notification = $row['notifmessage'];
        $time = $row['timestamp'];
        $killtime = $row['killtime'];
        if (strtotime($killtime) >= strtotime(date("Y-m-d"))) {
            $notifications[] = array('notificationID' => $notificationID, 'notification' => $notification, 'time' => $time);
        }
    }
}

$followeeNot = pg_prepare($conn, "notification_list", "SELECT DISTINCT notifications.* FROM notifications 
JOIN follows 
ON notifications.username = follows.followee WHERE follows.username = $1 ORDER BY notifications.notificationID DESC Limit 3");

$followeeRes = pg_execute($conn, "notification_list", array($user));

$NumbRows2 = pg_num_rows($followeeRes);

if ($NumbRows2 > 0) {
    while ($row = pg_fetch_assoc($followeeRes)) {
        $notificationID = $row['notificationid'];
        $notification = $row['notifmessage'];
        $user_table = $row['username'];
        $time = $row['timestamp'];
        $killtime = $row['killtime'];
        if ($user != $user_table && strtotime($killtime) >= strtotime(date("Y-m-d"))) {
            $notifications[] = array('notificationID' => $notificationID, 'notification' => " $notification", 'time' => $time);
        }
    }
}

// Sort notifications by ID first, then by time
usort($notifications, function ($a, $b) {
    // Compare notificationID first
    $idComparison = $b['notificationID'] - $a['notificationID'];

    // If notificationID is equal, compare timestamps
    if ($idComparison == 0) {
        return strtotime($b['time']) - strtotime($a['time']);
    }

    return $idComparison;
});

if (count($notifications) > 0) {
    $counter = 0;
    foreach ($notifications as $notification) {
        $counter++;
        echo "<list>";
        $i = 0;
        foreach ($notifications as $notification) {
            if ($i < 3) {
                echo "<p class='dropdown-item'>{$notification['notification']}</p>";
            } else {
                break; // Break the loop once the top 3 items are displayed
            }
            $i++;
        }
        echo "</list>";
    }
} else {
    echo "<div> <h1>No notifications yet...</h1></div>";
}
?>