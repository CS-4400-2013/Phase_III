<html>
<head>
</head>
<body>
<form>
Choose Car

<?php
$connection2=mysqli_connect("localhost","root","","car rental");

if (mysqli_connect_errno($connection2)) //make sure connection exists
{
  echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$q=$_GET["q"];
$vehiclesno="SELECT VehicleSno FROM car WHERE CarLocation='".$q."'";
$result = mysqli_query($connection2,$vehiclesno);
echo "<select name='car select' onchange='showcarinfo(this.value)'>";
echo "<option value='n/a'>n/a</option>";
while($array2 = mysqli_fetch_array($result,MYSQL_BOTH))
{
echo "<option value=".$array2[0].">".$array2[0]."</option>"; 
}
echo "</select>";
?>
</form>
<br>
<div id="txtHint"><b>Next Page Will Show Car Info</b></div>

</body>
</html>
