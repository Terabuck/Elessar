<!DOCTYPE html>
<html>
<head>
    <link rel='icon' href='libs/images/favicon.ico' type='image/ico'>
    <meta charset="UTF-8">
    <title><?=_('Login/Register DICOM DB user')?></title>
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="libs/styles/login.app.css">
    <style>
    </style>
</head>
<body>
    <div class="container-form">
        <div class="header">
            <div class="logo-title">
                <a href="http://www.orthanc-server.com/" target="_blank" alt="Orthanc Homepage">
                    <img src="libs/images/orthanc-logo.png" alt="Orthanc" style="max-width:100%" />
                </a>
            </div>
            <div class="menu">
                <a href="login.php">
                    <li class="module-login active"><?=_('Login')?></li>
                </a>
                <a href="register.php">
                    <li class="module-register"><?=_('Register')?></li>
                </a>
            </div>

            <div>
                <select class="lang-select" id="language" onchange="updateLang(this)"
                    style="background-image: url('libs/images/translate.svg');">
                    <option value="en_US"></option>
                    <option value="en_US">English</option>
                    <option value="zh_CN">中文</option>
                    <option value="hi_IN">हिन्दी भाषा</option>
                    <option value="es_ES">Castellano</option>
                    <option value="fr_FR">Français</option>
                    <option value="bn_BD">বাংলা ভাষা</option>
                    <option value="ru_RU">Русский</option>
                    <option value="pt_PT">Português</option>
                    <option value="id_ID">Bahasa</option>
                    <option value="de_DE">Deutsche</option>
                    <option value="ja_JP">日本語</option>
                    <option value="sw_TZ">Kiswahili</option>
                    <option value="it_IT">Italiano</option>
                    <option value="nl_NL">Nederlandse</option>
                </select>
            </div>
        </div>