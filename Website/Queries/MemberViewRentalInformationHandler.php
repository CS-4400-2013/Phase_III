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
$VehicleSno_Query =  mysqli_query($connection,"SELECT * FROM reservation WHERE ResId='$ResId'");
$VehicleSno_Result = mysqli_fetch_array($VehicleSno_Query);
$VehicleSno = $VehicleSno_Result['VehicleSno'];
$reservation = mysqli_query($connection,"SELECT * FROM reservation WHERE VehicleSno='$VehicleSno' AND ResId!='$ResId' AND PickUpDateTime<'$ReturnTime'");
$reservation_result = mysqli_fetch_array($reservation);
if($VehicleSno_Result['VehicleSno'] != NULL && $reservation_result['VehicleSno'] == NULL)
if((strtotime($ReturnTime) - strtotime($VehicleSno_Result['ReturnDateTime'])) <= 0 ||
	(strtotime($ReturnTime) - strtotime($VehicleSno_Result['PickUpDateTime'])) <= 0)
	header("Location: MemberViewRentalInformation.php");
else {
	mysqli_query($connection,"UPDATE reservation
			SET ReturnDateTime='$ReturnTime'
			WHERE ResId='$ResId'");
	mysqli_query($connection,"INSERT into reservation (ResID,Extended_Time) VALUES ($ResId,$ReturnTime)");
}
header("Location: MemberViewRentalInformation.php");
mysqli_close($connection);
?>
</body>
</html>