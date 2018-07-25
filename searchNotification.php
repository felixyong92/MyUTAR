<?php
 
// Create connection
$con=mysqli_connect("localhost","admin","1301466admin","myUtar");
mysqli_set_charset( $con, 'utf8');
 
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$keyword=$_GET["keyword"];
 
// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT * FROM notification WHERE `title` LIKE '%".$keyword."%' ORDER BY `publishDate` ASC";
 
// Check if there are results
if ($result = mysqli_query($con, $sql))
{
	// If so, then create a results array and a temporary one
	// to hold the data
	$resultArray = array();
	$resultArray["notification"] = array();
	$tempArray = array();
 
	// Loop through each row in the result set
	while($row = $result->fetch_object())
	{
		// Add each row into our results array
		$tempArray = $row;
	    array_push($resultArray["notification"], $tempArray);
	}
 
	// Finally, encode the array to JSON and output the results
	echo json_encode($resultArray);
}
 
// Close connections
mysqli_close($con);
?>