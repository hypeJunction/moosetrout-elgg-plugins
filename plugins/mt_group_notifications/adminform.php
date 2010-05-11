<?php

/**
 * mt_group_notifications form
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */

global $CONFIG;

//
require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');

// for admin only
admin_gatekeeper();

// set context
set_context('admin');
		
// set title
$title = elgg_echo('mt_group_notifications:title');

// grab form
$body = elgg_view('mt_group_notifications/form');

// body
$content = elgg_view_layout('two_column_left_sidebar', '', $body);
echo page_draw($title, $content);