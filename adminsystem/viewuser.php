<?php
date_default_timezone_set('America/Toronto');
include('../inc/config.php');
error_reporting(0);
session_start();
if($_SESSION['username']){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

        echo '<nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="border: 1px solid rgb(218,213,213);border-top: none;height: 61px;">
        <div class="container"><a class="navbar-brand" href="index" style="color: #28334AFF;font-size: 26px;">Profify Administration</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav mr-auto"></ul><span class="navbar-text actions"><a href="../' . $currentuser . '" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Go back Home</a></div>
        </div>
    </nav>';


    



}




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





if(isset($_GET['id'])){

    //theres an id in url, check if valid and proceed
    $rawuserid = $_GET['id'];
    $userid = mysqli_real_escape_string($con, $rawuserid);
    $useridquery = "SELECT * FROM users WHERE id='$userid'";
    $user_result = mysqli_query($con, $useridquery);
  
  
    if ($user_result->num_rows > 0){
      //theres a user with the id provided
      $u_row = $user_result->fetch_assoc();


        if($u_row['isadmin'] == 1){
          header("location: index");
        } else{



          
        }
  
  
    } else{
      //eventid does not exist
      header("location: manageusers");
    }
  
  
  
  
  
  } else{
    //no eventid in url, redirect :/
    header("location: index");
  }




  




  if(isset($_POST['banUser'])){
    //admin wants to ban user account
    $bannedemail = $u_row['id'];

    //first see if banned or unbanned
    $checkbanned_query = mysqli_query($con, "SELECT isbanned FROM users WHERE isbanned='1' AND id='$bannedemail'");
    $checkbanned_num = mysqli_num_rows($checkbanned_query);

      if($checkbanned_num == "1"){
          //alr banned so unban
          if(mysqli_query($con, "UPDATE users SET isbanned='0' WHERE id='$bannedemail'")){
            echo '<div class="alert alert-success text-center" role="alert">
                    User Account has been unbanned
                </div>';

                 //add action to logs
                 $action = "UNBAN USER";
                 $description = "Admin unbanned user " . $bannedemail . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
              //unbanned
    //           date_default_timezone_set('America/Toronto');
    //           $action = "Admin unbanned " . $u_row['email'] . "";
    //           $date = date("F j, Y, g:i a");
    //           $admin_email = $currentemail;

    //           mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
    //           echo '
    //   <div class="alert alert-success" role="alert">
    //    User unbanned
    //   </div>
    //   ';
    
          } else{
              //fatal error
              echo '
      <div class="alert alert-danger" role="alert">
       Fatal error
      </div>
      ';
          }
          } else{
              //not banned so ban em
              if(mysqli_query($con, "UPDATE users SET isbanned='1' WHERE id='$bannedemail'")){
                echo '<div class="alert alert-success text-center" role="alert">
                    User Account has been banned
                </div>';

                 //add action to logs
                 $action = "BAN USER";
                 $description = "Admin banned user " . $bannedemail . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
                  //banned
        //           date_default_timezone_set('America/Toronto');
        //       $action = "Admin banned " . $u_row['email'] . "";
        //       $date = date("F j, Y, g:i a");
        //       $admin_email = $currentemail;

        //       mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
        //           echo '
        //   <div class="alert alert-success" role="alert">
        //    User banned
        //   </div>
        //   ';
        
              } else{
                  //fatal error
                  echo '
          <div class="alert alert-danger" role="alert">
           Fatal error
          </div>
          ';
              }
          }

  

}







