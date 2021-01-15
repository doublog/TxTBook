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

//$action_url = $_SERVER['PHP_SELF']."?user=$user&amp;l={$_GET['l']}&amp;t={$_GET['t']}&amp;a={$_GET['a']}";

function msgbox($message, $title = "") {
	global $cfg;
	global $lang;
	global $template_msgbox;
	
	$template_msgbox = str_replace("{CHARSET}", $lang['charset'], $template_msgbox);
	$template_msgbox = str_replace("{APPLICATION_NAME}", $cfg['applicationName'], $template_msgbox);
	$template_msgbox = str_replace("{VERSION}", $cfg['version'], $template_msgbox);
	$template_msgbox = str_replace("{BOOKNAME}", $cfg['bookName'], $template_msgbox);
	$template_msgbox = str_replace("{TITLE}", $title, $template_msgbox);
	$template_msgbox = str_replace("{MESSAGE}", $message, $template_msgbox);
	$template_msgbox = str_replace("{COPYRIGHT}", $cfg['copyright'], $template_msgbox);
	echo $template_msgbox;
}

function getReplyForm($timeId) {
	global $adminMode;
	global $lang;
	global $action_url;
	global $template_reply_form;
	$template_reply_form = str_replace("{REPLY}", $lang['reply'], $template_reply_form);
	$template_reply_form = str_replace("{NAME}", $adminMode ? $lang['admReply'] : "", $template_reply_form);
	$template_reply_form = str_replace("{ACTION_URL}", $action_url, $template_reply_form);
	$template_reply_form = str_replace("{TIMEID}", $timeId, $template_reply_form);
	return $template_reply_form;
}

function getDeleteForm($timeId) {
	global $action_url;
	global $template_delete_form;
	global $lang;
	$template_delete_form = str_replace("{DELETE}", $lang['delete'], $template_delete_form);
	$template_delete_form = str_replace("{ACTION_URL}", $action_url, $template_delete_form);
	$template_delete_form = str_replace("{TIMEID}", $timeId, $template_delete_form);
	return $template_delete_form;
}

function getLoginForm() {
	global $action_url;
	global $template_login_form;
	global $lang;
	$template_login_form = str_replace("{ADM_LOGIN}", $lang['admLogin'], $template_login_form);
	$template_login_form = str_replace("{ACTION_URL}", $action_url, $template_login_form);
	$template_login_form = str_replace("{TIMEID}", $timeId, $template_login_form);
	return $template_login_form;
}

function getNavigatorFormat($page, $totalPage) {
	global $action_url;
	global $lang;
	global $template_navigator_header;
	global $template_navigator_footer;
	global $template_navigator_page;
	global $template_navigator_current_page;
	
	if ($totalPage == 1) {	return "";	}
	
	$ppp = 10;		//pages per page!
	$ppCount = intval($totalPage / $ppp) + (($totalPage%$ppp != 0) ? 1 : 0);
	$currentPP = intval($page / $ppp) + (($page%$ppp != 0) ? 1 : 0);
	$pStart = $ppp  * ($currentPP - 1) + 1;
	$pEnd = (($pStart + $ppp - 1) > $totalPage) ? $totalPage : ($pStart + $ppp - 1);
	
	$str = str_replace("{CURRENT_PAGE}", $page, $template_navigator_header);
	$str = str_replace("{TOTAL_PAGES}", $totalPage, $str);
	
	if ($currentPP != 1) {
		$firstPageStr = str_replace("{PAGE}", "|<", $template_navigator_page);
		$str .= str_replace("{URL}", $action_url."&page=1", $firstPageStr);
		$previousPageStr = str_replace("{PAGE}", "<", $template_navigator_page);
		$str .= str_replace("{URL}", $action_url."&page=".($pStart-1), $previousPageStr);
	}
	for ($i = 1; $i <= ($pEnd - $pStart + 1); $i++) {
		$p = $i + $pStart - 1;
		if ($p == $page) {
			$str .= str_replace("{PAGE}", $p, $template_navigator_current_page);
		} else {
			$currentPageStr = str_replace("{PAGE}", $p, $template_navigator_page);
			$str .= str_replace("{URL}", $action_url."&page=$p", $currentPageStr);
		}
	}
	if ($ppCount > 1 && $currentPP != $ppCount) {
		$nextPageStr = str_replace("{PAGE}", ">", $template_navigator_page);
		$str .= str_replace("{URL}", $action_url."&page=".($pEnd+1), $nextPageStr);
		$lastPageStr = str_replace("{PAGE}", ">|", $template_navigator_page);
		$str .= str_replace("{URL}", $action_url."&page=$totalPage", $lastPageStr);
	}
	
	$str .= $template_navigator_footer;
	return $str;
	
	/*
	$str = "";
	for ($i = 1; $i <= $totalPage; $i++) {
		if ($i == $page) {
			$str .= " <b>[$i]</b>";
		} else {
			$str = $str." <a href=\"{$_SERVER['PHP_SELF']}?page=$i&amp;l={$_GET['l']}&amp;t={$_GET['t']}&amp;a={$_GET['a']}\">$i</a>";
		}
	}
	return sprintf($lang['jumpTo'], $str);
	*/
}

function getMessageBlockFormat($msg, $messageStart, $messageEnd) {
	global $cfg;
	global $adminMode;
	global $lang;
	global $template_message_block;
	global $template_message_block_header;
	global $template_message_block_footer;
	
	$str = "";
	for ($i = $messageStart; $i <= $messageEnd; $i++) {
		list($timeId, $name, $homepage, $message, $private, $email, $msn, $date, $avatar, $ip) = explode("|", stripslashes(str_replace("[CrLf]", "\n", $msg[$i])));
		$tmp = $template_message_block;
		$tmp = str_replace("{AVATAR}", $avatar, $tmp);
		$tmp = str_replace("{TIMEID}", $timeId, $tmp);
		$tmp = str_replace("{NAME}", $name, $tmp);
		$tmp = str_replace("{HOMEPAGE}", htmlspecialchars($homepage), $tmp);
		$tmp = str_replace("{EMAIL}", htmlspecialchars($email), $tmp);
		$tmp = str_replace("{MSN}", htmlspecialchars($msn), $tmp);
		$tmp = str_replace("{DATE}", $date, $tmp);
		$tmp = str_replace("{IP}", $ip, $tmp);
		$message = str_replace("[separator]", "|", filter($message));
		$tmp = str_replace("{MESSAGE}", (!$private || $adminMode) ? $message : "<font color=darkgray>{$lang['privateMessage']}</font>", $tmp);
		if (!$adminMode) {
			$tmp = preg_replace("/<!--IF LOGIN-->(.*?)<!--END IF-->/", "", $tmp);
		}
		$str .= $tmp;
	}
	
	return $template_message_block_header.$str.$template_message_block_footer;
}

function getSignBlockFormat() {
	global $action_url;
	global $template_sign_block;
	global $lang;
	$template_sign_block = str_replace("{SIGNBOOK}", $lang['sign'], $template_sign_block);
	$template_sign_block = str_replace("{ACTION_URL}", $action_url, $template_sign_block);
	$template_sign_block = str_replace("{AVATARS}", getAvatarFormat(), $template_sign_block);
	return $template_sign_block;
}

function getAvatarFormat() {
	global $cfg;
	global $template_avatar;
	$str = "";
	for ($i = 0; $i < $cfg['avatarPageAmount']; $i++) {
		if ($i <= 9) $i = "0".$i;
		$str .= sprintf($template_avatar, $i, ($i == 0 ? "checked" : ""), $cfg['avatarSet'], $cfg['avatarSet'], $i);
	}
	return $str;
}

function getSearchBlockFormat() {
	global $action_url;
	global $template_search_block;
	$template_search_block = str_replace("{ACTION_URL}", $action_url, $template_search_block);
	return $template_search_block;
}

