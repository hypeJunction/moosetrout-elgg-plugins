<?php

/**
 * Link that opens tinyurl facebox
 */
?>
<!-- open mt_tinyurl link -->
<?php
// grab pluginsetting
$pluginsettings = getpluginsettings('mt_tinyurl');
$facebox = $pluginsettings->mode;

$link = "<a id='mt_tinyurl_link' class=\"tinyurl_option\" href=\"{$vars['url']}pg/mt_tinyurl/longurl?internalname=note\" ";

// facebox or
if ($pluginsetting->mode == 'facebox') {
    $link .= 'rel=\"facebox\">';
} else if ($pluginsetting->mode == 'accordion') {
    //$link .= ' js=\"onclick=\'showhide()\';
}

$link .= '>' . elgg_echo('shortlink:insert') . "</a><br />";

echo($link);
?>
<script type='text/javascript'>
$("#mt_tinyurl_link").click(function () {
	$('#mt_tinyurl_form').slideToggle("slow");
	return false;
});
</script>
<div id='mt_tinyurl_form'>
<h1 class="linkModalTitle"><?php echo elgg_echo("shortlink:modaltitle"); ?></h1>
<div id='sectionLink'><script type="text/javascript">
function mt_tinyurl_getTinyURL(longURL, success) {
 
    var API = 'http://json-tinyurl.appspot.com/?url=',
        URL = API + encodeURIComponent(longURL) + '&callback=?';
 
	$.getJSON(URL, function(data){
    	success && success(data.tinyurl);
    });
}
	
function mt_tinyurl_sendTinyURL(entityname) {
 
    var link = $('input[name=link]').val();
    mt_tinyurl_getTinyURL(link, function(tinyurl){

    	// put tinyurl in form
    	$('textarea[name='+entityname+']').val($('textarea[name='+entityname+']').val() + ' ' + tinyurl);			
	}); 
}
</script>

<div id="linkFormText">
<p><label><?php echo elgg_echo("shortlink:link"); ?><br />
<?php

echo elgg_view("input/text", array(
									"internalname" => "link",
									"value" => $title,
));
?> </label></p>
<input type="button"
	value="<?php echo elgg_echo("shortlink:insert"); ?>"
	onclick="javascript:sendTinyURL('<?php echo $vars['internalname']; ?>');" />
</div>
</div>

</div>
<!-- close mt_tinyurl link -->
