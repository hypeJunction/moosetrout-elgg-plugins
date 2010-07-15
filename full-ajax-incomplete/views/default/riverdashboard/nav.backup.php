<?php ?>
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
	echo("<li><a href='#' id='mt_display_tab_settings'>+/!</a></li>");
	?>
	    
</ul>