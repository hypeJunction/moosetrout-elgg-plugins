<?php

/**
 * 
 */
?>

<p>
  <?php echo elgg_echo('mt_rewrite_river_urls:settings:enable'); ?>
  
  <select name="params[enable_string_rewriting]">
  <option value="true" <?php if ($vars['entity']->enable_string_rewriting == 'true') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
  <option value="false" <?php if (($vars['entity']->enable_string_rewriting == 'false') || (!isset($vars['entity']->enable_string_rewriting))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
  </select>

</p>

<p>
  <?php echo elgg_echo('mt_rewrite_river_urls:settings:oldurl'); ?>
  <?php echo elgg_view('input/text',array('internalname' => 'oldurl')); ?>

</p>

<p>
  <?php echo elgg_echo('mt_rewrite_river_urls:settings:newurl'); ?>
  <?php echo elgg_view('input/text',array('internalname' => 'newurl')); ?>

</p>