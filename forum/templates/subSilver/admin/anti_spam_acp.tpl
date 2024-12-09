<h1>{L_ANTI_SPAM_ACP} <span class="genmed">{L_ANTI_SPAM_ACP_CREATED_BY}</span></h1>

{VERSION_INFO}
<form action="{S_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_CHECK_VERSION}<br /><span class="gensmall">{L_CHECK_VERSION_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_check_version" value="1" {CHECK_VERSION_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_check_version" value="0" {CHECK_VERSION_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ACCT_ACTIVATION}:<br/><span class="gensmall">{L_ACCT_ACTIVATION_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}" {ACTIVATION_NONE_CHECKED} />{L_NONE}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_USER}" {ACTIVATION_USER_CHECKED} />{L_USER}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_ADMIN}" {ACTIVATION_ADMIN_CHECKED} />{L_ADMIN}</td>
	</tr>
	<tr>
		<td class="row1">{L_HIDE_INACTIVE_USERS}<br /><span class="gensmall">{L_HIDE_INACTIVE_USERS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_hide_inactive" value="1" {HIDE_INACTIVE_USERS_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_hide_inactive" value="0" {HIDE_INACTIVE_USERS_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_CAPTCHA_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_VISUAL_CONFIRM}:</td>
		<td class="row2"><input type="radio" name="enable_confirm" value="1" {CONFIRM_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="enable_confirm" value="0" {CONFIRM_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_CAPTCHA_VERSION}<br /><span class="gensmall">{L_CAPTCHA_VERSION_EXPLAIN}</span></td>
		<td class="row2">
			<input type="radio" name="as_acp_captcha" value="-1" {RANDOM_CAPTCHA} />{L_RANDOM_CAPTCHA}<br/>
			<input type="radio" name="as_acp_captcha" value="0" {PHPBB_CAPTCHA} />{L_PHPBB_CAPTCHA}<br/>
			<input type="radio" name="as_acp_captcha" value="1" {BETTER_CAPTCHA} />{L_BETTER_CAPTCHA}<br/>
		</td>
	</tr>
	<tr>
		<td class="row1">{L_CAPTCHA_NOISE}<br /><span class="gensmall">{L_CAPTCHA_NOISE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_captcha_noise" value="1" {CAPTCHA_NOISE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_captcha_noise" value="0" {CAPTCHA_NOISE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_CAPTCHA_CASE_SENSITIVE}<br /><span class="gensmall">{L_CAPTCHA_CASE_SENSITIVE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_captcha_case_sensative" value="1" {CAPTCHA_CASE_SENSITIVE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_captcha_case_sensative" value="0" {CAPTCHA_CASE_SENSITIVE_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_POSTING_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1" width="65%">{L_POSTING_URL}:<br /><span class="gensmall">{L_POSTING_URL_EXPLAIN}</span><br /></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left" width="190px"><input type="radio" name="as_acp_posting_url" value="off" {POSTING_URL_OFF} />{L_URL_OFF}</td>
					<td align="left" width="175px"><input type="radio" name="as_acp_posting_url" value="on" {POSTING_URL_ON} />{L_URL_ON}</td>
				</tr>
			</table>
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left" width="190px"><input type="radio" name="as_acp_posting_url" value="post count" {POSTING_URL_POST_COUNT} />{L_URL_POST_COUNT}</td>
					<td align="left" width="175px"><input class="post" type="text" maxlength="4" size="5" name="as_acp_posting_url_post" value="{POSTING_URL_POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left"><input type="radio" name="as_acp_posting_url" value="guest" {POSTING_URL_GUEST} />{L_GUEST}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_LOG_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_LOG_CAPTCHA}:<br /><span class="gensmall">{L_LOG_CAPTCHA_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_log_captcha" value="1" {LOG_CAPTCHA_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_log_captcha" value="0" {LOG_CAPTCHA_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PROFILE_LOG}:<br /><span class="gensmall">{L_PROFILE_LOG_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_log_profile" value="1" {PROFILE_LOG_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_log_profile" value="0" {PROFILE_LOG_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POSTING_URL_LOG}:<br /><span class="gensmall">{L_POSTING_URL_LOG_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_log_message_posting" value="1" {POSTING_URL_LOG_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_log_message_posting" value="0" {POSTING_URL_LOG_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_LOG_SHOW}:<br /><span class="gensmall">{L_LOG_SHOW_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="5" name="as_acp_spam_log_pagination" value="{LOG_SHOW}" /> {L_LOGS}</td>
	</tr>
	<tr>
		<td class="row1">{L_EMAIL_ADDRESS}: <br /><span class="gensmall">{L_EMAIL_ADDRESS_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="25" name="as_acp_email_for_spam" value="{EMAIL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SEND_MAIL}: <br /><span class="gensmall">{L_SEND_MAIL_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="as_acp_notify_on_spam" value="1" {SEND_MAIL_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="as_acp_notify_on_spam" value="0" {SEND_MAIL_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TEST_MAIL}: <br /><span class="gensmall">{L_TEST_MAIL_EXPLAIN}</span></td>
		<td class="row2"><input type="submit" name="test_mail" value="{L_TEST_MAIL}" class="mainoption" /></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>

<br clear="all" />