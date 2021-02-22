<?php

include('inc/config.php');
include('inc/header.php');


if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row2 = mysqli_fetch_assoc($user_query);

} else{

    header("Location: login");

}



if(isset($_GET['username'])){


    //username in url

        //first make sure they are logged in



        if(isset($_SESSION['username'])){



            $requested_username = mysqli_real_escape_string($con, $_GET['username']);
            $requested_username = strip_tags($requested_username);

  
  
  
  
            //Check if username in db
        
            $username_query = mysqli_query($con, "SELECT * FROM users WHERE username='$requested_username'");
            $username_num = mysqli_num_rows($username_query);
        
        
              if($username_num == 1){
                //Username exists

                    $row = mysqli_fetch_assoc($username_query);

                



                
              } else{
                //Username does not exist
                header("location: error?error_id=416");
              }



        } else{
            header("location: signup");
        }

  
  
  
  } else{
      header("location: login");
  }



  if($row['isbanned'] == 1){
      header("location: error?error_id=420");
  } else{
      
  }



  function isUserReportingSelf(){
      global $con;
      global $row;
      global $currentuser;
      global $requested_username;

        if($currentuser == $requested_username){
            // user is trying to report themself

            echo 'disabled';
        }

  }

  function isUserReportingSelf2(){
    global $con;
    global $row;
    global $currentuser;
    global $requested_username;

      if($currentuser == $requested_username){
          // user is trying to report themself

          echo '<span style="color:red;margin-top:20px;margin-bottom:10px;">Why are you trying to report yourself? Thats a little sus...</span><br>';
      } else{
          echo "<span style='color:red;margin-top:20px;margin-bottom:10px;'>Don't worry, we won't let " . $row['fullname'] . " know you reported them!</span><br>";
      }

}


  function timesReported(){
    global $con;
    global $row;
    $maxTimes = 1; // amount of times it has to be reported to freeze account
    $userInQuestion = $row['id'];


        $checkReports = mysqli_query($con, "SELECT * FROM report_abuse WHERE report_userid='$userInQuestion'");
        $checkReportsNum = mysqli_num_rows($checkReports);

            if($checkReportsNum >= $maxTimes){


                if($row['reportGodeMode'] == 1){

                    //account has been whitelisted for spam reporting so dont freeze account 


                } else{

                    mysqli_query($con, "UPDATE users SET accountfrozen='1' WHERE id='$userInQuestion'");


                }


                


            } else{
                //do nothing
            }


    //if a user is reported over 50 times, freeze their account automatically for community safety





  }


  function showVerifiedBadge(){
    global $con; 
    global $row;
    
      if($row['isverified'] == "1"){
          //verified
          echo '<img src="assets/img/verified2.png" title="Verified Profile" style="width: 40px;margin-bottom:5px;">️<br><br>';
      } else{
          //not verified
      }

}



    if(isset($_POST['submitReport'])){


        $typeofabuse = mysqli_real_escape_string($con, $_POST['typeofAbuse']);
        $typeofabuse = strip_tags($typeofabuse);

        $explainWhy = mysqli_real_escape_string($con, $_POST['explainWhy']);
        $explainWhy = strip_tags($explainWhy);


        $reporter_userid = $row2['id']; //Person who is reportin
        $reported_userid = $row['id']; //Person who is being reported
        $ip_sentfrom = $_SERVER['REMOTE_ADDR']; //Reporter IP



        $sql = "INSERT INTO report_abuse (report_userid, report_reporterid, typeofabuse, abusemessage, ip_sentfrom)
         VALUES ('$reported_userid' , '$reporter_userid', '$typeofabuse', '$explainWhy', '$ip_sentfrom')";


            if(mysqli_query($con, $sql)){
                
                
                echo '<div class="alert alert-success text-center" role="alert">
                Report Sent! Thank you for keeping our community safe!
                </div>';
                    
                    if($row['isverified'] == "1"){

                    } else{
                        timesReported();
                    }

            } else{

                echo '<div class="alert alert-danger text-center" role="alert">
                Fatal Error! Your report was not sent.
                </div>';
            }




    }

    function marginAdjust(){
        global $con; 
        global $row;
        
          if($row['isverified'] == "1"){
              //verified
              echo 'margin-top: -52px;';
          } else{
              //not verified
              echo 'margin-top:5px;';
    
          }
      }









?>
<!DOCTYPE html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Report <?php echo $row['fullname'];?> - Profify</title>
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

<body style="min-height: 400px;margin-bottom: 300px;clear: both;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">

        <div>
        <img src="profilephotos/<?php echo $row['profilepic'];?>" style="height: 200px;width: 200px;border-radius: 50%;border: 6px solid #ffeb3bcc;margin-left:20px;object-fit:cover;box-shadow: 0px 5px 5px 1px;">
       

        </div>

    
    <div>
        <div class="container">
            <h1 style="margin-top:20px;font-size:24px;margin-bottom:25px;">Report <?php echo $row['fullname'];?><?php showVerifiedBadge();?></h1>
                
            <form action="" style="<?php marginAdjust();?>" method="POST">
            <span>Tell us why you think <?php echo $row['fullname'];?> is breaking the rules</span>
            <div class="form-group" style="margin-top:20px;">
                <label for="exampleFormControlSelect1" style="float:left;">Type of Abuse</label>
                <select required <?php isUserReportingSelf();?> class="form-control" name="typeofAbuse" id="exampleFormControlSelect1">
                <option name="Impersonation Account">Impersonation Account 🙍</option>
                <option name="Inappropirate Username">Inappropirate Username 🆔</option>
                <option name="Posting Inappropriate Site Links">Inappropriate Site Links 🌐</option>
                <option name="Profile Photo or Bio is Inappropriate">Profile Photo/ Bio is Inappropriate 😞</option>
                <option name="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1" style="float:left;">Explain how they are breaking the rules in as much detail as possible</label>
                <textarea <?php isUserReportingSelf();?> required class="form-control" required name="explainWhy" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>

                <?php isUserReportingSelf2(); ?>

                <button <?php isUserReportingSelf();?> type="submit" name="submitReport" class="btn" style="padding: 5px 5px 5px 5px; background-color:yellow; color:black; font-weight:bold;width:30%;margin-top:12px;">Submit</button>
        
            

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
</body>

</html>