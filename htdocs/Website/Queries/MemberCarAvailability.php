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
$pickup = DateTime::createFromFormat('Y-m-d h:i:s',$pickuptime);
$return = DateTime::createFromFormat('Y-m-d h:i:s',$returntime);
$timediff = $pickup->diff($return);
$days = $timediff->format('%d');
if(!$days)
	$days = 0;
if($timediff->format('%R') == '-' || $days > 2)
	header("Location: MemberRentCar.php");

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
			AND CarLocation='$location' AND IF('$Type'='NONE',TRUE,Type='$Type') AND IF('$CarModel'='NONE',TRUE,CarModel='$CarModel')
			AND car.VehicleSno NOT IN (SELECT VehicleSno FROM maintenance_request)");
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
			AND CarLocation<>'$location' AND IF('$Type'='NONE',TRUE,Type='$Type') AND IF('$CarModel'='NONE',TRUE,CarModel='$CarModel')
			AND car.VehicleSno NOT IN (SELECT VehicleSno FROM maintenance_request)
		ORDER BY CarLocation");
$discounts_query = mysqli_query($connection,"SELECT IF((`Discount`/100+1)*`HourlyRate`,(`Discount`/100+1)*`HourlyRate`,`HourlyRate`) AS `Rate`, 
		car.VehicleSno, drivingplan.Type
		FROM car INNER JOIN drivingplan");
$availabletill_query = mysqli_query($connection,"SELECT IF(TIMESTAMPDIFF(hour,'$returntime',MIN(PickUpDateTime)) < 12,MIN(PickUpDateTime),NULL) AS Availability, 
		car.VehicleSno
		FROM reservation INNER JOIN car ON car.VehicleSno=reservation.VehicleSno
		WHERE PickUpDateTime > '$returntime'");
$member_info_query = mysqli_query($connection,"	SELECT * FROM member WHERE Username='$username'");
$member_info_result = mysqli_fetch_array($member_info_query);

$rentals = array(array());
$no_rentals = 0;

echo "
<form action='MemberCarAvailabilityHandler.php' method='get'>
<table border='1'>
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

$checked = 'checked';

while($firstlocation_result = mysqli_fetch_array($firstlocation_query)) {
		echo "<tr>";
		echo "<td>".$firstlocation_result['CarModel']."</td>";
		echo "<td>".$firstlocation_result['Type']."</td>";
		echo "<td>".$firstlocation_result['CarLocation']."</td>";
		echo "<td>".$firstlocation_result['Color']."</td>";
		echo "<td>".$firstlocation_result['HourlyRate']."</td>";

		$rentals[$no_rentals]['CarModel'] = $firstlocation_result['CarModel'];
		$rentals[$no_rentals]['Type'] = $firstlocation_result['Type'];
		$rentals[$no_rentals]['CarLocation'] = $firstlocation_result['CarLocation'];
		$rentals[$no_rentals]['Color'] = $firstlocation_result['Color'];
		$rentals[$no_rentals]['HourlyRate'] = $firstlocation_result['HourlyRate'];

		// Discounts
		echo "<td>";
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Frequent') {
				echo $discounts_result['Rate'];
				$rentals[$no_rentals]['Frequent'] = $discounts_result['Rate'];
			}
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		echo "</td>";
		echo "<td>";
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Daily') {
				echo "<td>".$discounts_result['Rate']."</td>";
				$rentals[$no_rentals]['Daily'] = $discounts_result['Rate'];
			}
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		echo "</td>";

		echo "<td>".$firstlocation_result['DailyRate']."</td>";
		echo "<td>".$firstlocation_result['Seating_Capacity']."</td>";
		echo "<td>".$firstlocation_result['Transmission_Type']."</td>";
		echo "<td>".$firstlocation_result['BluetoothConnectivity']."</td>";
		echo "<td>".$firstlocation_result['Auxiliary Cable']."</td>";

		$rentals[$no_rentals]['DailyRate'] = $firstlocation_result['DailyRate'];
		$rentals[$no_rentals]['Seating_Capacity'] = $firstlocation_result['Seating_Capacity'];
		$rentals[$no_rentals]['Transmission_Type'] = $firstlocation_result['Transmission_Type'];
		$rentals[$no_rentals]['BluetoothConnectivity'] = $firstlocation_result['BluetoothConnectivity'];
		$rentals[$no_rentals]['Auxiliary_Cable'] = $firstlocation_result['Auxiliary Cable'];		

		// Available till
		mysqli_data_seek($availabletill_query,0);
		$availabletill_result = mysqli_fetch_array($availabletill_query);
		$has_availabletill = 0;
		for($i=0;$i<count($availabletill_result)&&$has_availabletill==0;$i++) {
			if($availabletill_result['VehicleSno'] == $firstlocation_result['VehicleSno']
			&& $availabletill_result['Availability'] != NULL) {
				echo "<td>".$availabletill_result['Availability']."</td>";
				$rentals[$no_rentals]['Availability'] = $availabletill_result['Availability'];		
				$has_availabletill = 1;
			}
			$availabletill_result = mysqli_fetch_array($availabletill_query);
		}
		if($has_availabletill==0)
			echo "<td>N/A</td>";

		// Estimated Cost
		echo "<td>";
			mysqli_data_seek($discounts_query,0);
			$discounts_result = mysqli_fetch_array($discounts_query);
			$cost = 0;
			for($i=0;$i<count($discounts_result);$i++) {
				if($discounts_result['VehicleSno'] == $firstlocation_result['VehicleSno']
				&& $discounts_result['Type'] == $member_info_result['DrivingPlan'])
					$cost = $discounts_result['Rate'];
				$discounts_result = mysqli_fetch_array($discounts_query);
			}
			if($cost == 0)
				$cost = $firstlocation_result['HourlyRate'];
			$estimated_cost = $cost*((strtotime($returntime) -
								strtotime($pickuptime))/3600);
			$rentals[$no_rentals]['estimated_cost'] = $estimated_cost;			
			echo $estimated_cost;
		echo "</td>";

		echo '<td><input type="radio" name="rental" 
				value="'.$no_rentals.'" '.$checked.'></input></td>';
		echo "</tr>";

		$rentals[$no_rentals]['VehicleSno'] = $firstlocation_result['VehicleSno'];			
		$no_rentals++;
}
while($secondlocation_result = mysqli_fetch_array($secondlocation_query)) {
		echo "<tr>";
		echo "<td>".$secondlocation_result['CarModel']."</td>";
		echo "<td>".$secondlocation_result['Type']."</td>";
		echo "<td>".$secondlocation_result['CarLocation']."</td>";
		echo "<td>".$secondlocation_result['Color']."</td>";
		echo "<td>".$secondlocation_result['HourlyRate']."</td>";

		$rentals[$no_rentals]['CarModel'] = $secondlocation_result['CarModel'];
		$rentals[$no_rentals]['Type'] = $secondlocation_result['Type'];
		$rentals[$no_rentals]['CarLocation'] = $secondlocation_result['CarLocation'];
		$rentals[$no_rentals]['Color'] = $secondlocation_result['Color'];
		$rentals[$no_rentals]['HourlyRate'] = $secondlocation_result['HourlyRate'];

		// Discounts
		echo "<td>";
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $secondlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Frequent') {
				echo "<td>".$discounts_result['Rate']."</td>";
				$rentals[$no_rentals]['Frequent'] = $discounts_result['Rate'];
			}
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		echo "</td>";
		echo "<td>";
		mysqli_data_seek($discounts_query,0);
		$discounts_result = mysqli_fetch_array($discounts_query);
		for($i=0;$i<count($discounts_result);$i++) {
			if($discounts_result['VehicleSno'] == $secondlocation_result['VehicleSno']
			&& $discounts_result['Type'] == 'Daily') {
				echo "<td>".$discounts_result['Rate']."</td>";
				$rentals[$no_rentals]['Daily'] = $discounts_result['Rate'];
			}
			$discounts_result = mysqli_fetch_array($discounts_query);
		}
		echo "</td>";

		echo "<td>".$secondlocation_result['DailyRate']."</td>";
		echo "<td>".$secondlocation_result['Seating_Capacity']."</td>";
		echo "<td>".$secondlocation_result['Transmission_Type']."</td>";
		echo "<td>".$secondlocation_result['BluetoothConnectivity']."</td>";
		echo "<td>".$secondlocation_result['Auxiliary Cable']."</td>";

		$rentals[$no_rentals]['DailyRate'] = $secondlocation_result['DailyRate'];
		$rentals[$no_rentals]['Seating_Capacity'] = $secondlocation_result['Seating_Capacity'];
		$rentals[$no_rentals]['Transmission_Type'] = $secondlocation_result['Transmission_Type'];
		$rentals[$no_rentals]['BluetoothConnectivity'] = $secondlocation_result['BluetoothConnectivity'];
		$rentals[$no_rentals]['Auxiliary_Cable'] = $secondlocation_result['Auxiliary Cable'];		

		// Available till
		mysqli_data_seek($availabletill_query,0);
		$availabletill_result = mysqli_fetch_array($availabletill_query);
		$has_availabletill = 0;
		for($i=0;$i<count($availabletill_result)&&$has_availabletill==0;$i++) {
			if($availabletill_result['VehicleSno'] == $secondlocation_result['VehicleSno']
			&& $availabletill_result['Availability'] != NULL) {
				echo "<td>".$availabletill_result['Availability']."</td>";
				$rentals[$no_rentals]['Availability'] = $availabletill_result['Availability'];		
				$has_availabletill = 1;
			}
			$availabletill_result = mysqli_fetch_array($availabletill_query);
		}
		if($has_availabletill==0)
			echo "<td>N/A</td>";

		// Estimated Cost
		echo "<td>";
			mysqli_data_seek($discounts_query,0);
			$discounts_result = mysqli_fetch_array($discounts_query);
			$cost = 0;
			for($i=0;$i<count($discounts_result);$i++) {
				if($discounts_result['VehicleSno'] == $secondlocation_result['VehicleSno']
				&& $discounts_result['Type'] == $member_info_result['DrivingPlan'])
					$cost = $discounts_result['Rate'];
				$discounts_result = mysqli_fetch_array($discounts_query);
			}
			if($cost == 0)
				$cost = $secondlocation_result['HourlyRate'];
			$estimated_cost = $cost*((strtotime($returntime) -
								strtotime($pickuptime))/3600);
			$rentals[$no_rentals]['estimated_cost'] = $estimated_cost;			
			echo $estimated_cost;
		echo "</td>";

		echo '<td><input type="radio" name="rental" 
				value="'.$no_rentals.'" '.$checked.'></input></td>';

		$checked = '';
		echo "</tr>";

		$rentals[$no_rentals]['VehicleSno'] = $secondlocation_result['VehicleSno'];			
		$no_rentals++;
}
$_SESSION['rentals'] = $rentals;

echo '</table>
<input type="hidden" name="pickuptime" value="'.$pickuptime.'"></input>
<input type="hidden" name="returntime" value="'.$returntime.'"></input>
<input type="submit" value="Reserve"></input>

</form>';

mysqli_close($connection);
?>
</body>
</html>