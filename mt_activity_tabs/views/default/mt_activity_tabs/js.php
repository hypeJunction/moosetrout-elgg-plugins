<?php
/**
 * Javascript for mt_activity_tabs
 */



global $CONFIG;
$nav_tab_endpoint_values = "orient=" . $vars['orient'] . "&type=" . $vars['type'] . "&url=" . $vars['url'] . "&user=" . $vars['user'];
$nav_tab_endpoint_url = $CONFIG->wwwroot . 'mod/mt_activity_tabs/endpoints/nav_tabs_endpoint.php';

echo($nav_tab_endpoint_values);
echo($nav_tab_endpoint_url);

?>
<script type="text/javascript">
$(document).ready(function () {

	// hide settings div on load
	$('#mt_activity_tabs_settings').hide();

	// hide ajax spinner on load
	$("#mt_activity_tabs_tab_spinner").hide();
	
	// add events that show/hide settings div onclick
    $('#mt_display_tab_settings').click(function () {
		$('#mt_activity_tabs_settings').slideToggle("fast");
		//return false;
    });
    
	// load up nav tabs
	// make ajax call
	var endpoint_values = '<?php echo $nav_tab_endpoint_values ?>';
	$.ajax({
		type: "POST",
		url: '<?php echo $nav_tab_endpoint_url ?>',
		data: endpoint_values,
		cache: false,
		success: function(returned_data){

			// reload tabs
			$('#elgg_horizontal_tabbed_nav').html(returned_data);
		}
	});
	
}); /* end document ready function */

// called when a tab is clicked
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

// called when a settings
function mtActivityTabsSettings()
{

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

	// make ajax call to submit settings form
	$.ajax({
		type: "POST",
		url: '<?php echo $url ?>',
		data: mapped_values,
		cache: false,
		success: function(returned_data){

			// reload tabs
			mtLoadTabs();
		}
	});
}

// called when tabs need to be reloaded
function mtLoadTabs()
{

	// register event handlers for spinner
	$("#mt_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });
	$("#mt_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
		 });
	 
	// make ajax call
	$.ajax({
		type: "POST",
		url: '<?php echo $nav_tab_endpoint_values ?>',
		data: '<?php echo $nav_tab_endpoint_url ?>',
		cache: false,
		success: function(returned_data){

			// reload tabs
			$('#elgg_horizontal_tabbed_nav').html(returned_data);
		}
	});
}


</script>