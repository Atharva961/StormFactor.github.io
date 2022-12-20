<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: login.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION["username"];
$showError = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $phoneno = $_POST["phoneno"];
    $gender = $_POST["gender"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $age = $_POST["age"];
    $phone_length = strlen((string)$phoneno);

    if($phoneno==NULL or $gender==NULL or $fname==NULL or $lname==NULL)
    {
        $showError = "Input cannot be null";
    }
    else if($phone_length!=10)
    {
        $showError = "Phone Number is incorrect";
    }
    else if($age<18)
    {
        $showError = "Your age should be above 18";
    }
    else
    {
        $sql = "UPDATE `farmer`.`farmers` SET phone = '$phoneno' , gender = '$gender', fname = '$fname', lname = '$lname', age = $age WHERE aadharID = '$aadharid';";

        $result = mysqli_query($conn, $sql);

        header("location: welcome.php");
    }
    
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update details</title>
    <!-- CSS only -->
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
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="welcome.php">StormFactor</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="history.php">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="crophomepage.php">Crops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="right">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="updateaccount.php">Update Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="deleteaccountmodal.php">Delete your account</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
        if($showError)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failure!</strong>'. $showError .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    ?>
<div class="container">
        <h2 class = "text-center">Please fill in your details again</h2>
        <form action = "/MiniProject/updateaccount.php" method = "post"> 
            <div class="mb-3">
                <label for="phoneno" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phoneno" name="phoneno">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</body>
</html>