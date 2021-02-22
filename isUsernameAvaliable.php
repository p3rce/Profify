<?php
include('inc/config.php');



if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];
 $name = strtolower($name);

 $checkdata="SELECT * FROM users WHERE username='$name'";

 $query=mysqli_query($con, $checkdata);

 $badusernamecheck = mysqli_query($con, "SELECT banned_username FROM banned_usernames WHERE banned_username='$name'");
 
 if(mysqli_num_rows($query)>0 || strlen($name) < 3 || strlen($name) > 27 || preg_match('/^[a-zA-Z0-9_]+((\.(-\.)*-?|-(\.-)*\.?)[a-zA-Z0-9_]+)*$/', $name) == false || mysqli_num_rows($badusernamecheck)>0 ){

    echo "Username is not avaliable";

 }
 else
 {
  
 }
 exit();
}



?>