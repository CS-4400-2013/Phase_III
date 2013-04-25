<html>
<head>
<body>
<script type="text/javascript" language="Javascript" 
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js">

    $(document).ready(function() {
        $('#form form').submit(function(){
            $.get('servicerequesinsertaction.php', $(this).serialize(), function(data){
                $('#content').html(data);
            });
            return false;
        });
    });
</script>
<script>
function showUser(str)
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
xmlhttp.open("GET","servicerequestaction.php?q="+str,true);
xmlhttp.send();
}

function insertRequest(str)
{

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
xmlhttp.open("POST","servicerequesinsertaction.php?q="+str,true);
xmlhttp.send();
}

function test()
{
  document.getElementById("txtHint").innerHTML="Test Function clicked";
  return;
}


</script>
</head>
<div id="form">

<form action="servicerequestinsertaction.php" method="post">
<?php
session_start();
$connection=mysqli_connect("localhost","root","","car rental");

// Check connection
if (mysqli_connect_errno($connection))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$location_query = mysqli_query($connection,"SELECT LocationName FROM location");
//$carmodel_query = mysqli_query($connection,"SELECT CarModel FROM car");

echo "<br>";
echo "<br>";

echo "<select name ='location_select' onchange='showUser(this.value)'>";
while($location_result = mysqli_fetch_array($location_query)) {
		echo "<option value=".$location_result['LocationName'].">".$location_result['LocationName']."</option>";
}
echo "</select>";l
echo "<br>";
echo "<br>";

mysqli_close($connection);
?>

<br>
Name : <input type="text" name="urname"><br />
Birthplace : <input type="text" name="urbirth"><br />

<div id="txtHint"><b>Car dropdown will appear here</b></div>
<input type="submit" name="submit" value="Submit">
</form>
</div>
<div id="content">
</div>
</body>
</html>
