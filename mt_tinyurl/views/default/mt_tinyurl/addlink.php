<?php
echo("<!-- open mt_tinyurl link -->");
echo("<a class=\"tinyurl_option\" href=\"{$vars['url']}pg/mt_tinyurl/longurl?internalname=note\" rel=\"facebox\">" . elgg_echo('shortlink:insert') . "</a><br />");
echo("<!-- close mt_tinyurl link -->");