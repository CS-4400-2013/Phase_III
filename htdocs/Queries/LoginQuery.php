<html>
<body>
<?php

$connection=mysqli_connect("localhost","root","","car rental");
// Check connection
if (mysqli_connect_errno($connection))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$username = $_POST["username"];
$password = $_POST["password"];
$result0 = mysqli_query($connection,"SELECT username,password FROM user WHERE username='$username' AND password='$password'");
$count=mysqli_num_rows($result0);

if($count == 1)
{

   echo "Login Successful";

   
while($row = mysqli_fetch_array($result0))
  {
  echo $row['username'] . " " . $row['password'];
  echo "<br />";
  }
  
}
else
{
	echo "Login unsuccessful";
}


mysqli_close($connection);
?>
</body>
</html>
