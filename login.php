<?php
include('inc/config.php');
include('inc/header.php');

session_start();

if(isset($_SESSION['username'])){

   header("location: home");

} else{

    

}


function generateRandomString($length = 70) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if(isset($_POST['loginSubmit'])){

    //get form variables

    $userUsername = mysqli_real_escape_string($con, $_POST['userUsername']);
    $userUsername = strip_tags($userUsername);

    $userPassword = mysqli_real_escape_string($con, $_POST['userPassword']);
    $userPassword = strip_tags($userPassword);

    $currentIP = $_SERVER['REMOTE_ADDR']; //Sign up IP


    $encryptedPassword = md5($userPassword);




    //check if in database

    $loginCheck = mysqli_query($con, "SELECT username, id, userpassword, isbanned, accountfrozen FROM users WHERE username='$userUsername' AND userpassword='$encryptedPassword'");
    $loginCheckNum = mysqli_num_rows($loginCheck);
    $loginrow = mysqli_fetch_assoc($loginCheck);

    if($loginCheckNum == 1){
        //user exists


            //make sure not banned
            if($loginrow['isbanned'] == "1"){

                echo '<div class="alert alert-danger text-center" role="alert">
                Your account has been banned for violating our Terms of Use and Community Guidelines
                </div>';

            } else{


                if($loginrow['accountfrozen'] == "1"){

                    echo '<div class="alert alert-danger text-center" role="alert">
                    Due to security reasons, we have locked out your account. Please contact us
                </div>';

                } else{
                    

                session_start();
                $_SESSION['username'] = $userUsername;
                $_SESSION['isLoggedIn'] = true;
                
                
                

                $newSessionID = generateRandomString();
                $userID = $loginrow['id'];
                $_SESSION['sessionID'] = $newSessionID;
                    
                    
                    //delete old sessions
                    mysqli_query($con, "DELETE FROM user_sessions WHERE currentuserid=$userID");

                    //start session
                    mysqli_query($con, "INSERT INTO user_sessions (currentuserid, sessionID) VALUES ('$userID', '$newSessionID')");
                    
                    //Update LastLogin Ip
                    mysqli_query($con, "UPDATE users SET lastlogin_ip='$currentIP' WHERE id='$userID'");
                    
                    


                header("location: home");



                }







            }





    } else{
        echo '<div class="alert alert-danger text-center" role="alert">
            Incorrect login Details! Please try again!
                </div>';
    }








}





?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">

    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />
</head>

<body style="background-color: #fffc00;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 5px;">
            <h1 style="font-size: 70px;color: #000000;"><strong>Log In</strong></h1>
            
            <form style="display: inline-block;" action="" method="POST">
            
            <input class="form-control" type="text" name="userUsername" style="width: 372px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="Username" required="">
            
            <input class="form-control" type="password" name="userPassword" style="width: 372px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="Password" required="">
            
            <button class="btn" type="submit" name="loginSubmit" style="background-color: black;color: white;margin-top: 20px;width: 50%;">Log In</button>

                <div style="margin-top: 15px;">
                <a href="forgotpassword" style="color: black;margin-bottom: 10px;text-decoration: none;">Forgot password</a>
                
                <a href="signup" style="display: inherit;color: black;margin-top: 0px;text-decoration: none;">Don't have an account? Create one</a>
                
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