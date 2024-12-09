##############################################################
## MOD Title: Anti-spam ACP 2.0.1 to 2.0.8 upgrade
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
##
## MOD Description: Blocks spam in many ways from your board.  Includes a new captcha, url posting control,
##				an inactive userlist, profile options control, a spam log, and an email notification option.
##
## MOD Version: 2.0.8
##
## Installation Level:	Easy
## Installation Time:	~8 min (less than 1 min with EasyMOD)
##
## Files To Edit:	admin/admin_users.php
##					includes/functions_post.php
##					includes/usercp_register.php
##					templates/subSilver/admin/user_edit_body.tpl
## 					templates/subSilver/posting_body.tpl
##					posting.php
##					profile.php
##
## Included Files:	admin/admin_anti_spam_acp.php
##					admin/admin_anti_spam_acp_inactive.php
##					admin/admin_anti_spam_acp_log.php
##					admin/admin_anti_spam_acp_profile.php
##					includes/better_captcha_fonts/*
##					includes/anti_spam_acp.php
##					includes/functions_anti_spam_acp.php
##					includes/usercp_captcha.php
##					language/lang_english/email/admin_spam_notification.tpl
##					language/lang_english/lang_anti_spam_acp.php
##					templates/subSilver/admin/anti_spam_acp.tpl
##					templates/subSilver/admin/anti_spam_acp_inactive.tpl
##					templates/subSilver/admin/anti_spam_acp_log.tpl
##					templates/subSilver/admin/anti_spam_acp_profile.tpl
##					templates/subSilver/images/arrowdown.png
##					templates/subSilver/images/arrowright.png
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##	+ If you are not able to manually do the SQL sections you may run the db_upgrade.php.  Read more about it below in the
##		- SQL section, it tells you what to do.
##	+ My official thread for this mod is here: http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=10&t=4
##		- Please ask for support in the Anti-Spam ACP support forum, which is located here:
##			+ http://www.lithiumstudios.org/phpBB3/viewforum.php?f=25
##	+ If you would like to support my work, you can do so by donating.  It can take a lot of time to code and support your modifications.
##		- You can donate with PayPal here:
##		- http://tinyurl.com/ymtctj
##	+ I HIGHLY reccomend you use EasyMod to install this mod(make sure you are using the latest version of EasyMod when you do)
##		- The biggest reason for errors after installing this mod is user installation error.  If EasyMod detects an error
##			+ it will let you know before it does any changes.
##############################################################
## MOD History:
##	(yyyy-mm-dd)
##	2006-06-25
##		+ 1.0.0 Initial Release
##	2006-08-23
##		+ 1.1.0 Complete Overhaul...
##	2006-08-27
##		+ 1.1.0a Hard codded language fixed and emailer template added(was forgotten in 1.1.0)
##	2006-09-06
##		+ 1.1.01 Bug fixes, a few minor things, a bots caught watcher, and a cool version checker ^_^
##			- As long as there are no bugs found or and all of the future versions of phpBB are compatible with this mod,
##				+ this will be the last version I code(I will still support it though). :-P
##	2006-09-11
##		+ 1.1.01a Dang it...I missed a small bug. :(
##			- Thanks gpraceman for finding it.
##	2006-11-01
##		+ 1.1.02 Many fixes...
##	2006-12-06
##		+ 2.0.0 Pretty much a complete remake of the mod.  Includes many more features and bug fixes over 1.1.02.
##	2006-12-07
##		+ 2.0.0a Oopsie, I had the inactive userlist counting the active members for the pagenation instead of the inactive ones. :$
##	2006-12-25
##		+ Happy Holidays!
##		+ 2.0.1 Polishing up the mod.
##		+ Also, now compatible with User Shield 1.2.1(if User Shield 1.2.1 is installed first).
##	2006-12-31
##		+ Have a great new year!
##		+ 2.0.2 More minor polishes.  Email now gets sent if something is logged instead of just during registration.
##			- unversioned update: Changed the mod to work even better with more templates(the way the finds are setup)!  Thanks Nightrider! :D
##	2007-01-12
##		+ 2.0.3 Now have the option to sync user's data to follow the current profile rules.  Also there is now the option to delete all posts or
##			- topics made by a specific user(located under User Management).
##	2007-01-21
##		+ 2.0.4 A few fixes.
##			- Now the captcha also shows during posting to guest users! :D
##	2007-01-24
##		+ 2.0.5 Some important bug fixes, update ASAP if you have 2.0.4
##			- Also, now the spam log can be sorted.
##	2007-02-04
##		+ 2.0.6 Minor bug fixes, and now more captcha options!
##			- No more manual SQL stuff anymore!  It is all done automatically! :D
##			- Rather large problem(data was not synced) found with deleting user posts/topics has now been fixed!  You can all thank Snapdragon for finding it. :)
##	2007-02-16
##		+ 2.0.7 Bug fixes
##			- Now much better support for other DB types(thanks to those who helped and tested it)
##			- Removed the new captcha that was included last time, it was not as helpful as I had hoped.
##	2007-03-11
##		+ 2.0.8 Minor bug fixes, language fixes
##			- You can thank Infarinato for the language fixes. :)
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#

