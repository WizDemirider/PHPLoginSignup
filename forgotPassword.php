<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Forgot Password</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>FORGOT PASSWORD</h1>
        <?php
        include 'dbcalls.php';

        if(isset($_SESSION["name"])) {
            header("Location:dashboard.php");
        }

        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST["username"]))
            {
                $message = "Username cannot be empty!";
            }
            else
            {
                $name = test_input($_POST["username"]);

                $entry = getEntryFromDB($name);
                $to = $entry['email'];
                $subject = "Your Recovered Password";
                $headers = "From: argankit@gmail.com";
                $password = random_string(8);
                changePassword($name, $password);

                $message = "Please use this password to login " . $password;
                if(mail($to, $subject, $message, $headers)){
                    echo "Your Password has been sent to your email id<br>";
                    echo $message;
                }else{
                    echo "Failed to Recover your password, try again";
                }

            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <a href="login.php">Back to Login</a>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Username: <input type="text" name="username">
            <button type="submit">Submit</button>
        </form>
    </body>
</html>

