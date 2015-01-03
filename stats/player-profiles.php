<?php

session_start();

require '../database-connect.php';

$season = $_GET['season'];
$player	= $_GET['player'];

// Names are not preset so choose the
// first in alphabetical order.
$playerQuery = 'SELECT `name` FROM `players` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `name` ASC';
$runPlayerQuery = mysql_query($playerQuery);

$seasonQuery = 'SELECT * FROM `seasons` ORDER BY `id` DESC';
$runSeasonQuery = mysql_query($seasonQuery);

if ($player == 'rank')
{
	$player = mysql_result($runPlayerQuery, 0);
}

if ($season == 'overall')
{
	$query = 'SELECT * FROM `players` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND `name`="'.$player.'"';
	$gamesQuery = 'SELECT * FROM `games` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND (`team_one_player_one`="'.$player.'" OR `team_one_player_two`="'.$player.'" OR `team_two_player_one`="'.$player.'" OR `team_two_player_two`="'.$player.'") ORDER BY `id` DESC';
}
else
{
	$query = 'SELECT * FROM `'.$season.'` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND `name`="'.$player.'"';
	$gamesQuery = 'SELECT * FROM `games` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND (`team_one_player_one`="'.$player.'" OR `team_one_player_two`="'.$player.'" OR `team_two_player_one`="'.$player.'" OR `team_two_player_two`="'.$player.'") AND `season`="'.$season.'" ORDER BY `id` DESC';
}

$runQuery = mysql_query($query);

$seasonStats = [];

for ($i = 0; $i < mysql_num_rows($runSeasonQuery); $i++)
{
	$seasonStats[$i][0] = mysql_query('SELECT * FROM `'.mysql_result($runSeasonQuery, $i, 'season').'` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND `name`="'.$player.'"');

	if (mysql_num_rows($seasonStats[$i][0]) > 0)
	{
		$seasonStats[$i][1] = true;

		$season = mysql_result($runSeasonQuery, $i, 'season');

		// Remove the first seven characters.
		$season = substr($season, 7);

		// Find and replace the underscores with spaces.
		$idx = strpos($season, '_');

		// Make the first letter uppercase.
		$season = str_replace('_', ' ', $season);
		$season = ucwords($season);

		$seasonStats[$i][2] = $season;
	}
	else
	{
		$seasonStats[$i][1] = false;
		$seasonStats[$i][2] = null;
	}
}

$runGamesQuery = mysql_query($gamesQuery);

