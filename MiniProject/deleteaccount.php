<?php
session_start();

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION["username"];
$sql = "DELETE FROM `farmer`.`farmers` WHERE aadharID = $aadharid;";

$result = mysqli_query($conn, $sql);

session_unset();
session_destroy();

header("location: farmerlogin.php");
exit;
?>
