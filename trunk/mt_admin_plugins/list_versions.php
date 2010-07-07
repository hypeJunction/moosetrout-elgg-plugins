<?php

admin_gatekeeper();
set_context('admin');

// grab lib
require_once($CONFIG->pluginspath . 'mt_admin_plugins/lib/mt_admin_plugins_lib.php');

// plugin base
$plugin_base = 'http://community.elgg.org/mod/plugins/read.php?guid=';

// get list of plugins
$plugins = get_plugin_list();

//
$plugin_url_guid = array(
    'mt_blog_widget'		=> 428039,
    'mt_default_profile_fields'		=> 425386,
    'mt_language_overrides'	=> 424552,
    'mt_widgets_reordering_debug'	=> 426582,
    'blogextended'          => 384585,
    'custom_index_widgets'	=> 385113,
    'customspotlight'		=> 384767,
    'dbvalidate'			=> 438616,
    'embedvideo'			=> 384562,
    'errorlog'              => 384440,
    'elgg_dev_tools' 	    => 384962,
    'event_calendar'		=> 384926,
    'groupmembers'			=> 385053,
	'help'					=> 384798,
    'market'				=> 407901,
    'mnet_support'			=> 391628,
    'poll'					=> 384627,
    'poll_extended'			=> 384626,
    'simplepie'      	    => 384545,
    'stats'					=> 385105,
	'tagcloud'              => 384567,
    'tidypics'				=> 385077,
    'tinyurl'				=> 384859,
    'tips'					=> 385100,
    'vazco_comments' 	    => 384807,
    'welcomer'				=> 384773
);

// add nav menu here?
//$body = elgg_view('mt_admin_plugins/nav');

$body = "<div class='contentWrapper'>\n<table cellpadding='5'>\n";
$body .= "<th>Plugin</th><th>Installed</th><th>Available Version</th><th>Author</th><th>Trust</th><th>Notes</th>\n";
foreach ($plugins as $plugin) {

    // set defaults
    $verified = false;
    $core = false;
    $trust = '?';
    $guid_stored = false;
    $css_row_color = 'white';
    $css_color = 'red';
    $latest_version = '';
    $installed_version = '';
    $notes = ' ';
    $url = '';
    $author_website = '';
    $enabled = false;

    // grab manifest values associative array
    $manifest_values = load_plugin_manifest($plugin);
    $installed_version = $manifest_values['version'];

    // check if url_guid
    if (array_key_exists($plugin, $plugin_url_guid)) {

        $guid_stored = true;

        // create url
        $url = $plugin_base . $plugin_url_guid[$plugin];

        // <div class="filerepo_download">Latest: <a href="http://community.elgg.org/pg/plugins/costelloc/read/384567?release=43026">1.5</a>  </div>

        // lookup latest version
        // deal with "Author Recommends"?
        $pattern = '/<div class="filerepo_download">[\w| ]+: <a href="([^"]+)">([^<]+)<\/a>/';
        $file = file_get_contents($url);
        $matches = array();
        preg_match($pattern, $file, $matches);
        //var_dump($matches);

        if (isset($matches[2])) {
            $latest_version = $matches[2];
            $verified = true;
        } else {
            $verified = false;
            $latest_version = "<a href='$url'>error</a>";
        }

        // calculate color
        if ($latest_version == $installed_version) {
            $css_color = 'green';
        }

    }

    // enabled?
    $enabled = is_plugin_enabled($plugin);

    // calculate core
    if (calculateCore($manifest_values)) {
        $core = true;
        $css_color = 'green';
        $css_row_color = '#dddddd';
    }
    
    // calculate local plugin?
    if (calculateLocal($manifest_values)) {
        $local = true;
        $css_color = 'green';
        $css_row_color = '#eeeeee';
    }

    // calculate trust
    $trust = calculateTrust($manifest_values, $plugin);

    // check author website
    if (isset($manifest_values['website'])) {
        $author_website = $manifest_values['website'];
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
     
    // installed version
    $body .= "<td style='color:$css_color'>$installed_version</td>";

    // available version
    if ($verified) {
        $body .= "<td style='color:$css_color'>$latest_version <a href='$url'><img src='" . $CONFIG->wwwroot . "mod/mt_admin_plugins/_graphics/ur_arrow.png' border='0'></a></td>";
    } else {
        $body .= "<td>&nbsp;</td>";
    }

    // author
    $body .= "<td>{$manifest_values['author']}";

    if (isset($author_website)) {
        $body .= " <a href='" . $author_website . "'><img src='" . $CONFIG->wwwroot . "mod/mt_admin_plugins/_graphics/ur_arrow.png' border='0'></a>";
    }
    $body .= "</td>";

    // trust
    $body .= "<td>$trust</td>";

    // notes
    if (($core) || ($guid_stored)) {
        $body .= "<td>$notes</td>";
    } else {
        $body .= "<td>please provide guid; $notes</td>";
    }

    $body .= "</tr>\n";
}
$body .= "</table></div>\n";


$title = elgg_view_title(elgg_echo('mt_admin_plugins:list_versions_title'));

page_draw(elgg_echo('mt_admin_plugins:list_versions_title'), elgg_view_layout("two_column_left_sidebar", '', $title . $body));


