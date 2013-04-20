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
$result0 = mysqli_query($connection,"SELECT FirstName FROM member WHERE Username='$Username'");
$row = mysqli_fetch_array($result0);

if (isset($row['FirstName'])) 
{
  echo $row['FirstName'];
}

mysqli_close($connection);
?>
</body>
</html>
