<?php
require('phpsqlajax_dbinfo.php');

 // Opens a connection to a MySQL server.
$connection = mysql_connect ($server, $username, $password);
if (!$connection) 
{
  die('Not connected : ' . mysql_error());
}

// Sets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mysql_error());
}

 // Selects all the rows in the markers table.
 $query = 'SELECT * FROM markers WHERE 1';
 $result = mysql_query($query);
 if (!$result) 
 {
  die('Invalid query: ' . mysql_error());
 }

// Creates an array of strings to hold the lines of the KML file.
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
$kml[] = ' <Document>';

// Iterates through the rows, printing a node for each row.
$i = 0;
while ($row = @mysql_fetch_assoc($result)) 
{
  $kml[] = ' <Placemark id="placemark' . $row['id'] . '">';
  $kml[] = ' <name>' . $i . '</name>';
  $kml[] = ' <Point>';
  $kml[] = ' <coordinates>' . round($row['lng'],4) . ','  . round($row['lat'],4) . '</coordinates>';
  $kml[] = ' </Point>';
  $kml[] = ' </Placemark>';
  $i++;
 
} 

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
header('Content-type: application/vnd.google-earth.kml+xml');
echo $kmlOutput;
?>