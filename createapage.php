<?php
include('inc/config.php');
include('inc/header.php');
session_start();

if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

    $user_id = $row['id'];

} else{

    header("Location: login");

}




    if(isset($_POST['submit'])){
    
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


    
    $socialSites = mysqli_real_escape_string($con, $_POST['social_site']);
    $socialSites = strip_tags($socialSites);

    $usernamesEntered = mysqli_real_escape_string($con, $_POST['usernamesEntered']);
    $usernamesEntered = strip_tags($usernamesEntered);

    $profileTitles = mysqli_real_escape_string($con, $_POST['social_title']);
    $profileTitles = strip_tags($profileTitles);

    foreach($_POST['social_site'] as $key=>$value)
{
$socialSite= mysqli_real_escape_string($con, $_POST["social_site"][$key]);
$socialSite=strip_tags($socialSite);

$username=mysqli_real_escape_string($con, $_POST["usernamesEntered"][$key]);
$username=strip_tags($username);
$profileTitle= mysqli_real_escape_string($con, $_POST["social_title"][$key]);
$profileTitle = strip_tags($profileTitle);

if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $username = addScheme2($username);
}
else {
}


$finalLink = $socialSite . $username;

$finalLink = addScheme($finalLink);



mysqli_query($con, "INSERT INTO userlinks (profile_name, profile_link, userid) VALUES('$profileTitle', '$finalLink', '$user_id')");
                    
                 
//update users set first login to 1

if($row['firstlogin'] == 1){
    mysqli_query($con, "UPDATE users SET firstlogin=0 WHERE username='$currentuser'");
} else{
    
}


header("location: $currentuser");


// Run your query here for one complete entry and it will repeat with loop


}



    }




?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Add Profiles - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/fed7abe0cd.js" crossorigin="anonymous"></script>

    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap js library -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
    .form-control:focus {
        border-color: transparent;
        box-shadow: 0 0 0 0.2rem yellow;
    } 


      </style>

<body style="min-height: 400px;margin-bottom: 300px;clear: both;">
    <!-- Start: Navigation with Button -->



    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">
            <h3 style="font-size: 50px;color: #000000;/*margin-bottom: -64px;*/"><strong>Add Profiles</strong></h3>
            
            <!-- Start: yourProfiles -->
            <div style="margin: auto;width: 75%">
                
            <form method="POST" action="">
            
            <div class=" fieldGroup">
                <div class="inputgrp">

                <label style="float:left;">Social Media Quick Add</label>
                    <select name="social_site[]" required id="socialQuickAdd" class="form-control">
                    <option value="" disabled selected>Select A Site</option>
                    <option value="" style="font-weight:bold;">Custom Site or Email</option>
                    <option value="https://www.facebook.com/">Facebook</option>
                    <option value="https://www.github.com/">GitHub</option>
                    <option value="https://www.instagram.com/">Instagram</option>
                    <option value="https://www.linkedin.com/in/">Linkedin</option>
                    <option value="https://www.pinterest.com/">Pinterest</option>
                    <option value="https://www.reddit.com/u/">Reddit</option>
                    <option value="https://www.snapchat.com/add/">Snapchat</option>
                    <option value="https://www.soundcloud.com/">SoundCloud Account</option>
                    <option value="https://open.spotify.com/user/">Spotify Account</option>
                    <option value="https://www.tiktok.com/@">TikTok</option>
                    <option value="https://www.twitter.com/">Twitter</option>
                    <option value="https://www.vsco.co/">VSCO</option>
                    
                    





                    </select>

                    <br>
                    <label style="float:left">Enter Your Username</label>
                    <input id="social_username" required name="usernamesEntered[]" type="text" class="form-control" />


                    <br>

                    <label style="float:left">Profile Title</label>
    <input id="social_username" name="social_title[]" required type="text" class="form-control" />

    <br>


                    <div class="input-group-addon"> 
                        <a href="javascript:void(0)" style="margin-top:10px;margin-bottom:20px;background-color:yellow;border:none;color:black;font-weight:bold;padding: 10px 40px 10px 40px;" class="btn addMore">Add Another Link</a>
                    </div>
                </div>
            </div>
            
            <input type="submit" style="margin-top:40px;margin-bottom:20px;background-color:yellow;border:none;color:black;font-weight:bold;width:50%;height:10%;" name="submit" class="btn" value="Create Page"/>
            
        </form>


        
        <!-- copy of input fields group -->
        <div class=" fieldGroupCopy" style="display: none;">
        <div class="inputgrp">

<label style="float:left;">Social Media Quick Add</label>

<select name="social_site[]" required id="socialQuickAdd" class="form-control">
                    <option value="" disabled selected>Select A Site</option>
                    <option value="" style="font-weight:bold;">Custom Site or Email</option>
                    <option value="https://www.facebook.com/">Facebook</option>
                    <option value="https://www.github.com/">GitHub</option>
                    <option value="https://www.instagram.com/">Instagram</option>
                    <option value="https://www.linkedin.com/in/">Linkedin</option>
                    <option value="https://www.pinterest.com/">Pinterest</option>
                    <option value="https://www.reddit.com/u/">Reddit</option>
                    <option value="https://www.snapchat.com/add/">Snapchat</option>
                    <option value="https://www.soundcloud.com/">SoundCloud Account</option>
                    <option value="https://open.spotify.com/user/">Spotify Account</option>
                    <option value="https://www.tiktok.com/@">TikTok</option>
                    <option value="https://www.twitter.com/">Twitter</option>
                    <option value="https://www.vsco.co/">VSCO</option>
                    
                    





                    </select>
    

    <br>
    <label  id="enterYourLbl" style="float:left">Enter Your Username</label>
    <input id="social_username" required name="usernamesEntered[]" type="text" class="form-control" />


    <br>

    <label style="float:left">Profile Title</label>
    <input id="social_username" required name="social_title[]" type="text" class="form-control" />

    <br>

    <div class="input-group-addon"> 
                    <a href="javascript:void(0)" style="margin-top:10px;margin-bottom:20px;background-color:yellow;border:none;color:black;font-weight:bold;padding: 10px 40px 10px 40px;" class="btn remove">Remove Link</a>
                </div>
</div>
        </div>
        





            </div>
            <!-- End: yourProfiles -->
        </div>
        <!-- End: Main info -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
<script>  







$(document).ready(function(){
    //max profile limit
    var maxGroup = 20;
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldGroup').length < maxGroup){
            var fieldHTML = '<div class="inputgrp fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
            $('body').find('.fieldGroup:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldGroup").remove();
    });
});






 </script>
</html>
