<?php
$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
session_unset();
session_destroy();

header("Location: login.php");

?>