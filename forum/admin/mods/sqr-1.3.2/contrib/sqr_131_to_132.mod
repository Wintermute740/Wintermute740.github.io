##############################################################
## MOD Title: SQR 1.3.1 to SQR 1.3.2 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.3.1 to 1.3.2
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 2 Minute
## Files To Edit: templates/subSilver/viewtopic_quickreply.tpl
##
##
## Included Files: (n/a)
##
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## phpBB 2.0.16 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-07-09 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl


#
#-----[ FIND ]------------------------------------------
#
var txtarea = document.post.message;
text = '[b]' + name + '[/b]' + '\r\n';


#
#-----[ BEFORE, ADD ]--------------------------------------
#
	sqr_show();


#
#-----[ FIND ]------------------------------------------
#
//-->
</script>


#
#-----[ BEFORE, ADD ]--------------------------------------
#
function sqr_show()
{
	var id = 'sqr';
	var item = null;

	if (document.getElementById)
	{
		item = document.getElementById(id);
	}
	else if (document.all)
	{
		item = document.all[id];
	}
	else if (document.layers)
	{
		item = document.layers[id];
	}

	if (item && item.style)
	{
		if (item.style.display == "none")
		{
			item.style.display = "";
		}
	}
	else if (item)
	{
		item.visibility = "show";
	}
}


#
#-----[ FIND ]------------------------------------------
#
#  NOTE - the origial text is:
# <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
javascript:emoticon


#
#-----[ REPLACE WITH ]---------------------------------------
#
				  <td><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" onmouseover="this.style.cursor='hand';" onclick="emoticon('{smilies_row.smilies_col.SMILEY_CODE}');" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></td>


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM