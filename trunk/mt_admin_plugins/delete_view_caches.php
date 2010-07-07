<?php


admin_gatekeeper();
set_context('admin');

global $CONFIG;

$body = "<div class='contentWrapper'>\n";

// delete view_paths file
if (file_exists($CONFIG->datadir . 'view_paths')) {
        $r1 = unlink($CONFIG->datadir . 'view_paths');
        $body .= "<p>Delete view_paths file result: $r1</p>\n";
} else {
        $body .= "<p>view_paths file does not exist</p>\n";
}

// delete everything under views_simplecache
$d = dir($CONFIG->datadir . 'views_simplecache');
while (false !== ($file = $d->read())) {
        if (($file != '.') && ($file != '..')) {
                $r2 = unlink($CONFIG->datadir . 'views_simplecache/' . $file);
                $body .= "<p>Delete views_simplecache file: $r2</p>\n";
        }
}

$body .= "</div>\n";

$title = elgg_view_title(elgg_echo('mt_admin_plugins:delete_view_caches'));

page_draw(elgg_echo('mt_admin_plugins:delete_view_caches'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
