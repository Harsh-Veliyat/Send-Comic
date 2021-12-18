<?php 
    include 'dbcon.php';
    function sendMail(
        $mailTo,
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

        $message = "<!DOCTYPE html> 
        <html lang='en'>
        <head> 
        <meta charset='UTF-8'> 
        <meta http-equiv='X-UA-Compatible' content='IE=edge'> 
        <meta name='viewport' content='width=device-width, initial-scale=1.0'> 
        <title>template</title> 
        </head> 
        <body> 
            <img src='https://imgs.xkcd.com/comics/barrel_cropped_(1).jpg'> 
        </body> 
        </html>";

        $header = "From: ".$fromName." <".$fromMail.">$LE";
        $header .= "Reply-To: ".$replyTo."$LE";
        $header .= "MIME-Version: 1.0$LE";
        $header .= "Content-Type: multipart/mixed, image/png; boundary=\"".$uid."\"$LE";
        $header .= "This is a multi-part message in MIME format.$LE";
        $header .= "--".$uid."$LE";
        $header .= "Content-type:text/html; charset=UTF-8$LE";
        $header .= "Content-Transfer-Encoding: 7bit$LE";

    
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

    if(isset($_POST['submit']))
    {

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = bin2hex(random_bytes(15));
        // Check if email already exist in database
        $emailQuery = "select * from emaillist where email = '$email'";
        $query = mysqli_query($con,$emailQuery);

        $emailcount = mysqli_num_rows($query);
        if($emailcount > 0){
            echo "Email already exists";
        }else{
            $insertquery ="INSERT INTO `emaillist`(`email`, `subscribed_on`,  `token`, `status`) VALUES ('$email',current_timestamp(),'$token','inactive')";
            $iquery = mysqli_query($con,$insertquery);
            if($iquery) {
                    $sub = "Email Activation for Comic";
                    $mess ="Hi, click in the below link to subscribe http://localhost/EmailTest/Emails/activate.php?token=$token ";
                    $head = "From: harshveliyat@gmail.com";
                    if(mail($email, $sub, $mess, $head)){
                        ?>
                    <script>
                        alert("Check your mail to activate your subscription!");
                    </script>
                <?php
                    }
            }else{
                ?>
                    <script>
                        alert("Error in inserting!");
                    </script>
                <?php
            }
        }
        
    }
    //sendMail("harshveliyat@gmail.com" , "Checking image sending", "harshveliyat@gmail.com", "Harsh", "No-reply", "https://imgs.xkcd.com/comics/barrel_cropped_(1).jpg");

?>

