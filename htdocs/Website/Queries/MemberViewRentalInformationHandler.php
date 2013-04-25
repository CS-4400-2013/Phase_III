<html>
<head>
</head>
<body>
<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$ReturnTime = $_POST['return_time'];
$ResId = $_POST['reservation_to_update'];
$CurrentVehicle_Query =  mysqli_query($connection,"SELECT * FROM reservation WHERE ResId='$ResId'");
$CurrentVehicle_Result = mysqli_fetch_array($CurrentVehicle_Query);
$VehicleSno = $CurrentVehicle_Result['VehicleSno'];
$CurrentReturnTime = $CurrentVehicle_Result['ReturnDateTime'];
$reservation = mysqli_query($connection,"SELECT * FROM reservation WHERE VehicleSno='$VehicleSno' AND ResId!='$ResId' AND PickUpDateTime<'$ReturnTime'");
$reservation_result = mysqli_fetch_array($reservation);
if($CurrentVehicle_Result['VehicleSno'] != NULL && $reservation_result['VehicleSno'] == NULL)
if((strtotime($ReturnTime) - strtotime($CurrentVehicle_Result['ReturnDateTime'])) <= 0 ||
	(strtotime($ReturnTime) - strtotime($CurrentVehicle_Result['PickUpDateTime'])) <= 0) {
	header("Location: MemberViewRentalInformation.php");
}
else {
	if (!mysqli_fetch_array(mysqli_query($connection,"SELECT ResID FROM reservation_extended_time WHERE ResId='$ResId'")))
		mysqli_query($connection,"INSERT into reservation_extended_time (ResID,Extended_Time) VALUES ('$ResId','$CurrentReturnTime')");
	else
		mysqli_query($connection,"UPDATE `reservation_extended_time` SET `Extended_Time`='$CurrentReturnTime' WHERE ResID='$ResId'");
	mysqli_query($connection,"UPDATE reservation
			SET ReturnDateTime='$ReturnTime'
			WHERE ResId='$ResId'");
}
header("Location: MemberViewRentalInformation.php");
mysqli_close($connection);
?>
</body>
</html>