if(isset($_POST['freezeAccount'])){
    //admin wants to freeze user account
    $frozenemail = $u_row['id'];
  
    //first see if banned or unbanned
    $checkfrozen_query = mysqli_query($con, "SELECT accountfrozen FROM users WHERE accountfrozen='1' AND id='$frozenemail'");
    $checkfrozen_num = mysqli_num_rows($checkfrozen_query);
  
      if($checkfrozen_num == "1"){
          //alr banned so unban
          if(mysqli_query($con, "UPDATE users SET accountfrozen='0' WHERE id='$frozenemail'")){
            echo '<div class="alert alert-success text-center" role="alert">
                    User Account has been unfrozen
                </div>';

                 //add action to logs
                 $action = "UNFROZE USER";
                 $description = "Admin unfroze user " . $frozenemail . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
              //unbanned
    //           date_default_timezone_set('America/Toronto');
    //           $action = "Admin unbanned " . $u_row['email'] . "";
    //           $date = date("F j, Y, g:i a");
    //           $admin_email = $currentemail;
  
    //           mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
    //           echo '
    //   <div class="alert alert-success" role="alert">
    //    User unbanned
    //   </div>
    //   ';
    
          } else{
              //fatal error
              echo '
      <div class="alert alert-danger" role="alert">
       Fatal error
      </div>
      ';
          }
          } else{
              //not banned so ban em
              if(mysqli_query($con, "UPDATE users SET accountfrozen='1' WHERE id='$frozenemail'")){
                echo '<div class="alert alert-success text-center" role="alert">
                    User Account has been frozen
                </div>';

                 //add action to logs
                 $action = "FROZE USER";
                 $description = "Admin froze user " . $frozenemail . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
                  //banned
        //           date_default_timezone_set('America/Toronto');
        //       $action = "Admin banned " . $u_row['email'] . "";
        //       $date = date("F j, Y, g:i a");
        //       $admin_email = $currentemail;
  
        //       mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
        //           echo '
        //   <div class="alert alert-success" role="alert">
        //    User banned
        //   </div>
        //   ';
        
              } else{
                  //fatal error
                  echo '
          <div class="alert alert-danger" role="alert">
           Fatal error
          </div>
          ';
              }
          }
  
  
  
  }



  if(isset($_POST['whitelistAccount'])){
    //admin wants to whitelist user account
    $whitelistemail = $u_row['id'];
  
    //first see if banned or unbanned
    $whitelist_query = mysqli_query($con, "SELECT reportGodeMode FROM users WHERE reportGodeMode='1' AND id='$whitelistemail'");
    $checkwhitelist_num = mysqli_num_rows($whitelist_query);
  
      if($checkwhitelist_num == "1"){
          //alr banned so unban
          if(mysqli_query($con, "UPDATE users SET reportGodeMode='0' WHERE id='$whitelistemail'")){
            echo '<div class="alert alert-success text-center" role="alert">
            User has been unshielded
        </div>';

         //add action to logs
         $action = "UNSHIELD USER";
         $description = "Admin unshielded user " . $whitelistemail . "";
         $dateofaction = date("F j, Y, g:i a");
         $admin_username = $currentuser;


         mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
         VALUES('$action','$description','$dateofaction','$admin_username')");

        $refreshAfter = 2;

        header('Refresh: ' . $refreshAfter);
              //unbanned
    //           date_default_timezone_set('America/Toronto');
    //           $action = "Admin unbanned " . $u_row['email'] . "";
    //           $date = date("F j, Y, g:i a");
    //           $admin_email = $currentemail;
  
    //           mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
    //           echo '
    //   <div class="alert alert-success" role="alert">
    //    User unbanned
    //   </div>
    //   ';
    
          } else{
              //fatal error
              echo '
      <div class="alert alert-danger" role="alert">
       Fatal error
      </div>
      ';
          }
          } else{
              //not banned so ban em
              if(mysqli_query($con, "UPDATE users SET reportGodeMode='1' WHERE id='$whitelistemail'")){
                echo '<div class="alert alert-success text-center" role="alert">
                    User Account has been shielded
                </div>';

                 //add action to logs
                 $action = "SHIELD USER";
                 $description = "Admin shielded user " . $whitelistemail . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
                  //banned
        //           date_default_timezone_set('America/Toronto');
        //       $action = "Admin banned " . $u_row['email'] . "";
        //       $date = date("F j, Y, g:i a");
        //       $admin_email = $currentemail;
  
        //       mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
        //           echo '
        //   <div class="alert alert-success" role="alert">
        //    User banned
        //   </div>
        //   ';
        
              } else{
                  //fatal error
                  echo '
          <div class="alert alert-danger" role="alert">
           Fatal error
          </div>
          ';
              }
          }
  
  
  
  }


  if(isset($_POST['userVerification'])){
    //admin wants to ban user account
    $verifiedUserId = $u_row['id'];
    $verifiedUsername = $u_row['username'];

    //first see if banned or unbanned
    $checkverification_query = mysqli_query($con, "SELECT isverified FROM users WHERE isverified='1' AND id='$verifiedUserId'");
    $checkverification_num = mysqli_num_rows($checkverification_query);

      if($checkverification_num == "1"){
          //alr verified so unverify
          if(mysqli_query($con, "UPDATE users SET isverified='0' WHERE id='$verifiedUserId'")){
            echo '<div class="alert alert-success text-center" role="alert">
                    User has been unverified
                </div>';

                 //add action to logs
                 $action = "UNVERIFY USER";
                 $description = "Admin unverified user " . $verifiedUsername . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
              //unbanned
    //           date_default_timezone_set('America/Toronto');
    //           $action = "Admin unbanned " . $u_row['email'] . "";
    //           $date = date("F j, Y, g:i a");
    //           $admin_email = $currentemail;

    //           mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
    //           echo '
    //   <div class="alert alert-success" role="alert">
    //    User unbanned
    //   </div>
    //   ';
    
          } else{
              //fatal error
              echo '
      <div class="alert alert-danger" role="alert">
       Fatal error
      </div>
      ';
          }
          } else{
              //not verified so verify em
              if(mysqli_query($con, "UPDATE users SET isverified='1' WHERE id='$verifiedUserId'")){
                echo '<div class="alert alert-success text-center" role="alert">
                   User has been Verified
                </div>';

                 //add action to logs
                 $action = "VERIFY USER";
                 $description = "Admin verified user " . $verifiedUsername . "";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);
                  //banned
        //           date_default_timezone_set('America/Toronto');
        //       $action = "Admin banned " . $u_row['email'] . "";
        //       $date = date("F j, Y, g:i a");
        //       $admin_email = $currentemail;

        //       mysqli_query($con, "INSERT INTO admin_logs (actiondesc, actiondate, admin_email) VALUES ('$action','$date','$admin_email')");
        //           echo '
        //   <div class="alert alert-success" role="alert">
        //    User banned
        //   </div>
        //   ';
        
              } else{
                  //fatal error
                  echo '
          <div class="alert alert-danger" role="alert">
           Fatal error
          </div>
          ';
              }
          }

  

}





