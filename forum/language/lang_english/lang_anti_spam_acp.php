<?php
/***************************************************************************
 *          lang_anti_spam_acp.php
 * 			 -------------------
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
 ***************************************************************************/

// Common
	$lang['Spam_Attempt']								= 'Spam attempt at ';
	$lang['Not_Test_Email_Header']						= 'A user attempted something which is not allowed (while they were %s) on';

// Admin Control Panel
	// Common
		$lang['Anti_Spam']								= 'Anti Spam';
		$lang['Anti_Spam_ACP']							= 'Anti-Spam ACP';
		$lang['Anti_Spam_ACP_Created_By']				= 'Created By: <a href="http://www.lithiumstudios.org" style="text-decoration:none" target="_blank">EXreaction</a>';
		$lang['version_check_disabled']					= 'You have your board disabled to check for new updates to Anti-Spam ACP.  It is reccomended that you set "Check lithiumstudios.org automatically for updates?" to yes.';
		$lang['AS_ACP_up_to_date']						= 'Your version of Anti-Spam ACP is up to date.';
		$lang['AS_ACP_not_up_to_date']					= 'You are not running the latest stable version of Anti-Spam ACP.  The latest stable version is available at <a href="http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=25&t=4">Lithium Studios</a>.';
		$lang['AS_ACP_Latest_Version']					= 'The latest stable version is %s.';
		$lang['AS_ACP_Current_Version']					= 'You are running %s.';

		$lang['Click_return_AS_ACP']					= 'Click %sHere%s to return to Anti-Spam Configuration';
		$lang['AS_ACP_Update_Error']					= 'Errors were reported, the rest of the ';
		$lang['Failed_Update']							= 'Failed to update general configuration for %s';

		$lang['User_id']								= 'User id';
		$lang['Always_Off']								= 'Always Off';
		$lang['Always_On']								= 'Always On';
		$lang['By_Post_Count']							= 'Set According to Post Count';
		$lang['Post_Count']								= 'Post(s)';

		$lang['Constants_Update']						= 'includes/constants.php file was not updated correctly.  Make the changes to that file required for this mod.';

	// General Options
		$lang['General_Settings']						= 'General Settings';
		$lang['Check_Version']							= 'Check for updates?';
		$lang['Check_Version_Explain']					= 'Automatically accesses lithiumstudios.org and checks to see if you are running the latest version (just like phpBB does).';
		$lang['Acct_Activation_Explain']				= 'Should be set to user for the best results and protection.';
		$lang['Hide_Inactive_Users']					= 'Hide Inactive Users.';
		$lang['Hide_Inactive_Users_Explain']			= 'Hide Inactive Users from the board stats and memberlist.';

		$lang['Captcha_Settings']						= 'Captcha/Visual Confirmation Settings';
		$lang['Captcha_Version']						= 'Select the Captcha Version you would like to use:';
		$lang['Captcha_Version_Explain']				= 'Make sure the setting is correct above (if you want it on or off).<br/>If the version you select is incompatible with your server setup the default will be used.';
		$lang['Demo']									= 'Demo';
		$lang['Demo_Noise']								= 'Demo With Noise';

		$lang['Random_Captcha']							= 'Pick a captcha to use randomly.';
		$lang['Default_Captcha']						= 'Use the default phpBB2 style captcha.<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;%s';
		$lang['Better_Captcha']							= 'Use a modified version of <a href="http://www.phpbb.com/phpBB/viewtopic.php?t=473222" target="_blank">Better Captcha</a>.<br/>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;%s';

		$lang['Captcha_Noise']							= 'Add Noise to the Captcha if possible?';
		$lang['Captcha_Noise_Explain']					= 'Makes the text harder to read by bots and humans.<br/>Note, this is not available for all captchas.';
		$lang['Captcha_Case_Sensitive']					= 'Captcha is case-sensitive:';
		$lang['Captcha_Case_Sensitive_Explain']			= 'Example: With Yes, \'asdfghkj\' will not match \'ASDFGHKJ\'.  With No \'asdfghjk\' will match \'ASDFGHKJ\'.';

		$lang['Posting_Settings']						= 'Posting Settings';
		$lang['Posting_Url']							= 'URL/Links in posts';
		$lang['Posting_Url_Explain']					= 'When should URL/Links be allowed?<br/>They are always allowed for Administrators and Moderators.';
		$lang['Url_Off']								= 'URL/Links Never Allowed';
		$lang['Url_On']									= 'URL/Links Always Allowed';
		$lang['Posting_Url_Guest']						= 'URL/Links Not Allowed for Guest Posting';
		$lang['Url_By_Post_Count']						= 'Set According to Post Count';

		$lang['Log_Settings']							= 'Log & Email Settings';
		$lang['Log_Captcha']							= 'Log Visual Confirmation';
		$lang['Log_Captcha_Explain']					= 'Put data in the Spam Log when a user tries to use the wrong code for the Visual Confirmation.';
		$lang['Log_Profile']							= 'Log Profile';
		$lang['Log_Profile_Explain']					= 'Log data to spam log when user puts something in their profile they are not allowed to.';
		$lang['Log_Url_Posts']							= 'Log posts of url\'s in spam log';
		$lang['Log_Url_Posts_Explain']					= 'When someone posts a url and they are not allowed to it shows up in the spam log.';
		$lang['Log_Show']								= 'Number of entries to show';
		$lang['Log_Show_Explain']						= 'How many entries will be shown on the spam log page.';
		$lang['Logs']									= 'Log(s)';

		$lang['Email_Address']							= 'Email Address';
		$lang['Email_Address_Explain']					= 'Email address that the spam notifications will get sent to and that will be displayed if you have show email enabled.<br/>To enter multiple email addresses use a comma between each.';
		$lang['Send_Email']								= 'Send notification email';
		$lang['Send_Email_Explain']						= 'Sends out a notification email when something is logged.';
		$lang['L_Test_Mail']							= 'Test Email & Submit';
		$lang['L_Test_Mail_Explain']					= 'Send a test email to yourself.';

		$lang['Test_Occupation']						= 'Email Tester';
		$lang['Test_Interests']							= 'Sending out Emails';
		$lang['Test_Signature']							= 'Thank you for testing the email feature of the Anti-Spam ACP mod.  Please visit http://www.lithiumstudios.org if you need help.';
		$lang['Test_Email_Header']						= 'You sent a test email from';
		$lang['Test_Username']							= 'Test Username';
		$lang['Test_Email']								= 'test@%s';
		$lang['Test_Message_Sent']						= 'Test email has been sent.';

	// Inactive Userlist
		$lang['Inactive_Userlist']						= 'Inactive Userlist';
		$lang['Anti_Spam_ACP_Userlist_Original_By']		= 'Created By: Milkboy31, wGEric';
		$lang['Anti_Spam_ACP_Userlist_Modified_By']		= 'Modified By: <a href="http://www.lithiumstudios.org" style="text-decoration:none">EXreaction</a>';
		$lang['Show']									= 'Show';
		$lang['Group']									= 'Group(s)';
		$lang['Find_all_posts']							= 'Find All Posts';
		$lang['User_manage']							= 'Manage';
		$lang['Select_All']								= 'Select All';
		$lang['Deselect_All']							= 'Deselect All';
		$lang['Select_one']								= 'Select One';
		$lang['Ban']									= 'Ban';
		$lang['UnBan']									= 'Un-Ban';
		$lang['Activate']								= 'Activate';

		$lang['Confirm_user_deleted']					= 'Are you sure you want to delete the selected user(s)?';
		$lang['User_deleted_successfully']				= 'User(s) deleted successfully!';
		$lang['Click_return_userlist']					= 'Click %shere%s to return to the Inactive Userlist';
		$lang['Confirm_user_ban']						= 'Are you sure you want to ban the selected user(s)?';
		$lang['User_banned_successfully']				= 'User(s) banned successfully!';
		$lang['Confirm_user_un_ban']					= 'Are you sure you want to unban the selected user(s)?';
		$lang['User_un_banned_successfully']			= 'User(s) unbanned successfully!';
		$lang['User_status_updated']					= 'User(s) status updated successfully!';

		$lang['All']									= 'All';
		$lang['Last_activity']							= 'Last Activity';
		$lang['User_level']								= 'User Level';
		$lang['Rank']									= 'Rank';
		$lang['Ascending']								= 'Ascending';
		$lang['Descending']								= 'Descending';
		$lang['Is_Banned']								= 'Banned!'; 
		$lang['Never']									= 'Never';

	// Profile Options
		$lang['Profile_Options']						= 'Profile Options';
		$lang['Profile_Settings']						= 'Profile Field Options';
		$lang['Reg_Off']								= 'Off For Registration';
		$lang['Required']								= 'Required';
		$lang['Sync']									= 'Sync & Submit';
		$lang['Sync_Explain']							= 'Syncs all existing user\'s data to follow the current profile rules.';
		$lang['Config_updated_users_synced']			= 'User\'s data has been synced successfully!';
		$lang['AS_ACP_Update_Error_synced']				= 'User\'s data has been synced successfully!<br/>Errors were reported for the configuration update, the rest of the configuration updated successfully.';

	// Log
		$lang['Spam_Log']								= 'Spam Log';
		$lang['Confirm_Log_Clear']						= 'Are you sure you want to clear the log?';
		$lang['Log_Cleared']							= 'The log has been cleared successfully!';
		$lang['Clear_Log']								= 'Clear Log';
		$lang['Log_ID']									= 'Log ID';
		$lang['Date']									= 'Date';
		$lang['No_Entries_In_Log']						= 'No entries in the log.';

	// admin_users.php
		$lang['User_Topics_Deleted']					= 'Topics by this user have been deleted!';
		$lang['User_Posts_Deleted']						= 'Posts by this user have been deleted!';
		$lang['User_delete_topics']						= 'Delete this user\'s topics?';
		$lang['User_delete_topics_explain']				= 'Click here to delete every topic started by this user; this cannot be undone.';
		$lang['User_delete_posts']						= 'Delete this user\'s posts?';
		$lang['User_delete_posts_explain']				= 'Click here to delete every post made by this user; this cannot be undone.';


