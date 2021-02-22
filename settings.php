<?php



include('inc/config.php');

include('inc/header.php');





if(isset($_SESSION['username']) || isset($_SESSION['sessionID'])){



    $currentuser = $_SESSION['username'];



    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");

    $row = mysqli_fetch_assoc($user_query);



} else{



    header("Location: login");



}













if(isset($_POST['generalSettingsBtn'])){





    $newFullName = mysqli_real_escape_string($con, $_POST['changeFullName']);

    $newFullName = strip_tags($newFullName);

    

    $newEmail = mysqli_real_escape_string($con, $_POST['changeEmail']);

    $newEmail = strip_tags($newEmail);

    $newEmail = str_replace(' ', '', $newEmail);





    $newBio = mysqli_real_escape_string($con, $_POST['changeBio']);

    $newBio = strip_tags($newBio);



    $newCurrentCity = mysqli_real_escape_string($con, $_POST['changeCity']);

    $newCurrentCity = strip_tags($newCurrentCity);



    if($newCurrentCity == " "){

        //send nothing

    } else{

        $newCurrentCity == $newCurrentCity;

    }



    $quietMode = mysqli_real_escape_string($con, $_POST['quietMode']);

    $quietMode = strip_tags($quietMode);







    $currentuserid = $row['id'];



    function remove_emoji($userFullName){

        return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $userFullName);

    }

  

  $cleanedFullName = remove_emoji($newFullName);

  $cleanedEmail = remove_emoji($newEmail);





    if(strlen($newFullName) >= 30){

        echo '<div class="alert alert-danger text-center" role="alert">

            Fullname must be 30 characters or less!

                </div>';

    } else{

        

        if(strlen($newEmail) == 0){



            echo '<div class="alert alert-danger text-center" role="alert">

            E-mail cannot be empty!

                </div>';





        } else{







            if(strlen($newBio) >= 150){

                echo '<div class="alert alert-danger text-center" role="alert">

                Bio must be 150 characters or less!

                    </div>';

            } else{

    

    

                $sql = "UPDATE users SET fullname='$newFullName',

                email='$cleanedEmail', bio='$newBio', currentcity='$newCurrentCity', quietmode='$quietMode' WHERE id='$currentuserid'";

            

            

                    if(mysqli_query($con, $sql)){

                        

                        header("location: $currentuser");

            

                        

                    } else{

                        echo '<div class="alert alert-danger text-center" role="alert">

                        Error! Please try again later!

                            </div>';

                    }

    

    

    

    

    

            }















        }





        

















    }



    

    

   









}





