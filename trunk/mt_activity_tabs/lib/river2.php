<?php
/**
 * Library of methods for mt_activity_tabs
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

/**
 *
 */
function mt_get_user_collection_ids($userid = NULL) {

    // if not set, user this user
    if (!isset($userid)) {
        $userid = $_SESSION['user']->guid;
    }

    // grab collections from usersettings
    $usersettings = find_plugin_usersettings('mt_activity_tabs', $userid);

    // collections is an array of collection_guid
    // that user asked to appear in activity tool
    $collection_ids = array();

    // iterate
    foreach($usersettings as $key => $value) {
        	
        $c = explode('_', $key);
        	
        if (($value == 'yes') && ($c[0] == 'collection')) {
            $collection_ids[] = $c[1];
        }
    }

    return $collection_ids;
}

/**
 *
 */
function mt_get_user_group_ids($userid = NULL) {

    // if not set, user this user
    if (!isset($userid)) {
        $userid = $_SESSION['user']->guid;
    }

    // grab collections from usersettings
    $usersettings = find_plugin_usersettings('mt_activity_tabs', $userid);

    // collections is an array of collection_guid
    // that user asked to appear in activity tool
    $group_ids = array();

    // iterate
    foreach($usersettings as $key => $value) {
        	
        $c = explode('_', $key);
        	
        if (($value == 'yes') && ($c[0] == 'group')) {
            $group_ids[] = $c[1];
        }
    }

    return $group_ids;
}

/**
 *
 */
function mt_get_river_items_by_collection($subject_guid = 0, $collection_guid = 0, $type = '', $subtype = '', $action_type = '',
$limit = 20, $offset = 0, $posted_min = 0, $posted_max = 0) {

    // get CONFIG
    global $CONFIG;

    // Sanitise variables
    if (!is_array($subject_guid)) {
        $subject_guid = (int) $subject_guid;
    } else {
        foreach($subject_guid as $key => $temp) {
            $subject_guid[$key] = (int) $temp;
        }
    }
    if (!empty($collection_guid)) {
        $collection_guid = (int) $collection_guid;
    }
    if (!empty($type)) {
        $type = sanitise_string($type);
    }
    if (!empty($subtype)) {
        $subtype = sanitise_string($subtype);
    }
    if (!empty($action_type)) {
        $action_type = sanitise_string($action_type);
    }
    $limit = (int) $limit;
    $offset = (int) $offset;
    $posted_min = (int) $posted_min;
    $posted_max = (int) $posted_max;

    // Construct 'where' clauses for the river
    $where = array();

    // HUH?
    $where[] = str_replace("and enabled='yes'",'',str_replace('owner_guid','subject_guid',get_access_sql_suffix()));

    // grab array of users in this collection
    $collection_users = get_members_of_access_collection($collection_guid, true);

    // if collection is empty, return false
    if (empty($collection_users)) {
        return false;
    }

    //
    $wherein = " subject_guid in (";

    // iterate
    foreach($collection_users as $user_id) {
        $wherein .= $user_id . ',';

    }

    // strip final comma
    $wherein = rtrim($wherein, ',');

    $wherein .= ') ';

    $where[] = $wherein;

    //
    $whereclause = implode(' and ', $where);

    // Construct main SQL
    // annotation_id field added in 1.7?
    $sql = "select id,type,subtype,action_type,access_id,view,subject_guid,object_guid,posted" .
	 		" from {$CONFIG->dbprefix}river where {$whereclause} order by posted desc limit {$offset},{$limit}";

    // Get data
    return get_data($sql);

}

/**
 *
 */
