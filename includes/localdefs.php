<?php
session_start();
if(!isset($_SESSION["dbuser"])){
header("Location: login.php");
exit(); }

//please define the enabled origin (legitimate calling URL) 
$LocalServer = '192.168.0.105';
$Protocol = 'http://'; //chahge to https for production
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dicomize</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../styles/login.app.css">
    
</head>
<body style="background: #525252;">
<?php
include("includes/auth.php"); //include auth.php file on all secure pages
$OrthancExplorer = $Protocol.$LocalServer.'/ngl/orthanc158/explorer.php';
$OrthancURL      = $Protocol.$LocalServer.'/ngl';
$PublicPATH      = '../../../../temporal/';
?>