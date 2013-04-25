<?php
session_start();


$connection=mysqli_connect("localhost","root","","car rental");

$affecteduser = $_SESSION["affecteduser"];
$pickuptime = $_SESSION["original_pickup_time"];
$returntime = $_SESSION["original_return_time"];
$resID = $_SESSION["res_id"];


$remove_reservation_query = "DELETE FROM reservation WHERE ResID ='$resID'"; 

$remove_result = mysqli_query($connection, $remove_reservation_query);

mysqli_close($connection);
?>