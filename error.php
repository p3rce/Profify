<?php

include('inc/config.php');
include('inc/header.php');



function userNameNotFoundErrorMessage(){
    echo '<div style="margin-top:50px;text-align:center;">
    
    
    <h2>😪Sorry, this page is not available😪</h2>

        <span>The account you are trying to reach does not exist or the owner may have changed their username</span>
    
    
    
    ';
}

function userAccountBannedErrorMessage(){
    echo '<div style="margin-top:50px;text-align:center;">
    
    
    <h2>👮This account has been terminated👮</h2>

        <span>This account has been banned for violating our Terms of Use & Community Guidelines.</span>
    
    
    
    ';
}

function pageDoesNotExist(){
    echo '<div style="margin-top:50px;text-align:center;">
    
    
    <h2>😬Page Not Found😬</h2>

        <span>The page you are requesting does not exist</span>
    
    
    
    ';
}




?>

<!DOCTYPE html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Error #<?php echo $_GET['error_id'];?> - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">

    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />
</head>

<body style="min-height: 400px;margin-bottom: 300px;clear: both;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->

    <!-- Start: AccountsGrouo -->


    
    <div>
        <div class="container">


        <?php

        if($_GET['error_id']){

            $error_id = mysqli_real_escape_string($con, $_GET['error_id']);

            
            if($error_id == "320"){


                //Username not found

                userNameNotFoundErrorMessage();


            } elseif($error_id == "420"){

                userAccountBannedErrorMessage();


            } elseif($error_id == "416"){
                pageDoesNotExist();
            }
            
            
            
            
            else{

                header("location: login");

            }





        } else{
            header("location: login");
        }



        ?>
            
        </div>
    </div>
    <!-- End: AccountsGrouo -->
    <!-- <footer class="d-block" style="background-color: rgba(0,0,0,0.75);color: rgb(255,255,255);margin-top: 50%;position: fixed;left: 0;bottom: 0;width: 101%;/*background-color: rgba(255,0,0,0.07);*//*color: white;*/text-align: center;height: 138px;/*display: inline-flex;*/">
        <h1 class="text-center" style="font-size: xx-large;margin-top: 8px;">Sign Up today and create your own page!</h1>
        <div style="text-align: center;"><button class="btn btn-primary" type="button" style="background-color: rgb(255,252,0);color: rgb(0,0,0);font-weight: 700;/*margin-bottom: -60px;*/box-shadow: none;border-color: yellow;">Create A Page</button></div>
    </footer> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>