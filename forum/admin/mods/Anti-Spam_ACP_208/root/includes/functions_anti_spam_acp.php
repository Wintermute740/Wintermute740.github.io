<?php
/***************************************************************************
 *                  functions_anti_spam_acp.php
 * 			 -------------------
 *   copyright	: (C) 2007 EXreaction
 *   email		: exreaction@lithiumstudios.org
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

/*
* ignore
*/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function main_profile_fields($HTTP_POST_VARS)
{
	/*
	* profile fields and $HTTP_POST_VARS variable array
	* first field is the name of it(used in the template switches)
	* second is the post variable variable name(what gets submitted when the user submits the page)
	*/
	$profile_fields = array(
		'icq'	=> $HTTP_POST_VARS['icq'],
		'aim'	=> $HTTP_POST_VARS['aim'],
		'msn'	=> $HTTP_POST_VARS['msn'],
		'yim'	=> $HTTP_POST_VARS['yim'],
		'web'	=> $HTTP_POST_VARS['website'],
		'loc'	=> $HTTP_POST_VARS['location'],
		'occ'	=> $HTTP_POST_VARS['occupation'],
		'int'	=> $HTTP_POST_VARS['interests'],
		'sig'	=> $HTTP_POST_VARS['signature']
		);

	return $profile_fields;
}

function admin_profile_fields()
{
	/*
	* profile fields and lang variable array
	* first field is the name of it(used in the database for this mod ex, 'icq' would be put in: 'as_acp_icq')
	* second is the lang variable name(the part between the '' in the $lang array, like 'ICQ' for: '$lang['ICQ']')
	* make sure you add the two rows in the phpbb_config table when adding a field as well
	*/
	$profile_fields = array(
		'icq'	=> 'ICQ',
		'aim'	=> 'AIM',
		'msn'	=> 'MSNM',
		'yim'	=> 'YIM',
		'web'	=> 'Website',
		'loc'	=> 'Location',
		'occ'	=> 'Occupation',
		'int'	=> 'Interests',
		'sig'	=> 'Signature'
		);

	return $profile_fields;
}

function admin_sync_profile_fields()
{
	/*
	* profile fields and database variable array
	* first field is the name of it(used in the database for this mod ex, 'icq' would be put in: 'as_acp_icq')
	* second is the name of the database variable in the users table(like user_icq, user_website, user_from, user_sig, etc)
	*/
	$profile_fields = array(
		'icq'	=> 'user_icq',
		'aim'	=> 'user_aim',
		'msn'	=> 'user_msnm',
		'yim'	=> 'user_yim',
		'web'	=> 'user_website',
		'loc'	=> 'user_from',
		'occ'	=> 'user_occ',
		'int'	=> 'user_interests',
		'sig'	=> 'user_sig'
		);

	return $profile_fields;
}

