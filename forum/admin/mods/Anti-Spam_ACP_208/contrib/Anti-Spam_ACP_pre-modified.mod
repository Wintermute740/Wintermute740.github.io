##############################################################
## MOD Title: Anti-Spam ACP Pre-Modified
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
##
## MOD Description: Blocks spam in many ways from your board.  Includes a new captcha, url posting control,
##				an inactive userlist, profile options control, a spam log, an email notification option, and more!
##
## MOD Version: 2.0.8
##
## Installation Level:	Easy
## Installation Time:	~2 min
##
## Files To Edit:	(none)
##
## Included Files:	admin/admin_anti_spam_acp.php
##					admin_anti_spam_acp_inactive.php
##					admin/admin_anti_spam_acp_log.php
##					admin/admin_anti_spam_acp_profile.php
##					admin/admin_users.php
##					includes/better_captcha_fonts/*
##					includes/constants.php
##					include/functions.php
##					includes/anti_spam_acp.php
##					includes/functions_anti_spam_acp.php
##					includes/functions_post.php
##					includes/usercp_captcha.php
##					includes/usercp_register.php
##					language/lang_english/email/admin_spam_notification.tpl
##					language/lang_english/lang_anti_spam_acp.php
##					templates/subSilver/admin/anti_spam_acp.tpl
##					templates/subSilver/admin/anti_spam_acp_inactive.tpl
##					templates/subSilver/admin/anti_spam_acp_log.tpl
##					templates/subSilver/admin/anti_spam_acp_profile.tpl
##					templates/subSilver/admin/user_edit_body.tpl
##					templates/subSilver/images/arrowdown.png
##					templates/subSilver/images/arrowright.png
##					templates/subSilver/overall_footer.tpl
## 					templates/subSilver/posting_body.tpl
##					templates/subSilver/profile_add_body.tpl
##					memberlist.php
##					posting.php
##					profile.php
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
##	+ My official thread for this mod is here: http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=10&t=4
##		- Please ask for support in the Anti-Spam ACP support forum, which is located here:
##			+ http://www.lithiumstudios.org/phpBB3/viewforum.php?f=25
##	+ If you would like to support my work, you can do so by donating.  It can take a lot of time to code and support your modifications.
##		- You can donate with PayPal here:
##		- http://tinyurl.com/ymtctj
##	+ I HIGHLY reccomend you use EasyMod to install this mod(make sure you are using the latest version of EasyMod when you do)
##		- The biggest reason for errors after installing this mod is user installation error.  If EasyMod detects an error
##			+ it will let you know before it does any changes.
##
##	+ This is the package that uses pre-modified phpBB 2.0.22 files!
##		- If any of the files this mod asks to write over have already been changed, use the normal package.
##		- If you are using a version of phpBB2 that is newer than 2.0.22 either use the normal package, or look on my website(lithiumstudios.org)
##			+ to see if a newer package is available.
##
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
#-----[ COPY ]------------------------------------------
#

copy root/admin/admin_anti_spam_acp.php								to admin/admin_anti_spam_acp.php
copy root/admin_anti_spam_acp_inactive.php							to admin_anti_spam_acp_inactive.php
copy root/admin/admin_anti_spam_acp_log.php							to admin/admin_anti_spam_acp_log.php
copy root/admin/admin_anti_spam_acp_profile.php						to admin_anti_spam_acp_profile.php
copy premod_root/admin/admin_users.php								to admin/admin_users.php
copy root/includes/better_captcha_fonts/*.*							to includes/better_captcha_fonts/*.*
copy premod_root/includes/constants.php								to includes/constants.php
copy premod_root/include/functions.php								to include/functions.php
copy root/includes/anti_spam_acp.php								to includes/anti_spam_acp.php
copy root/includes/functions_anti_spam_acp.php						to includes/functions_anti_spam_acp.php
copy premod_root/includes/functions_post.php						to includes/functions_post.php
copy root/includes/usercp_captcha.php								to includes/usercp_captcha.php
copy premod_root/includes/usercp_register.php						to includes/usercp_register.php
copy root/language/lang_english/email/admin_spam_notification.tpl	to language/lang_english/email/admin_spam_notification.tpl
copy root/language/lang_english/lang_anti_spam_acp.php				to language/lang_english/lang_anti_spam_acp.php
copy root/templates/subSilver/admin/anti_spam_acp.tpl				to templates/subSilver/admin/anti_spam_acp.tpl
copy root/templates/subSilver/admin/anti_spam_acp_inactive.tpl		to templates/subSilver/admin/anti_spam_acp_inactive.tpl
copy root/templates/subSilver/admin/anti_spam_acp_log.tpl			to templates/subSilver/admin/anti_spam_acp_log.tpl
copy root/templates/subSilver/admin/anti_spam_acp_profile.tpl		to templates/subSilver/admin/anti_spam_acp_profile.tpl
copy premod_root/templates/subSilver/admin/user_edit_body.tpl		to templates/subSilver/admin/user_edit_body.tpl
copy root/templates/subSilver/images/arrowdown.png					to templates/subSilver/images/arrowdown.png
copy root/templates/subSilver/images/arrowright.png					to templates/subSilver/images/arrowright.png
copy premod_root/templates/subSilver/overall_footer.tpl				to templates/subSilver/overall_footer.tpl
copy premod_root/templates/subSilver/posting_body.tpl				to templates/subSilver/posting_body.tpl
copy premod_root/templates/subSilver/profile_add_body.tpl			to templates/subSilver/profile_add_body.tpl
copy premod_root/memberlist.php										to memberlist.php
copy premod_root/posting.php										to posting.php
copy premod_root/profile.php										to profile.php

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM