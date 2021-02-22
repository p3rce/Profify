<?php
include('inc/config.php');
include('inc/header.php');

session_start();

if(isset($_SESSION['username'])){

   header("location: home");

} else{

    

}

//LHS EVENTS//
//Created by: Pierce Goulimis//
//Date: June 13th 2019//
error_reporting(0);


if($_SESSION["email"]){
    header("home");
} else{
    
}



if(isset($_POST['fp_submit'])){

    $email = mysqli_real_escape_string($con, $_POST['fp_email']);
    $email = strip_tags($email);
    //check if email in database
    $fp_query = "SELECT email from users WHERE email='$email'";
    $result = mysqli_query($con, $fp_query);
    $res = mysqli_num_rows($result);

    if($res == 1){
        //email exists in database

        //if account not email verified, dont send reset link

        $fp_checkquery = "SELECT emailconfirmed FROM users WHERE email='$email'";
        $result2 = mysqli_query($con, $fp_checkquery);
        $res2 = mysqli_fetch_assoc($result2);

        if($res2['emailconfirmed'] == "5"){
            //account not verified
            echo '
            <div class="alert alert-danger text-center" role="alert">
             Your account has not been verified so you cannot reset the password
            </div>
            ';
        } else{


          //check if reset link sent already
          $alrlink_query = mysqli_query($con, "SELECT * FROM password_tokens WHERE email='$email'");
          $alrlink_num = mysqli_num_rows($alrlink_query);

          if($alrlink_num == "1"){
            //already sent one, delete old one and send new one


              //Delete old one
              $del_query = mysqli_query($con, "DELETE FROM password_tokens WHERE email='$email'");


              if($del_query){
                //Old one deleted so send new one
                $fp_key2 = md5( rand(0,1000) ); // Generate random 32 character hash
                $fp_email2 = $email; //Will be equal to the email the user gave us
                $new_query = mysqli_query($con, "INSERT INTO password_tokens (email, token) VALUES ('$fp_email2','$fp_key2')");


                if($new_query){
                  //New Password Link sent
                  //Sent Password Reset Link
                  $url2 = "https://www.profify.ca/reset_password?key=$fp_key2";
                  $to = $fp_email2;
                  $to_fullname = $res2['firstname'];
    
                  $subject = 'Profify Support | Reset Password';
    
                  $message .= '<p>Click below to reset your password ';
    
                  $message .= '<br>';
    
                  $message .= '<a href="' . $url2 . '">Click here</a> <br>';
    
                  $message .= '<br>';
    
                  $message .= 'DO NOT REPLY TO THIS EMAIL';
    
                  $headers .= "From: Profify Support <info@profify.ca>\r\n";
    
                  $headers .= "Reply-To: info@profify.ca\r\n";
    
                  $headers .= "Content-Type: text/html\r\n";
    
                  mail($to, $subject, $message, $headers);
              
                




                    echo '
                    <div class="alert alert-success text-center" role="alert">
                    The password reset link has been sent! Please check your email / spam folder
                  </div>
    
                    ';
                }

              }

          } else{
            //no link sent yet
            $fp_key = md5( rand(0,1000) ); // Generate random 32 character hash
            $fp_email = $email; //Will be equal to the email the user gave us
                
                if(mysqli_query($con, "INSERT INTO password_tokens (email, token) VALUES ('$fp_email','$fp_key')")){
                  
                  //Sent Password Reset Link
                  $url2 = "https://www.profify.ca/reset_password?key=$fp_key";

                  $to = $fp_email;
              $subject = 'Profify Support | Reset Password';
    
                  $message .= '<p>Click below to reset your password ';
    
                  $message .= '<br>';
    
                  $message .= '<a href="' . $url2 . '">Click here</a> <br>';
    
                  $message .= '<br>';
    
                  $message .= 'DO NOT REPLY TO THIS EMAIL';
    
                  $headers .= "From: Profify Support <info@profify.ca>\r\n";
    
                  $headers .= "Reply-To: info@profify.ca\r\n";
    
                  $headers .= "Content-Type: text/html\r\n";
    
                  mail($to, $subject, $message, $headers);

             
              




                    echo '
                    <div class="alert alert-success text-center" role="alert">
                    The password reset link has been sent! Please check your email / spam folder
                  </div>
    
                    ';

                  
    
                } else{
                    //error
                    echo '
                  <div class="alert alert-danger text-center" role="alert">
                  An error has occured! Please try again later.
                  </div>
                  ';
                }



          }






        }



    } else{
        //email does not exist
        echo '
          <div class="alert alert-danger text-center" role="alert">
           The email you entered is not connected to any account!
          </div>
          ';
    }



} else{
    //do nothing
}



?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Forgot Password - Profify</title>
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
            <h1 style="font-size: 70px;color: #000000;"><strong>Forgot Password</strong></h1>

                <span style="margin-left:15px;margin-right:15px;">If you forgot your password, enter the email attached to your account and we will send you a reset email. Emails usually take 1-5 minutes to be sent.</span>
                <br>
            
            <form style="display: inline-block;" action="" method="POST">
            
            <input class="form-control" type="email" name="fp_email" style="width: 300px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="E-mail Address" required="">

            <button class="btn" type="submit" name="fp_submit" style="background-color: black;color: white;margin-top: 20px;width: 50%;margin-bottom:190px;">Reset Password</button>

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
                    <p class="text-left" style="margin-top:5%;margin-bottom:3%;"><strong>© <?php echo date("Y");?> Profify. All Rights Reserved</strong></p>
                </div>
                <div class="col-12 col-sm-6 col-md-6" style="margin-top: 30px;">
                    <div style="margin-bottom: 0px;height: 24px;"><a href="about" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">about us</a><a href="legal" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">legal</a>
                    <a href="contact" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">contact us</a>
                        
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