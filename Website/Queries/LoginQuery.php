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
$user_query = mysqli_query($connection,"SELECT username,password FROM user WHERE username='$username' AND password='$password'");

if(!$user_query)
	echo "query error";

$user_result = mysqli_fetch_array($user_query);

if (isset($user_result['username'], $user_result['password'])) 
{
	$_SESSION['username'] = $user_result['username'];
	
	// Member
	$member_query = mysqli_query($connection,"SELECT username FROM member WHERE username='$username'");
	if(!$member_query)
		echo "query error";
	$member_result = mysqli_fetch_array($member_query);
	if(isset($member_result['username']))
		header('Location: ../MemberHomePage.html');
		
	$employee_query = mysqli_query($connection,"SELECT username FROM gtcremployee WHERE username='$username'");
	if(!$employee_query)
		echo "query error";
	$employee_result = mysqli_fetch_array($employee_query);
	if(isset($employee_result['username']))
		header('Location: ../EmployeeHomePage.html');
		
	$admin_query = mysqli_query($connection,"SELECT username FROM administrator WHERE username='$username'");
	if(!$admin_query)
		echo "query error";
	$admin_result = mysqli_fetch_array($admin_query);
	if(isset($admin_result['username']))
		header('Location: ../AdminHomePage.html');
}
else
  header('Location: ../LoginPage.html');
	
mysqli_close($connection);
?>
</body>
</html>
