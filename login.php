<?php
session_start();
function checkInDB($name, $password) {
    $servername = 'localhost:3360';
    $dbusername = 'ankit';
    $dbpassword = 'ag@12345';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=AtomUsers", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM Users WHERE username='$name'");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $entry = $stmt->fetchAll();
        if(count($entry) == 0)
            return false;
        else
            return $entry[0]['password']==$password;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

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