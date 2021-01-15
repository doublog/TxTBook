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

	if (!file_exists("data/lock")) {
		header("Location:install.php");
		exit;
	}

	require("config.inc.php");

	$timeId = time().rand(1000, 9999);
	$date = date($cfg['dateFormat']);
	$ip = $_SERVER['REMOTE_ADDR'];

	$_POST = formatEntries(formatQuotes($_POST));
	$act = $_REQUEST['act'];
	if ($act == null || $act == "") { $act = "browse"; }
	
	//Login
	if ($act == 'login') {
		if ($_POST['submit'] != "") {
			if ($_POST['password'] != $cfg['password']) {
				msgbox($lang['wrongPassword']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
			} else {
				$adminMode = $_SESSION['vlBookAdm'] = true;
				msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">{$lang['loginSucceed']}<br><br><a href=\"$action_url\">".$lang['dontwait']."</a>", $lang['admLogin']);
			}
		} else {
			msgbox(getLoginForm($_GET['id']), $lang['admLogin']);
		}
		
	//Delete
	} else if ($act == 'delete') {
		if ($_POST['submit'] != "") {
			if (empty($_POST['id'])) {
				msgbox($lang['requireField']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
				exit();
			}
			if (!$adminMode) {
				msgbox($lang['notLogin']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
				exit();
			}
			$msg = file("data/$user");
			$fp = fopen("data/$user", "w");
 			if (flock($fp, LOCK_EX)) {
 				foreach($msg as $cnt=>$eachData) {
 					list($timeId, $name, $homepage, $message, $private, $email, $msn, $date, $avatar, $ip) = explode("|", $eachData);
					if($_POST['id'] != $timeId) {
						fputs($fp, "$timeId|$name|$homepage|$message|$private|$email|$msn|$date|$avatar|$ip");
					}
 				}
 				flock($fp, LOCK_UN);
 			} else {
				msgbox($lang['fileError'], $lang['error']);
				exit();
			}
			fclose($fp);
			msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">".$lang['deleteSucceed']."<br><br><a href=\"$action_url\">".$lang['dontwait']."</a>", $lang['delete']);
			
			
		} else if ($_GET['id'] != "") {
			msgbox(getDeleteForm($_GET['id']), $lang['delete']);
		}	else {
			msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">{$lang['missParam']}<br><br><a href=\"$action_url\">{$lang['dontwait']}</a>", $lang['error']);
		}
	
	//Reply
	} else if ($act == 'reply') {
		if ($_POST['submit'] != "") {
			if (empty($_POST['id']) || empty($_POST['name']) || empty($_POST['reply']) || empty($_POST['captcha'])) {
				msgbox("{$lang['requireField']}<br><br><a href='javascript:history.back();'>{$lang['back']}</a>", $lang['error']);
				exit();
			}
		if (!PhpCaptcha::Validate($_POST['captcha'])) {
			msgbox($lang['captchaInvalid']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
			exit();
		}
			$pull = (empty($_POST['pull']) || $_POST['pull'] != "1") ? false : true;
			$reply = str_replace("[CrLf]", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", "&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"red\">{$_POST['name']}{$lang['replyPrefix']}</font>{$_POST['reply']}");
			$msg = file("data/$user");
			$fp = fopen("data/$user", "w");
 			if (flock($fp, LOCK_EX)) {
 				$replyMessage = "";
 				foreach($msg as $cnt=>$eachData) {
 					list($timeId, $name, $homepage, $message, $private, $email, $msn, $date, $avatar, $ip) = explode("|", $eachData);
					if($_POST['id'] == $timeId) {
						$replyMessage = "$timeId|$name|$homepage|$message<br>$reply|$private|$email|$msn|$date|$avatar|$ip";
					}
 				}
 				if ($pull) {
 					fputs($fp, $replyMessage);
 				}
 				foreach($msg as $cnt=>$eachData) {
 					list($timeId, $name, $homepage, $message, $private, $email, $msn, $date, $avatar, $ip) = explode("|", $eachData);
					if($_POST['id'] != $timeId) {
						fputs($fp, "$timeId|$name|$homepage|$message|$private|$email|$msn|$date|$avatar|$ip");
					} else if(!$pull) {
 						fputs($fp, $replyMessage);
 					}
 				}
 				flock($fp, LOCK_UN);
 			} else {
				msgbox($lang['fileError'], $lang['error']);
				exit();
			}
			fclose($fp);
			msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">".$lang['replySucceed']."<br><br><a href=\"$action_url\">".$lang['dontwait']."</a>", $lang['reply']);
			
		} else if ($_GET['id'] != "") {
			msgbox(getReplyForm($_GET['id']), $lang['reply']);
		}	else {
			msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">{$lang['missParam']}<br><br><a href=\"$action_url\">{$lang['dontwait']}</a>", $lang['error']);
		}
	
	//Add new
	} else if ($act == 'add') {
		if (empty($_POST['name']) || empty($_POST['message']) || empty($_POST['captcha'])) {
			msgbox($lang['requireField']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
			exit();
		}
		if (!PhpCaptcha::Validate($_POST['captcha'])) {
			msgbox($lang['captchaInvalid']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
			exit();
		}
		if (strlen($_POST['name'].$_POST['homepage'].$_POST['message'].$_POST['email'].$_POST['msn']) > $cfg['maxMessageLength']) {
			msgbox($lang['messageTooLong'], $lang['error']);
			exit();
		}
		if (empty($_POST['homepage'])) {$_POST[''] = "http://";}
		if (empty($_POST['email'])) {$_POST['email'] = $lang['noEmail'];}
		if (empty($_POST['msn'])) {$_POST['msn'] = $lang['noMsn'];}
		$newData = "$timeId|{$_POST['name']}|{$_POST['homepage']}|{$_POST['message']}|{$_POST['private']}|{$_POST['email']}|{$_POST['msn']}|$date|{$_POST['avatar']}|$ip\n";
		$oldData = file("data/$user");
		$fp = fopen("data/$user", "w");
		if (flock($fp, LOCK_EX)) {
			fputs($fp, $newData);
			foreach($oldData as $cnt=>$eachData) {
				fputs($fp, $eachData);
			}
			flock($fp, LOCK_UN);
		} else {
			msgbox($lang['fileError'], $lang['error']);
			exit();
		}
		fclose($fp);
		msgbox("<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=$action_url\">".$lang['thanksForPost']."<br><br><a href=\"$action_url\">".$lang['dontwait']."</a>", $lang['sign']);
		
	//Browse Guestbook
	} else if ($act == 'browse' || $act == 'search') {
		if ($act == 'search') {
			if (empty($_POST['keyword'])) {
				msgbox($lang['requireField']."<br><br><a href='javascript:history.back();'>".$lang['back']."</a>", $lang['error']);
				exit();
			}
			@$data = file("data/$user");
			$fp = fopen($cfg['tempFile'], "w");
			if (flock($fp, LOCK_EX)) {
				foreach($data as $cnt=>$eachData) {
					if (strstr($eachData, $_POST['keyword'])) {
						fputs($fp, $eachData);
					}
				}
				flock($fp, LOCK_UN);
			} else {
				msgbox($lang['fileError'], $lang['error']);
				exit();
			}
			fclose($fp);
			@$msg = file($cfg['tempFile']);
			$cfg['listAmount'] = 9999;			//one page for search results
			
		} else {
			@$msg = file("data/$user");
		}
		
		$messageAmount = count($msg);
		$listAmount = $cfg['listAmount'];
		$page = $_GET['page'];
		
		if ($messageAmount % $listAmount) {
			$totalPage = intval($messageAmount / $listAmount) + 1;
		} else {
			$totalPage = $messageAmount / $listAmount;
		}
		if ($page <= 0 or $page > $totalPage) {
			$page = 1;
		}
		$messageStart = $listAmount * ($page - 1);
		$messageEnd = $messageStart + $listAmount - 1;
		if ($messageEnd > $messageAmount - 1) {
			$messageEnd = $messageAmount - 1;
		}
		
		//output
		@$tpl = file("themes/".$cfg['themeName']."/template.html");
		$tpl=implode("", $tpl);
		$tpl = str_replace("{CHARSET}", $lang['charset'], $tpl);
		$tpl = str_replace("{APPLICATION_NAME}", $cfg['applicationName'], $tpl);
		$tpl = str_replace("{VERSION}", $cfg['version'], $tpl);
		$tpl = str_replace("{HTMLAREA_EXT}", (file_exists("js/htmlarea_{$cfg['lang']}/.") ? "_".$cfg['lang'] : ""), $tpl);
		$tpl = str_replace("{AVATAR_PAGE_AMOUNT}", $cfg['avatarPageAmount'], $tpl);
		$tpl = str_replace("{AVATAR_TOTAL_IMAGE}", $cfg['avatarTotalImage'], $tpl);
		$tpl = str_replace("{AVATAR_SET}", $cfg['avatarSet'], $tpl);
		$tpl = str_replace("{BOOKNAME}", $cfg['bookName'], $tpl);
		$tpl = str_replace("{REQUIRE_FIELD}", $lang['requireField'], $tpl);
		$tpl = str_replace("{MAX_MESSAGE_LENGTH}", $cfg['maxMessageLength'], $tpl);
		$tpl = str_replace("{MESSAGE_TOO_LONG}", $lang['messageTooLong'], $tpl);
		$tpl = str_replace("{ANNOUNCEMENT}", str_replace("[separator]", "|", str_replace("[CrLf]", "\n", $cfg['announcement'])), $tpl);
		$tpl = str_replace("{SIGNBOOK}", $template_signbook, $tpl);
		$tpl = str_replace("{ADM_LOGIN}", $template_admin_login, $tpl);
		$tpl = str_replace("{TOTALPAGES}", sprintf($lang['totalPages'], $messageAmount), $tpl);
		$tpl = str_replace("{SIGN_BLOCK}", getSignBlockFormat(), $tpl);
		$tpl = str_replace("{SEARCH_BLOCK}", getSearchBlockFormat(), $tpl);
		$tpl = str_replace("{MESSAGE_BLOCK}", getMessageBlockFormat(xss_free($msg), $messageStart, $messageEnd), $tpl);
		$tpl = str_replace("{NAVIGATOR}", getNavigatorFormat($page, $totalPage), $tpl);
		$tpl = str_replace("{HOME_URL}", $action_url, $tpl);
		$tpl = str_replace("{COPYRIGHT}", $cfg['copyright'], $tpl);
		//$tpl = str_replace("", , $tpl);
		echo $tpl;
		
	} else {
		msgbox("ERROR ACTION!");
		exit();
	}

?>