<?php

include('inc/header.php');
include('inc/config.php');

session_start();

if(isset($_SESSION['username'])){

   header("location: home");

} else{

    

}






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6Leq39QUAAAAAHUJFKdaXSPYvavU0o1uDnzVkT45',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $captcha = post_captcha($_POST['g-recaptcha-response']);

    if (!$captcha['success']) {
        // What happens when the CAPTCHA wasn't checked
        echo '
        <div class="alert alert-danger text-center" role="alert">
         Captcha not filled out!
        </div>
        ';
    } else {
        


      // Form handler






      if(isset($_POST['signUpBtn'])){


        //Get form variables
        $userFullName = mysqli_real_escape_string($con, $_POST['userFullName']);
        $userFullName = strip_tags($userFullName);

        $userEmailAddress = mysqli_real_escape_string($con, $_POST['userEmailAddress']);
        $userEmailAddress = strip_tags($userEmailAddress);

        $OlduserUsername = mysqli_real_escape_string($con, $_POST['userUsername']);

        $userUsername = strtolower($OlduserUsername);
        $userUsername = strip_tags($userUsername);
 
        $userPassword = mysqli_real_escape_string($con, $_POST['userPassword']);
        $userPassword = strip_tags($userPassword);

        $userConfirmPassword = mysqli_real_escape_string($con, $_POST['userConfirmPassword']);
        $userConfirmPassword = strip_tags($userConfirmPassword);

        $userBio = mysqli_real_escape_string($con, $_POST['userBio']);
        $userBio = strip_tags($userBio);

        $dayBorn = mysqli_real_escape_string($con, $_POST['dayofbirth']);
        $dayBorn = strip_tags($dayBorn);

        $monthBorn = mysqli_real_escape_string($con, $_POST['monthofbirth']);
        $monthBorn = strip_tags($monthBorn);

        $yearBorn = mysqli_real_escape_string($con, $_POST['yearofbirth']);
        $yearBorn = strip_tags($yearBorn);

        $dateOfBirth = $yearBorn . '-' . $monthBorn . '-' . $dayBorn;

        


        //Additional Variables
        $signup_ip = $_SERVER['REMOTE_ADDR']; //Sign up IP
        $isVerified = 0; //Is the user verified
        $isBanned = 0; //Is the users account banned
        $isAdmin = 0; //Is the user an admin
        $first_login = 1; //Is first login


        //Profile Picture
        // $newProfilePhoto = time().'_'.$_FILES['fileToUpload']['name'];
        // $target = 'profilephotos/' . $newProfilePhoto;
        // $currentuserid = $row['id'];
        // $fileType = $_FILES['fileToUpload']['type'];
        // $fileExt = explode('.', $newProfilePhoto);
        // $fileActualExt = strtolower(end($fileExt));
        // $allowed = array('jpg', 'jpeg', 'png');

        //Username






            if($userPassword != $userConfirmPassword){
                //passwords are not equal
                echo '<div class="alert alert-danger text-center" role="alert">
            Password and Confirm Password do not match!
                </div>';
            } else{

                    //is email address in use?

                $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$userEmailAddress'");
                $e_num = mysqli_num_rows($e_check);


                if($e_num == 1){
                    //email already exists
                    
                    echo '<div class="alert alert-danger text-center" role="alert">
            The email you gave is already in use!
                </div>';
                } else{

                        //check if username exists
                    $u_check = mysqli_query($con, "SELECT username FROM users WHERE username='$userUsername'");

                    $badusernamecheck = mysqli_query($con, "SELECT banned_username FROM banned_usernames WHERE banned_username='$userUsername'");
                    
                    if(mysqli_num_rows($u_check)>0 || strlen($userUsername) < 3 || strlen($userUsername) > 27 || preg_match('/^[a-zA-Z0-9_]+((\.(-\.)*-?|-(\.-)*\.?)[a-zA-Z0-9_]+)*$/', $userUsername) == false || mysqli_num_rows($badusernamecheck)>0 ){

    echo '<div class="alert alert-danger text-center" role="alert">
            The username you entered is in use!
                </div>';

 }

                else{


                        // if(in_array($fileActualExt, $allowed)){

                        //     move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);
                
                             //everything is good

                             $encryptedPassword = md5($userPassword);
                             $newProfilePhoto = "defaultprofilephoto.jpg";

                             $sql = "INSERT INTO users (fullname, email, username, userpassword, bio, birthday, profilepic, signup_ip, lastlogin_ip,
                             isverified, isbanned, isadmin, firstlogin) VALUES('$userFullName', '$userEmailAddress',
                             '$userUsername', '$encryptedPassword', '$userBio', '$dateOfBirth', '$newProfilePhoto', '$signup_ip', '', '$isVerified', '$isBanned', '$isAdmin', '$first_login')";
 
 
                             if(mysqli_query($con, $sql)){
 
                                header("location: login");
 
 
                             } else{
 
                                echo '<div class="alert alert-danger text-center" role="alert">
                                Error! Your account was not created!
                                    </div>';
 
 
                             }
                    
                
                
                
                        // } else{
                
                        //     echo 'invalid file type';
                
                
                        // } // end if in array of files allowed










                    } //end is username taken check




                } //end is email in use check





            } //end is user password equal



        
        






        








    }





    }




}
    






