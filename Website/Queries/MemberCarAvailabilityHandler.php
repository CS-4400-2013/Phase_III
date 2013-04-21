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

if(!isset($_GET['car_to_rent']))
	header('Location: MemberCarAvailability.php');

$username = $_SESSION['username'];
$pickuptime = $_GET['pickuptime'];
$returntime = $_GET['returntime'];
$vehicle = $_GET['car_to_rent'];
$cost = 0;

	
$location_query = mysqli_query($connection,"	SELECT CarLocation FROM car WHERE VehicleSno='$vehicle'");
$location_result = mysqli_fetch_array($location_query);
$location = $location_result['CarLocation'];

echo "Username: ".$username."<br>";
echo "Pick Up Time: ".$pickuptime."<br>";
echo "Return Time: ".$returntime."<br>";
echo "Vehicle: ".$vehicle."<br>";
echo "Location: ".$location."<br>";
echo "Cost: ".$cost."<br>";

mysqli_close($connection);
?>
</body>
</html>
