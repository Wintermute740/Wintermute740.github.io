##############################################################
## MOD Title: SQR 1.2.1 to SQR 1.2.2 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.2.1 to 1.2.2
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 2 Minutes
## Files To Edit: includes/viewtopic_quickreply.php
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
## phpBB 2.0.13 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-11 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
if ( ($userdata['user_quickreply_mode']==1) && ($userdata['user_id'] != ANONYMOUS) || ($board_config['anonymous_sqr_mode']==1) )

#
#-----[ REPLACE WITH ]--------------------------------------
#
if ( (($userdata['user_quickreply_mode']==1) && ($userdata['user_id'] != ANONYMOUS)) || (($board_config['anonymous_sqr_mode']==1) && ($userdata['user_id'] == ANONYMOUS)) )

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM