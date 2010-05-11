<?php

/**
 * simple wrapper around object/blog view
 * so filter only applies to this namespace
 * without affecting *all* object/blog views
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// set view back to use standard view
// NB: do not set to 'object/blog'; this
// disables comments being displayed
//$vars['entity']->view = 'object/blog';

$guid = $vars['entity']->guid;
remove_metadata($guid, 'view');

// now view standard entity view
echo elgg_view_entity($vars['entity']);