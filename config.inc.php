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

$cfg['bookName'] = '&#23396;&#33311;&#30041;&#35328;&#26412;';       //name of your guestbook/homepage
$cfg['password'] = '19871002';              //admin's password
$cfg['user_DEFAULT'] = 'default';		//user database
$cfg['lang_DEFAULT'] = 'english';       //language pack
$cfg['themeName_DEFAULT'] = 'mac';  //theme pack
$cfg['avatarSet_DEFAULT'] = 'default';  //avatar set
$cfg['listAmount'] = 10;                //how many posts to show in one page
$cfg['maxMessageLength'] = 20000;        //maximum message length
$cfg['dateFormat'] = 'Y-m-d H:i:s';     //date format
$cfg['tempFile'] = "data/temp";         //a temp file to store search result

//Announcement
$cfg['announcement'] = <<<EOT

EOT;


/*** don't change below ***/
include("include/global.inc.php");
?>