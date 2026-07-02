<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "ecommerce";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>