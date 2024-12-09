############################################################## 
## MOD Title: SMTP PHPMailer
## MOD Author: Ian Channing; ian@klever.co.uk
## MOD Description: Bridges phpBB to PHPMailer's nice SMTP functions.
## MOD Version: 0.1; created for phpBB 2.0.23
## 
## Installation Level: Easy
## Installation Time: ~10 Minutes 
## Files To Edit: 
##		  admin/admin_board.php
##		  templates/subSilver/admin/board_config_body.tpl
##		  language/lang_english/lang_admin.php
##		  includes/emailer.php
## Included Files:
##		  .gitignore
##		  .travis.yml
##		  changelog.md
##		  class.phpmailer.php
##		  class.pop3.php
##		  class.smtp.php
##		  composer.json
##		  docs
##		  examples
##		  extras
##		  language
##		  LICENSE
##		  phpbb2_smtp_phpmailer.mod
##		  phpbb2_smtp_phpmailer.php
##		  README.md
##		  test
##		  docs\Callback_function_notes.txt
##		  docs\DomainKeys_notes.txt
##		  docs\extending.html
##		  docs\faq.html
##		  docs\generatedocs.sh
##		  docs\Note_for_SMTP_debugging.txt
##		  docs\pop3_article.txt
##		  examples\code_generator.phps
##		  examples\contents.html
##		  examples\exceptions.phps
##		  examples\gmail.phps
##		  examples\images
##		  examples\index.html
##		  examples\LGPLv3.txt
##		  examples\mail.phps
##		  examples\mailing_list.phps
##		  examples\pop_before_smtp.phps
##		  examples\scripts
##		  examples\sendmail.phps
##		  examples\smtp.phps
##		  examples\smtp_no_auth.phps
##		  examples\styles
##		  examples\images\phpmailer.png
##		  examples\images\phpmailer_mini.gif
##		  examples\scripts\shAutoloader.js
##		  examples\scripts\shBrushPhp.js
##		  examples\scripts\shCore.js
##		  examples\scripts\shLegacy.js
##		  examples\scripts\XRegExp.js
##		  examples\styles\shCore.css
##		  examples\styles\shCoreDefault.css
##		  examples\styles\shCoreDjango.css
##		  examples\styles\shCoreEclipse.css
##		  examples\styles\shCoreEmacs.css
##		  examples\styles\shCoreFadeToGrey.css
##		  examples\styles\shCoreMDUltra.css
##		  examples\styles\shCoreMidnight.css
##		  examples\styles\shCoreRDark.css
##		  examples\styles\shThemeAppleScript.css
##		  examples\styles\shThemeDefault.css
##		  examples\styles\shThemeDjango.css
##		  examples\styles\shThemeEclipse.css
##		  examples\styles\shThemeEmacs.css
##		  examples\styles\shThemeFadeToGrey.css
##		  examples\styles\shThemeMDUltra.css
##		  examples\styles\shThemeMidnight.css
##		  examples\styles\shThemeRDark.css
##		  examples\styles\shThemeVisualStudio.css
##		  examples\styles\wrapping.png
##		  extras\class.html2text.php
##		  extras\EasyPeasyICS.php
##		  extras\htmlfilter.php
##		  extras\ntlm_sasl_client.php
##		  language\phpmailer.lang-ar.php
##		  language\phpmailer.lang-br.php
##		  language\phpmailer.lang-ca.php
##		  language\phpmailer.lang-ch.php
##		  language\phpmailer.lang-cz.php
##		  language\phpmailer.lang-de.php
##		  language\phpmailer.lang-dk.php
##		  language\phpmailer.lang-eo.php
##		  language\phpmailer.lang-es.php
##		  language\phpmailer.lang-et.php
##		  language\phpmailer.lang-fi.php
##		  language\phpmailer.lang-fo.php
##		  language\phpmailer.lang-fr.php
##		  language\phpmailer.lang-he.php
##		  language\phpmailer.lang-hu.php
##		  language\phpmailer.lang-it.php
##		  language\phpmailer.lang-ja.php
##		  language\phpmailer.lang-lt.php
##		  language\phpmailer.lang-nl.php
##		  language\phpmailer.lang-no.php
##		  language\phpmailer.lang-pl.php
##		  language\phpmailer.lang-ro.php
##		  language\phpmailer.lang-ru.php
##		  language\phpmailer.lang-se.php
##		  language\phpmailer.lang-sk.php
##		  language\phpmailer.lang-tr.php
##		  language\phpmailer.lang-uk.php
##		  language\phpmailer.lang-zh.php
##		  language\phpmailer.lang-zh_cn.php
##		  test\fakesendmail.sh
##		  test\phpmailerLangTest.php
##		  test\phpmailerTest.php
##		  test\testbootstrap-dist.php
##		  test\test_callback.php
############################################################## 
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
##  * Includes the [PHP Mailer](https://github.com/PHPMailer/PHPMailer) classes as is
##  * Most of the MODs to PHPBB are copied from the [BetterSMTP MOD]()
## 
############################################################## 
## MOD History: 
## 0.1 versioning start
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'smtp_port', '25' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'smtp_auth_mech', 'none' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'use_smtp_tls', '0' );

