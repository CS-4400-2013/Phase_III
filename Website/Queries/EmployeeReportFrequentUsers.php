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

$report_query = mysqli_query($connection,"Select reservation.Username, DrivingPlan, COUNT(*) AS Count
FROM reservation INNER JOIN member ON reservation.Username=member.Username
WHERE DATE_SUB(CURDATE(),INTERVAL 3 MONTH) < PickUpDateTime AND 
CURDATE() > PickUpDateTime
Group By Username
ORDER BY Count DESC
LIMIT 5");

echo "<table border='1'>
<tr>
<th>Username</th>
<th>Driving plan</th>
<th>No of Reservations per month</th>
</tr>";

while($report_result = mysqli_fetch_array($report_query)) {
		echo "<tr>";
		echo "<td>".$report_result['Username']."</td>";
		echo "<td>".$report_result['DrivingPlan']."</td>";
		echo "<td>".$report_result['Count']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
