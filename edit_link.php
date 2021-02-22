<?php



include('inc/config.php');

include('inc/header.php');



if(isset($_SESSION['username'])){



    $currentuser = $_SESSION['username'];



    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

    $user = mysqli_fetch_assoc($user_query);



} else{



    header("Location: login");



}







if(isset($_GET['edit_id'])){





    

  

  

    $requested_id = mysqli_real_escape_string($con, $_GET['edit_id']);

    $requested_id = strip_tags($requested_id);



  

  

  

  

      //check

  

        //first check if user logged in is owner of link

        $userID = $user['id'];

        $idLoggedInCheck = mysqli_query($con, "SELECT * FROM userlinks WHERE userid='$userID' AND id='$requested_id'");

        $idLoggedInNum = mysqli_num_rows($idLoggedInCheck);



            if($idLoggedInNum == "1"){

                



                //leave them their



                $link_row = mysqli_fetch_assoc($idLoggedInCheck);









            } else{

                //not correct user

                header("location: login");

            }

  

  

  

  } else{

      header("location: login");

  }











  if(isset($_POST['editLinkSubmit'])){



        $editLinkName = mysqli_real_escape_string($con, $_POST['editLinkName']);

        $editLinkName = strip_tags($editLinkName);



        $editLinkURL = mysqli_real_escape_string($con, $_POST['editLinkURL']);

        $editLinkURL = strip_tags($editLinkURL);









        if(strlen($editLinkName) >= 70){





            echo '<div class="alert alert-danger text-center" role="alert">

               Link Name is too Long!

                </div>';





        } else{



            function addScheme($url, $scheme = 'https://')

                    {

                    return parse_url($url, PHP_URL_SCHEME) === null ?

                        $scheme . $url : $url;

                    }



                    function addScheme2($url, $scheme = 'mailto:')

                    {

                    return parse_url($url, PHP_URL_SCHEME) === null ?

                        $scheme . $url : $url;

                    }





                //check if link starts with www and replace with https



                if(filter_var($editLinkURL, FILTER_VALIDATE_EMAIL)) {

                    $newEditLinkURL = addScheme2($editLinkURL);

                }

                else {

                    // invalid address

                    $newEditLinkURL = addScheme($editLinkURL);

                }







                    $sql = "UPDATE userlinks SET profile_name='$editLinkName', profile_link='$newEditLinkURL' WHERE id='$requested_id'";



            if(mysqli_query($con, $sql)){

    

                header("location: $currentuser");

    

            } else{

                echo '<div class="alert alert-danger text-center" role="alert">

                Fatal Error! Your link was not updated!

                </div>';

            }















                 }

                







    









        

        









  }





  if(isset($_POST['deleteLinkSubmit'])){





        $sql = "DELETE FROM userlinks WHERE id='$requested_id'";



        if(mysqli_query($con, $sql)){

            header("location: $currentuser");

        } else{

            echo 'fatal error';

        }





  }




  function getLinkPinStatus(){
      global $link_row;

        if($link_row['pinned'] == "1"){
            echo 'Unpin Link';
        }else{
            echo 'Pin Link';
        }


  }





  if(isset($_POST['pinLink'])){


        //if this is alr pinned and they pressed to unpin
        $currentUserID = $link_row['userid'];
        $currentLinkID = $link_row['id'];

        if($link_row['pinned'] == "1"){
            //wants to unpin this
            $newPinQuery2 = mysqli_query($con, "UPDATE userlinks SET pinned='0' WHERE id='$currentLinkID'");

            header("Refresh:0");
            
        } else{



            //check if user already pinned a link
        
        $pinLinkCheck = mysqli_query($con,"SELECT * FROM userlinks WHERE userid='$currentUserID' AND pinned='1'");
        $pinLinkNum = mysqli_num_rows($pinLinkCheck);

            if($pinLinkNum == "1"){
                $oldPinnedLink = mysqli_fetch_assoc($pinLinkCheck);
                $oldPinnedID = $oldPinnedLink['id'];
                //already pinned a link so remove old pinned and make this one new pinned
                $removeOldPin = mysqli_query($con, "UPDATE userlinks SET pinned='0' WHERE id='$oldPinnedID'");

                    //now pin this new one
                    $newPinQuery = mysqli_query($con, "UPDATE userlinks SET pinned='1' WHERE id='$currentLinkID'");
                    header("Refresh:0");

            } else{
                //no previous pins
                $newPinQuery = mysqli_query($con, "UPDATE userlinks SET pinned='1' WHERE id='$currentLinkID'");
                header("Refresh:0");

            }




        }
      
        






  }












?>

<!DOCTYPE html>

<html>







<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Edit Link - Profify</title>

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

      <script>

        //MARK: Change Pin btn


        function changePinBtn(e){
            var changePinBtn = document.getElementById("pinLinkBtn");
            e.preventDefault();

                if(changePinBtn.innerText == "Pin Link"){
                    changePinBtn.innerText = "Unpin Link";
                } else if(changePinBtn.innerText == "Unpin Link"){
                    changePinBtn.innerText = "Pin Link";
                }
        }



      </script>



<body style="min-height: 400px;margin-bottom: 300px;clear: both;">

   

    <!-- Start: AccountsGrouo -->





    

    <div>

        <div class="container">

             <h1 style="text-align:center;margin-top:20px;">Edit Link</h1>

            <form action="" method="POST">

                    <label style="margin-top:20px;margin-bottom:20px;">Profile Name</label>

                    <input required type="text" class="form-control" name="editLinkName" value="<?php echo $link_row['profile_name'];?>" />



                    <label style="margin-top:20px;margin-bottom:20px;">Profile URL</label>

                    <input required type="text" class="form-control" name="editLinkURL" value="<?php echo $link_row['profile_link'];?>" />

                    
        



                    <button style="margin-top: 0px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;margin-top:20px;font-weight:bold;" type="submit" class="btn" name="editLinkSubmit">Save Changes</button>


                    <br>


                    <div>

<button class="btn" type="submit" style="margin-top: 0px;margin-bottom: 0px;background-color: #00ff03;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: white;border-radius: 3%;text-decoration: none;margin-top:50px;font-weight:bold;margin-right:20px;" onclick="changePinBtn()" id="pinLinkBtn" name="pinLink" ><?php getLinkPinStatus();?></button>
<button style="margin-top: 0px;margin-bottom: 0px;background-color: red;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: white;border-radius: 3%;text-decoration: none;margin-top:50px;font-weight:bold;" type="submit" class="btn" name="deleteLinkSubmit">Delete <?php echo $link_row['profile_name'];?></button>



</div>


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