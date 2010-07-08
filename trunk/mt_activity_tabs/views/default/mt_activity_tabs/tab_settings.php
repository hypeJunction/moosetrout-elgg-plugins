<?php

/**
 * 
 */

global $CONFIG;

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

$fb .= "<p>" . elgg_echo('mt_activity_tabs:description') ."<p>\n";

$fb .= "<div class=''>\n";
$fb .= "<h3>Collections</h3>\n";
$fb .= "<table border='1' cellpadding='5'>\n";

$even = false;
foreach ($collections as $collection) {

    //
    $name = $collection->name;
    if(substr($name, 0, 7) == 'Group: ') {
        continue;  
    }
    
    $id = $collection->id;
    $collectionid = "collection_" . $id;

    if ($even) {
        $fb .= "<tr class='even'><td class='column_one'>$name</td>";
    } else {
        $fb .= "<tr class='odd'><td class='column_one'>$name</td>";
    }
    $fb .= "<td><select name='params[{$collectionid}]'>\n";

    // yes
    $fb .= '<option value="yes"';
    if ($usersettings->{$collectionid} == 'yes') {
        $fb .= " selected=\"selected\" "; 
    }
    $fb .= '>' . elgg_echo('option:yes') .'</option>';
    
    // no
    $fb .= '<option value="no"';
    if ($usersettings->{$collectionid} != 'yes') {
        $fb .= " selected=\"selected\" "; 
    }
    $fb .= '>' . elgg_echo('option:no') . '</option></select></td></tr>';
    
    // toggle even flag
    if($even) {
        $even = false;
    } else {
        $even = true;
    }
}
$fb .= "</table>\n";

$fb .= "<br /><br />\n";

$fb .= "<h3>Groups</h3>\n";
$fb .= "<table border='1' cellpadding='5'>\n";

// even flag
$even = false;
foreach ($groups as $group) {

    //
    $name = $group->name;
    
    $id = $group->guid;
    $groupid = "group_" . $id;

    if ($even) {
        $fb .= "<tr class='even'><td class='column_one'>$name</td>";
    } else {
        $fb .= "<tr class='odd'><td class='column_one'>$name</td>";
    }	
    $fb .= "<td><select name='params[{$groupid}]'>\n";

    // yes
    $fb .= '<option value="yes"';
    if ($usersettings->{$groupid} == 'yes') {
        $fb .= " selected=\"selected\" "; 
    }
    $fb .= '>' . elgg_echo('option:yes') . '</option>';
    
    // no
    $fb .= '<option value="no"';
    if ($usersettings->{$groupid} != 'yes') {
        $fb .= " selected=\"selected\" "; 
    }
    $fb .= '>' . elgg_echo('option:no') . '</option></select></td></tr>';
    
    // toggle even flag
    if($even) {
        $even = false;
    } else {
        $even = true;
    }
}

$fb .= "</table>\n";
$fb .= "</div>\n";

$fb .= elgg_view('input/button', array(	'name' => 'submit',
                                        'value' => elgg_echo('Submit'),
										'js' => 'onclick="mtActivityTabsSettings()"' ));

$fb .= '<div id="mt_ajax_spinner"><img src="' . $vars['url'] . '_graphics/ajax_loader.gif" /></div>';

echo elgg_view('input/form', array('body' => $fb, 'id' =>'mt_activity_tabs_settings_form', 'action' => $url));

?>

<div id="mt_ajax_spinner"><img src="<?php echo $vars['url'] ?>_graphics/ajax_loader.gif" /></div>

<script type="text/javascript">

$(document).ready(function() {	
    $('#mt_activity_tabs_settings_form').submit(function() {
    	  alert($(this).serialize());
    	  return false;
    });
});

function mtActivityTabsSettings()
{
	alert('here');

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
	alert(mapped_values);
	
	var datastring = 'a=b';

	// make ajax call
	$.ajax({
		type: "POST",
		url: '<?php echo $url ?>',
		data: datastring,
		cache: false
//		success: function(data){
//
//			// reload tabs
//		}
	});
}
</script>