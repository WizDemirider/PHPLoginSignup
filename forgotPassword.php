<?php
function getEntryFromDB($name) {
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
        return $entry[0];
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return NULL;
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
    else
    {
        $name = test_input($_POST["username"]);

        $entry = getEntryFromDB($name);
        $to = $entry['email'];
        $subject = "Your Recovered Password";
        $headers = "From: argankit@gmail.com";

        $message = "Please use this password to login " . $entry['password'];
        if(mail($to, $subject, $message, $headers)){
            echo "Your Password has been sent to your email id";
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p id = "error">
                <?php
                echo $message;
                ?>
            </p>
            Username: <input type="text" name="username">
            <button type="submit">Submit</button>
        </form>
    </body>
</html>

