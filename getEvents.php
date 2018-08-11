<?php

// Create connection
$con=mysqli_connect("localhost","root","","myutar");
mysqli_set_charset( $con, 'utf8');

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// This SQL statement selects ALL from the table 'Locations'
$sql = "SELECT * FROM event";


// Check if there are results
if ($result = mysqli_query($con, $sql))
{
	// If so, then create a results array and a temporary one
	// to hold the data
	$resultArray = array();
	$resultArray["event"] = array();
	$tempArray = array();

	// Loop through each row in the result set
	while($row = $result->fetch_object())
	{
		// Add each row into our results array
		$tempArray = $row;
	    array_push($resultArray["event"], $tempArray);
	}


	// Finally, encode the array to JSON and output the results
  //Decode the JSON and convert it into an associative array.
  $jsonDecoded = implode(",",$resultArray);

  //Give our CSV file a name.
  $csvFileName = 'backup.csv';
  //Set the Content-Type and Content-Disposition headers.
  header('Content-Type: application/excel');
  header('Content-Disposition: attachment; filename="' . $csvFileName . '"');

  //Open file pointer.
  //Open up a PHP output stream using the function fopen.
  $fp = fopen('php://output', 'w');

  //Loop through the associative array.
  foreach($jsonDecoded as $row){
      //Write the row to the CSV file.
      fputcsv($fp, $row);
  }

  //Finally, close the file pointer.
  fclose($fp);
}

// Close connections
mysqli_close($con);
?>
