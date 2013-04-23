<html>
<body>
<form>
<?php
echo "ran update";
$value1=$_GET["l"];
echo $value1;
$value2=$_GET["c"];
echo $value2;
$connection4=mysqli_connect("localhost","root","","car rental");
if (mysqli_connect_errno($connection4)) //make sure connection exists
{
  echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$newloc="UPDATE car SET `CarLocation`='".$value1."' WHERE `VehicleSno`='".$value2."'";
$result5 = mysqli_query($connection4, $newloc);
?>
</form>
<br>
<div id="txtHint"><b>Updated!</b></div>
</body>
</html>