if(isset($_POST['changeProfilePicButton'])){



    $newProfilePhoto = time().'_'.$_FILES['fileToUpload']['name'];

    $target = 'profilephotos/' . $newProfilePhoto;

    $currentuserid = $row['id'];

    $fileType = $_FILES['fileToUpload']['type'];

    $fileExt = explode('.', $newProfilePhoto);

    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');



        if(in_array($fileActualExt, $allowed)){



            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);



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





function displayCurrentCity(){

    global $con; 

    global $row;



    $currentcity = $row['currentcity'];



    if($row['isverified'] == 1){

        // echo '<div><label style="margin-top: 1px;margin-bottom: 4px;">Current City</label><input name="changeCity" class="form-control" type="text" style="width: 350px;margin: auto;margin-top:5px;margin-bottom:5px;" value="' . $row['currentcity'] . '"></div>';



        echo '<div><label style="margin-top:1px;margin-bottom:4px;">Current Country</label>

        

        

        <select id="country" name="changeCity" class="form-control" style="width: 350px;

        margin: auto;

        margin-top: 5px;

        margin-bottom: 5px;">

        <option value=" " disabled selected>Select A Country</option>

        <option value="' . $currentcity . '" selected>' . $currentcity . '</option>

        <option value="">None</option>

        <option value="Afghanistan">Afghanistan</option>

        <option value="Åland Islands">Åland Islands</option>

        <option value="Albania">Albania</option>

        <option value="Algeria">Algeria</option>

        <option value="American Samoa">American Samoa</option>

        <option value="Andorra">Andorra</option>

        <option value="Angola">Angola</option>

        <option value="Anguilla">Anguilla</option>

        <option value="Antarctica">Antarctica</option>

        <option value="Antigua and Barbuda">Antigua and Barbuda</option>

        <option value="Argentina">Argentina</option>

        <option value="Armenia">Armenia</option>

        <option value="Aruba">Aruba</option>

        <option value="Australia">Australia</option>

        <option value="Austria">Austria</option>

        <option value="Azerbaijan">Azerbaijan</option>

        <option value="Bahamas">Bahamas</option>

        <option value="Bahrain">Bahrain</option>

        <option value="Bangladesh">Bangladesh</option>

        <option value="Barbados">Barbados</option>

        <option value="Belarus">Belarus</option>

        <option value="Belgium">Belgium</option>

        <option value="Belize">Belize</option>

        <option value="Benin">Benin</option>

        <option value="Bermuda">Bermuda</option>

        <option value="Bhutan">Bhutan</option>

        <option value="Bolivia">Bolivia</option>

        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>

        <option value="Botswana">Botswana</option>

        <option value="Bouvet Island">Bouvet Island</option>

        <option value="Brazil">Brazil</option>

        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>

        <option value="Brunei Darussalam">Brunei Darussalam</option>

        <option value="Bulgaria">Bulgaria</option>

        <option value="Burkina Faso">Burkina Faso</option>

        <option value="Burundi">Burundi</option>

        <option value="Cambodia">Cambodia</option>

        <option value="Cameroon">Cameroon</option>

        <option value="Canada">Canada</option>

        <option value="Cape Verde">Cape Verde</option>

        <option value="Cayman Islands">Cayman Islands</option>

        <option value="Central African Republic">Central African Republic</option>

        <option value="Chad">Chad</option>

        <option value="Chile">Chile</option>

        <option value="China">China</option>

        <option value="Christmas Island">Christmas Island</option>

        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>

        <option value="Colombia">Colombia</option>

        <option value="Comoros">Comoros</option>

        <option value="Congo">Congo</option>

        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>

        <option value="Cook Islands">Cook Islands</option>

        <option value="Costa Rica">Costa Rica</option>

        <option value="Cote D ivoire">Cote D ivoire</option>

        <option value="Croatia">Croatia</option>

        <option value="Cuba">Cuba</option>

        <option value="Cyprus">Cyprus</option>

        <option value="Czech Republic">Czech Republic</option>

        <option value="Denmark">Denmark</option>

        <option value="Djibouti">Djibouti</option>

        <option value="Dominica">Dominica</option>

        <option value="Dominican Republic">Dominican Republic</option>

        <option value="Ecuador">Ecuador</option>

        <option value="Egypt">Egypt</option>

        <option value="El Salvador">El Salvador</option>

        <option value="Equatorial Guinea">Equatorial Guinea</option>

        <option value="Eritrea">Eritrea</option>

        <option value="Estonia">Estonia</option>

        <option value="Ethiopia">Ethiopia</option>

        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>

        <option value="Faroe Islands">Faroe Islands</option>

        <option value="Fiji">Fiji</option>

        <option value="Finland">Finland</option>

        <option value="France">France</option>

        <option value="French Guiana">French Guiana</option>

        <option value="French Polynesia">French Polynesia</option>

        <option value="French Southern Territories">French Southern Territories</option>

        <option value="Gabon">Gabon</option>

        <option value="Gambia">Gambia</option>

        <option value="Georgia">Georgia</option>

        <option value="Germany">Germany</option>

        <option value="Ghana">Ghana</option>

        <option value="Gibraltar">Gibraltar</option>

        <option value="Greece">Greece</option>

        <option value="Greenland">Greenland</option>

        <option value="Grenada">Grenada</option>

        <option value="Guadeloupe">Guadeloupe</option>

        <option value="Guam">Guam</option>

        <option value="Guatemala">Guatemala</option>

        <option value="Guernsey">Guernsey</option>

        <option value="Guinea">Guinea</option>

        <option value="Guinea-bissau">Guinea-bissau</option>

        <option value="Guyana">Guyana</option>

        <option value="Haiti">Haiti</option>

        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>

        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>

        <option value="Honduras">Honduras</option>

        <option value="Hong Kong">Hong Kong</option>

        <option value="Hungary">Hungary</option>

        <option value="Iceland">Iceland</option>

        <option value="India">India</option>

        <option value="Indonesia">Indonesia</option>

        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>

        <option value="Iraq">Iraq</option>

        <option value="Ireland">Ireland</option>

        <option value="Isle of Man">Isle of Man</option>

        <option value="Israel">Israel</option>

        <option value="Italy">Italy</option>

        <option value="Jamaica">Jamaica</option>

        <option value="Japan">Japan</option>

        <option value="Jersey">Jersey</option>

        <option value="Jordan">Jordan</option>

        <option value="Kazakhstan">Kazakhstan</option>

        <option value="Kenya">Kenya</option>

        <option value="Kiribati">Kiribati</option>

        <option value="Korea, Democratic Peoples Republic of">Korea, Democratic Peoples Republic of</option>

        <option value="Korea, Republic of">Korea, Republic of</option>

        <option value="Kuwait">Kuwait</option>

        <option value="Kyrgyzstan">Kyrgyzstan</option>

        <option value="Lao Peoples Democratic Republic">Lao Peoples Democratic Republic</option>

        <option value="Latvia">Latvia</option>

        <option value="Lebanon">Lebanon</option>

        <option value="Lesotho">Lesotho</option>

        <option value="Liberia">Liberia</option>

        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>

        <option value="Liechtenstein">Liechtenstein</option>

        <option value="Lithuania">Lithuania</option>

        <option value="Luxembourg">Luxembourg</option>

        <option value="Macao">Macao</option>

        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>

        <option value="Madagascar">Madagascar</option>

        <option value="Malawi">Malawi</option>

        <option value="Malaysia">Malaysia</option>

        <option value="Maldives">Maldives</option>

        <option value="Mali">Mali</option>

        <option value="Malta">Malta</option>

        <option value="Marshall Islands">Marshall Islands</option>

        <option value="Martinique">Martinique</option>

        <option value="Mauritania">Mauritania</option>

        <option value="Mauritius">Mauritius</option>

        <option value="Mayotte">Mayotte</option>

        <option value="Mexico">Mexico</option>

        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>

        <option value="Moldova, Republic of">Moldova, Republic of</option>

        <option value="Monaco">Monaco</option>

        <option value="Mongolia">Mongolia</option>

        <option value="Montenegro">Montenegro</option>

        <option value="Montserrat">Montserrat</option>

        <option value="Morocco">Morocco</option>

        <option value="Mozambique">Mozambique</option>

        <option value="Myanmar">Myanmar</option>

        <option value="Namibia">Namibia</option>

        <option value="Nauru">Nauru</option>

        <option value="Nepal">Nepal</option>

        <option value="Netherlands">Netherlands</option>

        <option value="Netherlands Antilles">Netherlands Antilles</option>

        <option value="New Caledonia">New Caledonia</option>

        <option value="New Zealand">New Zealand</option>

        <option value="Nicaragua">Nicaragua</option>

        <option value="Niger">Niger</option>

        <option value="Nigeria">Nigeria</option>

        <option value="Niue">Niue</option>

        <option value="Norfolk Island">Norfolk Island</option>

        <option value="Northern Mariana Islands">Northern Mariana Islands</option>

        <option value="Norway">Norway</option>

        <option value="Oman">Oman</option>

        <option value="Pakistan">Pakistan</option>

        <option value="Palau">Palau</option>

        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>

        <option value="Panama">Panama</option>

        <option value="Papua New Guinea">Papua New Guinea</option>

        <option value="Paraguay">Paraguay</option>

        <option value="Peru">Peru</option>

        <option value="Philippines">Philippines</option>

        <option value="Pitcairn">Pitcairn</option>

        <option value="Poland">Poland</option>

        <option value="Portugal">Portugal</option>

        <option value="Puerto Rico">Puerto Rico</option>

        <option value="Qatar">Qatar</option>

        <option value="Reunion">Reunion</option>

        <option value="Romania">Romania</option>

        <option value="Russian Federation">Russian Federation</option>

        <option value="Rwanda">Rwanda</option>

        <option value="Saint Helena">Saint Helena</option>

        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>

        <option value="Saint Lucia">Saint Lucia</option>

        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>

        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>

        <option value="Samoa">Samoa</option>

        <option value="San Marino">San Marino</option>

        <option value="Sao Tome and Principe">Sao Tome and Principe</option>

        <option value="Saudi Arabia">Saudi Arabia</option>

        <option value="Senegal">Senegal</option>

        <option value="Serbia">Serbia</option>

        <option value="Seychelles">Seychelles</option>

        <option value="Sierra Leone">Sierra Leone</option>

        <option value="Singapore">Singapore</option>

        <option value="Slovakia">Slovakia</option>

        <option value="Slovenia">Slovenia</option>

        <option value="Solomon Islands">Solomon Islands</option>

        <option value="Somalia">Somalia</option>

        <option value="South Africa">South Africa</option>

        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>

        <option value="Spain">Spain</option>

        <option value="Sri Lanka">Sri Lanka</option>

        <option value="Sudan">Sudan</option>

        <option value="Suriname">Suriname</option>

        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>

        <option value="Swaziland">Swaziland</option>

        <option value="Sweden">Sweden</option>

        <option value="Switzerland">Switzerland</option>

        <option value="Syrian Arab Republic">Syrian Arab Republic</option>

        <option value="Taiwan, Province of China">Taiwan, Province of China</option>

        <option value="Tajikistan">Tajikistan</option>

        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>

        <option value="Thailand">Thailand</option>

        <option value="Timor-leste">Timor-leste</option>

        <option value="Togo">Togo</option>

        <option value="Tokelau">Tokelau</option>

        <option value="Tonga">Tonga</option>

        <option value="Trinidad and Tobago">Trinidad and Tobago</option>

        <option value="Tunisia">Tunisia</option>

        <option value="Turkey">Turkey</option>

        <option value="Turkmenistan">Turkmenistan</option>

        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>

        <option value="Tuvalu">Tuvalu</option>

        <option value="Uganda">Uganda</option>

        <option value="Ukraine">Ukraine</option>

        <option value="United Arab Emirates">United Arab Emirates</option>

        <option value="United Kingdom">United Kingdom</option>

        <option value="United States">United States</option>

        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>

        <option value="Uruguay">Uruguay</option>

        <option value="Uzbekistan">Uzbekistan</option>

        <option value="Vanuatu">Vanuatu</option>

        <option value="Venezuela">Venezuela</option>

        <option value="Viet Nam">Viet Nam</option>

        <option value="Virgin Islands, British">Virgin Islands, British</option>

        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>

        <option value="Wallis and Futuna">Wallis and Futuna</option>

        <option value="Western Sahara">Western Sahara</option>

        <option value="Yemen">Yemen</option>

        <option value="Zambia">Zambia</option>

        <option value="Zimbabwe">Zimbabwe</option>

    </select>







    </div>

        

        

        

        

        

        

        ';

    } else{

        //display nothing

    }



}





if(isset($_POST['changePassword'])){



$currentuserid = $row['id'];

$newPassword = mysqli_real_escape_string($con, $_POST['newpassword']);

$newPassword = strip_tags($newPassword);

$confirmNewPassword = mysqli_real_escape_string($con, $_POST['confirmnewpassword']);

$confirmNewPassword = strip_tags($confirmNewPassword);











    if($newPassword != $confirmNewPassword){

        //passwords don't match

        echo '<div class="alert alert-danger text-center" role="alert">

            Passwords do not match!

                </div>';



    } else{



        $encryptedPassword = md5($newPassword);







        $sql2 = "UPDATE users SET userpassword='$encryptedPassword' WHERE id='$currentuserid'";





            if(mysqli_query($con, $sql2)){



                mysqli_query($con, "DELETE FROM user_sessions WHERE currentuserid='$currentuserid'");





                header("location: logout");



            } else{

                echo '<div class="alert alert-danger text-center" role="alert">

            Error! Please try again later!

                </div>';

            }











    }







}







// function enableSelected(){

//     global $con;

//     global $row;



//     if($row['quietmode'] == 1){

//         echo 'checked';

//     } else{



//     }



// }





// function disableSelected(){

//     global $con;

//     global $row;



//     if($row['quietmode'] == 0){

//         echo 'checked';

//     } else{

        

//     }



// }











?>





<!DOCTYPE html>

<html>



<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

    

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>User Settings - Profify</title>

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

            <h3 style="font-size: 50px;color: #000000;/*margin-bottom: -64px;*/"><strong>Settings</strong></h3>

        </div>

        <!-- End: Main info -->

        <!-- Start: SettingsMain -->

        <div style="text-align: center;">

            <!-- Start: MainAccount -->

            <div>

                <h1>General Settings</h1>

                <img id="output" src="profilephotos/<?php echo $row['profilepic'];?>" style="height: 200px;width: 200px;border-radius: 50%;border: 6px solid #ffeb3bcc;margin-bottom:10px;object-fit:cover;box-shadow: 0px 5px 5px 1px;"><br>

                <a href="uploadnewprofilephoto" style="margin-top:20px;margin-bottom:20px;text-decoration:none;">Change Profile Photo</a>

                <form action="" method="POST" style="margin-top:10px;">

                    <div><label style="margin-top: 1px;margin-bottom: 4px;">Full Name</label><input required name="changeFullName" class="form-control" type="text" style="width: 350px;margin: auto;margin-top:5px;margin-bottom:5px;" value="<?php echo $row['fullname'];?>"></div>

                    <div><label style="margin-top: 1px;margin-bottom: 4px;">Email Address</label><input required name="changeEmail" class="form-control" type="text" style="width: 350px;margin: auto;margin-top:5px;margin-bottom:5px;" value="<?php echo $row['email'];?>"></div>

                    <div><label style="margin-top: 1px;margin-bottom: 4px;">Bio</label><input name="changeBio" class="form-control" type="text" style="width: 350px;margin: auto;margin-top:5px;margin-bottom:5px;" maxlength="100" value="<?php echo $row['bio'];?>"></div>

                    



                    <?php



                        if($row['isverified'] == 1){



                            echo '

                            

                            <div style="font-size:15px;margin-top:20px;">

                    

                    <label style="margin-top:1px;margin-bottom:4px;font-weight:bold;">Quiet Mode 🤫</label><br>

                    <input type="radio" style="margin-left: -4px;" name="quietMode" value="1">

                    <span>Enable Quiet Mode</span><br>

                    <input type="radio" name="quietMode" value="0">

                    <span>Disable Quiet Mode</span><br>

                    <span>Quiet Mode will hide all your posted links but will not delete them!</span>

                    

                        </div>

                            

                            

                            

                            ';







                        }





                    ?>

                    









                    <button class="btn btn-primary" name="generalSettingsBtn" type="submit" style="margin-top: 15px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border: none;width: 300px;"><strong>Save</strong></button>

                    </form>





            </div>



            







            <!-- End: MainAccount -->

            <!-- Start: PassworldMain -->

            <div style="margin-top: 20px;">

                <h1>Change Password</h1>

                

                <form action="" method="POST">

                    <div><label style="margin-top: 1px;margin-bottom: 4px;">New Password</label><input required class="form-control" type="password" name="newpassword" style="width: 350px;margin: auto;"></div>

                    <div><label style="margin-top: 1px;margin-bottom: 4px;">Confirm New Password</label><input required class="form-control" type="password" name="confirmnewpassword" style="width: 350px;margin: auto;" value=""></div>

                    <button

                        class="btn btn-primary" name="changePassword" type="submit" style="margin-top: 15px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border: none;width: 300px;"><strong>Change Password</strong></button>

                </form>

                <span style="color: rgb(255,0,0);">Changing your password will log you out of your current session</span>

            </div>

            <!-- End: PassworldMain -->

            <!-- Start: PassworldMain -->

            <div style="margin-top: 20px;">

                <h1>Account Security</h1>

                <div style="margin-top: 20px;display:none;"><a href="deleteyouraccount?username=<?php echo $currentuser;?>" style="margin-top: 20px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border: none;"><strong>Delete Account</strong></a></div>

                <div style="margin-top: 30px;"><a href="changeusername" style="margin-top: 40px;margin-bottom: 20px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border: none;"><strong>Change Username</strong></a></div>



                <!-- <div style="margin-top: 35px;"><a href="changeusername?username=<?php echo $currentuser;?>" style="margin-top: 20px;margin-bottom: 0px;background-color: #fffc00;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;color: rgb(0,0,0);border-radius: 3%;text-decoration: none;border: none;"><strong>CHANGE USERNAME</strong></a></div> -->

            </div>

            <!-- End: PassworldMain -->

        </div>

        <!-- End: SettingsMain -->

    </div>

    <script>

var loadFile = function(event) {

	var image = document.getElementById('output');

	image.src = URL.createObjectURL(event.target.files[0]);

};







$(document).ready(

function(){

    $('input:file').change(

        function(){

            if ($(this).val()) {

                $('input:submit').attr('disabled',false);

                // or, as has been pointed out elsewhere:

                // $('input:submit').removeAttr('disabled'); 

            } 

        }

        );

});

</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>



</html>