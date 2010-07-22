<?php

/**
 * Displays a large amount of text, with new lines converted to line breaks
 * This version also substitutes embed tags for
 * video sharing websites using code from the embedvideo plugin.
 *
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/lib/mt_longtext_video_filter.php');

// this is how the ususal input/longtext view works:
//echo autop(parse_urls(filter_tags($vars['value'])));

echo autop(mt_parse_embed_urls(filter_tags($vars['value'])));