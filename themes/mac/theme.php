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
$lang['buttonSearch'] = "     ".$lang['buttonSearch'];

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
	return sprintf($lang['jumpTo'], $str);
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
		<a href="#signArea"><font color="brown">{$lang['sign']}</font></a>
EOT;

$template_admin_login = <<<EOT
		<a href="$action_url&amp;act=login"><font color="brown">{$lang['admLogin']}</font></a>
EOT;

$template_message_block_header = <<<EOT
		<table border="0" cellPadding="3" cellSpacing="1" width="98%" align="center" bgcolor="#000000">
EOT;

$template_message_block_footer = <<<EOT
		</table>
EOT;

$template_message_block = <<<EOT
			<tr>
				<td bgcolor="#f7f7f7" rowSpan="3" valign="top" width="20%">
					<table border="0" cellPadding="4" cellSpacing="0" width="100%" style="WORD-BREAK: break-all">
						<tr>
							<td align="center" width="41%"><font color="#000000"> </font></td>
							<td align="center" width="17%"><font color="#000000"><img src="avatar/{$cfg['avatarSet']}/{$cfg['avatarSet']}{AVATAR}.gif" alt="avatar"></font></td>
							<td align="center" width="42%">&nbsp;</td>
						</tr>
					</table>
					<P>	{$lang['name']} <font color="#000000">{NAME}</font><br>
							{$lang['from']} <font color="#000000">{IP}</font><br>
					</P>
				</td>
				<td bgcolor="#ffffff" width="80%"><img src="images/sign.gif" alt="sign" align="middle"> {$lang['posted']}  {DATE} </td>
			<tr style="WORD-BREAK: break-all">
				<td height="68" onMouseOver="mouseOver(this);" onMouseOut="mouseOut(this);" bgcolor="#ebebeb" valign="top">{MESSAGE}</td>
			</tr>
			<tr>
				<td bgcolor="#f7f7f7">&nbsp; 
					<a href="mailto:{EMAIL}" title="{$lang['sendEmail']}"> <img border="0" src="images/mail.gif" alt="mail" align="middle">&nbsp;{$lang['email']}</a>&nbsp;
					<a href="{HOMEPAGE}" target=_blank title="{$lang['visitHomepage']}"> <img border="0" src="images/home.gif" alt="home" align="middle">&nbsp;{$lang['homepage']}</a>&nbsp; 
					<img src="images/msn.gif" alt="{$lang['vistorMsn']}" align="middle">&nbsp;MSN&nbsp; 
					<img src="images/ip.gif" border="0" alt="{$lang['visitorIP']}" align="middle">&nbsp;IP&nbsp;
					<a href="{$action_url}&amp;act=reply&amp;id={TIMEID}" title="{$lang['reply']}"> <img border="0" src="images/reply.gif" alt="reply" align="middle">&nbsp;{$lang['reply']}</a> &nbsp; 
					<!--IF LOGIN--><a href="{$action_url}&amp;act=delete&amp;id={TIMEID}" title="{$lang['delete']}"> <img border="0" src="images/del.gif" alt="delete" align="middle">&nbsp;{$lang['delete']}</a><!--END IF-->
				</td>
			</tr>
EOT;

