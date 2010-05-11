<?php

/**
 * Lang file for mt_group_notifications
 *
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */
$english = array (

    'mt_group_notifications:settings:enable_email_notifications' => 'Automatically set email notifications ON when a user joins a group',
    'mt_group_notifications:settings:enable_site_notifications' => 'Automatically set site notifications ON when a user joins a group',
    'mt_group_notifications:adminlink' => 'MT Group Notifications',
    'mt_group_notifications:title' => 'Set notifications for existing group members',
    'mt_group_notifications:explanation' => 'Submitting this form will set the group notify to "notifyemail" for all members of all groups that have not already set it to email or site for that membership.',
    'mt_group_notifications:dryrun' => 'Dry run?',
    'mt_group_notifications:defaultnotify' => 'Override notifications for existing group members: ',
    'mt_group_notifications:result' => 'Result',
    'mt_group_notifications:displayskipping' => 'Display relationships that are skipped?',
    'mt_group_notifications:skipping' => 'Skipping relationship: ',
    'mt_group_notifications:defaultnotifyparamerror' => 'Defaultnotify param should be email/site/both; received ',
    'mt_group_notifications:dryrunparamerror' => 'dryrun param should be true or false; received ',
    'mt_group_notifications:optionnotifyemail' => 'Email only',
    'mt_group_notifications:optionnotifysite' => 'Site only',
    'mt_group_notifications:optionnotifyboth' => 'Both email and site',
    'mt_group_notifications:addingnotifyemail' => 'Adding notifyemail relationship: ',
	'mt_group_notifications:addingnotifysite' => 'Adding notifysite relationship: ',
	'mt_group_notifications:addingnotifyboth' => 'Adding both notifyemail and notifysite relationship: '
);

add_translation('en', $english);