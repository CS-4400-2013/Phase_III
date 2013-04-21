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

$drivingplan_query = mysqli_query($connection,"	SELECT * FROM drivingplan");

echo "<table border='1'>
<tr>
<th>Driving Plan</th>
<th>Monthly Payment</th>
<th>Discount</th>
<th>Annual Fees</th>
</tr>";

while($drivingplan_result = mysqli_fetch_array($drivingplan_query)) {
		echo "<tr>";
		echo "<td>".$drivingplan_result['Type']." Driving"."</td>";
		echo "<td>".$drivingplan_result['MonthlyPayment']."</td>";
		echo "<td>".$drivingplan_result['Discount']."</td>";
		echo "<td>".$drivingplan_result['AnnualFees']."</td>";
		echo "</tr>";
}
echo "</table>";


mysqli_close($connection);
?>
</body>
</html>
