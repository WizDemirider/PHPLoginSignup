<?php
session_start();
function saveInDB($name, $password, $email) {
    $servername = 'localhost:3360';
    $dbusername = 'ankit';
    $dbpassword = 'ag@12345';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=AtomUsers", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO Users (username, password, email)
        VALUES ('$name', '$password', '$email')";
        // use exec() because no results are returned
        $conn->exec($sql);
        return true;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return false;
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
        if($saved)
        {
            $_SESSION["name"] = $name;
            echo '<script>window.location.href = "dashboard.php";</script>';
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
    </head>
    <body>
    <h2>SIGNUP</h2>
    <a href="login.php">Login</a>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p id = "error">
                <?php
                echo $message;
                ?>
            </p>
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            Email: <input type="text" name="email"><br>
            <button type="submit">Submit</button>
        </form>
    </body>
</html>