// registration check(includes/anti_spam_acp.php and includes/usercp_register.php)
	$lang['Profile_Error']								= 'You incorrectly filled in the %s field.';
	$lang['Profile_Error_Email']						= 'They incorrectly filled the %s field with "%s".';
	$lang['Profile_Error_Email_Required']				= 'They did not fill in the required %s field.';
	$lang['Registering']								= 'registering';
	$lang['Editing_Profile']							= 'editing their profile';
	$lang['During_Registration']						= 'Registration';
	$lang['No_Captcha_Code']							= 'No Captcha Code entered by user.  The code in the image was "%s".';
	$lang['Wrong_Captcha_Code']							= 'Incorrect Captcha Code entered.  Code in the image was: "%s".  They entered: "%s".';
	$lang['New_Confirm_Code_Explain']					= 'Enter the code exactly as you see it (there are no spaces). The code is case-sensitive (all letters are uppercase).  There is no 0 (zero).';

// posting check(includes/functions_post.php)
	$lang['Url_Not_Allowed']							= 'URL\'s/Links are not allowed.';
	$lang['Url_Not_Allowed_Guests']						= 'URL\'s/Links are not allowed for Guests.';
	$lang['Url_Not_Allowed_Count']						= 'You must have %s posts before you can post URL\'s/Links.';
	$lang['During_Posting']								= 'Posting';
	$lang['Posting']									= 'posting';
?>