if (mysql_num_rows($runQuery) > 0)
{

?>

<div id="rank-header-container">
	<img src="img/player-rank.png" />
	<div class="rank"><?php echo mysql_result($runQuery, 0, 'rank') ?></div>
	<div class="name"><?php echo mysql_result($runQuery, 0, 'name') ?></div>
</div>

<h2 id="player-profiles-stats-title" class="section-header"><img src="img/stats-header.png" style="width: 23px; height: 20px; margin: 0 5px 0 0;" />Stats</h2>

<table id="player-profiles-rank">
	<thead>
		<tr>
			<th title="Rank">RANK</th>
			<th title="ELO Rating">ELO</th>
			<th title="Compound Rating">CR</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(mysql_result($runQuery, 0, 'rank')); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'elo_rating'), 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'compound_rating'), 0)); ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-record">
	<thead>
		<tr>
			<th title="Games Played">GP</th>
			<th title="Wins">W</th>
			<th title="Losses">L</th>
			<th title="Overtime Losses">OTL</th>
			<th title="Overtime Games Played">OTGP</th>
			<th title="Cup Differential">DIF</th>
			<th title="Winning Percentage">WP</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(mysql_result($runQuery, 0, 'games_played')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'wins')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'losses')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'ot_losses')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'ot_games_played')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'cup_dif')); ?></td>
			<td><?php if (mysql_result($runQuery, 0, 'games_played') > 0) { echo(number_format(mysql_result($runQuery, 0, 'wins') / mysql_result($runQuery, 0, 'games_played') * 100, 0).'%'); } else { echo(number_format(0, 0).'%'); } ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-shooting">
	<thead>
		<tr>
			<th title="Shooting Percentage">SP</th>
			<th title="Shots">S</th>
			<th title="Hits">H</th>
			<th title="Bounces">B</th>
			<th title="Gang Bangs">GB</th>
			<th title="Errors">E</th>
			<th title="Heating Up">HU</th>
			<th title="On Fire">OF</th>
			<th title="Last Cups Hits">LCH</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'shooting_percentage') * 100, 0).'%'); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'shots')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'hits')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'bounces')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'gang_bangs')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'errors')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'heating_up')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'on_fire')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'h1')); ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-streaks">
	<thead>
		<tr>
			<th title="Winning Streak">WS</th>
			<th title="Losing Streak">LS</th>
			<th title="Hit Streak">HS</th>
			<th title="Miss Streak">MS</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(mysql_result($runQuery, 0, 'win_streak')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'loss_streak')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'hit_streak')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'miss_streak')); ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-redemption">
	<thead>
		<tr>
			<th title="Redemption Shooting Percentage">RSP</th>
			<th title="Redemption Shots">RS</th>
			<th title="Redemption Hits">RH</th>
			<th title="Redemption Attempts">RAT</th>
			<th title="Redemption Successes">RSU</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'redemp_shotperc') * 100, 0).'%'); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'redemp_shots')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'redemp_hits')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'redemp_atmps')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'redemp_succs')); ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-racks">
	<thead>
		<tr>
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
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p10') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p9') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p8') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p7') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p6') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p5') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p4') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p3') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p2') * 100, 0)); ?></td>
			<td><?php echo(number_format(mysql_result($runQuery, 0, 'p1') * 100, 0)); ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-overtime">
	<thead>
		<tr>
			<th title="Overtime Games Played">OTGP</th>
			<th title="Overtime Wins">W</th>
			<th title="Overtime Losses">L</th>
			<th title="Overtime Winning Percentage">OTWP</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo(mysql_result($runQuery, 0, 'ot_games_played')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'ot_games_played') - mysql_result($runQuery, 0, 'ot_losses')); ?></td>
			<td><?php echo(mysql_result($runQuery, 0, 'ot_losses')); ?></td>
			<td><?php if (mysql_result($runQuery, 0, 'ot_games_played') > 0) { echo(number_format((mysql_result($runQuery, 0, 'ot_games_played') - mysql_result($runQuery, 0, 'ot_losses')) / mysql_result($runQuery, 0, 'ot_games_played') * 100, 0).'%'); } else { echo(number_format(0, 0).'%'); } ?></td>
		</tr>
	</tbody>
</table>

