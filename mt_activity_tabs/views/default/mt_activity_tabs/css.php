#mt_ajax_spinner {
	float: right;
	margin-right: 340px;
	display: none;
}

#mt_activity_tabs_settings_header {
	height:10px;
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/div_up.png) no-repeat center -1px;
	background-color:white;
}
#mt_activity_tabs_settings_body {
	border:1px solid #cccccc;
	background-color:#dddddd;
	margin:10px;
}

// override river icons
.river_object_event_calendar_create {
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/river_icon_calendar.png) no-repeat left -1px;
}
.river_object_event_calendar_update {
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/river_icon_calendar.png) no-repeat left -1px;
}