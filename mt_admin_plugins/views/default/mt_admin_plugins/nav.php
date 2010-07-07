<?php

global $CONFIG;

$body = "<ul>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/dump_order'>" . elgg_echo('mt_admin_plugins:dump_order') . "</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/list_versions'>" . elgg_echo('mt_admin_plugins:view_overrides') . "</a></li>\n";
$body .= "<li><a href='" . $CONFIG->wwwroot . "pg/mt_admin_plugins/view_overrides'>" . elgg_echo('mt_admin_plugins:list_versions') . "</a></li>\n";
$body .= "</ul>";

echo($body);