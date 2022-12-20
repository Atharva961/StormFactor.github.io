<?php

$showAlert = false;
$showError = false;
$login = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    include 'C:\xampp\htdocs\MiniProject\dbconnect.php';
    $aadharid = $_POST["aadharid"];
    $password = $_POST["password"];

    if($aadharid==NULL or $password==NULL)
    {
        $showError = "Input cannot be null";
    }
    else
    {
        $exists = false;

        $sql = "SELECT * FROM `farmers` WHERE aadharID='$aadharid' AND password='$password';";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);

        if($num==1)
        {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $aadharid;
            header("location: welcome.php");
        }
    
        else
        {
            $showError = "Invalid Credentials";
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="farmerlogin.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Thambi+2&family=Cedarville+Cursive&family=Fira+Sans&family=Raleway:wght@100&family=Recursive&family=Roboto+Slab&family=Rubik&family=Source+Code+Pro&family=Ubuntu&family=Varela+Round&display=swap');

        body {
            font-family: "Roboto Slab";
            background-color: rgb(153, 237, 153);
        }
    </style>
</head>

<body>
    <?php
    if($login)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> You are logged in<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    if($showError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failure!</strong>'. $showError .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    ?>
    <h2 class="text-center">Login</h2>
    <p class="text-center">Make sure you have an account already</p>

    <div class="container signup">
        <form action="/MiniProject/farmerlogin.php" method="post" class="signupform">
            <div class="mb-3">
                <label for="aadharid" class="form-label">Aadhar ID</label>
                <input type="number" class="form-control" id="aadharid" name="aadharid" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <!-- <div class="elem-group">
                <label for="captcha">Please Enter the Captcha Text</label>
                <img src="captcha.php" alt="CAPTCHA" class="captcha-image"><i class="fas fa-redo refresh-captcha"></i>
                <br>
                <input type="text" id="captcha" name="captcha_challenge" pattern="[A-Z]{6}">
            </div> -->
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-success text-center">Login</button>
            </div>
        </form>
        <div class="container text-center mb-4">
            Don't have an account?<a href="farmersignup.php">SignUp</a>
        </div>
    </div>


</body>

</html>