<?php

/**
 * Link that opens tinyurl facebox
 */
?>
<!-- open mt_tinyurl link -->
<?php
echo("<a class=\"tinyurl_option\" href=\"{$vars['url']}pg/mt_tinyurl/longurl?internalname=note\" rel=\"facebox\">" . elgg_echo('shortlink:insert') . "</a><br />");
?>
<!-- close mt_tinyurl link -->