$template_navigator_header = <<<EOT
	    <table cellspacing="1" cellpadding="3" class="tableborder">
	    	<tr bgcolor="#F8F8F8" class="smalltxt">
	    	<td class="header">&nbsp;{CURRENT_PAGE}/{TOTAL_PAGES}&nbsp;</td>
EOT;

$template_navigator_footer = <<<EOT
	    	</tr>
	    </table>
EOT;

$template_navigator_page = <<<EOT
	    	<td>&nbsp;<a href="{URL}">{PAGE}</a>&nbsp;</td>
EOT;

$template_navigator_current_page = <<<EOT
	    	<td bgcolor="#FFFFFF">&nbsp;<u><b>{PAGE}</b></u>&nbsp;</td>
EOT;

$template_signbook = <<<EOT
		<a href="#signArea">{$lang['sign']}</a>
EOT;

$template_admin_login = <<<EOT
		<a href="$action_url&amp;act=login">{$lang['admLogin']}</a>
EOT;

$template_message_block_header = <<<EOT
		<!--table border="0" cellPadding="3" cellSpacing="1" width="98%" align="center" bgcolor="#000000"-->
EOT;

$template_message_block_footer = <<<EOT
		<!--/table-->
EOT;

$template_message_block = <<<EOT
	    <tr><td class="singleborder" colspan="2">&nbsp;</td></tr>
		<tr bgcolor="#FFFFFF">
		  <td height="100%"width="21%" valign="top">
		    <span class="bold">{NAME}</span><br><br>
		    <center><img src="avatar/{$cfg['avatarSet']}/{$cfg['avatarSet']}{AVATAR}.gif" alt="avatar"></center>
		  </td>
		  <td width="79%" valign="top">
		    {MESSAGE}
		  </td>
		</tr>

		<tr bgcolor="#F8F8F8">
		  <td valign="middle">{DATE}</td>
		  <td valign="bottom">
		    <table width="100%" cellspacing="0" cellpadding="0">
		      <tr>
		        <td>&nbsp;
					<a href="mailto:{EMAIL}" title="{$lang['sendEmail']}"> <img border="0" src="images/mail.gif" alt="mail" align="middle">&nbsp;{$lang['email']}</a>&nbsp;
					<a href="{HOMEPAGE}" target=_blank title="{$lang['visitHomepage']}"> <img border="0" src="images/home.gif" alt="home" align="middle">&nbsp;{$lang['homepage']}</a>&nbsp; 
					<img src="images/msn.gif" alt="{$lang['vistorMsn']}" align="middle">&nbsp;MSN&nbsp; 
					<img src="images/ip.gif" border="0" alt="{$lang['visitorIP']}" align="middle">&nbsp;IP&nbsp;
					<a href="{$action_url}&amp;act=reply&amp;id={TIMEID}" title="{$lang['reply']}"> <img border="0" src="images/reply.gif" alt="reply" align="middle">&nbsp;{$lang['reply']}</a> &nbsp; 
					<!--IF LOGIN--><a href="{$action_url}&act=delete&id={TIMEID}" title="{$lang['delete']}"> <img border="0" src="images/del.gif" alt"delete" align="middle">&nbsp;{$lang['delete']}</a><!--END IF-->
				</td>
				<td align="right">
					<a href="###" onclick="scroll(0,0)"><img src="themes/discuz/images/top.gif" alt="top" border="0" align="middle"></a>
				</td>
			  </tr>
			</table>
		  </td>
		</tr>
EOT;

