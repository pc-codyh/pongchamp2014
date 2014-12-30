<?php

session_start();

require '../database-connect.php';

$season = $_GET['season'];

if ($season == 'overall')
{
	$gamesQuery = 'SELECT * FROM `games` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `id` DESC';
}
else
{
	$gamesQuery = 'SELECT * FROM `games` WHERE `id_registrations`="'.$_SESSION['userID'].'" AND `season`="'.$season.'" ORDER BY `id` DESC';
}

$runGamesQuery = mysql_query($gamesQuery);

?>

<table id="game-results">
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