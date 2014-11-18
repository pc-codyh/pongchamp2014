<?php 
	require 'database-connect.php';

	$query = 'SELECT * FROM `registrations` WHERE 1';

	$queryResult = mysql_query($query);

	$response = [];

	for ($i = 0; $i < mysql_num_rows($queryResult); $i++)
	{
		$id		  = mysql_result($queryResult, $i, 'id');
		$username = mysql_result($queryResult, $i, 'username');
		$password = mysql_result($queryResult, $i, 'password');
		$icon_url = mysql_result($queryResult, $i, 'icon-url');

		$subRes = [$id, $username, $password, $icon_url];

		$response[$i] = $subRes;
	}

	echo(json_encode($response));
?>