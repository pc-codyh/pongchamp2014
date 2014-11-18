<?php 
	require 'database-connect.php';

	$id = $_GET['id'];

	// Account creation date QUERY
	$query 			= 'SELECT `date` FROM `registrations` WHERE `id`="'.$id.'"';
	$queryResult 	= mysql_query($query);
	$creationDate 	= mysql_result($queryResult, 0);

	// Number of games played QUERY
	$query 			= 'SELECT COUNT(*) FROM `games` WHERE `id_registrations`="'.$id.'"';
	$queryResult 	= mysql_query($query);
	$gamesPlayed 	= mysql_result($queryResult, 0);

	// Number of players QUERY
	$query 			= 'SELECT COUNT(*) FROM `players` WHERE `id_registrations`="'.$id.'"';
	$queryResult 	= mysql_query($query);
	$numPlayers 	= mysql_result($queryResult, 0);

	echo '{"creationDate": "'.$creationDate.'", "gamesPlayed": "'.$gamesPlayed.'", "numPlayers": "'.$numPlayers.'"}';
?>