<?php
$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "loginsystemitcc14";

$conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName); #connecting to db

if (!$conn) { #check if connection failed
    die("Connection error: ".mysqli_connect_error());
}
