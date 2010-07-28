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
//echo("NAV.php -- orient: {$vars['orient']};");

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
<div id='mt_ajax_spinner'><img src='<?php echo $vars['url'] ?>mod/medikly_theme/graphics/custom/wp_preload.gif' /></div>
</div>

<?php echo elgg_view('mt_activity_tabs/js', array(
											'type' => $vars['type'],
											'subtype' => $vars['subtype'],
											'orient' => $vars['orient']
                                            )) ?>

<?php echo elgg_view('mt_activity_tabs/tab_settings', array(
											'type' => $vars['type'],
											'subtype' => $vars['subtype'],
											'orient' => $vars['orient']
                                            )) ?>

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