?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link type="image/ico" rel="shortcut icon" href="favicon.ico" />
    <link type="image/png" rel="shortcut icon" href="assets/img/sunshinelogo.png" />
    <link rel="apple-touch-icon" href="assets/img/sunshinelogo.png" />

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




</head>

<body style="background-color: #fffc00;min-height: 400px;margin-bottom: 300px;clear: both;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;margin-left:20px;">
            <h1 style="font-size: 70px;color: #000000;"><strong>Sign Up</strong></h1>
            <form style="display: inline-block;" enctype="multipart/form-data" action="" method="POST">
            <span style="font-size: 15px;">Sign Up now! People want to connect with you 😊</span>
            <input class="form-control" type="text" name="userFullName" style="width: 340px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Full Name" required="">


            <input class="form-control" type="email" name="userEmailAddress" style="width: 340px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Email" required="">


                
                    <input class="form-control" type="text"  autocomplete="off" name="userUsername" id="UserName" onkeyup="checkname();" style="width: 340px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Username" required="">
                    <p id="name_status"></p>



                    
                    <input class="form-control" type="password" name="userPassword"  autocomplete="off" style="width: 340px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Password" required="">


                    <input class="form-control" type="password" name="userConfirmPassword" autocomplete="off" style="width: 340px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Confirm Password" required="">

                    <div class="control-group" style="margin-top:10px;width:340px;" >
                        <label for="dob-day" class="control-label">Date of birth</label>
                        <div class="controls" style="display:flex;">
                            <select class="form-control" style="width:30%;border: none;margin-top: 16px;border: none;box-shadow: none;margin-left:10px;margin-right:10px;" name="dayofbirth" id="dob-day">
                            <option value="" disabled selected>Day</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            </select>
                            <select class="form-control" style="width:30%;border: none;margin-top: 16px;border: none;box-shadow: none;margin-left:10px;margin-right:10px;" name="monthofbirth" id="dob-month">
                            <option value="" disabled selected>Month</option>
                            
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                            </select>
                            <select class="form-control" style="width:30%;border: none;margin-top: 16px;border: none;box-shadow: none;margin-left:10px;margin-right:10px;" name="yearofbirth" id="dob-year">
                            <option value="" disabled selected>Year</option>
                            
                            <!-- <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option> -->
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            <option value="1969">1969</option>
                            <option value="1968">1968</option>
                            <option value="1967">1967</option>
                            <option value="1966">1966</option>
                            <option value="1965">1965</option>
                            <option value="1964">1964</option>
                            <option value="1963">1963</option>
                            <option value="1962">1962</option>
                            <option value="1961">1961</option>
                            <option value="1960">1960</option>
                            <option value="1959">1959</option>
                            <option value="1958">1958</option>
                            <option value="1957">1957</option>
                            <option value="1956">1956</option>
                            <option value="1955">1955</option>
                            <option value="1954">1954</option>
                            <option value="1953">1953</option>
                            <option value="1952">1952</option>
                            <option value="1951">1951</option>
                            <option value="1950">1950</option>
                            <option value="1949">1949</option>
                            <option value="1948">1948</option>
                            <option value="1947">1947</option>
                            <option value="1946">1946</option>
                            <option value="1945">1945</option>
                            <option value="1944">1944</option>
                            <option value="1943">1943</option>
                            <option value="1942">1942</option>
                            <option value="1941">1941</option>
                            <option value="1940">1940</option>
                            <!-- <option value="1939">1939</option>
                            <option value="1938">1938</option>
                            <option value="1937">1937</option>
                            <option value="1936">1936</option>
                            <option value="1935">1935</option>
                            <option value="1934">1934</option>
                            <option value="1933">1933</option>
                            <option value="1932">1932</option>
                            <option value="1931">1931</option>
                            <option value="1930">1930</option>
                            <option value="1929">1929</option>
                            <option value="1928">1928</option>
                            <option value="1927">1927</option>
                            <option value="1926">1926</option>
                            <option value="1925">1925</option>
                            <option value="1924">1924</option>
                            <option value="1923">1923</option>
                            <option value="1922">1922</option>
                            <option value="1921">1921</option>
                            <option value="1920">1920</option>
                            <option value="1919">1919</option>
                            <option value="1918">1918</option>
                            <option value="1917">1917</option>
                            <option value="1916">1916</option>
                            <option value="1915">1915</option>
                            <option value="1914">1914</option>
                            <option value="1913">1913</option>
                            <option value="1912">1912</option>
                            <option value="1911">1911</option>
                            <option value="1910">1910</option>
                            <option value="1909">1909</option>
                            <option value="1908">1908</option>
                            <option value="1907">1907</option>
                            <option value="1906">1906</option>
                            <option value="1905">1905</option>
                            <option value="1904">1904</option>
                            <option value="1903">1903</option>
                            <option value="1901">1901</option>
                            <option value="1900">1900</option> -->
                            </select>
                        </div>
                        </div>
                    
                        <div style="margin-top: 20px;"><label><strong>Customize Profile</strong></label>

                        

                    <div style="margin-top:10px;margin-bottom:20px;">


                        </div>

                        
                        
                        <input class="form-control" type="text" name="userBio" style="width: 320px;border: none;margin-top: 16px;border: none;box-shadow: none;" placeholder="Bio">

                        <!-- <span style="float:right;color:grey;margin-top:5px;">0/50</span> -->
                            <!-- <div><img src="assets/img/defaultprofilephoto.jpg" style="width: 40%;border-radius: 50%;margin-top: 20px;"><label style="display: inherit;margin-top: 15px;">Add a Profile Picture</label></div> -->
                        </div>


                        <div class="form-check text-center" style="margin-top:10px;margin-left0px;"><input required class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1"><strong>By checking this, I agree to the <br><a href="legal" style="color:black;text-decoration:underline;">Terms of Use</a> and <a href="legal" style="color:black;text-decoration:underline;">Privacy Policy</a></strong></label></div>
                        
                        <div style="margin-top:15px;margin-bottom:15px;margin-left:30px;"><div class="text-center g-recaptcha" data-sitekey="6Leq39QUAAAAAJKFZB39zadTBqxPYmjTdBAxXHS0"></div></div>


                        <button class="btn" name="signUpBtn" type="submit" style="background-color: black;color: white;margin-top: 20px;width: 50%;">SIGN UP</button>
                        
                        <div style="margin-top: 15px;"><a href="login" style="color: black;margin-bottom: 10px;text-decoration: none;">Have an account already? Sign In</a></div>
        </form>
    </div>
    <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    <!-- <div class="footer-2" style="position: fixed;left: 0;bottom: 0;width: 100%;background-color: black;color: white;text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-8 col-sm-6 col-md-6">
                    <p class="text-left" style="margin-top:5%;margin-bottom:3%;"><strong>© 2020 Profify. All Rights Reserved</strong></p>
                </div>
                <div class="col-12 col-sm-6 col-md-6" style="margin-top: 30px;">
                    <div style="margin-bottom: 0px;height: 24px;"><a href="about" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">about us</a><a href="legal" style="color: white;text-decoration: none;margin-left: 10px;margin-right: 10px;">legal</a>
                        
                    </div>
                    <p class="text-right" style="margin-top: 4%;margin-bottom: 10%%;font-size: 1em;"></p>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
</body>

</html>