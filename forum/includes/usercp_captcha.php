<?php
/***************************************************************************
 *                                 usercp_captcha.php
 *			       -------------------
 *   copyright	: (C) 2007 EXreaction
 *   email                : support@lithiumstudios.org
 *
 *                                        Original(Heavily modified with demo code and other changes, though quite a bit of original code exists)
 *			       -------------------        
 *   copyright  : (C) 2006 paul sohier
 *   email      : webmaster@paulscripts.nl
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( ( !defined('IN_PHPBB') ) && ($_GET['demo'] != 'true') )
{
	die('Hacking attempt');
	exit;
}

/**
  * Function to create a random color
  * @auteur mastercode.nl
  * @param $type string Mode for the color
  * @return int
  **/
function color($type)
{
	switch($type)
	{
		case "bg":
			$color = rand(224,255);
		break;
		case "tekst":
			$color = rand(0,127);
		break;
		case "bgtekst":
			$color = rand(200,224);
		break;
		default:
			$color = rand(0,255);
		break;
	}
	return $color;
}

/**
  * Function to return a ttf file from fonts map
  * @auteur mastercode.nl
  * @return string
  **/
function font()
{
	global $phpbb_root_path,$phpEx;
	static $ar;
	$f = opendir($phpbb_root_path . 'includes/better_captcha_fonts');
	if(!is_array($ar))
	{
		$ar = array();
		while(($file = @readdir($f)) !== false)
		{
			if(!in_array($file,array('.','..')) && eregi('.ttf',$file))
			{
		 		$ar[] = $file;
		 	}
		}
	}
	if(count($ar))
	{
	//	shuffle($ar);
		$i = rand(0,(count($ar) - 1));
		return $phpbb_root_path . 'includes/better_captcha_fonts/' . $ar[$i];
	}
	else
	{
		//There where NO font files. Included old confirm code.
 		require($phpbb_root_path . 'includes/usercp_confirm.' . $phpEx);
 		die;
	}
}

/*
 * Pick the captcha we want to use
 */
function pick_captcha($captcha)
{
	global $phpbb_root_path, $phpEx;

	// for the random option
	if ($captcha == '-1')
	{
		$captcha = rand(0, 1);
	}

	switch ($captcha)
	{
		case '0': // Default Captcha
			return $phpbb_root_path . 'includes/usercp_confirm.' . $phpEx;
		case '1': // Modified Better Captcha
			return true;
		default: // if the number is not something it should be use the modified better captcha
			return true;
	}
}

/*
 * Demo stuff
 */
