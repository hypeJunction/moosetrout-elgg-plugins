<?php

/**
 * mt_admin_plugins/index
 */
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

admin_gatekeeper();
set_context('admin');

$tab = get_input("tab");

$title = elgg_view_title(elgg_echo('mt_admin_plugins:index_title'));
$body = elgg_view('mt_admin_plugins/index2', array('tab' => $tab));

page_draw(elgg_echo('mt_admin_plugins:index_title'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
