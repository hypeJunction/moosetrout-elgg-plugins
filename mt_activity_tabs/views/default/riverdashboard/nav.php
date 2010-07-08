<?php

/**
 * new nav view for mt_activity_tabs
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lib/river2.php');

$contents = array();
$contents['all'] = 'all';
if (!empty($vars['config']->registered_entities)) {
    foreach ($vars['config']->registered_entities as $type => $ar) {
        foreach ($vars['config']->registered_entities[$type] as $object) {
            if (!empty($object )) {
                $keyname = 'item:'.$type.':'.$object;
            } else $keyname = 'item:'.$type;
            $contents[$keyname] = "{$type},{$object}";
        }
    }
}

$allselect = ''; $friendsselect = ''; $mineselect = '';
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
<div class="contentWrapper">
<div id="elgg_horizontal_tabbed_nav">
<p><a href="<?php echo $vars['url']; ?>pg/settings/plugins/admin/#Activity Tabs"><?php echo elgg_echo('mt_activity_tabs:addtab') ?></a></p>
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
		?>
		    
		</ul>
	</div>


<script type="text/javascript">
$(document).ready(function () {

	// hide on load
	$('#mt_display_tab_settings').hide();

	// toggle on click
    $('#mt_display_tab_settings').click(function () {
		$('#mt_activity_tabs_settings').slideToggle("fast");
		return false;
    });
}); /* end document ready function */
</script>
<p><a href='#' id='mt_display_tab_settings'>Show settings</a></p>
<div id="mt_activity_tabs_settings">
Stuff here.
</div>

<div class="riverdashboard_filtermenu"><select name="content" id="content" onchange="javascript:$('#river_container').load('<?php echo $vars['url']; ?>pg/activity_tabs/?callback=true&amp;display='+$('input#display').val() + '&amp;content=' + $('select#content').val());">
	
    <?php
    // iterate to create filter
	foreach($contents as $label => $content) {
	    if (("{$vars['type']},{$vars['subtype']}" == $content) || (empty($vars['subtype']) && $content == 'all')) {
			$selected = 'selected="selected"';
		} else {
		    $selected = '';
		}
		echo "<option value=\"{$content}\" {$selected}>".elgg_echo($label)."</option>";
	}

	?>
</select>
<input type="hidden" name="display" id="display" value="<?php echo htmlentities($vars['orient']); ?>" />
</div>