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

$Member_Next = $_GET["Member_Next"];
$username = $_SESSION['username'];

// Check if member has this username
$member_query = mysqli_query($connection,"SELECT username FROM member WHERE username='".$username."'");
if(!$member_query)
	echo "query error";

$member_result = mysqli_fetch_array($member_query);
switch($Member_Next)
{
	case "Rent_Car":
		if(isset($member_result['username']))
			header('Location: MemberRentCar.php');
		else
			header('Location: ../MemberHomePage.html');
		break;
	case "Enter_Info":
		header('Location: MemberPersonalInformation.php');
		break;
	case "Rental_Info":
		if(isset($member_result['username'])) 
			header('Location: MemberViewRentalInformation.php');
		else
			header('Location: ../MemberHomePage.html');
		break;
}

mysqli_close($connection);
?>
</body>
</html>
