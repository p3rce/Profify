<?php

include('inc/config.php');

error_reporting(0);

session_start();



function isSessionActive(){

    global $con;



    if(isset($_SESSION['username'])){



        $currentuser = $_SESSION['username'];

    

        $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

        $row = mysqli_fetch_assoc($user_query);



        $userID = $row['id'];





            //check if session variable active



            $sessionQuery = mysqli_query($con, "SELECT * FROM user_sessions WHERE currentuserid=$userID");

            $sessionNum = mysqli_num_rows($sessionQuery);



                if($sessionNum == 0){

                    header("location:logout");

                } else{

                    

                }





    

    } else{

    

        

    

    }





}







if(!$_SESSION['username']){



    //user is not logged in

    echo '

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

<a href="index"><img style="height: 35px;margin-left: 10px;margin-right: 10px;" src="assets/img/sunshinelogo.png"></a><a class="navbar-brand" href="index" style="color: #28334AFF;font-size: 26px;font-weight:400;margin-left:30px;">Profify</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav ml-auto">

    <span class="navbar-text actions"> <a class="login" href="login"></a><a class="btn btn-light action-button" role="button" href="signup" style="margin-right: 20px;background-color: #000000;color:white;"><strong>Create a Page</strong></a><a href="login" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;">Log In</a></span>

    </ul>

  </div>

</nav>

    

    ';



    





} else{



    $currentuser = $_SESSION['username'];



    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

    $row = mysqli_fetch_assoc($user_query);



    if($row['isadmin'] == "1"){

        //user is admin and logged in

        isSessionActive();




    echo '

<nav class="navbar navbar-expand-lg navbar-light bg-light">

<a href="index"><img style="height: 35px;margin-left: 10px;margin-right: 10px;" src="assets/img/sunshinelogo.png"></a><a class="navbar-brand" href="index" style="color: #28334AFF;font-size: 26px;font-weight:400;margin-left:30px;">Profify</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav ml-auto" >

    <span class="navbar-text actions text-center"><a href="adminsystem" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Admin Panel</a> <a href="home" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Home</a><a href="createapage" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Add Profiles</a><a href="settings" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Settings</a><a href="logout" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Log Out</a></span>

    </ul>

  </div>

</nav>

<meta http-equiv="refresh" content="6000;url=logout" />

    ';





    } else{



        isSessionActive();



        //user is logged in


        echo '

<nav class="navbar navbar-expand-lg navbar-light bg-light">

<a href="index"><img style="height: 35px;margin-left: 10px;margin-right: 10px;" src="assets/img/sunshinelogo.png"></a><a class="navbar-brand" href="index" style="color: #28334AFF;font-size: 26px;font-weight:400;margin-left:30px;">Profify</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbarNav">

    <ul class="navbar-nav ml-auto" >

    <span class="navbar-text actions text-center"> <a href="home" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Home</a><a href="createapage" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Add Profiles</a><a href="settings" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Settings</a><a href="logout" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Log Out</a></span>

    </ul>

  </div>

</nav>

<meta http-equiv="refresh" content="6000;url=logout" />

    ';

       





    }













}











?>