<?php

/**
 * mt_group_notifications clear_notications action
 * 
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */
		
// for admin only
admin_gatekeeper();

// action protection
action_gatekeeper();

// set context
set_context('admin');

// set title
$title = elgg_echo('mt_group_notifications:result');

// start body
$body = "Starting...<br/>\n";

// dryrun?
$dryrun = get_input('dryrun', 'true');
$body .= "Dryrun: $dryrun<br/>\n";

// grab all users
$users = elgg_get_entities(array (types => 'user', limit => 5000));
$num = count($users);
$body .= "Max number of users being fetched: 5000; number of users being processed: $num<br /><hr />\n";

if ($num == 5000) {
    $body .= "Please raise the limit in actions/set_notifications.php. Halting...";
} else {

    // iterate
    foreach($users as $user) {
        
        // guid
        $guid_one = $user->guid;
        
        // grab memberships for this user
        // returns false if no relationships found
        $relationships = get_entity_relationships($guid_one);
        
        if ($relationships != false) {
            
            // iterate
            foreach($relationships as $relationship) {
                
                // guid and rel
                $guid_two = $relationship->guid_two;
                $rel = $relationship->relationship;
                
                // if both notifyemail and notifysite are false, set
                // check_entity_relationship returns a relationship object or false
                $emailset = check_entity_relationship($guid_one, 'notifyemail', $guid_two);
                $siteset = check_entity_relationship($guid_one, 'notifysite', $guid_two);
                
                //
                if (true) {
    
                    // dryrun?
                    if ($dryrun == 0) {
                        if ($emailset) {
                            
                            $body .= elgg_echo('mt_group_notifications:clearnotifyemail') . "$guid_one; $guid_two<br />\n";
                            remove_entity_relationship($guid_one, 'notifyemail', $guid_two);
                            
                        }
                        if ($siteset) {
                            
                            $body .= elgg_echo('mt_group_notifications:clearnotifysite') . "$guid_one; $guid_two<br />\n";
                            remove_entity_relationship($guid_one, 'notifysite', $guid_two);
                            
                        }
                    } else if ($dryrun == 1) {
                        if ($emailset) {
                            
                            $body .= elgg_echo('mt_group_notifications:clearnotifyemail') . "$guid_one; $guid_two<br />\n";
                            
                        }
                        if ($siteset) {
                            
                            $body .= elgg_echo('mt_group_notifications:clearnotifysite') . "$guid_one; $guid_two<br />\n";
                            
                        }
                    } else {
                        $body .= elgg_echo('mt_group_notifications:dryrunparamerror') . $dryrun;
                    }
                } else {
                    if ($displayskipping == 1) {
                        $body .= elgg_echo('mt_group_notifications:skipping') . "$guid_one => $rel => $guid_two<br />\n";
                    }
                }
            }
        }
    }
    
    $body .= "Done.<br/>\n";
}
      

// wrap in contentwrapper div
//$body = elgg_view('page_elements/contentwrapper', array($body));

// body
$content = elgg_view_layout('two_column_left_sidebar', '', $body);
echo page_draw($title, $content);
