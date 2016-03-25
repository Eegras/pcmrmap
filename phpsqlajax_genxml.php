<?php
require('phpsqlajax_dbinfo.php');

$db = new PDO("mysql:host=$server;dbname=$database", $username, $password);

// Selects all the rows in the markers table.
$query = 'SELECT * FROM markers ORDER BY lat ASC;';
$result = $db->query($query);
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
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
  $kml[] = ' <Placemark id="placemark' . $row['id'] . '">';
  $kml[] = ' <name>' . $i . '</name>';
  $kml[] = ' <Point>';
  $kml[] = ' <coordinates>' . round(floatval($row['lng']),1) . ','  . round(floatval($row['lat']),1) . '</coordinates>';
  $kml[] = ' </Point>';
  $kml[] = ' </Placemark>';
  $i++;
} 

$result->closeCursor();
$db = null;

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
header('Content-type: application/vnd.google-earth.kml+xml');
echo $kmlOutput;
?>