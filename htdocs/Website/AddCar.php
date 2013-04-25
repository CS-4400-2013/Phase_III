<html>
<head>
<title>Manage Cars</title>
</head>
<body>

Manage cars
<br>
<br>

<form action="Queries/AddCar_Action.php" method="post">
Vehicle Sno:     		<input type="text" name="vehicle_sno"><br>
Car Model:			<input type="text" name="car_model"><br>
Car Type: 
<br>
<select name = "car_type">
  <option value="">Select...</option>
  <option value="suv">SUV</option>
  <option value="truck">Truck</option>
  <option value="hatchback">Hatchback</option>
  <option value="compact">Compact</option>
  </select>
<br>

Location:
<?php include 'locationbox.php'; ?>

Color: 				             <input type="text" name="color"><br>

Hourly Rate: 			             <input type="text" name="hourly_rate"><br>
Daily Rate: 			             <input type="text" name="daily_rate"><br>

Seating Capacity: 		             <input type="text" name="seating_capacity"><br>

Transmission Type: 
<br>
<select name = "transmission_type">
  <option value="">Select...</option>
  <option value="automatic">Automatic</option>
  <option value="manual">Manual</option>
  </select>
<br>

Bluetooth Connectivity: <input type="checkbox" name="bluetooth_connectivity" value="bluetooth_connectivity"  /><br />
<br>
Auxilliary Cable: <input type="checkbox" name="auxillary_cable" value="auxillary_cable"  /><br /> 
<br>

Under Maintenance Flag: <input type="checkbox" name="maintenance_flag" value="under_maintenance_flag"  /><br /> 
<br>

<input type="submit" value="Add Car" />

</form>

</body>
</html>
