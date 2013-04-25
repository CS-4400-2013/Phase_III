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
$username = $_SESSION['username'];

// Check if member has this username
$member_query = mysqli_query($connection,"SELECT username FROM member WHERE username='".$username."'");
if(!$member_query)
	echo "query error";

$member_result = mysqli_fetch_array($member_query);
switch($Employee_Next)
{
	case "Add_Car":
		if(isset($member_result['username']))
			header('Location: ../AddCar.html');
		else
			header('Location: ../MemberHomePage.html');
			break;
	case "ChangeCarLocations":
		header('Location: ChangeCarLocation.php');
		break;
	
}

mysqli_close($connection);
?>
</body>
</html>
