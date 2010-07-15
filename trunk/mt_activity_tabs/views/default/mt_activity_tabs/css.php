#mt_ajax_spinner {
	float: right;
	display: none;
}
#mt_activity_tabs_settings {
	display:none;
}
#mt_activity_tabs_settings_close {
	float:right;
	background: url(<?php echo $vars['url']; ?>/mod/embed/images/close_button.gif) no-repeat center -1px;
}
#mt_activity_tabs_settings_header {
	height:10px;
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/div_up.png) no-repeat center -1px;
	background-color:white;
}
#mt_activity_tabs_settings_body {
	border:1px solid #cccccc;
	background-color:#eeeeee;
	padding:10px;
}
#mt_activity_tabs_settings_submit {
	margin-left:300px;
}

// override river icons
.river_object_event_calendar_create {
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/river_icon_calendar.png) no-repeat left -1px;
}
.river_object_event_calendar_update {
	background: url(<?php echo $vars['url']; ?>mod/mt_activity_tabs/_graphics/river_icon_calendar.png) no-repeat left -1px;
}

//
.usersettings_statistics th, .admin_statistics th {
	border-bottom:1px solid #CCCCCC;
	padding:2px 4px;
}
