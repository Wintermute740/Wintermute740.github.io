<?php
/***************************************************************************
 *        admin_anti_spam_acp.php
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
	$module['Anti_Spam']['Spam_Log'] = $filename;
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

if( isset( $HTTP_POST_VARS['mode'] ) || isset( $HTTP_GET_VARS['mode'] ) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = '';
}

if( isset( $HTTP_POST_VARS['confirm'] ) || isset( $HTTP_GET_VARS['confirm'] ) )
{
	$confirm = true;
}
else
{
	$confirm = false;
}

if( isset( $HTTP_POST_VARS['cancel'] ) || isset( $HTTP_GET_VARS['cancel'] ) )
{
	$cancel = true;
	$mode = '';
}
else
{
	$cancel = false;
}

if ($mode == 'delete')
{
	//
	// see if cancel has been hit and redirect if it has
	//
	if ( $cancel )
	{
		redirect('admin_anti_spam_acp_log.'.$phpEx);
	}

	//
	// check confirm and either delete or show confirm message
	//
	if ( !$confirm )
	{
		// show message
		$template->set_filenames(array(
			'body' => 'confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Delete'],
			'MESSAGE_TEXT' => $lang['Confirm_Log_Clear'],
			'U_INDEX' => '',
			'L_INDEX' => '',
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'S_CONFIRM_ACTION' => append_sid('admin_anti_spam_acp_log.'.$phpEx . '?mode=delete'))
			);

		$template->pparse('body');
	}
	else
	{
		$sql = "TRUNCATE TABLE " . SPAM_LOG_TABLE;
		if(!$result = $db->sql_query($sql))
		{
			message_die(CRITICAL_ERROR, "Could not clear log table.", "", __LINE__, __FILE__, $sql);
		}

		$message = $lang['Log_Cleared'] . "<br /><br />" . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp_log.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}	
}
else
{
	//
	// sort method
	//
	if ( isset($HTTP_GET_VARS['sort']) || isset($HTTP_POST_VARS['sort']) )
	{
		$sort = ( isset($HTTP_POST_VARS['sort']) ) ? htmlspecialchars($HTTP_POST_VARS['sort']) : htmlspecialchars($HTTP_GET_VARS['sort']);
		$sort = str_replace("\'", "''", $sort);
	}
	else
	{
		$sort = 'log_id';
	}

	//
	// sort order
	//
	if( isset($HTTP_POST_VARS['order']) )
	{
		$sort_order = ( $HTTP_POST_VARS['order'] == 'ASC' ) ? 'ASC' : 'DESC';
	}
	else if( isset($HTTP_GET_VARS['order']) )
	{
		$sort_order = ( $HTTP_GET_VARS['order'] == 'ASC' ) ? 'ASC' : 'DESC';
	}
	else
	{
		$sort_order = 'DESC';
	}

	// Pagination
	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
	$show = $board_config['as_acp_spam_log_pagination'];

	if (isset($HTTP_POST_VARS['show']))
	{
		if ( ($show != $HTTP_POST_VARS['show']) && (num_check($HTTP_POST_VARS['show'])) )
		{
			$show = $HTTP_POST_VARS['show'];
			
			$sql = 'UPDATE ' . CONFIG_TABLE . ' SET config_value = \'' . $HTTP_POST_VARS['show'] . '\' WHERE config_name = \'as_acp_spam_log_pagination\'';
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], 'as_acp_spam_log_pagination'), "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if ($show == '') //should never happen, but just in case
	{
		$show = '12';
	}
	
	$sql = "SELECT * FROM " . SPAM_LOG_TABLE . "
				ORDER BY $sort $sort_order
				LIMIT $start, $show";
	if(!$result = $db->sql_query($sql))
	{
		message_die(CRITICAL_ERROR, "Could not query log information", "", __LINE__, __FILE__, $sql);
	}

	if ($db->sql_numrows($result) == 0)
	{
		$template->assign_block_vars('no_rows', array());
	}
	else
	{
		while($row = $db->sql_fetchrow($result))
		{
			$date = create_date($board_config['default_dateformat'], $row['log_time'], $board_config['board_timezone']);
			$manage_user_url = append_sid('admin_users.'.$phpEx.'?mode=edit&amp;' . POST_USERS_URL . '=' . $row['user_id']);
			$template->assign_block_vars('log_row', array(
				'DATE'				=> $date,
				'USERNAME'			=> ($row['user_id'] == -1) ? $row['username'] : '<a href="' . $manage_user_url . '">' . $row['username'] . '</a>',
				'LOCATION'			=> $row['location'],
				'USER_IP'			=> $row['user_ip'],
				'USER_EMAIL'		=> $row['user_email'],
				'TRIGGERS'			=> $row['log_triggers'])
				);
		}
	}

	// sort
	$select_sort_by = array('log_id', 'username', 'user_ip', 'user_email'); 
	$select_sort_by_text = array($lang['Date'], $lang['Username'], $lang['IP_Address'], $lang['Email']); 
	$select_sort = '<select name="sort" class="post">'; 
	for($i = 0; $i < count($select_sort_by); $i++) 
	{ 
		$selected = ($sort == $select_sort_by[$i]) ? ' selected="selected"' : ''; 
		$select_sort .= '<option value="' . $select_sort_by[$i] . '"' . $selected . '>' . $select_sort_by_text[$i] . '</option>'; 
	} 
	$select_sort .= '</select>'; 

	$select_sort_order = '<select name="order" class="post">'; 
	if ( $sort_order == 'ASC' ) 
	{ 
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Ascending'] . '</option><option value="DESC">' . $lang['Descending'] . '</option>'; 
	} 
	else 
	{ 
		$select_sort_order .= '<option value="ASC">' . $lang['Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Descending'] . '</option>'; 
	} 
	$select_sort_order .= '</select>';

	// More Pagination
	$count_sql = "SELECT count(log_id) AS total 
		FROM " . SPAM_LOG_TABLE;

	if ( !($count_result = $db->sql_query($count_sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $count_sql);
	}

	if ( $total = $db->sql_fetchrow($count_result) )
	{
		$total_members = $total['total'];
		$pagination = generate_pagination("admin_anti_spam_acp_log.$phpEx?sort=$sort&amp;order=$sort_order&amp;show=$show", $total_members, $show, $start);
	}

	$template->set_filenames(array(
		'body' => 'admin/anti_spam_acp_log.tpl')
	);

	$template->assign_vars(array(
		'L_ANTI_SPAM_ACP'						=> $lang['Anti_Spam_ACP'],
		'L_ANTI_SPAM_ACP_CREATED_BY'			=> $lang['Anti_Spam_ACP_Created_By'],
		'VERSION_INFO'							=> $version_info,
		'S_ACTION'								=> append_sid("admin_anti_spam_acp_log.$phpEx"),

		'L_SORT_BY'								=> $lang['Sort_by'],
		'S_SELECT_SORT'							=> $select_sort, 
        'S_SELECT_SORT_ORDER'					=> $select_sort_order,
		'L_SHOW'								=> $lang['Show'],
		'S_SHOW'								=> $show,
		'S_SORT'								=> $lang['Sort'],		

		'L_LOG_ID'								=> $lang['Log_ID'],
		'L_DATE'								=> $lang['Date'],
		'L_USERNAME'							=> $lang['Username'],
		'L_LOCATION'							=> $lang['Forum_Location'],
		'L_USER_IP'								=> $lang['IP_Address'],
		'L_USER_EMAIL'							=> $lang['Email_Address'],

		'L_NO_ROWS'								=> $lang['No_Entries_In_Log'],
		'L_SELECT'								=> $lang['Select_one'],
		'L_CLEAR_LOG'							=> $lang['Clear_Log'],
		'L_GO'									=> $lang['Go'],

		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $show ) + 1 ), ceil( $total_members / $show )))
		);

	$template->pparse('body');

	include('./page_footer_admin.'.$phpEx);
}
?>