{
	var _checkForValidUsernameID 		= 0;
	var _checkForValidPasswordID 		= 0;
	var _checkForValidConfirmPasswordID = 0;
	var _checkForActiveInputID			= 0;
	var _isModalVisible 				= false;
	var _logins 						= [];

	var _ID 							= -1;
	var _iconURL						= null;

	var _validUsername 					= false;
	var _validPassword 					= false;
	var _passwordsMatch 				= false;
	var _validRegistration 				= false;

	var _myAccountVisible				= false;

	var _changePasswordVisible			= false;
	var _uploadIconVisible				= false;

	var ID_USERNAME 					= 0;
	var ID_PASSWORD 					= 1;
	var ID_ID							= 2;
	var ID_ICON_URL						= 3;

	var ID_PLAYER_STATS 				= 0;
	var ID_PLAYER_PROFILES 				= 1;
	var ID_TEAM_STATS 					= 2;
	var ID_TEAM_PROFILES 				= 3;
	var ID_GAME_RESULTS 				= 4;
	var ID_HEAD_TO_HEAD 				= 5;
	var ID_ACHIEVEMENTS 				= 6;

	var STATS_MENU_ACTIVE				= 0;

	var INVALID_USERNAME_LENGTH 		= 'Username must be at least 6 characters';
	var USERNAME_ALREADY_EXISTS 		= 'Username already exists';
	var INVALID_PASSWORD_LENGTH 		= 'Password must be at least 6 characters';
	var PASSWORDS_DO_NOT_MATCH			= 'Passwords do not match';

	var KEYPRESS_ENTER 					= 13;

	var MONTH_NAMES = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

	$(document).ready(function()
	{
		footerHeight();
		statsContainerHeight();
		findOutMoreClickHandler();
		backToTopClickHandler();
		appHoverHandlers();
		loginClickHandler();
		registerClickHandler();
		closeModalClickHandler();
		swapModalClickHandler();

		submitLoginClickHandler();
		submitRegisterClickHandler();

		getLogins(function(){});

		checkForActiveInput();
		deactivateStatsMenuIcons(ID_PLAYER_STATS);
		statsMenuStateHandlers();

		myAccountClickHandler();
		logoutClickHandler();

		accountSettingsClickHandler();
		chooseIconClickHandler();
		uploadIconClickHandler();
	});

	function footerHeight()
	{
		var height = ($(window).height() - 456);

		$('#app-container #footer').height(height);
	};

	function statsContainerHeight()
	{
		var height = ($(window).height() - 100);

		// $('#achievements-container').height(height);
		$('#achievements-container').css('max-height', height);
	};

	function findOutMoreClickHandler()
	{
		$('#find-out-more').click(function()
		{
			scrollDown();
		});
	};

	function scrollDown()
	{
		var wrapper = $('#page-wrapper');

		wrapper.animate(
		{
			top: -wrapper.height()
		}, 1000);
	};

	function scrollUp()
	{
		var wrapper = $('#page-wrapper');

		wrapper.animate(
		{
			top: wrapper.height()
		}, 1000);
	};

	function scrollReset()
	{
		var wrapper = $('#page-wrapper');

		wrapper.animate(
		{
			top: 0
		}, 1000);
	};

	function backToTopClickHandler()
	{
		$('#back-to-top').click(function()
		{
			scrollReset();
		});
	};

	function appHoverHandlers()
	{
		$('#android img').mouseover(function()
		{
			$(this).attr('src', 'img/googleplay3-hover.png');
		});

		$('#android img').mouseout(function()
		{
			$(this).attr('src', 'img/googleplay3.png');
		});

		$('#ios img').mouseover(function()
		{
			$(this).attr('src', 'img/appstore2-hover.png');
		});

		$('#ios img').mouseout(function()
		{
			$(this).attr('src', 'img/appstore2.png');
		});
	};

	function closeModalClickHandler()
	{
		$('#go-back').click(function()
		{
			hideModal(function()
			{
				// ... do nothing for now.
			});
		});
	};

	function loginClickHandler()
	{
		_isModalVisible = true;

		$('#login .icon').click(function()
		{
			showLoginModal();
		});

		$('#login-modal-submit').mouseover(function()
		{
			$(this).attr('src', 'img/login-hover.png');
		});

		$('#login-modal-submit').mouseout(function()
		{
			$(this).attr('src', 'img/login.png');
		});
	};

	function registerClickHandler()
	{
		_isModalVisible = true;

		$('#signup .icon').click(function()
		{
			showRegisterModal();

		});
	};

	function swapModalClickHandler()
	{
		$('#swap-login').click(function()
		{
			hideModal(function()
			{
				showLoginModal();
			});
		});

		$('#swap-register').click(function()
		{
			hideModal(function()
			{
				showRegisterModal();
			});
		});
	};

	function showLoginModal()
	{
		$('#login-modal-title, #login-modal-container, #login-modal-submit-container, #login-modal-footer-container').show();
		$('#modal-container').fadeIn(500);

		$('#username-icon').show();
		$('#username').focus();

		blurBackground();
	};

	function showRegisterModal()
	{
		$('#modal-container #circle').addClass('register-circle');
		$('#register-modal-title, #register-modal-container, #register-modal-submit-container, #register-modal-footer-container').show();
		$('#modal-container').fadeIn(500);

		$('#register-username').focus();

		blurBackground();
	};

	function hideModal(callback)
	{
		sharpenBackground();

		$('#modal-container').fadeOut(500, function()
		{
			$('#login-modal-title, #login-modal-container, #login-modal-submit-container, #login-modal-footer-container').hide();
			$('#register-modal-title, #register-modal-container, #register-modal-submit-container, #register-modal-footer-container').hide();
			$('#modal-container #circle').removeClass('register-circle');
			$('#login-modal-message-valid').hide();

			_isModalVisible = false;

			callback();
		});
	};

	function blurBackground()
	{
		$('#main-container, #login-container, #find-out-more').addClass('blurred');
	};

	function sharpenBackground()
	{
		$('#main-container, #login-container, #find-out-more').removeClass('blurred');
	};

	function submitLoginClickHandler()
	{
		$('#login-modal-submit').click(function()
		{
			login(_logins, $('#username').val(), $('#password').val());
		});

		$('#login-modal-submit, #password').keypress(function(e)
		{
			if (e.which == KEYPRESS_ENTER)
			{
				login(_logins, $('#username').val(), $('#password').val());
			}
		});
	};

	function submitRegisterClickHandler()
	{
		$('#register-modal-submit').click(function()
		{
			register($('#register-username').val(), $('#register-password').val());
		});

		$('#register-modal-submit').keypress(function(e)
		{
			if (e.which == KEYPRESS_ENTER)
			{
				register($('#register-username').val(), $('#register-password').val());
			}
		});
	};

	function login(logins, username, password)
	{
		var validLogin = false;
		var user, pass;

		for (var i = 0; i < logins.length; i++)
		{
			user = logins[i][ID_USERNAME];
			pass = logins[i][ID_PASSWORD];

			console.log(user);
			console.log(pass);

			if ((user.toLowerCase() == username.toLowerCase()) && (pass == password))
			{
				_ID 		= logins[i][ID_ID];
				_iconURL 	= logins[i][ID_ICON_URL];
				validLogin 	= true;

				getMyAccountInfo();

				break;
			}
		}

		if (validLogin)
		{
			$('#account-user').html(user);

			// If the user has uploaded an icon,
			// use that one.
			if (false)
			{

			}
			// Use the chosen/default icon.
			else
			{
				$('#account-icon').css({'background': 'url(' + _iconURL + ') 0 0 no-repeat', 'background-size': 'cover'});
			}

			scrollUp();

			hideModal(function()
			{
				// ... Do nothing for now.
			});
		}
		else
		{
			$('#login-modal-message-valid').show();
		}
	};

	function register(username, password)
	{
		if (checkForValidRegistration())
		{
			request = $.ajax(
		    {
		        url: 'create-account.php',
		        type: 'post',
		        data: {'username': username, 'password': password}
		    });

		    request.done(function (response, textStatus, jqXHR)
		    {
		    	if (response == 1)
		    	{
		    		clearRegistrationIntervals();

		    		getLogins(function()
	    			{
	    				login(_logins, username, password);
	    			});
		    	}
		    });

		    request.fail(function (jqXHR, textStatus, errorThrown)
		    {
		        console.error
		        (
		            "The following error occured: " +
		            textStatus, errorThrown
		        );
		    });

		    request.always(function()
		    {
		        // ...
		    });
		}
	};

	function getMyAccountInfo()
	{
		request = $.ajax(
	    {
	        url: 'get-myaccount.php',
	        type: 'get',
	        data: {'id': _ID}
	    });

	    request.done(function (response, textStatus, jqXHR)
	    {
	    	var accountInfo  = $.parseJSON(response);
	    	var creationDate = new Date(accountInfo['creationDate']);
	    	var numGames 	 = accountInfo['gamesPlayed'];
	    	var numPlayers 	 = accountInfo['numPlayers'];

	    	$('#my-account-date').html(MONTH_NAMES[creationDate.getMonth()] + ' ' + creationDate.getDate() + ', ' + creationDate.getFullYear());
	    	$('#my-account-gp').html(numGames);
	    	$('#my-account-players').html(numPlayers);
	    });

	    request.fail(function (jqXHR, textStatus, errorThrown)
	    {
	        console.error
	        (
	            "The following error occured: " +
	            textStatus, errorThrown
	        );
	    });

	    request.always(function()
	    {
	        // ...
	    });
	};

	function getLogins(callback)
	{
	    request = $.ajax(
	    {
	        url: 'get-logins.php',
	        type: 'post',
	        data: null
	    });

	    request.done(function (response, textStatus, jqXHR)
	    {
	    	_logins = $.parseJSON(response);

	    	checkForValidUsername(_logins);
	    	checkForValidPassword();
	    	checkForValidConfirmPassword();

	    	callback();
	    });

	    request.fail(function (jqXHR, textStatus, errorThrown)
	    {
	        console.error
	        (
	            "The following error occured: " +
	            textStatus, errorThrown
	        );
	    });

	    request.always(function()
	    {
	        // ...
	    });
	};

	function checkForValidUsername(logins)
	{
		var username 		= '';
		var msg				= '';
		var validLength 	= false;
		var foundMatch 		= false;
		var validUsername  	= false;
		var textWasEntered 	= false;

		_checkForValidUsernameID = setInterval(function()
		{
			foundMatch 	= false;

			for (var i = 0; i < logins.length; i++)
			{
				username 		= logins[i][ID_USERNAME];
				enteredUsername = $('#register-username').val();

				if (enteredUsername.length > 0)
				{
					textWasEntered = true;
				}

				validLength = (enteredUsername.length >= 6) ? true : false;

				if (username.toLowerCase() == enteredUsername.toLowerCase())
				{
					foundMatch = true;

					break;
				}
			}

			if (!validLength)
			{
				msg 			= INVALID_USERNAME_LENGTH;
				validUsername 	= false;
				_validUsername 	= false;
			}
			else if (foundMatch)
			{
				msg 			= USERNAME_ALREADY_EXISTS;
				validUsername 	= false;
				_validUsername 	= false;
			}
			else
			{
				msg 			= '';
				validUsername 	= true;
				_validUsername 	= true;
			}

			if (textWasEntered)
			{
				$('#register-modal-message-username').html(msg);
				validateInput($('#register-username-icon'), validUsername);
			}
		}, 1000);
	};

	function checkForValidPassword()
	{
		var password 		= '';
		var msg				= '';
		var validLength 	= false;
		var validPassword  	= false;
		var textWasEntered 	= false;

		_checkForValidPasswordID = setInterval(function()
		{
			enteredPassword = $('#register-password').val();

			if (enteredPassword.length > 0)
			{
				textWasEntered = true;
			}

			validLength = (enteredPassword.length >= 6) ? true : false;

			if (!validLength)
			{
				msg 			= INVALID_PASSWORD_LENGTH;
				validPassword 	= false;
				_validPassword 	= false;
			}
			else
			{
				msg 			= '';
				validPassword 	= true;
				_validPassword 	= true;
			}

			if (textWasEntered)
			{
				$('#register-modal-message-password').html(msg);
				validateInput($('#register-password-icon'), validPassword);
			}
		}, 1000);
	};

	function checkForValidConfirmPassword()
	{
		var password 		= '';
		var msg				= '';
		var validPassword  	= false;
		var textWasEntered 	= false;

		_checkForValidConfirmPasswordID = setInterval(function()
		{
			enteredPassword = $('#register-confirm-password').val();

			if (enteredPassword.length > 0)
			{
				textWasEntered = true;
			}

			if (enteredPassword != $('#register-password').val())
			{
				msg 					= PASSWORDS_DO_NOT_MATCH;
				validPassword 			= false;
				_validConfirmPassword 	= false;
			}
			else
			{
				msg 					= '';
				validPassword 			= true;
				_validConfirmPassword 	= true;
			}

			if (textWasEntered)
			{
				$('#register-modal-message-confirm-password').html(msg);
				validateInput($('#register-confirm-password-icon'), validPassword);
			}
		}, 1000);
	};

	function clearRegistrationIntervals()
	{
		clearInterval(_checkForValidUsernameID);
		clearInterval(_checkForValidPasswordID);
		clearInterval(_checkForValidConfirmPasswordID);
	};

	function checkForActiveInput()
	{
		_checkForActiveInputID = setInterval(function()
		{
			if ($('#register-username').is(':focus'))
			{
				toggleInputIcons('#register-username-icon');
			}
			else if ($('#register-password').is(':focus'))
			{
				toggleInputIcons('#register-password-icon');
			}
			else if ($('#register-confirm-password').is(':focus'))
			{
				toggleInputIcons('#register-confirm-password-icon');
			}

			$('#register-modal-message-username, #register-modal-message-password, #register-modal-message-confirm-password, #register-modal-message-valid').hide();

			if ($('#register-modal-container').css('display') != 'none')
			{
				if ($('#register-modal-message-username').html().length > 0)
				{
					$('#register-modal-message-username').show();
				}
				else if ($('#register-modal-message-password').html().length > 0)
				{
					$('#register-modal-message-password').show();
				}
				else if ($('#register-modal-message-confirm-password').html().length > 0)
				{
					$('#register-modal-message-confirm-password').show();
				}

				if (checkForValidRegistration())
				{
					$('#register-modal-message-valid').show();
				}
			}
		}, 100);
	};

	function validateInput(selector, isValid)
	{
		(isValid) ? selector.attr('src', 'img/confirmed-input.png') : 
					selector.attr('src', 'img/invalid-input.png');
	};

	function toggleInputIcons(id)
	{
		if ($('#register-username-icon').attr('src') == 'img/active-input.png')
		{
			$('#register-username-icon').hide();	
		}

		if ($('#register-password-icon').attr('src') == 'img/active-input.png')
		{
			$('#register-password-icon').hide();	
		}

		if ($('#register-confirm-password-icon').attr('src') == 'img/active-input.png')
		{
			$('#register-confirm-password-icon').hide();	
		}

		if (id == '#register-username-icon')
		{
			if (hasInputBeenEntered($('#register-username-icon')) || $('#register-username').is(':focus'))
			{
				$('#register-username-icon').show();
			}
		}
		else if (id == '#register-password-icon')
		{
			if (hasInputBeenEntered($('#register-password-icon')) || $('#register-password').is(':focus'))
			{
				$('#register-password-icon').show();
			}
		}
		else if (id == '#register-confirm-password-icon')
		{
			if (hasInputBeenEntered($('#register-confirm-password-icon')) || $('#register-confirm-password').is(':focus'))
			{
				$('#register-confirm-password-icon').show();
			}
		}
	};

	function hasInputBeenEntered(selector)
	{
		return ((selector.attr('src') == 'img/confirmed-input.png') || (selector.attr('src') == 'img/invalid-input.png'));
	};

	function checkForValidRegistration()
	{
		return (_validUsername && _validPassword && _validConfirmPassword);
	};

	function deactivateStatsMenuIcons(active)
	{
		$('.stats-menu-icon').addClass('stats-menu-icon-inactive');
		$('.stats-menu-icon').each(function(index)
		{
			if (index == active)
			{
				$(this).removeClass('stats-menu-icon-inactive');				
			}
		});

		STATS_MENU_ACTIVE = active;
	};

	function statsMenuStateHandlers()
	{
		$('.stats-menu-icon').mouseover(function()
		{
			$(this).removeClass('stats-menu-icon-inactive');
		});

		$('.stats-menu-icon').mouseout(function()
		{
			deactivateStatsMenuIcons(STATS_MENU_ACTIVE);
		});

		$('.stats-menu-icon').click(function()
		{
			STATS_MENU_ACTIVE = getIDForMenuIconID($(this).attr('id'));

			deactivateStatsMenuIcons(STATS_MENU_ACTIVE);
		});
	};

	function getIDForMenuIconID(id)
	{
		if (id == 'stats-menu-player-stats')
		{
			return ID_PLAYER_STATS;
		}
		else if (id == 'stats-menu-player-profiles')
		{
			return ID_PLAYER_PROFILES;
		}
		else if (id == 'stats-menu-team-stats')
		{
			return ID_TEAM_STATS;
		}
		else if (id == 'stats-menu-team-profiles')
		{
			return ID_TEAM_PROFILES;
		}
		else if (id == 'stats-menu-game-results')
		{
			return ID_GAME_RESULTS;
		}
		else if (id == 'stats-menu-head-to-head')
		{
			return ID_HEAD_TO_HEAD;
		}
		else if (id == 'stats-menu-achievements')
		{
			return ID_ACHIEVEMENTS;
		}
	};

	function myAccountClickHandler()
	{
		$('#account-icon').click(function()
		{
			$('#my-account-link').click();
		});

		$('#my-account-link').click(function()
		{
			if (!_myAccountVisible)
			{
				$('#my-account-overlay').fadeIn(500);

				$('#my-account').animate(
				{
					width: 		'300px',
					height: 	'300px',
					opacity: 	1
				}, 500);
			}
			else
			{
				hideAccountSettingMessage(true);

				if (_changePasswordVisible)
				{
					hideChangePassword(function()
					{
						hideAccount();
					});
				}
				else if (_uploadIconVisible)
				{
					hideUploadIcon(function()
					{
						hideAccount();
					});
				}
				else
				{
					hideAccount();
				}
				
				function hideAccount()
				{
					$('#my-account-overlay').fadeOut(500);

					$('#my-account').animate(
					{
						width: 		'0px',
						height: 	'0px',
						opacity: 	0
					}, 500);
				};
			}

			_myAccountVisible = !_myAccountVisible;
		});

		$('#my-account-overlay').click(function()
		{
			$('#my-account-link').click();
		});
	};

	function logoutClickHandler()
	{
		$('#my-account-logout').click(function()
		{
			// ... need to invalidate User here.

			if (_myAccountVisible)
			{
				$('#my-account-link').click();
			}

			scrollReset();
		});
	};

	function accountSettingsClickHandler()
	{
		$('#my-account-choose-icon-container').click(function()
		{
			hideAccountSettingMessage(true);

			if (_uploadIconVisible)
			{
				hideUploadIcon(function()
				{
					showChangePassword();
				});
			}
			else if (_changePasswordVisible)
			{
				hideChangePassword(function()
				{
					// ... do nothing.
				});
			}
			else
			{
				showChangePassword();
			}
		});

		$('#my-account-upload-icon-container').click(function()
		{
			hideAccountSettingMessage(true);

			if (_changePasswordVisible)
			{
				hideChangePassword(function()
				{
					showUploadIcon();
				});
			}
			else if (_uploadIconVisible)
			{
				hideUploadIcon(function()
				{
					// ... do nothing.
				});
			}
			else
			{
				showUploadIcon();
			}
		});
	};

	function showChangePassword()
	{
		var selector = $('#choose-icon-container');

		selector.show().animate(
		{
			top: '364px'
		}, 500);

		_changePasswordVisible = true;
	};

	function hideChangePassword(callback)
	{
		var selector = $('#choose-icon-container');

		selector.animate(
		{
			top: '214px'
		}, 500, function()
		{
			selector.hide();
			callback();
		});

		_changePasswordVisible = false;
	};

	function showUploadIcon()
	{
		var selector = $('#upload-icon-container');

		selector.show().animate(
		{
			top: '364px'
		}, 500);

		_uploadIconVisible = true;
	};

	function hideUploadIcon(callback)
	{
		var selector = $('#upload-icon-container');

		selector.animate(
		{
			top: '214px'
		}, 500, function()
		{
			selector.hide();
			callback();
		});

		_uploadIconVisible = false;
	};

	function chooseIconClickHandler()
	{
		$('.choose-icon-icon').click(function()
		{
			if ($(this).attr('id') == 'default-icon-1')
			{
				uploadIcon('img/default-icons/default-1.png');
			}
			else if ($(this).attr('id') == 'default-icon-2')
			{
				uploadIcon('img/default-icons/default-2.png');
			}
			else if ($(this).attr('id') == 'default-icon-3')
			{
				uploadIcon('img/default-icons/default-3.png');
			}
			else if ($(this).attr('id') == 'default-icon-4')
			{
				uploadIcon('img/default-icons/default-4.png');
			}
			else if ($(this).attr('id') == 'default-icon-5')
			{
				uploadIcon('img/default-icons/default-5.png');
			}
			else if ($(this).attr('id') == 'default-icon-6')
			{
				uploadIcon('img/default-icons/default-6.png');
			}
			else if ($(this).attr('id') == 'default-icon-7')
			{
				uploadIcon('img/default-icons/default-7.png');
			}
			else if ($(this).attr('id') == 'default-icon-8')
			{
				uploadIcon('img/default-icons/default-8.png');
			}
		});
	};

	function uploadIcon(iconURL)
	{
		$('#account-icon').css({'background': 'url(' + iconURL + ')', 'background-size': 'cover'});

		request = $.ajax(
	    {
	        url: 'upload-icon.php',
	        type: 'post',
	        data: {'id' : _ID, 'icon_url' : iconURL}
	    });

	    request.done(function (response, textStatus, jqXHR)
	    {
	    	if (response == 1)
	    	{
	    		showAccountSettingMessage('Icon changed successfully', true);
	    	}
	    	else
	    	{
	    		showAccountSettingMessage('Error changing icon', false);
	    	}
	    });

	    request.fail(function (jqXHR, textStatus, errorThrown)
	    {
	        console.error
	        (
	            "The following error occured: " +
	            textStatus, errorThrown
	        );
	    });

	    request.always(function()
	    {
	        // ...
	    });
	};

	function showAccountSettingMessage(msg, success)
	{
		$('#account-setting-message span').html(msg);

		(success) ? $('#account-setting-message img').attr('src', 'img/confirmed-input.png') : 
					$('#account-setting-message img').attr('src', 'img/invalid-input.png');

		if (_changePasswordVisible)
		{
			hideChangePassword(function()
			{
				showResult();
			});
		}
		else
		{
			hideUploadIcon(function()
			{
				showResult();
			});
		}

		function showResult()
		{
			$('#account-setting-message-container').show().animate(
			{
				top: '364px'
			}, 500, function()
			{
				setTimeout(function()
				{
					hideAccountSettingMessage(false);
				}, 2000);
			});
		};
	};

	function hideAccountSettingMessage(hideRightAway)
	{
		if (hideRightAway)
		{
			$('#account-setting-message-container').hide();
		}

		$('#account-setting-message-container').animate(
		{
			top: '319px'
		}, 500, function()
		{
			$(this).hide();
		});
	};

	function uploadIconClickHandler()
	{
		$('#upload-icon-submit').click(function()
		{
			var URL = $('#reference-file').val();

			if (URL != '')
			{
				uploadIcon(URL);
			}
		});
	};
}