<?php

/**
 * mt_group_notifications plugin start file
 *
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */

global $CONFIG;

// register init event
register_elgg_event_handler('init', 'system', 'mt_group_notifications_init');

// register actions
register_action("mt_group_notifications/set_notifications", false, $CONFIG->pluginspath . "mt_group_notifications/actions/set_notifications.php", true);

/**
 * Standard init method
 */
function mt_group_notifications_init() {
    
    // register widget
    add_widget_type('mt_group_notifications_widget', elgg_echo('mt_group_notifications_widget:title'), elgg_echo('mt_group_notifications_widget:description'), 'profile');
    
    // register event handler
    register_elgg_event_handler('join', 'group', 'mt_group_notifications_settings');
    
    // register event handler to add admin submenu item
	register_elgg_event_handler('pagesetup', 'system', 'mt_group_notifications_pagesetup');

}

/**
 * Event handler that sets default notification
 * based on plugin settings
 * 
 * @return true
 */
function mt_group_notifications_settings($event, $object_type, $object) {

    // grab plugin settings
    $enable_email = get_plugin_setting('enable_email_notifications', 'mt_group_notifications');
    $enable_site = get_plugin_setting('enable_site_notifications', 'mt_group_notifications');
    
    // grab user and group guids
    $user_guid = $object['user']['guid'];
    $group_guid = $object['group']['guid'];

    // add relationships
    if ($enable_email == 'true') {
        add_entity_relationship($user_guid, 'notifyemail', $group_guid);
    }
    if ($enable_site == 'true') {
        add_entity_relationship($user_guid, 'notifysite', $group_guid);     
    }
    
    return true;
}

/**
 * Add admin menu item
 */
function mt_group_notifications_pagesetup() {
	if (get_context() == 'admin') {
		global $CONFIG;
		add_submenu_item(elgg_echo('mt_group_notifications:adminlink'), $CONFIG->wwwroot . 'mod/mt_group_notifications/adminform.php');
	}
	 
	return true;
}