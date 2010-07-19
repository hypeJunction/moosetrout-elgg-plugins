<?php
/**
 * Plugin settings for mt_activity_tabs plugin
 */
?>
<p>
  <?php echo elgg_echo('mt_activity_tabs_settings:settings:disablefriends'); ?>
 
  <select name="params[enable_email_notifications]">
  <option value="true" <?php if ($vars['entity']->enable_disable_friends == 'true') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:yes')?></option>
  <option value="false" <?php if (($vars['entity']->enable_disable_friends == 'false') || (!isset($vars['entity']->enable_disable_friends))) echo " selected=\"selected\" "; ?>><?php echo elgg_echo('option:no')?></option>
  </select>

</p>