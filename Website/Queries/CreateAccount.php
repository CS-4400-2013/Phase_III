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

$username = $_POST["username"];
$password = $_POST["password"];
$password_confirm = $_POST["password_confirm"];
$user_type = $_POST["User_Type"];

// Check if username already taken
$db_query = mysqli_query($connection,"SELECT username FROM user WHERE username='$username'");
if(!$db_query)
	echo "query error";
$db_username = mysqli_fetch_array($db_query);

if ($username != NULL && $password != NULL && $password_confirm != NULL 
	&& $db_username['username'] == NULL && $password == $password_confirm) 
{
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	switch ($user_type)
	{
		case "Member":
			header('Location: ../MemberHomePage.html');
			break;
		case "Employee":
			mysqli_query($connection,"INSERT INTO user (Username, Password) VALUES ('$username', '$password')");
			mysqli_query($connection,"INSERT INTO `GTCREmployee`(`username`) VALUES ('$username')");
			header('Location: ../EmployeeHomePage.html');
			break;
	}	
}
else
{
	header('Location: ../CreateAccountPage.html');
}
  
mysqli_close($connection);
?>
</body>
</html>