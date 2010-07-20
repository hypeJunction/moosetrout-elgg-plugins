<?php
/**
 * Plugin settings for mt_tinyurl plugin
 */
?>
<p>
  <?php echo elgg_echo('mt_tinyurl:settings:mode'); ?>
 
  <select name="params[mode]">
  <option value="facebox" <?php if ($vars['entity']->mode == 'facebox') echo " selected=\"selected\" "; ?>><?php echo elgg_echo('mt_tinyurl:settings:facebox')?></option>
  <option value="accordion" <?php if (($vars['entity']->mode == 'accordion') || (!isset($vars['entity']->mode))) echo " selected=\"selected\" "; ?>><?php echo elgg_echo('mt_tinyurl:settings:accordion')?></option>
  </select>

</p>