if(isset($_POST['destroyAllSessions'])){
    $userID = $u_row['id'];
    $userRemoveName = $u_row['username'];

    //destroy ALL logged in sessions


    if(mysqli_query($con, "DELETE FROM user_sessions WHERE currentuserid=$userID")){

      echo '<div class="alert alert-success text-center" role="alert">
                    All of the Users Sessions have been destroyed
                </div>';

                 //add action to logs
                 $action = "REMOVE SESSIONS";
                 $description = "Admin removed all of " . $userRemoveName . " sessions";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);


    }




  }




  if(isset($_POST['changePassword'])){


    $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
    $userID = $u_row['id'];
    $userChngUsername = $u_row['username'];
    $securePassword = md5($newPassword);

                if(mysqli_query($con, "UPDATE users SET userpassword='$securePassword' WHERE id='$userID'")){

                    echo '<div class="alert alert-success text-center" role="alert">
                    Account Password Changed
                </div>';

                 //add action to logs
                 $action = "CHANGE PASSWORD";
                 $description = "Admin force reset " . $userChngUsername . " password";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                }



            


    


  }




  if(isset($_POST['changeUsername'])){


    $newUsername = mysqli_real_escape_string($con, $_POST['newUsername']);
    $userID = $u_row['id'];
    $oldUsername = $u_row['username'];


        $usernameTaken = mysqli_query($con, "SELECT username FROM users WHERE username='$newUsername'");
        $usernameNum = mysqli_num_rows($usernameTaken);

            if($usernameNum == 1){
                echo '<div class="alert alert-danger text-center" role="alert">
                Username is taken
            </div>';
            } else{


                if(mysqli_query($con, "UPDATE users SET username='$newUsername' WHERE id='$userID'")){

                    echo '<div class="alert alert-success text-center" role="alert">
                    Username Changed
                </div>';

                 //add action to logs
                 $action = "CHANGE USERNAME";
                 $description = "Admin changed " . $oldUsername . " username to " . $newUsername . " ";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);

                }



            }


    


  }


  if(isset($_POST['newEmail'])){


    $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);
    $userID = $u_row['id'];
    $changeEmailUsername = $u_row['email'];


        $usernameTaken = mysqli_query($con, "SELECT email FROM users WHERE email='$newEmail'");
        $usernameNum = mysqli_num_rows($usernameTaken);

            if($usernameNum == 1){
                echo '<div class="alert alert-danger text-center" role="alert">
                    Email is already in use
                </div>';
            } else{


                if(mysqli_query($con, "UPDATE users SET email='$newEmail' WHERE id='$userID'")){

                    echo '<div class="alert alert-success text-center" role="alert">
                    Email Changed
                </div>';

                 //add action to logs
                 $action = "CHANGE EMAIL";
                 $description = "Admin changed " . $changeEmailUsername . " account email";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);

                }



            }


  }



  if(isset($_POST['changeProfilePhoto'])){

    $userID = $u_row['id'];
    $userUsernameThing = $u_row['username'];
    $defaultProfilePictureURL = "defaultprofilephoto.jpg";


      if(mysqli_query($con, "UPDATE users SET profilepic='$defaultProfilePictureURL' WHERE id='$userID'")){


        echo '<div class="alert alert-success text-center" role="alert">
                    Profile Picture changed to Default
                </div>';

                 //add action to logs
                 $action = "CHANGE PROFILE PICTURE";
                 $description = "Admin changed" . $userUsernameThing . " profile picture to default";
                 $dateofaction = date("F j, Y, g:i a");
                 $admin_username = $currentuser;
 
 
                 mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                 VALUES('$action','$description','$dateofaction','$admin_username')");

                $refreshAfter = 2;

                header('Refresh: ' . $refreshAfter);



      }


  }





