<?php
session_start();
$q=$_GET["q"];

$_SESSION["location_selection"] = $_GET["q"];
//save the selected location to a session variable


//print out q for debugging purposes
echo var_dump($q);

//Find out what the variables are for this page
echo var_dump(get_defined_vars());
$connection=mysqli_connect("localhost","root","","car rental");

$carmodel_query = mysqli_query($connection,"SELECT VehicleSno FROM car WHERE CarLocation = '".$q."'");
//$sql="SELECT VehicleSno FROM car WHERE CarLocation = '".$q."'";

//here are the variables that we are going to be using
/*
$car = $_POST["car_select"];
$carsno = $_POST["car_sno"];
$problem = $_POST["problem_description"];
*/

//'".$q."'" is how we use php vars in a mysql statement
echo "Select a VehicleSno:";

echo "<br>";
echo "<select name ='car_select'>";
while($car_result = mysqli_fetch_array($carmodel_query)) {
		echo "<option value=".$car_result['VehicleSno'].">".$car_result['VehicleSno']."</option>";
}
echo "</select>";

echo"Brief Description of the problem:
<br>
<br>";
echo"<textarea name='problem_description' rows='10' cols='30'>
Describe Problem here.
</textarea>";

mysql_close($connection);
?>