if ($_GET['demo'] != 'true')
{
	// load the captcha we want to use
	if (pick_captcha($board_config['as_acp_captcha']) !== true)
	{
		require pick_captcha($board_config['as_acp_captcha']);
	}

	$confirm_id = htmlspecialchars($HTTP_GET_VARS['id']);

	if ( (!preg_match('/^[A-Za-z0-9]+$/', $confirm_id)) || empty($confirm_id) )
	{
		die('Bad Confirm ID');
	}

	if(!extension_loaded("gd") || (!function_exists('imagettftext')) )
	{
		require($phpbb_root_path . 'includes/usercp_confirm.' . $phpEx);
		die;
	}

	$sql = 'SELECT code
		FROM ' . CONFIRM_TABLE . "
		WHERE session_id = '" . $userdata['session_id'] . "'
			AND confirm_id = '$confirm_id'";
	$result = $db->sql_query($sql);

	if ($row = $db->sql_fetchrow($result))
	{
		$db->sql_freeresult($result);
		$code = $row['code'];
	}
	else
	{
		exit;
	}
}
else
{
	define('IN_PHPBB', true);
	$phpbb_root_path = './../';
	include($phpbb_root_path . 'extension.inc');
	include($phpbb_root_path . 'common.'.$phpEx);

	//
	// Start session management
	//
	$userdata = session_pagestart($user_ip, PAGE_PROFILE);
	init_userprefs($userdata);
	//
	// End session management
	//

	if (!$userdata['session_logged_in'])
	{
		redirect(append_sid("login.$phpEx?redirect=includes/usercp_captcha.$phpEx?demo=" . $_GET['demo'] . "&captcha=" . $_GET['captcha'], true));
	}
	else if ($userdata['user_level'] != ADMIN)
	{
		message_die(GENERAL_MESSAGE, $lang['Not_admin']);
	}

	// Generate the required confirmation code
	// NB 0 (zero) could get confused with O (the letter) so we make change it
	$code = dss_rand();

	$code = substr(str_replace('0', 'Z', strtoupper(base_convert($code, 16, 35))), rand(0, 3), rand(2, 8));

	// if we are accessing any captcha other than this one(Modified Better Captcha)
	if ($_GET['captcha'] != '1')
	{
		$confirm_id = md5(uniqid($user_ip));

		$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) 
			VALUES ('$confirm_id', '". $userdata['session_id'] . "', '$code')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
		}

		$HTTP_GET_VARS['id'] = $confirm_id;

		// load the captcha we want to use
		if (pick_captcha($_GET['captcha']) !== true)
		{
			require pick_captcha($_GET['captcha']);
		}
	}

	if(!extension_loaded("gd") || (!function_exists('imagettftext')) )
	{
		/*
		* include the language file
		*/
		$language = ($userdata['user_lang'] != '') ? $userdata['user_lang'] : $board_config['default_lang'];

		if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx))
		{
			message_die(GENERAL_MESSAGE, 'Anti-Spam ACP Mod language file does not exist: language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);
		}
		include_once($phpbb_root_path . 'language/lang_' . $language . '/lang_anti_spam_acp.' . $phpEx);

		message_die(GENERAL_MESSAGE, $lang['Captcha_Not_Supported']);
	}
}

/**
  * The next part is orginnaly written by ted from mastercode.nl and modified for using in this mod.
  **/
header("content-type:image/png");
header('Cache-control: no-cache, no-store');
$width = rand(500, 600);
$height = rand(80, 120);
$img = imagecreate($width,$height);
$background = imagecolorallocate($img, color("bg"), color("bg"), color("bg"));

imagefilledrectangle($img, 0, 0, ($width - 1), ($height - 1), $background);

$x_move = $width / (strlen($code) + 1);
$current_pos = rand(10, ($x_move / 2));

if ( ( ($board_config['as_acp_captcha_noise']) && ($_GET['demo'] != 'true') ) || ( ($_GET['demo'] == 'true') && ($_GET['noise'] == 'true') ) )
{
	// put some noise in the background
	$limit = rand(5, 15);

	for($g = 0;$g < $limit; $g++)
	{
		if ((rand(0,1)) == 0)
		{
			imageellipse($img, rand(-100, ($width + 100)), rand(-50, ($height + 50)), rand(100, 400), rand(50, 400), rand(0, 255));
		}
		else
		{
			imagerectangle($img, rand(-100, ($width + 100)), rand(-50, ($height + 50)), rand(-100, ($width + 100)), rand(-50, ($height + 50)), rand(0, 255));
		}
	}
}

$less_rotate = array('N', 'Z', '6', '9'); //letters that we don't want rotated too much...

// Put in the letters now
for($j = 0;$j < strlen($code); $j++)
{
	$size = rand(20,28);
	$angle = (in_array($code[$j], $less_rotate)) ? rand(-15, 15) : rand(-45,45);
	$y_pos = $height/2 + rand(-12,12);

	$x_pos = $current_pos + rand(($size * 2), $x_move);
	$current_pos = $x_pos;

	$color2 = imagecolorallocate($img, color("tekst"), color("tekst"), color("tekst"));

	imagettftext($img, $size, $angle, $x_pos, $y_pos, $color2, font() , $code[$j]);
}

imagepng($img);
imagedestroy($img);
die;
?>
