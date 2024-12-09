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
	$module['Anti_Spam']['General_Settings'] = $filename;
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

		if( isset($HTTP_POST_VARS['submit']) || isset($HTTP_POST_VARS['test_mail']) )
		{
			if ( ($config_name == 'as_acp_spam_log_pagination') && (num_check($new['as_acp_spam_log_pagination']) == false) )
			{
				$error = true;
				$new['as_acp_spam_log_pagination'] = $row['config_value'];
			}

			$new[$config_name] = str_replace("\'", "''", $new[$config_name]);
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("'", "&#39;", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, sprintf($lang['Failed_Update'], $config_name), "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		if (!$error)
		{
			$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['AS_ACP_Update_Error'] . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( isset($HTTP_POST_VARS['test_mail']) )
	{
		$as_triggers  = $lang['ICQ'] . ': ' . '000000000' . "%end_of_line%";
		$as_triggers .= $lang['AIM'] . ': ' . 'AIM' . "%end_of_line%";
		$as_triggers .= $lang['MSNM'] . ': ' . 'test@hotmail.com' . "%end_of_line%";
		$as_triggers .= $lang['YIM'] . ': ' . 'YIM' . "%end_of_line%";
		$as_triggers .= $lang['Website'] . ': ' . 'http://www.testwebsite.com' . "%end_of_line%";
		$as_triggers .= $lang['Location'] . ': ' . $board_config['sitename'] . "%end_of_line%";
		$as_triggers .= $lang['Occupation'] . ': ' . $lang['Test_Occupation'] . "%end_of_line%";
		$as_triggers .= $lang['Interests'] . ': ' . $lang['Test_Interests'] . "%end_of_line%";
		$as_triggers .= $lang['Signature'] . ': ' . $lang['Test_Signature'] . "%end_of_line%";

		send_email($as_triggers, $lang['Test_Username'], sprintf($lang['Test_Email'], $board_config['server_name']), '0.0.0.0', $lang['Test_Email_Header']);

		if (!$error)
		{
			$message = $lang['Test_Message_Sent'] . '<br />' . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['Test_Message_Sent'] . '<br />' . $lang['AS_ACP_Update_Error'] . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}

}

$template->set_filenames(array(
	'body' => 'admin/anti_spam_acp.tpl')
);
$template->assign_vars(array(
	'L_ANTI_SPAM_ACP'						=> $lang['Anti_Spam_ACP'],
	'L_ANTI_SPAM_ACP_CREATED_BY'			=> $lang['Anti_Spam_ACP_Created_By'],
	'VERSION_INFO'							=> $version_info,

	'S_ACTION'								=> append_sid("admin_anti_spam_acp.$phpEx"),

	'L_GENERAL_SETTINGS'					=> $lang['General_Settings'],

	'L_CHECK_VERSION'						=> $lang['Check_Version'],
	'L_CHECK_VERSION_EXPLAIN'				=> $lang['Check_Version_Explain'],
	'CHECK_VERSION_ENABLE'					=> ( $new['as_acp_check_version']) ? "checked=\"checked\"" : "",
	'CHECK_VERSION_DISABLE'					=> (!$new['as_acp_check_version']) ? "checked=\"checked\"" : "",

	'L_ACCT_ACTIVATION'						=> $lang['Acct_activation'],
	'L_ACCT_ACTIVATION_EXPLAIN'				=> $lang['Acct_Activation_Explain'],
	'ACTIVATION_NONE'						=> USER_ACTIVATION_NONE,
	'ACTIVATION_NONE_CHECKED'				=> ( $new['require_activation'] == USER_ACTIVATION_NONE ) ? "checked=\"checked\"" : "",
	'L_NONE'								=> $lang['Acc_None'], 
	'ACTIVATION_USER'						=> USER_ACTIVATION_SELF,
	'ACTIVATION_USER_CHECKED'				=> ( $new['require_activation'] == USER_ACTIVATION_SELF ) ? "checked=\"checked\"" : "",
	'L_USER'								=> $lang['Acc_User'], 
	'ACTIVATION_ADMIN'						=> USER_ACTIVATION_ADMIN,
	'ACTIVATION_ADMIN_CHECKED'				=> ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "",
	'L_ADMIN'								=> $lang['Acc_Admin'], 

	'L_HIDE_INACTIVE_USERS'					=> $lang['Hide_Inactive_Users'],
	'L_HIDE_INACTIVE_USERS_EXPLAIN'			=> $lang['Hide_Inactive_Users_Explain'],
	'HIDE_INACTIVE_USERS_ENABLE'			=> ( $new['as_acp_hide_inactive']) ? "checked=\"checked\"" : "",
	'HIDE_INACTIVE_USERS_DISABLE'			=> (!$new['as_acp_hide_inactive']) ? "checked=\"checked\"" : "",

	'L_CAPTCHA_SETTINGS'					=> $lang['Captcha_Settings'],

	'L_VISUAL_CONFIRM'						=> $lang['Visual_confirm'], 
	'L_YES'									=> $lang['Yes'],
	'CONFIRM_ENABLE'						=> ($new['enable_confirm']) ? 'checked="checked"' : '',
	'CONFIRM_DISABLE'						=> (!$new['enable_confirm']) ? 'checked="checked"' : '',
	'L_NO'									=> $lang['No'],

	'L_CAPTCHA_VERSION'						=> $lang['Captcha_Version'],
	'L_CAPTCHA_VERSION_EXPLAIN'				=> $lang['Captcha_Version_Explain'],

	'RANDOM_CAPTCHA'						=> ($new['as_acp_captcha'] == '-1') ? 'checked="checked"' : '',
	'L_RANDOM_CAPTCHA'						=> $lang['Random_Captcha'],
	'PHPBB_CAPTCHA'							=> ($new['as_acp_captcha'] == '0') ? 'checked="checked"' : '',
	'L_PHPBB_CAPTCHA'						=> sprintf($lang['Default_Captcha'], '<a href="' . $phpbb_root_path . 'includes/usercp_captcha.' . $phpEx . '?demo=true&captcha=0">' . $lang['Demo'] . '</a>'),
	'BETTER_CAPTCHA'						=> ($new['as_acp_captcha'] == '1') ? 'checked="checked"' : '',
	'L_BETTER_CAPTCHA'						=> sprintf($lang['Better_Captcha'], '<a href="' . $phpbb_root_path . 'includes/usercp_captcha.' . $phpEx . '?demo=true&captcha=1">' . $lang['Demo'] . '</a> <a href="' . $phpbb_root_path . 'includes/usercp_captcha.' . $phpEx . '?demo=true&captcha=1&noise=true">' . $lang['Demo_Noise'] . '</a>'),

	'L_CAPTCHA_NOISE'						=> $lang['Captcha_Noise'],
	'L_CAPTCHA_NOISE_EXPLAIN'				=> $lang['Captcha_Noise_Explain'],
	'CAPTCHA_NOISE_ENABLE'					=> ($new['as_acp_captcha_noise']) ? 'checked="checked"' : '',
	'CAPTCHA_NOISE_DISABLE'					=> (!$new['as_acp_captcha_noise']) ? 'checked="checked"' : '',

	'L_CAPTCHA_CASE_SENSITIVE'				=> $lang['Captcha_Case_Sensitive'],
	'L_CAPTCHA_CASE_SENSITIVE_EXPLAIN'		=> $lang['Captcha_Case_Sensitive_Explain'],
	'CAPTCHA_CASE_SENSITIVE_ENABLE'			=> ($new['as_acp_captcha_case_sensative']) ? 'checked="checked"' : '', // sensitive is spelt wrong in the database, so to keep things simple we will just leave it
	'CAPTCHA_CASE_SENSITIVE_DISABLE'		=> (!$new['as_acp_captcha_case_sensative']) ? 'checked="checked"' : '', // sensitive is spelt wrong in the database, so to keep things simple we will just leave it

	'L_POSTING_SETTINGS'					=> $lang['Posting_Settings'],

	'L_POSTING_URL'							=> $lang['Posting_Url'],
	'L_POSTING_URL_EXPLAIN'					=> $lang['Posting_Url_Explain'],
	'POSTING_URL_OFF'						=> ( $new['as_acp_posting_url']	== 'off' ) ? "checked=\"checked\"" : "",
	'L_URL_OFF'								=> $lang['Url_Off'],
	'POSTING_URL_ON'						=> ( $new['as_acp_posting_url']	== 'on' ) ? "checked=\"checked\"" : "",
	'L_URL_ON'								=> $lang['Url_On'],
	'POSTING_URL_POST_COUNT'				=> ( $new['as_acp_posting_url']	== 'post count' ) ? "checked=\"checked\"" : "",
	'L_URL_POST_COUNT'						=> $lang['Url_By_Post_Count'],
	'POSTING_URL_POSTS'						=> $new['as_acp_posting_url_post'],
	'L_POSTS'								=> $lang['Post_Count'],
	'POSTING_URL_GUEST'						=> ( $new['as_acp_posting_url']	== 'guest' ) ? "checked=\"checked\"" : "",
	'L_GUEST'								=> $lang['Posting_Url_Guest'],

	'L_LOG_SETTINGS'						=> $lang['Log_Settings'],

	'L_LOG_CAPTCHA'							=> $lang['Log_Captcha'],
	'L_LOG_CAPTCHA_EXPLAIN'					=> $lang['Log_Captcha_Explain'],
	'LOG_CAPTCHA_ENABLE'					=> ( $new['as_acp_log_captcha']) ? "checked=\"checked\"" : "",
	'LOG_CAPTCHA_DISABLE'					=> (!$new['as_acp_log_captcha']) ? "checked=\"checked\"" : "",

	'L_PROFILE_LOG'							=> $lang['Log_Profile'],
	'L_PROFILE_LOG_EXPLAIN'					=> $lang['Log_Profile_Explain'],
	'PROFILE_LOG_ENABLE'					=> ($new['as_acp_log_profile']) ? 'checked="checked"' : '',
	'PROFILE_LOG_DISABLE'					=> (!$new['as_acp_log_profile']) ? 'checked="checked"' : '',

	'L_POSTING_URL_LOG'						=> $lang['Log_Url_Posts'],
	'L_POSTING_URL_LOG_EXPLAIN'				=> $lang['Log_Url_Posts_Explain'],
	'POSTING_URL_LOG_ENABLE'				=> ($new['as_acp_log_message_posting']) ? 'checked="checked"' : '',
	'POSTING_URL_LOG_DISABLE'				=> (!$new['as_acp_log_message_posting']) ? 'checked="checked"' : '',

	'L_LOG_SHOW'							=> $lang['Log_Show'],
	'L_LOG_SHOW_EXPLAIN'					=> $lang['Log_Show_Explain'],
	'LOG_SHOW'								=> $new['as_acp_spam_log_pagination'],
	'L_LOGS'								=> '', //$lang['Logs'], removing this for now...

	'L_EMAIL_ADDRESS'						=> $lang['Email_Address'],
	'L_EMAIL_ADDRESS_EXPLAIN'				=> $lang['Email_Address_Explain'],
	'EMAIL'									=> $new['as_acp_email_for_spam'],

	'L_SEND_MAIL'							=> $lang['Send_Email'],
	'L_SEND_MAIL_EXPLAIN'					=> $lang['Send_Email_Explain'],
	'SEND_MAIL_ENABLE'						=> ( $new['as_acp_notify_on_spam'])	? "checked=\"checked\"" : "",
	'SEND_MAIL_DISABLE'						=> (!$new['as_acp_notify_on_spam'])	? "checked=\"checked\"" : "",

	'L_TEST_MAIL'							=> $lang['L_Test_Mail'],
	'L_TEST_MAIL_EXPLAIN'					=> $lang['L_Test_Mail_Explain'],

	'S_HIDDEN_FIELDS'						=> '',
	'L_SUBMIT'								=> $lang['Submit'],
	'L_RESET'								=> $lang['Reset'])
	);
	
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>