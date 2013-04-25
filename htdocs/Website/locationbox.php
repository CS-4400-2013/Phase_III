<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$location_query = mysqli_query($connection,"SELECT LocationName FROM location");
//$carmodel_query = mysqli_query($connection,"SELECT CarModel FROM car");

echo "<br>";
echo "<br>";

echo "<select name ='location' onchange='showUser(this.value)'>";
while($location_result = mysqli_fetch_array($location_query)) {
		echo "<option value=".$location_result['LocationName'].">".$location_result['LocationName']."</option>";
}
echo "</select>";
echo "<br>";
echo "<br>";

mysqli_close($connection);
?>
