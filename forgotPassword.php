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

        if(gettype($entry)=="array")
        {
            $to = $entry['email'];
            $subject = "Your Recovered Password";
            $headers = "From: argankit@gmail.com";
            $password = random_string(8);
            changePassword($name, $password);


            if(mail($to, $subject, $message, $headers)){
                $message = "";
                $success_message = "Please use this password to login: " . $password .
                "<br>Your Password has been sent to your email id<br>";
            }else{
                $message = "Failed to Recover your password, try again";
            }
        }
        else
        {
            $message = $entry;
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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Forgot Password</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <ul class="nav">
        <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
    </ul>
    </nav>
    <div class="container">
        <div class="row mt-5">
            <div class="card offset-3 col-6">
                <div class="card-title centertext">
                    <h1>RESET PASSWORD</h1>
                    <hr>
                </div>
                <div class="card-body centertext p-1">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <p id = "error">
                            <?php
                            echo $message;
                            ?>
                        </p>
                        <p id = "success">
                            <?php
                            echo $success_message;
                            ?>
                        </p>
                        <p>
                        <label>Username:</label>
                        <input type="text" name="username">
                        </p>
                        <p><button type="submit" class="btn btn-primary">Submit</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>