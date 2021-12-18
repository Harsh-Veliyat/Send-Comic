<?php
    session_start();

    include 'dbcon.php';
    if(isset($_GET['token'])){
        $token = $_GET['token']; 
        echo $token;
        $updatequery = "update emaillist set status ='active' where token = '$token' ";
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