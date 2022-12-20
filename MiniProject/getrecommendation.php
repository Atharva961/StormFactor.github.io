<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
    header("location: welcome.php");
    exit;
}

include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

$aadharid = $_SESSION['username'];
$landid = $_SESSION['landid'];

$sql = "SELECT * FROM `farmer`.`land` WHERE aadharid = $aadharid AND landid = $landid;";
$result = mysqli_query($conn, $sql);
$city = "";
$status="";
$msg="";

while($row = mysqli_fetch_assoc($result))
{
    $city = $row['city'];
}

$url="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=e1ad429ecb5a6a237491211d9c781e3f";
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($ch);
curl_close($ch);
$result=json_decode($result,true);
if($result['cod']==200){
    $status="yes";
}else{
    $msg=$result['message'];
}

if($status=="yes")
{
    $temperature = $result["main"]["temp"];
    $weatherdesc = $result["weather"][0]["main"];
    $weatherdescription = $result["weather"][0]["description"];
    $pressure = $result["main"]["pressure"];
    $humidity = $result["main"]["humidity"];
    $weatherIcon = $result['weather'][0]['icon'];

    $sql2 = "INSERT INTO `farmer`.`weatherhistory` (weatherdesc, temperature, pressure, humidity, landid, aadharid) VALUES ('$weatherdesc', $temperature, $pressure, $humidity, $landid, $aadharid)";
    $result2 = mysqli_query($conn, $sql2);
}
else
{
    header("location: welcome.php");
}

// echo $result;




// echo $temperature . " " . $weatherdesc . " ". $weatherdescription . " " . $pressure . " " . $humidity;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendation</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="getrecommendation.css">
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
    <div class="container my-5">

        <!-- <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">The weather info for this land is: </h4>
            <p>City: <?php echo $city?></p>
            <p>Weather: <?php echo $weatherdesc?></p>
            <p>Description: <?php echo $weatherdescription?></p>
            <p>Temperature: <?php echo $temperature?></p>
            <p>Pressure: <?php echo $pressure?></p>
            <p>Humidity: <?php echo $humidity?></p>
            <div class="weatherIcon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon']?>@4x.png"/>
         </div>
            <hr>
            <p>Thanks for using our service. The information has been stored in the history</p>
        </div> -->
        <article class="widget">
         <div class="weatherIcon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon']?>@4x.png"/>
         </div>
         <div class="weatherInfo">
            <div class="temperature">
               <span><?php echo round($result['main']['temp']-273.15)?>°</span>
            </div>
            <div class="description mr45">
               <div class="weatherCondition"><?php echo $result['weather'][0]['main']?></div>
               <div class="place"><?php echo $result['name']?></div>
            </div>
            <div class="description">
               <div class="weatherCondition">Wind</div>
               <div class="place"><?php echo $result['wind']['speed']?> M/H</div>
            </div>
         </div>
         <div class="date">
            <?php echo date('d M',$result['dt'])?> 
             
         </div>
      </article>

    </div>
</body>

</html>