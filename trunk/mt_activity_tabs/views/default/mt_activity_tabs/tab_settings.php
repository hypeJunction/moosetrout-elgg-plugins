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
$fb .= "<div class='mt_activity_tabs_usersettings_close'></div>\n";
$fb .= "<table border='1' cellpadding='5'>\n";
$fb .= "<tr><th></th><th>" . elgg_echo('mt_activity_tabs:display') . "</th><th>" . elgg_echo('mt_activity_tabs:makedefault') . "</th></tr>\n";
    
// fix default_tab
if (is_null($usersettings->default_tab)) {
    $usersettings->default_tab = 'all';
}

// print out row for all
// fix usersettings when NULL
if (is_null($usersettings->all)) {
    $usersettings->all = 'yes';
}
$fb .= "<tr class='even'><td class='column_one'>All</td>";
$fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalid' => 'mtat_all', 'internalname' => 'params[all]', 'value' => $usersettings->all, 'js' => 'onclick="mtActivityTabsToggleDefaultRadio(\'all\', \'all\');"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";

// is default radio button disabled?
unset($disabled);
if ($usersettings->all == 'no') {
    $disabled = 'disabled';
}

// default radio button    
$fb .= "<td>" . elgg_view('input/radio', array('internalid' => "default_select_all", 'internalname' => 'params[default_tab]', 'disabled' => $disabled, 'value' => $usersettings->default_tab, 'options' => array(''=>'all'))) . "</td></tr>\n";

// print out row for friends
$pluginsettings = find_plugin_settings('mt_activity_tabs');
if ($pluginsettings->enable_disable_friends == 'true') {
    
    // fix usersettings when NULL
    if (is_null($usersettings->friends)) {
        $usersettings->friends = 'yes';
    }
    $fb .= "<tr class='even'><td class='column_one'>Friends</td>";
    $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalid' => 'mtat_friends', 'internalname' => 'params[friends]', 'value' => $usersettings->friends, 'js' => 'onclick="mtActivityTabsToggleDefaultRadio(\'friends\', \'friends\');"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";
    
    // is default radio button disabled?
    unset($disabled);
    if ($usersettings->friends == 'no') {
        $disabled = 'disabled';
    }
    
    // default radio button    
    $fb .= "<td>" . elgg_view('input/radio', array('internalid' => "default_select_friends", 'internalname' => 'params[default_tab]', 'disabled' => $disabled, 'value' => $usersettings->default_tab, 'options' => array(''=>'friends'))) . "</td></tr>\n";
}

// print out row for mine
// fix usersettings when NULL
if (is_null($usersettings->mine)) {
    $usersettings->mine = 'yes';
}
$fb .= "<tr class='even'><td class='column_one'>Mine</td>";
$fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalid' => 'mtat_mine', 'internalname' => 'params[mine]', 'value' => $usersettings->mine, 'js' => 'onclick="mtActivityTabsToggleDefaultRadio(\'mine\', \'mine\');"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";

// is default radio button disabled?
unset($disabled);
if ($usersettings->mine == 'no') {
    $disabled = 'disabled';
}

// default radio button    
$fb .= "<td>" . elgg_view('input/radio', array('internalid' => "default_select_mine", 'internalname' => 'params[default_tab]', 'disabled' => $disabled, 'value' => $usersettings->default_tab, 'options' => array(''=>'mine'))) . "</td></tr>\n";

        
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
        $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalid' => 'mtat_c_' . $collectionid, 'internalname' => 'params[' . $collectionid .']', 'value' => $usersettings->$collectionid, 'js' => 'onclick="mtActivityTabsToggleDefaultRadio(\'collection\', \'' . $collectionid . '\');"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";

        // is default radio button disabled?
        unset($disabled);
        if ($usersettings->$collectionid == 'no') {
            $disabled = 'disabled';
        }

        // default radio button    
        $fb .= "<td>" . elgg_view('input/radio', array('internalid' => "default_select_" . $collectionid, 'internalname' => 'params[default_tab]', 'disabled' => $disabled, 'value' => $usersettings->default_tab, 'options' => array(''=>$collectionid))) . "</td></tr>\n";
                
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
        $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalname' => 'params[' . $groupid .']', 'value' => $usersettings->$groupid, 'js' => 'onclick="mtActivityTabsToggleDefaultRadio(\'group\', \'' . $groupid . '\')"', 'options' => array('yes'=>'yes', 'no'=>'no'))) . "</td>";

        // is default radio button disabled?
        unset($disabled);
        if ($usersettings->$groupid == 'no') {
            $disabled = 'disabled';
        }
        
        // default radio button
        $fb .= "<td>" . elgg_view('mt_activity_tabs/input/radio', array('internalid' => "default_select_" . $groupid, 'internalname' => 'params[default_tab]', 'disabled' => $disabled, 'value' => $usersettings->default_tab, 'options' => array(''=>$groupid))) . "</td></tr>\n";

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

$fb .= elgg_view('input/button', array(	'internalid' => 'mt_activity_tabs_usersettings_submit',
										'name' => 'submit',
                                        'value' => elgg_echo('Submit')));

// open div

echo("<div id='mt_activity_tabs_usersettings'>\n");
echo("<div id='mt_activity_tabs_usersettings_header'></div>\n");
echo("<div id='mt_activity_tabs_usersettings_body'>\n");

// write out form
echo elgg_view('input/form', array('action' => $CONFIG->wwwroot . 'action/plugins/usersettings/save', 'body' => $fb, 'internalid' =>'mt_activity_tabs_usersettings_form'));

// write out explanations for groups and collections
?>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_collection.png" /><?php echo elgg_echo('mt_activity_tabs:collectionexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/collections/add"><?php echo elgg_echo('mt_activity_tabs:createcollection')?></a></p>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_group.png" /><?php echo elgg_echo('mt_activity_tabs:groupexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/groups/new"><?php echo elgg_echo('mt_activity_tabs:creategroup')?></a></p>

</div><!--  close mt_activity_tabs_usersettings_body div -->
</div><!--  close mt_activity_tabs_usersettings div -->