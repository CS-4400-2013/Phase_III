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
/*
echo var_dump($vehicle_sno);
<br>
echo var_dump($car_model);
<br>
echo var_dump($car_type);
<br>
echo var_dump($location);
<br>
echo var_dump($color);
<br>
echo var_dump($hourly_rate);
<br>
echo var_dump($daily_rate);
<br>
echo var_dump($seating_capacity);
<br>*/
//Do a var dump to show all of the variables that were entered into the page
//echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
if(isset($_POST["submit"])) //the submit button was pressed
{
      $insertCar = "INSERT INTO car (`VehicleSno`, `Auxiliary Cable`, `Transmission_Type`, `Seating_Capacity`,`BluetoothConnectivity`, `DailyRate`, 
`HourlyRate`, `Color`, `Type`, `CarModel`, `UnderMaintenanceFlag`, `CarLocation`) 
VALUES ('$vehicle_sno', '$auxillary_cable', '$transmission_type', '$seating_capacity', '$bluetooth_connectivity', '$daily_rate', '$hourly_rate', '$color', '$car_type', '$car_model', '$maintenance_flag', '$location')";
      $result1 = mysqli_query($connection, $insertCar);
      echo "Car added to Database";
}
mysqli_close($connection);

?>
</body>
</html>
