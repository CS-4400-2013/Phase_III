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
$Username = $_SESSION['username'];
$username_query = mysqli_query($connection,"SELECT Username FROM member WHERE Username='$Username'");
$first_name_query = mysqli_query($connection,"SELECT FirstName FROM member WHERE Username='$Username'");
$middle_init_query = mysqli_query($connection,"SELECT MiddleInit FROM member WHERE Username='$Username'");
$last_name_query = mysqli_query($connection,"SELECT LastName FROM member WHERE Username='$Username'");
$email_query = mysqli_query($connection,"SELECT EmailAddress FROM member WHERE Username='$Username'");
$phoneno_query = mysqli_query($connection,"SELECT PhoneNo FROM member WHERE Username='$Username'");
$address_query = mysqli_query($connection,"SELECT Address FROM member WHERE Username='$Username'");
$driving_plan_query = mysqli_query($connection,"SELECT DrivingPlan FROM member WHERE Username='$Username'");
$card_no_query = mysqli_query($connection,"SELECT `credit card`.CardNo 
			FROM `credit card` INNER JOIN member 
			ON `credit card`.CardNo=member.CardNo WHERE Username='$Username'");
$card_name_query = mysqli_query($connection,"SELECT `credit card`.Name 
			FROM `credit card` INNER JOIN member 
			ON `credit card`.CardNo=member.CardNo WHERE Username='$Username'");	
$card_cvv_query = mysqli_query($connection,"SELECT `credit card`.CVV 
			FROM `credit card` INNER JOIN member 
			ON `credit card`.CardNo=member.CardNo WHERE Username='$Username'");	
$card_expire_query = mysqli_query($connection,"SELECT `credit card`.ExpiryDate 
			FROM `credit card` INNER JOIN member 
			ON `credit card`.CardNo=member.CardNo WHERE Username='$Username'");	
$card_billaddr_query = mysqli_query($connection,"SELECT `credit card`.BillingAdd 
			FROM `credit card` INNER JOIN member 
			ON `credit card`.CardNo=member.CardNo WHERE Username='$Username'");
			
$username_result = mysqli_fetch_array($username_query);
$first_name_result = mysqli_fetch_array($first_name_query);
$middle_init_result = mysqli_fetch_array($middle_init_query);
$last_name_result = mysqli_fetch_array($last_name_query);
$email_result = mysqli_fetch_array($email_query);
$phoneno_result = mysqli_fetch_array($phoneno_query);
$address_result = mysqli_fetch_array($address_query);
$driving_plan_result = mysqli_fetch_array($driving_plan_query);
$card_no_result = mysqli_fetch_array($card_no_query);
$card_name_result = mysqli_fetch_array($card_name_query);
$card_cvv_result = mysqli_fetch_array($card_cvv_query);
$card_expire_result = mysqli_fetch_array($card_expire_query);
$card_billaddr_result = mysqli_fetch_array($card_billaddr_query);

$username = $username_result['Username'];
$first_name = $first_name_result['FirstName'];
$middle_init = $middle_init_result['MiddleInit'];
$last_name = $last_name_result['LastName'];
$email = $email_result['EmailAddress'];
$phoneno = $phoneno_result['PhoneNo'];
$address = $address_result['Address'];
$driving_plan = $driving_plan_result['DrivingPlan'];
$card_no = $card_no_result['CardNo'];
$card_name = $card_name_result['Name'];
$card_cvv = $card_cvv_result['CVV'];
$card_expire = $card_expire_result['ExpiryDate'];
$card_billaddr = $card_billaddr_result['BillingAdd'];

$occasional = "";
$frequent = "";
$daily = "";

switch($driving_plan) 
{
	case "Occasional": 
		$occasional = "checked";
		break;
	case "Frequent": 
		$frequent = "checked";
		break;
	case "Daily": 
		$daily = "checked";
		break;
}

echo '
General Information 
<br>
<br>

<form action="MemberPersonalInformationHandler.php" method="post">
First Name:     		<input type="text" name="first_name" value=';echo $first_name; echo'><br>
Middle Initial:         <input type="text" name="middle_initial" value=';echo $middle_init; echo'><br>
Last Name:     			<input type="text" name="last_name" value=';echo $last_name; echo'><br>
Email Address: 			<input type="text" name="email_address" value=';echo $email; echo'><br>
Phone Number: 			<input type="text" name="phone_number" value=';echo $phoneno; echo'><br>
Address: 				<input type="text" name="address" value=';echo $address; echo'><br>

<br>
<br>
Membership Information 
<br>
<br>
<br>
Choose a plan<br>

<input type="radio" name="DrivingPlan" value="Occasional"';echo $occasional; echo'>Occasional Driving<br>
<input type="radio" name="DrivingPlan" value="Frequent"';echo $frequent; echo'>Frequent Driving<br>
<input type="radio" name="DrivingPlan" value="Daily"';echo $daily; echo'>Daily Driving
<br>
<a href="DrivingPlanDetails.php">View plan details</a>


<br>
<br>
Payment Information 
<br>
<br>
<br>

Name on Card:  		   	<input type="text" name="name_on_card" value=';echo $card_name; echo'><br>
Card Number:     		<input type="text" name="card_number" value=';echo $card_no; echo'><br>
CVV: 					<input type="text" name="cvv" value=';echo $card_cvv; echo'><br>
Expiry Date: 			<input type="text" name="expiry_date" value=';echo $card_expire; echo'><br>
Billing Address: 		<input type="text" name="billing_address" value=';echo $card_billaddr; echo'><br>
						<input type="Submit">
</form>
';

mysqli_close($connection);
?>
<a href="../MemberHomePage.html">Cancel</a>
</body>
</html>
