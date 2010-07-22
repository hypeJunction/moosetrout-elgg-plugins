<?php

/**
 * Longtext filter plugin.
 * Substitutes video embed code into longtext fields
 * using a library file from the embedvideo plugin.
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */

// standard plugin init
register_elgg_event_handler('init','system','mt_longtext_video_filter_init');

/**
 * plugin init function
 * 
 * @return unknown_type
 */
function mt_longtext_video_filter_init() {

    // extend css
    extend_view('css', 'mt_longtext_video_filter/mt_longtext_video_filter_css');
    
    // do not load if embedvideo is not present
    $plugins = get_plugin_list();
    
    // use in_array or array_search?
    if(!in_array('embedvideo', $plugins)) {
        
        // disable this plugin
        disable_plugin('mt_longtext_video_filter');
        
        // generate error message
        register_error(elgg_echo('mt_longtext_video_filter:missinglib'));
        
    }
}
