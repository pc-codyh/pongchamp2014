{
	this.UI_PLAYER_STATS 	= 0;
	this.UI_PLAYER_PROFILES = 1;
	this.UI_TEAM_STATS 		= 2;
	this.UI_TEAM_PROFILES 	= 3;
	this.UI_GAME_RESULTS 	= 4;
	this.UI_HEAD_TO_HEAD 	= 5;
	this.UI_ACHIEVEMENTS 	= 6;

	this.username;

	var scope = this;

	$(document).ready(function()
	{
		scope.username = $('#nav-bar .account .username').html();

		myAccountClickHandler();
		uploadIconClickHandler();
		logoutClickHandler();
		categoriesClickHandler();
	});

	function myAccountClickHandler()
	{
		$('#my-account, #nav-bar .icon').click(function()
		{
			$('#nav-bar .account-info').toggleClass('account-info-expanded');
		});
	};

	function uploadIconClickHandler()
	{
		$('#nav-bar .account-info .footer').click(function()
		{
			$('#upload-icon').fadeIn(500);

			setTimeout(function()
			{
			    $('#upload-icon-url').focus();
			}, 0);
		});

		$('#upload-icon .content .close-button').click(function()
		{
			$('#upload-icon').fadeOut(500);
		});

		$('#upload-icon-submit').click(function()
		{
			uploadIcon($('#upload-icon-url').val());
			$('#upload-icon').fadeOut(500);
		});
	};

	function uploadIcon(iconURL)
	{
		request = $.ajax(
	    {
	        url: 'upload-icon.php',
	        type: 'post',
	        data: {'username' : scope.username, 'icon_url' : iconURL}
	    });

	    request.done(function (response, textStatus, jqXHR)
	    {
	    	if (response == 1)
	    	{
	    		setIconUrl(iconURL);
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

	function setIconUrl(url)
	{
		$('#nav-bar .icon img').attr('src', url);
	};

	function logoutClickHandler()
	{
		$('#my-logout').click(function()
		{
			window.open('web-logout.php', '_self');
		});
	};

	function categoriesClickHandler()
	{
		$('#nav-bar .categories li').click(function()
		{
			var categories = $('#nav-bar .categories li');
			var active = $(this);

			categories.each(function(idx, li)
			{
				$(this).removeClass('active');
			});

			$(this).addClass('active');

			categories.each(function(idx, li)
			{
				if ($(this).hasClass('active'))
				{
					updateStatsUI(idx);
				}
			});
		});
	};

	function updateStatsUI(idx)
	{
		switch(idx)
		{
			case scope.UI_PLAYER_STATS:
			{
				$('#stats').load('stats/player-stats.php');
			}
				break;

			case scope.UI_PLAYER_PROFILES:
			{
				$('#stats').load('stats/player-profiles.php');
			}
				break;

			case scope.UI_TEAM_STATS:
			{
				$('#stats').load('stats/team-stats.php');
			}
				break;

			case scope.UI_TEAM_PROFILES:
			{
				$('#stats').load('stats/team-profiles.php');
			}
				break;

			case scope.UI_GAME_RESULTS:
			{
				$('#stats').load('stats/game-results.php');
			}
				break;

			case scope.UI_HEAD_TO_HEAD:
			{
				$('#stats').load('stats/head-to-head.php');
			}
				break;

			case scope.UI_ACHIEVEMENTS:
			{
				$('#stats').load('stats/achievements.php');
			}
				break;
		}
	};
}