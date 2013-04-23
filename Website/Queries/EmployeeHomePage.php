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
$reporttype=$_GET["Employee_report"];
$username = $_SESSION['username'];

switch($Employee_Next)
{
	case "Manage_Car":
		header('Location: ../managecars.html');
		break;
	case "Maintainence_Requests":
		header('Location: servicerequest.php');
		break;
	case "Rental_Request_Change":
		header('Location: RentalRequestChangeUI.php');
		break;
	case "Reports":
		if($reporttype=="Location_preference")
			header('Location: EmployeeReportLocationPreference.php');
		elseif($reporttype=="Frequent_Users")
			header('Location: EmployeeReportFrequentUsers.php');
		elseif($reporttype=="Maintainence_History_Report")
			header('Location: EmployeeReportMaintainenceHistory.php');
		else
			header('Location: ../EmployeeHomePage.html');
		break;
}

mysqli_close($connection);
?>
</body>
</html>
