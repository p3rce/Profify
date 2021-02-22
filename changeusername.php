<?php

include('inc/config.php');
include('inc/header.php');


if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

} else{

    header("Location: login");

}



if(isset($_POST['changeUsername'])){

$userUsername = mysqli_real_escape_string($con, $_POST['userUsername']);
$userUsername = strip_tags($userUsername);
$userUsername = strtolower($userUsername);

$userPassword = mysqli_real_escape_string($con, $_POST['userPassword']);
$userPassword = strip_tags($userPassword);


$safeUserPassword = md5($userPassword);




if($row['isverified'] == 1){

    header("location: $currentuser");


} else{

    //check if username exists
$u_check = mysqli_query($con, "SELECT username FROM users WHERE username='$userUsername'");

$badusernamecheck = mysqli_query($con, "SELECT * FROM banned_usernames WHERE banned_username='$userUsername'");


if(mysqli_num_rows($u_check)>0 || strlen($userUsername) < 3 || strlen($userUsername) > 27 || preg_match('/^[a-zA-Z0-9_]+((\.(-\.)*-?|-(\.-)*\.?)[a-zA-Z0-9_]+)*$/', $userUsername) == false || mysqli_num_rows($badusernamecheck)>0 ){
    //username exists

    echo '<div class="alert alert-danger text-center" role="alert">
The username you entered is unavaliable!
</div>';
}   else{



            //get current password
            $currentpassword = $row['userpassword'];


                if($currentpassword != $safeUserPassword){

                    echo '<div class="alert alert-danger text-center" role="alert">
                The password you entered is incorrect!
                </div>';

                } else{

                    //update username
                    $currentID = $row['id'];

                    $updateQuery = "UPDATE users SET username='$userUsername' WHERE id='$currentID'";

                        if(mysqli_query($con, $updateQuery)){

                            header("location: logout");


                        } else{

                            echo '<div class="alert alert-danger text-center" role="alert">
                                Fatal error! Please try again later!
                            </div>';

                        }


                }
       




            }





}










    }

























function disableSubmitBtn(){
    global $con;
    global $row;

    if($row['isverified'] == 1){

        echo 'disabled';


    } else{

    }


}


function hideChangeBtn(){
    global $con;
    global $row;

    if($row['isverified'] == 1){

        echo 'style="display:none;';


    } else{

    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Change Username - Profify</title>
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

    <style type="text/css">

    #changePic{
        margin-top: 50px;
    color: black;
    background-color: yellow;
    border: none;
    font-weight: bold;
    padding-top: 15px;
    padding-bottom: 15px;
    }


    input[type="file"] {
    display: none;
}
.custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    background-color: yellow;
    border-radius: 3%;
    font-weight:bold;
}

.btn-success:not(:disabled):not(.disabled):active:focus, .show>.btn-success.dropdown-toggle:focus {
     box-shadow: none;

    }

    </style>
    


</head>


<body style="min-height: 400px;margin-bottom: 300px;clear: both;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">
            <h3 style="font-size: 50px;color: #000000;/*margin-bottom: -64px;*/"><strong>Change Username</strong></h3>

            <span style="color:red;">Changing your username will log you out of all sessions</span>

        </div>
        <!-- End: Main info -->
        <!-- Start: SettingsMain -->



        <div class="container" style="text-align:center;">



        <form action="" method="POST" enctype="multipart/form-data" style="display:inline-block">

        <div class="text-align:center;">
        <input class="form-control" type="text" <?php disableSubmitBtn();?> required  autocomplete="off" name="userUsername" id="UserName" onkeyup="checkname();" style="width: 372px;margin-top: 16px" placeholder="New Username" required="">
            <p id="name_status"></p>

            <input class="form-control" <?php disableSubmitBtn();?> required type="password"  autocomplete="off" name="userPassword" style="width: 372px;margin-top: 16px;" placeholder="Confirm Password" required="">



            </div>
            <?php

                if($row['isverified']){
                    echo '<div style="margin-top:20px;width:372px;" class="alert alert-danger" role="alert">
                    Verified Accounts cannot change their Username. Please contact us.
                    </div>';
                } else{

                }


                ?>
            
            <br>
            <button <?php hideChangeBtn();?> id="changePic" style="width:30%;" type="submit" name="changeUsername" class="btn btn-success">Save</button>


            </form>



    </div>


</body>


<script type="text/javascript">
function checkname()
{
 var name=document.getElementById( "UserName" ).value;
	
 if(name)
 {
  $.ajax({
  type: 'post',
  url: 'isUsernameAvaliable.php',
  data: {
   user_name:name,
  },
  success: function (response) {
   $( '#name_status' ).html(response);
   if(response=="Available")	
   {
	   $("#name_status").css('color', '#0AC02A', 'important');
    return true;
   }
   else
   {
	   $("#name_status").css('color', '#FF0004', 'important');
    return false;
   }
  }
  });
 }
 else
 {
  $( '#name_status' ).html("");
  return false;
 }
}


</script>



</html>

































            

    </div>

            
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>


</html>