If you do NOT have Anti-spam ACP 2.0.1 installed DO NOT install this .mod file!

Also make sure you read the Read_Me_First.txt file located in the root mod directory.

If you do not follow those 2 instructions, I will not give you support on this mod.

Delete the includes/fonts folder(it is no longer used).
Delete the usercp_captcha2.php file from the includes/ folder

#
#-----[ COPY ]------------------------------------------
#

copy root/admin/admin_anti_spam_acp.php								to	admin/admin_anti_spam_acp.php
copy root/admin/admin_anti_spam_acp_inactive.php					to	admin/admin_anti_spam_acp_inactive.php
copy root/admin/admin_anti_spam_acp_log.php							to	admin/admin_anti_spam_acp_log.php
copy root/admin/admin_anti_spam_acp_profile.php						to	admin/admin_anti_spam_acp_profile.php
copy root/includes/better_captcha_fonts/*.*							to	includes/better_captcha_fonts/*.*
copy root/includes/anti_spam_acp.php								to	includes/anti_spam_acp.php
copy root/includes/functions_anti_spam_acp.php						to	includes/functions_anti_spam_acp.php
copy root/includes/usercp_captcha.php								to	includes/usercp_captcha.php
copy root/language/lang_english/email/admin_spam_notification.tpl	to	language/lang_english/email/admin_spam_notification.tpl
copy root/language/lang_english/lang_anti_spam_acp.php				to	language/lang_english/lang_anti_spam_acp.php
copy root/templates/subSilver/admin/anti_spam_acp.tpl				to	templates/subSilver/admin/anti_spam_acp.tpl
copy root/templates/subSilver/admin/anti_spam_acp_inactive.tpl		to	templates/subSilver/admin/anti_spam_acp_inactive.tpl
copy root/templates/subSilver/admin/anti_spam_acp_log.tpl			to	templates/subSilver/admin/anti_spam_acp_log.tpl
copy root/templates/subSilver/admin/anti_spam_acp_profile.tpl		to	templates/subSilver/admin/anti_spam_acp_profile.tpl
copy root/templates/subSilver/images/arrowdown.png					to	templates/subSilver/images/arrowdown.png
copy root/templates/subSilver/images/arrowright.png					to	templates/subSilver/images/arrowright.png

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#

require($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------
#

// Start Anti-Spam ACP MOD
$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];

if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx))
{
	message_die(GENERAL_MESSAGE, 'Anti-Spam ACP Mod language file does not exist: language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
}
include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);

require($phpbb_root_path . 'includes/functions_anti_spam_acp.' . $phpEx);
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
#

		$user_id = intval($HTTP_POST_VARS['id']);

#
#-----[ AFTER, ADD ]------------------------------------
#

// Start Anti-Spam ACP MOD
		$message = '';
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
#

			$message = $lang['User_deleted'] . '<br /><br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . append_sid("admin_users.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);

#
#-----[ REPLACE WITH ]----------------------------------
#

// Start Anti-Spam ACP MOD
			$message .= $lang['User_deleted'] . '<br />';
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
# Note: This is not the full line

phpbb_clean_username($HTTP_POST_VARS['username'])

#
#-----[ BEFORE, ADD ]-----------------------------------
#

// Start Anti-Spam ACP MOD
		if( $HTTP_POST_VARS['deletetopics'] )
		{
			delete_topics($user_id);
			$message .= $lang['User_Topics_Deleted'] . '<br/>';
		}

		if( $HTTP_POST_VARS['deleteposts'] )
		{
			delete_posts($user_id);
			$message .= $lang['User_Posts_Deleted'] . '<br/>';
		}

		if ( ($HTTP_POST_VARS['deleteuser']) || ($HTTP_POST_VARS['deletetopics']) || ($HTTP_POST_VARS['deleteposts']) )
		{
			$message .= '<br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . append_sid("admin_users.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
#

			'L_DELETE_USER_EXPLAIN' => $lang['User_delete_explain'],

#
#-----[ AFTER, ADD ]------------------------------------
#

// Start Anti-Spam ACP MOD
			'L_DELETE_USER_TOPICS' => $lang['User_delete_topics'],
			'L_DELETE_USER_TOPICS_EXPLAIN' => $lang['User_delete_topics_explain'],
			'L_DELETE_USER_POSTS' => $lang['User_delete_posts'],
			'L_DELETE_USER_POSTS_EXPLAIN' => $lang['User_delete_posts_explain'],
// End Anti-Spam ACP MOD

#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#

// Start Anti-Spam ACP MOD
	if ( ($userdata['user_level'] != ADMIN) && ($userdata['user_level'] != MOD) )
	{
		if ( ($board_config['as_acp_posting_url'] == 'off') || ( ($board_config['as_acp_posting_url'] == 'post count') && ( ($userdata['user_posts'] < $board_config['as_acp_posting_url_post']) || ($userdata['user_id'] == ANONYMOUS) ) ) || ( ($board_config['as_acp_posting_url'] == 'guest') && ($userdata['user_id'] == ANONYMOUS) ) )
		{
			if ( (preg_match("%((http://|https://|ftp://|file://|www\.)[^\s]+?)(.*)%isU", $message)) || (preg_match("%([^\s]+?(\.com|\.org|\.net|\.biz|\.info|\.name|\.ru|\.ws|\.de))%", $message)) )
			{
				/*
				* include the language file
				*/
				$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];

				if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx))
				{
					message_die(GENERAL_MESSAGE, 'Anti-Spam ACP Mod language file does not exist: language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
				}
				include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);

				if ($board_config['as_acp_posting_url'] == 'off')
				{
					$error_msg .= $lang['Url_Not_Allowed'];
				}
				else if( ($board_config['as_acp_posting_url'] == 'guest') || ($userdata['user_id'] == ANONYMOUS) )
				{
					$error_msg .= $lang['Url_Not_Allowed_Guests'];
				}
				else
				{
					$error_msg .= sprintf($lang['Url_Not_Allowed_Count'], $board_config['as_acp_posting_url_post']);
				}

				if ($board_config['as_acp_log_message_posting'])
				{
					/*
					* include the functions file
					*/
					require('functions_anti_spam_acp.' . $phpEx);

					log_spam($message, (empty($username)) ? $userdata['username'] : $username, $userdata['user_id'], $userdata['user_email'], $lang['During_Posting']);
				}
			}
		}
	}
