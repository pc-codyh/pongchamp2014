<?php

session_start();

require '../database-connect.php';

$season = $_GET['season'];
$table	= $_GET['table'];

if ($season == 'overall')
{
	$query = 'SELECT * FROM `players` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `name` ASC';
}
else
{
	$query = 'SELECT * FROM `'.$season.'` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `name` ASC';
}

$runQuery = mysql_query($query);

?>

<table id="player-stats">
	<thead>
		<tr>
			<?php
				if ($table == 'rank')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="Rank">RANK</th>
					<th title="ELO Rating">ELO</th>
					<th title="Compound Rating">CR</th>
					<?php
				}
				else if ($table == 'record')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="Games Played">GP</th>
					<th title="Wins">W</th>
					<th title="Losses">L</th>
					<th title="Overtime Losses">OTL</th>
					<th title="Overtime Games Played">OTGP</th>
					<th title="Cup Differential">DIF</th>
					<th title="Winning Percentage">WP</th>
					<?php
				}
				else if ($table == 'shooting')
				{
					?>
					<th>ROW</th>
					<th title="Rank">NAME</th>
					<th title="Shooting Percentage">SP</th>
					<th title="Shots">S</th>
					<th title="Hits">H</th>
					<th title="Bounces">B</th>
					<th title="Gang Bangs">GB</th>
					<th title="Errors">E</th>
					<th title="Heating Up">HU</th>
					<th title="On Fire">OF</th>
					<th title="Last Cups Hits">LCH</th>
					<?php
				}
				else if ($table == 'streaks')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="Winning Streak">WS</th>
					<th title="Losing Streak">LS</th>
					<th title="Hit Streak">HS</th>
					<th title="Miss Streak">MS</th>
					<?php
				}
				else if ($table == 'redemption')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="Redemption Shooting Percentage">RSP</th>
					<th title="Redemption Shots">RS</th>
					<th title="Redemption Hits">RH</th>
					<th title="Redemption Attempts">RAT</th>
					<th title="Redemption Successes">RSU</th>
					<?php
				}
				else if ($table == 'racks')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="10 Cups">10</th>
					<th title="9 Cups">9</th>
					<th title="8 Cups">8</th>
					<th title="7 Cups">7</th>
					<th title="6 Cups">6</th>
					<th title="5 Cups">5</th>
					<th title="4 Cups">4</th>
					<th title="3 Cups">3</th>
					<th title="2 Cups">2</th>
					<th title="Last Cup">1</th>
					<?php
				}
				else if ($table == 'overtime')
				{
					?>
					<th>ROW</th>
					<th title="Name">NAME</th>
					<th title="Overtime Games Played">OTGP</th>
					<th title="Overtime Wins">W</th>
					<th title="Overtime Losses">L</th>
					<th title="Overtime Winning Percentage">OTWP</th>
					<?php
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 0; $i < mysql_num_rows($runQuery); $i++) { ?>
		<tr>
			<?php
				if ($table == 'rank')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'rank')); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'elo_rating'), 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'compound_rating'), 2)); ?></td>
					<?php
				}
				else if ($table == 'record')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'games_played')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'wins')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'losses')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'ot_losses')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'ot_games_played')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'cup_dif')); ?></td>
					<td><?php if (mysql_result($runQuery, $i, 'games_played') > 0) { echo(number_format(mysql_result($runQuery, $i, 'wins') / mysql_result($runQuery, $i, 'games_played') * 100, 2)); } else { echo(number_format(0, 2)); } ?></td>
					<?php
				}
				else if ($table == 'shooting')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'shooting_percentage') * 100, 2)); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'shots')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'hits')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'bounces')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'gang_bangs')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'errors')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'heating_up')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'on_fire')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'h1')); ?></td>
					<?php
				}
				else if ($table == 'streaks')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'win_streak')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'loss_streak')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'hit_streak')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'miss_streak')); ?></td>
					<?php
				}
				else if ($table == 'redemption')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'redemp_shotperc') * 100, 2)); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'redemp_shots')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'redemp_hits')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'redemp_atmps')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'redemp_succs')); ?></td>
					<?php
				}
				else if ($table == 'racks')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p10') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p9') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p8') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p7') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p6') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p5') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p4') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p3') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p2') * 100, 2)); ?></td>
					<td><?php echo(number_format(mysql_result($runQuery, $i, 'p1') * 100, 2)); ?></td>
					<?php
				}
				else if ($table == 'overtime')
				{
					?>
					<td><?php echo($i + 1); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'name')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'ot_games_played')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'ot_games_played') - mysql_result($runQuery, $i, 'ot_losses')); ?></td>
					<td><?php echo(mysql_result($runQuery, $i, 'ot_losses')); ?></td>
					<td><?php if (mysql_result($runQuery, $i, 'ot_games_played') > 0) { echo(number_format((mysql_result($runQuery, $i, 'ot_games_played') - mysql_result($runQuery, $i, 'ot_losses')) / mysql_result($runQuery, $i, 'ot_games_played') * 100, 2)); } else { echo(number_format(0, 2)); } ?></td>
					<?php
				}
			?>
		</tr>
		<?php }; ?>
	</tbody>
</table>