<?php

	global $SESSION;
	
	// This page can only be run from within the Elgg framework
	if (!is_callable('elgg_view') || !isloggedin()) exit;
		
	// Get the name of the form field we need to inject into
	$internalname = get_input('internalname');
		
	// Echo the view
	echo elgg_view('mt_tinyurl/longurl', array(
							'internalname' => $internalname,
					   ));

?>