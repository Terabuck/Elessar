<?php
if(isset($_COOKIE["NG_TRANSLATE_LANG_KEY"])) {
    $lang = $_COOKIE["NG_TRANSLATE_LANG_KEY"];
    $directory=dirname(__FILE__)."/locale"; 
    $domain="messages"; 
    textdomain($domain); 
    setlocale(LC_MESSAGES,$lang); 
    bindtextdomain($domain, $directory); 
    bind_textdomain_codeset($domain, "UTF-8");
};
session_start();
if(!isset($_SESSION["dbuser"])){
header("Location: login.php");
exit(); }
?>