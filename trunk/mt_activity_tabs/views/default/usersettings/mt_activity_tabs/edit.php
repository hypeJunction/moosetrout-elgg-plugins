<?php
/**
 * User settings for mt_activity_tabs plugin
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */


$user_guid = $_SESSION['user']->guid;

// grab collections for this user
$collections = get_user_access_collections($user_guid);

// grab groups this user is a member of
$groups = get_users_membership($user_guid);

echo("<p>" . elgg_echo('mt_activity_tabs:description') ."<p>\n");

echo("<div class='admin_statistics'>\n");
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
    <?php if ($vars['entity']->{$collectionid} == 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
<option value="no"
    <?php if ($vars['entity']->{$collectionid} != 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
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
    <?php if ($vars['entity']->{$groupid} == 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
<option value="no"
    <?php if ($vars['entity']->{$groupid} != 'yes') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
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
echo($form_body);
//echo("<p><a href='" . $vars['url'] ."pg/activity_tabs/'>" . elgg_echo('mt_activity_tabs:clickhere') . "</a></p>\n");