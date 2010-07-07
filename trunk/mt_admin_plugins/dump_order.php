<?php

admin_gatekeeper();
set_context('admin');

global $CONFIG;

// grab lib
require_once($CONFIG->pluginspath . 'mt_admin_plugins/lib/mt_admin_plugins_lib.php');

// get list of plugins
$plugins = get_plugin_list();

// spit out in a format suitable for importing
$body = "<div class='contentWrapper'>\n<textarea rows='20' cols='60'>" . serialize($plugins) . "</textarea></div>\n";

$submenu = array('item1' => 'link1', 'item2' => 'link2');
$title = elgg_view_title(elgg_echo('mt_admin_plugins:dump_order'), $submenu);

page_draw(elgg_echo('mt_admin_plugins:dump_order'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
