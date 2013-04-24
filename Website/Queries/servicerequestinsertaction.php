<?php
session_start();
date_default_timezone_set('America/New_York');
$date = date ("Y-m-d H:i:s", time());

$location = $_POST['location_select'];
$carsno = $_POST['car_select'];
$problem = $_POST['problem_description'];
$username = $_SESSION['username'];

echo "The following values were inserted into maintenance request:";

if(isset($name)){
    $html .= "<p>Location: <b>".$location."</b></p>";
    $html .= "<p>Car Serial Number: <b>".$carsno."</b></p>";   
    $html .= "<Problem>p: <b>".$problem."</b></p>";
    $html .= "<Date>p: <b>".$date."</b></p>";   
   
    print($html);
}

//echo var_dump(get_defined_vars());


$connection=mysqli_connect("localhost","root","","car rental");

//just inserting a test username. Need to get the username from the session later this needs to be worked out with the team later
$insertCar = "INSERT INTO maintenance_request (`VehicleSno`, `RequestDateTime`, `Username`)
VALUES ('$carsno', '$date', '$username')";
$result1 = mysqli_query($connection, $insertCar);

$insertProblem = "INSERT INTO maintenance_request_problems (`VehicleSno`, `RequestDateTime`, `Problem`)
VALUES ('$carsno', '$date', '$problem')";
$result2 = mysqli_query($connection, $insertProblem);

mysqli_close($connection);
?>