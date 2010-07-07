<?php

admin_gatekeeper();
set_context('admin');

// grab lib
require_once($CONFIG->pluginspath . 'mt_admin_plugins/lib/mt_admin_plugins_lib.php');

// get list of plugins
$plugins = get_plugin_list();

// add nav menu here?
//$body = elgg_view('mt_admin_plugins/nav');

$body = "<div class='contentWrapper'>\n<table cellpadding='5'>\n";
$body .= "<tr><th>Plugin</th><th>Requires</th></tr>\n";
foreach ($plugins as $plugin) {

    // set defaults
    $verified = false;
    $core = false;
    $guid_stored = false;
    $css_row_color = 'white';
    $css_color = 'red';
    $author_website = '';
    $enabled = false;
    $requires = array();

    // grab manifest values associative array
    $manifest_values = load_plugin_manifest($plugin);
    $installed_version = $manifest_values['version'];
    $requires = $manifest_values['requires'];

    // enabled?
    $enabled = is_plugin_enabled($plugin);

    // calculate core
    if (calculateCore($manifest_values)) {
        $core = true;
        $css_color = 'green';
        $css_row_color = '#dddddd';
    }

    // print to screen
    $body .= "<tr style='background-color:$css_row_color'>";

    // plugin
    if (!$enabled) {
        $body .= "<td style='text-decoration: line-through'>";
    } else {
        $body .= "<td>";
    }
    if ($core) {
        $body .= "$plugin (core)</td>";
    } else {
        $body .= "$plugin</td>";
    }

    // dependencies
    $body .= "<td>";
    if (isset($requires)) {
        $deps = explode(',', $requires);
        $body .= "<ul>";

        foreach ($deps as $dependency) {

            // set defaults
            $r_exists = false;
            $r_enabled = false;

            // exists?
            if (in_array($dependency, array_values($plugins))) {
                $r_exists = true;

                if(is_plugin_enabled($dependency)) {
                    $r_enabled = true;
                } else {
                    $r_enabled = false;
                }
            } else {
                $r_exists = false;
            }

            // enabled?
            if ($r_exists) {
                if($r_enabled) {
                    $body .= "<li style='color:green'>$dependency</li>\n";
                } else {
                    $body .= "<li style='color:orange; text-decoration: line-through'>$dependency</li>\n";
                }
            } else {
                $body .= "<li style='color:red'>$dependency</li>\n";
            }
        }
        $body .= "</ul>";
    } else {
        $body .= '';
    }
    $body .= "</td>";

    $body .= "</tr>\n";
}
$body .= "</table></div>\n";

$title = elgg_view_title(elgg_echo('mt_admin_plugins:list_dependencies'));

page_draw(elgg_echo('mt_admin_plugins:list_versions_dependencies'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));


