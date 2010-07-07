<?php
/**
 * mt_errorlog settings page
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */
?>

<p>
  <?php echo elgg_echo('mt_errorlog:settings:path_to_errorlog'); ?>
  
  <?php echo elgg_view('input/text',array('internalname' => 'path_to_errorlog')); ?>
  

</p>