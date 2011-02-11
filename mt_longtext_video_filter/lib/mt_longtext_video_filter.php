<?php

global $CONFIG;

// do not load if embedvideo is not present
$plugins = get_plugin_list();
    
// use in_array or array_search?
if(in_array('embedvideo', $plugins)) {
	
    require_once($CONFIG->pluginspath . '/embedvideo/lib/embedvideo.php');
    
} else {
	// disable this plugin
    disable_plugin('mt_longtext_video_filter');
        
    // generate error message
    register_error(elgg_echo('mt_longtext_video_filter:missinglib'));
}

/**
 * Modified version of /engine/lib/input.php
 * @author Curverider, Brian Jorgensen
 */


/**
 * Takes a string and turns any URLs into either embed code
 * using Cash Costello's embedvideo library, or else typical Elgg formatted links
 *
 * @param string $text The input string
 * @return string The output string with formatted links
 **/
function mt_parse_embed_urls($text) {
     
    return preg_replace_callback('/(?<!=["\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\!\(\)]+)/i',
    mt_replace_urls,
    $text);
}

/**
 * Callback method that either substitutes in embed code, or
 * standard Elgg formatted links
 * 
 * @param array $matches Array of matches passed in by preg_replace_callback function
 * @return string HTML for this longtext field
 */
function mt_replace_urls($matches) {

    // create a fake guid for this embedded video
    // use item guid plus what?
    $guid = $vars['entity']->guid . '_' . time();

    $url = $matches[1];

    // will return text for URLs that aren't videos
    $temp = videoembed_create_embed_object($matches[1], $guid);

    // text for unmatched video
    // @todo would be nice to be able to call embedvideo_get_unrecognized_text
    $unrecognized_text = '<p><b>' . elgg_echo('embedvideo:unrecognized') . '</b></p>';

    // if not a video site URL, do usual substitution
    if ($temp == $unrecognized_text) {
        
        $urltext = str_replace("/", "/<wbr />", $url);

        return "<a href=\"$url\" style=\"text-decoration:underline;\">$urltext</a>";

    } else {
        
        //var_dump($temp);
        return $temp;
    }

}