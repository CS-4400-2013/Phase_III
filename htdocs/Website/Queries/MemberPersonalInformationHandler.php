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

$username = $_SESSION['username'];
$username_query = mysqli_query($connection,"SELECT username FROM member WHERE username='$username'");
$username_result = mysqli_fetch_array($username_query);

$first_name = $_POST["first_name"];
$middle_initial = $_POST["middle_initial"];
$last_name = $_POST["last_name"];
$email_address = $_POST["email_address"];
$phone_number = $_POST["phone_number"];
$address = $_POST["address"];
$DrivingPlan = $_POST["DrivingPlan"];
$name_on_card = $_POST["name_on_card"];
$card_number = $_POST["card_number"];
$cvv = $_POST["cvv"];
$expiry_date = $_POST["expiry_date"];
$billing_address = $_POST["billing_address"];
if (isset($username_result['username'])) {
	mysqli_query($connection,"UPDATE `credit card` c, member m
		SET c.Name='$name_on_card',c.CardNo='$card_number',c.CVV=$cvv,
		c.ExpiryDate='$expiry_date',c.BillingAdd='$billing_address'
		WHERE c.CardNo=m.CardNo AND m.Username='$username' AND DATEDIFF('$expiry_date', CurDate()) >= 0");	
	mysqli_query($connection,"UPDATE member
		SET FirstName='$first_name', LastName='$last_name', MiddleInit='$middle_initial',
		Address='$address', PhoneNo='$phone_number', EmailAddress='$email_address',
		DrivingPlan='$DrivingPlan'
		WHERE Username='$username'");
	header('Location: ../MemberHomePage.html');
} else {
	$password = $_SESSION['password'];
	if (isset($DrivingPlan) && 
	$name_on_card != "" &&
	$card_number != "" &&
	$cvv != "" &&
	$expiry_date != "" &&
	$billing_address != "") 
	{
		mysqli_query($connection,"INSERT INTO user (Username, Password) VALUES ('$username', '$password')");
		$card_no_query = mysqli_query($connection,"SELECT CardNo FROM `credit card` WHERE CardNo=$card_number");
		$card_no_result = mysqli_fetch_array($card_no_query);
		if (!isset($card_no_result['CardNo']))
			mysqli_query($connection,"INSERT INTO `credit card`(
				`Name`, `CardNo`, `CVV`, `ExpiryDate`, `BillingAdd`) 
				VALUES ('$name_on_card', '$card_number', '$cvv', '$expiry_date', '$billing_address')");
		mysqli_query($connection,"INSERT INTO `member`
			(`Username`,`FirstName`,`LastName`,`MiddleInit`,
			`Address`,`PhoneNo`,`EmailAddress`,`CardNo`,`DrivingPlan`) 
			VALUES ('$username','$first_name','$last_name','$middle_initial',
			'$address','$phone_number','$email_address','$card_number','$DrivingPlan')");
		header('Location: ../MemberHomePage.html');
	}
	else 
	{
		header('Location: MemberPersonalInformation.php');
	}
}
mysqli_close($connection);
?>
</body>
</html>
