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

$locationreport_query = mysqli_query($connection,"SELECT * FROM 
(SELECT Month, Location, Total, MAX(Hours) AS Hours FROM (
    SELECT Date_Format(PickUpDateTime, '%b') AS 'Month', ReservationLocation AS Location, Count(*) AS Total, 
    SUM(HOUR(SEC_TO_TIME((UNIX_TIMESTAMP(ReturnDateTime) - UNIX_TIMESTAMP(PickUpDateTime))))) AS Hours
    FROM location INNER JOIN reservation
    ON location.LocationName=Reservation.ReservationLocation
    WHERE DATE_SUB(CURDATE(),INTERVAL 3 MONTH) < PickUpDateTime AND 
    CURDATE() > PickUpDateTime
    GROUP BY Location
    ORDER BY Month DESC
) AS FirstRun
GROUP BY Location) AS SecondRun
GROUP BY Month");

echo "<table border='1'>
<tr>
<th>Month</th>
<th>Location</th>
<th>No of Reservations</th>
<th>Total no of hours</th>
</tr>";

while($locationreport_result = mysqli_fetch_array($locationreport_query)) {
		echo "<tr>";
		echo "<td>".$locationreport_result['Month']."</td>";
		echo "<td>".$locationreport_result['Location']."</td>";
		echo "<td>".$locationreport_result['Total']."</td>";
		echo "<td>".$locationreport_result['Hours']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
