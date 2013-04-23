<html>
<head>
<title>Service Request Pg 1/3</title>
</head>
<body>
Service Requests Pg 2/3
<br>
<br>

Choose a Car: 
<br>
<form action="ServiceRequest3.php" method="post">

<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

//echo var_dump(get_defined_vars());

// Check connection
//$location = $_POST["location_select"];

if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$location = $_POST["location_select"];
$_SESSION["location_selection"] = $_POST["location_select"];
echo var_dump($location);

$carmodel_query = mysqli_query($connection,"SELECT VehicleSno FROM car WHERE CarLocation =".$location.")"; //where carLocation = location

echo "<br>";
echo "<br>";

echo "<select name ='car_select'>";
while($car_result = mysqli_fetch_array($carmodel_query)) {
		echo "<option value=\"car_sno\">".$car_result['VehicleSno']."</option>";
}
echo "</select>";
echo "<br>";
echo "<br>";
/*
echo"Brief Description of the problem:
<br>
<br>";
echo"<textarea name='problem_description' rows='10' cols='30'>
Describe Problem here.
</textarea>
<input type=\"Submit\">";
*/
mysqli_close($connection);
?>
</form>
</body>
</html>
