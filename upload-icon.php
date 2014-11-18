<?php 
	require 'database-connect.php';

	$username = $_POST['username'];
	$iconURL  = $_POST['icon_url'];

	$query = 'UPDATE `registrations` SET `icon-url`="'.$iconURL.'" WHERE `username`="'.$username.'"';

	$queryResult = mysql_query($query);

	if ($queryResult)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>