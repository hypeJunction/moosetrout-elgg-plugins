<?php
global $CONFIG;

$dependency_url = $CONFIG->wwwroot . 'mod/mt_longtext_video_filter/dependency_test.php';
echo('<p>');
echo('<a href="' . $dependency_url . '">' . elgg_echo('mt_longtext_video_filter:dep_test_title') . '</a>');
echo('</p>');
echo("<hr />");
?>