$template_sign_block = <<<EOT
		<a name="signArea"></a>
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="add">
			<table width="98%" border="0" cellspacing="1" cellpadding="4" align="center" class="border" bgcolor="#000000">
				<tr bgcolor="#ebebeb"> 
					<td nowrap align="right" width="10%"><font color="red"><b>*</b></font> {$lang['signCaptcha']}</td>
					<td nowrap colspan="3">
						<input type="text" id="captcha" name="captcha" size="6" maxlength="4"  style="background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver="this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">&nbsp;
						<img id='image_captcha' src="include/php-captcha.image.php" align="middle" border="0" onclick="newCaptcha()" class="hand" alt="captcha">
					</td>
				</tr>
				<tr bgcolor="#ebebeb">
					<td width="10%" align="right" nowrap><font color="red"><b>*</b></font> {$lang['signName']}</td>
					<td width="40%">
						<input type="text" maxlength="20" id="name" name="name" style="width: 100%; background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver="this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">
					</td>
					<td width="10%" align="right" nowrap>{$lang['signEmail']}</td>
					<td width="40%"> 
						<input maxlength="60" type="text" name="email" style="width: 100%; background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver="this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''" value="@">
					</td>
				</tr>
				<tr bgcolor="#ebebeb">
					<td align="right" nowrap width="10%">{$lang['signMsn']}</td>
					<td width="40%"> 
						<input maxlength="40" type="text" name="msn" size="32" style="width: 100%; background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">
					</td>
					<td width="10%" align="right" nowrap>{$lang['signHomepage']}</td>
					<td width="40%" height="12">
						<input type="text" name="homepage" size="35" style="width: 100%; background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''" value="http://">
					</td>
        </tr>
				<tr bgcolor="#ebebeb"> 
					<td align="right" nowrap width="10%"><font color="red"><b>*</b></font> {$lang['signMessage']}</td>
					<td align="left" width="40%" colspan="3"> 
						<textarea id="text" name="message" rows="8" cols="80" style="width: 100%"></textarea>
					</td>
        </tr>
				<tr bgcolor="#ebebeb"> 
					<td nowrap align="right" width="10%">{$lang['signPrivate']}</td>
					<td nowrap colspan="3">
						<input type="radio" name="private" value="0" checked>{$lang['signPrivateOff']}
						<input type="radio" name="private" value="1">{$lang['signPrivateOn']}
					</td>
				</tr>
				<tr bgcolor="#ebebeb"> 
					<td nowrap align="right" width="10%">{$lang['signAvatar']}</td>
					<td nowrap align="center" colspan="3" id="ChoiceImage">
						{AVATARS} <input class="buttongray" value="" style="width: 22" type="button" onClick="nextImagePage()">
					</td>
				</tr>
				<tr bgcolor="#ebebeb">
					<td align="center" nowrap colspan="4">
						<input name="Submit" class="button" type="submit" value="{$lang['buttonSign']}" maxlength="1000"  onMouseOver ="this.style.backgroundColor='#000000'" onMouseOut ="this.style.backgroundColor='EEEEF8'" onClick="return checkData();">&nbsp;&nbsp;
						<input name="Reset" class="button" type="reset" value="{$lang['buttonReset']}" onMouseOver ="this.style.backgroundColor='#000000'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
					</td>    
				</tr>    
			</table>    
		</form>
		<br>
EOT;

$template_avatar = <<<EOT
							<input type="radio" name="avatar" value="%s" %s><img src="avatar/%s/%s%s.gif" alt="avatar">&nbsp;&nbsp;
EOT;

$template_search_block = <<<EOT
		<table width="98%" border="0" cellspacing="1" cellpadding="4" align="center" class="border" bgcolor="#000000">
			<tr bgcolor="#ebebeb">
			<td width="100%" align="center"> 
				<form method="post" action="{ACTION_URL}">
				<input type="hidden" name="act" value="search">
						{$lang['searchKeyword']}<input name="keyword" size="12" maxlength="20" style="background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">&nbsp;&nbsp;
		    		<input class="buttongray" name="submit" type="submit" value="{$lang['buttonSearch']}" onMouseOver ="this.style.backgroundColor='#000000'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
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
					<td align="right" nowrap>{$lang['signCaptcha']}</td>
					<td>
						<input type="text" name="captcha" class="fielder" size="6" maxlength="4">&nbsp;
						<img id='image_captcha' src="include/php-captcha.image.php" align="middle" border="0" onclick="newCaptcha()" class=hand>
					</td>
				</tr>
				<tr> 
					<td align="right" nowrap>{$lang['signName']}</td>
					<td> 
						<input type="text" maxlength="20" value="{NAME}" id="name" name="name" style="width: 370; background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="right" nowrap>{$lang['replyMessage']}</td>
					<td>
						<textarea name="reply" cols="50" rows="5" style="background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''"></textarea>
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
						<input class="button" type="submit" name="submit" value="{$lang['buttonReply']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
						<input class="button" type="reset"  name="cancel" value="{$lang['buttonReset']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
					</td>
				</tr>
			</table>
		</form>
