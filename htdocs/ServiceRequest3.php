<html>
<head>
<title>Service Request Pg 3/3</title>
</head>
<body>
Service Requests Pg 3/3
<br>
<br>

Service Request3.php Page
<br>
<form action="" method="post">

<?php
session_start();

$connection=mysqli_connect("localhost","root","","car rental");

//Need to figure out how to get a variable to stay with you for multiple pages

//remember to redirect the user back to home or wherever they are supposed to go to.
//printing out the session variables
echo "<pre>";
echo var_dump($_SESSION["location_selection"]);
echo "</pre>"; 

if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$carmodel_query = mysqli_query($connection,"SELECT VehicleSno FROM car"); //where carLocation = location

//insert things into the database 






mysqli_close($connection);
?>
</form>
</body>
</html>
