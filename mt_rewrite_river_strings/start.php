<?php

/**
 *
 */
function mt_rewrite_river_strings_init() {

    global $CONFIG;

    if (get_plugin_setting('enabled', 'mt_rewrite_river_strings') == 'true') {
        
        // register post processing hook
        register_plugin_hook('display', 'view', 'mt_rewrite_river_strings');
    }

    // define views we want to rewrite codes on (means we don't have to process *everything*)
    $CONFIG->mt_rewrite_river_strings_views = array('object/thewire');

}

/**
 *
 * @param $hook
 * @param $entity_type
 * @param $returnvalue
 * @param $params
 */

function mt_rewrite_river_strings($hook, $entity_type, $returnvalue, $params) {

    global $CONFIG;

    // check if enabled
    if(get_plugin_setting('enabled', 'mt_rewrite_river_strings') != 'true') {    
        return $returnvalue;
    }
    
    // grab view
    $view = $params['view'];

    // grab old url and escape?
    $oldurl = get_plugin_setting('oldurl', 'mt_rewrite_river_strings');

    // escape?
    
    
    // grab new url
    $newurl = get_plugin_setting('newurl', 'mt_rewrite_river_strings');

    // escape?
    
    
    // do the search and replace
    if (($view) && (in_array($view, $CONFIG->mt_rewrite_river_strings_views))) {

        // Search and replace
        $returnvalue = preg_replace($oldurl, $newurl, $view);
        
        // done
        return $returnvalue;
    }
}
