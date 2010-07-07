<?php

/**
 * Rewrite of Elgg river dashboard plugin index page
 * to support group and collection tabs
 *
 * @package ElggRiverDash
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com> and Brian Jorgensen <brian@moosetrout.com>
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.org/
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
require_once(dirname(__FILE__) . '/lib/river2.php');

// grab userid
$userid = $_SESSION['user']->guid;

// grab collections from usersettings
$usersettings = find_plugin_usersettings('mt_activity_tabs', $userid);

// collections is an array of collection_guid
// that user asked to appear in activity tool
$collection_ids = array();
$group_guids = array();

// iterate
foreach($usersettings as $key => $value) {
    	
    $gc = explode('_', $key);
    	
    if ($value == 'yes') {
        if ($gc[0] == "group") {
            $group_ids[] = $gc[1];
        } else if ($gc[0] == 'collection') {
            $collection_ids[] = $gc[1];
        }
    }
}

gatekeeper();

$content = get_input('content','');
$content = explode(',',$content);
$type = $content[0];
if (isset($content[1])) {
    $subtype = $content[1];
} else {
    $subtype = '';
}
$orient = get_input('display');

if (substr($orient, 0, 11) == 'collection_') {
    $c_river = true;
    $z = explode('_', $orient);
    $collection_guid = $z[1];
} else if (substr($orient, 0, 6) == 'group_') {
    $g_river = true;
    $zz = explode('_', $orient);
    $group_guid = $zz[1];
}

$callback = get_input('callback');

if ($type == 'all') {
    $type = '';
    $subtype = '';
}

$body = '';
if (empty($callback)) {

    //set a view for the wire to extend
    $area1 = elgg_view("riverdashboard/sitemessage");

    //set a view to display newest members
    $area1 .= elgg_view("riverdashboard/newestmembers");

    //set a view to display a welcome message
    $body .= elgg_view("riverdashboard/welcome");

}

switch($orient) {
    case 'mine':
        $subject_guid = $_SESSION['user']->guid;
        $relationship_type = '';
        break;
    case 'friends':	$subject_guid = $_SESSION['user']->guid;
    $relationship_type = 'friend';
    break;
    default:		$subject_guid = 0;
    $relationship_type = '';
    break;
}

if ($c_river) {
    $subject_guid = $_SESSION['user']->guid;
    $river =  mt_elgg_view_river_items_by_collection($subject_guid, $collection_guid, $type, $subtype, '') . "</div>";
} else if ($g_river) {
    $subject_guid = $_SESSION['user']->guid;
    $river =  mt_elgg_view_river_items_by_group($subject_guid, $group_guid, $type, $subtype, '') . "</div>";
} else {
    $river =  elgg_view_river_items($subject_guid, 0, $relationship_type, $type, $subtype, '') . "</div>";
}

// Replacing callback calls in the nav with something meaningless
$river = str_replace('callback=true','replaced=88,334',$river);

$nav = elgg_view('riverdashboard/nav',array(
											'type' => $type,
											'subtype' => $subtype,
											'orient' => $orient,
											'collection_ids' => $collection_ids
                                            )
                );

if (empty($callback)) {
    $body .= elgg_view('riverdashboard/container', array('body' => $nav . $river . elgg_view('riverdashboard/js')));
    
    // use full page layout to support more tabs
    //page_draw(elgg_echo('dashboard'),elgg_view_layout('sidebar_boxes',$area1,$body));
    page_draw(elgg_echo('dashboard'),elgg_view_layout('one_column',$body));
} else {
    header("Content-type: text/html; charset=UTF-8");
    echo $nav . $river . elgg_view('riverdashboard/js');
}

?>
