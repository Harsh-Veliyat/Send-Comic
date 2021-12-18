<?php
    include 'dbcon.php';

    class cronmail extends dbcon{
        
        function sendMail(
            $mailTo,
            $url,
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
                <img src='$url'> 
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
    }
?>