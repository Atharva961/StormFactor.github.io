<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: welcome.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION['username'];
$showError = "";

$getCrops = "SELECT * FROM `farmer`.`crop` WHERE aadharid = $aadharid;";
$getCropsResult = mysqli_query($conn, $getCrops);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $cropid = $_POST['cropid'];
    if($cropid==NULL)
    {   
        $showError = "Input cannot be NULL";
    }
    else
    {
        // echo "Executing SQL query";
        $sql = "SELECT * FROM `farmer`.`crop` WHERE cropid = $cropid AND aadharid = $aadharid ;";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)!=0)
        {
            $sql2 = "DELETE FROM `farmer`.`crop` WHERE cropid = $cropid;";
            $result2 = mysqli_query($conn, $sql2);
            echo "updated";
            header("location: crophomepage.php");
        }
        else
        {
            $showError = "This crop does not belong to you";
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
    <title>Delete Crop</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="deletecrop.css">
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
    <table class = "table">
            <thead>
                <tr>
                    <th>Crop ID</th>
                    <th>Crop Name</th>
                    <th>Planted on Land ID</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row = mysqli_fetch_assoc($getCropsResult))
            {
            echo "<tr>
            <th scope='row'>". $row['cropid'] . "</th>
            <td>". $row['cropname'] . "</td>
            <td>". $row['landid'] . "</td>".
            ".
          </tr>";
            }
        ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <h2 class="text-center">Delete Crop</h2>
        <form action="/MiniProject/deletecrop.php" method="post">
            <div class="mb-3">
                <label for="cropid" class="form-label">Crop ID of the crop which you want to delete</label>
                <input type="text" class="form-control" id="cropid" name="cropid" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-success">Delete</button>
        </form>
    </div>
</body>

</html>