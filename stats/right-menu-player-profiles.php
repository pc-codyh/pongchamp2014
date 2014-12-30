<?php 

session_start();

require '../database-connect.php';

$query = 'SELECT `name`, `rank` FROM `players` WHERE `id_registrations`="'.$_SESSION['userID'].'" ORDER BY `name` ASC';

$runQuery = mysql_query($query);

?>

<ul>
	<?php 
		for ($i = 0; $i < mysql_num_rows($runQuery); $i++)
		{
			$name = mysql_result($runQuery, $i, 'name');
			$rank = mysql_result($runQuery, $i, 'rank');

			echo '<li id="'.$name.'">';
			echo '<img src="img/player-rank.png" style="float: right;" />';
			echo '<div style="margin: -1px 22px 0 0;">';
			echo $name;
			echo '</div>';
			echo '<div class="player-rank">'.$rank.'</div>';
			echo '</li>';
		}
	?>
</ul>