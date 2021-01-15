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
	$template_reply_form = str_replace("{NAME}", $adminMode ? $lang['admReply'] : "", $template_reply_form);
	$template_reply_form = str_replace("{ACTION_URL}", $action_url, $template_reply_form);
	$template_reply_form = str_replace("{TIMEID}", $timeId, $template_reply_form);
	return $template_reply_form;
}

function getDeleteForm($timeId) {
	global $action_url;
	global $template_delete_form;
	$template_delete_form = str_replace("{ACTION_URL}", $action_url, $template_delete_form);
	$template_delete_form = str_replace("{TIMEID}", $timeId, $template_delete_form);
	return $template_delete_form;
}

function getLoginForm() {
	global $action_url;
	global $template_login_form;
	$template_login_form = str_replace("{ACTION_URL}", $action_url, $template_login_form);
	$template_login_form = str_replace("{TIMEID}", $timeId, $template_login_form);
	return $template_login_form;
}

function getNavigatorFormat($page, $totalPage) {
	global $action_url;
	global $lang;
	$str = "";
	for ($i = 1; $i <= $totalPage; $i++) {
		if ($i == $page) {
			$str .= " <b>[$i]</b>";
		} else {
			$str = $str." <a href=\"$action_url&page=$i\">$i</a>";
		}
	}
	//return sprintf($lang['jumpTo'], $str);
	return $str;
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

$template_signbook = <<<EOT
		<a href="javascript:dispadd();" onmouseover="popup('{$lang['sign']}!!','#ffffcc')" onmouseout="kill();">{$lang['sign']}</a>
EOT;

$template_admin_login = <<<EOT
		<a href="$action_url&amp;act=login" onmouseover="popup('{$lang['admLogin']}!!','#ffffcc')" onmouseout="kill();">{$lang['admLogin']}</a>
EOT;

$template_message_block_header = <<<EOT
<table class="m_tb2" cellpadding="4" cellspacing="1">
 <tr>
  <th class="thl">Guest</th>
  <th class="thr">Message</th>
 </tr>
EOT;

$template_message_block_footer = <<<EOT
</table>
EOT;

$template_message_block = <<<EOT
 <tr>
  <td class="tdl">
  	<p align="center">
  	<img src="avatar/{$cfg['avatarSet']}/{$cfg['avatarSet']}{AVATAR}.gif" alt="avatar"><br>
  	<b>{NAME}</b></p>
  	<a href="mailto:{EMAIL}" title="{$lang['sendEmail']}"> <img border="0" src="images/mail.gif" alt="mail" align="middle">&nbsp;{$lang['email']}</a><br>
  	<a href="{HOMEPAGE}" target=_blank title="{$lang['visitHomepage']}"> <img border="0" src="images/home.gif" alt="home" align="middle">&nbsp;{$lang['homepage']}</a><br>
  	<img src="images/msn.gif" alt="{$lang['vistorMsn']}" align="middle"> MSN<br>
		<img src="images/ip.gif" border="0" alt="{$lang['visitorIP']}" align="middle"> IP
  </td>
  <td class="tdr">
  	<table class="tb100" cellpadding="0" cellspacing="0">
  		<tr>
  			<td><font size="1"><img src="images/sign.gif" alt="sign" align="middle"> {$lang['posted']}  {DATE}</font></td>
  			<td align="right">
  				<a href="{$action_url}&amp;act=reply&amp;id={TIMEID}" title="{$lang['reply']}"> <img border="0" src="images/reply.gif" alt="reply" align="middle">&nbsp;<font size="1">{$lang['reply']}</font></a>
  				<!--IF LOGIN--><a href="{$action_url}&amp;act=delete&amp;id={TIMEID}" title="{$lang['delete']}"> <img border="0" src="images/del.gif" alt="delete" align="center">&nbsp;<font size="1">{$lang['delete']}</font></a><!--END IF-->
  			</td>
  		</tr>
  	</table>
  	<hr>
  	{MESSAGE}<br>
  </td>
 </tr>
EOT;

$template_sign_block = <<<EOT
<form method="post" action="{ACTION_URL}">
 <input type="hidden" name="act" value="add">
 <table class="f_tb" cellpadding="3" cellspacing="0">
  <tr>
   <td colspan="2" class="f_th1" id="floater_handle">:: {$lang['sign']} ::</td>
   <th class="f_th2"><input type="button" onclick="dispadd();" class="f_close"></th>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/user.gif" alt="user"> <b>{$lang['signName']}</b></td>
   <td><input type="text" size="25" name="name" class="fielder" ></td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/mail.gif" alt="mail"> {$lang['signEmail']}</td>
   <td><input type="text" size="25" name="email" class="fielder"></td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/msn.gif" alt="{$lang['vistorMsn']}"> {$lang['signMsn']}</td>
   <td><input type="text" size="25" name="msn" class="fielder">&nbsp;</td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/home.gif" alt="home"> {$lang['signHomepage']}</td>
   <td><input type="text" size="25" name="homepage" class="fielder">&nbsp;</td>
  </tr>
  <tr>
   <td valign="middle" nowrap>&nbsp;<img src="images/sign.gif" alt="sign"> <b>{$lang['signMessage']}</b><br><br>&nbsp; 
   <td colspan="2">
   	<table border="1" width="99%" class="outerborder" cellspacing="0">
			<tr>
				<td class="innerborder"><textarea id="text" name="message" rows="8" cols="80" class="fielder" style="width: 100%"></textarea></td>
			</tr>
		</table>
   </td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/user.gif" alt="user"> {$lang['signPrivate']}</td>
   <td nowrap>
			<input type="radio" name="private" value="0" checked>{$lang['signPrivateOff']}
			<input type="radio" name="private" value="1">{$lang['signPrivateOn']}
	 </td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp;<img src="images/user.gif" alt="user"> {$lang['signAvatar']}</td>
   <td nowrap align="center" id="ChoiceImage">
			{AVATARS} <input value=">>" style="width: 25" class="submitter" type="button" onClick="nextImagePage()">
	 </td>
  </tr>
  <tr>
   <td align="right" nowrap>&nbsp; <b>{$lang['signCaptcha']}</b></td>
   <td><input type="text" id="captcha" name="captcha" class="fielder" size="6" maxlength="4">&nbsp;<img id='image_captcha' src="include/php-captcha.image.php" alt="captcha" align="middle" border="0" onclick="newCaptcha()" class="hand"></td>
  </tr>
  <tr>
   <td>&nbsp;</td>
   <td colspan="3">
			<input name="Submit" class="submitter" type="submit" value="{$lang['buttonSign']}" maxlength="1000" onClick="return checkData();">&nbsp;&nbsp;
			<input name="Reset" class="submitter" type="reset" value="{$lang['buttonReset']}">
			<br>
			<br>
   </td>
  </tr>
 </table>
</form>
EOT;

$template_avatar = <<<EOT
							<input type="radio" name="avatar" value="%s" %s><img src="avatar/%s/%s%s.gif" alt="avatar">&nbsp;&nbsp;
EOT;

$template_search_block = <<<EOT
		<table class="search" cellspacing="1" cellpadding="2">
			<tr>
			<td class="td_head">
				<form method="post" action="{ACTION_URL}">
				<input type="hidden" name="act" value="search">
					{$lang['searchKeyword']}<input class="fielder" name="keyword" size="12" maxlength="20" >&nbsp;&nbsp;
		    		<input class="submitter" name="submit" type="submit" value="{$lang['buttonSearch']}">
				</form>
			</td>
			</tr>
		</table>
EOT;

$template_reply_form = <<<EOT
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="reply">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr> 
					<td align="right" nowrap>{$lang['signName']}</td>
					<td> 
						<input type="text" name="name" value="{NAME}" size="20" class="fielder">
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="right" nowrap>{$lang['replyMessage']}</td>
					<td>
						<textarea name="reply" cols="50" rows="5" class="fielder"></textarea>
					</td>
				</tr>
				<tr>
					<td align="right" nowrap>{$lang['signCaptcha']}</td>
					<td>
						<input type="text" name="captcha" class="fielder" size=6 maxlength=4>&nbsp;
						<img id='image_captcha' src="include/php-captcha.image.php" align="middle" border=0 onclick="newCaptcha()" class=hand>
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
						<input class="submitter" type="submit" name="submit" value="{$lang['buttonReply']}">
						<input class="submitter" type="reset"  name="cancel" value="{$lang['buttonReset']}">
					</td>
				</tr>
			</table>
		</form>
EOT;

$template_delete_form = <<<EOT
		<br>
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="delete">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="center" nowrap>{$lang['deleteConfirm']}<p>
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap colspan="2">
						<br>
						<input class="submitter" type="submit" name="submit" value="{$lang['buttonDelete']}">
						<input class="submitter" type="button" name="cancel" value="{$lang['buttonCancel']}" onClick="javascript:history.back();">
					</td>
				</tr>
			</table>
		</form>
EOT;

$template_login_form = <<<EOT
		<br>
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="login">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="right" nowrap>{$lang['enterPassword']}</td>
					<td>
						<input type="password" name="password" size="20" class="fielder">
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap colspan="2">
						<br>
						<input class="submitter" type="submit" name="submit" value="{$lang['buttonLogin']}">
						<input class="submitter" type="button" name="cancel" value="{$lang['buttonCancel']}" onClick="javascript:history.back();">
					</td>
				</tr>
			</table>
		</form>
EOT;

$template_msgbox = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
<link rel="stylesheet" type="text/css" href="themes/default/style.css">
<title>{BOOKNAME} - {TITLE} (Powered by {APPLICATION_NAME} {VERSION})</title>
<script>
function newCaptcha() {
	var now=new Date();
	document.getElementById('image_captcha').src='include/php-captcha.image.php?'+now.getTime();
}
</script>
</head>

<body>

<div align="center">
<table class="m_tb2" cellpadding="4" cellspacing="1">
 <tr>
  <th class="td_head">{TITLE}</th>
 </tr>
 <tr>
  <th class="td_body">{MESSAGE}</th>
 </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0">
 <tr>
  <td class="copyright">
    <table>
    	<tr>
    		<td><a href="https://book.doublog.com/" target=_blank>
    		<img src="images/small_logo.gif" alt="logo" border="0"></a></td>
    		<td>&nbsp;</td>
    		<td>{COPYRIGHT}<br><a href="https://www.doublog.com/" target=_blank>Eruo Studio</a></td>
    	</tr>
    </table>
  </td>
 </tr>
</table>
</div>

</body>

</html>
EOT;
?>