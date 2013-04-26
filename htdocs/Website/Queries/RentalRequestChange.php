<html>
<head>
<body>
</head>

<form action="servicerequestinsertaction.php" method="post">

<?php
session_start();

$connection=mysqli_connect("localhost","root","","car rental");

//TODO:
//Find out if another member has the same car booked
//select username from reservation where (time overlaps) AND vehiclesno = $vehiclesno
//need to figure out how to calculate the time overlap

//Calculate the late fees
//find out the difference in hours and multiply by 50

//(StartDate1 <= EndDate2) and (StartDate2 <= EndDate1) will get us an overlap between two dates


$username = $_GET['username'];
echo var_dump($username);
echo "<br>";
echo "Entered Model:
<br>";
$entered_model = $_GET['car_model'];
echo var_dump($entered_model);
echo "<br>";
$selected_location = $_GET['location_select'];
echo var_dump($selected_location);
echo "<br>";
$original_return_date = $_GET['original_return_date'];
echo var_dump($original_return_date);
echo "<br>";
$original_return_time = $_GET['original_return_time'];
echo var_dump($original_return_time);
echo "<br>";
$new_return_date = $_GET['new_return_date'];
echo var_dump($new_return_date);
echo "<br>";
$new_return_time = $_GET['new_return_time'];
echo var_dump($new_return_date);
echo "<br>";

$sno_query = "SELECT VehicleSno, ResID FROM reservation WHERE Username = '".$username."' AND ReturnDateTime = TIMESTAMP('".$original_return_date."' , '".$original_return_time."')";
$sno = mysqli_query($connection, $sno_query);
$sno_result = mysqli_fetch_array($sno, MYSQL_BOTH);
$sno_num = $sno_result[0];

//get the reservation id
$res_id = $sno_result[1];

$_SESSION["res_id"] = $res_id;

$_SESSION["sno_num"] = $sno_num;

echo var_dump($sno_num);
echo "<br>";
$model_query = "SELECT CarModel FROM car WHERE VehicleSno = '".$sno_num."'";
$model = mysqli_query($connection, $model_query);
$model_result = mysqli_fetch_array($model);
$model_queried = $model_result[0];
echo var_dump($model_queried);
echo "<br>";

if($entered_model == $model_queried)
{
	echo "Model entered matches model in the database";
	echo "<br>";
}
else
{
	echo "Model entered does not match model in the database";
	echo "<br>";
}


//Find reservations that start before the requested return time
echo "New Return date time: ";
echo "<br>";
$d1 = new DateTime('2008-08-03 14:52:10');
$new_return_unixtime = strtotime($new_return_date." ".$new_return_time);
$new_return_datetime = date("Y-m-d h:i:s A T",$new_return_unixtime);

$original_return_unixtime = strtotime($original_return_date." ".$original_return_time);
$original_return_datetime = date("Y-m-d h:i:s A T",$original_return_unixtime);

echo var_dump($new_return_datetime);
echo "<br>";

echo "Affected User: ";
echo "<br>";
echo "hello";
$affected_user_query = mysqli_query($connection, "SELECT Username, PickUpDateTime, ReturnDateTime FROM reservation WHERE PickUpDateTime <  '".$new_return_datetime."'");
echo "About to do the while loop";
echo "<br>";
echo var_dump($affected_user_query);

$array=mysqli_fetch_array($affected_user_query,MYSQL_BOTH);
$affected_user = $array[0];
$original_pickup_time = $array[1];
$original_return_time = $array[2];

$_SESSION["affecteduser"] = $affected_user;
$_SESSION["original_pickup_time"] = $original_pickup_time;
$_SESSION["original_return_time"] = $original_return_time;
echo "<br>";

//difference between two dates
$diff = abs(strtotime($original_return_datetime) - strtotime($new_return_datetime)); 

$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds); 

$late_fee = ($hours + $days*24) * 50;

echo "<br>";

echo "Late Fee: ";
echo var_dump($late_fee);

$late = "LATE";
$on_time = "ON TIME";

$update_string = "UPDATE reservation SET ReturnDateTime='$new_return_datetime', LateFees='$late_fee', ReturnStatus='$late' WHERE Username = '".$username."' AND ReturnDateTime = '".$original_return_time."'";
$update_query = mysqli_query($connection, $update_string);

if($affected_user != NULL)
{
	header('Location: UserAffected.php');
}
else
{
	//update query goes here
	//when the query is successful
	//change back to employee homepage

	header('Location: Website/EmployeeHomePage.html');
	break;
}

mysql_close($connection);
?>
</form>
</body>
</html>
