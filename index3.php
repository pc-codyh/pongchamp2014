<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pong Champ</title>
	<link rel="stylesheet" href="css/pc3.css" />
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.arctext.js"></script>
	<script type="text/javascript" src="js/pc3.js"></script>
</head>
<body>
	<div id="background"></div>
	<div id="page-wrapper">
		<div id="modal-container">
			<div id="circle">
				<div id="login-modal-title">Sign in</div>
				<div id="login-modal-container">
					<input type="text" name="username" id="username" class="username" placeholder="Username" />
					<br>
					<input type="password" name="password" id="password" class="password" placeholder="Password" /><img src="img/login.png" alt="Login" id="login-modal-submit" class="login-form-icon" tabindex="0" />
				</div>
				<h4 id="login-modal-message-valid" class="login-modal-message">Username or password is incorrect</h4>
				<div id="login-modal-footer-container" class="modal-footer-container">
					<p>Don't have an account? <span id="swap-register">Register.</span></p>
				</div>
				<div id="register-modal-title">Register</div>
				<div id="register-modal-container">
					<img src="img/active-input.png" alt="Username" id="register-username-icon" class="login-form-icon" /><input type="text" name="username" id="register-username" placeholder="Username" />
					<br>
					<img src="img/active-input.png" alt="Password" id="register-password-icon" class="login-form-icon" /><input type="password" name="password" id="register-password" placeholder="Password" />
					<br>
					<img src="img/active-input.png" alt="Confirm Password" id="register-confirm-password-icon" class="login-form-icon" /><input type="password" name="confirm-password" id="register-confirm-password" placeholder="Confirm Password" />
				</div>
				<h4 id="register-modal-message-username" class="register-modal-message"></h4>
				<h4 id="register-modal-message-password" class="register-modal-message"></h4>
				<h4 id="register-modal-message-confirm-password" class="register-modal-message"></h4>
				<h4 id="register-modal-message-valid" class="register-modal-message">You're all set</h4>
				<div id="register-modal-submit-container">
					<h3>Create my account</h3>
					<div id="register-modal-submit" tabindex="0"></div>
				</div>
				<div id="register-modal-footer-container" class="modal-footer-container">
					<p>Already have an account? <span id="swap-login">Sign in.</span></p>
				</div>
			</div>
			<div id="go-back"></div>
		</div>
		<div id="main-container">
			<h1 id="title" class="title">Pong Champ</h1>
			<img src="img/pongchamp.png" alt="PC" />
			<h2 id="subtitle" class="title">The next level in beer pong stats.</h2>
		</div>
		<div id="login-container">
			<div id="login" class="menu-button">
				<div class="icon"></div>
				<h3>Sign in</h3>
			</div>
			<div id="signup" class="menu-button">
				<div class="icon"></div>
				<h3>Register</h3>
			</div>
		</div>
		<div id="find-out-more">
			<a href="#">Find out more</a>
		</div>
		<div id="app-container">
			<h2>Get the app today. For Android and iOS.</h2>
			<div id="app-subcontainer">
				<div id="android" class="app">
					<img src="img/googleplay3.png" alt="Google Play" />
					<h4 class="app-store">Google Play</h4>
				</div>
				<div id="ios" class="app">
					<img src="img/appstore2.png" alt="App Store" />
					<h4 class="app-store">App Store</h4>
				</div>
				<div id="app-hover" class="app">
					<div id="feature-1" class="feature-item">
						<div class="feature-title">Over 40 different stat categories</div>
					</div>
					<div id="feature-2" class="feature-item">
						<div class="feature-title">Customizable rules</div>
					</div>
					<div id="feature-3" class="feature-item">
						<div class="feature-title">Smartwatch integration</div>
					</div>
					<div id="feature-4" class="feature-item">
						<div class="feature-title">Leaderboards and rankings</div>
					</div>
					<div id="feature-5" class="feature-item">
						<div class="feature-title">Achievements</div>
					</div>
					<div id="feature-6" class="feature-item">
						<div class="feature-title">Pre-game odds/predictions</div>
					</div>
					<div id="feature-7" class="feature-item">
						<div class="feature-title"><a href="#" id="back-to-top">Back to top</a></div>
					</div>
				</div>
			</div>
			<div id="footer">
				<div id="copyright">Copyright &copy; 2014. All Rights Reserved.</div>
			</div>
		</div>
		<div id="main-stats-container">
			<div id="account-container">
				<div id="account-user" class="account-info"></div>
				<div id="account-link-container" class="account-info">
					<a href="#" id="my-account-link">My account</a> | <a href="#" id="my-account-logout">Logout</a>
				</div>
				<div id="account-icon"></div>
			</div>
			<div id="my-account-overlay"></div>
			<div id="my-account">
				<div id="my-account-1" class="my-account-item">
					<div class="my-account-title">Member since:</div>
					<div class="my-account-value" id="my-account-date"></div>
				</div>
				<div id="my-account-2" class="my-account-item">
					<div class="my-account-title">Games played:</div>
					<div class="my-account-value" id="my-account-gp"></div>
				</div>
				<div id="my-account-3" class="my-account-item">
					<div class="my-account-title">Players:</div>
					<div class="my-account-value" id="my-account-players"></div>
				</div>
				<div id="my-account-4" class="my-account-item">
					<div class="my-account-title"></div>
					<div class="my-account-value" id="my-account-sp"></div>
				</div>
				<div id="my-account-5" class="my-account-item" style="border: none !important;">
					<div class="my-account-title"></div>
					<div class="my-account-value" id="my-account-sp"></div>
				</div>
				<div id="my-account-footer">
					<div id="my-account-choose-icon-container" class="my-account-setting"><div id="my-account-choose-icon" class="my-account-subsetting"><span>Choose icon</span></div></div>
					<div id="my-account-upload-icon-container" class="my-account-setting"><div id="my-account-upload-icon" class="my-account-subsetting"><span>Upload icon</span></div></div>
				</div>
			</div>
			<div id="account-setting-message-container">
				<div id="account-setting-message"><span>Icon changed successfully</span><img src="img/confirmed-input.png" alt="OK" /></div>
			</div>
			<div id="choose-icon-container" class="setting-subcontainer">
				<table>
					<tr>
						<td><div class="choose-icon-icon top-row" id="default-icon-1"></div></td>
						<td><div class="choose-icon-icon top-row" id="default-icon-2"></div></td>
						<td><div class="choose-icon-icon top-row" id="default-icon-3"></div></td>
						<td><div class="choose-icon-icon top-row" id="default-icon-4"></div></td>
					</tr>
					<tr>
						<td><div class="choose-icon-icon bottom-row" id="default-icon-5"></div></td>
						<td><div class="choose-icon-icon bottom-row" id="default-icon-6"></div></td>
						<td><div class="choose-icon-icon bottom-row" id="default-icon-7"></div></td>
						<td><div class="choose-icon-icon bottom-row" id="default-icon-8"></div></td>
					</tr>
				</table>
			</div>
			<div id="upload-icon-container" class="setting-subcontainer">
				<table>
					<tr>
						<td id="upload-url">URL:</td>
						<td id="upload-url-text"><input type="text" name="reference-icon" id="reference-file" /></td>
					</tr>
				</table>
				<div id="upload-icon-submit-container">
					<h3>Upload</h3>
					<div id="upload-icon-submit" tabindex="0"></div>
				</div>
			</div>
			<div id="stats-menu-container">
				<div id="stats-menu-player-stats" class="stats-menu-icon"><h4>Player Stats</h4></div>
				<div id="stats-menu-player-profiles" class="stats-menu-icon"><h4>Player Profiles</h4></div>
				<div id="stats-menu-team-stats" class="stats-menu-icon"><h4>Team Stats</h4></div>
				<div id="stats-menu-team-profiles" class="stats-menu-icon"><h4>Team Profiles</h4></div>
				<div id="stats-menu-game-results" class="stats-menu-icon"><h4>Game Results</h4></div>
				<div id="stats-menu-head-to-head" class="stats-menu-icon"><h4>Head To Head</h4></div>
				<div id="stats-menu-achievements" class="stats-menu-icon"><h4>Achievements</h4></div>
			</div>
			<div id="achievements-container">
				<div class="sharpshooter item">
					<div class="icon"></div>
					<div class="title">SHARPSHOOTER</div>
					<div class="desc">Hit five or more cups in a row in a game</div>
				</div>
				<div class="michael-jordan item">
					<div class="icon"></div>
					<div class="title">MICHAEL JORDAN</div>
					<div class="desc">Go "On Fire" two or more times in a game</div>
				</div>
				<div class="the-kid-can-play item">
					<div class="icon"></div>
					<div class="title">THE KID CAN PLAY</div>
					<div class="desc">Sink all the cups for your team in a game (your team must win)</div>
				</div>
				<div class="heartbreak-city item">
					<div class="icon"></div>
					<div class="title">HEARTBREAK CITY</div>
					<div class="desc">Win a game after being down by five or more cups</div>
				</div>
				<div class="caught-with-their-pants-down item">
					<div class="icon"></div>
					<div class="title">CAUGHT WITH THEIR PANTS DOWN</div>
					<div class="desc">Hit two or more bounces in a game</div>
				</div>
				<div class="porn-star item">
					<div class="icon"></div>
					<div class="title">PORN STAR</div>
					<div class="desc">Hit two or more gang-bangs in a game</div>
				</div>
				<div class="perfection item">
					<div class="icon"></div>
					<div class="title">PERFECTION</div>
					<div class="desc">Shoot one-hundred percent in a game</div>
				</div>
				<div class="down-but-not-out item">
					<div class="icon"></div>
					<div class="title">DOWN BUT NOT OUT</div>
					<div class="desc">Complete two or more redemptions in a game</div>
				</div>
				<div class="marathon item">
					<div class="icon"></div>
					<div class="title">MARATHON</div>
					<div class="desc">Compete in a game that goes to triple overtime</div>
				</div>
				<div class="first-degree-murder item">
					<div class="icon"></div>
					<div class="title">FIRST DEGREE MURDER</div>
					<div class="desc">Win a game before the other team gets a re-rack</div>
				</div>
				<div class="comeback-kill item">
					<div class="icon"></div>
					<div class="title">COMEBACK KILL</div>
					<div class="desc">Hit a shot after missing five or more in a row</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>