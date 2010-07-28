<?php

	/**
	 * Elgg embed CSS
	 * 
	 * @package tinyurl
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Evobilis <emmanuel@evobilis.com>
	 * @copyright Evobilis Ltd 2009
	 * @link http://www.evobilis.com/
	 */

?>

#mt_tinyurl_form {
	display:none;
	background-color:#EEEEEE;
	border: 1px solid #CCCCCC;
	padding: 10px;
}

#facebox {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 100;
	text-align: left;
}
#facebox .popup {
	position: relative;
}
#facebox .body {
	padding: 10px;
	background: white;
	width: 730px;
	-webkit-border-radius: 12px; 
	-moz-border-radius: 12px;
}
#facebox .loading {
	text-align: center;
	padding: 100px 10px 100px 10px;
}
#facebox .image {
	text-align: center;
}
#facebox .footer {
	float: right;
	width:22px;
	height:22px;
	margin:0;
	padding:0;
}
#facebox .footer img.close_image {
	background: url(<?php echo $vars['url']; ?>mod/embed/images/close_button.gif) no-repeat left top;
}
#facebox .footer img.close_image:hover {
	background: url(<?php echo $vars['url']; ?>mod/embed/images/close_button.gif) no-repeat left -31px;
}
#facebox .footer a {
	-moz-outline: none;
	outline: none;
}
#facebox_overlay {
	position: fixed;
	top: 0px;
	left: 0px;
	height:100%;
	width:100%;
}
.facebox_hide {
	z-index:-100;
}
.facebox_overlayBG {
	background-color: #000000;
	z-index: 99;
}

* html #facebox_overlay { /* ie6 hack */
	position: absolute;
	height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');
}

h1.linkModalTitle {
	color:#0054A7;
	font-size:1.35em;
	line-height:1.2em;
	margin:0 0 0 8px;
	padding:5px;
}

#linkFormText label {
	font-size:120%;
}

a.tinyurl_option {
	margin:0;
	float:right;
	display:block;
	text-align: right;
	font-size:1.0em;
	font-weight: normal;
}
label a.tinyurl_option {
	font-size:0.8em;
}