<?php

session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ' . "./login.php");
    exit();
}

require_once "../php/connect_db.php";

$username = $_SESSION["username"];
$university = isset($_POST['university']) ? $_POST['university'] : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
$worksat = isset($_POST['worksat']) ? $_POST['worksat'] : null;
$location = isset($_POST['location']) ? $_POST['location'] : null;
//$phonenum = isset($_POST['phonenum']) ? $_POST['phonenum'] : null;
$dob = isset($_POST['dob']) ? $_POST['dob'] : null;

if ($university !== null) {
    $insert = pg_prepare($conn, "university", "UPDATE accounts SET university=$1 WHERE username=$2");
    $result = pg_execute($conn, "university", array($university, $username));
    header ('Location:../html/Settings.php');
    exit();
}
if ($gender !== null) {
    $insert = pg_prepare($conn, "gender", "UPDATE accounts SET gender=$1 WHERE username=$2");
    $result = pg_execute($conn, "gender", array($gender, $username));
    header ('Location:../html/Settings.php');
    exit();
}
if ($worksat !== null) {
    $insert = pg_prepare($conn, "work", "UPDATE accounts SET worksat=$1 WHERE username=$2");
    $result = pg_execute($conn, "work", array($worksat, $username));
    header ('Location:../html/Settings.php');
    exit();
}
if ($location !== null) {
    $insert = pg_prepare($conn, "location", "UPDATE accounts SET location=$1 WHERE username=$2");
    $result = pg_execute($conn, "location", array($location, $username));
    header ('Location:../html/Settings.php');
    exit();
}
// if ($phonenum !== null) {
//     $insert = pg_prepare($conn, "phone", "UPDATE accounts SET phonenum=$1 WHERE username=$2");
//     $result = pg_execute($conn, "phone", array($phonenum, $username));
//     header ('Location:../html/Settings.php');
//     exit();
//}
if ($dob !== null) {
    $insert = pg_prepare($conn, "dob", "UPDATE accounts SET dob=$1 WHERE username=$2");
    $result = pg_execute($conn, "dob", array($dob, $username));
    header ('Location:../html/Settings.php');
    exit();
}
header ('Location:../html/Settings.php');
    exit();
?>
