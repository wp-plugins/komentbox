<?php
/*
Plugin Name: WP-komentbox
Plugin URI: http://www.nlpcaptcha.in/integration/wordpress
Description: Integrates NLPCaptcha anti-spam solutions with wordpress
Version: 1.1
Author: NLPCaptcha
Email: support@nlpcaptcha.com
Author URI: http://www.nlpcaptcha.in
*/

define('ALLOW_INCLUDE', true);

require_once('komentbox.php');

$nlpcaptcha = new NLPCaptcha('komentbox_options');

?>