// End Anti-Spam ACP MOD

#
#-----[ REPLACE WITH ]----------------------------------
#

// Start Anti-Spam ACP MOD
	if ( ($userdata['user_level'] != ADMIN) && ($userdata['user_level'] != MOD) )
	{
		if ( ($board_config['as_acp_posting_url'] == 'off') || ( ($board_config['as_acp_posting_url'] == 'post count') && ( ($userdata['user_posts'] < $board_config['as_acp_posting_url_post']) || ($userdata['user_id'] == ANONYMOUS) ) ) || ( ($board_config['as_acp_posting_url'] == 'guest') && ($userdata['user_id'] == ANONYMOUS) ) )
		{
			if ( (preg_match("%((http://|https://|ftp://|file://)[^\s]+?)(.*)%isU", $message)) || (preg_match("%([^\s]+?(\.com|\.org|\.net|\.biz|\.info|\.name))%", $message)) )
			{
				if ($board_config['as_acp_posting_url'] == 'off')
				{
					$error_msg .= $lang['Url_Not_Allowed'];
				}
				else if( ($board_config['as_acp_posting_url'] == 'guest') || ($userdata['user_id'] == ANONYMOUS) )
				{
					$error_msg .= $lang['Url_Not_Allowed_Guests'];
				}
				else
				{
					$error_msg .= sprintf($lang['Url_Not_Allowed_Count'], $board_config['as_acp_posting_url_post']);
				}

				if ($board_config['as_acp_log_message_posting'])
				{
					log_spam($message, (empty($username)) ? $userdata['username'] : $username, $userdata['user_id'], $userdata['user_email'], $lang['During_Posting'], sprintf($lang['Not_Test_Email_Header'], $lang['Posting']));
				}
			}
		}
	}
