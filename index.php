<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pong Champ</title>
	<link rel="stylesheet" href="css/pc.css" />
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/pc.js"></script>
</head>
<body>
	<div id="landing">
		<div class="inner">
			<img id="logo" src="img/pongchamp.png" alt="PC" />
			<h1>Pong Champ</h1>
			<p class="sub">The next level in beer pong stats</p>
			<p class="buttons">
				<a href="#" class="button" id="login">Sign in</a>
				<a href="#" class="button" id="register">Create account</a>
			</p>
		</div>
	</div>
	<div id="components">
		<ul>
			<li><img src="img/stats.png" /><h2>Over 40 different stats</h2></li>
			<li><img src="img/watch.png" /><h2>Smartwatch integration</h2></li>
			<li><img src="img/money.png" /><h2>Free to use</h2></li>
		</ul>
	</div>
	<div id="download">
		<h2>Download the app today for:</h2>
		<p class="buttons">
			<a href="#"><img src="img/android.png" alt="Android" /></a>
			<a href="#"><img src="img/ios.png" alt="Android" /></a>
		</p>
	</div>
	<div id="footer">
		<h3>New to beer pong?</h2>
		<p class="buttons">
			<a href="http://en.wikipedia.org/wiki/Beer_pong" target="_blank" class="button">Find out more</a>
		</p>
		<p class="copy">Copyright &copy; 2014. All Rights Reserved.</p>
		<ul>
			<li><img src="img/facebook.png" /></li>
			<li><img src="img/twitter.png" /></li>
			<li><img src="img/instagram.png" /></li>
		</ul>
	</div>
	<div id="modal">
		<div class="close"></div>
		<div class="login">
			<div class="close-button"></div>
			<div class="content">
				<h2>Sign in</h2>
				<input id="login-username" class="modal-input" type="text" placeholder="Username" />
				<input id="login-password" class="modal-input" type="password" placeholder="Password" />
				<input id="login-submit" class="modal-submit" type="button" value="Sign in »" />
			</div>
			<div class="message" style="top: 192px;"></div>
			<div class="footer">
				<p>Don't have an account? <a href="#">Create one.</a></p>
			</div>
		</div>
		<div class="register">
			<div class="close-button"></div>
			<div class="content">
				<h2>Create account</h2>
				<input id="register-username" class="modal-input" type="text" placeholder="Username" />
				<input id="register-password" class="modal-input" type="password" placeholder="Password" />
				<input id="register-confirm-password" class="modal-input" type="password" placeholder="Confirm Password" />
				<input id="register-submit" class="modal-submit" type="button" value="Create »" />

				<div class="input-valid" id="register-username-valid"></div>
				<div class="input-valid" id="register-password-valid"></div>
				<div class="input-valid" id="register-confirm-password-valid"></div>
			</div>
			<div class="message" style="top: 258px;"></div>
			<div class="footer">
				<p>Already have an account? <a href="#">Sign in.</a></p>
			</div>
		</div>
	</div>
	<form id="stats-form" action="stats.php" method="post">
		<input id="stats-username" type="hidden" name="username" />
	</form>
</body>
</html>