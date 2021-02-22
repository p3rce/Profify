<?php



include('inc/config.php');

include('inc/header.php');



if(isset($_SESSION['username'])){



    $currentuser = $_SESSION['username'];



    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

    $row = mysqli_fetch_assoc($user_query);



} else{



    

    



}





function getJoinUsAd(){

    global $con;

    global $row;

    global $currentuser;

    global $pagerow;



    $userBeingViewed = $pagerow['username'];





    if(empty($currentuser)){

        echo '<footer class="d-block" style="background-color: rgba(0,0,0,0.75);color: rgb(255,255,255);margin-top: 30%;position: fixed;left: 0;bottom: 0;width: 101%;/*background-color: rgba(255,0,0,0.07);*//*color: white;*/text-align: center;height: 150px;/*display: inline-flex;*/">

        <h1 class="text-center" style="font-size: xx-large;margin-top: 8px;">Sign Up Today & Create Your Own Page!</h1>

        

        <div style="text-align: center;"><a href="signup" class="btn btn-primary" style="background-color: rgb(255,252,0);color: rgb(0,0,0);font-weight: 700;/*margin-bottom: -60px;*/box-shadow: none;border-color: yellow;">Create A Page</a></div>

    </footer>';

    } else{



    }





}





if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 

    $link = "https"; 

else

    $link = "http"; 

  

// Here append the common URL characters. 

$link .= "://"; 

  

// Append the host(domain name, ip) to the URL. 

$link .= $_SERVER['HTTP_HOST']; 

  

// Append the requested resource location to the URL 

$link .= $_SERVER['REQUEST_URI']; 

      

// Print the link 









if(isset($_GET['username'])){





    //username in url

  

  

    $requested_username = mysqli_real_escape_string($con, $_GET['username']);

  

  

  

  

      //Check if username in db

  

      $username_query = mysqli_query($con, "SELECT * FROM users WHERE username='$requested_username'");

      $username_num = mysqli_num_rows($username_query);

  

  

        if($username_num == 1){

          //Username exists

          $pagerow = mysqli_fetch_assoc($username_query);

          $currentProfileUserID = $pagerow['id'];

        } else{

          //Username does not exist

          header("location: error?error_id=320");

        }





        //check if banned



        if($pagerow['isbanned'] == "1"){

            header("location: error?error_id=420");

        }

  

  

  

  } else{

      header("location: error?error_id=320");

  }





  











  function showEditProfileBtn(){

      global $con;

      global $row;

      global $currentuser;

      global $requested_username;





      if($currentuser == $requested_username){

          //this is logged in users page

          



          echo '<a href="settings" style="margin-top: 0px;margin-bottom: 0px;background-color: #fffc00;padding-top: 11.28px;padding-right: 10px;padding-bottom: 11.4px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;margin-left: 10px;"><strong>Edit Profile</strong></a>';



      } else{

          //dont show btn

      }





  }



  function showReportBtn(){

    global $con;

    global $pagerow;

    global $currentuser;

    global $requested_username;







        if($currentuser == $requested_username){

            //this is logged in users page

            

    

    

        }else{

            // show btn

            echo '<a href="reportaccount?username=' . $requested_username . '" style="margin-top: 0px;margin-left:10px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10.8px;padding-right: 10px;padding-bottom: 11px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border:none;cursor:pointer;word-wrap: break-word;""><strong>Report</strong></a>';

        }



    







}





  function showVerifiedBadge(){

      global $con; 

      global $pagerow;

      

        if($pagerow['isverified'] == "1"){

            //verified

            echo '<img src="assets/img/verified2.png" title="Verified Profile" style="width: 35px;margin-bottom:5px;margin-left:-2px;">️<br><br>';

        } else{

            //not verified

        }



  }





  function marginAdjust(){

    global $con; 

    global $pagerow;

    

      if($pagerow['isverified'] == "1"){

          //verified

          echo 'margin-top: -55px;';

      } else{

          //not verified

          echo 'margin-top:-5px;';



      }

  }



function getUserBio(){

    global $con; 

    global $pagerow;



    $rawBio = $pagerow['bio'];

    $rawBioLength = strlen($rawBio);





    $str = $rawBio;

    //how many @s are in the bio?

    substr_count($str, '@');



    //replace every @ and put in a link and also how the fuck does this even work i copy and pasted this shit 

    echo preg_replace('/(^|\s)@([\w_\.]+)/', '$1<a style="text-decoration:none;text-transform:lowercase;" title="@$2" href="$2">@$2</a>', $str);







}