$template_sign_block = <<<EOT
	  <a name="signArea"></a>
	  <form method="post" action="{ACTION_URL}">
	  <input type="hidden" name="act" value="add">
	  <table cellspacing="1" cellpadding="4" width="99%" align="center" class="tableborder">
        <tr><td colspan="4" class="header">{SIGNBOOK}</td></tr>
		<tr bgcolor="#FFFFFF">
		  <td nowrap bgcolor="#F8F8F8" align="right" width="10%"><font color="red"><b>*</b></font> {$lang['signCaptcha']}</td>
		  <td colspan="3"><input type="text" id="captcha" name="captcha" size="6" maxlength="4">&nbsp;<img id='image_captcha' src="include/php-captcha.image.php" alt="captcha" align="middle" border="0" onclick="newCaptcha()" class="hand"></td>
		</tr>
        <tr bgcolor="#FFFFFF">
		  <td width="10%" align="right" bgcolor="#F8F8F8" nowrap><font color="red"><b>*</b></font> {$lang['signName']}</td>
		  <td width="40%">
		  	<input type="text" maxlength="20" id="name" name="name" style="width:100%">
		  </td>
		  <td width="10%" align="right" bgcolor="#F8F8F8" nowrap>{$lang['signEmail']}</td>
		  <td width="40%"> 
		  	<input maxlength="60" type="text" name="email" style="width:100%">
		  </td>
        </tr>
        <tr bgcolor="#FFFFFF">
		  <td align="right" bgcolor="#F8F8F8" nowrap width="10%">{$lang['signMsn']}</td>
		  <td width="40%"> 
		  	<input maxlength="40" type="text" name="msn" size="32" style="width: 100%">
		  </td>
		  <td width="10%" bgcolor="#F8F8F8" align="right" nowrap>{$lang['signHomepage']}</td>
		  <td width="40%" height="12">
		  	<input type="text" name="homepage" size="35" style="width: 100%">
		  </td>
        </tr>
		<tr bgcolor="#FFFFFF">
		  <td nowrap bgcolor="#F8F8F8" align="right" width="10%">{$lang['signPrivate']}</td>
		  <td nowrap colspan="3">
		  	<input type="radio" name="private" value="0" checked>{$lang['signPrivateOff']}
		  	<input type="radio" name="private" value="1">{$lang['signPrivateOn']}
		  </td>
		</tr>
		<tr bgcolor="#FFFFFF">
		  <td nowrap bgcolor="#F8F8F8" align="right" width="10%">{$lang['signAvatar']}</td>
		  <td nowrap align="center" colspan="3" id="ChoiceImage">
		  	{AVATARS} <input value=" >> " type="button" onClick="nextImagePage()" style="font-family: MS Gothic; font-weight: bold; font-size: 10">
		  </td>
		</tr>
        <tr bgcolor="#FFFFFF">
		  <td align="right" bgcolor="#F8F8F8" nowrap><font color="red"><b>*</b></font> {$lang['signMessage']}</td>
		  <td align="left" colspan="3"> 
		  	<textarea id="text" name="message" rows="8" cols="80" style="width: 100%"></textarea>
		  	<input name="Submit" type="submit" value="{$lang['buttonSign']}" maxlength="1000" onClick="return checkData();">&nbsp;&nbsp;
		  	<input name="Reset" type="reset" value="{$lang['buttonReset']}">
		  </td>
        </tr>
	  </table>
	  </form>
EOT;

$template_avatar = <<<EOT
							<input type="radio" name="avatar" value="%s" %s><img src="avatar/%s/%s%s.gif" alt="avatar">&nbsp;&nbsp;
EOT;

$template_search_block = <<<EOT
	  <br>
	  <table cellspacing="1" cellpadding="2" align="center" class="tableborder">
	    <tr><td colspan="4" class="header">{$lang['buttonSearch']}</td></tr>
		<tr bgcolor="#F8F8F8">
		  <td align="center">
		<form method="post" action="{ACTION_URL}">
		<input type="hidden" name="act" value="search">
		    &nbsp;&nbsp;
			{$lang['searchKeyword']}<input name="keyword" size="12" maxlength="20" style="background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4">&nbsp;&nbsp;
    		<input name="submit" type="submit" value="{$lang['buttonSearch']}">
		    &nbsp;&nbsp;
		    </form>
		  </td>
		</tr>
	  </table>
	  <br>
EOT;

