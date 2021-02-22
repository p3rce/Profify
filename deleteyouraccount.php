<?php

$deleteAccountDisabled = true;

include('inc/config.php');

include('inc/header.php');



if(isset($_SESSION['username'])){

    if(deleteAccountDisabled == true){
        header("location: home");
    } else {
 
    $currentuser = $_SESSION['username'];



    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

    $row = mysqli_fetch_assoc($user_query);

    

    }



} else{



    header("Location: login");



}







if(isset($_GET['username'])){





    

  

  

    $requested_username = mysqli_real_escape_string($con, $_GET['username']);



    $requested_username = strip_tags($requested_username);



    





        //first make sure logged in user is the username in url



            if($requested_username != $currentuser){



                header("location: home");





            } else{



                //do nothing





                









            }





  

  

  

  } else{

      header("location: login");

  }











  

function deleteRequestedAccount(){

    global $con; 

    global $currentuser;

    global $row;



    $userID = $row['id'];





    if(mysqli_query($con, "DELETE FROM users WHERE username='$currentuser'")){





        if(mysqli_query($con, "DELETE FROM userlinks WHERE userid='$userID'")){



            header("location: logout");





        }

    }









}





if(isset($_POST['deleteAccount'])){

    $password = mysqli_real_escape_string($con, $_POST['userpassword']);

    $password = strip_tags($password);

    $password = md5($password);



    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmuserpassword']);

    $confirmpassword = strip_tags($confirmpassword);

    $confirmpassword = md5($confirmpassword);









        //check if password is actual user password





        if($password != $confirmpassword){

            echo '<div class="alert alert-danger text-center" role="alert">

                Passwords do not match!

                </div>';

        } else{





            $userPassword = $row['userpassword'];







                if($userPassword == $password){



                    deleteRequestedAccount();





                } else{

                    echo '<div class="alert alert-danger text-center" role="alert">

                    Password incorrect!

                </div>';

                }





        }







}























?>

<!DOCTYPE html>

<html>







<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Delete Account - Profify</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/styles.min.css">



    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />

    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />

    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />

</head>



<style type="text/css">

    .form-control:focus {

        border-color: transparent;

        box-shadow: 0 0 0 0.2rem yellow;

    } 





      </style>



<body style="min-height: 400px;margin-bottom: 300px;clear: both;">

   

    <!-- Start: AccountsGrouo -->





    

    <div>

        <div class="container" style="text-align:center;">

             <h1 style="text-align:center;margin-top:20px;">Delete Account</h1>

            <form action="" method="POST">

                <span style="font-size:large;">We're sorry to see you go 😢. Deleting your account will delete your profile and all pages you have linked to it. <br><strong style="color:red;">You cannot undo this action</strong></span>

                    <br>

                    <label style="float:left;">Enter Password</label>

                    <input type="password" id="userPassword" class="form-control" required name="userpassword" />

                    <label style="float:left;margin-top:10px;">Re-Enter Password</label>

                    <input type="password" id="confirmUserPassword" required class="form-control" name="confirmuserpassword" />



                    <input type="checkbox" id="checkme" style="margin-top:10px;" required /><span>I agree I cannot undo this action</span>

                    <br>

                    <button type="submit" id="sendNewSms" disabled="true" name="deleteAccount" style="margin-top:10px;" class="btn btn-danger">Delete Account</button>







                </form>

        </div>

    </div>

    <!-- End: AccountsGrouo -->

    <!-- <footer class="d-block" style="background-color: rgba(0,0,0,0.75);color: rgb(255,255,255);margin-top: 50%;position: fixed;left: 0;bottom: 0;width: 101%;/*background-color: rgba(255,0,0,0.07);*//*color: white;*/text-align: center;height: 138px;/*display: inline-flex;*/">

        <h1 class="text-center" style="font-size: xx-large;margin-top: 8px;">Sign Up today and create your own page!</h1>

        <div style="text-align: center;"><button class="btn btn-primary" type="button" style="background-color: rgb(255,252,0);color: rgb(0,0,0);font-weight: 700;/*margin-bottom: -60px;*/box-shadow: none;border-color: yellow;">Create A Page</button></div>

    </footer> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>



    <script type="text/javascript">



        var checker = document.getElementById('checkme');

        var sendbtn = document.getElementById('sendNewSms');

        var userPassword = document.getElementById('userPassword');

        var confirmUserPassword = document.getElementById('confirmUserPassword');

        

        checker.onchange = function(){

        if(this.checked){

            sendbtn.disabled = false;

        } else {

            sendbtn.disabled = true;

        }



        }





    </script>

    

</body>



</html>