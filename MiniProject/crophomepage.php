<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: login.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION["username"];

$sql = "SELECT * FROM `farmer`.`crop` WHERE aadharid = $aadharid;";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crops</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="crophomepage.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Thambi+2&family=Cedarville+Cursive&family=Fira+Sans&family=Raleway:wght@100&family=Recursive&family=Roboto+Slab&family=Rubik&family=Source+Code+Pro&family=Ubuntu&family=Varela+Round&display=swap');

        body {
            font-family: "Roboto Slab";
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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

    <!-- <h2 class = "text-center">Your Crops are: </h2> -->

    <div class="container my-2">
        <div class="d-flex"><h2>Your Crops</h2> <a href = "addcrop.php" class=" btn btn-outline-primary mx-2">Add Crop</a> <a href = "updatecrop.php" class=" btn btn-outline-warning mx-2">Update Crop</a> <a href = "deletecrop.php" class=" btn btn-outline-danger mx-2">Delete Crop</a></div>
        
        <table class = "table" id = "myTable">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Crop ID</th>
                    <th>Crop Name</th>
                    <th>Planted on Land ID</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $srno = 1;
            while($row = mysqli_fetch_assoc($result))
            {
            echo "<tr>
            <td>". $srno . "</td> 
            <td>". $row['cropid'] . "</td>
            <td>". $row['cropname'] . "</td>
            <td>". $row['landid'] . "</td>".
            ".
          </tr>";
          $srno+=1;
            }
        ?>
            </tbody>
        </table>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "iDisplayLength": 10,
                "bFilter": true,
                "aaSorting": [
                    [1, "asc"]
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData[0]%2!=0) {
                        $('td', nRow).css('background-color', 'rgb(153, 237, 153)');
                    } else if (aData[0]%2==0) {
                        $('td', nRow).css('background-color', 'white');
                    }
                }
            });
        })
    </script>
</body>

</html>