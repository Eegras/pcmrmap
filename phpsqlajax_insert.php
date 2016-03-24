<?php
session_start();
require("phpsqlajax_dbinfo.php");

// Opens a connection to a MySQL server
$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "DELETE FROM markers WHERE `name` = '".md5($_SERVER['REMOTE_ADDR'])."';";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
if (!isset($_POST['clr']))
{
	$query = "INSERT INTO markers (`name`, `lat`, `lng`) VALUES ('".md5($_SERVER['REMOTE_ADDR'])."','".mysql_real_escape_string(round(floatval($_POST['lat'],0)))."','".mysql_real_escape_string(round(floatval($_POST['lng'],0)))."');";
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
}
?>