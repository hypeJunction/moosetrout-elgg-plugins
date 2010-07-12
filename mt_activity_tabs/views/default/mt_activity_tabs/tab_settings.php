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
$fb .= "<table border='1' cellpadding='5'>\n";
$fb .= "<tr class='even'><th></th><th></th><th>" . elgg_echo('mt_activity_tabs:makedefault') . "</th></tr>\n";
    
if (empty($collections)) {
    $fb .= '<tr><td>' . elgg_echo('mt_activity_tabs:nocollections') . '</td></tr>';
} else {

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
        $fb .= "<td><select name='params[{$collectionid}]'>\n";

        // yes
        $fb .= '<option value="yes"';
        if ($usersettings->{$collectionid} == 'yes') {
            $fb .= " selected=\"selected\" ";
        }
        $fb .= '>' . elgg_echo('mt_activity_tabs:remove') .'</option>';

        // no
        $fb .= '<option value="no"';
        if ($usersettings->{$collectionid} != 'yes') {
            $fb .= " selected=\"selected\" ";
        }
        $fb .= '>' . elgg_echo('mt_activity_tabs:add') . '</option></select></td>';

        // add default radio button
        $fb .= "<td>" . elgg_view('input/radio', array('internalname' => 'default_tab', 'value' => $collectionid)) . "</td></tr>\n";
        
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

if (empty($groups)) {
    $fb .= '<tr><td>' . elgg_echo('mt_activity_tabs:nogroups') . "</td></tr>\n";
} else {

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
        $fb .= "<td><select name='params[{$groupid}]'>\n";

        // yes
        $fb .= '<option value="yes"';
        if ($usersettings->{$groupid} == 'yes') {
            $fb .= " selected=\"selected\" ";
        }
        $fb .= '>' . elgg_echo('mt_activity_tabs:remove') . '</option>';

        // no
        $fb .= '<option value="no"';
        if ($usersettings->{$groupid} != 'yes') {
            $fb .= " selected=\"selected\" ";
        }
        
        // finish select dropdown
        $fb .= '>' . elgg_echo('mt_activity_tabs:add') . "</option></select>"; //</td>";
        
        // try out radio buttons
        $fb .= elgg_view('input/radio', array('internalname' => 'params[' . $groupid .']', 'value' => $groupid, 'options'=>array('yes'=>'yes', 'no'=>'no')));

        // add default radio button
        $fb .= "<td>" . elgg_view('input/radio', array('internalname' => 'default_tab', 'value' => $groupid)) . "</td></tr>\n";

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

$fb .= '<div id="mt_ajax_spinner"><img src="' . $vars['url'] . '_graphics/ajax_loader.gif" /></div>';

// open div
echo("<div id='mt_activity_tabs_settings'>\n");

// write out form
echo elgg_view('input/form', array('body' => $fb, 'internalid' =>'mt_activity_tabs_settings_form'));

// write out explanations for groups and collections
?>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_collection.png" /><?php echo elgg_echo('mt_activity_tabs:collectionexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/collections/add"><?php echo elgg_echo('mt_activity_tabs:createcollection')?></a></p>
<p><img src="<?php echo $CONFIG->wwwroot ?>mod/mt_activity_tabs/_graphics/river_icon_group.png" /><?php echo elgg_echo('mt_activity_tabs:groupexpl')?><a href="<?php echo $CONFIG->wwwroot ?>pg/groups/new"><?php echo elgg_echo('mt_activity_tabs:creategroup')?></a></p>

</div><!--  close mt_actitivy_tabs_settings div -->


<script type="text/javascript">

// called when submit button is clicked
function mtActivityTabsSettings()
{

	// register event handlers for spinner
	$("#mt_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });
	$("#mt_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
		 });

	// serialize form values
	var mapped_values = {};
	mapped_values = $("#mt_activity_tabs_settings_form").serialize();

	// make ajax call
	$.ajax({
		type: "POST",
		url: '<?php echo $url ?>',
		data: mapped_values,
		cache: false,
		success: function(returned_data){

			// reload tabs
			mtLoadTabs();
		}
	});
}

function mtLoadTabs()
{
	// make ajax call
	$.ajax({
		type: "POST",
		url: '<?php echo $nav_tab_endpoint_values ?>',
		data: '<?php echo $nav_tab_endpoint_url ?>',
		cache: false,
		success: function(returned_data){

			// reload tabs
			$('#elgg_horizontal_tabbed_nav').html(returned_data);
		}
	});
}
</script>
