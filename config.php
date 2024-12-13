<?php
session_start();
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "movies";
$charset = "utf8mb4";

try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    $message = $error->getMessage();
    echo "Connection failed: $message";
    die();
}