?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>View User - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>

<body style="background-color: white;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">
            <h1 style="font-size: 70px;color: #000000;"><strong><?php echo $u_row['username'];?>'s Account</strong></h1>
            
            <a class="btn btn-success" href="../<?php echo $u_row['username'];?>" target="_blank">VIEW PAGE</a>

            <div class="container" style="margin-top:10px;">


            <form action="" method="POST">
                
            <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Value</th>
      <th scope="col">Actions</th>
      
    </tr>
  </thead>
                <tbody>


                <tr>
                <th scope="row">User ID</th>
                <td><?php echo $u_row['id'];?></td>
                <td></td>

                </tr>

                <tr>
                <th scope="row">Username</th>
                <td>@<?php echo $u_row['username'];?></td>
                <td>
                <button type="submit" name="destroyAllSessions" class="btn btn-danger">clear all logged in sessions</button>
                
                <form action="" method="POST">
                <div class="form-group" style="margin-top:15px;">
    <label for="formGroupExampleInput">New Username</label>
    <input type="text" name="newUsername" class="form-control" id="formGroupExampleInput" placeholder="Desired Username">
  </div>
                    <button type="submit" name="changeUsername" class="btn btn-success">CHANGE USERNAME</button>
                
                </form>
                </td>

                </tr>

                <tr>
                <th scope="row">Email</th>
                <td><?php echo $u_row['email'];?> <span class="badge badge-<?php if($u_row['emailconfirmed'] == 1){echo 'success';} else{echo 'danger';}?>"><?php if($u_row['emailconfirmed'] == 1){echo 'Email Confirmed';} else{echo 'Email Not Confirmed';}?></span></td>
                <td>
                <!-- <button type="submit" style="margin-top:20px;margin-bottom:20px;" name="changeProfilePhoto" class="btn btn-secondary">send confirm email link to email</button> -->

                



                <form action="" method="POST">
                <div class="form-group">
    <label for="formGroupExampleInput">New Email</label>
    <input type="email" name="newEmail" class="form-control" id="formGroupExampleInput" placeholder="Desired Email">
  </div>

  <button type="submit" name="changeEmail" class="btn btn-success">CHANGE EMAIL</button>

  </form>

                
                
                
                </td>

                </tr>

                <tr>
                <th scope="row">Password</th>
                <td></td>
                <td>
                <form action="" method="POST">
  <div class="form-group">
    <label for="formGroupExampleInput">New Password</label>
    <input type="text" name="newPassword" class="form-control" id="formGroupExampleInput" placeholder="Desired Password">
  </div>
                    <button type="submit" name="changePassword" class="btn btn-success">CHANGE PASSWORD</button>

                </form>

                
                
                
                </td>

                </tr>

                <tr>
                <th scope="row">Full Name</th>
                <td><?php echo $u_row['fullname'];?></td>
                <td>
              
                </td>

                </tr>

                <tr>
                <th scope="row">Bio</th>
                <td><?php echo $u_row['bio'];?></td>
                <td>
              
                </td>

                </tr>

                <tr>
                <th scope="row">Profile Photo</th>
                <td><span class="badge badge-<?php if($u_row['profilepic'] == "defaultprofilephoto.jpg"){echo 'success';} else{echo 'danger';}?>"><?php if($u_row['profilepic'] == "defaultprofilephoto.jpg"){echo 'Default Picture';} else{echo 'Not Default Picture';}?></span></td>
                <td>
                <a class="btn btn-secondary" target="__blank" href="../profilephotos/<?php echo $u_row['profilepic'];?>">view current profile photo</a>
                <br>
                <button type="submit" style="margin-top:20px;margin-bottom:20px;" name="changeProfilePhoto" class="btn btn-secondary">change profile picture to default</button>

                </td>

                </tr>


                <tr>
                <th scope="row">Sign Up IP</th>
                <td><?php echo $u_row['signup_ip'];?></td>
                <td>
              
                </td>

                </tr>

                <tr>
                <th scope="row">Last Login IP</th>
                <td><?php echo $u_row['lastlogin_ip'];?></td>
                <td>
              
                </td>

                </tr>

                <tr>
                <th scope="row">Ghost Account</th>
                <td><span class="badge badge-<?php if($u_row['firstlogin'] == 1){echo 'danger';} else{echo 'success';}?>"><?php if($u_row['firstlogin'] == 1){echo 'Ghost Account';} else{echo 'Not Ghost Account';}?></span></td>
                <td>
              
                </td>

                </tr>



                <tr>
                <th scope="row">User Birthday</th>
                <td><span class="badge badge-info"><?php echo $u_row['birthday'];?></span></td>
                <td>
                

                </td>

                </tr>

                <tr>
                <th scope="row">Account Status</th>
                <td><span class="badge badge-<?php if($u_row['isbanned'] == 1){echo 'danger';} else{echo 'success';}?>"><?php if($u_row['isbanned'] == 1){echo 'Disabled';} else{echo 'Enabled';}?></span></td>
                <td>
                <button type="submit" name="banUser" class="btn btn-success"><?php if($u_row['isbanned'] == 1){echo 'enable account';} else{echo 'disable account';}?></button>

                </td>

                </tr>

                <tr>
                <th scope="row">Account Verified</th>
                <td><span class="badge badge-<?php if($u_row['isverified'] == 1){echo 'success';} else{echo 'danger';}?>"><?php if($u_row['isverified'] == 1){echo 'Verified';} else{echo 'Not Verified';}?></span></td>
                <td>
                <button type="submit" name="userVerification" class="btn btn-secondary"><?php if($u_row['isverified'] == 1){echo 'unverify account';} else{echo 'verify account';}?></button>

                </td>

                </tr>

                <tr>
                <th scope="row">Account Shielded</th>
                <td><span class="badge badge-<?php if($u_row['reportGodeMode'] == 1){echo 'success';} else{echo 'danger';}?>"><?php if($u_row['reportGodeMode'] == 1){echo 'Shielded';} else{echo 'Not Shielded';}?></span></td>
                <td>
                <button type="submit" name="whitelistAccount" class="btn btn-secondary"><?php if($u_row['reportGodeMode'] == 1){echo 'unshield account';} else{echo 'shield account';}?></button>

                </td>

                </tr>

                <tr>
                <th scope="row">Account Frozen</th>
                <td><span class="badge badge-<?php if($u_row['accountfrozen'] == 1){echo 'success';} else{echo 'danger';}?>"><?php if($u_row['accountfrozen'] == 1){echo 'Frozen';} else{echo 'Not Frozen';}?></span></td>
                <td>
                <button type="submit" name="freezeAccount" class="btn btn-success"><?php if($u_row['accountfrozen'] == 1){echo 'unfreeze account';} else{echo 'freeze account';}?></button>

                </td>

                </tr>

                







                
            </tbody>
</table>

</form>




            </div>


           





            
        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
   
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>




<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">REPORTS AGAIN USER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

</html>