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
$result0 = mysqli_query($connection,"SELECT username,password FROM user WHERE username='$username' AND password='$password'");
$row = mysqli_fetch_array($result0);

if (isset($row['username'], $row['password'])) 
{
  $_SESSION['username'] = $row['username'];
  header('Location: ../MemberHomePage.html');
}
  
mysqli_close($connection);
?>
</body>
</html>