EOT;

$template_delete_form = <<<EOT
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="delete">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="center" nowrap>{$lang['deleteConfirm']}<p>
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap> 
						<input class="button" type="submit" name="submit" value="{$lang['buttonDelete']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
						<input class="button" type="button" name="cancel" value="{$lang['buttonCancel']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'" onClick="javascript:history.back();">
					</td>
				</tr>
			</table>
		</form>
EOT;

$template_login_form = <<<EOT
		<form method="post" action="{ACTION_URL}">
			<input type="hidden" name="act" value="login">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="right" nowrap>{$lang['enterPassword']}</td>
					<td>
						<input type="password" name="password" size="20" style="background-color:#ffffff; color:#8888AA; border: 1 double #B4B4B4" onMouseOver = "this.style.backgroundColor = '#E5F0FF'" onMouseOut = "this.style.backgroundColor = ''">
						<input type="hidden" name="id" value="{TIMEID}">
					</td>
				</tr>
				<tr> 
					<td align="center" nowrap colspan="2"> 
						<br><br>
						<input class="button" type="submit" name="submit" value="{$lang['buttonLogin']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'">
						<input class="button" type="button" name="cancel" value="{$lang['buttonCancel']}" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='EEEEF8'" onClick="javascript:history.back();">
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
<link rel="stylesheet" href="themes/mac/style.css" type="text/css">
<title>{BOOKNAME} - {TITLE} (Powered by {APPLICATION_NAME} {VERSION})</title>
<script>
function newCaptcha() {
	var now=new Date();
	document.getElementById('image_captcha').src='include/php-captcha.image.php?'+now.getTime();
}
</script>
</head>

<body style="margin-top: 5" bgcolor="#ffffff" text="#000000" link="#4682B4" vlink="#4682B4" background="themes/mac/images/lines.gif">

<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="15">
		<img src="themes/mac/images/imac_scrn_1.gif" alt="imac" width="15" height="16"></td>
		<td background="themes/mac/images/imac_scrn_3.gif" width="100%">
		<img src="themes/mac/images/spacer.gif" alt="spacer"></td>
		<td width="16">
		<img src="themes/mac/images/imac_scrn_5.gif" width="16" height="16"></td>
	</tr>
	<tr>
		<td width="15" background="themes/mac/images/imac_scrn_9.gif">
		<img src="themes/mac/images/spacer.gif" alt="spacer"></td>
		<td width="100%" align="center">
			<br>
			{MESSAGE}
			<br>
			<br>
		</td>
		<td width="16" background="themes/mac/images/imac_scrn_10.gif">
		<img src="themes/mac/images/spacer.gif" alt="spacer"></td>
	</tr>
	<tr>
		<td width="15">
		<img src="themes/mac/images/imac_scrn_13.gif" width="15" height="16"></td>
		<td background="themes/mac/images/imac_scrn_14.gif" width="100%">
		<img src="themes/mac/images/spacer.gif" alt="spacer"></td>
		<td width="16">
		<img src="themes/mac/images/imac_scrn_11.gif" width="16" height="16" alt="imac"></td>
	</tr>
</table>

<div align="center">
	<table>
		<tr>
			<td height="50"><a href="https://book.doublog.com/" target="_blank">
			<img src="images/small_logo.gif" alt="logo" border="0"></a></td>
			<td>&nbsp;</td>
			<td>{COPYRIGHT}<br><a href="https://www.doublog.com/" target="_blank">Eruo Studio</a></td>
		</tr>
	</table>
</div>

</body>
</html>
EOT;
?>