<?php
session_start();
date_default_timezone_set('America/New_York');
$date = date ("Y-m-d H:i:s", time());

$name = strtoupper($_REQUEST['urname']);
$birth = strtoupper($_REQUEST['urbirth']);
$location = $_POST['location_select'];
$carsno = $_POST['car_select'];
$problem = $_POST['problem_description'];

$logged_in_user = $_SESSION['username'];
echo "Logged in User:";
echo var_dump($logged_in_user);
echo "<br>";
echo var_dump(get_defined_vars());

$connection=mysqli_connect("localhost","root","","car rental");

$insertCar = "INSERT INTO maintenance_request (`VehicleSno`, `RequestDateTime`, `Username`)
VALUES ('$carsno', '$date', '$logged_in_user')";
$result1 = mysqli_query($connection, $insertCar);


$insertProblem = "INSERT INTO maintenance_request_problems (`VehicleSno`, `RequestDateTime`, `Problem`)
VALUES ('$carsno', '$date', '$problem')";
$result2 = mysqli_query($connection, $insertProblem);

echo "The following values were inserted into maintenance request:";

if(isset($name)){
    $html = "<p> Name: <b>".$name."</b></p>";
    $html .= "<p>Location: <b>".$location."</b></p>";
    $html .= "<p>Car Serial Number: <b>".$carsno."</b></p>";   
    $html .= "<Problem>p: <b>".$problem."</b></p>";
    $html .= "<Date>p: <b>".$date."</b></p>";   
   
    print($html);
}

mysql_close($connection);
?>