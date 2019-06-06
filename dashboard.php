<?php
session_start();
if (!isset($_SESSION["name"]))
{
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div>
        <button onclick="window.location.href = 'logout.php';">logout</button>
    </div>
    <h2>DASHBOARD</h2>
    <?php
        echo "welcome ".$_SESSION["name"]." you're logged in!<br>";
    ?>
    </body>
</html>