function adjustBioSpacing(){

    global $con; 

    global $row;

    

      

}













  function getUserLinks(){

      global $con; 

      global $pagerow;

      global $currentuser;

      global $requested_username;



        //get all user posts based on userid

        $userid = $pagerow['id'];



        $sql = mysqli_query($con, "SELECT * FROM userlinks WHERE userid='$userid' ORDER BY pinned DESC, id ASC");

        // $sql = mysqli_query($con, "SELECT * FROM userlinks WHERE userid='$userid' limit 0,10");







            

        while($profile_row = mysqli_fetch_assoc($sql)){



            if($currentuser == $requested_username){

            //     echo '

            

            // <div class="col-md-4 text-center" style="margin-top: 30px;"><a target="_blank" href="' . $profile_row['profile_link'] . '" style="font-size: 40px;margin-left: 9px;text-decoration: none;color: black;background-color: rgb(255,252,0);padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;border-radius: 3%;display: inherit;"><strong>' . $profile_row['profile_name'] . '</strong></a>

            // <div style="margin-top:10px;">       

            // </div>

            // </div>

            // ';



            echo '<a target="_blank" href="' . $profile_row['profile_link'] . '" class="d-block p-2  text-black text-center" style="font-size: 25px;color:black;margin-left: 0px;text-decoration: none;color: black;background-color: rgb(255,252,0);padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;border-radius: 5px;display: inherit;margin-top:10px;margin-bottom:10px;box-shadow: 0px 2px 5px 1px;"><strong>' . $profile_row['profile_name'] . '</strong></a>

            <div class="text-center"><a href="edit_link?edit_id=' . $profile_row['id'] .'" style="color: black;text-decoration: none;margin-right: 5px;">Edit Link</a>

            

            </div>

            ';









            

          



            

            



            





            } else{

                echo '<a target="_blank" id="link-btn" href="' . $profile_row['profile_link'] . '" class="d-block p-2  text-black text-center" style="font-size: 25px;color:black;margin-left: 0px;text-decoration: none;color: black;background-color: rgb(255,252,0);padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;border-radius: 5px;display: inherit;margin-top:30px;margin-bottom:30px;box-shadow: 0px 2px 5px 1px;"><strong>' . $profile_row['profile_name'] . '</strong></a>

            ';

            }

        }



            





  }





  function nothingInBioAdjust(){

      global $con;

      global $profilerow;







        if($profilerow['bio'] == " " || $profilerow['currentcity'] == " "){

            echo 'margin-bottom: -25px;';

        } else{

            echo 'margin-bottom: 25px;';

        }

  }





  















?>

<!DOCTYPE html>

<html>



<style type="text/css">



body {

    font-family: Verdana, Geneva,



}



#form1 {

    display: block;

}





a#link-btn:hover{

    background-color:black;

}





</style>





<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title><?php echo $pagerow['fullname'];?> (<?php echo "@" . $requested_username;?>) - Profify</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/styles.min.css">

    <script src="https://kit.fontawesome.com/fed7abe0cd.js" crossorigin="anonymous"></script>



    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />

    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />

    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />

    



</head>



<body style="min-height: 400px;margin-bottom: 300px;clear: both;">



<div class="alert alert-success text-center" id="form1" style="display:none;" role="alert">

                                Profile Link Copied!

                                    </div>

    <!-- Start: Navigation with Button -->

    

    <!-- End: Navigation with Button -->

    <div style="/*padding-bottom: 0px;*/">

        <!-- Start: Main info -->

        <div class="text-center" style="margin-top: 35px;text-align:center;">

        <div>

        <img src="profilephotos/<?php echo $pagerow['profilepic'];?>" style="height: 150px;width: 150px;border-radius: 50%;border: 6px solid #ffeb3bcc;margin-left:20px;object-fit:cover;box-shadow: 0px 5px 5px 1px;">



        <div style="margin-bottom: -20px;">



        <div>

            <h4 style="font-size: 37px;color: #000000;margin-bottom: 0px;margin-top:8px;margin-left:0px;"><strong style="margin-left:20px;"><?php echo $pagerow['fullname'];?></strong><span style="width: auto;height: auto;font-size: 40px;margin-left: 4px;"><?php showVerifiedBadge();?></span></h4>

        </div>





        

            <div style="<?php marginAdjust();?>"><span style="font-size: 23px;color: rgb(110, 110, 110);font-weight:400;">@<?php echo $pagerow['username'];?></span>

            </div>

                <p class="lead" style="padding-left: 0px;padding-right: 0px;margin-left: 20px;margin-right: 20px;margin-bottom:25px;font-size:24px;"><?php getUserBio();?><br><span title="My Location!" style="color:grey;font-size:19px;padding-left:30px;padding-right:30px;text-transform:uppercase;">

                <?php 

                if($pagerow['currentcity'] == ""){



                } else{

                    echo '<i style="font-size:16px;display:inline-block;" class="fas fa-map-marker-alt 2x"></i>';

                }





                ?>

                

