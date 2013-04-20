<html>
<body>
<?php
$Member_Next = $_GET["Member_Next"];

switch($Member_Next)
{
	case "Rent_Car":
		echo "Rent Car";
		break;
	case "Enter_Info":
		echo "Enter Info";
		break;
	case "Rental_History":
		echo "Rental History";
		break;
}

?>
</body>
</html>
