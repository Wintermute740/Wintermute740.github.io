##############################################################
## MOD Title: User Profile Link with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install User Profile Link MOD
##                  together with Super Quick Reply MOD v1.2.1 and
##                  allows to solve a problem with JavaScript errors
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 2 Minutes
## Files To Edit: viewtopic.php
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
## Use this MOD if you have installed one of the following MODs:
##  - Username Color ( http://www.phpbb.com/phpBB/viewtopic.php?t=187354 )
##  - Link Poster's Name To Profile ( http://www.phpbb.com/phpBB/viewtopic.php?t=210954 )
##  - Mini Profile ( http://www.phpbb.com/phpBB/viewtopic.php?t=110870 )
##  - Author Hyperlink ( http://www.phpbb.com/phpBB/viewtopic.php?t=135776 )
##  - Online/Offline/Hidden ( http://www.phpbb.com/phpBB/viewtopic.php?t=228106 )
##
## 1. User Profile Link MOD
## 2. Install Super Quick Reply MOD v1.2.1
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-14 - Version 1.0.1
##      - added notes about Online/Offline/Hidden
##
##   2005-03-09 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$poster = '<a href="javascript:pn(\''.$poster.'\');">'.$poster.'</a>'

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$poster

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
//$poster

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM