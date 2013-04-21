<html>
<body>
<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_SESSION['username'];
$rentals = $_SESSION['rentals'];
$selection = $_GET['rental'];
$pickuptime = $_GET['pickuptime'];
$returntime = $_GET['returntime'];
$location = $rentals[$selection]['CarLocation'];
$estimatedcost = $rentals[$selection]['estimated_cost'];
$vehiclesno = $rentals[$selection]['VehicleSno'];

mysqli_query($connection,"	INSERT INTO `reservation`(`Username`, 
	`PickUpDateTime`, `ReturnDateTime`, 
	`EstimatedCost`,`ReservationLocation`, `VehicleSno`) 
	VALUES ('$username',
	'$pickuptime','$returntime',
	'$estimatedcost','$location','$vehiclesno')");

header("Location: ../MemberHomePage.html");	

mysqli_close($connection);
?>
</body>
</html>