$template_reply_form = <<<EOT
	  <form method="post" action="{ACTION_URL}">
	  <input type="hidden" name="act" value="reply">
	  <table cellspacing="1" cellpadding="4" align="center" class="tableborder" width="400">
	    <tr><td class="header">{REPLY}</td></tr>
		<tr bgcolor="#F8F8F8">
			<td align="center" nowrap><br>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="right" nowrap>{$lang['signCaptcha']}</td>
					<td>
						<input type="text" name="captcha" class="fielder" size="6" maxlength="4">&nbsp;
						<img id='image_captcha' src="include/php-captcha.image.php" alt="captcha" align="middle" border="0" onclick="newCaptcha()" class="hand">
					</td>
				</tr>
				<tr> 
					<td align="right" nowrap>{$lang['signName']}</td>
					<td> 
						<input type="text" maxlength="20" value="{NAME}" id="name" name="name">
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="right" nowrap>{$lang['replyMessage']}</td>
					<td>
						<textarea name="reply" cols="50" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td align="right" nowrap>{$lang['pullUpMessage']}</td>
					<td>
						<input type="checkbox" name="pull" value="1" checked>
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap colspan="2"> 
						<input type="submit" name="submit" value="{$lang['buttonReply']}">
						<input type="reset"  name="cancel" value="{$lang['buttonReset']}">
						<br><br>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	  </table>
	  </form>
EOT;

$template_delete_form = <<<EOT
	  <form method="post" action="{ACTION_URL}">
	  <input type="hidden" name="act" value="delete">
	  <table cellspacing="1" cellpadding="4" align="center" class="tableborder" width="400">
	    <tr><td class="header">{DELETE}</td></tr>
		<tr bgcolor="#F8F8F8">
			<td align="center" nowrap><br>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="center" nowrap>{$lang['deleteConfirm']}<p>
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap> 
						<input type="submit" name="submit" value="{$lang['buttonDelete']}">
						<input type="button" name="cancel" value="{$lang['buttonCancel']}" onClick="javascript:history.back();">
					</td>
				</tr>
			</table>
			<br>
			</td>
		</tr>
	  </table>
	  </form>
EOT;

$template_login_form = <<<EOT
	  <form method="post" action="{ACTION_URL}">
	  <input type="hidden" name="act" value="login">
	  <table cellspacing="1" cellpadding="4" align="center" class="tableborder" width="300">
	    <tr><td class="header">{ADM_LOGIN}</td></tr>
		<tr bgcolor="#F8F8F8">
			<td align="center" nowrap><br>
			{$lang['enterPassword']}
			<input type="password" name="password" size="20">
			<input type="hidden" name="id" value="{TIMEID}">
			<br><br><br>
			<input type="submit" name="submit" value="{$lang['buttonLogin']}">
			<input type="button" name="cancel" value="{$lang['buttonCancel']}"onClick="javascript:history.back();">
			<br><br>
			</td>
		</tr>
	  </table>
	  </form>
EOT;

$template_msgbox = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}" />
<link rel="stylesheet" href="themes/discuz/style.css" type="text/css">
<title>{BOOKNAME} - {TITLE} (Powered by {APPLICATION_NAME} {VERSION})</title>
<script>
function newCaptcha() {
	var now=new Date();
	document.getElementById('image_captcha').src='include/php-captcha.image.php?'+now.getTime();
}
</script>
</head>

<body leftmargin="0" rightmargin="0">

<table bgcolor="#FFFFFF" width="98%" height="100%" cellpadding="0" cellspacing="0" border="0" align="center">
  <tr>
    <td width="100%" height="100%" align="center">{MESSAGE}</td>
  </tr>
  <tr>
	<td align="center">
  	  <table>
  		<tr>
  		  <td class="smalltxt" align="center">
  		    {COPYRIGHT} <a href="https://www.doublog.com/" target=_blank class="smalltxt">Eruo Studio</a><br>
  		    <a href="http://www.discuz.net/" target=_discuz>This theme is a modification of the Discuz! Board.</a>
  		  </td>
  		</tr>
  	  </table>
    </td>
  </tr>
</table>

</body>
</html>
EOT;
?>