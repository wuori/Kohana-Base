<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * SwiftMailer driver, used with the email helper.
 *
 * @see http://www.swiftmailer.org/wikidocs/v3/connections/nativemail
 * @see http://www.swiftmailer.org/wikidocs/v3/connections/sendmail
 * @see http://www.swiftmailer.org/wikidocs/v3/connections/smtp
 *
 * Valid drivers are: native, sendmail, smtp
 */
$config['driver'] = 'sendmail';

/**
 * To use secure connections with SMTP, set "port" to 465 instead of 25.
 * To enable TLS, set "encryption" to "tls".
 *
 * Driver options:
 * @param   null    native: no options
 * @param   string  sendmail: executable path, with -bs or equivalent attached
 * @param   array   smtp: hostname, (username), (password), (port), (auth), (encryption)
 */
//$config['options'] = array('hostname'=>'mail.onlyinoldtown.com', 'port'=>'25', 'username'=>'messages@onlyinoldtown.com', 'password'=>'harvey');

$config['options'] = array('hostname'=>'smtp.gmail.com', 'port'=>'465', 'username'=>'michael@studiobanks.com', 'password'=>'swordfish', 'encryption' => 'tls');$config['options'] = NULL;