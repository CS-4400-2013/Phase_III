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

$Username = $_SESSION['username'];

$current_reservations_query = mysqli_query($connection,"SELECT DATE_FORMAT(PickUpDateTime,'%m/%d/%y') AS 'Date', 
		DATE_FORMAT(PickUpDateTime,'%h:%i %p') AS 'Pick-Up',
		DATE_FORMAT(ReturnDateTime,'%h:%i %p') AS 'Return',
		CarModel, ReservationLocation, EstimatedCost
		FROM reservation INNER JOIN car ON reservation.VehicleSno=car.VehicleSno
		WHERE Username='$Username' AND TIMESTAMPDIFF(hour,ReturnDateTime,NOW()) < 0");
$previous_reservations_query = mysqli_query($connection,"	SELECT DATE_FORMAT(PickUpDateTime,'%m/%d/%y') AS 'Date', 
		DATE_FORMAT(PickUpDateTime,'%h:%i %p') AS 'Pick-Up',
		DATE_FORMAT(ReturnDateTime,'%h:%i %p') AS 'Return',
		CarModel, ReservationLocation, EstimatedCost + LateFees AS Cost, ReturnStatus
		FROM reservation INNER JOIN car ON reservation.VehicleSno=car.VehicleSno
		WHERE Username='$Username' AND TIMESTAMPDIFF(hour,ReturnDateTime,NOW()) >= 0");

echo "<table border='1'>
<tr>
<th>Date</th>
<th>Reservation Time</th>
<th>Car</th>
<th>Location</th>
<th>Amount</th>
</tr>";

while($current_reservations_result = mysqli_fetch_array($current_reservations_query)) {
		echo "<tr>";
		echo "<td>".$current_reservations_result['Date']." Driving"."</td>";
		echo "<td>".$current_reservations_result['Pick-Up']." - ".$current_reservations_result['Return']."</td>";
		echo "<td>".$current_reservations_result['CarModel']."</td>";
		echo "<td>".$current_reservations_result['ReservationLocation']."</td>";
		echo "<td>".$current_reservations_result['EstimatedCost']."</td>";
		echo "</tr>";
}
echo "</table>";

echo "<br><br>";

echo "<table border='1'>
<tr>
<th>Date</th>
<th>Reservation Time</th>
<th>Car</th>
<th>Location</th>
<th>Amount</th>
<th>Return Status</th>
</tr>";

while($previous_reservations_result = mysqli_fetch_array($previous_reservations_query)) {
		echo "<tr>";
		echo "<td>".$previous_reservations_result['Date']." Driving"."</td>";
		echo "<td>".$previous_reservations_result['Pick-Up']." - ".$previous_reservations_result['Return']."</td>";
		echo "<td>".$previous_reservations_result['CarModel']."</td>";
		echo "<td>".$previous_reservations_result['ReservationLocation']."</td>";
		echo "<td>".$previous_reservations_result['Cost']."</td>";
		echo "<td>".$previous_reservations_result['ReturnStatus']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
