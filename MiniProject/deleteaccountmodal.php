<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: farmerlogin.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

if(array_key_exists('button1', $_POST)) {
    button1();
}
else if(array_key_exists('button2', $_POST)) {
    button2();
}

function button1() {
    header("location: deleteaccount.php");
    exit;
}
function button2() {

    header("location: welcome.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Thambi+2&family=Cedarville+Cursive&family=Fira+Sans&family=Raleway:wght@100&family=Recursive&family=Roboto+Slab&family=Rubik&family=Source+Code+Pro&family=Ubuntu&family=Varela+Round&display=swap');

        body {
            font-family: "Roboto Slab";
        }
    </style>
</head>
<body class = "text-center">
    <div class="container">
        <h2 class="text-center">Are you sure you want to delete your account? All your data will be lost</h2>
    <form method="post">
        <input type="submit" name="button1"
                class="button btn btn-outline-danger" value="Yes" />
         
        <input type="submit" name="button2"
                class="button btn btn-success" value="No" />
    </form>
    </div>
</body>
</html>