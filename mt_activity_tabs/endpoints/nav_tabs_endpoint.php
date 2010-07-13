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

$orient = get_input('orient');
$url = get_input('url');
$type = get_input('type');
$subtype = get_input('subtype');
$user = get_input('user');

echo("NAV_TABS_ENDPOINT.PHP -- orient: $orient; url: $url; type: $type; subtype: $subtype; user: $user<br />");

switch($orient) {
    case '':		$allselect = 'class="selected"';
    break;
    case 'friends':		$friendsselect = 'class="selected"';
    break;
    case 'mine':		$mineselect = 'class="selected"';
    break;
}


// grab enabled collections and groups from usersettings
$collection_ids = mt_get_user_collection_ids($user->guid);
$group_ids = mt_get_user_group_ids($user->guid);

$c_river = false;
$g_river = false;
// deal with setting class for selected collection tab
if (substr($orient, 0, 11) == 'collection_') {
    //
    $c_river = true;
    $z = explode('_', $orient);
    $selectedid = $z[1];
} else if (substr($orient, 0, 6) == 'group_') {
    $g_river = true;
    $z = explode('_', $orient);
    $selectedid = $z[1];
}

?>

<ul>
	<li <?php echo $allselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $url; ?>pg/activity_tabs/?content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display="><?php echo elgg_echo('all'); ?></a></li>
	<li <?php echo $friendsselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $url; ?>pg/activity_tabs/?display=friends&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display=friends"><?php echo elgg_echo('friends'); ?></a></li>
	<li <?php echo $mineselect; ?>><a
		onclick="javascript:$('#river_container').load('<?php echo $url; ?>pg/activity_tabs/?display=mine&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
		href="?display=mine"><?php echo elgg_echo('mine'); ?></a></li>
		<?php

	// iterate through collections
	foreach($collection_ids as $id) {

	    $collection = get_access_collection($id);
	    $collection_name = $collection->name;

        // set selected class
	    if($c_river && ($selectedid == $id)) {
	    ?>
	        <li class='selected'><a
	        onclick="javascript:$('#river_container').load('<?php echo $url; ?>pg/activity_tabs/?display=collection_<?php echo $collection->id ?>&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
	        href="?display=collection_<?php echo $collection->id; ?>"><?php echo $collection_name; ?></a></li>
	        
	    <?php
	    } else {
	    ?>
            <li><a
            onclick="javascript:$('#river_container').load('<?php echo $url; ?>pg/activity_tabs/?display=collection_<?php echo $collection->id ?>&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
            href="?display=collection_<?php echo $collection->id; ?>"><?php echo $collection_name; ?></a></li>
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
	    	<li class='selected'><a
	    	onclick="javascript:$('#river_container').load('<?php echo $url ?>pg/activity_tabs/?display=group_<?php echo $id ?>&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
	    	href="?display=group_<?php echo $id ?>"><?php echo $group_name ?></a></li>
	    <?php
	    } else {
	    ?>
	        <li><a
	        onclick="javascript:$('#river_container').load('<?php echo $url ?>pg/activity_tabs/?display=group_<?php echo $id ?>&amp;content=<?php echo $type; ?>,<?php echo $vars['subtype']; ?>&amp;callback=true'); return false;"
	        href="?display=group_<?php echo $id ?>"><?php echo $group_name ?></a></li>
	    <?php
	    }
	}
	
	// add settings tab
	echo("<li><a href='#' id='mt_display_tab_settings'>+/-</a></li>");
	
	// add ajax spinner
	echo("<li id='mt_ajax_spinner'><img src='" . $url . "_graphics/ajax_loader.gif' /></li>");
	?>
	    
</ul>