function get_ip() // Gets the users IP address
{
	if (isSet($_SERVER))
	{
		if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (isSet($_SERVER["HTTP_CLIENT_IP"]))
		{
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else
		{
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	}
	else
	{
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
		{
			$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
		}
		elseif ( getenv( 'HTTP_CLIENT_IP' ) )
		{
			$realip = getenv( 'HTTP_CLIENT_IP' );
		}
		else
		{
			$realip = getenv( 'REMOTE_ADDR' );
		}
	}
	return $realip;
}

function send_email($triggers, $username, $user_email, $user_ip, $notice)
{
	global $board_config, $lang, $phpbb_root_path, $phpEx;

	// For the preg_replace done on $triggers
	$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
	$unhtml_specialchars_replace = array('>', '<', '"', '&');

	$email = explode(",", $board_config['as_acp_email_for_spam'], 2);
	$address = array_shift($email);
	$bcc = implode(",", $email);

	include($phpbb_root_path . 'includes/emailer.' . $phpEx);
	$emailer = new emailer($board_config['smtp_delivery']);
	$emailer->from($board_config['board_email']);
	$emailer->replyto($board_config['board_email']);
	$emailer->use_template('admin_spam_notification');
	$emailer->email_address($address);
	$emailer->bcc($bcc);
	$emailer->set_subject($lang['Spam_Attempt'] . $board_config['sitename']);

	$triggers = str_replace("\'", "'", $triggers);
	$triggers = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $triggers);
	$triggers = str_replace("%end_of_line%", "\r\n", $triggers);

	$emailer->assign_vars(array(
		'NOTICE'			=> $notice,
		'SITENAME'			=> $board_config['sitename'], 
		'USERNAME'			=> $username,
		'IP'				=> $user_ip,
		'EMAIL'				=> $user_email,
		'TRIGGERS'			=> $triggers)
		);

	$emailer->send();
	$emailer->reset();
}

function log_spam($triggers, $username, $user_id, $email, $location, $notice = '') // Logs data to spam table
{
	global $db, $board_config;

	$time = time();
	$user_id = ($user_id == 0) ? -1 : $user_id;
	$ip_address = get_ip();
	$location = str_replace("'", "\'", $location);
	$triggers = trim(htmlspecialchars($triggers));
	$triggers = stripslashes($triggers);
	$triggers = str_replace("'", "\'", $triggers);
	$log_triggers = str_replace('%end_of_line%', '<br/>', $triggers);
	$sql = 'INSERT INTO ' . SPAM_LOG_TABLE . " (log_time, username, user_id, user_ip, user_email, location, log_triggers) 
				VALUES ('$time', '$username', '$user_id', '$ip_address', '$email', '$location', '$log_triggers')";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update log table.");
	}
	
	if ( ($board_config['as_acp_email_for_spam'] != '') && ($board_config['as_acp_notify_on_spam'] == '1') )
	{
		send_email($triggers, $username, $email, $ip_address, $notice);
	}
}

function check_version() // Checks the version to see if it is the latest
{
	global $board_config, $lang;

	if (!$board_config['as_acp_check_version'])
	{
		return '<p style="color:red">' . $lang['version_check_disabled'] . '</p>';
	}

	$errno = 0;
	$errstr = $version_info = '';

	if ($fsock = @fsockopen('www.lithiumstudios.org', 80, $errno, $errstr, 5))
	{
		@fputs($fsock, "GET /updatecheck/anti_spam_acp_version.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.lithiumstudios.org\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$version .= @fread($fsock, 1024);
			}
			else
			{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);

		$version = explode("\n", $version);
		$version = implode(".", $version);

		if ($version == $board_config['as_acp_version'])
		{
			$version_info = '<p style="color:green">' . $lang['AS_ACP_up_to_date'] . '</p>';
		}
		else
		{
			$version_info = '<p style="color:red">' . $lang['AS_ACP_not_up_to_date'];
			$version_info .= '<br />' . sprintf($lang['AS_ACP_Latest_Version'], $version) . ' ' . sprintf($lang['AS_ACP_Current_Version'], $board_config['as_acp_version']) . '</p>';
		}
	}
	else
	{
		if ($errstr)
		{
			$version_info = '<p style="color:red">' . sprintf($lang['Connect_socket_error'], $errstr) . '</p>';
		}
		else
		{
			$version_info = '<p>' . $lang['Socket_functions_disabled'] . '</p>';
		}
	}

	return $version_info;
}

function num_check($num) // a simple number check to make sure the number is in operating parameters(for the post count check)
{
	if ( ($num >= 1) && ($num <= 9999) )
	{
		return(true);
	}
	else
	{
		return(false);
	}
}

