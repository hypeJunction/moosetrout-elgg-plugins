<?php

/**
 *
 */
function calculateCore($manifest_values) {

    //echo("website: {$manifest_values['website']}; author: {$manifest_values['author']}\n");

    if ($manifest_values['website'] == 'http://www.elgg.org/') {
        return true;
    }

    if (preg_match('/Curverider/', $manifest_values['author'])) {
        return true;
    }  else {
        return false;
    }
}

/**
 *
 */
function calculateLocal($manifest_values) {

    if (preg_match('/Brian Jorgensen/', $manifest_values['author'])) {
        return true;
    }  else {
        return false;
    }
}

/**
 *
 * @param unknown_type $plugin
 * @return string 'high', 'medium', 'low', '?'
 */
function calculateTrust($manifest_values, $plugin) {

    // first, deal with core, local, and Cash/Tidypics
    if (($manifest_values['author'] == 'Curverider')
    || ($manifest_values['author'] == 'Cash Costello')
    || ($manifest_values['author'] == 'The Tidypics team')
    || ($manifest_values['author'] == 'Brian Jorgensen')) {

        return 'high';
    }

    switch ($plugin) {
        case'elgg_dev_tools':
            return 'high';
            break;
        case 'blogextended':
            // overrode groups/groupselector namespace in v?
            return 'low';
            break;
        case 'pollextended':
            // overrode groups/groupselector namespace in v?
            return 'low';
            break;
        default:
            return '?';
            break;
    }
}

/**
 *
 */
function getNotes($plugin) {
    switch ($plugin) {
        case 'blogextended':
            return 'Bad override decision with groups/groupselector';
    }
}


/**
 *
 * @return unknown_type
 */
function findVersionByXpath() {
    // load xhtml file
    //        $xhtml = new DomDocument();
    //        $xhtml->loadHTML($url);
    //
    //        // xpath to grab latest version
    //        $xp = new DOMXPath($xhtml);
    //
    //        //<div class="filerepo_download"> then text of <a href>
    //        //$xpath_query = '//div[@class="filerepo_download"]/a/text()';
    //        $xpath_query = "div[@class='filerepo_download']/a";
    //
    //        $nodes = $xp->query($xpath_query);
    //
    //        foreach ($nodes as $node) {
    //            //
    //            echo("result: {$node->nodeValue}\n");
    //        }
}


/**
 * loadPlugins
 * variation of plugins/load_plugins
 */
function mt_load_plugins($mod) {

    global $CONFIG;

    if (is_plugin_enabled($mod)) {
        if (file_exists($CONFIG->pluginspath . $mod)) {
            if (!include($CONFIG->pluginspath . $mod . "/start.php")) {
                // misconfigured plugin
            }
             
//        if (!$cached_view_paths) {
            if (is_dir($CONFIG->pluginspath . $mod . "/views")) {
                if ($handle = opendir($CONFIG->pluginspath . $mod . "/views")) {
                    while ($viewtype = readdir($handle)) {
                        if (!in_array($viewtype,array('.','..','.svn','CVS')) && is_dir($CONFIG->pluginspath . $mod . "/views/" . $viewtype)) {
                            mt_autoregister_views("",$CONFIG->pluginspath . $mod . "/views/" . $viewtype,$CONFIG->pluginspath . $mod . "/views/", $viewtype);
                        }
                    }
                }
            }
//        }
        }
    }
}

/**
 * autoregisterViews
 * variation of elgglib/autoregister_views
 * @return unknown_type
 */
function mt_autoregister_views($view_base, $folder, $base_location_path, $viewtype) {
     
    if (!isset($i)) $i = 0;
    if ($handle = opendir($folder)) {
        while ($view = readdir($handle)) {
            if (!in_array($view,array('.','..','.svn','CVS')) && !is_dir($folder . "/" . $view)) {
                if ((substr_count($view,".php") > 0) || (substr_count($view,".png") > 0)) {
                    if (!empty($view_base)) { $view_base_new = $view_base . "/"; } else { $view_base_new = ""; }
                    mt_set_view_location($view_base_new . str_replace(".php","",$view), $base_location_path, $viewtype);
                }
            } else if (!in_array($view,array('.','..','.svn','CVS')) && is_dir($folder . "/" . $view)) {
                if (!empty($view_base)) { $view_base_new = $view_base . "/"; } else { $view_base_new = ""; }
                mt_autoregister_views($view_base_new . $view, $folder . "/" . $view, $base_location_path, $viewtype);
            }
        }
    }
}

/**
 * mt_set_view_location
 * 
 * Based on elgglib/set_view_location
 * 
 * @param
 * @param
 * @param
 * @returns
 */
function mt_set_view_location($view, $location, $viewtype = '') {
     
    if (empty($viewtype))
    $viewtype = 'default';
     
    if (!isset($plugin_views->views)) {
        $plugin_views->views = new stdClass;
    }
    if (!isset($plugin_views->views->locations)) {
        $plugin_views->views->locations = array($viewtype => array(
        $view => $location
        ));

    } else if (!isset($plugin_views->views->locations[$viewtype])) {
        $plugin_views->views->locations[$viewtype] = array(
        $view => $location
        );
    } else {
        $plugin_views->views->locations[$viewtype][$view] = $location;
    }
    //return $plugin_views;
    mt_display_plugin_views($plugin_views);
}

/**
 * 
 * @param unknown_type $plugin_views
 * @return unknown_type
 */
function mt_display_plugin_views($plugin_views) {
    
    foreach($plugin_views->views->locations as $locations) {
        var_dump($locations);
    }
}