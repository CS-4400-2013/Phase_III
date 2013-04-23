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
$reporttype=$_GET["Employee_Report"]
$username = $_SESSION['username'];

// Check if member has this username
$member_query = mysqli_query($connection,"SELECT username FROM member WHERE username='".$username."'");
if(!$member_query)
	echo "query error";

$member_result = mysqli_fetch_array($member_query);
switch($Employee_Next)
{
	case "Manage_car":
		if(isset($member_result['username']))
			header('Location: ../managecars.html');
			break;
		else
			header('Location: ../MemberHomePage.html');
			break;
	case "Maintainence_Requests":
		header('Location: servicerequest.php');
		break;
	case "Rental_Request_Change":
		if(isset($member_result['username'])) 
			header('Location: RentalRequestChangeUI.php');
			break;
		else
			header('Location: ../MemberHomePage.html');
			break;
	case "Reports":
		if(isset($member_result['username']))
			if($reporttype="Location_Preference")
				header('Location: EmployeeReportLocationPreference.php');
			elseif($reporttype="Frequent_Users")
				header('Location: EmployeeReportFrequentUsers.php');
				break;
			elseif($reporttype="Maintainence_History_Report")
				header('Location: EmployeeReportMaintainenceHistory.php');
				break;
			else
				header('Location: ../MemberHomePage.html');
				break;
		else
			header('Location: ../MemberHomePage.html');
			break;
}

mysqli_close($connection);
?>
</body>
</html>
