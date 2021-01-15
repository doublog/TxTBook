<?php
// ------------------------------------------------------ //
// TxTBook 1.0                                            //
// https://doublog.com/                                   //
// Project Leader: Jack Z <im@doublog.com>                //
// ------------------------------------------------------ //
// Copyright (C) 2021 Eruo Studio                         //
// https://book.doublog.com/                              //
// ------------------------------------------------------ //
// This program is free software; you can redistribute it //
// and/or modify it under the terms of the GNU General    //
// Public License as published by the Free Software       //
// Foundation; either version 2 of the License, or (at    //
// your option) any later version.                        //
// ------------------------------------------------------ //
// Langeuage Pack: English                                //
// Translator: Jack Z <im@doublog.com>                    //
// Homepage: https://www.doublog.com/                     //
// ------------------------------------------------------ //

function removeQuotes($content) {
	if (is_array($content)) {
		foreach ($content as $key=>$value) {
			$content[$key] = stripslashes($value);
		}
	} else {
		stripslashes(trim($content));
	}
}

function formatQuotes($content) {
	if (!get_magic_quotes_gpc()) {
		if (is_array($content)) {
			foreach ($content as $key=>$value) {
				$content[$key] = addslashes($value);
			}
		} else {
			addslashes(trim($content));
		}
	}
	return $content;
}

function formatEntries($content) {
	if (is_array($content)) {
		foreach ($content as $key=>$value) {
			$content[$key] = formatEntries($value);
		}
	} else if ($content) {
		$content = trim($content);
		$content = xss_free($content);		// Added in version 1.10, to avoid XSS attack.
		$content = str_replace("|", "[separator]", $content);
		$content = str_replace("\r", "", $content);
		$content = str_replace("\t", "", $content);
		$content = str_replace("\n", "[CrLf]", $content);
		$content = str_replace("  ", " ", $content);
	}
	return $content;
}

function xss_free($content) {
	if (is_array($content)) {
		foreach ($content as $key=>$value) {
			$content[$key] = xss_free($value);
		}
	} else if ($content) {
		$content =  preg_replace("/>([^<]*)<([^>]*) on([^=]*)=([^>]*)>/", ">\\1&lt;\\2 on\\3=\\4&gt;", $content);
/*
		$content =  preg_replace(">([^<]*)<([^>]*) onfocus([^=]*)=([^>]*)>", ">\\1&lt;\\2 onfocus\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onblur([^=]*)=([^>]*)>", ">\\1&lt;\\2 onblur\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) oncontextmenu([^=]*)=([^>]*)>", ">\\1&lt;\\2 oncontextmenu\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onload([^=]*)=([^>]*)>", ">\\1&lt;\\2 onload\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onresize([^=]*)=([^>]*)>", ">\\1&lt;\\2 onresize\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onscroll([^=]*)=([^>]*)>", ">\\1&lt;\\2 onscroll\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onunload([^=]*)=([^>]*)>", ">\\1&lt;\\2 onunload\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onclick([^=]*)=([^>]*)>", ">\\1&lt;\\2 onclick\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) ondblclick([^=]*)=([^>]*)>", ">\\1&lt;\\2 ondblclick\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmousedown([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmousedown\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmouseup([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmouseup\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmouseenter([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmouseenter\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmouseleave([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmouseleave\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmousemove([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmousemove\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmouseover([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmouseover\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onmouseout([^=]*)=([^>]*)>", ">\\1&lt;\\2 onmouseout\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onchange([^=]*)=([^>]*)>", ">\\1&lt;\\2 onchange\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onreset([^=]*)=([^>]*)>", ">\\1&lt;\\2 onreset\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onselect([^=]*)=([^>]*)>", ">\\1&lt;\\2 onselect\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onsubmit([^=]*)=([^>]*)>", ">\\1&lt;\\2 onsubmit\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onkeydown([^=]*)=([^>]*)>", ">\\1&lt;\\2 onkeydown\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onkeypress([^=]*)=([^>]*)>", ">\\1&lt;\\2 onkeypress\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onkeyup([^=]*)=([^>]*)>", ">\\1&lt;\\2 onkeyup\\3=\\4&gt;", $content);
		$content =  preg_replace(">([^<]*)<([^>]*) onerror([^=]*)=([^>]*)>", ">\\1&lt;\\2 onerror\\3=\\4&gt;", $content);
*/
		$content =  preg_replace("(<meta([^>]*)>)", "&lt;meta&gt;", $content);
		$content =  preg_replace("(<\/meta[^>]*>)", "&lt;/meta&gt;", $content);
		$content =  preg_replace("(<script([^>]*)>)", "&lt;script&gt;", $content);
		$content =  preg_replace("(<\/script[^>]*>)", "&lt;/script&gt;", $content);
		$content =  preg_replace("(<object[^>]*>)", "&lt;object&gt;", $content);
		$content =  preg_replace("(<\/object[^>]*>)", "&lt;/object&gt;", $content);
		$content =  preg_replace("(<applet[^>]*>)", "&lt;applet&gt;", $content);
		$content =  preg_replace("(<\/applet[^>]*>)", "&lt;/applet&gt;", $content);
		$content =  preg_replace("(<embed[^>]*>)", "&lt;embed&gt;", $content);
		$content =  preg_replace("(<\/embed[^>]*>)", "&lt;/embed&gt;", $content);
		$content =  preg_replace("(<form[^>]*>)", "&lt;form&gt;", $content);
		$content =  preg_replace("(<\/form[^>]*>)", "&lt;/form&gt;", $content);
	}
	return $content;
}

function avoidLastSlash($str) {
	if (substr($str, -1).' ' == '\ ') {
		$str .= ' ';
	}
	return $str;
}

function filter($text) {
	$text =  preg_replace("<(xmp)>", "&lt;\\1&gt;", $text);
	return $text;
}

?>