<?php
/**
 * au_group_notification settings page
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */
?>

<p>
  <?php echo elgg_echo('au_group_notifications:settings:enable_email_notifications'); ?>
 
  <select name="params[enable_email_notifications]">
  <option value="true" <?php if ($vars['entity']->enable_email_notifications == 'true') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
  <option value="false" <?php if (($vars['entity']->enable_email_notifications == 'false') || (!isset($vars['entity']->enable_email_notifications))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
  </select>

</p>

<p>
  <?php echo elgg_echo('au_group_notifications:settings:enable_site_notifications'); ?>
 
  <select name="params[enable_site_notifications]">
  <option value="true" <?php if ($vars['entity']->enable_site_notifications == 'true') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
  <option value="false" <?php if (($vars['entity']->enable_site_notifications == 'false') || (!isset($vars['entity']->enable_email_notifications))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
  </select>

</p>
