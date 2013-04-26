<html>
<body>
<?php

echo "Add Car PHP File";
$connection=mysqli_connect("localhost","root","","car rental");

if (mysqli_connect_errno($connection)) //make sure connection exists
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
      echo "Database connection successful";
}

$vehicle_sno = $_POST["vehicle_sno"];
$car_model = $_POST["car_model"];
$car_type = $_POST["car_type"];
$location = $_POST["location"];
$color = $_POST["color"];
$hourly_rate = $_POST["hourly_rate"];
$daily_rate = $_POST["daily_rate"];
$seating_capacity = $_POST["seating_capacity"];
$transmission_type = $_POST["transmission_type"];
$bluetooth_connectivity = 0;
$auxillary_cable = 0;
$maintenance_flag = 0;

if(isset($_POST["bluetooth_connectivity"]))
{
      $bluetooth_connectivity = 1;
}

if(isset($_POST["auxillary_cable"]))
{
      $auxillary_cable = 1;
}

if(isset($_POST["maintenance_flag"]))
{
      $maintenance_flag = 1;
}

echo var_dump($vehicle_sno);
echo "<br>";
echo var_dump($car_model);
echo "<br>";
echo var_dump($car_type);
echo "<br>";
echo var_dump($location);
echo "<br>";
echo var_dump($color);
echo "<br>";
echo var_dump($hourly_rate);
echo "<br>";
echo var_dump($daily_rate);
echo "<br>";
echo var_dump($seating_capacity);
echo "<br>";

$capacity_query = "SELECT Capacity FROM location WHERE LocationName='$location'";

$capacity_result = mysqli_query($connection, $capacity_query);
//use fetch array to get the capacity at the current location
$array=mysqli_fetch_array($capacity_result,MYSQL_BOTH);
$capacity = $array[0];
//print out the capcity
echo "Max Capacity at selected Location:";
echo "<br>";
echo var_dump($capacity);
echo "<br>";


$current_capacity_query = mysqli_query($connection, "SELECT COUNT(*) FROM car WHERE CarLocation = '$location'");
$current_capacity_array=mysqli_fetch_array($current_capacity_query,MYSQL_BOTH);
$current_capacity = $current_capacity_array[0];

echo "Current Capacity at selected Location:";
echo "<br>";

echo var_dump($current_capacity);

//Make sure capacity + 1 is not greater than the capacity

if(!($current_capacity + 1 > $capacity))
{

      $insertCar = "INSERT INTO car (`VehicleSno`, `Auxiliary Cable`, `Transmission_Type`, `Seating_Capacity`,`BluetoothConnectivity`, `DailyRate`, 
`HourlyRate`, `Color`, `Type`, `CarModel`, `UnderMaintenanceFlag`, `CarLocation`) 
VALUES ('$vehicle_sno', '$auxillary_cable', '$transmission_type', '$seating_capacity', '$bluetooth_connectivity', '$daily_rate', '$hourly_rate', '$color', '$car_type', '$car_model', '$maintenance_flag', '$location')";
      $result1 = mysqli_query($connection, $insertCar);
      echo "Car added to Database";
}
else
{
	echo "Selected location is full. Unable to add car.";
}

mysqli_close($connection);

?>
</body>
</html>
