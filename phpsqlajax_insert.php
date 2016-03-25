<?php
session_start();
require("phpsqlajax_dbinfo.php");

$db = new PDO("mysql:host=$server;dbname=$database", $username, $password);
// Select all the rows in the markers table

$query = "DELETE FROM markers WHERE `name` = '".md5($_SERVER['REMOTE_ADDR'])."';";
$result = $db->query($query);
if (!$result) {
  die('Invalid query: ' . $db->errorInfo());
}
echo "Success";
if (!isset($_POST['clr']))
{
	$query = "INSERT INTO markers (`name`, `lat`, `lng`) VALUES (".$db->quote(md5($_SERVER['REMOTE_ADDR'])).",".round(floatval($_POST['lat']),0).",".round(floatval($_POST['lng']),0).");";
	$result = $db->query($query);
	if (!$result) {
	  echo 'Invalid query: ' . print_r($db->errorInfo());
	}
	else
		echo "Success!";
}
?>