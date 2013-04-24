<!doctype html>

<html lang = "en">
<head>
<title>Rental Request Change</title>

  <meta charset="utf-8" />
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });

  });
  </script>

</head>
<body>
<form action="RentalRequestChange.php">

Username: <input type="text" name="username"><br>
<br>
<br>
Car Model: <input type="text" name="car_model"><br>
<br>
<br>
<?php
$connection=mysqli_connect("localhost","root","","car rental");

$location_query = mysqli_query($connection,"SELECT LocationName FROM location");

echo "<select name ='location_select'>";
while($location_result = mysqli_fetch_array($location_query)) {
    echo "<option value=".$location_result['LocationName'].">".$location_result['LocationName']."</option>";
}
echo "</select>";
echo "<br>";
echo "<br>";

mysql_close($connection);

?>
<p>Original Return Date: <input type="text" id="datepicker" name="original_return_date"/></p>
<br>
Original Return Time: <input type="text" name="original_return_time"><br>
<br>
<br>

<p>New Return Date: <input type="text" id="datepicker2" name="new_return_date"/></p>
<br>

New Return Time: <input type="text" name="new_return_time"><br>
<br>
<br>
  
<input type="Submit" name="submit" value="Update" />

</form>

</body>
</html>
