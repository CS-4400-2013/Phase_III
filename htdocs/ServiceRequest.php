<html>
<head>
<title>Service Request</title>
</head>
<body>


Service Requests
<br>
<br>


Choose Location: 
<br>



<select name="locationcombobox">
<?php
$connection=mysqli_connect("localhost","root","","car rental");
$location_query = mysqli_query($connection,"SELECT LocationName from location");
$carmodel_query = mysqli_query($connection,"SELECT CarModel from car");

  <option value="location1">Location1</option>
  <option value="location2">Location2</option>
  <option value="location3">Location3</option>
  <option value="location4">Location4</option>
<br>
<br>

Choose Car: 
<br>
<select>
  <option value="model1">Model 1</option>
  <option value="model2">Model 2</option>
  <option value="model3">Model 3</option>
  </select>
<br>
<br>

?>
</select>



Brief Description of the problem:
<br>
<br>
<textarea rows="10" cols="30">
Describe Problem here.
</textarea>

<input type="Submit">



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript" ></script>

<select class="small-input" id="NameCombobox1" name="NameCombobox1">                            
    <option value="0">Select one</option>
    <option value="1">Fruits</option>
    <option value="2">vegetables</option>
</select>

<div id="result"></div>

<script type="text/javascript">

 $('#NameCombobox1').change(function() 
    {                                   
    var NameCombobox1 =  $(this).attr('value'); 

    if( NameCombobox1> 0) {
    $.post(
    "PageWithSelect.php", 
    { BRFLink:  NameCombobox1 },
    function(data) {                                                        
        $("#result").append(data);          
    }, 
     "html"
    );
    }
    $('#result').show();
  });

</script>




</body>
</html>
