<?php
    session_start();

    include 'dbcon1.php';
    
    if(isset($_GET['token'])){
        $token = $_GET['token']; 
        $updatequery = "update `emaillist` set `status` ='inactive' ,`unsubscribed_on` = CURRENT_TIMESTAMP where `token` = '$token' ";
        $uquery = mysqli_query($con,$updatequery);

        if($uquery)
        {
            echo "<br>Thanks!";
        }
        else{
            echo "try again";
        }
    }
?>