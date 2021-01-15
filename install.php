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

require("config.inc.php");

$_POST = formatEntries(formatQuotes($_POST));

$errmsg = "<ul>";

$step = $_POST['s'];
if ($step == "") {
	$step = 1;
}
if (file_exists("data/lock")) {
	$step = -1;
	$errmsg .= "<li>The installer is currently locked, please remove 'lock' from the data directory to continue!</li>";
}
if (!is_writeable("config.inc.php")) {
	$step = -1;
	$errmsg .= "<li>The configuration file (config.inc.php) is not writable. Please adjust the chmod permissions to allow it to be written to.</li>";
}
if (!is_writeable("data/.")) {
	$step = -1;
	$errmsg .= "<li>The data directory is not writable. Please adjust the chmod permissions to allow it to be written to.</li>";
}

if ($step == "2") {
	$fp = fopen('config.inc.php', 'r');
	$configfile = fread($fp, filesize('config.inc.php'));
	fclose($fp);
	
	$configfile = preg_replace("/[$]cfg\[\'bookName\'\]\s*\=\s*[\"'].*?[\"']/i", 			"\$cfg['bookName'] = '".$_POST['bookname']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'password\'\]\s*\=\s*[\"'].*?[\"']/i", 			"\$cfg['password'] = '".$_POST['password']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'user_DEFAULT\'\]\s*\=\s*[\"'].*?[\"']/i", 		"\$cfg['user_DEFAULT'] = '".$_POST['user_default']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'lang_DEFAULT\'\]\s*\=\s*[\"'].*?[\"']/i", 		"\$cfg['lang_DEFAULT'] = '".$_POST['language_default']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'themeName_DEFAULT\'\]\s*\=\s*[\"'].*?[\"']/i", 	"\$cfg['themeName_DEFAULT'] = '".$_POST['theme_default']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'avatarSet_DEFAULT\'\]\s*\=\s*[\"'].*?[\"']/i", 	"\$cfg['avatarSet_DEFAULT'] = '".$_POST['avatar_default']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'listAmount\'\]\s*\=\s*.*?;/i", 					"\$cfg['listAmount'] = ".$_POST['listAmount'].";", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'maxMessageLength\'\]\s*\=\s*.*?;/i", 			"\$cfg['maxMessageLength'] = ".$_POST['maxMessageLength'].";", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'dateFormat\'\]\s*\=\s*[\"'].*?[\"']/i", 			"\$cfg['dateFormat'] = '".$_POST['dateFormat']."'", $configfile);
	$configfile = preg_replace("/[$]cfg\[\'announcement\'\]\s*\=\s*<<<EOT.*?EOT;/is",		"\$cfg['announcement'] = <<<EOT\n".$_POST['announcement']."\nEOT;", $configfile);
	
	$fp = fopen('config.inc.php', 'w');
	fwrite($fp, trim($configfile));
	fclose($fp);
	
	$fp = fopen('data/lock', 'w');
	fwrite($fp, "installed");
	fclose($fp);
	
	copy("data/default", "data/".$_POST['user_default']);
}


$errmsg .= "</ul><br><br><br>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="themes/default/style.css">
<title>TxTbook Installation</title>
</head>

<body>

<div align="center">
<table class="m_tb1" cellspacing="0" cellpadding="0">
 <tr>
  <td width="1%">&nbsp;</td>
  <td align="center" width="120"><img src="themes/default/images/small_logo.gif" border="0"></td>
  <td align="center"><h3 class="gb_title">TxTbook 1.0 Installation</h3></td>
 </tr>
</table>
<font size="-2"><br></font>

