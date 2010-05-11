<?php

/**
 * Plugin that provides a simple widget with the user's blog posts
 * This widget is only available on their profile
 *
 * @author Brian Jorgensen (brian@moosetrout.com)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */


// Make sure the initialisation function is called on initialisation
register_elgg_event_handler('init','system','au_blog_widget_init');

/**
 * Standard Elgg plugin init function
 *
 */
function au_blog_widget_init() {

    // register widget
    add_widget_type('au_blog_widget', elgg_echo('au_blog_widget:title'), elgg_echo('au_blog_widget:description'), 'profile');

    // Register our post processing hook
    register_plugin_hook('display', 'view', 'blog_image_filter');

}

/**
 * elgg image filter: does simple search and replace for size=large
 */

function blog_image_filter($hook, $entity_type, $returnvalue, $params) {
    
    // define views we want to rewrite image URLs for so we don't have to process *every* object/blog view
    $blog_image_filter_views = array('au_blog_widget/blog');

    $view = $params['view'];

    // apply filter 
    if (($view) && (in_array($view, $blog_image_filter_views))) {
        
        // Search for 'size=large' and replace with 'size=small'
        $returnvalue = preg_replace('/(thumbnail\.php\?file_guid\=)(\d+)(\&|\&amp;)(size=large)/', "$1$2&size=small", $returnvalue);

    }
    
    return $returnvalue;
}