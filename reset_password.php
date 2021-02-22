<?php
//LHS EVENTS//
//Created by: Pierce Goulimis//
//Date: June 13th 2019//

include('inc/header.php');

session_start();

if(isset($_SESSION['username'])){

   header("Location: login");

} else{

    

}

if(isset($_GET['key']) && !empty($_GET['key'])){

    $hash = mysqli_real_escape_string($con, $_GET['key']); // Set hash variable
    $hash = strip_tags($hash);

    //verify email token is real and such
    $sql_e = "SELECT * FROM password_tokens WHERE token='$hash'";
    $res_e = mysqli_query($con, $sql_e);
    $row = mysqli_fetch_assoc($res_e); 

    if(mysqli_num_rows($res_e) > 0){
      //password token exists, do nothing
      


    } else{
        //Token is either invalid or already used

        header("Location: index");
    }



}else{
    header("location: index");
}



//reset form handler
if(isset($_POST['resetpassword'])){

//get vars from form
$newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
$newpassword = strip_tags($newpassword);
$confirmnewpassword = mysqli_real_escape_string($con, $_POST['confirmnewpassword']);
$confirmnewpassword = strip_tags($confirmnewpassword);

//check for errors

if(strlen($newpassword) >= 6 && strlen($newpassword) <= 30){

  if($newpassword == $confirmnewpassword){

    //save to database

    $hashednewpassword = md5($newpassword);
    $newPasswordEmail = $row['email'];

    if(mysqli_query($con, "UPDATE users SET userpassword='$hashednewpassword' WHERE email='$newPasswordEmail'")){
      //password updated,delete from password tokens
      mysqli_query($con, "DELETE FROM password_tokens WHERE email='$newPasswordEmail'");
      header("Location: login");
      


    } else{
      //display error
      echo '
                  <div class="alert alert-danger text-center" role="alert">
                  An error has occured! Please try again later.
                  </div>
                  ';
    }


  } else{
    //passwords don't match
    echo '
                  <div class="alert alert-danger text-center" role="alert">
                  Passwords do not match!
                  </div>
                  ';
  }


} else{
  //passwords bad length
  echo '
                  <div class="alert alert-danger text-center" role="alert">
                  Password must be between 6 and 30 characters.
                  </div>
                  ';
}


}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Reset Password - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">

    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />
    <style type="text/css">
    .form-control:focus {
        border-color: transparent;
        box-shadow: 0 0 0 0.2rem yellow;
    } 


      </style>
</head>

<body style="background-color: #fffc00;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 5px;">
            <h1 style="font-size: 70px;color: #000000;"><strong>Reset Password</strong></h1>

                <span style="margin-left:15px;margin-right:15px;">Please enter a new password for your account</span>
                <br>
            
            <form style="display: inline-block;" action="" method="POST">
            
            <input class="form-control" type="password" name="newpassword" style="width: 300px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="Enter a New Password" required="">

            <input class="form-control" type="password" name="confirmnewpassword" style="width: 300px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="Confirm New Password" required="">


            <button class="btn" type="submit" name="resetpassword" style="background-color: black;color: white;margin-top: 20px;width: 50%;margin-bottom:190px;">Change</button>

                <div style="margin-top: 15px;">
                
                </div>
            </form>
        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    <div class="footer-2" style="position: fixed;left: 0;bottom: 0;width: 100%;background-color: black;color: white;text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-8 col-sm-6 col-md-6">
                    <p class="text-left" style="margin-top:5%;margin-bottom:3%;"><strong>© 2020 Profify. All Rights Reserved</strong></p>
                </div>
                <div class="col-12 col-sm-6 col-md-6" style="margin-top: 30px;">
                    <div style="margin-bottom: 0px;height: 24px;"><a href="about" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">about us</a><a href="legal" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">legal</a>
                        
                    </div>
                    <p class="text-right" style="margin-top: 4%;margin-bottom: 10%%;font-size: 1em;"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>