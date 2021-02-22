<?php
include('inc/config.php');
include('inc/header.php');

session_start();

if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

} else{

    
    

}


function getLoggedInEmail(){
    global $row;
    global $currentuser;

    if(isempty($currentuser)){

    } else{
        echo $row['email'];
    }


}

function getLoggedInUsername(){
    global $row;
    global $currentuser;

    if(isempty($currentuser)){

    } else{
        echo $row['username'];
    }


}










?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact Us - Profify</title>
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
            <h1>To contact us, email <strong>info@profify.ca</strong></h1>
        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>