<table id="player-profiles-seasons">
	<thead>
		<tr>
			<th>ROW</th>
			<th title="Season">SEASON</th>
			<th title="Games Played">GP</th>
			<th title="Wins">W</th>
			<th title="Losses">L</th>
			<th title="Overtime Losses">OTL</th>
			<th title="Cup Differential">DIF</th>
			<th title="Winning Percentage">WP</th>
			<th title="Shooting Percentage">SP</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i = 0; $i < count($seasonStats); $i++)
			{
				if ($seasonStats[$i][1] == true)
				{
					?>
					<tr>
						<td><?php echo($i + 1); ?></td>
						<td><?php echo($seasonStats[$i][2]); ?></td>
						<td><?php echo(mysql_result($seasonStats[$i][0], 0, 'games_played')); ?></td>
						<td><?php echo(mysql_result($seasonStats[$i][0], 0, 'wins')); ?></td>
						<td><?php echo(mysql_result($seasonStats[$i][0], 0, 'losses')); ?></td>
						<td><?php echo(mysql_result($seasonStats[$i][0], 0, 'ot_losses')); ?></td>
						<td><?php echo(mysql_result($seasonStats[$i][0], 0, 'cup_dif')); ?></td>
						<td><?php if (mysql_result($seasonStats[$i][0], 0, 'games_played') > 0) { echo(number_format(mysql_result($seasonStats[$i][0], 0, 'wins') / mysql_result($seasonStats[$i][0], 0, 'games_played') * 100, 0).'%'); } else { echo(number_format(0, 0).'%'); } ?></td>
						<td><?php echo(number_format(mysql_result($seasonStats[$i][0], 0, 'shooting_percentage') * 100, 0).'%'); ?></td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>

<h2 id="milestones-title" class="section-header"><img src="img/milestones.png" style="width: 24px; height: 18px; margin: 0 5px 0 0;" />Milestones</h2>

<?php
$gamesPlayed 		= min(200, mysql_result($runQuery, 0, 'games_played'));
$wins 				= min(100, mysql_result($runQuery, 0, 'wins'));
$cupsHit 			= min(1000, mysql_result($runQuery, 0, 'hits'));
$bouncesHit 		= min(50, mysql_result($runQuery, 0, 'bounces'));
$redempSuccs 		= min(50, mysql_result($runQuery, 0, 'redemp_succs'));
$lastCupsHit 		= min(100, mysql_result($runQuery, 0, 'h1'));

$achievementsEarned = min(100, mysql_result($runQuery, 0, 'games_played'));
?>

<ul class="toplevellist">
	<li>
		<ul class="sublist">
			<li>
				<div id="m_gp" class="dial-container dial-container-left">
					<input class="dial" data-min="0" data-max="200" data-fgColor="#A00000" data-width="80" value="<?php echo $gamesPlayed; ?>">
					<h3>Games Played</h3>
				</div>
			</li>
			<li>
				<div id="m_wins" class="dial-container dial-container-right">
					<input class="dial" data-min="0" data-max="100" data-fgColor="#A00000" data-width="80" value="<?php echo $wins; ?>">
					<h3>Wins</h3>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="sublist">
			<li>
				<div id="m_cups" class="dial-container dial-container-left">
					<input class="dial" data-min="0" data-max="1000" data-fgColor="#A00000" data-width="80" value="<?php echo $cupsHit; ?>">
					<h3>Cups Hit</h3>
				</div>
			</li>
			<li>
				<div id="m_bounces" class="dial-container dial-container-right">
					<input class="dial" data-min="0" data-max="50" data-fgColor="#A00000" data-width="80" value="<?php echo $bouncesHit; ?>">
					<h3>Bounces Hit</h3>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="sublist">
			<li>
				<div id="m_rs" class="dial-container dial-container-left">
					<input class="dial" data-min="0" data-max="50" data-fgColor="#A00000" data-width="80" value="<?php echo $redempSuccs; ?>">
					<h3>Redemption Successes</h3>
				</div>
			</li>
			<li>
				<div id="m_lch" class="dial-container dial-container-right">
					<input class="dial" data-min="0" data-max="100" data-fgColor="#A00000" data-width="80" value="<?php echo $lastCupsHit; ?>">
					<h3>Last Cups Hit</h3>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="sublist">
			<li>
				<div id="m_ae" class="dial-container dial-container-left">
					<input class="dial" data-min="0" data-max="100" data-fgColor="#A00000" data-width="80" value="<?php echo $achievementsEarned; ?>">
					<h3>Achievements Earned</h3>
				</div>
			</li>
		</ul>
	</li>
</ul>

<h2 id="achievements-title" class="section-header"><img src="img/achievements.png" style="width: 26px; height: 20px; margin: 0 5px 0 0;" />Achievements</h2>

<ul>
	<li>
		<ul class="ach">
			<li><h5>Standard Achievements</h5></li>
			<li></li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_ss" class="ach-container">
					<img src="img/achievements/sharpshooter.png" />
					<h3 class="ach">Sharpshooter</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_shs'); ?></h4>
					<h6>Hit five or more cups in a row</h6>
				</div>
			</li>
			<li>
				<div id="a_mj" class="ach-container">
					<img src="img/achievements/michael-jordan.png" />
					<h3 class="ach">Michael Jordan</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_mj'); ?></h4>
					<h6>Go "On Fire" two or more times in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_tkcp" class="ach-container">
					<img src="img/achievements/the-kid-can-play.png" />
					<h3 class="ach">The Kid Can Play</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_cibav'); ?></h4>
					<h6>Win a game, sinking all the cups for your team</h6>
				</div>
			</li>
			<li>
				<div id="a_hc" class="ach-container">
					<img src="img/achievements/heartbreak-city.png" />
					<h3 class="ach">Heartbreak City</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_hc'); ?></h4>
					<h6>Win a game after trailing by five or more cups</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_snsn" class="ach-container">
					<img src="img/achievements/sneaky-snake.png" />
					<h3 class="ach">Sneaky Snake</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_cwtpd'); ?></h4>
					<h6>Hit two or more bounce shots in a game</h6>
				</div>
			</li>
			<li>
				<div id="a_ps" class="ach-container">
					<img src="img/achievements/porn-star.png" />
					<h3 class="ach">Porn Star</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_ps'); ?></h4>
					<h6>Hit two or more gang-bangs in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_per" class="ach-container">
					<img src="img/achievements/perfection.png" />
					<h3 class="ach">Perfection</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_per'); ?></h4>
					<h6>Shoot one-hundred percent in a game</h6>
				</div>
			</li>
			<li>
				<div id="a_dbno" class="ach-container">
					<img src="img/achievements/down-but-not-out.png" />
					<h3 class="ach">Down But Not Out</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_dbno'); ?></h4>
					<h6>Complete two or more redemptions in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_mar" class="ach-container">
					<img src="img/achievements/marathon.png" />
					<h3 class="ach">Marathon</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_mar'); ?></h4>
					<h6>Compete in a game that goes to triple overtime</h6>
				</div>
			</li>
			<li>
				<div id="a_fdm" class="ach-container">
					<img src="img/achievements/first-degree-murder.png" />
					<h3 class="ach">First Degree Murder</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_fdm'); ?></h4>
					<h6>Win a game before the other team gets a re-rack</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_ck" class="ach-container">
					<img src="img/achievements/comeback-kill.png" />
					<h3 class="ach">Comeback Kill</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_ck'); ?></h4>
					<h6>Sink a cup after missing five or more shots in a row</h6>
				</div>
			</li>
			<li>
				<div id="a_bb" class="ach-container">
					<img src="img/achievements/bill-buckner.png" />
					<h3 class="ach">Bill Buckner</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_bb'); ?></h4>
					<h6>Commit two or more errors in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<div id="a_bc" class="ach-container">
					<img src="img/achievements/bitch-cup.png" />
					<h3 class="ach">Bitch Cup</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_bc'); ?></h4>
					<h6>Hit the middle cup first on a ten-cup rack</h6>
				</div>
			</li>
			<li>
				<div id="a_bank" class="ach-container">
					<img src="img/achievements/bankruptcy.png" />
					<h3 class="ach">Bankruptcy</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_bank'); ?></h4>
					<h6>Sink no cups in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach" style="border-bottom: 1px dashed #EAEAEA; margin-bottom: 5px;">
			<li>
				<div id="a_skunk" class="ach-container">
					<img src="img/achievements/skunked.png" />
					<h3 class="ach">Skunked</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_skunk'); ?></h4>
					<h6>Lose a game before getting a re-rack</h6>
				</div>
			</li>
			<li>
				<div id="a_sw" class="ach-container">
					<img src="img/achievements/stevie-wonder.png" />
					<h3 class="ach">Stevie Wonder</h3>
					<h4><?php echo mysql_result($runQuery, 0, 'a_sw'); ?></h4>
					<h6>Miss ten shots in a row in a game</h6>
				</div>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li><h5>Unlockable Achievements</h5></li>
			<li></li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<?php
					if ($gamesPlayed >= 200)
					{
						?>
							<div id="a_bd" class="ach-container">
								<img src="img/achievements/binge-drinker.png" />
								<h3 class="ach">Binge Drinker</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_alc'); ?></h4>
								<h6>Play in consecutive overtime games</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_bd" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Games Played Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
			<li>
				<?php
					if ($wins >= 100)
					{
						?>
							<div id="a_sss" class="ach-container">
								<img src="img/achievements/superstar.png" />
								<h3 class="ach">Superstar</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_oah'); ?></h4>
								<h6>Win five games in a row</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_sss" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Wins Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<?php
					if ($cupsHit >= 1000)
					{
						?>
							<div id="a_sk" class="ach-container">
								<img src="img/achievements/serial-killer.png" />
								<h3 class="ach">Serial Killer</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_ce'); ?></h4>
								<h6>Hit ten cups in a game</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_sk" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Cups Hit Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
			<li>
				<?php
					if ($bouncesHit >= 50)
					{
						?>
							<div id="a_mag" class="ach-container">
								<img src="img/achievements/magician.png" />
								<h3 class="ach">Magician</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_slip'); ?></h4>
								<h6>Hit consecutive bounce shots without missing</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_mag" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Bounces Hit Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<?php
					if ($redempSuccs >= 50)
					{
						?>
							<div id="a_im" class="ach-container">
								<img src="img/achievements/immortal.png" />
								<h3 class="ach">Immortal</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_dciac'); ?></h4>
								<h6>Successfully complete a redemption and go on to win the game in the first overtime</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_im" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Redemption Successes Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
			<li>
				<?php
					if ($lastCupsHit >= 100)
					{
						?>
							<div id="a_mark" class="ach-container">
								<img src="img/achievements/marksman.png" />
								<h3 class="ach">Marksman</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_dth'); ?></h4>
								<h6>Hit three last cups in a game<?php if ($redempSuccs >= 50) { echo '<br>&nbsp;'; } ?></h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_mark" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Last Cups Hit Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
		</ul>
	</li>
	<li>
		<ul class="ach">
			<li>
				<?php
					if ($achievementsEarned >= 100)
					{
						?>
							<div id="a_sia" class="ach-container">
								<img src="img/achievements/seen-it-all.png" />
								<h3 class="ach">Seen It All</h3>
								<h4><?php echo mysql_result($runQuery, 0, 'ua_show'); ?></h4>
								<h6>Earn three achievements in a game</h6>
							</div>
						<?php
					}
					else
					{
						?>
							<div id="a_sia" class="ach-container">
								<img src="img/achievements/locked.png" />
								<h3 class="ach">Locked</h3>
								<h4>-</h4>
								<h6>Complete the Achievements Earned Milestone</h6>
							</div>
						<?php
					}
				?>
			</li>
			<li></li>
		</ul>
	</li>
</ul>

<h2 id="results-title" class="section-header"><img src="img/results.png" style="width: 20px; height: 20px; margin: 0 5px 0 0;" />Results</h2>

<table id="player-profiles-games" class="always-visible">
	<thead>
		<tr>
			<th>ROW</th>
			<th title="Winning Team">WIN</th>
			<th title="Losing Team">LOSS</th>
			<th title="Cups Remaining">CR</th>
			<th title="Number Of Overtimes">#OT</th>
			<th title="Date">DATE</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$count = 0;

			while ($row = mysql_fetch_assoc($runGamesQuery))
			{
				$count++;
				?>
					<tr>
						<td><?php echo $count;?></td>
						<td><?php echo $row['winning_team']; ?></td>
						<td><?php echo $row['losing_team']; ?></td>

						<?php
							if ($row['team_one_cups_remaining'] > 0)
							{
								?>
									<td><?php echo $row['team_one_cups_remaining']; ?></td>
								<?php
							}
							else
							{
								?>
									<td><?php echo $row['team_two_cups_remaining']; ?></td>
								<?php
							}
						?>

						<td><?php echo $row['number_of_ots']; ?></td>
						<td><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
					</tr>
				<?php
			}
		?>
	</tbody>
</table>

<?php 

}
else
{

?>

<div id="rank-header-container" style="border-bottom: 1px solid #A00000; padding: 0 0 0.5em 0;">
	<img src="img/rank.png" />
	<div class="name"><?php echo $player; ?></div>
</div>
<h4 class="nobody">No stats available for this season</h4>

<?php

}

?>