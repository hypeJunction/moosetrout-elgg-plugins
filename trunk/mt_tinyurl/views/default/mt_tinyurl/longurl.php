<?php

/**
 * Ajax endpoint that returns a longurl form
 */

// load elgg


// make sure we are logged in, etc etc
gatekeeper();

?>

<h1 class="linkModalTitle"><?php echo elgg_echo("shortlink:modaltitle"); ?></h1>
<div id='sectionLink'>
<script type="text/javascript">
function getTinyURL(longURL, success) {
 
    var API = 'http://json-tinyurl.appspot.com/?url=',
        URL = API + encodeURIComponent(longURL) + '&callback=?';
 
	$.getJSON(URL, function(data){
    	success && success(data.tinyurl);
    });
}
	
function sendTinyURL(entityname) {
 
    var link = $('input[name=link]').val();
	getTinyURL(link, function(tinyurl){
    // Do something with tinyurl:
    $('textarea[name='+entityname+']').val($('textarea[name='+entityname+']').val() + ' ' + tinyurl);			
	$.facebox.close();
	}); 
}
</script>

<div id="linkFormText">
		<p>
			<label><?php echo elgg_echo("shortlink:link"); ?><br />
			<?php

				echo elgg_view("input/text", array(
									"internalname" => "link",
									"value" => $title,
													));	
			?>
			</label>
		</p>
		<input type="button" value="<?php echo elgg_echo("shortlink:insert"); ?>" onclick="javascript:sendTinyURL('<?php echo $vars['internalname']; ?>');" />
</div>
</div>