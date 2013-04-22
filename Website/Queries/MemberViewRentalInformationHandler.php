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
$reservation = mysqli_query($connection,"SELECT * FROM reservation WHERE ResId='$ResId' ResId NOT IN
							(SELECT ResId FROM reservation WHERE ResId='$ResID' AND PickUpDateTime<'$ReturnTime')");
$reservation_result = mysqli_fetch_array($reservation);

if(strtotime($ReturnTime) - strtotime($reservation_result['ReturnDateTime']) <= 0)
	header("Location: MemberViewRentalInformation.php");
else {
	mysqli_query($connection,"UPDATE reservation
			SET ReturnDateTime='$ReturnTime'
			WHERE ResId='$ResId'");
	mysqli_query($connection,"INSERT into reservation (ResID,Extended_Time) VALUES ($ResId,$ReturnTime)");
	header("Location: ../MemberHomePage.html");
}
		
mysqli_close($connection);
?>
</body>
</html>