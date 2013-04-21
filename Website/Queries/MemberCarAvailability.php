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

$username = $_SESSION['username'];
$pickuptime = $_GET['pickuptime'];
$returntime = $_GET['returntime'];
$CarModel = $_GET['CarModel'];
$Type = $_GET['Type'];
$location = $_GET['location'];

$firstlocation_query = mysqli_query($connection,"SELECT `CarModel`,`Type`,`CarLocation`,`Color`,
		`HourlyRate`,`DailyRate`,
		`Seating_Capacity`,`Transmission_Type`,`BluetoothConnectivity`,
		`Auxiliary Cable`, `VehicleSno`
		FROM car
		WHERE car.VehicleSno NOT IN 
			(SELECT car.VehicleSno FROM car INNER JOIN reservation ON car.VehicleSno=reservation.VehicleSno
			WHERE ('$pickuptime' >= reservation.PickUpDateTime AND '$pickuptime' <= reservation.ReturnDateTime)
				OR ('$pickuptime' < reservation.PickUpDateTime AND '$returntime' > reservation.PickUpDateTime)
			)
			AND CarLocation='$location' AND IFNULL(Type='$Type', TRUE) AND IFNULL(CarModel='$CarModel', TRUE)");
$secondlocation_query = mysqli_query($connection,"SELECT `CarModel`,`Type`,`CarLocation`,`Color`,
		`HourlyRate`,`DailyRate`,
		`Seating_Capacity`,`Transmission_Type`,`BluetoothConnectivity`,
		`Auxiliary Cable`, `VehicleSno`
		FROM car
		WHERE car.VehicleSno NOT IN 
			(SELECT car.VehicleSno FROM car INNER JOIN reservation ON car.VehicleSno=reservation.VehicleSno
			WHERE ('$pickuptime' >= reservation.PickUpDateTime AND '$pickuptime' <= reservation.ReturnDateTime)
				OR ('$pickuptime' < reservation.PickUpDateTime AND '$returntime' >= reservation.PickUpDateTime)
			)
			AND CarLocation<>'$location' AND IFNULL(Type='$Type', TRUE) AND IFNULL(CarModel='$CarModel', TRUE)
		ORDER BY CarLocation");
$discounts_query = mysqli_query($connection,"SELECT IF((`Discount`/100+1)*`HourlyRate`,(`Discount`/100+1)*`HourlyRate`,`HourlyRate`) AS `Rate`, 
		car.VehicleSno, drivingplan.Type
		FROM car INNER JOIN drivingplan");
$availabletill_query = mysqli_query($connection,"SELECT IF(TIMESTAMPDIFF(hour,'$returntime',MIN(PickUpDateTime)) < 12,MIN(PickUpDateTime),NULL) AS Availability, 
		car.VehicleSno
		FROM reservation INNER JOIN car ON car.VehicleSno=reservation.VehicleSno
		WHERE PickUpDateTime > '$returntime'");
$estimatedcost_query = mysqli_query($connection,"	
		SELECT (TIMESTAMPDIFF(hour,'$pickuptime','$returntime') AS `Cost`, 
		car.VehicleSno
		FROM car INNER JOIN member INNER JOIN drivingplan
		WHERE member.Username='$username' AND member.DrivingPlan=drivingplan.Type");
		
echo "<table border='1'>
<tr>
<th>Car Model</th>
<th>Car Type</th>
<th>Location</th>
<th>Color</th>
<th>HourlyRate</th>
<th>DiscountedRate</th>
<th>DiscountedRate</th>
<th>DailyRate</th>
<th>Seating_Capacity</th>
<th>Transmission_Type</th>
<th>BluetoothConnectivity</th>
<th>Auxiliary Cable</th>
<th>Available Till</th>
<th>Estimated Cost</th>
</tr>";

while($firstlocation_result = mysqli_fetch_array($firstlocation_query)) {
		echo "<tr>";
		echo "<td>".$firstlocation_result['CarModel']."</td>";
		echo "<td>".$firstlocation_result['Type']."</td>";
		echo "<td>".$firstlocation_result['CarLocation']."</td>";
		echo "<td>".$firstlocation_result['Color']."</td>";
		echo "<td>".$firstlocation_result['HourlyRate']."</td>";
		
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Frequent')
				echo "<td>".$discounts_result['Rate']."</td>";
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Daily')
				echo "<td>".$discounts_result['Rate']."</td>";
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		
		echo "<td>".$firstlocation_result['DailyRate']."</td>";
		echo "<td>".$firstlocation_result['Seating_Capacity']."</td>";
		echo "<td>".$firstlocation_result['Transmission_Type']."</td>";
		echo "<td>".$firstlocation_result['BluetoothConnectivity']."</td>";
		echo "<td>".$firstlocation_result['Auxiliary Cable']."</td>";
		mysqli_data_seek($availabletill_query,0);
		$availabletill_result = mysqli_fetch_array($availabletill_query);
		$has_availabletill = 0;
		for($i=0;$i<count($availabletill_result)&&$has_availabletill==0;$i++) {
			if($availabletill_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $availabletill_result['Availability'] != NULL) {
				echo "<td>".$availabletill_result['Availability']."</td>";
				$has_availabletill = 1;
			}
			$availabletill_result = mysqli_fetch_array($availabletill_query);
		}
		if($has_availabletill==0)
			echo "<td>N/A</td>";
		echo "</tr>";
}
while($secondlocation_result = mysqli_fetch_array($secondlocation_query)) {
		echo "<tr>";
		echo "<td>".$secondlocation_result['CarModel']."</td>";
		echo "<td>".$secondlocation_result['Type']."</td>";
		echo "<td>".$secondlocation_result['CarLocation']."</td>";
		echo "<td>".$secondlocation_result['Color']."</td>";
		echo "<td>".$secondlocation_result['HourlyRate']."</td>";
		
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $secondlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Frequent')
				echo "<td>".$discounts_result['Rate']."</td>";
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $secondlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Daily')
				echo "<td>".$discounts_result['Rate']."</td>";
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		
		echo "<td>".$secondlocation_result['DailyRate']."</td>";
		echo "<td>".$secondlocation_result['Seating_Capacity']."</td>";
		echo "<td>".$secondlocation_result['Transmission_Type']."</td>";
		echo "<td>".$secondlocation_result['BluetoothConnectivity']."</td>";
		echo "<td>".$secondlocation_result['Auxiliary Cable']."</td>";
		
		mysqli_data_seek($availabletill_query,0);
		$availabletill_result = mysqli_fetch_array($availabletill_query);
		$has_availabletill = 0;
		for($i=0;$i<count($availabletill_result)&&$has_availabletill==0;$i++) {
			if($availabletill_result['VehicleSno'] == $secondlocation_result['VehicleSno']) {
				echo "<td>".$availabletill_result['Availability']."</td>";
				$has_availabletill = 1;
			}
			$availabletill_result = mysqli_fetch_array($availabletill_query);
		}
		if($has_availabletill==0)
			echo "<td>N/A</td>";
			
		echo "</tr>";
}
echo "</table>";

mysqli_close($connection);
?>
</body>
</html>
