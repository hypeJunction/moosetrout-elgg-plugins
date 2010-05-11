<?php

/**
 * Profile blog widget view
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */
		
//get the num of posts the user want to display
$num = $vars['entity']->num_display;

//if no number has been set, default to 4
if(!$num) {
    $num = 5;
}

//grab the user's blog posts
$pageowner_guid = page_owner();
$posts = get_entities('object', 'blog', $pageowner_guid, "", $num, 0, false);

// if posts exist, display, otherwise print message
if($posts){

    // iterate through posts
    foreach($posts as $post){
         
        // use custom blog view for this widget so easy to post-process
        $post->view = 'au_blog_widget/blog';
        
        echo elgg_view_entity($post);

    }
} else {
    echo elgg_echo('au_blog_widget:noposts');
}