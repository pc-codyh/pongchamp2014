<?php 
	$dbHost = 'localhost';
	$dbName = 'pc-dev';
	$dbUser = 'root';
	$dbPass = '';

	if (mysql_connect($dbHost, $dbUser, $dbPass))
	{
		if (mysql_select_db($dbName))
		{
			$_SESSION['database_connected'] = true;
		}
		else
		{
			$_SESSION['database_connected'] = false;
			
			die('Failed to connect to the database.');
		}
	}
	else
	{
		$_SESSION['database_connected'] = false;

		die('Failed to connect to the server.');
	}
?>