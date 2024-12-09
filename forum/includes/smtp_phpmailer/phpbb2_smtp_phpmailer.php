<?php
/**
 * PHP Mailer SMTP MOD
 * 
 * SMTP using PHP Mailer
 * y'know SMTP as of 2013 that actually works... 
 * used by WordPress amongst others
 * 
 * @link https://github.com/konsulting/PHPMailer
 * 
 * @author Ian Channing <ian@klever.co.uk>
 * @version 0.1
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require 'class.phpmailer.php';

/**
 * 
 * @global array $board_config PHP BB config options
 * @param type $mail_to mail@domain.com only single email allowed
 * @param type $subject email subject must not be blank
 * @param type $message email body - can be blank
 * @param type $headers ccs and bcc
 * @return boolean Whether the email is sent or not
 * 
 * @link https://raw.github.com/konsulting/PHPMailer/master/README.md The PHP Mailer code is taken from the default example in the README.md
 */
function smtpphpmailer($mail_to, $subject, $message, $headers='') {
	global $board_config;
	
    if (isset($board_config['smtp_auth_mech']) && $board_config['smtp_auth_mech'] != "") {
        $smtp_auth_mech = $board_config['smtp_auth_mech'];
    } elseif (!empty($board_config['smtp_username'])) {
        $smtp_auth_mech = "login";
    } else {
        $smtp_auth_mech = "none";
    }

    if (isset($board_config['use_smtp_tls']) && $board_config['use_smtp_tls'] == "1") {
        $use_smtp_tls = true;
    } else {
        $use_smtp_tls = false;
    }

    if (isset($board_config['smtp_port']) && $board_config['smtp_port'] != "") {
        $smtp_port = $board_config['smtp_port'];
    } else {
        $smtp_port = 25;
    }
	
	/**
	 * <CODE FROM PHPBBs SMTPMAIL v2.0.23>
	 */
	// Fix any bare linefeeds in the message to make it RFC821 Compliant.
	// $message = preg_replace("#(?<!\r)\n#si", "\r\n", $message);

	if ($headers != '')
	{
		if (is_array($headers))
		{
			if (sizeof($headers) > 1)
			{
				$headers = join("\n", $headers);
			}
			else
			{
				$headers = $headers[0];
			}
		}
		$headers = chop($headers);

		// Make sure there are no bare linefeeds in the headers
		$headers = preg_replace('#(?<!\r)\n#si', "\r\n", $headers);

		// Ok this is rather confusing all things considered,
		// but we have to grab bcc and cc headers and treat them differently
		// Something we really didn't take into consideration originally
		$header_array = explode("\r\n", $headers);
		@reset($header_array);

		$headers = '';
		while(list(, $header) = each($header_array))
		{
			if (preg_match('#^cc:#si', $header))
			{
				$cc = preg_replace('#^cc:(.*)#si', '\1', $header);
			}
			else if (preg_match('#^bcc:#si', $header))
			{
				$bcc = preg_replace('#^bcc:(.*)#si', '\1', $header);
				$header = '';
			}
			$headers .= ($header != '') ? $header . "\r\n" : '';
		}

		$headers = chop($headers);
		if (!empty($cc)) {			
			$cc = explode(', ', $cc);
		}
		if (!empty($bcc)) {
			$bcc = explode(', ', $bcc);			
		}
		
	}

	if (trim($subject) == '')
	{
		message_die(GENERAL_ERROR, "No email Subject specified", "", __LINE__, __FILE__);
	}

	if (trim($message) == '')
	{
		// ICC - We're going to allow blank messages
		// message_die(GENERAL_ERROR, "Email message was blank", "", __LINE__, __FILE__);
	}

	// Ok we have error checked as much as we can to this point let's get on
	// it already.
	if( !$socket = @fsockopen($board_config['smtp_host'], $smtp_port, $errno, $errstr, 20) )
	{
		message_die(GENERAL_ERROR, "Could not connect to smtp host : $errno : $errstr", "", __LINE__, __FILE__);
	}
	
	// Add an additional bit of error checking to the To field.
	$mail_to = (trim($mail_to) == '') ? 'Undisclosed-recipients:;' : trim($mail_to);
	
	/**
	 * </CODE FROM PHPBBs SMTPMAIL v2.0.23>
	 */
	
	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $board_config['smtp_host'];             // Specify main and backup server
	$mail->Port = $smtp_port;							  // SMTP Port 25, 587
	if ($use_smtp_tls) {
		$mail->SMTPAuth = true;                           // Enable SMTP authentication
		$mail->SMTPSecure = 'tls';                        // Enable encryption, 'ssl' also accepted - ICC for SMTP it seems that we always want tls for secure connections
	}
	$mail->Username = $board_config['smtp_username'];     // SMTP username
	$mail->Password = $board_config['smtp_password'];     // SMTP password

	$mail->From = $board_config['board_email'];
	list($from_name, $from_domain) = explode('@',$board_config['board_email']);
	$mail->FromName = $from_name;
	$mail->AddAddress($mail_to);                          // Add a recipient
	if (!empty($cc)) {
		foreach ($cc as $cc_address) {
			$mail->AddCC($cc_address);
		}
	}
	if (!empty($bcc)) {
		foreach ($bcc as $bcc_address) {
			$mail->AddBCC($bcc_address);
		}
	}

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	// $mail->AddAttachment('/var/tmp/file.tar.gz');      // Add attachments
	// $mail->AddAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;
	// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	
	if(!$mail->Send()) {
		$success = false;
		message_die(GENERAL_ERROR, "Message could not be sent. Mailer Error: " . $mail->ErrorInfo, "", __LINE__, __FILE__);
	} else {
		$success = true;	
	}
	
	return $success;
	// echo 'Message has been sent';
}
