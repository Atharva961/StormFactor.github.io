<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: login.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION["username"];
$landid = $_SESSION["landid"];
$showError = "";

$land = "SELECT * FROM `farmer`.`land` WHERE landid = $landid;";
$resultland = mysqli_query($conn, $land);

$cityname = "";

while($row = mysqli_fetch_assoc($resultland))
{
    $cityname = $row["city"];
}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $cropname = $_POST["cropname"];

    if($cropname==NULL)
    {
        $showError = "Input cannot be null!";
    }
    else
    {
        $sql = "INSERT INTO `farmer`.`crop` (aadharid, landid, cropname) VALUES ($aadharid, $landid, '$cropname');";
        $result = mysqli_query($conn, $sql);

        // $cityname = strtolower($cityname);
        // $crop = "INSERT INTO `farmer`.`crop_inp` VALUES ('$cityname','$cropname');";
        // $result = mysqli_query($conn, $crop);
    }
}


$cityname = strtolower($cityname);
$getCrops = "SELECT * FROM `farmer`.`crops_data` WHERE lower(district) = '$cityname';";
$crops_data = mysqli_query($conn, $getCrops);


// $getCrops = "SELECT * FROM `farmer`.`crop_inp` WHERE cityname = '$cityname';";
// $crops_data = mysqli_query($conn, $getCrops);

// while($row = mysqli_fetch_assoc($crops_data))
// {
//     array_push($crops, $row["cropname"]);
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add crop</title>
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
        <form action="/MiniProject/addcropdriver.php" method = "post">
            <div class="mb-3">
                <label for="cropname" class="form-label">Name of the crop</label>
                <input type="text" class="form-control" id="cropname" name="cropname" aria-describedby="emailHelp">
            </div>
            <button type="submit" class = "btn btn-success">Plant</button>
        </form>

        <h2>Having trouble selecting crop?</h2>
        <p>Here are some recommendations based on data from Government of India</p>
        
        <table class="table">
            <thead>
                <th>District</th>
                <th>Market</th>
                <th>Commodity</th>
                <th>Variety</th>
                <th>Arrival Date</th>
                <th>Min Price</th>
                <th>Max Price</th>
                <th>Modal Price</th>
            </thead>
            <tbody>
                <?php
                    if(mysqli_num_rows($crops_data)!=0)
                    {
                        while($row = mysqli_fetch_assoc($crops_data))
                        {
                            echo "<tr>
                                <td>". $row['district']. "</td>
                                <td>". $row['market'] . "</td>
                                <td>". $row['commodity'] . "</td>
                                <td>". $row['variety'] . "</td>
                                <td>". $row['arrival_date'] . "</td>
                                <td>". $row['min_price'] . "</td>
                                <td>". $row['max_price'] . "</td>
                                <td>". $row['modal_price'] . "</td>
                                ".
                            "</tr>";
                        }
                    }
                    else echo "<tr>Looks like no crops grow here!</tr>"
                ?>
            </tbody>
        </table>
    </div>
    

</body>

</html>