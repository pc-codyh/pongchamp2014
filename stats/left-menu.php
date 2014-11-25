<?php 

require '../database-connect.php';

$query = 'SELECT * FROM `seasons` ORDER BY `id` DESC';

$runQuery = mysql_query($query);

?>

<ul>
	<?php 
		echo '<li id="overall"><img src="img/overall.png" style="float: right;" /><div>Overall</div></li>';

		for ($i = 0; $i < mysql_num_rows($runQuery); $i++)
		{
			$season = mysql_result($runQuery, $i, 'season');

			echo '<li id="'.$season.'">';

			// Remove the first seven characters.
			$season = substr($season, 7);

			// Find and replace the underscores with spaces.
			$idx = strpos($season, '_');

			// Make the first letter uppercase.
			$season = str_replace('_', ' ', $season);
			$season = ucwords($season);

			if (substr($season, 0, 3) == 'Sum')
			{
				echo '<img src="img/summer.png" style="float: right;" />';
			}
			else if (substr($season, 0, 3) == 'Fal')
			{
				echo '<img src="img/fall.png" style="float: right;" />';
			}
			else if (substr($season, 0, 3) == 'Win')
			{
				echo '<img src="img/winter.png" style="float: right;" />';
			}
			else if (substr($season, 0, 3) == 'Spr')
			{
				echo '<img src="img/spring.png" style="float: right;" />';
			}

			echo '<div>';
			echo $season;
			echo '</div>';

			echo '</li>';
		}
	?>
</ul>