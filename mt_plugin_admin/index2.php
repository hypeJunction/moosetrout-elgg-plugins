<?php

/**
 * au_admin_plugins/index
 */
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

admin_gatekeeper();
set_context('admin');

$tab = get_input("tab");

$title = elgg_view_title(elgg_echo('au_admin_plugins:index_title'));
$body = elgg_view('au_admin_plugins/index2', array('tab' => $tab));

page_draw(elgg_echo('au_admin_plugins:index_title'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
