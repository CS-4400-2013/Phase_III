<html>
<head>
<title>Service Request Pg 1/3</title>
</head>
<body>
Service Requests Pg 1/3
<br>
<br>

Choose Location: 
<br>
<form action="ServiceRequest2.php" method="post">

<?php
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$location_query = mysqli_query($connection,"SELECT LocationName FROM location");
$carmodel_query = mysqli_query($connection,"SELECT CarModel FROM car");

echo "<br>";
echo "<br>";

echo "<select name ='location_select'>";
while($location_result = mysqli_fetch_array($location_query)) {
		echo "<option value=".$location_result['LocationName'].">".$location_result['LocationName']."</option>";
}
echo "</select>";
echo "<br>";
echo "<br>";
echo "<input type=\"Submit\">";

mysqli_close($connection);
?>
</form>
</body>
</html>
