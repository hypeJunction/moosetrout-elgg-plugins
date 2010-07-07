<?php

/**
 * 
 */
admin_gatekeeper();
set_context('admin');

// grab lib
require_once($CONFIG->pluginspath . 'mt_admin_plugins/lib/mt_admin_plugins_lib.php');

// defaults
$conflicts = array();

// get list of plugins
$plugins = get_plugin_list();

$body = "<div class='contentWrapper'>\n<p><a href='#summary'>Summary</a></p>\n\n\n";

$body .= "<table cellpadding='5'>\n";
$body .= "<tr><th>Plugin</th><th>Views</th></tr>\n";


// first, grab core views
$location = $CONFIG->viewpath;

// grab viewtype; for now, use default?
$viewtype = elgg_get_viewtype();

$view_root = '';

// $CONFIG->dataroot . '/views/default'

$root = $location . $viewtype . '/' . $view_root;

// root is /usr/libexec/elgg/views/default/

//$toplevel_views = array();

// set defaults
$views = array();

if (file_exists($root) && is_dir($root)) {
    //$toplevel_views = get_views($root, $view_root);
    $views = get_views($root, $view_root);
}

// sort views
sort($views);

//
$body .= "<tr valign='top'><td>Core</td>\n<td><ul>";

// remove initial slash
$i = 0;
foreach($views as $path) {
    
    // trim initial slash
    $path = ltrim($path, '/');
    $views[$i] = $path;
    
    // populate conflicts array
    $conflicts[$path][] = 'core';

    $body .= "<li>$path</li>\n";
    $i++;
}
$body .= "</ul></td></tr>\n";

foreach ($plugins as $plugin) {

    // new array for each plugin
    $views = array();

    // grab views
    //$views = mt_load_plugin($views, $plugin);
    $p = $CONFIG->pluginspath . "/$plugin/views/default";
    $views = get_views($p, '');

    $i = 0;
    foreach($views as $view) {
        
        $view = ltrim($view, '/');
        $views[$i] = $view;
        
        // populate conflicts array
        $conflicts[$view][] = $plugin;
        $i++;
    }

    // enabled?
    $enabled = is_plugin_enabled($plugin);

    // calculate core
    if (calculateCore($manifest_values)) {
        $core = true;
        $css_color = 'green';
        $css_row_color = '#dddddd';
    }

    // print to screen
    $body .= "<tr style='background-color:$css_row_color' valign='top'>";

    // plugin
    if (!$enabled) {
        $body .= "<td style='text-decoration: line-through'>";
    } else {
        $body .= "<td><a name='$plugin'>";
    }
    if ($core) {
        $body .= "$plugin</a> (core)</td>";
    } else {
        $body .= "$plugin</a></td>";
    }

    // views
    $body .= "<td><ul>\n";
    foreach($views as $view) {

        // grab array of plugins that claim this view
        $cf = $conflicts[$view];

        if(count($cf) > 1) {
            $ccc = '';
            $first = true;

            // iterate through conflicting plugins
            foreach ($cf as $cfp) {
                if ($first) {
                    $ccc = $cfp;
                } else {

                    // don't append this plugin
                    if ($cfp != $plugin) {
                        $ccc = $ccc . '; ' . $cfp;
                    }
                }
                $first = false;
            }

            //
            $body .= "<li style='color:red'>$view (overrides: $ccc)</li>\n";

        } else {
            $body .= "<li>$view</li>\n";
        }
    }
    $body .= "</ul></td></tr>\n";
}
$body .= "</table>\n\n\n";

// iterate through conflicts
// grab array of plugins that claim this view
$body .= "<h2><a name='summary'>Summary</a></h2>\n\n";
$body .= "<table cellpadding='5'>\n";
$body .= "<tr><th>View Path</th><th>Plugins That Claim This Path</th></tr>\n\n";
$keys = array_keys($conflicts);
sort($keys);
foreach ($keys as $view) {

    $cf_array = $conflicts[$view];

    if(count($cf_array) > 1) {
        $ccc = '';
        $first = true;

        // iterate through conflicting plugins
        foreach ($cf_array as $cfp) {
            if ($first) {
                $ccc = "<ul><li><a href='#$cfp'>$cfp</a></li>\n";
            } else {
                $ccc = $ccc . "<li><a href='#$cfp'>$cfp</a></li>\n";
            }
            $first = false;
        }
        $ccc .= '</ul>';
        $body .= "<tr><td>$view</td><td>$ccc</td></tr>\n";
    }

}
$body .= "</table></div>\n";

$title = elgg_view_title(elgg_echo('mt_admin_plugins:list_view_overrides_title'));

page_draw(elgg_echo('mt_admin_plugins:list_view_overrides_title'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));
