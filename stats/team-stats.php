<?php

session_start();

require '../database-connect.php';

$query = 'SELECT * FROM `teams` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `games_played` DESC';

$runQuery = mysql_query($query);

?>

<table id="team-stats">
	<thead>
		<tr>
			<th>ROW</th>
			<th title="Team">TEAM</th>
			<th title="Games Played">GP</th>
			<th title="Wins">W</th>
			<th title="Losses">L</th>
			<th title="Overtime Losses">OTL</th>
			<th title="Overtime Games Played">L</th>
			<th title="Winning Percentage">WP</th>
			<th title="Winning Streak">WS</th>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 0; $i < mysql_num_rows($runQuery); $i++) { ?>
		<tr>
			<td><?php echo($i + 1); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'team_name')); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'games_played')); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'wins')); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'losses')); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'ot_losses')); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'ot_games_played')); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, $i, 'win_perc') * 100, 2)); ?></td>
			<td><?php echo(mysql_result($runQuery, $i, 'win_streak')); ?></td>
		</tr>
		<?php }; ?>
	</tbody>
</table>