function delete_topics($user_id) // Delete all topics and related info by X user id
{
	global $db, $phpbb_root_path, $phpEx;

	include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

	// Select all topic ID's
	$topic_sql = 'SELECT topic_id, forum_id FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id;
	if (!$topic_result = $db->sql_query($topic_sql))
	{
		message_die(GENERAL_ERROR, 'Could not select topic info', '', __LINE__, __FILE__, $topic_sql);
	}

	while($topic_row = $db->sql_fetchrow($topic_result))
	{
		// Select post ID's from the topics
		$post_sql = 'SELECT post_id, forum_id FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_row['topic_id'];
		if (!$post_result = $db->sql_query($post_sql))
		{
			message_die(GENERAL_ERROR, 'Could not select post info', '', __LINE__, __FILE__, $post_sql);
		}

		while($post_row = $db->sql_fetchrow($post_result))
		{
			// Delete the posts_text
			$delete_sql = 'DELETE FROM ' . POSTS_TEXT_TABLE . ' WHERE post_id = ' . $post_row['post_id'];
			if (!$delete_result = $db->sql_query($delete_sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete post text info', '', __LINE__, __FILE__, $delete_sql);
			}

			// Delete the search match
			$delete_sql = 'DELETE FROM ' . SEARCH_MATCH_TABLE . ' WHERE post_id = ' . $post_row['post_id'];
			if (!$delete_result = $db->sql_query($delete_sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete post search info', '', __LINE__, __FILE__, $delete_sql);
			}
		}

		// Delete the posts
		$delete_sql = 'DELETE FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_row['topic_id'];
		if (!$delete_result = $db->sql_query($delete_sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete post info', '', __LINE__, __FILE__, $delete_sql);
		}

		// Delete the topics watch
		$delete_sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . ' WHERE topic_id = ' . $topic_row['topic_id'];
		if (!$delete_result = $db->sql_query($delete_sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete topic watch info', '', __LINE__, __FILE__, $delete_sql);
		}

		// Get the poll ID's
		$vote_sql = 'SELECT vote_id FROM ' . VOTE_DESC_TABLE . ' WHERE topic_id = ' . $topic_row['topic_id'];
		if (!$vote_result = $db->sql_query($vote_sql))
		{
			message_die(GENERAL_ERROR, 'Could not select vote info', '', __LINE__, __FILE__, $vote_sql);
		}

		while($vote_row = $db->sql_fetchrow($vote_result))
		{
			// Delete the poll results
			$delete_sql = 'DELETE FROM ' . VOTE_RESULTS_TABLE . ' WHERE vote_id = ' . $vote_row['vote_id'];
			if (!$delete_result = $db->sql_query($delete_sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete vote results info', '', __LINE__, __FILE__, $delete_sql);
			}

			// Delete the user vote info
			$delete_sql = 'DELETE FROM ' . VOTE_USERS_TABLE . ' WHERE vote_id = ' . $vote_row['vote_id'];
			if (!$delete_result = $db->sql_query($delete_sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete user vote info', '', __LINE__, __FILE__, $delete_sql);
			}
		}

		// Delete the polls
		$delete_sql = 'DELETE FROM ' . VOTE_DESC_TABLE . ' WHERE topic_id = ' . $topic_row['topic_id'];
		if (!$delete_result = $db->sql_query($delete_sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete vote info', '', __LINE__, __FILE__, $delete_sql);
		}
	}

	// Delete the topics
	$delete_sql = 'DELETE FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id;
	if (!$delete_result = $db->sql_query($delete_sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete topic info', '', __LINE__, __FILE__, $delete_sql);
	}

	// Resync
	sync('all forums');
}

function delete_posts($user_id) // Delete all posts and related info by X user id
{
	global $db, $phpbb_root_path, $phpEx;

	include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

	$topic_post_count_changed = array(); // to sync the reply counts

	// Select post ID's
	$post_sql = 'SELECT p.post_id, t.topic_last_post_id, t.topic_id FROM ' . POSTS_TABLE . ' p, ' . TOPICS_TABLE . ' t
					WHERE p.poster_id = ' . $user_id . '
					AND t.topic_id = p.topic_id';
	if (!$post_result = $db->sql_query($post_sql))
	{
		message_die(GENERAL_ERROR, 'Could not select post info', '', __LINE__, __FILE__, $post_sql);
	}

	while($post_row = $db->sql_fetchrow($post_result))
	{
		if (!in_array($post_row['topic_id'], $topic_post_count_changed))
		{
			$topic_post_count_changed[] = $post_row['topic_id'];
		}

		// Delete post texts
		$delete_sql = 'DELETE FROM ' . POSTS_TEXT_TABLE . ' WHERE post_id = ' . $post_row['post_id'];
		if (!$delete_result = $db->sql_query($delete_sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete post text info', '', __LINE__, __FILE__, $delete_sql);
		}

		// Delete search matchs
		$delete_sql = 'DELETE FROM ' . SEARCH_MATCH_TABLE . ' WHERE post_id = ' . $post_row['post_id'];
		if (!$delete_result = $db->sql_query($delete_sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete post search info', '', __LINE__, __FILE__, $delete_sql);
		}

		if ($post_row['topic_last_post_id'] == $post_row['post_id'])
		{
			$last_post_sql = 'SELECT post_id FROM ' . POSTS_TABLE . '
									WHERE topic_id = \'' . $post_row['topic_id'] . '\'
									AND poster_id != \'' . $user_id . '\'
										ORDER BY post_time ASC
											LIMIT 1';
			if (!$last_post_result = $db->sql_query($last_post_sql))
			{
				message_die(GENERAL_ERROR, 'Could not select last post info', '', __LINE__, __FILE__, $last_post_sql);
			}

			$last_post_row = $db->sql_fetchrow($last_post_result);

			$update_sql = 'UPDATE ' . TOPICS_TABLE . ' SET topic_last_post_id = \'' . $last_post_row['post_id'] . '\' WHERE topic_id = \'' . $post_row['topic_id'] . '\'';
			if (!$update_result = $db->sql_query($update_sql))
			{
				message_die(GENERAL_ERROR, 'Could not update last post info', '', __LINE__, __FILE__, $update_sql);
			}
		}
	}

	// Delete posts
	$delete_sql = 'DELETE FROM ' . POSTS_TABLE . ' WHERE poster_id = ' . $user_id;
	if (!$delete_result = $db->sql_query($delete_sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete post info', '', __LINE__, __FILE__, $delete_sql);
	}

	// Update topic replies value
	foreach ($topic_post_count_changed as $topic_id)
	{
		$count_sql = 'SELECT count(post_id) AS total FROM ' . POSTS_TABLE . ' WHERE topic_id = \'' . $topic_id . '\'';
		if (!$count_result = $db->sql_query($count_sql))
		{
			message_die(GENERAL_ERROR, 'Could not count topic replies', '', __LINE__, __FILE__, $count_sql);
		}
		$replies = $db->sql_fetchrow($count_result);

		$update_sql = 'UPDATE ' . TOPICS_TABLE . ' SET topic_replies = \'' . ($replies['total'] - 1) . '\' WHERE topic_id = \'' . $topic_id . '\'';
		if (!$update_result = $db->sql_query($update_sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topic replies info', '', __LINE__, __FILE__, $update_sql);
		}
	}

	// Resync
	sync('all forums');
}

function db_updates() // Check if all the fields in the database exist, if not automatically add them
{
	// Note:
	// postgresql and msaccess have not been tested, the way it is setup is just a guess by me, I got it by looking at the schema of the install and upgrade parts of phpBB2 and phpBB3
	// mssql has been tested by at least 1 other user at this point, may not work in all setups but it works better than it did before ;-)

	global $board_config, $db, $lang;

	// USERS: Do Not Change!
	$version = '2.0.8';

	if ( (!array_key_exists('as_acp_version', $board_config)) || ($board_config['as_acp_version'] != $version) || (!array_key_exists('as_acp_version_db', $board_config)) || ($board_config['as_acp_version_db'] != $version) )
	{
		// Config Table
		$db_fields = array(
			'as_acp_icq'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_icq', 'reg off')",
			'as_acp_aim'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_aim', 'reg off')",
			'as_acp_msn'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_msn', 'reg off')",
			'as_acp_yim'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_yim', 'reg off')",
			'as_acp_web'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_web', 'reg off')",
			'as_acp_loc'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_loc', 'reg off')",
			'as_acp_occ'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_occ', 'reg off')",
			'as_acp_int'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_int', 'reg off')",
			'as_acp_sig'					=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_sig', 'reg off')",
			'as_acp_icq_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_icq_post', '10')",
			'as_acp_aim_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_aim_post', '10')",
			'as_acp_msn_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_msn_post', '10')",
			'as_acp_yim_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_yim_post', '10')",
			'as_acp_web_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_web_post', '10')",
			'as_acp_loc_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_loc_post', '10')",
			'as_acp_occ_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_occ_post', '10')",
			'as_acp_int_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_int_post', '10')",
			'as_acp_sig_post'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_sig_post', '10')",
			'as_acp_notify_on_spam'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_notify_on_spam', '0')",
			'as_acp_email_for_spam'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_email_for_spam', '')",
			'as_acp_version'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_version', '" . $version . '\')',
			'as_acp_check_version'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_check_version', '1')",
			'as_acp_posting_url'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_posting_url', 'post count')",
			'as_acp_posting_url_post'		=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_posting_url_post', '1')",
			'as_acp_hide_inactive'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_hide_inactive', '1')",
			'as_acp_log_captcha'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_log_captcha', '1')",
			'as_acp_log_profile'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_log_profile', '1')",
			'as_acp_log_message_posting'	=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_log_message_posting', '1')",
			'as_acp_spam_log_pagination'	=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_spam_log_pagination', '12')",
			'as_acp_captcha'				=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_captcha', '1')",
			'as_acp_captcha_noise'			=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_captcha_noise', '0')",
			'as_acp_captcha_case_sensative'	=> 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_captcha_case_sensative', '1')",
			);

		foreach($db_fields as $config_value => $insert_sql)
		{
			if (!array_key_exists($config_value, $board_config))
			{
				if (!($result = $db->sql_query($insert_sql)))
				{
					message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], $config_value), "", __LINE__, __FILE__, $sql);
				}
			}
		}


		// Spam Log Table
		if ( !defined('SPAM_LOG_TABLE') ) // check to make sure the user did the edit to constants.php.  For some reason many people miss this part...
		{
			message_die(GENERAL_ERROR, $lang['Constants_Update']);
		}

		// Try and select anything from the spam log table, if nothing is selectable that _should_ mean the table does not exist...
		$sql = 'SELECT * FROM ' . SPAM_LOG_TABLE;

		if (!($result = $db->sql_query($sql)))
		{
			switch (SQL_LAYER)
			{
				case 'mysql':
				case 'mysql4':
					$sql = 'CREATE TABLE IF NOT EXISTS ' . SPAM_LOG_TABLE . ' (
						log_id MEDIUMINT(8) NOT NULL AUTO_INCREMENT,
						log_time INT(11) NOT NULL,
						username VARCHAR(25) NOT NULL,
						user_id MEDIUMINT(8) NOT NULL,
						user_ip VARCHAR(40) NOT NULL,
						user_email VARCHAR(255) NOT NULL,
						location VARCHAR(25) NOT NULL,
						log_triggers TEXT NOT NULL,
						PRIMARY KEY (log_id)
						)';
					break;
				case 'postgresql':
					$sql = 'CREATE SEQUENCE ' . SPAM_LOG_TABLE . '_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;';

					$sql2 = 'CREATE TABLE ' . SPAM_LOG_TABLE . ' (
						log_id int4 NOT NULL AUTO_INCREMENT,
						log_time int4 NOT NULL,
						username varchar(25) NOT NULL,
						user_id int4 NOT NULL,
						user_ip varchar(40) NOT NULL,
						user_email varchar(255) NOT NULL,
						location varchar(25) NOT NULL,
						log_triggers text NOT NULL,
						CONSTRAINT ' . SPAM_LOG_TABLE . '_pkey PRIMARY KEY (log_id)
						)';
					break;
				case 'mssql-odbc':
				case 'mssql':
					$sql = 'CREATE TABLE [' . SPAM_LOG_TABLE . "] (
						[log_id] [int] IDENTITY (1, 1) NOT NULL ,
						[log_time] [int] NOT NULL ,
						[username] [varchar] (25) NOT NULL ,
						[user_id] [int] NOT NULL ,
						[user_ip] [varchar] (40) NOT NULL ,
						[user_email] [varchar] (255) NOT NULL ,
						[location] [varchar] (25) NOT NULL ,
						[log_triggers] [text] NOT NULL ,
						) ON [PRIMARY]";
						
					$sql2 = 'ALTER TABLE [' . SPAM_LOG_TABLE . '] WITH NOCHECK ADD 
						CONSTRAINT [PK_' . SPAM_LOG_TABLE . '] PRIMARY KEY  CLUSTERED 
						(
							[log_id]
						)  ON [PRIMARY]';
					break;
				case 'msaccess':
					$sql = 'CREATE TABLE ' . SPAM_LOG_TABLE . ' (
						log_id MEDIUMINT(8) NOT NULL AUTO_INCREMENT,
						log_time INT(11) NOT NULL,
						username VARCHAR(25) NOT NULL,
						user_id MEDIUMINT(8) NOT NULL,
						user_ip VARCHAR(40) NOT NULL,
						user_email VARCHAR(255) NOT NULL,
						location VARCHAR(25) NOT NULL,
						log_triggers TEXT NOT NULL,
						PRIMARY KEY (log_id)
						)';
					break;
				default:
					die("No DB LAYER found!");
					break;
			}

			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not create Spam Log Table', "", __LINE__, __FILE__, $sql);
			}

			if ( (isset($sql2)) && (!($result = $db->sql_query($sql2))) )
			{
				message_die(GENERAL_ERROR, 'Could not create Spam Log Table pt2', "", __LINE__, __FILE__, $sql);
			}
		}

		// Confirm Table
		switch (SQL_LAYER)
		{
			case 'mysql':
			case 'mysql4':
				$sql = 'ALTER TABLE ' . CONFIRM_TABLE . " CHANGE `code` `code` CHAR(8)";
				break;
			case 'postgresql':
				$sql = 'ALTER TABLE ' . CONFIRM_TABLE . " ALTER COLUMN code varchar(8)";
				break;
			case 'mssql-odbc':
			case 'mssql':
				$sql = 'ALTER TABLE ' . CONFIRM_TABLE . ' DROP CONSTRAINT [DF_' . CONFIRM_TABLE . '_code]';
				$sql1 = 'ALTER TABLE ' . CONFIRM_TABLE . ' ALTER COLUMN code varchar(8) NOT NULL';
				$sql2 = 'ALTER TABLE ' . CONFIRM_TABLE . ' ADD CONSTRAINT [DF_' . CONFIRM_TABLE . '_code] DEFAULT (\'\') FOR code';
				break;
			case 'msaccess':
				$sql = 'ALTER TABLE ' . CONFIRM_TABLE . " ALTER COLUMN code varchar(8)";
				break;
			default:
				die("No DB LAYER found!");
			break;
		}

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not update Confirm Table', "", __LINE__, __FILE__, $sql);
		}

		if ( (isset($sql1)) && (!($result = $db->sql_query($sql1))) )
		{
			message_die(GENERAL_ERROR, 'Could not update Confirm Table pt2', "", __LINE__, __FILE__, $sql);
		}

		if ( (isset($sql2)) && (!($result = $db->sql_query($sql2))) )
		{
			message_die(GENERAL_ERROR, 'Could not update Confirm Table pt3', "", __LINE__, __FILE__, $sql);
		}

		// Update the version number
		$sql = 'UPDATE ' . CONFIG_TABLE . " SET config_value = '" . $version . "' WHERE config_name = 'as_acp_version'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], 'as_acp_version'), "", __LINE__, __FILE__, $sql);
		}

		// After we make sure everything is updated, add a new(or update) row in the DB so we do not have to go through the long check every time. ;-)
		if (!array_key_exists('as_acp_version_db', $board_config))
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . " (config_name, config_value) VALUES ('as_acp_version_db', '" . $version . "')";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], 'as_acp_version_db'), "", __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . " SET config_value = '" . $version . "' WHERE config_name = 'as_acp_version_db'";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], 'as_acp_version_db'), "", __LINE__, __FILE__, $sql);
			}
		}
	}
}

// Run the db_updates function we made above
// I know it does not need to be in a function, but it will be easier if I want to move the call to the function later.
db_updates();
?>