<?php 

/**
 * Ajax endpoint
 * @var unknown_type
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

global $CONFIG;

gatekeeper();
	
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
	
$allselect = '';
$friendsselect = '';
$mineselect = '';

$vars['orient'] = get_input('orient');
$vars['url'] = get_input('url');
$vars['type'] = get_input('type');
$vars['user'] = get_input('user');

switch($vars['orient']) {
    case '':		$allselect = 'class="selected"';
    break;
    case 'friends':		$friendsselect = 'class="selected"';
    break;
    case 'mine':		$mineselect = 'class="selected"';
    break;
}


// grab enabled collections and groups from usersettings
$collection_ids = mt_get_user_collection_ids($vars['user']->guid);
$group_ids = mt_get_user_group_ids($vars['user']->guid);

$c_river = false;
$g_river = false;
// deal with setting class for selected collection tab
if (substr($vars['orient'], 0, 11) == 'collection_') {
    //
    $c_river = true;
    $z = explode('_', $vars['orient']);
    $selectedid = $z[1];
} else if (substr($vars['orient'], 0, 6) == 'group_') {
    $g_river = true;
    $z = explode('_', $vars['orient']);
    $selectedid = $z[1];
}

?>

<ul>
	<li <?php echo $allselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display="><?php echo elgg_echo('all'); ?></a></li>
	<li <?php echo $friendsselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?display=friends&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display=friends"><?php echo elgg_echo('friends'); ?></a></li>
	<li <?php echo $mineselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?display=mine&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display=mine"><?php echo elgg_echo('mine'); ?></a></li>
		<?php

	// iterate through collections
	foreach($collection_ids as $id) {

	    $collection = get_access_collection($id);
	    $collection_name = $collection->name;

        // set selected class
	    if($c_river && ($selectedid == $id)) {
	    ?>
	        <li class='selected'><a onclick="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?display=collection_<?php echo $collection->id ?>&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;" href="?display=collection_<?php echo $collection->id; ?>"><?php echo $collection_name; ?></a></li>
	        
	    <?php
	    } else {
	    ?>
            <li><a onclick="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?display=collection_<?php echo $collection->id ?>&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;" href="?display=collection_<?php echo $collection->id; ?>"><?php echo $collection_name; ?></a></li>
        <?php
        }
	}

	// iterate through groups
	foreach($group_ids as $id) {

	    $group = get_group_entity_as_row($id);
	    $group_name = $group->name;

        // set selected class
	    if($g_river && ($selectedid == $id)) {
	    ?>
	    	<li class='selected'><a onclick="javascript:$('#river_container').load('<?php echo $vars['url'] ?>pg/activity_tabs/?display=group_<?php echo $id ?>&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;" href="?display=group_<?php echo $id ?>"><?php echo $group_name ?></a></li>
	    <?php
	    } else {
	    ?>
	        <li><a onclick="javascript:$('#river_container').load('<?php echo $vars['url'] ?>pg/activity_tabs/?display=group_<?php echo $id ?>&amp;content=<?php echo $vars['type']; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;" href="?display=group_<?php echo $id ?>"><?php echo $group_name ?></a></li>
	    <?php
	    }
	}
	
	// add settings tab
	echo("<li><a href='#' id='mt_display_tab_settings'>+/-</a></li>");
	
	// add ajax spinner
	//echo("<li id='mt_activity_tabs_tab_spinner'><img src='" . $vars['url'] . "_graphics/ajax_loader.gif' /></li>");
	?>
	    
</ul>


<script type='text/javascript'>

// body onload
$(document).ready(function () {

	// hide ajax spinner
	$("#mt_activity_tabs_tab_spinner").hide();


}

// when a tab is clicked
function mtActivityTabsTabClick()
{
    // register event handlers for spinner
    $("#mt_activity_tabs_tab_spinner").ajaxStart(function(){
    	   $(this).show();
    	 });
    $("#mt_activity_tabs_tab_spinner").ajaxStop(function(){
    	   $(this).hide();
    	 });
}

</script>