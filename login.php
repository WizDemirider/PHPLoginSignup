<?php
session_start();
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
    elseif(empty($_POST["password"]))
    {
        $message = "Password cannot be empty!";
    }
    elseif(strlen($_POST["password"])<=6)
    {
        $message = "Password is too short! Need at least 6 characters!";
    }
    else
    {
        $name = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $found = checkInDB($name, $password);
        if($found)
        {
            $_SESSION["name"] = $name;
            header("Location:dashboard.php");
        }
        else
        {
            $message = "Username or password is incorrect!";
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
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <h1>LOGIN</h1>
        <a href="signup.php">Signup</a>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p id = "error">
                <?php
                echo $message;
                ?>
            </p>
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <a href="forgotPassword.php">Forgot Password</a>
            <button type="submit">Submit</button>
        </form>
    </body>
</html>