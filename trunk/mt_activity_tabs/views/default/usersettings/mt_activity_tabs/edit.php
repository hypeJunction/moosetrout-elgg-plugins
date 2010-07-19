<?php
/**
 * User settings for mt_activity_tabs plugin
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

echo elgg_view('mt_activity_tabs/tab_settings');

// script to display block
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#mt_activity_tabs_usersettings').show();
});
</script>