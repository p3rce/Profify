<?php

include('inc/config.php');
include('inc/header.php');

error_reporting(0);


if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

} else{

    header("Location: login");

}






if(isset($_POST['changeProfilePicButton'])){

    $newProfilePhoto = time().'_'.$_FILES['fileToUpload']['name'];
    $target = 'profilephotos/' . $newProfilePhoto;
    $currentuserid = $row['id'];
    $fileType = $_FILES['fileToUpload']['type'];
    $fileExt = explode('.', $newProfilePhoto);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png','gif');

    function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
          $exif = exif_read_data($filename);
          if($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){
              $img = imagecreatefromjpeg($filename);
              $deg = 0;
              switch ($orientation) {
                case 3:
                  $deg = 180;
                  break;
                case 6:
                  $deg = 270;
                  break;
                case 8:
                  $deg = 90;
                  break;
              }
              if ($deg) {
                $img = imagerotate($img, $deg, 0);        
              }
              // then rewrite the rotated image back to the disk as $filename 
              imagejpeg($img, $filename, 95);
            } // if there is some rotation necessary
          } // if have the exif orientation info
        } // if function exists      
      }







        if(in_array($fileActualExt, $allowed)){

            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);
            correctImageOrientation($target);


                //if current is default profile picture, don't delete photo from directory

                $defaultProfilePhotoExtension = "defaultprofilephoto.jpg"; //default image
                $userCurrentProfilePhotoExtension = $row['profilepic']; //Users current profile photo


                    if($defaultProfilePhotoExtension == $userCurrentProfilePhotoExtension){
                        //don't delete

                    } else{


                        //delete old profile photo
                        $newUserCurrentProfilePhotoExtension = "profilephotos/$userCurrentProfilePhotoExtension";
                        unlink($newUserCurrentProfilePhotoExtension);
                        



                    }






            //next update database with link to new profile photo
            $sql3 = "UPDATE users SET profilepic='$newProfilePhoto' WHERE id='$currentuserid'";
    
                if(mysqli_query($con, $sql3)){
                    header("location: $currentuser");
                } else{
                    echo '<div class="alert alert-danger text-center" role="alert">
            Error! Please try again later!
                </div>';
                }
    



        } else{

            echo '<div class="alert alert-danger text-center" role="alert">
            Invalid File Type! Only photos are allowed!
                </div>';


        }



}















?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Settings - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    
    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />


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
            <h3 style="font-size: 50px;color: #000000;/*margin-bottom: -64px;*/"><strong>Update Profile Picture</strong></h3>
        </div>
        <!-- End: Main info -->
        <!-- Start: SettingsMain -->



        <div class="container" style="text-align:center;">

        <img id="output" src="profilephotos/<?php echo $row['profilepic'];?>" style="height: 200px;width: 200px;border-radius: 50%;border: 6px solid #ffeb3bcc;margin-bottom:10px;object-fit:cover;box-shadow: 0px 5px 5px 1px;"><br>


        <form action="" method="POST" enctype="multipart/form-data" style="margin-top:20px;">
            <label for="file-upload" class="custom-file-upload">
            <i class="fa fa-cloud-upload"></i> Change Profile Picture
            </label>
            <input id="file-upload" required name="fileToUpload" onchange="loadFile(event)" type="file"/>

            

            <br>
            <button id="changePic" style="width:30%;" type="submit" name="changeProfilePicButton" class="btn btn-success">Save</button>


            </form>



    </div>


</body>


<script type="text/javascript">
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};


$(document).ready(
    function(){
        $('input:submit').attr('disabled',true);
        $('input:file').change(
            function(){
                if ($(this).val()){
                    $('input:submit').removeAttr('disabled'); 
                }
                else {
                    $('input:submit').attr('disabled',true);
                }
            });
    });
</script>



</html>

































            

    </div>

            
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>


</html>
