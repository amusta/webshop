<?php


$dBServername ="localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "pet_shop";

// create connection

$conn = mysqli_connect($dBServername, $dbUsername, $dbPassword, $dbName);

// Check connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}