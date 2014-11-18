<?php 
	require 'database-connect.php';

	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = 'INSERT INTO `registrations`(`username`, `password`) VALUES("'.$username.'", "'.$password.'")';

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