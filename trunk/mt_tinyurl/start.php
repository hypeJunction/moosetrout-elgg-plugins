<?php

/**
 * mt_tinyurl plugin
 * Based on tinyurl plugin
 *
 */

/**
 * Init function
 *
 */
function mt_tinyurl_init() {

    // Extend useful views
    elgg_extend_view('css','tinyurl/css');
    	
    // extend urlshortner view!
    elgg_extend_view('input/urlshortener', 'my_tinyurl/addlink');
    	
    if(!is_plugin_enabled('embed')){
        elgg_extend_view('js/initialise_elgg','mt_tinyurl/js');
        elgg_extend_view('metatags','mt_tinyurl/metatags');
    }

    register_page_handler('tinyurl','mt_tinyurl_page_handler');
}

function mt_tinyurl_page_handler($page) {
    switch($page[0]) {
        default:			require_once(dirname(__FILE__) . '/longurl.php');
        exit;
        break;
    }
}

/**
 * 
 * @param $url
 */
function mt_getTinyUrl($url) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
    return $tinyurl;
}

// Register the init action
register_elgg_event_handler('init','system','mt_tinyurl_init',10);
?>