#
#-----[ COPY ]------------------------------------------
#
# Effectively copy all files to includes/smtp_phpmailer/

copy .gitignore									to includes/smtp_phpmailer/.gitignore
copy .travis.yml								to includes/smtp_phpmailer/.travis.yml
copy changelog.md								to includes/smtp_phpmailer/changelog.md
copy class.phpmailer.php						to includes/smtp_phpmailer/class.phpmailer.php
copy class.pop3.php								to includes/smtp_phpmailer/class.pop3.php
copy class.smtp.php								to includes/smtp_phpmailer/class.smtp.php
copy composer.json								to includes/smtp_phpmailer/composer.json
copy docs										to includes/smtp_phpmailer/docs
copy examples									to includes/smtp_phpmailer/examples
copy extras										to includes/smtp_phpmailer/extras
copy language									to includes/smtp_phpmailer/language
copy LICENSE									to includes/smtp_phpmailer/LICENSE
copy phpbb2_smtp_phpmailer.mod					to includes/smtp_phpmailer/phpbb2_smtp_phpmailer.mod
copy phpbb2_smtp_phpmailer.php					to includes/smtp_phpmailer/phpbb2_smtp_phpmailer.php
copy README.md									to includes/smtp_phpmailer/README.md
copy test										to includes/smtp_phpmailer/test
copy docs\Callback_function_notes.txt			to includes/smtp_phpmailer/docs\Callback_function_notes.txt
copy docs\DomainKeys_notes.txt					to includes/smtp_phpmailer/docs\DomainKeys_notes.txt
copy docs\extending.html						to includes/smtp_phpmailer/docs\extending.html
copy docs\faq.html								to includes/smtp_phpmailer/docs\faq.html
copy docs\generatedocs.sh						to includes/smtp_phpmailer/docs\generatedocs.sh
copy docs\Note_for_SMTP_debugging.txt			to includes/smtp_phpmailer/docs\Note_for_SMTP_debugging.txt
copy docs\pop3_article.txt						to includes/smtp_phpmailer/docs\pop3_article.txt
copy examples\code_generator.phps				to includes/smtp_phpmailer/examples\code_generator.phps
copy examples\contents.html						to includes/smtp_phpmailer/examples\contents.html
copy examples\exceptions.phps					to includes/smtp_phpmailer/examples\exceptions.phps
copy examples\gmail.phps						to includes/smtp_phpmailer/examples\gmail.phps
copy examples\images							to includes/smtp_phpmailer/examples\images
copy examples\index.html						to includes/smtp_phpmailer/examples\index.html
copy examples\LGPLv3.txt						to includes/smtp_phpmailer/examples\LGPLv3.txt
copy examples\mail.phps							to includes/smtp_phpmailer/examples\mail.phps
copy examples\mailing_list.phps					to includes/smtp_phpmailer/examples\mailing_list.phps
copy examples\pop_before_smtp.phps				to includes/smtp_phpmailer/examples\pop_before_smtp.phps
copy examples\scripts							to includes/smtp_phpmailer/examples\scripts
copy examples\sendmail.phps						to includes/smtp_phpmailer/examples\sendmail.phps
copy examples\smtp.phps							to includes/smtp_phpmailer/examples\smtp.phps
copy examples\smtp_no_auth.phps					to includes/smtp_phpmailer/examples\smtp_no_auth.phps
copy examples\styles							to includes/smtp_phpmailer/examples\styles
copy examples\images\phpmailer.png				to includes/smtp_phpmailer/examples\images\phpmailer.png
copy examples\images\phpmailer_mini.gif			to includes/smtp_phpmailer/examples\images\phpmailer_mini.gif
copy examples\scripts\shAutoloader.js			to includes/smtp_phpmailer/examples\scripts\shAutoloader.js
copy examples\scripts\shBrushPhp.js				to includes/smtp_phpmailer/examples\scripts\shBrushPhp.js
copy examples\scripts\shCore.js					to includes/smtp_phpmailer/examples\scripts\shCore.js
copy examples\scripts\shLegacy.js				to includes/smtp_phpmailer/examples\scripts\shLegacy.js
copy examples\scripts\XRegExp.js				to includes/smtp_phpmailer/examples\scripts\XRegExp.js
copy examples\styles\shCore.css					to includes/smtp_phpmailer/examples\styles\shCore.css
copy examples\styles\shCoreDefault.css			to includes/smtp_phpmailer/examples\styles\shCoreDefault.css
copy examples\styles\shCoreDjango.css			to includes/smtp_phpmailer/examples\styles\shCoreDjango.css
copy examples\styles\shCoreEclipse.css			to includes/smtp_phpmailer/examples\styles\shCoreEclipse.css
copy examples\styles\shCoreEmacs.css			to includes/smtp_phpmailer/examples\styles\shCoreEmacs.css
copy examples\styles\shCoreFadeToGrey.css		to includes/smtp_phpmailer/examples\styles\shCoreFadeToGrey.css
copy examples\styles\shCoreMDUltra.css			to includes/smtp_phpmailer/examples\styles\shCoreMDUltra.css
copy examples\styles\shCoreMidnight.css			to includes/smtp_phpmailer/examples\styles\shCoreMidnight.css
copy examples\styles\shCoreRDark.css			to includes/smtp_phpmailer/examples\styles\shCoreRDark.css
copy examples\styles\shThemeAppleScript.css		to includes/smtp_phpmailer/examples\styles\shThemeAppleScript.css
copy examples\styles\shThemeDefault.css			to includes/smtp_phpmailer/examples\styles\shThemeDefault.css
copy examples\styles\shThemeDjango.css			to includes/smtp_phpmailer/examples\styles\shThemeDjango.css
copy examples\styles\shThemeEclipse.css			to includes/smtp_phpmailer/examples\styles\shThemeEclipse.css
copy examples\styles\shThemeEmacs.css			to includes/smtp_phpmailer/examples\styles\shThemeEmacs.css
copy examples\styles\shThemeFadeToGrey.css		to includes/smtp_phpmailer/examples\styles\shThemeFadeToGrey.css
copy examples\styles\shThemeMDUltra.css			to includes/smtp_phpmailer/examples\styles\shThemeMDUltra.css
copy examples\styles\shThemeMidnight.css		to includes/smtp_phpmailer/examples\styles\shThemeMidnight.css
copy examples\styles\shThemeRDark.css			to includes/smtp_phpmailer/examples\styles\shThemeRDark.css
copy examples\styles\shThemeVisualStudio.css	to includes/smtp_phpmailer/examples\styles\shThemeVisualStudio.css
copy examples\styles\wrapping.png				to includes/smtp_phpmailer/examples\styles\wrapping.png
copy extras\class.html2text.php					to includes/smtp_phpmailer/extras\class.html2text.php
copy extras\EasyPeasyICS.php					to includes/smtp_phpmailer/extras\EasyPeasyICS.php
copy extras\htmlfilter.php						to includes/smtp_phpmailer/extras\htmlfilter.php
copy extras\ntlm_sasl_client.php				to includes/smtp_phpmailer/extras\ntlm_sasl_client.php
copy language\phpmailer.lang-ar.php				to includes/smtp_phpmailer/language\phpmailer.lang-ar.php
copy language\phpmailer.lang-br.php				to includes/smtp_phpmailer/language\phpmailer.lang-br.php
copy language\phpmailer.lang-ca.php				to includes/smtp_phpmailer/language\phpmailer.lang-ca.php
copy language\phpmailer.lang-ch.php				to includes/smtp_phpmailer/language\phpmailer.lang-ch.php
copy language\phpmailer.lang-cz.php				to includes/smtp_phpmailer/language\phpmailer.lang-cz.php
copy language\phpmailer.lang-de.php				to includes/smtp_phpmailer/language\phpmailer.lang-de.php
copy language\phpmailer.lang-dk.php				to includes/smtp_phpmailer/language\phpmailer.lang-dk.php
copy language\phpmailer.lang-eo.php				to includes/smtp_phpmailer/language\phpmailer.lang-eo.php
copy language\phpmailer.lang-es.php				to includes/smtp_phpmailer/language\phpmailer.lang-es.php
copy language\phpmailer.lang-et.php				to includes/smtp_phpmailer/language\phpmailer.lang-et.php
copy language\phpmailer.lang-fi.php				to includes/smtp_phpmailer/language\phpmailer.lang-fi.php
copy language\phpmailer.lang-fo.php				to includes/smtp_phpmailer/language\phpmailer.lang-fo.php
copy language\phpmailer.lang-fr.php				to includes/smtp_phpmailer/language\phpmailer.lang-fr.php
copy language\phpmailer.lang-he.php				to includes/smtp_phpmailer/language\phpmailer.lang-he.php
copy language\phpmailer.lang-hu.php				to includes/smtp_phpmailer/language\phpmailer.lang-hu.php
copy language\phpmailer.lang-it.php				to includes/smtp_phpmailer/language\phpmailer.lang-it.php
copy language\phpmailer.lang-ja.php				to includes/smtp_phpmailer/language\phpmailer.lang-ja.php
copy language\phpmailer.lang-lt.php				to includes/smtp_phpmailer/language\phpmailer.lang-lt.php
copy language\phpmailer.lang-nl.php				to includes/smtp_phpmailer/language\phpmailer.lang-nl.php
copy language\phpmailer.lang-no.php				to includes/smtp_phpmailer/language\phpmailer.lang-no.php
copy language\phpmailer.lang-pl.php				to includes/smtp_phpmailer/language\phpmailer.lang-pl.php
copy language\phpmailer.lang-ro.php				to includes/smtp_phpmailer/language\phpmailer.lang-ro.php
copy language\phpmailer.lang-ru.php				to includes/smtp_phpmailer/language\phpmailer.lang-ru.php
copy language\phpmailer.lang-se.php				to includes/smtp_phpmailer/language\phpmailer.lang-se.php
copy language\phpmailer.lang-sk.php				to includes/smtp_phpmailer/language\phpmailer.lang-sk.php
copy language\phpmailer.lang-tr.php				to includes/smtp_phpmailer/language\phpmailer.lang-tr.php
copy language\phpmailer.lang-uk.php				to includes/smtp_phpmailer/language\phpmailer.lang-uk.php
copy language\phpmailer.lang-zh.php				to includes/smtp_phpmailer/language\phpmailer.lang-zh.php
copy language\phpmailer.lang-zh_cn.php			to includes/smtp_phpmailer/language\phpmailer.lang-zh_cn.php
copy test\fakesendmail.sh						to includes/smtp_phpmailer/test\fakesendmail.sh
copy test\phpmailerLangTest.php					to includes/smtp_phpmailer/test\phpmailerLangTest.php
copy test\phpmailerTest.php						to includes/smtp_phpmailer/test\phpmailerTest.php
copy test\testbootstrap-dist.php				to includes/smtp_phpmailer/test\testbootstrap-dist.php
copy test\test_callback.php						to includes/smtp_phpmailer/test\test_callback.php


# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$timezone_select = tz_select($new['board_timezone'], 'board_timezone');

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$smtp_auth_mech_select = smtp_auth_mech_select($new['smtp_auth_mech']);

# 
#-----[ FIND ]------------------------------------------ 
# 

"SMTP_HOST" => $new['smtp_host'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

"SMTP_PORT" => $new['smtp_port'],
"SMTP_AUTH_MECH_SELECT" => $smtp_auth_mech_select,
"S_USE_SMTP_TLS_YES" => $use_smtp_tls_yes,
"S_USE_SMTP_TLS_NO" => $use_smtp_tls_no,


# 
#-----[ FIND ]------------------------------------------ 
# 

"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

"L_SMTP_PORT" => $lang['SMTP_port'],
"L_SMTP_AUTH_MECH" => $lang['SMTP_auth_mech'],
"L_SMTP_AUTH_MECH_EXPLAIN" => $lang['SMTP_auth_mech_explain'],
"L_USE_SMTP_TLS" => $lang['use_smtp_tls'],
"L_USE_SMTP_TLS_EXPLAIN" => $use_smtp_tls_error,

# 
#-----[ FIND ]------------------------------------------ 
# 

$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$has_openssl = extension_loaded("openssl");
if ($new['use_smtp_tls']) {
    $use_smtp_tls_yes = "checked=\"checked\"";
} else {
    if ($has_openssl) {
        $use_smtp_tls_yes = "";
    } else {
        $use_smtp_tls_yes = "disabled";
        $use_smtp_tls_error = $lang['use_smtp_tls_error'];
    }
}
$use_smtp_tls_no = ( !$new['use_smtp_tls'] ) ? "checked=\"checked\"" : "";


# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr>
	<td class="row1">{L_SMTP_SERVER}</td>
	<td class="row2"><input class="post" type="text" name="smtp_host" value="{SMTP_HOST}" size="25" maxlength="50" /></td>
</tr>


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr>
	<td class="row1">{L_SMTP_PORT}</td>
	<td class="row2"><input class="post" type="text" name="smtp_port" value="{SMTP_PORT}" size="5" maxlength="5" /></td>
</tr>

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr>
	<td class="row1">{L_SMTP_PASSWORD}<br /><span class="gensmall">{L_SMTP_PASSWORD_EXPLAIN}</span></td>
	<td class="row2"><input class="post" type="password" name="smtp_password" value="{SMTP_PASSWORD}" size="25" maxlength="255" /></td>
</tr>



# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr>
	<td class="row1">{L_SMTP_AUTH_MECH}<br /><span class="gensmall">{L_SMTP_AUTH_MECH_EXPLAIN}</span></td>
	<td class="row2">{SMTP_AUTH_MECH_SELECT}</td>
</tr>
<tr>
	<td class="row1">{L_USE_SMTP_TLS}<br /><span class="gensmall">{L_USE_SMTP_TLS_EXPLAIN}</span></td>
	<td class="row2"><input type="radio" name="use_smtp_tls" value="1" {S_USE_SMTP_TLS_YES}/> {L_YES}&nbsp;&nbsp;<input type="radio" name="use_smtp_tls" value="0" {S_USE_SMTP_TLS_NO}/> {L_NO}</td>
</tr>

	
# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// SMTP PHPMailer MOD
$lang['SMTP_port'] = 'SMTP Server Port';
$lang['SMTP_auth_mech'] = 'Authentication Method';
$lang['SMTP_auth_mech_explain'] = '&quot;none&quot; and &quot;login&quot; are the options originally supported by phpBB';
$lang['use_smtp_tls'] = 'Server uses Secure Authentication (SSL/TLS)';
$lang['use_smtp_tls_error'] = '<b>WARNING: This PHP engine cannot use secure authentication!</b><br />Make sure you\'re running PHP version >= 4.3.0 with <a href="http://www.php.net/openssl" target="_blank">openssl</a> enabled.';

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_selects.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//
// Select smtp_auth_mech
//
function smtp_auth_mech_select($value) {
    # defaults to 'none'
    $methods = array("none", "login", "plain", "cram-md5", "digest-md5");
    $s = '<select name="smtp_auth_mech">' . chr(13);
    foreach ($methods as $method) {
        $s .= '<option value="' . $method . '"';
        if ($value == $method) {
            $s.= ' SELECTED';
        }
        $s.= '>' . $method . '</option>';
    }
    $s.= '</select>';
    return $s;
}

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/emailer.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$result = smtpmail($to, $this->subject, $this->msg, $this->extra_headers);

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

// SMTP PHPMailer MOD
require("smtp_phpmailer/phpbb2_smtp_phpmailer.php");
$result = smtpsquirrelmail($to, $this->subject, $this->msg, $this->extra_headers);

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM