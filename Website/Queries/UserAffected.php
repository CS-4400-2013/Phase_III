<html>
<head>
<title>User Affected</title>
</head>
<body>



User Affected
<br>
<br>


<?php
session_start();

$connection=mysqli_connect("localhost","root","","car rental");


$res_id = $_SESSION["res_id"];
echo var_dump($res_id);
echo "<br>";
$sno_num = $_SESSION["sno_num"];
echo var_dump($sno_num);
$affecteduser = $_SESSION["affecteduser"];
$pickuptime = $_SESSION["original_pickup_time"];
$returntime = $_SESSION["original_return_time"];

$sno_query = "SELECT VehicleSno, ResID FROM reservation WHERE Username = '".$affecteduser."' AND ReturnDateTime = TIMESTAMP('".$returntime."')";
$sno = mysqli_query($connection, $sno_query);
$sno_result = mysqli_fetch_array($sno, MYSQL_BOTH);
$sno_num = $sno_result[0];

//get the reservation id
$res_id = $sno_result[1];

$_SESSION["res_id"] = $res_id;

$_SESSION["sno_num"] = $sno_num;


$info_string = "SELECT EmailAddress, PhoneNo FROM member WHERE Username = '".$affecteduser."'";
$info_query = mysqli_query($connection, $info_string);


$info_query_array = mysqli_fetch_array($info_query); 
$email_address = $info_query_array[0];
$phone_number = $info_query_array[1];



echo "Username: <input type='text' name='username' value ='$affecteduser'><br>";

echo "Original Pickup Time: <input type='text' name='pickup_time' value ='$pickuptime'<br>";


echo "Original Return Time: <input type='text' name='return_time' value ='$returntime'><br>";

echo "Email Address: 			<input type='text' name='email_address' value ='$email_address'><br>";
echo "Phone Number: 			<input type='text' name='phone_number' value= '$phone_number'><br>";



mysqli_close($connection);

?>

<form name="cancel" action="cancelreservation.php">
<input type ="submit" value="Cancel Request">
</form>
<form name="caravailability" action="../EmployeeHomePage.html">
<input type ="submit" value="Show Car Availability">
</form>

</body>
</html>