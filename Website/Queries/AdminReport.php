<html>
<body>
<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$adminreport_query = mysqli_query($connection,"Select car.VehicleSno, car.Type, car.CarModel, (SUM(EstimatedCost)) AS cost, (SUM(LateFees)) AS late_fees
FROM reservation INNER JOIN car ON reservation.VehicleSno=car.VehicleSno
WHERE DATE_SUB(CURDATE(),INTERVAL 3 MONTH) < PickUpDateTime AND 
CURDATE() > PickUpDateTime
Group By VehicleSno
ORDER BY Type");

echo "<table border='1'>
<tr>
<th>Vehicle Sno</th>
<th>Type</th>
<th>Car Model</th>
<th>Reservation revenue</th>
<th>Late Fees Revenue</th>
</tr>";

while($adminreport_result = mysqli_fetch_array($adminreport_query)) {
		echo "<tr>";
		echo "<td>".$adminreport_result['VehicleSno']."</td>";
		echo "<td>".$adminreport_result['Type']."</td>";
		echo "<td>".$adminreport_result['CarModel']."</td>";
		echo "<td>".$adminreport_result['cost']."</td>";
		echo "<td>".$adminreport_result['late_fees']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
