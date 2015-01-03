{
	this.UI_PLAYER_STATS 	= 0;
	this.UI_PLAYER_PROFILES = 1;
	this.UI_TEAM_STATS 		= 2;
	this.UI_GAME_RESULTS 	= 3;
	this.UI_ACHIEVEMENTS 	= 4;

	this.username;
	this.currentIdx;
	this.currentSeasonId;
	this.currentTableId;

	this.shouldSelectFirstRow = false;

	var scope = this;

	$(document).ready(function()
	{
		scope.username = $('#nav-bar .account .username').html();

		myAccountClickHandler();
		uploadIconClickHandler();
		logoutClickHandler();
		categoriesClickHandler();
		leftMenuClickHandler();
		rightMenuClickHandler();

		pageEventHandlers();
	});

	function pageEventHandlers()
	{
		var tableArray = ['#player-profiles-rank', '#player-profiles-record', '#player-profiles-shooting', '#player-profiles-streaks', '#player-profiles-redemption', '#player-profiles-racks', '#player-profiles-overtime', '#player-profiles-seasons'];
		var achArray = ['#a_ss', '#a_mj', '#a_tkcp', '#a_hc', '#a_snsn', '#a_ps', '#a_per', '#a_dbno', '#a_mar', '#a_fdm', '#a_ck', '#a_bb', '#a_bc', '#a_bank', '#a_skunk', '#a_sw', '#a_bd', '#a_sss', '#a_sk', '#a_mag', '#a_im', '#a_mark', '#a_sia'];
		var milestoneArray = ['#m_gp', '#m_wins', '#m_cups', '#m_bounces', '#m_rs', '#m_lch', '#m_ae'];

		$(window).scroll(function()
		{
			for (var i = 0; i < achArray.length; i++)
			{
				if (checkIfElementIsOnScreen(achArray[i]))
				{
					$(achArray[i]).addClass('onscreen');
				}
				else
				{
					$(achArray[i]).removeClass('onscreen');
				}
			}

			for (var i = 0; i < milestoneArray.length; i++)
			{
				if (checkIfElementIsOnScreen(milestoneArray[i]))
				{
					$(milestoneArray[i]).addClass('onscreen');
				}
				else
				{
					$(milestoneArray[i]).removeClass('onscreen');
				}
			}

			for (var i = 0; i < tableArray.length; i++)
			{
				if (checkIfElementIsOnScreen(tableArray[i]))
				{
					$(tableArray[i]).addClass('onscreen');
				}
				else
				{
					$(tableArray[i]).removeClass('onscreen');
				}
			}
		});
	};

	function checkIfElementIsOnScreen(elem)
	{
		if ($(elem).length)
		{
			var docViewTop = $(window).scrollTop();
		    var docViewBottom = docViewTop + $(window).height();

		    var elemTop = $(elem).offset().top;
		    var elemBottom = elemTop + $(elem).height();

		    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		}

		return false;
	};

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
					updateStatsUI(idx, 'overall', 'rank', true);

					scope.currentSeasonId = 'overall';
					scope.currentTableId = 'rank';

					if (idx == 1)
					{
						scope.shouldSelectFirstRow = true;
					}
				}
			});
		});
	};

	function leftMenuClickHandler()
	{
		$('#left-menu ul li').click(function()
		{
			scope.currentSeasonId = $(this).attr('id');

			updateStatsUI(scope.currentIdx, scope.currentSeasonId, scope.currentTableId, false);
		});
	};

	function rightMenuClickHandler()
	{
		$('#right-menu ul li').click(function()
		{
			scope.currentTableId = $(this).attr('id');

			updateStatsUI(scope.currentIdx, scope.currentSeasonId, scope.currentTableId, false);
		});
	};

	function updateStatsUI(idx, season, table, shouldLoadSideMenus)
	{
		var selector = '#stats';
		var height = Math.max(1000, ($('#stats').height() + 100));

		if (shouldLoadSideMenus)
		{
			selector = '#stats, #left-menu, #right-menu';
		}

		scope.currentIdx = idx;

		$('#stats').animate(
		{
			marginTop: '-=' + height
		}, 1000, function()
		{
			switch(idx)
			{
				case scope.UI_PLAYER_STATS:
				{
					if (shouldLoadSideMenus)
					{
						loadLeftMenu('stats/left-menu-player-stats.php');
						loadRightMenu('stats/right-menu-player-stats.php');
					}
					else
					{
						refreshLeftMenu();
						refreshRightMenu();
					}

					$('#stats').load('stats/player-stats.php?season=' + season + '&table=' + table, function()
					{
						$('#player-stats').slimtable();
						$('#stats').animate(
						{
							marginTop: '+=' + height
						}, 1000, 'easeOutBack');
					});
				}
					break;

				case scope.UI_PLAYER_PROFILES:
				{
					if (shouldLoadSideMenus)
					{
						loadLeftMenu('stats/left-menu-player-profiles.php');
						loadRightMenu('stats/right-menu-player-profiles.php');
					}
					else
					{
						refreshLeftMenu();
						refreshRightMenu();
					}

					$('#stats').load('stats/player-profiles.php?season=' + season + '&player=' + encodeURIComponent(table), function()
					{
						$('#player-profiles-rank').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-record').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-shooting').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-streaks').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-redemption').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-racks').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-overtime').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-seasons').slimtable().next($('.slimtable-paging-div')).hide();
						$('#player-profiles-games').slimtable();
						$('.dial').knob({readOnly: true});
						$('#stats').animate(
						{
							marginTop: '+=' + height
						}, 1000, 'easeOutBack', function()
						{
							$(window).scroll();
						});
					});
				}
					break;

				case scope.UI_TEAM_STATS:
				{
					if (shouldLoadSideMenus)
					{
						loadLeftMenu('stats/left-menu-team-stats.php');
						loadRightMenu('stats/right-menu-team-stats.php');
					}
					else
					{
						refreshLeftMenu();
						refreshRightMenu();
					}

					$('#stats').load('stats/team-stats.php', function()
					{
						$('#team-stats').slimtable();
						$('#stats').animate(
						{
							marginTop: '+=' + height
						}, 1000, 'easeOutBack');
					});
				}
					break;

				case scope.UI_GAME_RESULTS:
				{
					if (shouldLoadSideMenus)
					{
						loadLeftMenu('stats/left-menu-game-results.php');
						loadRightMenu('stats/right-menu-game-results.php');
					}
					else
					{
						refreshLeftMenu();
						refreshRightMenu();
					}

					$('#stats').load('stats/game-results.php?season=' + season, function()
					{
						$('#game-results').slimtable();
						$('#stats').animate(
						{
							marginTop: '+=' + height
						}, 1000, 'easeOutBack');
					});
				}
					break;

				case scope.UI_ACHIEVEMENTS:
				{
					if (shouldLoadSideMenus)
					{
						loadLeftMenu('stats/left-menu-achievements.php');
						loadRightMenu('stats/right-menu-achievements.php');
					}
					else
					{
						refreshLeftMenu();
						refreshRightMenu();
					}

					$('#stats').load('stats/achievements.php?ach=' + encodeURIComponent(table), function()
					{
						$('#stats').animate(
						{
							marginTop: '+=' + height
						}, 1000, 'easeOutBack', function()
						{
							$('.fill').each(function(index)
							{
								var elemWidth = $(this).width();

								$(this).width(0);
								$(this).animate({width: elemWidth, opacity: 1}, 2000, 'easeOutQuad');
							});
						});
					});
				}
					break;
			}
		});

		function loadLeftMenu(path)
		{
			$('#left-menu').animate(
			{
				left: '-240px'
			}, 500, function()
			{
				$('#left-menu').load(path, function()
				{
					$('#left-menu ul li').each(function(idx, li)
					{
						if ($(this).attr('id') == scope.currentSeasonId)
						{
							$(this).addClass('active');
						}
					});

					$('#left-menu').animate(
					{
						left: 0
					}, 500, function()
					{
						leftMenuClickHandler();
					});
				});
			});
		};

		function loadRightMenu(path)
		{
			$('#right-menu').animate(
			{
				right: '-240px'
			}, 500, function()
			{
				$('#right-menu').load(path, function()
				{
					$('#right-menu ul li').each(function(idx, li)
					{
						if (($(this).attr('id') == scope.currentTableId) || (idx == 0 && scope.shouldSelectFirstRow))
						{
							$(this).addClass('active');
							scope.shouldSelectFirstRow = false;
						}
					});

					$('#right-menu').animate(
					{
						right: 0
					}, 500, function()
					{
						rightMenuClickHandler();
					});
				});
			});
		};

		function refreshLeftMenu()
		{
			$('#left-menu ul li').each(function(idx, li)
			{
				$(this).removeClass('active');

				if ($(this).attr('id') == scope.currentSeasonId)
				{
					$(this).addClass('active');
				}
			});
		};

		function refreshRightMenu()
		{
			$('#right-menu ul li').each(function(idx, li)
			{
				$(this).removeClass('active');

				if ($(this).attr('id') == scope.currentTableId)
				{
					$(this).addClass('active');
				}
			});
		};
	};
}