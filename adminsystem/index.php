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
            header("location: ../error?error_id=420");
        }



} else{

    header("location: ../login");

}





if(isset($_POST['loginSubmit'])){

    //Admin wants to search a users file
    
    $search_email = mysqli_real_escape_string($con, $_POST['userUsername']); //User's Email
    
    
      //Check if email even registered to account
      $account_check = mysqli_query($con, "SELECT * FROM users WHERE username='$search_email'");
      $account_check_num = mysqli_num_rows($account_check);
      $account_check_row = mysqli_fetch_assoc($account_check);




      if($account_check_row['isadmin'] == 1){


        echo '
        <div class="alert alert-danger text-center" role="alert">
                    This account is a Staff Account and cannot be viewed
                      </div>
        
        ';



      } else{


        if($account_check_num == "0"){
            //No account exists
            echo '
            <div class="alert alert-danger text-center" role="alert">
                         No account with that username exists!
                          </div>
            
            ';
          } else{
            //Account with that email exists, so redirect


                //add action to logs
                $action = "VIEW USER";
                $description = "Admin accessed users information of " . $search_email . "";
                $dateofaction = date("F j, Y, g:i a");
                $admin_username = $currentuser;


                mysqli_query($con, "INSERT INTO admin_logs (admin_action, admin_description, dateofaction, admin_username)
                VALUES('$action','$description','$dateofaction','$admin_username')");



            $account_id = $account_check_row['id'];
            header("Location: viewuser?id=$account_id");
          }




      }
      






      

    
    
    
    
    }





    function getTotalUsers(){
        global $con;

        $totalUsersQuery = mysqli_query($con, "SELECT * FROM users");

        $totalUsers = mysqli_num_rows($totalUsersQuery) * 12;

        echo "<h3 style='font-weight:bold;color:red;'>" . $totalUsers . "</h3>";
    }


    function getTotalActiveSessions(){
        global $con;

        $totalActiveSessionsQuery = mysqli_query($con, "SELECT * from user_sessions");
        $totalActiveSessionsNum = mysqli_num_rows($totalActiveSessionsQuery);

        echo "<h3 style='font-weight:bold;color:red;'>" . $totalActiveSessionsNum . "</h3>";
    }





?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>

<body style="background-color: #fffc00;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">
            <h2 style="font-size: 50px;color: #000000;"><strong>Site Stats</strong></h1>

            <h3>Total Live Accounts:</h3><?php getTotalUsers();?>

            <h3>Total Sessions Active:</h3><?php getTotalActiveSessions();?>
            
            <h2 style="font-size: 50px;color: #000000;"><strong>User Search</strong></h1>

            <form style="display: inline-block;" action="" method="POST">
            
            <input class="form-control" type="text" name="userUsername" style="width: 372px;border: none;margin-top: 16px;border:none;box-shadow:none;" placeholder="Username" required="">
                    
            <button class="btn" type="submit" name="loginSubmit" style="background-color: black;color: white;margin-top: 20px;width: 50%;">Search</button>
            <br>


            </form>

            <br>
            <a style="width:50%;margin-top:50px;" href="viewreports" class="btn btn-success">VIEW ABUSE REPORTS</a>

        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>