// End Anti-Spam ACP MOD

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#

				if ($row['code'] != $confirm_code)
				{

#
#-----[ REPLACE WITH ]----------------------------------
# (delete it)


#
#-----[ FIND ]------------------------------------------
#

// Start Anti-Spam ACP MOD

#
#-----[ AFTER, ADD ]------------------------------------
#

				if ( ( ($board_config['as_acp_captcha_case_sensative'] == '0') && (strtoupper($row['code']) != strtoupper($confirm_code)) ) || ( ($board_config['as_acp_captcha_case_sensative'] == '1') && ($row['code'] != $confirm_code) ))
				{

#
#-----[ FIND ]------------------------------------------
#

		log_spam($as_triggers, $username, $user_id, $email, $lang['During_Registration']);

#
#-----[ REPLACE WITH ]----------------------------------
#

		log_spam($as_triggers, $username, $user_id, $email, $lang['During_Registration'], sprintf($lang['Not_Test_Email_Header'], ($mode == 'register') ? $lang['Registering'] : $lang['Editing_Profile']));

#
#-----[ FIND ]------------------------------------------
#

		if ( (extension_loaded("gd")) && ($board_config['as_acp_new_captcha_on']) )
		{
			$confirm_explain = $lang['New_Confirm_Code_Explain'];
		}
		else
		{
			$confirm_explain = $lang['Confirm_code_explain'];
		}

#
#-----[ REPLACE WITH ]----------------------------------
# (delete it)

#
#-----[ FIND ]------------------------------------------
#

		'L_CONFIRM_CODE_EXPLAIN'	=> $confirm_explain,

#
#-----[ REPLACE WITH ]----------------------------------
#
		'L_CONFIRM_CODE_EXPLAIN'	=> $lang['New_Confirm_Code_Explain'],
#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#

{L_DELETE_USER_EXPLAIN}
</tr>

#
#-----[ AFTER, ADD ]------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_DELETE_USER_TOPICS}</span></td>
	  <td class="row2"> 
		<input type="checkbox" name="deletetopics">
		{L_DELETE_USER_TOPICS_EXPLAIN}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_DELETE_USER_POSTS}</span></td>
	  <td class="row2"> 
		<input type="checkbox" name="deleteposts">
		{L_DELETE_USER_POSTS_EXPLAIN}</td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#

{POLLBOX}

#
#-----[ AFTER, ADD ]------------------------------------
#

	<!-- BEGIN switch_confirm -->
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_CONFIRM_CODE_IMPAIRED}</span><br /><br />{CONFIRM_IMG}<br /><br /></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_CODE}: * </span><br /><span class="gensmall">{L_CONFIRM_CODE_EXPLAIN}</span></td>
	  <td class="row2"><input type="text" class="post" style="width: 200px" name="confirm_code" size="8" maxlength="8" value="" /></td>
	</tr>
	<!-- END switch_confirm -->

#
#-----[ OPEN ]------------------------------------------
#

posting.php

#
#-----[ FIND ]------------------------------------------
#

// End session management
//

#
#-----[ AFTER, ADD ]------------------------------------
#

// Start Anti-Spam ACP MOD
/*
* include the language file
*/
$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];

if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx))
{
	message_die(GENERAL_MESSAGE, 'Anti-Spam ACP Mod language file does not exist: language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
}			
include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);

/*
* include the functions file
*/
require($phpbb_root_path . 'includes/functions_anti_spam_acp.' . $phpEx);
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
# Note, this line is longer than shown, full line is this:
# 			prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $message, $poll_title, $poll_options, $poll_length);

prepare_post

#
#-----[ BEFORE, ADD ]-----------------------------------
#

