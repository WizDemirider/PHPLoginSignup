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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <ul class="nav">
        <li class="nav-item"><a class="nav-link active" href="logout.php">Logout</a></li>
    </ul>
    </nav>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="centertext">
                    <h1>DASHBOARD</h1>
                    <hr>
                </div>
                <div class="centertext p-1">
                <?php
                    echo "welcome <b>".$_SESSION["name"]."</b> you're logged in!<br>";
                ?>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>