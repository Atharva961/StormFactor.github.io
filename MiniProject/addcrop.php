<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: login.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION["username"];
$showAlert = false;
$showError = "";

$getLands = "SELECT * FROM `farmer`.`land` WHERE aadharid = $aadharid";
$getLandsResult = mysqli_query($conn, $getLands);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // $cropname = $_POST["cropname"];
    $landid = $_POST["landid"];
    if($landid==NULL)
    {
        $showAlert = true;
        $showError = "Input cannot be NULL";
    }
    else
    {
        $sql = "SELECT * FROM `farmer`.`land` WHERE landid = $landid AND aadharid = $aadharid;";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)!=0)
        {
            session_start();
            $_SESSION["username"] = $aadharid;
            $_SESSION["landid"] = $landid;
            header("location: addcropdriver.php");
        }
        else
        {
            $showError = "This land either does not exist or does not belong to you!";
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
    <title>Add Crop</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="addcrop.css">
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
        <table class="table">
            <thead>
                <tr>
                    <th>Land ID</th>
                    <th>City</th>
                    <th>Soiltype</th>
                </tr>
            </thead>
            <tbody>
                <?php
            while($row = mysqli_fetch_assoc($getLandsResult))
            {
            echo "<tr>
            <th scope='row'>". $row['landid'] . "</th>
            <td>". $row['city'] . "</td>
            <td>". $row['soiltype'] . "</td>".
            ".
          </tr>";
            }
        ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <h2>Enter land ID on which you want to plant the crop or get recommendation</h2>
        <p><b>Note: </b>Recommendations available only for Indian Locations</p>
        <form action="/MiniProject/addcrop.php" method="post">
            <div class="mb-3">
                <!-- <label for="landid" class="form-label">Land ID of the land on which it is being planted</label> -->
                <input type="number" class="form-control" id="landid" name="landid" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-success">Go</button>
        </form>
    </div>
</body>

</html>