<html>
<head>
<title>Change Car Location</title>
<script>
function update(location,v)
{

<?php
?>
}
</script>
<script>
function showCar(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","selectcarfromlocation.php?q="+str,true);
xmlhttp.send();
}
</script>
<script>
function showcarinfo(str)
{

if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","carinfo.php?v="+str,true);
xmlhttp.send();
}
</script>
<script>
function update(loc,veh)
{

if (loc=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","newlocation.php?l="+loc+"&c="+veh,true);
xmlhttp.send();
}
</script>
</head>
<body>
<form>
Choose Current Location: 
<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

if (mysqli_connect_errno($connection)) //make sure connection exists
{
  echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$location="SELECT LocationName FROM location";
$result2 = mysqli_query($connection, $location);
echo "<select name='location select' onchange='showCar(this.value)'>";
echo "<option value='1'>n/a</option>";
while($array = mysqli_fetch_array($result2,MYSQL_BOTH))
{
echo "<option value='".$array[0]."'>".$array[0]."</option>";
}
echo "</select>";
?>
</form>
<br>
<div id="txtHint"><b>Next Page Will Show Cars</b></div>

</body>
</html> 
