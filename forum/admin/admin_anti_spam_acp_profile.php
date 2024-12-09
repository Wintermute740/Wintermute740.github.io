<?php
/***************************************************************************
 *      admin_anti_spam_acp_profile.php
 *			-------------------
 *   copyright	: (C) 2006 EXreaction
 *   email		: exreaction@lithiumstudios.org
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

define('IN_PHPBB', 1);
global $board_config, $phpEx, $userdata;
$phpbb_root_path = './../';

if(!empty($setmodules))
{
	/*
	* include the language file for the module name
	*/
	$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];
	if (@file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx) )
	{
		include($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
	}
	else if (@file_exists($phpbb_root_path . 'language/lang_english/lang_anti_spam_acp.' . $phpEx) )
	{
		include($phpbb_root_path . 'language/lang_english/lang_anti_spam_acp.' . $phpEx);
	}
	else
	{
		die("Language File Missing");
	}

	$filename = basename(__FILE__);
	$module['Anti_Spam']['Profile_Options'] = $filename;
	return;
}

require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

/*
* include the language file
*/
$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];
if (@file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
}
else if (@file_exists($phpbb_root_path . 'language/lang_english/lang_anti_spam_acp.' . $phpEx) )
{
	include($phpbb_root_path . 'language/lang_english/lang_anti_spam_acp.' . $phpEx);
}
else
{
	message_die(GENERAL_MESSAGE, 'Anti-Spam ACP Mod language file does not exist: language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
}

/*
* include the functions file
*/
require($phpbb_root_path . 'includes/functions_anti_spam_acp.' . $phpEx);

$version_info = check_version(); // function is in includes/functions_anti_spam_acp.php

$profile_fields = admin_profile_fields(); // function is in includes/functions_anti_spam_acp.php

$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}
else
{
	$error = false;
	
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ( (isset($HTTP_POST_VARS['submit'])) || (isset($HTTP_POST_VARS['sync'])) )
		{
			foreach ($profile_fields as $field => $lang_var)
			{
				if ( ($config_name == 'as_acp_' . $field . '_post') && (num_check($new['as_acp_' . $field . '_post']) == false) )
				{
					$error = true;
					$new['as_acp_' . $field . '_post'] = $row['config_value'];
				}
			}

			if (isset($HTTP_POST_VARS['sync']))
			{
				$board_config[$config_name] = $new[$config_name]; // update the $board_config if the user decided to sync the board(otherwise it doesn't do the syncs if changes were made to the settings
			}

			if ( ($config_name != 'sitename') && ($config_name != 'site_desc') ) // once in a while we get a very strange bug otherwise...so just skip these areas because we don't even change them
			{
				$sql = "UPDATE " . CONFIG_TABLE . " SET
					config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
					WHERE config_name = '$config_name'";
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], $config_name), "", __LINE__, __FILE__, $sql);
				}
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		if (!$error)
		{
			$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp_profile.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['AS_ACP_Update_Error'] . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp_profile.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}
	else if (isset($HTTP_POST_VARS['sync']))
	{
		$sql = 'SELECT * FROM ' . USERS_TABLE . '
					WHERE user_level = 0
						ORDER BY user_id ASC';
		if(!$result = $db->sql_query($sql))
		{
			message_die(CRITICAL_ERROR, "Could not query user table", "", __LINE__, __FILE__, $sql);
		}
		else
		{
			$sync_profile_fields = admin_sync_profile_fields(); // function is in includes/functions_anti_spam_acp.php

			while( $row = $db->sql_fetchrow($result) )
			{
				$update = false; // don't do the update unless we have to...if nothing gets changed, don't run extra querys.
				$update_sql = 'UPDATE ' . USERS_TABLE . ' SET ';

				foreach($sync_profile_fields as $field => $db_column)
				{
					if ( ($board_config['as_acp_' . $field] == 'off') || ( ($board_config['as_acp_' . $field] == 'post count')  && ($row['user_posts'] < $board_config['as_acp_' . $field . '_post']) ) )
					{
						if ($row[$db_column] != '')
						{
							$update_sql .= $db_column . ' = \'\', ';
							$update = true;
						}
					}
				}

				if ($update)
				{
					$update_sql = substr($update_sql, 0, (strlen($update_sql) - 2)); // to remove the last comma and space
					$update_sql .= ' WHERE user_id = ' . $row['user_id'];
					if(!$update_result = $db->sql_query($update_sql))
					{
						message_die(CRITICAL_ERROR, "Error syncing the users table", "", __LINE__, __FILE__, $update_sql);
					}
				}
			}
		}

		if (!$error)
		{
			$message = $lang['Config_updated_users_synced'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp_profile.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['AS_ACP_Update_Error_synced'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp_profile.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}
}

$template->set_filenames(array(
	'body' => 'admin/anti_spam_acp_profile.tpl')
);

foreach ($profile_fields as $field => $lang_var)
{
	$template->assign_block_vars('field_row', array(
		'L_TITLE'			=> $lang[$lang_var],
		'NAME'				=> 'as_acp_' . $field,
		'OFF'				=> ( $new['as_acp_' . $field] == 'off' ) ? "checked=\"checked\"" : "",
		'REG_OFF'			=> ( $new['as_acp_' . $field] == 'reg off' ) ? "checked=\"checked\"" : "",
		'POST_COUNT'		=> ( $new['as_acp_' . $field] == 'post count' ) ? "checked=\"checked\"" : "",
		'POSTS'				=> $new['as_acp_' . $field . '_post'],
		'ON'				=> ( $new['as_acp_' . $field] == 'on' ) ? "checked=\"checked\"" : "",
		'REQUIRED'			=> ( $new['as_acp_' . $field] == 'required' ) ? "checked=\"checked\"" : "")
		);
}

$template->assign_vars(array(
	'L_ANTI_SPAM_ACP'				=> $lang['Anti_Spam_ACP'],
	'L_ANTI_SPAM_ACP_CREATED_BY'	=> $lang['Anti_Spam_ACP_Created_By'],
	'VERSION_INFO'					=> $version_info,

	'S_ACTION'						=> append_sid("admin_anti_spam_acp_profile.$phpEx"),

	'L_PROFILE_SETTINGS'			=> $lang['Profile_Settings'],

	'L_OFF'							=> $lang['Always_Off'],
	'L_REG_OFF'						=> $lang['Reg_Off'],
	'L_ON'							=> $lang['Always_On'],
	'L_REQUIRED'					=> $lang['Required'],
	'L_POST_COUNT'					=> $lang['By_Post_Count'],
	'L_POSTS'						=> $lang['Post_Count'],

	'L_SYNC'						=> $lang['Sync'],
	'L_SYNC_EXPLAIN'				=> $lang['Sync_Explain'],
	'L_SUBMIT'						=> $lang['Submit'],
	'L_RESET'						=> $lang['Reset'])
	);
	
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>
