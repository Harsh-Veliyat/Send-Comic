<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Comic</title>
    <link rel="stylesheet" href="email.css">
</head>
<body>
    <div class="container">
        <h1>Comic Delivery Service</h1>
        <p>Welcome to CDS! Our random comic will bring smile on your face!.
        </p>
       <!-- <?php        
       // if($submit == true)
       // {
       //     echo "<p class='submitmsg'>Your form has been successfully submitted!</p>";
       // }
        ?> -->
        <form action="email.php" method="post">
            <table>
                <tr>
                    <td id="email">Email</td>
                    <td><input type="text" name="email" size="52" placeholder="Enter your mail id here to subscribe to our service." autocomplete="off" required></td>
                </tr>
            </table>
            <input type="submit" value="submit" class="submit" name="submit">
        </form>
    </div>
</body>
</html>
