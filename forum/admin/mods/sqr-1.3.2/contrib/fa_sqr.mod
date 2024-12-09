##############################################################
## MOD Title: File Attachment MOD with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install File Attachment MOD together
##                  with Super Quick Reply MOD v1.2.1
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/viewtopic_quickreply.php,
##                templates/subSilver/viewtopic_quickreply.tpl
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
## 1. Install File Attachment MOD v2.3.11 ( http://www.phpbb.com/phpBB/viewtopic.php?t=74505 )
## 2. Install Super Quick Reply MOD v1.2.1
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-10 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]---------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]---------------------------------------------
#
$template->assign_block_vars('switch_advanced_qr', array());

#
#-----[ AFTER, ADD ]---------------------------------------
#
execute_posting_attachment_handling();

#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]---------------------------------------------
#
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">

#
#-----[ REPLACE WITH ]---------------------------------------
#
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)" {S_FORM_ENCTYPE}>

#
#-----[ FIND ]---------------------------------------------
#
<tr>
<td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}

#
#-----[ BEFORE, ADD ]---------------------------------------
#
   {ATTACHBOX}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM