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

$Employee_Next = $_GET["Employee_Next"];

switch($Employee_Next)
{
	case "Add_Car":
		header('Location: ../AddCar.html');
		break;
	case "ChangeCarLocation":
		header('Location: ChangeCarLocation.php');
		break;
	
}

mysqli_close($connection);
?>
</body>
</html>
