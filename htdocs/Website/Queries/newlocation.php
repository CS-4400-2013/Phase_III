<html>
<body>
<form>
<?php
echo "ran update";
$value1=$_GET["l"];
$value2=$_GET["c"];
$connection4=mysqli_connect("localhost","root","","car rental");
if (mysqli_connect_errno($connection4)) //make sure connection exists
{
  echo "Failed to connect to MySQL: ".mysqli_connect_error();
}

$capacity_query = "SELECT Capacity FROM location WHERE LocationName='$value1'";

$capacity_result = mysqli_query($connection4, $capacity_query);
//use fetch array to get the capacity at the current location
$array=mysqli_fetch_array($capacity_result,MYSQL_BOTH);
$capacity = $array[0];
//print out the capcity
echo "Max Capacity at selected Location:";
echo "<br>";
echo var_dump($capacity);
echo "<br>";


$current_capacity_query = mysqli_query($connection4, "SELECT COUNT(*) FROM car WHERE CarLocation = '$value1'");
$current_capacity_array=mysqli_fetch_array($current_capacity_query,MYSQL_BOTH);
$current_capacity = $current_capacity_array[0];

echo "Current Capacity at selected Location:";
echo "<br>";

echo var_dump($current_capacity);

//Make sure capacity + 1 is not greater than the capacity

if(!($current_capacity + 1 > $capacity)) {
	$newloc="UPDATE car SET `CarLocation`='".$value1."' WHERE `VehicleSno`='".$value2."'";
	$result5 = mysqli_query($connection4, $newloc);
}
?>
</form>
<br>
<div id="txtHint"><b>Updated!</b></div>
</body>
</html>