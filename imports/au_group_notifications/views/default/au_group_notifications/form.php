<?php

/**
 * Script to set notifications for existing memberships
 *
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */

echo elgg_view_title(elgg_echo('au_group_notifications:title'));

?>

<div class="contentWrapper">

<?php

$form_body = "<p>" . elgg_echo('au_group_notifications:explanation') . "</p>";

// radio buttons for dryrun
$dryrun_flag = 1;
$form_body .= elgg_echo('au_group_notifications:dryrun');
$form_body .= elgg_view('input/radio', array('label' => elgg_echo('au_group_notifications:dryrun'),
											'value' => $dryrun_flag,
            								'internalname' => 'dryrun',
            								'options' => array(elgg_echo('option:yes') => 1,
                                                                elgg_echo('option:no') => 0)));
// radio buttons for displayskipping
$displayskipping_flag = 0;
$form_body .= elgg_echo('au_group_notifications:displayskipping');
$form_body .= elgg_view('input/radio', array('label' => elgg_echo('au_group_notifications:displayskipping'),
											'value' => $displayskipping_flag,
            								'internalname' => 'displayskipping',
            								'options' => array(elgg_echo('option:yes') => 1,
                                                                elgg_echo('option:no') => 0)));
                                                                
// radio buttons for email/site/both
$form_body .= elgg_view('input/radio', array('label' => elgg_echo('au_group_notifications:defaultnotify'),
											'value' => 'email',
            								'internalname' => 'defaultnotify',
            								'options' => array(elgg_echo('au_group_notifications:optionnotifyemail') => 'email',
                                                                elgg_echo('au_group_notifications:optionnotifysite') => 'site',
                                                                elgg_echo('au_group_notifications:optionnotifyboth') => 'both')));
                                                                                                                                
$form_body .= elgg_view('input/submit', array('internalname' => 'submit',
                                                'value' => elgg_echo('submit')));



	echo elgg_view('input/form',
            		array(
            			'action' => $vars['url'] . 'action/au_group_notifications/set_notifications',
            			'method' => 'post',
            			'body' => $form_body
            		)
	);

?>

</div>