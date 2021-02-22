<?php
session_start();
include('inc/config.php');

if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

} else{

    

}


//destroy session
$currentUserID = $row['id'];
$currentSessionID = $_SESSION['sessionID'];
mysqli_query($con, "DELETE FROM user_sessions WHERE currentuserid='$currentUserID' AND sessionid='$currentSessionID'");




session_destroy();
header("location: login");










?>