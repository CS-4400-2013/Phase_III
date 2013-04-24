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

$report_query = mysqli_query($connection,"SELECT CarModel, RequestDateTime, Username, Problem FROM (SELECT CarModel, maintenance_request.RequestDateTime, Username, Problem, maintenance_request.VehicleSno
FROM maintenance_request_problems INNER JOIN maintenance_request INNER JOIN car
ON maintenance_request.RequestDateTime=maintenance_request_problems.RequestDateTime AND maintenance_request.VehicleSno=maintenance_request_problems.VehicleSno 
AND car.VehicleSno=maintenance_request.VehicleSno) AS FirstRun 
INNER JOIN (SELECT COUNT(*) AS amount, maintenance_request.VehicleSno FROM maintenance_request_problems INNER JOIN maintenance_request INNER JOIN car
ON maintenance_request.RequestDateTime=maintenance_request_problems.RequestDateTime AND maintenance_request.VehicleSno=maintenance_request_problems.VehicleSno 
AND car.VehicleSno=maintenance_request.VehicleSno
GROUP BY maintenance_request.VehicleSno) AS SecondRun
ON FirstRun.VehicleSno=SecondRun.VehicleSno
ORDER BY amount DESC");

echo "<table border='1'>
<tr>
<th>Car</th>
<th>Date-Time</th>
<th>Employee</th>
<th>Problem</th>
</tr>";

while($report_result = mysqli_fetch_array($report_query)) {
		echo "<tr>";
		echo "<td>".$report_result['CarModel']."</td>";
		echo "<td>".$report_result['RequestDateTime']."</td>";
		echo "<td>".$report_result['Username']."</td>";
		echo "<td>".$report_result['Problem']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
