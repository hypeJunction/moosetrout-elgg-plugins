<?php


$english = array(
    'mt_longtext_video_filter:missinglib' => 'The mt_longtext_video_filter plugin requires Cash Costello\'s embedvideo plugin to be loaded (though not enabled); disabling.',
    'mt_longtext_video_filter:dep_test_title' => 'Plugin Dependency Test',
    'mt_longtext_video_filter:dependencyok' => 'Success! The embedvideo plugin is already loaded.',
    'mt_longtext_video_filter:dependencyfail' => 'ERROR: please load the embedvideo plugin (it does not need to be enabled).',
    'mt_longtext_video_filter:backlink' => 'Return to Tools Administration',
    
    'mt_longtext_video_filter:youtube' => 'Youtube',
	'mt_longtext_video_filter:bliptv' => 'Blip TV',
	'mt_longtext_video_filter:google' => 'Google Video',
	'mt_longtext_video_filter:vimeo' => 'Vimeo',
	'mt_longtext_video_filter:veoh' => 'Veoh',
	'mt_longtext_video_filter:dailymotion' => 'Daily Motion',
	'mt_longtext_video_filter:teachertube' => 'Teacher Tube',
	'mt_longtext_video_filter:metacafe' => 'Metacafe',

    'mt_longtext_video_filter:helplink' => 'How to embed youtube videos',
    'mt_longtext_video_filter:helpcontent' => '<p>This site supports embedding videos in any text area (blog, wiki page, etc) from the following video sharing sites:
    		<ul><li>youtube</li><li>google</li><li>vimeo</li><li>metacafe</li><li>veoh</li><li>dailymotion</li><li>blip.tv</li><li><s>teacher tube</s></li></ul></p>
    		<p>Simply cut and paste the appropriate video sharing link into your content as plain text, and this site will automatically convert the link to the necessary embed code when it displays the content to users.</p>
    		<p><h3>Example:</h3><div><img src="/mod/mt_longtext_video_filter/_graphics/sesame_screenshot_editor.png"/></div><p></p><h3>Is automatically converted to:</h3><div><img src="/mod/mt_longtext_video_filter/_graphics/sesame_screenshot_embed.png"></div></p>'

);

add_translation('en', $english);