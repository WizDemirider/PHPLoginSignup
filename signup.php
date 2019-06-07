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
    elseif(empty($_POST["email"]))
    {
        $message = "Email cannot be empty!";
    }
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    elseif(strlen($_POST["password"])<=6)
    {
        $message = "Password is too short! Need at least 6 characters!";
    }
    else
    {
        $name = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $email = test_input($_POST["email"]);
        $saved = saveInDB($name, $password, $email);
        if(gettype($saved)=="boolean" && $saved)
        {
            $_SESSION["name"] = $name;
            echo '<script>window.location.href = "dashboard.php";</script>';
        }
        else
        {
            $message = $saved;
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
        <title>Signup</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <ul class="nav">
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link active" href="signup.php">Signup</a></li>
    </ul>
    </nav>
    <div class="container">
        <div class="row mt-5">
            <div class="card offset-3 col-6">
                <div class="card-title centertext">
                    <h1>SIGNUP</h1>
                    <hr>
                </div>
                <div class="card-body centertext p-1">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <p id = "error">
                            <?php
                            echo $message;
                            ?>
                        </p>
                        <p>
                        <label>Username:</label>
                        <input type="text" name="username">
                        </p>
                        <p>
                        <label>Password:</label>
                        <input type="password" name="password">
                        </p>
                        <p>
                        <label>&nbsp;&nbsp;&nbsp;Email:&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" name="email">
                        </p>
                        <p><button type="submit" class="btn btn-primary">Submit</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>