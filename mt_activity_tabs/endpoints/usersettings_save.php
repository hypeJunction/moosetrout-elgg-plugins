<?php
/**
 * Elgg plugin user settings save action.
 * 
 * Modified to be an ajax endpoint.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd, Brian Jorgensen
 * @link http://elgg.org/, http://www.moosetrout.com
 */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();

$params = get_input('params');
$plugin = get_input('plugin');

$result = false;

// send header
echo(header('Content-type:text/plain'));
foreach ($params as $k => $v) {
	// Save
	$result = set_plugin_usersetting($k, $v, $_SESSION['user']->guid, $plugin);

	// Error?
	if (!$result) {
	    
	    // return error
	    echo sprintf(elgg_echo('plugins:usersettings:save:fail'), $plugin);
		exit;
	}
}

// return success
echo sprintf(elgg_echo('plugins:usersettings:save:ok'), $plugin);
exit;
