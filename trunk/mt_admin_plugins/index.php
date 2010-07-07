<?php

/**
 * mt_admin_plugins/index
 */

admin_gatekeeper();
set_context('admin');

$body = "<div class='contentWrapper'>\n<ul>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/index2'>tabbed index</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/dump_order'>" . elgg_echo('mt_admin_plugins:dump_order') . "</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/list_versions'>" . elgg_echo('mt_admin_plugins:list_versions') . "</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/list_view_overrides'>" . elgg_echo('mt_admin_plugins:list_view_overrides') . "</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/list_dependencies'>" . elgg_echo('mt_admin_plugins:list_dependencies') . "</a></li>\n";
$body .= "</ul></div>\n\n";

$title = elgg_view_title(elgg_echo('mt_admin_plugins:index_title'));

page_draw(elgg_echo('mt_admin_plugins:index_title'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