function mt_get_river_items_by_group($subject_guid = 0, $group_guid = 0, $type = '', $subtype = '', $action_type = '',
$limit = 20, $offset = 0, $posted_min = 0, $posted_max = 0) {

    // get CONFIG
    global $CONFIG;

    // Sanitise variables
    if (!is_array($subject_guid)) {
        $subject_guid = (int) $subject_guid;
    } else {
        foreach($subject_guid as $key => $temp) {
            $subject_guid[$key] = (int) $temp;
        }
    }
    if (!empty($group_guid)) {
        $group_guid = (int) $group_guid;
    }
    if (!empty($type)) {
        $type = sanitise_string($type);
    }
    if (!empty($subtype)) {
        $subtype = sanitise_string($subtype);
    }
    if (!empty($action_type)) {
        $action_type = sanitise_string($action_type);
    }
    $limit = (int) $limit;
    $offset = (int) $offset;
    $posted_min = (int) $posted_min;
    $posted_max = (int) $posted_max;

    // Construct 'where' clauses for the river
    $where = array();

    // HUH?
    $where[] = str_replace("and enabled='yes'",'',str_replace('owner_guid','subject_guid',get_access_sql_suffix()));

    // grab array of users in this collection
    //$collection_users = get_members_of_access_collection($collection_guid, true);
    $group_users = get_group_members($group_guid);

    // if collection is empty, return false
    if (empty($group_users)) {
        return false;
    }

    //
    $wherein = " subject_guid in (";

    // iterate
    foreach($group_users as $user) {
        $wherein .= $user->guid . ',';

    }

    // strip final comma
    $wherein = rtrim($wherein, ',');

    $wherein .= ') ';

    $where[] = $wherein;

    //
    $whereclause = implode(' and ', $where);

    // Construct main SQL
    // annotation_id field added in 1.7?
    $sql = "select id,type,subtype,action_type,access_id,view,subject_guid,object_guid,posted" .
	 		" from {$CONFIG->dbprefix}river where {$whereclause} order by posted desc limit {$offset},{$limit}";

    // Get data
    return get_data($sql);

}

/**
 * Returns a human-readable version of the river.
 *
 * @param int|array $subject_guid Acting entity to restrict to. Default: all
 * @param int|array $object_guid Entity being acted on to restrict to. Default: all
 * @param string $subject_relationship If set to a relationship type, this will use
 * 	$subject_guid as the starting point and set the subjects to be all users this
 * 	entity has this relationship with (eg 'friend'). Default: blank
 * @param string $type The type of entity to restrict to. Default: all
 * @param string $subtype The subtype of entity to restrict to. Default: all
 * @param string $action_type The type of river action to restrict to. Default: all
 * @param int $limit The number of items to retrieve. Default: 20
 * @param int $posted_min The minimum time period to look at. Default: none
 * @param int $posted_max The maximum time period to look at. Default: none
 * @return string Human-readable river.
 */
function mt_elgg_view_river_items_by_collection($subject_guid = 0, $collection_guid = 0,
$type = '', $subtype = '', $action_type = '', $limit = 20, $posted_min = 0, $posted_max = 0, $pagination = true) {

    // Get input from outside world and sanitise it
    $offset = (int) get_input('offset',0);

    // Get river items, if they exist
    if ($riveritems = mt_get_river_items_by_collection($subject_guid,$collection_guid,$type,$subtype,$action_type,($limit + 1),$offset,$posted_min,$posted_max)) {

        return elgg_view('river/item/list',array(
			'limit' => $limit,
			'offset' => $offset,
			'items' => $riveritems,
			'pagination' => $pagination
        ));

    } else {
        return elgg_echo('mt_activity_tabs:empty');
    }

    return '';
}

/**
 * Returns a human-readable version of the river.
 *
 * @param int|array $subject_guid Acting entity to restrict to. Default: all
 * @param int|array $object_guid Entity being acted on to restrict to. Default: all
 * @param string $subject_relationship If set to a relationship type, this will use
 * 	$subject_guid as the starting point and set the subjects to be all users this
 * 	entity has this relationship with (eg 'friend'). Default: blank
 * @param string $type The type of entity to restrict to. Default: all
 * @param string $subtype The subtype of entity to restrict to. Default: all
 * @param string $action_type The type of river action to restrict to. Default: all
 * @param int $limit The number of items to retrieve. Default: 20
 * @param int $posted_min The minimum time period to look at. Default: none
 * @param int $posted_max The maximum time period to look at. Default: none
 * @return string Human-readable river.
 */
function mt_elgg_view_river_items_by_group($subject_guid = 0, $group_guid = 0,
$type = '', $subtype = '', $action_type = '', $limit = 20, $posted_min = 0, $posted_max = 0, $pagination = true) {

    // Get input from outside world and sanitise it
    $offset = (int) get_input('offset',0);

    // Get river items, if they exist
    if ($riveritems = mt_get_river_items_by_group($subject_guid,$group_guid,$type,$subtype,$action_type,($limit + 1),$offset,$posted_min,$posted_max)) {

        return elgg_view('river/item/list',array(
			'limit' => $limit,
			'offset' => $offset,
			'items' => $riveritems,
			'pagination' => $pagination
        ));

    } else {
        return elgg_echo('mt_activity_tabs:empty');
    }

    return '';
}