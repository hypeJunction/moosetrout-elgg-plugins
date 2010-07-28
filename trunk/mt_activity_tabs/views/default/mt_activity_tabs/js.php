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

	// register event handlers for spinner
	$("#mt_ajax_spinner").ajaxStart(function(){
			alert('ajax starting');
		   $(this).show();
		 });
	$("#mt_ajax_spinner").ajaxStop(function(){
			alert('ajax done');
		   $(this).hide();
		 });
    
	// load up nav tabs
	mtLoadTabs();
	
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

// called when tabs need to be loaded
function mtLoadTabs()
{
	//alert('loading tabs!');
	
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
	return false;
}


</script>