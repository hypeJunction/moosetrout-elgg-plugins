<?php
/**
 * Javascript for mt_activity_tabs
 */



global $CONFIG;
$nav_tab_endpoint_values = "orient=" . $vars['orient'] . "&type=" . $vars['type'] . "&subtype=" . $vars['subtype']; // . "&url=" . $vars['url'] . "&user=" . $vars['user'];
$nav_tab_endpoint_url = $CONFIG->wwwroot . 'mod/mt_activity_tabs/endpoints/nav_tabs_endpoint.php';

// use ajax to post to /action/plugins/usersettings/save
$usersettings_url = $CONFIG->wwwroot . "mod/mt_activity_tabs/endpoints/usersettings_save.php";

?>
<script type="text/javascript">
$(document).ready(function () {
	
	// add events that show/hide settings div onclick
//    $('#mt_display_tab_settings').click(function () {
//        alert('+/- clicked');
//		$('#mt_activity_tabs_settings').slideToggle("fast");
//		return false;
//    });

	// register event handlers for spinner
	$("#mt_ajax_spinner").ajaxStart(function(){
		   $(this).show();
		 });
	$("#mt_ajax_spinner").ajaxStop(function(){
		   $(this).hide();
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

			// load tabs
			$('#elgg_horizontal_tabbed_nav').html(returned_data);
		}
	});
	
}); /* end document ready function */

// activate default radio button
function mtActivityTabsToggleDefaultRadio(stype,sid) {
	
	// calculate default radio button id
	var drbid = 'default_select_' + sid;

	// figure out which button was clicked, yes or no
	var thisval = $("input[name='params[" + sid + "]']:checked").val();

	// enable/disable default radio button
	if (thisval == 'no') {

		$("#" + drbid).attr("disabled","disabled");
	} else if (thisval == 'yes') {

		$("#" + drbid).removeAttr("disabled");
	} else {
		//alert('');
	}

	return true;
}

// called when settings change
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
	alert('mapped_values: ' + mapped_values);
	
	// make ajax call to submit settings form
	$.ajax({
		type: "POST",
		url: '<?php echo $usersettings_url ?>',
		data: mapped_values,
		cache: false,
		error: function(xhr, status, error) {
			alert('xhr error: ' + xhr.status + '; status: ' + status + '; error: ' + error);
			return false;
		},
		success: function(returned_data){
			alert('Success! Reloading tabs');
			// reload tabs
			mtLoadTabs();
		}
	});

	return false;
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
		url: '<?php echo $nav_tab_endpoint_url ?>',
		data: '<?php echo $nav_tab_endpoint_values ?>',
		cache: false,
		success: function(returned_data){

			// reload tabs
			$('#elgg_horizontal_tabbed_nav').html(returned_data);
		}
	});
}


</script>