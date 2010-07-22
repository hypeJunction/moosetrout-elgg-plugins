<?php

// this is a quick hack of the compatibility script included with simple pie

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$embedmedia_loaded = in_array('embedvideo', get_plugin_list());

if ($embedmedia_loaded) {
    $result = elgg_echo('mt_longtext_video_filter:dependencyok');
} else {
    $result = elgg_echo('mt_longtext_video_filter:dependencyfail');
}


$content = '<div class="contentWrapper" style="margin: 0;">';

$content .= '<div id="elggreturn"><a href="javascript:history.go(-1)">' . elgg_echo('mt_longtext_video_filter:backlink') . '</a></div>';

$content .= '<div id="site">';
$content .= '<div id="content">';
$content .= '<div class="chunk">';
$content .= '<h2 style="text-align: center;">' . elgg_echo('mt_longtext_video_filter:dep_test_title') . '</h2>';

$content .= "<p>$result</p>";

$content .= '</div>';
$content .= '</div>';
$content .= '</div>';

$body = elgg_view_layout('one_column', $content);
echo page_draw(null, $body);