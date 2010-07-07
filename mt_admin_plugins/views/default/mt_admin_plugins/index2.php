<?php
/*******************************************************************************
 * Main Admin page with tabs
 *
 *
 *
 * @package AU Admin Plugins
 * @author Brian Jorgensen based on elgg_developer_tools code by Cash Costello
 ******************************************************************************/

global $CONFIG;

$tab = $vars['tab'];

if (!$tab) {
    $tab = 'index2';
}

// set tab classes
$indexselect = 'class="auap_tab_nav"';
$listversionsselect = 'class="auap_tab_nav"';
$listoverridesselect = 'class="auap_tab_nav"';
$dumporderselect = 'class="auap_tab_nav"';

// set class for selected tab
switch($tab) {
    case 'list_versions':
        $listversionsselect = 'class="selected auap_tab_nav"';
        break;
    case 'dump_order':
        $dumporderselect = 'class="selected auap_tab_nav"';
        break;
    case 'view_overrides':
        $listoverridesselect = 'class="selected auap_tab_nav';
        break;
    case 'index2':
        $indexselect = 'class="selected auap_tab_nav"';
        break;
    default:
        $indexselect = 'class="selected auap_tab_nav"';
        break;
}

?>
<div class="contentWrapper">
<div id="elgg_horizontal_tabbed_nav">
<ul>
	<li id="auap_index_nav" <?php echo $indexselect; ?>><a
		href="javascript:auapSwitchTab('auap_index')"><?php echo elgg_echo('mt_admin_plugins:index'); ?></a></li>
	<li id="auap_listversions_nav" <?php echo $listversionsselect; ?>><a
		href="javascript:auapSwitchTab('auap_listversions')"><?php echo elgg_echo('mt_admin_plugins:list_versions'); ?></a></li>
	<li id="auap_listoverrides_nav" <?php echo $listoverridesselect; ?>><a
		href="javascript:auapSwitchTab('auap_listoverrides')"><?php echo elgg_echo('mt_admin_plugins:list_view_overrides'); ?></a></li>
	<li id="auap_dumporder_nav" <?php echo $dumporderselect; ?>><a
		href="javascript:auapSwitchTab('auap_dumporder')"><?php echo elgg_echo('mt_admin_plugins:dump_order'); ?></a></li>
</ul>
</div>
<br />

<div id="auap_index_tab" class="mt_admin_plugins_tab"><?php 
echo elgg_view("mt_admin_plugins/content");
?></div>
<div id="auap_listversions_tab" class="mt_admin_plugins_tab"><?php 
echo elgg_view("mt_admin_plugins/content"); //listversions");
?></div>
<div id="auap_listoverrides_tab" class="mt_admin_plugins_tab"><?php 
echo elgg_view("mt_admin_plugins/content"); //listoverrides");
?></div>
<div id="auap_dumporder_tab" class="mt_admin_plugins_tab"><?php 
echo elgg_view("mt_admin_plugins/content"); //dumporder");
?></div>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#auap_<?php echo $tab; ?>_tab").show();
});

function auapSwitchTab(tab_id)
{
	var nav_name = "#" + tab_id + "_nav";
	var tab_name = "#" + tab_id + "_tab";
	
	$(".mt_admin_plugins_tab").hide();
	$(tab_name).show();
	$(".auap_tab_nav").removeClass("selected");
	$(nav_name).addClass("selected");
}
</script>
