<html>
<body>
<?php
$connection=mysqli_connect("localhost","root","password","car rental");

// Check connection
if (mysqli_connect_errno($connection))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$username = $_POST["username"];
$password = $_POST["password"];
$result0 = mysqli_query($connection,"SELECT username,password FROM user WHERE username='$username' AND password='$password'");

while($row = mysqli_fetch_array($result0))
  {
  echo $row['username'] . " " . $row['password'];
  echo "<br />";
  }
  
mysqli_close($connection);
?>
</body>
</html>
