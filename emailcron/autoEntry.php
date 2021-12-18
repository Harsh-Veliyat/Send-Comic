<?php
    include_once 'cronmail.php';
    $cronmail = new cronmail();
    
    $selectquery = "select * from emaillist";
    $squery = $this->query($selectquery);
    if($squery)
    {
        echo "yes";
    }

    //$cronmail->sendMail("harshveliyat@gmail.com" , "https://imgs.xkcd.com/comics/barrel_cropped_(1).jpg" , "Checking image sending", "harshveliyat@gmail.com", "Harsh", "No-reply", "barrel_cropped_(1) (1).png");


?>