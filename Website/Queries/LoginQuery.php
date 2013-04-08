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
$result0 = mysqli_query($connection,"SELECT username,password FROM gt_student_faculty_member WHERE username='$username' AND password='$password'");
$result1 = mysqli_query($connection,"SELECT username,password FROM gtcr_employee WHERE username='$username' AND password='$password'");
$result2 = mysqli_query($connection,"SELECT username,password FROM administrator WHERE username='$username' AND password='$password'");

while($row = mysqli_fetch_array($result0))
  {
  echo $row['username'] . " " . $row['password'];
  echo "<br />";
  }
 
while($row = mysqli_fetch_array($result1))
  {
  echo $row['username'] . " " . $row['password'];
  echo "<br />";
  }
  
while($row = mysqli_fetch_array($result2))
  {
  echo $row['username'] . " " . $row['password'];
  echo "<br />";
  }
  
mysqli_close($connection);
?>
</body>
</html>
