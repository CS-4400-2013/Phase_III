<html>
<head>
<title>Rent A Car</title>
</head>
<body>

<?php
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo '
<form action="MemberCarAvailability.php" method="get">

Pick Up time:
<select name="pickuptime">
';
  for($i=0;$i<5;$i++) {
	echo '<option value="'; echo date("Y-m-d h:i:s", strtotime("+".$i." days")).'">';
	echo date("m-d-Y h:i:s", strtotime("+".$i." days"));
	echo "</option>";
  }
echo '
</select>
<br>

Return time:
<select name="returntime">
';
  for($j=0;$j<5+$i;$j++) {
	echo '<option value="'; echo date("Y-m-d h:i:s", strtotime("+".$j." days")).'">';
	echo date("m-d-Y h:i:s", strtotime("+".$j." days"));
	echo "</option>";
  }
echo '
</select>
<br>
 
Location:
<select name="location">
';
  $location_query = mysqli_query($connection,"SELECT LocationName FROM location");
  while ($location_result = mysqli_fetch_array($location_query)) {
	echo '<option value="'; echo $location_result['LocationName'].'">';
	echo $location_result['LocationName'];
	echo "</option>";
  }
echo '
</select>
<br>

Cars:
<select name="Type">
';
  $cartype_query = mysqli_query($connection,"SELECT DISTINCT Type FROM car;");
  while ($cartype_result = mysqli_fetch_array($cartype_query)) {
	echo '<option value="'; echo $cartype_result['Type'].'">';
	echo $cartype_result['Type'];
	echo "</option>";
  }
echo '
</select>
<select name="CarModel">
';
  $carmodel_query = mysqli_query($connection,"SELECT DISTINCT CarModel FROM car;");
  while ($carmodel_result = mysqli_fetch_array($carmodel_query)) {
	echo '<option value="'; echo $carmodel_result['CarModel'].'">';
	echo $carmodel_result['CarModel'];
	echo "</option>";
  }
echo '
<br>

<input type="Submit" value="Search">

</form>';
mysqli_close($connection);
?>
</body>
</html>
