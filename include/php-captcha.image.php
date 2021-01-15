<?php 
require('php-captcha.inc.php'); 

//You can have
$aFonts = array('../fonts/Architex.ttf');

$oVisualCaptcha = new PhpCaptcha($aFonts, 100, 19);
$oVisualCaptcha->UseColour(true); 
$oVisualCaptcha->SetNumChars(4);
$oVisualCaptcha->SetNumLines(0);
$oVisualCaptcha->SetMinFontSize(12);
$oVisualCaptcha->SetMaxFontSize(20);
$oVisualCaptcha->Create();
?>