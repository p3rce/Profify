<?php

include('inc/config.php');

session_start();

if(isset($_SESSION['username'])){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

} else{

    header("Location: login");

}


function isFirstLogin(){
    global $con;
    global $currentuser;




        //is user first login
        


        $checkLogin = mysqli_query($con, "SELECT firstlogin FROM users WHERE username='$currentuser'");
        $checkLoginRow = mysqli_fetch_assoc($checkLogin);


        if(isset($_SESSION['username'])){

            if($checkLoginRow['firstlogin'] == 1){
                //first login
    
                header("location: createapage");
            } else{
    
                header("location: $currentuser");
    
    
            }
        
        } else{
        
            header("Location: login");
        
        }





}


isFirstLogin();



?>

<html>

<img src="https://upload.wikimedia.org/wikipedia/commons/6/66/An_up-close_picture_of_a_curious_male_domestic_shorthair_tabby_cat.jpg">


</html>