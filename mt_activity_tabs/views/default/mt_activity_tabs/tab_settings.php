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
$url = elgg_add_action_tokens_to_url($CONFIG->wwwroot . "action/plugins/usersettings/save"); 

// create form
echo elgg_view('input/form', array('id' =>'mt_activity_tabs_settings_form', 'action' => $url));

// hidden field
echo elgg_view('input/hidden', array('name' => 'plugin', 'value' => 'mt_activity_tabs'));

echo("<p>" . elgg_echo('mt_activity_tabs:description') ."<p>\n");

echo("<div class=''>\n");
echo("<h3>Collections</h3>\n");
echo("<table border='1' cellpadding='5'>\n");

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
        echo("<tr class='even'><td class='column_one'>$name</td>");
    } else {
        echo("<tr class='odd'><td class='column_one'>$name</td>");
    }
    echo("<td><select name='params[{$collectionid}]'>\n");

    ?>
<option value="yes"
    <?php if ($usersettings->{$collectionid} == 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
<option value="no"
    <?php if ($usersettings->{$collectionid} != 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select></td></tr>
    <?php
    
    // toggle even flag
    if($even) {
        $even = false;
    } else {
        $even = true;
    }
}
echo("</table>\n");

echo("<br /><br />\n");

echo("<h3>Groups</h3>\n");
echo("<table border='1' cellpadding='5'>\n");

// even flag
$even = false;
foreach ($groups as $group) {

    //
    $name = $group->name;
    
    $id = $group->guid;
    $groupid = "group_" . $id;

    if ($even) {
        echo("<tr class='even'><td class='column_one'>$name</td>");
    } else {
        echo("<tr class='odd'><td class='column_one'>$name</td>");
    }	
    echo("<td><select name='params[{$groupid}]'>\n");

    ?>
<option value="yes"
    <?php if ($usersettings->{$groupid} == 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
<option value="no"
    <?php if ($usersettings->{$groupid} != 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
</select></td></tr>
    <?php
    
    // toggle even flag
    if($even) {
        $even = false;
    } else {
        $even = true;
    }
}

echo("</table>\n");
echo("</div>\n");

echo elgg_view('input/button', array(	'value' => elgg_echo('Submit'),
										'js' => 'onclick="mtActivityTabsSettings()"' ));

echo '<div id="mt_ajax_spinner"><img src="' . $vars['url'] . '_graphics/ajax_loader.gif" /></div>';
echo('</form>');

?>

<div id="mt_ajax_spinner"><img src="<?php echo $vars['url'] ?>_graphics/ajax_loader.gif" /></div>

<script type="text/javascript">
function mtActivityTabsSettings()
{
	$("#mt_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });

	$("#mt_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
		 });
	
	$.ajax({
		type: "POST",
		url: <?php echo $url ?>,
		data: $("#mt_activity_tabs_settings_form").serialize());
		cache: false,
		success: function(data){

			// reload tabs
		}
	});
}
</script>