<?php

include('../inc/config.php');
error_reporting(0);
session_start();





if(isset($_SESSION['username'])){




    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);



        //check if admin

        if($row['isadmin'] == "1"){
            //is admin
        } else{
          header("location: ../error?error_id=416");
        }



} else{

    echo header("location: ../login");

}





if(isset($_GET['reportid'])){

    //theres an id in url, check if valid and proceed
    $rawuserid = $_GET['reportid'];
    $userid = mysqli_real_escape_string($con, $rawuserid);
    $useridquery = "SELECT * FROM report_abuse WHERE id='$userid'";
    $user_result = mysqli_query($con, $useridquery);
  
  
    if (mysqli_num_rows($user_result) == 1){
      //theres a user with the id provided, delete it

      mysqli_query($con,"DELETE FROM report_abuse WHERE id='$userid'");
      header("location: viewreports");
      
  
  
    } else{
      //eventid does not exist
      header("location: index");
    }
  
  
  
  
  
  } else{
    //no eventid in url, redirect :/
    header("location: index");
  }










  ?>