// Start Anti-Spam ACP MOD
			if ( $board_config['enable_confirm'] && !$userdata['session_logged_in'] )
			{
				if ( empty($HTTP_POST_VARS['confirm_id']) )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
				}
				else
				{
					$confirm_id = htmlspecialchars($HTTP_POST_VARS['confirm_id']);
					if (!preg_match('/^[A-Za-z0-9]+$/', $confirm_id))
					{
						$confirm_id = '';
					}
					
					$sql = 'SELECT code 
						FROM ' . CONFIRM_TABLE . " 
						WHERE confirm_id = '$confirm_id' 
							AND session_id = '" . $userdata['session_id'] . "'";
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not obtain confirmation code');
					}
		
					if ($row = $db->sql_fetchrow($result))
					{
						if ( ( ($board_config['as_acp_captcha_case_sensative'] == '0') && (strtoupper($row['code']) != strtoupper($HTTP_POST_VARS['confirm_code'])) ) || ( ($board_config['as_acp_captcha_case_sensative'] == '1') && ($row['code'] != $HTTP_POST_VARS['confirm_code']) ))
						{
							$error = TRUE;
							$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
							if ($board_config['as_acp_log_captcha'])
							{
								if ($HTTP_POST_VARS['confirm_code'] != '')
								{
									$as_triggers = sprintf($lang['Wrong_Captcha_Code'], $row['code'], str_replace("'", "\'", $HTTP_POST_VARS['confirm_code'])) . '%end_of_line%';
								}
								else
								{
									$as_triggers = sprintf($lang['No_Captcha_Code'], $row['code']) . '%end_of_line%';
								}
							}
						}

						$sql = 'DELETE FROM ' . CONFIRM_TABLE . " 
							WHERE confirm_id = '$confirm_id' 
								AND session_id = '" . $userdata['session_id'] . "'";
						if (!$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not delete confirmation code');
						}
					}
					else
					{		
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
					}
					$db->sql_freeresult($result);
				}
			}

			if ( isset($as_triggers))
			{
				log_spam($as_triggers, $username, '-1', '', $lang['During_Posting'], sprintf($lang['Not_Test_Email_Header'], $lang['During_Posting']));
			}
// End Anti-Spam ACP MOD

#
#-----[ FIND ]------------------------------------------
#

$template->assign_block_vars('switch_not_privmsg', array());

#
#-----[ AFTER, ADD ]------------------------------------
#

// Start Anti-Spam ACP MOD
$confirm_image = '';
if( !$userdata['session_logged_in'] && (!empty($board_config['enable_confirm'])) )
{
	// Generate the required confirmation code
	$code = dss_rand();

	$code = substr(str_replace('0', 'Z', strtoupper(base_convert($code, 16, 35))), rand(0, 3), rand(2, 8));
	if ( (extension_loaded("gd")) && ($board_config['as_acp_new_captcha_on']) )
	{
		$confirm_explain = $lang['New_Confirm_Code_Explain'];
	}
	else
	{
		$confirm_explain = $lang['Confirm_code_explain'];
	}

	$confirm_id = md5(uniqid($user_ip));

	$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) 
		VALUES ('$confirm_id', '". $userdata['session_id'] . "', '$code')";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
	}

	unset($code);
	
	$confirm_image = '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id") . '" alt="" title="" />';
	$hidden_form_fields .= '<input type="hidden" name="confirm_id" value="' . $confirm_id . '" />';

	$template->assign_block_vars('switch_confirm', array());
}

$template->assign_vars(array(
	'CONFIRM_IMG' => $confirm_image,
	'L_CONFIRM_CODE_IMPAIRED'	=> sprintf($lang['Confirm_code_impaired'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'),
	'L_CONFIRM_CODE' => $lang['Confirm_code'],
	'L_CONFIRM_CODE_EXPLAIN' => $confirm_explain)
	);
// End Anti-Spam ACP MOD

#
#-----[ OPEN ]------------------------------------------
#

profile.php

#
#-----[ FIND ]------------------------------------------
#

// Start Anti-Spam ACP MOD
		if ($board_config['as_acp_new_captcha_on'])
		{
			include($phpbb_root_path . 'includes/usercp_captcha.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'includes/usercp_confirm.'.$phpEx);
		}
// End Anti-Spam ACP MOD

#
#-----[ REPLACE WITH ]----------------------------------
#

// Start Anti-Spam ACP MOD
		include($phpbb_root_path . 'includes/usercp_captcha.'.$phpEx);
// End Anti-Spam ACP MOD

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM