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

$cfg['DEMO'] = false;
$cfg['applicationName'] = "TxTBook";
$cfg['version'] = "1.0";
$cfg['copyright'] = "<a href=\"https://book.doublog.com/\">Powered by <b> {$cfg['applicationName']} {$cfg['version']} </b> &copy; 2021.</a>";

// This cheap little trick was found over at php.net
if(PHP_VERSION < "4.1.0") {
	$_COOKIE = $HTTP_COOKIE_VARS;
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_FILES = $HTTP_POST_FILES;
}

if ($cfg['DEMO']) {
	$cfg['lang'] = 		empty($_GET['l']) ? $cfg['lang_DEFAULT'] : $_GET['l'];
	$cfg['themeName'] = empty($_GET['t']) ? $cfg['themeName_DEFAULT'] : $_GET['t'];
	$cfg['avatarSet'] = empty($_GET['a']) ? $cfg['avatarSet_DEFAULT'] : $_GET['a'];
	$user = 			empty($_GET['user']) ? $cfg['user_DEFAULT'] : $_GET['user'];
	$action_url = $_SERVER['PHP_SELF']."?user=$user&l={$_GET['l']}&t={$_GET['t']}&a={$_GET['a']}";
} else {
	$cfg['lang'] = empty($_GET['l']) ? $cfg['lang_DEFAULT'] : $_GET['l'];
	$cfg['themeName'] = $cfg['themeName_DEFAULT'];
	$cfg['avatarSet'] = $cfg['avatarSet_DEFAULT'];
	$user = $cfg['user_DEFAULT'];
	$action_url = $_SERVER['PHP_SELF']."?l={$_GET['l']}";
}

if(!file_exists("lang/{$cfg['lang']}.php")) {$cfg['lang'] = "english";}
include("include/functions.php");
include("lang/english.php");
include("lang/{$cfg['lang']}.php");
include("themes/{$cfg['themeName']}/theme.php");
include("avatar/{$cfg['avatarSet']}/setting.php");
include("include/php-captcha.inc.php");


if (!file_exists("data/$user")) {
	msgbox($lang['userNotExist'], $lang['error']);
	exit();
}

$adminMode = isset($_SESSION['vlBookAdm']);

?>