<table class="m_tb2" cellpadding="4" cellspacing="1">
 <tr>
  <td class="tdl" align="center"><b>
  	<?php
  	switch ($step) {
		case -1:
  		echo "<font color=red>ERROR!</font>";
  		break;
  		
  		case 1:
  		echo "One and the only step - Enter your informatoin";
  		break;
  		
  		case 2:
  		echo "Installation Successfully";
  		break;
  	}
  	?>
  </b></td>
 <tr>
  <td class="tdr"><br>
  	<?php
  	switch ($step) {
		case -1:
  		echo $errmsg;
  		break;
  		
  		case 1:
  		echo <<<EOT
<script language="Javascript1.2">
<!--
var _editor_url = "js/htmlarea/";
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { 
 document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>');
}
function getRand(n) {
	var chars = "abcdefghjkmnpqrstuvwxyz23456789";
	var rtn = "";
	for (var i = 0; i < n; i++) {
		rtn += chars.substr(parseInt(Math.random()*10000) % chars.length, 1);
	}
	return rtn;
}
function checkData() {
	if (document.getElementById("bookname").value == "") {
		document.getElementById("bookname").focus();
		alert("The name of your guestbook is required!");
		return false;
	}
	if (document.getElementById("password").value == "") {
		document.getElementById("password").focus();
		alert("Admin's password is required!");
		return false;
	}
	if (document.getElementById("password").value == "pass") {
		document.getElementById("password").focus();
		document.getElementById("password").select();
		alert("For a security reason, the password 'pass' is not acceptable, you have to enter another password!");
		return false;
	}
	if (document.getElementById("password").value != document.getElementById("password2").value) {
		document.getElementById("password").focus();
		document.getElementById("password").select();
		alert("Passwords do not match!");
		return false;
	}
	if (document.getElementById("user_default").value == "") {
		if (confirm("A filename is required, would you like me to generate one for you?")) {
			document.getElementById("user_default").value = getRand(6);
		} else {
			document.getElementById("user_default").focus();
			return false;
		}
	}
	if (document.getElementById("user_default").value == "default") {
		if (confirm("For a security reason, the filename 'default' is not acceptable, would you like me to generate another one for you?")) {
			document.getElementById("user_default").value = getRand(6);
		} else {
			document.getElementById("user_default").focus();
			document.getElementById("user_default").select();
			return false;
		}
	}
	return true;
}
function checkNaN(obj, n) {
	var num = parseInt(obj.value, 10);
	if (isNaN(num) || num < 1) {
		num = n;
	}
	obj.value = num;
}
//-->
</script>
<form method=post>
<input type=hidden name=s value=2>
<table align=center>
  <tr><td align=center colspan=2>To continue with the installation we now require your information, please fill every fields below:<br><br></td></tr>
  <tr><td align=right>The name of your guestbook: </td><td><input type=text class=fielder name=bookname value="my homepage"> ex: TxTBook demo</td></tr>
  <tr><td align=right>Admin's password: </td><td><input type=password class=fielder name=password> ex: pass1234</td></tr>
  <tr><td align=right>password again: </td><td><input type=password class=fielder name=password2></td></tr>
  <tr><td align=right>Guestbook filename: </td><td><input type=text class=fielder name=user_default> ex: mydata <input name=contactSubmit class=submitter type=button value="Give me a random one" onClick="document.getElementById('user_default').value=getRand(6);" style="font-size:10; height: 20"></td></tr>
  <tr><td align=right>Language: </td><td>
  		<select name=language_default class=fielder>
  			<option value=english>English</option>
  			<option value=basque>Basque(Euskera)</option>
  			<option value=chinese_gb>Chinese simplified</option>
  			<option value=chinese_big5>Chinese traditional</option>
  			<option value=hebrew>Hebrew</option>
  			<option value=italian>Italian</option>
  			<option value=nederlands>Nederlands</option>
  		</select></td></tr>
  <tr><td align=right>Theme: </td><td><select name=theme_default class=fielder><option value=default>Default</option><option value=mac>iMac</option><option value=discuz>Discuz! Board</option><option value=bluegrey>BlueGrey</option></select></td></tr>
  <tr><td align=right>Avatar Pack: </td><td><select name=avatar_default class=fielder><option value=default>Default</option><option value=bigsmile>Big smiles</option><option value=sangou>Sangou</option></select></td></tr>
  <tr><td align=right>How many messages in one page: </td><td><input type=text class=fielder name=listAmount value=10 onblur="checkNaN(this, 10);"></td></tr>
  <tr><td align=right>Maximum message length: </td><td><input type=text class=fielder name=maxMessageLength value=2000 onblur="checkNaN(this, 2000);"></td></tr>
  <tr><td align=right>Date format: </td><td><input type=text class=fielder name=dateFormat value="Y-m-d H:i:s"> <a href="http://www.php.net/manual/tw/function.date.php" target="_dateformat">see formats...</a></td></tr>
  <tr><td align=right>Announcement: </td><td></td></tr>
  <tr><td align=center colspan="2">
  		<table border="1" width="92%" bgcolor="threedface" bordercolorlight="#808080" bordercolordark="#FFFFFF" cellspacing="0" cellpadding="2">
			<tr>
				<td><textarea id="announcement" name="announcement" rows="8" class="fielder" style="width: 100%">Welcome to my homepage...</textarea></td>
			</tr>
		</table>
  		</td></tr>
  <tr><td align=center colspan="2"><br><input name=contactSubmit class=submitter type=submit value="  Click to install  " onClick="return checkData();"></td></tr>
</table>  
</form>
<script language="JavaScript1.2" defer>
editor_generate('announcement');
</script>
<br>
EOT;
  		break;
  		
  		case 2:
  		echo <<<EOT
<center>
Congratulations! The vlbook is installed successfully.<br><br>
The settings are stored in config.inc.php and you can open and edit it anytime.<br><br>
<a href="index.php"> Goto my guestbook </a></center><br><br>
EOT;

  		break;
  	}
  	?>
  </td>
 </tr>
</table>
<font size="-2"><br></font>

<table cellspacing="0" cellpadding="0">
 <tr>
  <td class="copyright">
		<table>
			<tr>
				<td><a href="https://book.doublog.com/" target=_blank>
				<img src="images/small_logo.gif" border="0" /></a></td>
				<td>&nbsp;</td>
				<td class="sfont">Copyright &copy 2021. All rights reserved.<br><a href="https://www.doublog.com/" target=_blank>Eruo Studio</a></td>
			</tr>
		</table>
  </td>
 </tr>
</table>
</div>

</body>

</html>