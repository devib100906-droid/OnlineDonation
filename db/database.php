<?php

$host = "127.0.0.1";
$username = "root";
$password = "KCET@123";
$database = "online_donation";
$port = 3307;

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database,
    $port
);

if ($conn->connect_error) {

    die("Database Connection Failed: " . $conn->connect_error);

}

?>