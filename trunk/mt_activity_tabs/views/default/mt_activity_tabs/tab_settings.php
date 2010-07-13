<?php

/**
 *
 */

global $CONFIG;

// calculate endpoint query string
$nav_tab_endpoint_values = "orient=" . $vars['orient'] . "&type=" . $vars['type'] . "&url=" . $vars['url'] . "&user=" . $vars['user'];
$nav_tab_endpoint_url = $CONFIG->wwwroot . 'mod/mt_activity_tabs/endpoints/nav_tabs.php';

// grab userid
$userid = $_SESSION['user']->guid;

// grab collections from usersettings
$usersettings = find_plugin_usersettings('mt_activity_tabs', $userid);

// grab user
$user_guid = $_SESSION['user']->guid;

// grab collections for this user
$collections = get_user_access_collections($user_guid);

// grab groups this user is a member of
$groups = get_users_membership($user_guid);

// use ajax to post to /action/plugins/usersettings/save
$url = $CONFIG->wwwroot . "action/plugins/usersettings/save";

// plugin name hidden field
$fb .= elgg_view('input/hidden', array('internalname' => 'plugin', 'value' => 'mt_activity_tabs'));

$fb .= "<div class='admin_statistics'>\n";
$fb .= "<div class='mt_activity_tabs_settings_close'></div>\n";
$fb .= "<table border='1' cellpadding='5'>\n";
$fb .= "<tr><th></th><th>" . elgg_echo('mt_activity_tabs:display') . "</th><th>" . elgg_echo('mt_activity_tabs:makedefault') . "</th></tr>\n";
    
// fix default_tab
if (is_null($usersettings->default_tab)) {
    $usersettings->default_tab = 'all';
}

if (!empty($collections)) {

    $even = false;
    $non_group_collection = false;
    foreach ($collections as $collection) {

        // grab name and skip if a group
        $name = $collection->name;
        if(substr($name, 0, 7) == 'Group: ') {
            continue;
        }

        // set flag
        $non_group_collection = true;

        $id = $collection->id;
        $collectionid = "collection_" . $id;

        if ($even) {
            $fb .= "<tr class='even'><td class='column_one'><img src='" . $CONFIG->wwwroot . "mod/mt_activity_tabs/_graphics/river_icon_collection.png' />$name</td>";
        } else {
            $fb .= "<tr class='odd'><td class='column_one'><img src='" . $CONFIG->wwwroot . "mod/mt_activity_tabs/_graphics/river_icon_collection.png' />$name</td>";
        }

        // fix usersettings when NULL
        if (is_null($usersettings->$collectionid)) {
            $usersettings->$collectionid = 'no';
        }
        
        // radio buttons
        $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalname' => 'params[' . $collectionid .']', 'value' => $usersettings->$collectionid, 'js' => 'onclick="mtActivityTabsSettings(); return false;"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";
        
        // add default radio button if this group is enabled
        if ($usersettings->$collectionid == 'yes') {
            
            // add default radio button
            $fb .= "<td>" . elgg_view('input/radio', array('internalname' => 'params[default_tab]', 'value' => $usersettings->default_tab, 'js' => 'onclick="mtActivityTabsSettings(); return false;"', 'options' => array(''=>$collectionid))) . "</td></tr>\n";
        } else {
            $fb .= "<td></td></tr>\n";
        }
        
        // toggle even flag
        if($even) {
            $even = false;
        } else {
            $even = true;
        }
        
        // print out message if no non-group collections
        if (!$non_group_collection) {
            $fb .= '<tr><td>' . elgg_echo('mt_activity_tabs:nocollections') . '</td></tr>';
        }
    }
}

if (!empty($groups)) {

    // iterate through groups
    foreach ($groups as $group) {

        //
        $name = $group->name;

        $id = $group->guid;
        $groupid = "group_" . $id;

        if ($even) {
            $fb .= "<tr class='even'><td class='column_one'><img src='" . $CONFIG->wwwroot . "mod/mt_activity_tabs/_graphics/river_icon_group.png' />$name</td>";
        } else {
            $fb .= "<tr class='odd'><td class='column_one'><img src='" . $CONFIG->wwwroot . "mod/mt_activity_tabs/_graphics/river_icon_group.png' />$name</td>";
        }
        
        // fix usersettings when NULL
        if (is_null($usersettings->$groupid)) {
            $usersettings->$groupid = 'no';
        }
        
        // radio buttons
        $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalname' => 'params[' . $groupid .']', 'value' => $usersettings->$groupid, 'js' => 'onclick="mtActivityTabsSettings()"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";

        // add default radio button if this group is enabled
        if ($usersettings->$groupid == 'yes') {
            $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalname' => 'params[default_tab]', 'value' => $usersettings->default_tab, 'js' => 'onclick="mtActivityTabsSettings()"', 'options' => array(''=>$groupid))) . "</td></tr>\n";
        } else {
            $fb .= "<td></td></tr>\n";
        }
        // toggle even flag
        if($even) {
            $even = false;
        } else {
            $even = true;
        }
    }
}

$fb .= "</table>\n";
$fb .= "</div>\n";

$fb .= elgg_view('input/button', array(	'name' => 'submit',
                                        'value' => elgg_echo('Submit'),
										'js' => 'onclick="mtActivityTabsSettings(); return false;"' ));

// open div

echo("<div id='mt_activity_tabs_settings'>\n");
echo("<div id='mt_activity_tabs_settings_header'></div>\n");
echo("<div id='mt_activity_tabs_settings_body'>\n");

// write out form
echo elgg_view('input/form', array('body' => $fb, 'internalid' =>'mt_activity_tabs_settings_form'));

// write out explanations for groups and collections
?>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_collection.png" /><?php echo elgg_echo('mt_activity_tabs:collectionexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/collections/add"><?php echo elgg_echo('mt_activity_tabs:createcollection')?></a></p>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_group.png" /><?php echo elgg_echo('mt_activity_tabs:groupexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/groups/new"><?php echo elgg_echo('mt_activity_tabs:creategroup')?></a></p>

</div><!--  close mt_activity_tabs_settings_body div -->
</div><!--  close mt_activity_tabs_settings div -->