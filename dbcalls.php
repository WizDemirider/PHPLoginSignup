<?php
function saveInDB($name, $password, $email) {
    $servername = 'localhost:3360';
    $dbusername = 'ankit';
    $dbpassword = 'ag@12345';
    $hashedPassword = hashPassword($password);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=AtomUsers", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO Users (username, password, email)
        VALUES ('$name', '$hashedPassword', '$email')";
        // use exec() because no results are returned
        $conn->exec($sql);
        return true;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
}

function checkInDB($name, $password) {
    $servername = 'localhost:3360';
    $dbusername = 'ankit';
    $dbpassword = 'ag@12345';
    $hashedPassword = hashPassword($password);

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
            return $entry[0]['password']==$hashedPassword;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

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

function changePassword($name, $newPassword) {
    $servername = 'localhost:3360';
    $dbusername = 'ankit';
    $dbpassword = 'ag@12345';
    $hashedPassword = hashPassword($newPassword);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=AtomUsers", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = ("UPDATE `Users` SET `password`='$hashedPassword' WHERE username='$name'");
        $conn->exec($sql);
        return true;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
}

function random_string($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $keyspace = str_shuffle($keyspace);
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function hashPassword($password) {
    return hash_hmac('sha256', $password, 'random_key123');
}
?>