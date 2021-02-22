<?php
include('inc/config.php');
if(isset($_POST['getresult'])){

$userid = $_POST['userid'];
$no = $_POST['getresult'];
$select = mysqli_query($con, "SELECT * FROM userlinks WHERE userid='$userid' limit $no,10");

while($row = mysqli_fetch_assoc($select)){
      echo "<p class='rows'>".$row['profile_name']."</p>";
}
exit();
}  
?>