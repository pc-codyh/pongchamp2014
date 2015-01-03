<?php

session_start();

require '../database-connect.php';

$ach = $_GET['ach'];

if ($ach == 'rank')
{
	$ach = 'a_shs';
}

$query = 'SELECT `name`, `'.$ach.'` FROM `players` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND `'.$ach.'` > 0 ORDER BY `'.$ach.'` DESC';

$runQuery = mysql_query($query);

$img;
$title;
$subtitle;

switch ($ach)
{
	case 'a_shs':
	{
		$img = 'sharpshooter';
		$title = 'Sharpshooter';
		$subtitle = 'Hit five or more cups in a row';
	}
		break;

	case 'a_mj':
	{
		$img = 'michael-jordan';
		$title = 'Michael Jordan';
		$subtitle = 'Go "On Fire" two or more times in a game';
	}
		break;

	case 'a_cibav':
	{
		$img = 'the-kid-can-play';
		$title = 'The Kid Can Play';
		$subtitle = 'Win a game, sinking all the cups for your team';
	}
		break;

	case 'a_hc':
	{
		$img = 'heartbreak-city';
		$title = 'Heartbreak City';
		$subtitle = 'Win a game after trailing by five or more cups';
	}
		break;

	case 'a_cwtpd':
	{
		$img = 'sneaky-snake';
		$title = 'Sneaky Snake';
		$subtitle = 'Hit two or more bounce shots in a game';
	}
		break;

	case 'a_ps':
	{
		$img = 'porn-star';
		$title = 'Porn Star';
		$subtitle = 'Hit two or more gang-bangs in a game';
	}
		break;

	case 'a_per':
	{
		$img = 'perfection';
		$title = 'Perfection';
		$subtitle = 'Shoot one-hundred percent in a game';
	}
		break;

	case 'a_dbno':
	{
		$img = 'down-but-not-out';
		$title = 'Down But Not Out';
		$subtitle = 'Complete two or more redemptions in a game';
	}
		break;

	case 'a_mar':
	{
		$img = 'marathon';
		$title = 'Marathon';
		$subtitle = 'Compete in a game that goes to triple overtime';
	}
		break;

	case 'a_fdm':
	{
		$img = 'first-degree-murder';
		$title = 'First Degree Murder';
		$subtitle = 'Win a game before the other team gets a re-rack';
	}
		break;

	case 'a_ck':
	{
		$img = 'comeback-kill';
		$title = 'Comeback Kill';
		$subtitle = 'Sink a cup after missing five or more shots in a row';
	}
		break;

	case 'a_bb':
	{
		$img = 'bill-buckner';
		$title = 'Bill Buckner';
		$subtitle = 'Commit two or more errors in a game';
	}
		break;

	case 'a_bc':
	{
		$img = 'bitch-cup';
		$title = 'Bitch Cup';
		$subtitle = 'Hit the middle cup first on a ten-cup rack';
	}
		break;

	case 'a_bank':
	{
		$img = 'bankruptcy';
		$title = 'Bankruptcy';
		$subtitle = 'Sink no cups in a game';
	}
		break;

	case 'a_skunk':
	{
		$img = 'skunked';
		$title = 'Skunked';
		$subtitle = 'Lose a game before getting a re-rack';
	}
		break;

	case 'a_sw':
	{
		$img = 'stevie-wonder';
		$title = 'Stevie Wonder';
		$subtitle = 'Miss ten shots in a row in a game';
	}
		break;

	case 'ua_alc':
	{
		$img = 'binge-drinker';
		$title = 'Binge Drinker';
		$subtitle = 'Play in consecutive overtime games';
	}
		break;

	case 'ua_oah':
	{
		$img = 'superstar';
		$title = 'Superstar';
		$subtitle = 'Win five games in a row';
	}
		break;

	case 'ua_ce':
	{
		$img = 'serial-killer';
		$title = 'Serial Killer';
		$subtitle = 'Hit ten cups in a game';
	}
		break;

	case 'ua_slip':
	{
		$img = 'magician';
		$title = 'Magician';
		$subtitle = 'Hit consecutive bounce shots without missing';
	}
		break;

	case 'ua_dciac':
	{
		$img = 'immortal';
		$title = 'Immortal';
		$subtitle = 'Successfully complete a redemption and go on to win the game in the first overtime';
	}
		break;

	case 'ua_dth':
	{
		$img = 'marksman';
		$title = 'Marksman';
		$subtitle = 'Hit three last cups in a game';
	}
		break;

	case 'ua_show':
	{
		$img = 'seen-it-all';
		$title = 'Seen It All';
		$subtitle = 'Earn three achievements in a game';
	}
		break;
}

?>

<h2 id="achievements-title" class="section-header"><img src="img/achievements/<?php echo $img; ?>.png" style="width: 20px; height: 20px; margin: 0 5px 0 0;" /><?php echo $title; ?></h2>
<h6 class="section-subheader"><?php echo $subtitle; ?></h6>

<?php

$count = 0;
$max = 0;

while ($row = mysql_fetch_assoc($runQuery))
{
	// echo $row['name'].': '.$row[$ach].' | ';
	if ($count == 0)
	{
		$max = $row[$ach];
	}

	?>

	<div class="ach-row-container">
		<div class="bar">
			<div class="fill" style="width: <?php echo(100 * ($row[$ach]) / $max); ?>%">
				<div class="row"><?php echo ($count + 1); ?></div>
				<div class="val"><?php echo $row[$ach]; ?></div>
			</div>
			<div class="name"><?php echo $row['name']; ?></div>
		</div>
	</div>

	<?php

	$count++;
}

if ($count == 0)
{
	?>

	<h4 class="nobody">No players have earned this achievement</h4>
	
	<?php
}

?>



<!-- <table id="sharpshooter">
	<thead>
		<tr>
			<th>ROW</th>
			<th title="Team">TEAM</th>
			<th title="Games Played">GP</th>
			<th title="Wins">W</th>
			<th title="Losses">L</th>
			<th title="Overtime Losses">OTL</th>
			<th title="Overtime Games Played">OTGP</th>
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
</table> -->