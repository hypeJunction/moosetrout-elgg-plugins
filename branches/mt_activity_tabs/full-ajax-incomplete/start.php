<?php

/**
 * Plugin that allows users to use pluginsettings to add collection
 * and group tabs to their activity tool.
 *
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

require_once(dirname(__FILE__) . '/lib/river2.php');
register_elgg_event_handler('init','system','mt_activity_tabs_init');

/**
 * Standard plugin init.
 */
function mt_activity_tabs_init() {

    global $CONFIG;
    
    // register page handler
    register_page_handler('activity_tabs','mt_activity_tabs_page_handler');
    
    // extend views
	extend_view('css', 'mt_activity_tabs/css');
		
    // override activity menu item
    if (isloggedin())
    {
        // override activity menu item
        add_menu(elgg_echo('activity'), $CONFIG->wwwroot . "pg/activity_tabs/");
    }

}

/**
 * Page handler for activity tabs
 *
 * @param unknown_type $page
 */
function mt_activity_tabs_page_handler($page)
{
    global $CONFIG;
     
    include(dirname(__FILE__) . "/index.php");
    return true;
}