<?php echo $pagerow['currentcity'];?></span></p>

                

            </div>

            

            

            <div style="<?php adjustBioSpacing();?>">

            

            <button class="" type="button" id="copy-btn" onclick="setClipboard('<?php echo $link;?>')" style="margin-top: 0px;margin-left:10px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border:none;cursor:pointer;"><strong>Copy Profile Link</strong></button>







<?php showReportBtn();?>



            

            <?php showEditProfileBtn();?>



            



        </div>

        <!-- End: Main info -->

        <!-- Start: Divider -->

        <div style="border-bottom: 1px solid rgba(0,0,0,0.55);/*width: 50%;*/margin: auto;padding-top: 18px;display: none;"></div>

        <!-- End: Divider -->

    </div>

    <!-- Start: AccountsGrouo -->





    

    <div>

        <div class="container">



            <form action="" method="POST">



                <div style="margin-top:50px;"  id="all_rows">

        

            <!-- <div class="row" style="margin-top: 40px;margin-bottom: 29px;"> -->



                    <?php

                        $currentuserid = $pagerow['id'];

                        $totalPosts = mysqli_query($con, "SELECT * FROM userlinks WHERE userid='$currentuserid'");

                        $totalPostsNum = mysqli_num_rows($totalPosts);

                        $profileUsername = $pagerow['username'];

                        $currentUsername = $row['username'];



                           





                            if($pagerow['quietmode'] == 1){



                                echo '<div style="margin:auto;text-align:center;">

                            

                            <h1><strong>' . $pagerow['fullname'] . '</strong> <br>has not linked any profiles yet😭</h1>

                            

                            

                            </div>

                            ';







                            } else{





                                if($totalPostsNum == 0){

                                    echo '<div style="margin:auto;text-align:center;">

                                    

                                    <h1><strong>' . $pagerow['fullname'] . '</strong> <br>has not linked any profiles yet😭</h1>

                                    

                                    

                                    </div>

                                    ';

                                } else{

                                    getUserLinks();

                                }







                            }







                            









                        



                        





                        ?>

                        



                

                        </div>



                        <input type="hidden" id="row_no" value="10">

                        <input type="hidden" id="currentuserid" value="<?php echo $currentProfileUserID;?>">





                <!-- </div> -->



                </form>

        </div>

    </div>



    </div>



    



    

    <!-- End: AccountsGrouo -->

    <?php getJoinUsAd();?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    

    <script type="text/javascript">



$(document).ready(function() {

  $("#copy-btn").click(function() {

    $("#form1").toggle();

  });

});



function setClipboard(value) {

    var tempInput = document.createElement("input");

    tempInput.style = "position: absolute; left: -1000px; top: -1000px";

    tempInput.value = value;

    document.body.appendChild(tempInput);

    tempInput.select();

    document.execCommand("copy");

    document.body.removeChild(tempInput);

}

        

        </script>









<script type="text/javascript">

$(window).scroll(function (){

  if($(document).height() <= $(window).scrollTop() + $(window).height())

  {

	loadmore();

  }

});



function loadmore(){

   var val = document.getElementById("row_no").value;

   var userid = document.getElementById("currentuserid").value;

   $.ajax({

   type: 'post',

   url: 'fetchMoreLinks.php',

   data: {

          getresult:val

          currentuserid:userid

      },

   success: function (response) {

   var content = document.getElementById("all_rows");

   content.innerHTML = content.innerHTML+response;



// We increase the value by 10 because we limit the results by 10

      document.getElementById("row_no").value = Number(val)+10;

      }

      });

    }

</script>  



 



</body>







</html>