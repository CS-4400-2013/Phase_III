<html>
<body>
<form>
Car Info
<?php


$v=$_GET["v"];
echo "<br>";
echo "Vehicle Serial No:";
echo $v;
echo "<br>";
$connection4=mysqli_connect("localhost","root","","car rental");

if (mysqli_connect_errno($connection4)) //make sure connection exists
{
  echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$info="SELECT Color,Type,Transmission_Type,Seating_Capacity FROM car WHERE VehicleSno='".$v."'";
$result3 = mysqli_query($connection4, $info);
$array3 = mysqli_fetch_array($result3,MYSQL_BOTH);
echo "<br>";
echo "Color:".$array3[0];
echo "<br>";
echo "Type:".$array3[1];
echo "<br>";
echo "Transmission Type:".$array3[2];
echo "<br>";
echo "Seating Capacity:".$array3[3];
echo "<br>";
$location2="SELECT LocationName FROM location";
$result2 = mysqli_query($connection4, $location2);
echo "Select New Location:";
echo "<select name='location select' onchange='update(this.value,".$v.")'>";
echo "<option value='none'>none</option>";
while($array = mysqli_fetch_array($result2,MYSQL_BOTH))
{
echo "<option value='".$array[0]."'>".$array[0]."</option>";
}
echo "</select>";

?>
</form>
<br>
<div id="txtHint"><b>Select location to update</b></div>
</body>
</html>
