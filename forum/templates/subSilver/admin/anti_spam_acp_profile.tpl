<h1>{L_ANTI_SPAM_ACP} <span class="genmed">{L_ANTI_SPAM_ACP_CREATED_BY}</span></h1>

{VERSION_INFO}
<form action="{S_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_PROFILE_SETTINGS}</th>
	</tr>
	<!-- BEGIN field_row -->
	<tr>
		<td class="row1" width="65%">{field_row.L_TITLE}:</td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left" width="200px"><input type="radio" name="{field_row.NAME}" value="off" {field_row.OFF} />{L_OFF}</td>
					<td align="left" width="150px"><input type="radio" name="{field_row.NAME}" value="reg off" {field_row.REG_OFF} />{L_REG_OFF}</td>
				</tr>
			</table>
			<table  width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left" width="200px"><input type="radio" name="{field_row.NAME}" value="post count" {field_row.POST_COUNT} />{L_POST_COUNT}</td>
					<td align="left" width="150px"><input class="post" type="text" maxlength="4" size="5" name="{field_row.NAME}_post" value="{field_row.POSTS}" /> {L_POSTS}</td>
				</tr>
			</table>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td align="left" width="200px"><input type="radio" name="{field_row.NAME}" value="on" {field_row.ON} />{L_ON}</td>
					<td align="left" width="150px"><input type="radio" name="{field_row.NAME}" value="required" {field_row.REQUIRED} />{L_REQUIRED}</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END field_row -->
	<tr>
		<td class="row1">{L_SYNC}: <br /><span class="gensmall">{L_SYNC_EXPLAIN}</span></td>
		<td class="row2"><input type="submit" name="sync" value="{L_SYNC}" class="mainoption" /></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>

<br clear="all" />
