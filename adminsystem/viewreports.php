<?php

include('../inc/config.php');
error_reporting(0);
session_start();
if($_SESSION['username']){

    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);

        echo '<nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="border: 1px solid rgb(218,213,213);border-top: none;height: 61px;">
        <div class="container"><a class="navbar-brand" href="index" style="color: #28334AFF;font-size: 26px;">Profify Administration</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav mr-auto"></ul><span class="navbar-text actions"><a href="../' . $currentuser . '" style="text-decoration: none;color: black;font-weight: 300;margin-top: 0px;padding-top: 0px;margin-bottom: 0px;margin-left: 10px;margin-right: 10px;">Go back Home</a></div>
        </div>
    </nav>';


    



}




if(isset($_SESSION['username'])){




    $currentuser = $_SESSION['username'];

    $user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$currentuser'");
    $row = mysqli_fetch_assoc($user_query);



        //check if admin

        if($row['isadmin'] == "1"){
            //is admin
        } else{
            header("location: ../error?error_id=416");
        }



} else{

    header("location: ../login");

}



function getReports(){
    global $con;
    



        //first get all reports from database, ordered from oldest to newest
        $reportsQuery = mysqli_query($con, "SELECT * FROM report_abuse ORDER BY id ASC");
        

        //next echo it all out

        while($reportsRow = mysqli_fetch_assoc($reportsQuery)){

            

            //get correct usernames
            $personWhoReportedID = $reportsRow['report_userid'];
            $personWhoReportedQuery = mysqli_query($con, "SELECT username FROM users WHERE id='$personWhoReportedID'");
            $personWhoReportedRow = mysqli_fetch_assoc($personWhoReportedQuery);
            $personWhoReported = $personWhoReportedRow['username'];




            $personWhoReportedID2 = $reportsRow['report_reporterid'];
            $personWhoReportedQuery2 = mysqli_query($con, "SELECT username FROM users WHERE id='$personWhoReportedID2'");
            $personWhoReportedRow2 = mysqli_fetch_assoc($personWhoReportedQuery2);
            $personWhoReported2 = $personWhoReportedRow2['username'];

            $reportid = $reportsRow['id'];

            


            
           echo ' <tr>
                    <th scope="row">' . $personWhoReported . '</th>
                    <td>' . $personWhoReported2 . '</td>
                    <td>' . $reportsRow['typeofabuse'] . '</td>
                    <td>' . $reportsRow['abusemessage'] . '</td>
                    <td><a class="btn btn-danger" href="delete_report?reportid=' . $reportid . '">Delete</a></td>
                    </tr>


                    ';


        }



    




}













?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin - Profify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">

    <script type="text/javascript">

$(document).ready(function(){

// Load more data
$('.load-more').click(function(){
    var row = Number($('#row').val());
    var allcount = Number($('#all').val());
    row = row + 3;

    if(row <= allcount){
        $("#row").val(row);

        $.ajax({
            url: 'getData.php',
            type: 'post',
            data: {row:row},
            beforeSend:function(){
                $(".load-more").text("Loading...");
            },
            success: function(response){

                // Setting little delay while displaying new content
                setTimeout(function() {
                    // appending posts after last post with class="post"
                    $(".post:last").after(response).show().fadeIn("slow");

                    var rowno = row + 3;

                    // checking row value is greater than allcount or not
                    if(rowno > allcount){

                        // Change the text and background
                        $('.load-more').text("No More Posts!");
                       
                       
                    }else{
                        $(".load-more").text("Load more");
                    }
                }, 2000);


            }
        });
    }else{
        $('.load-more').text("Loading...");

        // Setting little delay while removing contents
        setTimeout(function() {

            // When row is greater than allcount then remove all class='post' element after 3 element
            $('.post:nth-child(3)').nextAll('.post').remove().fadeIn("slow");

            // Reset the value of row
            $("#row").val(0);

            // Change the text and background
            $('.load-more').text("Load more");
            $('.load-more').css("background","#15a9ce");

        }, 2000);


    }

});

});



    </script>
</head>

<body style="background-color: #fffc00;">
    <!-- Start: Navigation with Button -->
    
    <!-- End: Navigation with Button -->
    <div style="/*padding-bottom: 0px;*/">
        <!-- Start: Main info -->
        <div class="text-center" style="margin-top: 35px;">
            <h1 style="font-size: 70px;color: #000000;"><strong>View Reports</strong></h1>
            
            <form style="display: inline-block;width:90%;margin-top:15px;" action="" method="POST">
            
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">Person Who Is Getting Reported</th>
                    <th scope="col">Person Who Sent Report</th>
                    <th scope="col">Type of Abuse</th>
                    <th scope="col">Abuse Message</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php getReports();?>
                    
                </tbody>
                </table>


            </form>
        </div>
        <!-- End: Main info -->
    </div>
    <!-- Start: simple footer -->
    
    <!-- End: simple footer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>