<h1>{L_ANTI_SPAM_ACP} <span class="genmed">{L_ANTI_SPAM_ACP_CREATED_BY}</span></h1>

{VERSION_INFO}
<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td width="100%">&nbsp;</td>
		<td align="right" nowrap="nowrap"><span class="gen">{L_SORT_BY}</td>
      	<td nowrap="nowrap">{S_SELECT_SORT}</td> 
      	<td nowrap="nowrap">{S_SELECT_SORT_ORDER}</td>
		<td nowrap="nowrap"><span class="gen">{L_SHOW}</span></td>
		<td nowrap="nowrap"><input type="text" size="4" value="{S_SHOW}" name="show" /></td>
		<td nowrap="nowrap">{S_HIDDEN_FIELDS}<input type="submit" value="{S_SORT}" name="change_sort" class="liteoption" /></td>
	</tr>
</table>
</form>

<form action="{S_ACTION}" method="post"> 
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th width="20%" align="center"><b>{L_DATE}</b></th>
		<th width="27%" align="center"><b>{L_USERNAME}</b></th>
		<th width="8%" align="center"><b>{L_LOCATION}</b></th>
		<th width="15%" align="center"><b>{L_USER_IP}</b></th>
		<th width="30%" align="center"><b>{L_USER_EMAIL}</b></th>
	</tr>
	<!-- BEGIN log_row -->
	<tr>
		<td class="row3" align="center"><b>{log_row.DATE}</b></td>
		<td class="row3" align="center"><b>{log_row.USERNAME}</b></td>
		<td class="row3" align="center"><b>{log_row.LOCATION}</b></td>
		<td class="row3" align="center"><b>{log_row.USER_IP}</b></td>
		<td class="row3" align="center"><b>{log_row.USER_EMAIL}</b></td>
	</tr>
	<tr>
		<td colspan="6" class="row2" align="center">{log_row.TRIGGERS}</td>
	</tr>
	<!-- END log_row -->
	<!-- BEGIN no_rows -->
	<tr>
		<td align="center" colspan="6">{L_NO_ROWS}</td>
	</tr>
	<!-- END no_rows -->
	<tr>
		<td class="catbottom" colspan="6" align="center">
			<select name="mode" class="post">
				<option value="">{L_SELECT}</option>
				<option value="delete">{L_CLEAR_LOG}</option>
			</select>
			<input type="submit" name="submit" value="{L_GO}" class="mainoption" />
		</td>
	</tr>
</table>
</form>

<table width="100%" cellpadding="3" cellspacing="1" border="0"> 
   <tr> 
      <td align="left" width="50%"><span class="gen">{PAGE_NUMBER}</span></td> 
      <td align="right" width="50%"><span class="gen">{PAGINATION}</span></td> 
   </tr> 
</table>

<br clear="all" />