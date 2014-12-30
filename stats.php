<?php 
	session_start();

	require 'database-connect.php';

	$MONTH_NAMES = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

	$username = $_POST['username'];
	$userID;

	$queries 	  = [];
	$queryResults = [];

	$query = 'SELECT `id` FROM `registrations` WHERE `username`="'.$username.'"';

	if ($runQuery = mysql_query($query))
	{
		$userID = mysql_result($runQuery, 0, 'id');
		$_SESSION['userID'] = $userID;

		// Date registered.
		$queries[0] = 'SELECT `date` FROM `registrations` WHERE `id`="'.$userID.'"';
		// League games played.
		$queries[1] = 'SELECT COUNT(*) FROM `games` WHERE `id_registrations`="'.$userID.'"';
		// League players count.
		$queries[2] = 'SELECT COUNT(*) FROM `players` WHERE `id_registrations`="'.$userID.'"';
		// Beers drank. 5 hits = 1 beer.
		$queries[3] = 'SELECT SUM(`hits`) FROM `players` WHERE `id_registrations`="'.$userID.'"';
		// Icon URL.
		$queries[4] = 'SELECT `icon-url` FROM `registrations` WHERE `id`="'.$userID.'"';

		for ($i = 0; $i < count($queries); $i++)
		{
			$queryResults[$i] = mysql_query($queries[$i]);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pong Champ</title>
	<link rel="stylesheet" href="css/pc.css" />
	<link rel='stylesheet' href='css/slimtable.css' />
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type='text/javascript' src='js/slimtable.js'></script>
	<script type="text/javascript" src="js/stats.js"></script>
	<script type="text/javascript" src="js/jquery.knob.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
</head>
<body>
	<div id="nav-bar">
		<img id="nav-logo" src="img/pongchamp.png" alt="PC" />
		<h2>Pong Champ</h2>
		<ul class="categories">
			<li>Player Stats</li>
			<li>Player Profiles</li>
			<li>Team Stats</li>
			<li>Game Results</li>
			<li>Achievements</li>
		</ul>
		<div class="account">
			<div class="username"><?php echo($username); ?></div>
			<div class="options"><a id="my-account" href="#">My account</a> | <a id="my-logout" href="#">Logout</a></div>
		</div>
		<div class="icon"><img src=<?php echo(mysql_result($queryResults[4], 0)); ?> /></div>
		<div class="account-info">
			<ul class="items">
				<li><div class="item"><h3><?php echo(date('M d, Y', strtotime(mysql_result($queryResults[0], 0)))); ?></h3><h6>Member since</h6></div></li>
				<li><div class="item"><h3><?php echo(mysql_result($queryResults[1], 0)); ?></h3><h6>Games played</h6></div></li>
				<li><div class="item"><h3><?php echo(mysql_result($queryResults[2], 0)); ?></h3><h6>Players</h6></div></li>
				<li><div class="item"><h3><?php echo(intval(mysql_result($queryResults[3], 0) / 5)); ?></h3><h6>Beers drank</h6></div></li>
			</ul>
			<div class="footer">
				<div class="subfooter"><p>Upload icon</p></div>
			</div>
		</div>
	</div>
	<div id="upload-icon">
		<div class="content">
			<div class="close-button"></div>
			<h2>Upload icon</h2>
			<input id="upload-icon-url" class="modal-input" type="text" placeholder="URL" />
			<input id="upload-icon-submit" class="modal-submit" type="button" value="Upload »" />
		</div>
	</div>
	<div id="stats"></div>
	<div id="left-menu" class="side-menu"></div>
	<div id="right-menu" class="side-menu"></div>
</body>
</html>