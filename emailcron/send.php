<?php
    $server="localhost";
    $user="root";
    $password="";
    $db="emailassignmenttest";
    $con = mysqli_connect($server, $user, $password, $db);

    function sendMail(
        $mailTo,
        $url,
        $token,
        $subject    = "Your Subject",
        $fromMail   = "your@emialaddress.com",
        $fromName   = "from sender",
        $replyTo    = "no-reply",
        $filePath   = "path"
    )
    {
        $LE  = "\n";
        $uid = md5(uniqid(time()));
        $withAttachment = ($filePath !== NULL && file_exists($filePath));

        if($withAttachment){
            $fileName   = basename($filePath);
            $fileSize   = filesize($filePath);
            $handle     = fopen($filePath, "r");
            $content    = fread($handle, $fileSize);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
        }
        $unsub = "http://localhost/emailTest/Emails/emailcron/unsubscribe.php?token=$token"; 
        $message = "<!DOCTYPE html> 
                <html lang='en'>
                <head> 
                <meta charset='UTF-8'> 
                <meta http-equiv='X-UA-Compatible' content='IE=edge'> 
                <meta name='viewport' content='width=device-width, initial-scale=1.0'> 
                <title>template</title>
                <style>
                    a 
                    {
                        color: hotpink;
                    }
                </style> 
                </head> 
                <body> 
                    <img src='" . $url ."'> <br>
                    <form action='$unsub' method='post'><input type=\"submit\" value=\"Unsubscribe\" name=\"submit\">
                </body> 
                </html>";
                //<a href=\"www.google.com?token=".$token."\" target=\"_blank\">Unsubscribe</a>

        $header = "From: ".$fromName." <".$fromMail.">$LE";
        $header .= "Reply-To: ".$replyTo."$LE";
        $header .= "MIME-Version: 1.0$LE";
        $header .= "Content-Type: multipart/mixed, image/png; boundary=\"".$uid."\"$LE";
        $header .= "This is a multi-part message in MIME format.$LE";
        $header .= "--".$uid."$LE";
        $header .= "Content-type:text/html; charset=UTF-8$LE";
        $header .= "Content-Transfer-Encoding: 7bit$LE";
        $header .= $message."$LE";

    
        if($withAttachment){
            $header .= "--".$uid."$LE";
            $header .= "Content-Type: application/octet-stream; name=\"".$fileName."\"$LE";
            $header .= "Content-Transfer-Encoding: base64$LE";
            $header .= "Content-Disposition: attachment; filename=\"".$fileName."\"$LE";
            $header .= $content;
            $header .= "--".$uid."--";
        }   
        return mail($mailTo, $subject, $message, $header);
    }
    //getting json
    $DIRR = getcwd();
    $comnum = mt_rand(1,1000);
    $url_to_image = "https://xkcd.com/" . $comnum . "/info.0.json";
    $my_save_dir = $DIRR . "/";//./
    $filename = "file.json";
    $complete_save_loc = $my_save_dir . $filename;
    file_put_contents($complete_save_loc, file_get_contents($url_to_image));

    //reading json
    $data = file_get_contents("file.json");
    $data = json_decode($data,true);

    $url_to_image = $data["img"];
    $my_save_dir = $DIRR . "/";
    $filename = "image.png";
    $complete_save_loc = $my_save_dir . $filename;
    file_put_contents($complete_save_loc, file_get_contents($url_to_image));
    
    $searchQuery = "select email, token from emaillist where status = 'active'";
    $squery = mysqli_query($con, $searchQuery);
    while($row = mysqli_fetch_assoc($squery)){
        $email = $row['email'];
        $token = $row['token'];
        sendMail($email , $url_to_image, $token ,"Checking image sending", "harshveliyat@gmail.com", "Harsh", "No-reply", "image.png");
    }
?>