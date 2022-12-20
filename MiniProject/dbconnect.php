<?php

$server = "localhost";
$username = "root";
$password = "Basileo@806";
$database = "farmer";

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn)
{
    die("Error". mysqli_connect_error());
}
?>