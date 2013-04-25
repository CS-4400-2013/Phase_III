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
		CarModel, ReservationLocation, EstimatedCost, ResID
		FROM reservation INNER JOIN car ON reservation.VehicleSno=car.VehicleSno
		WHERE Username='$Username' AND TIMESTAMPDIFF(hour,ReturnDateTime,NOW()) < 0");
$previous_reservations_query = mysqli_query($connection,"	SELECT DATE_FORMAT(PickUpDateTime,'%m/%d/%y') AS 'Date', 
		DATE_FORMAT(PickUpDateTime,'%h:%i %p') AS 'Pick-Up',
		DATE_FORMAT(ReturnDateTime,'%h:%i %p') AS 'Return',
		CarModel, ReservationLocation, EstimatedCost + LateFees AS Cost, ReturnStatus
		FROM reservation INNER JOIN car ON reservation.VehicleSno=car.VehicleSno
		WHERE Username='$Username' AND TIMESTAMPDIFF(hour,ReturnDateTime,NOW()) >= 0");

echo "
<form action='MemberViewRentalInformationHandler.php' method='post'>
<table border='1'>
<tr>
<th>Date</th>
<th>Reservation Time</th>
<th>Car</th>
<th>Location</th>
<th>Amount</th>
<th>Extend?</th>
</tr>";

while($current_reservations_result = mysqli_fetch_array($current_reservations_query)) {
		echo "<tr>";
		echo "<td>".$current_reservations_result['Date']."</td>";
		echo "<td>".$current_reservations_result['Pick-Up']." - ".$current_reservations_result['Return']."</td>";
		echo "<td>".$current_reservations_result['CarModel']."</td>";
		echo "<td>".$current_reservations_result['ReservationLocation']."</td>";
		echo "<td>$".$current_reservations_result['EstimatedCost']."</td>";
		echo '<td><input type="radio" name="reservation_to_update" value="'.$current_reservations_result['ResID'].'" checked></input></td>';
		echo "</tr>";
}
echo "</table>";

echo "<br><br>";

echo "Choose return time: <select name='return_time'>";

for($i=0;$i<5;$i++) {
	for($j=1;$j<6;$j++) {
		echo '<option value="'; echo date("Y-m-d H:i:s", strtotime($current_reservations_result['Date']." ". $current_reservations_result['Return'])+60*30*$j+60*60*24*$i).'">';
		echo date("m/d/Y H:i A", strtotime($current_reservations_result['Date']." ". $current_reservations_result['Return'])+60*30*$j+60*60*24*$i);
		echo "</option>";
	}
}

echo "</select>";
echo "<input type='submit' value='Update'></input>";
echo "</form><br><br>";

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
		echo "<td>".$previous_reservations_result['Date']."</td>";
		echo "<td>".$previous_reservations_result['Pick-Up']." - ".$previous_reservations_result['Return']."</td>";
		echo "<td>".$previous_reservations_result['CarModel']."</td>";
		echo "<td>".$previous_reservations_result['ReservationLocation']."</td>";
		echo "<td>$".$previous_reservations_result['Cost']."</td>";
		echo "<td>".$previous_reservations_result['ReturnStatus']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
