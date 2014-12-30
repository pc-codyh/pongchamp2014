{
	DATA_ID 		= 0;
	DATA_USERNAME 	= 1;
	DATA_PASSWORD 	= 2;
	DATA_ICON_URL 	= 3;

	this.loginVisible 		= false;
	this.registerVisible 	= false;

	this.userData 						= null;
	this.checkForValidUsernameID 		= -1;
	this.checkForValidPasswordID		= -1;
	this.checkForValidConfirmPasswordID = -1;
	this.validUsername 					= false;
	this.validPassword 					= false;
	this.validConfirmPassword 			= false;

	// Signed in user data //
	this.userID = -1;

	var scope = this;

	$(document).ready(function()
	{
		getUserData();
		modalClickHandlers();
		modalActionClickHandlers();

		introAnimations();
	});

	function introAnimations()
	{
		$('#landing .inner').animate(
		{
			marginTop: '-160px',
			opacity: 1
		}, 1200, 'easeOutBack', function()
		{
			$('#landing h1').animate(
			{
				marginRight: 0,
				opacity: 1
			}, 1200, 'easeOutBack');

			$('#landing .sub').animate(
			{
				marginLeft: 0,
				opacity: 1
			}, 1200, 'easeOutBack', function()
			{
				$('#landing .buttons, #components, #download, #footer').fadeIn(2400);
			});
		});
	};

	function getUserData()
	{
		request = $.ajax(
	    {
	        url: 'get-logins.php',
	        type: 'get',
	        data: null
	    });

	    request.done(function (response, textStatus, jqXHR)
	    {
	    	scope.userData = $.parseJSON(response);

	    	checkForValidUsername();
	    	checkForValidPassword();
	    	checkForValidConfirmPassword();
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

	function checkForValidUsername()
	{
		var username 		= '';
		var msg				= '';
		var validLength 	= false;
		var foundMatch 		= false;
		var validUsername  	= false;
		var textWasEntered 	= false;

		scope.checkForValidUsernameID = setInterval(function()
		{
			foundMatch 	= false;

			for (var i = 0; i < scope.userData.length; i++)
			{
				username 		= scope.userData[i][DATA_USERNAME];
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
				scope.validUsername = false;
				msg = 'Username must be at least six characters long';
			}
			else if (foundMatch)
			{
				scope.validUsername = false;
				msg = 'Username already exists';
			}
			else
			{
				scope.validUsername = true;
				msg = '';
			}

			if (textWasEntered)
			{
				(scope.validUsername) ? $('#register-username-valid').removeClass('invalid-input') :
										$('#register-username-valid').addClass('invalid-input');

				$('#register-username-valid').show();
				
				if ($('#register-username').is(':focus'))
				{
					$('#modal .register .message').html(msg);
				}
			}
		}, 250);
	}

	function checkForValidPassword()
	{
		var msg				= '';
		var validLength 	= false;
		var validPassword  	= false;
		var textWasEntered 	= false;

		scope.checkForValidPasswordID = setInterval(function()
		{
			enteredPassword = $('#register-password').val();

			if (enteredPassword.length > 0)
			{
				textWasEntered = true;
			}

			validLength = (enteredPassword.length >= 6) ? true : false;

			if (!validLength)
			{
				scope.validPassword = false;
				msg = 'Password must be at least six characters long';
			}
			else
			{
				scope.validPassword = true;
				msg = '';
			}

			if (textWasEntered)
			{
				(scope.validPassword) ? $('#register-password-valid').removeClass('invalid-input') :
										$('#register-password-valid').addClass('invalid-input');

				$('#register-password-valid').show();

				if ($('#register-password').is(':focus'))
				{
					$('#modal .register .message').html(msg);
				}
			}
		}, 250);
	}

	function checkForValidConfirmPassword()
	{
		var msg				= '';
		var valid 		 	= false;
		var validPassword  	= false;
		var textWasEntered 	= false;

		scope.checkForValidConfirmPasswordID = setInterval(function()
		{
			enteredConfirmPassword = $('#register-confirm-password').val();

			if (enteredConfirmPassword.length > 0)
			{
				textWasEntered = true;
			}

			valid = (enteredConfirmPassword == $('#register-password').val());

			if (!valid || (enteredConfirmPassword.length < 6))
			{
				scope.validConfirmPassword = false;

				if (!valid)
				{
					msg = 'Passwords do not match';
				}
				else
				{
					msg = 'Password must be at least six characters long';
				}
			}
			else
			{
				scope.validConfirmPassword = true;
				msg = '';
			}

			if (textWasEntered)
			{
				(scope.validConfirmPassword) ? $('#register-confirm-password-valid').removeClass('invalid-input') :
											   $('#register-confirm-password-valid').addClass('invalid-input');

				$('#register-confirm-password-valid').show();

				if ($('#register-confirm-password').is(':focus'))
				{
					$('#modal .register .message').html(msg);
				}
			}
		}, 250);
	}

	function modalClickHandlers()
	{
		$('#login, #modal .register a').click(function()
		{
			hideModal(function()
			{
				scope.loginVisible 		= true;
				scope.registerVisible 	= false;

				$('#modal .register').hide();
				$('#modal .login').show();

				$('#modal').fadeIn(500);

				setTimeout(function()
				{
				    $('#login-username').focus();
				}, 0);
			});
		});

		$('#register, #modal .login a').click(function()
		{
			hideModal(function()
			{
				scope.registerVisible 	= true;
				scope.loginVisible 		= false;

				$('#modal .login').hide();
				$('#modal .register').show();

				$('#modal').fadeIn(500);

				setTimeout(function()
				{
				    $('#register-username').focus();
				}, 0);
			});
		});

		$('#modal .close-button').click(function()
		{
			hideModal(function(){});
		});
	}

	function modalActionClickHandlers()
	{
		$('#login-submit').click(function()
		{
			var username = $('#login-username').val();
			var password = $('#login-password').val();

			if ((username.length > 0) && (password.length > 0))
			{
				login(username, password);
			}
			else
			{
				$('#modal .login .message').html('You must enter a username and a password');
			}
		});

		$('#register-submit').click(function()
		{
			var username = $('#register-username').val();
			var password = $('#register-password').val();
			var confirmPassword = $('#register-confirm-password').val();

			if ((username.length > 0) && (password.length > 0) && (confirmPassword.length > 0))
			{
				register(username, password);
			}
			else
			{
				$('#modal .register .message').html('You must complete all fields');
			}
		});
	}

	function hideModal(callback)
	{
		scope.loginVisible 		= false;
		scope.registerVisible 	= false;

		$('#modal').fadeOut(500, function()
		{
			callback();
		});
	}

	function login(username, password)
	{
		var validLogin = false;
		var user, pass, msg;

		for (var i = 0; i < scope.userData.length; i++)
		{
			user = scope.userData[i][DATA_USERNAME];
			pass = scope.userData[i][DATA_PASSWORD];

			if ((user.toLowerCase() == username.toLowerCase()) && (pass == password))
			{
				scope.userID = scope.userData[i][DATA_ID];
				validLogin 	= true;

				break;
			}
		}

		if (validLogin)
		{
			advanceToMembersArea(username);
		}
		else
		{
			msg = 'Username and/or password is incorrect';
		}

		$('#modal .login .message').html(msg);
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
		    		advanceToMembersArea(username);
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

	function checkForValidRegistration()
	{
		return (scope.validUsername && scope.validPassword && scope.validConfirmPassword);
	};

	function advanceToMembersArea(username)
	{
		$('#stats-username').val(username);
		$('#stats-form').submit();
	};
}