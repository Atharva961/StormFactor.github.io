<?php

$showAlert = false;
$showError = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    include 'C:\xampp\htdocs\MiniProject\dbconnect.php';

    $aadharid = $_POST["aadharid"];
    $password = $_POST["password"];
    $cpassword =$_POST["cpassword"];
    $phoneno = $_POST["phoneno"];
    $gender = $_POST["gender"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $city = $_POST["city"];
    $soiltype = $_POST["soiltype"];
    $age = $_POST["age"];

    $aadhar_length = strlen((string)$aadharid);
    $phone_length = strlen((string)$phoneno);
    $password_length = strlen((string)$password);

    

    $exists = false;
    if($aadharid==NULL or $password==NULL or $cpassword==NULL or $phoneno==NULL or $gender==NULL or $fname==NULL or $lname==NULL or $city==NULL or $soiltype==NULL or $age==NULL)
    {
        $nullfields = "";
        if($aadharid==NULL)$nullfields .= "aadharID, ";
        if($password==NULL)$nullfields .= "password, ";
        if($cpassword==NULL)$nullfields .= "confirm password, ";
        if($phoneno==NULL)$nullfields .= "phone number, ";
        if($fname==NULL)$nullfields .= "first name, ";
        if($lname==NULL)$nullfields .= "last name, ";
        if($city==NULL)$nullfields .= "city, ";
        if($age==NULL)$nullfields .= "age, ";

        $showError = $nullfields . "cannot be null!";
    }
    else
    {
        $existsSQL = "SELECT * FROM `farmers` WHERE aadharID = $aadharid";
        $result = mysqli_query($conn, $existsSQL);
        $numExistsRows = mysqli_num_rows($result);
        if($numExistsRows > 0)
        {
            $showError = "The account with this Aadhar ID already exists";
        }
        else
        {
            if($aadhar_length!=12)
            {
                $showError = "Aadhar ID should be 12 digits long";
            }
            else if($phone_length!=10)
            {
                $showError = "Phone Number should be 10 digits long";
            }
            else if($password_length<=7)
            {
                $showError = "Password is too weak";
            }
            else if($age<18)
            {
                $showError = "Your age should be above 18";
            }
            else if($password == $cpassword)
            {
                $sql = "INSERT INTO `farmer`.`farmers` (aadharID, password, phone, gender, fname, lname, age) VALUES ('$aadharid', '$password', '$phoneno', '$gender', '$fname', '$lname', $age)";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    $showAlert = true;
                }

                $sql = "INSERT INTO `farmer`.`land` (city, soiltype, aadharID) VALUES ('$city', '$soiltype', '$aadharid');";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    $showAlert = true;
                }
            }
            else
            {
                $showError = "Passwords do not match";
            }
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
    <title>Sign Up</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="farmersignup.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Thambi+2&family=Cedarville+Cursive&family=Fira+Sans&family=Raleway:wght@100&family=Recursive&family=Roboto+Slab&family=Rubik&family=Source+Code+Pro&family=Ubuntu&family=Varela+Round&display=swap');

        body {
            font-family: "Roboto Slab";
            background-color: rgb(153, 237, 153);
        }
    </style>
</head>

<body>
    <h2 class="text-center">Sign Up</h2>
    <p class="text-center">Please fill out the form below to get the best service</p>

    <?php
    if($showAlert)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your account is now created and you can Login<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    if($showError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failure!</strong>'. $showError .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    ?>

    <div class="container signup">
        <form action = "/MiniProject/farmersignup.php" method = "post"> 
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Aadhar ID</label>
              <input type="number" class="form-control" id="aadharid" name = "aadharid" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">Note: Aadhar ID once enterred cannot be changed</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword">
                <div id="emailHelp" class="form-text">Make sure to type the same password</div>
            </div>
            <div class="mb-3">
                <label for="phoneno" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phoneno" name="phoneno">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class = "form-control">
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
            <p>To be eligible for our service you should own atleast 1 farm land</p>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city">
            </div>
            <div class="mb-3">
                <label for="soiltype" class="form-label">Soil Type</label>
                <select id="soiltype" name="soiltype" class = "form-control">
                    <option value="sandy">Sandy</option>
                    <option value="silt">Silt</option>
                    <option value="clay">Clay</option>
                    <option value="loamy">Loamy</option>
                </select>
            </div>
            <div class="mb-3 text-center">
            <button type="submit" class="btn btn-success">Submit</button>
            </div>
            
        </form>
        <div class="container text-center mb-4">
        Already have an account?<a href="farmerlogin.php">Login</a>
    </div>
    </div>

    
    
    
    
</body>

</html>
<!-- 19:09:51	create table land (  landid int primary key auto_increment,     city text,     soiltype text,     aadharid int,     FOREIGN KEY (aadharid)   REFERENCES farmers(aadharID)         ON DELETE CASCADE )	Error Code: 3780. Referencing column 'aadharid' and referenced column 'aadharID' in foreign key constraint 'land_ibfk_1' are incompatible.	0.015 sec -->
