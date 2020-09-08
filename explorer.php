<?php 
include("includes/header.php");
include("includes/auth.php");
?>
<div data-role="page" id="lookup">
    <div data-role="header">
        <h1><?php  echo strtoupper($_SESSION['dbuser']); ?> @ <span class="orthanc-name"></span><?=_('Lookup studies')?>
        </h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#" id="logout" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Quit')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
            <select data-iconpos="left" id="language" onchange="updateLang(this)" data-mini="true">
                <option value="en_US">🌐</option>
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
    <div data-role="content">
        <div data-role="content" id="content">
            <p align="center">
                <a href="http://www.orthanc-server.com/" target="_blank" alt="Orthanc homepage"><img
                        src="libs/images/orthanc-logo.png" alt="Orthanc" style="width: 80%; max-width: 420px" /></a>
            </p>
        </div>
        <form data-ajax="false" id="lookup-form">
            <div data-role="fieldcontain">
                <label for="lookup-patient-id"><?=_('Patient ID:')?></label>
                <input type="text" name="lookup-patient-id" id="lookup-patient-id" value="" />
            </div>
            <div data-role="fieldcontain">
                <label for="lookup-patient-name"><?=_('Patient Name:')?></label>
                <input type="text" name="lookup-patient-name" id="lookup-patient-name" value="" />
            </div>
            <div data-role="fieldcontain">
                <label for="lookup-accession-number"><?=_('Accession Number:')?></label>
                <input type="text" name="lookup-accession-number" id="lookup-accession-number" value="" />
            </div>
            <div data-role="fieldcontain">
                <label for="lookup-study-description"><?=_('Study Description:')?></label>
                <input type="text" name="lookup-study-description" id="lookup-study-description" value="" />
            </div>
            <div data-role="fieldcontain">
                <label for="lookup-study-date"><?=_('Study Date:')?></label>
                <select name="lookup-study-date" id="lookup-study-date"></select>
            </div>
            <fieldset class="ui-grid-b">
                <div class="ui-block-a">
                    <a href="#find-patients" data-role="button" data-theme="b"
                        data-direction="reverse"><?=_('All patients')?></a>
                </div>
                <div class="ui-block-b">
                    <a href="#find-studies" data-role="button" data-theme="b"
                        data-direction="reverse"><?=_("All studies")?></a>
                </div>
                <div class="ui-block-c"><button id="lookup-submit" type="submit"
                        data-theme="e"><?=_('Do lookup')?></button></div>
            </fieldset>
            <div>&nbsp;</div>
        </form>
        <div id="lookup-result">
            <div id="lookup-alert">
                <div class="ui-bar ui-bar-e">
                    <h3><?=_('Warning:')?></h3><?=_('Your lookup led to many results! Showing only')?><span
                        id="lookup-count">?</span><?=_('studies to avoid performance issue. Please make your query more specific, then relaunch the lookup.')?>
                </div>
                <div>&nbsp;</div>
            </div>
            <ul data-role="listview" data-inset="true" data-filter="true"></ul>
        </div>
    </div>
</div>
<div data-role="page" id="find-patients">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('All patients')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div id="alert-patients">
            <div class="ui-bar ui-bar-e">
                <h3><?=_('Warning:')?></h3><?=_('This is a large Orthanc server. Showing only')?> <span
                    id="count-patients">?</span><?=_('patients to avoid performance issue. Make sure to use lookup if targeting specific patients!')?>
            </div>
            <div>&nbsp;</div>
        </div>
        <ul id="all-patients" data-role="listview" data-inset="true" data-filter="true"></ul>
    </div>
</div>
<div data-role="page" id="find-studies">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('All studies')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div id="alert-studies">
            <div class="ui-bar ui-bar-e">
                <h3><?=_('Warning:')?></h3><?=_('This is a large Orthanc server. Showing only')?> <span
                    id="count-studies">?</span><?=_('studies to avoid performance issue. Make sure to use lookup if targeting specific studies!')?>
            </div>
            <div>&nbsp;</div>
        </div>
        <ul id="all-studies" data-role="listview" data-inset="true" data-filter="true"></ul>
    </div>
</div>
<div data-role="page" id="upload">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('Upload DICOM files')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
            <a href="#jobs" data-icon="refresh" data-role="button" data-direction="reverse"><?=_('Jobs')?></a>
        </div>
    </div>
    <div data-role="content">
        <div>
            <input id="fileupload" type="file" name="files[]" data-url="../instances/" style="display:none" multiple>
        </div>
        <p>
        <ul data-role="listview" data-inset="true">
            <li id="fileupload-proxy" onclick="$('#fileupload').click()" data-icon="arrow-r" data-theme="e">
                <a href="#"><?=_('Select files to upload ...')?></a>
            </li>
            <li data-icon="arrow-r" data-theme="e">
                <a href="#" id="upload-button"><?=_('Start the upload')?></a>
            </li>
            <li data-icon="delete" data-theme="d">
                <a href="#" id="upload-clear"><?=_('Clear the pending uploads')?></a>
            </li>
        </ul>
        <div id="progress" class="ui-corner-all"><span class="bar ui-corner-all"></span>
            <div class="label"></div>
        </div>
        </p>
        <div class="ui-bar ui-bar-e" id="issue-21-warning">
            <h3><?=_('Warning:')?></h3>
            <!-- // Translator's comment - Missing space in the original file #21:On -->
            <?=_('Orthanc issue #21: On Firefox, especially on Linux & OSX systems, files might be missing if using drag-and-drop. Please use the "Select files to upload" button instead, or use the command-line "ImportDicomFiles.py" script.')?>
        </div>
        <ul id="upload-list" data-role="listview" data-inset="true">
            <li data-role="list-divider"><?=_('Drag and drop DICOM files here')?></li>
        </ul>
    </div>
</div>
<div data-role="page" id="patient">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('Patient')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <ul data-role="listview" data-inset="true" data-theme="a" id="patient-info"></ul>
                <p>
                <div class="switch-container">
                    <select name="protection" id="protection" data-role="slider">
                        <option value="off"><?=_('Unprotected')?></option>
                        <option value="on"><?=_('Protected')?></option>
                    </select>
                </div>
                </p>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Interact')?></li>
                    <li data-icon="arrow-u">
                        <a href="#" id="upload-picture"><?=_('Add JPG image')?></a>
                    </li>
                    <li data-icon="delete">
                        <a href="#" id="patient-delete"><?=_('Delete this patient')?></a>
                    </li>
                    <li data-icon="forward">
                        <a href="#" id="patient-store"><?=_('Send to remote modality')?></a>
                    </li>
                    <li data-icon="star">
                        <a href="#" id="patient-anonymize"><?=_('Anonymize')?></a>
                    </li>
                </ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Access')?></li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="patient-anonymized-from"><?=_('Before anonymization')?></a>
                    </li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="patient-modified-from"><?=_('Before modification')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="patient-archive"><?=_('Download ZIP')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="patient-media"><?=_('Download DICOMDIR')?></a>
                    </li>
                </ul>
            </div>
            <div class="ui-block-b">
                <ul id="list-studies" data-role="listview" data-inset="true" data-filter="true"></ul>
            </div>
        </div>
    </div>
</div>
<div data-role="page" id="study">
    <div data-role="header">
        <h1><span class="orthanc-name"></span>
            <a href="#" class="patient-link"><?=_('Patient')?></a>&raquo;
            <?=_('Study')?>
        </h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <ul data-role="listview" data-inset="true" data-theme="a" id="study-info"></ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Interact')?></li>
                    <li data-icon="plus">
                        <a href="#" id="upload-report"><?=_('Append PDF report')?></a>
                    </li>
                    <li data-icon="arrow-u">
                        <a href="#" id="upload-picture2"><?=_('Add JPG image')?></a>
                    </li>
                    <li data-icon="delete">
                        <a href="#" id="study-delete"><?=_('Delete this study')?></a>
                    </li>
                    <li data-icon="forward">
                        <a href="#" id="study-store"><?=_('Send to DICOM modality')?></a>
                    </li>
                    <li data-icon="star">
                        <a href="#" id="study-anonymize"><?=_('Anonymize')?></a>
                    </li>
                </ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Access')?></li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="study-anonymized-from"><?=_('Before anonymization')?></a>
                    </li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="study-modified-from"><?=_('Before modification')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="study-archive"><?=_('Download ZIP')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="study-media"><?=_('Download DICOMDIR')?></a>
                    </li>
                </ul>
            </div>
            <div class="ui-block-b">
                <ul id="list-series" data-role="listview" data-inset="true" data-filter="true"></ul>
            </div>
        </div>
    </div>
</div>
<div data-role="page" id="series">
    <div data-role="header">
        <h1><span class="orthanc-name"></span>
            <a href="#" class="patient-link"><?=_('Patient')?></a>&raquo; <a href="#"
                class="study-link"><?=_('Study')?></a>&raquo; <?=_('Series')?>
        </h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <ul data-role="listview" data-inset="true" data-theme="a" id="series-info"></ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Interact')?></li>
                    <li data-icon="delete">
                        <a href="#" id="series-delete"><?=_('Delete this series')?></a>
                    </li>
                    <li data-icon="forward">
                        <a href="#" id="series-store"><?=_('Send to DICOM modality')?></a>
                    </li>
                    <li data-icon="star">
                        <a href="#" id="series-anonymize"><?=_('Anonymize')?></a>
                    </li>
                </ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Access')?></li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="series-anonymized-from"><?=_('Before anonymization')?></a>
                    </li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="series-modified-from"><?=_('Before modification')?></a>
                    </li>
                    <li data-icon="search">
                        <a href="#" id="series-preview"><?=_('Preview this series')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="series-archive"><?=_('Download ZIP')?></a>
                    </li>
                    <li data-icon="gear">
                        <a href="#" id="series-media"><?=_('Download DICOMDIR')?></a>
                    </li>
                </ul>
            </div>
            <div class="ui-block-b">
                <ul id="list-instances" data-role="listview" data-inset="true" data-filter="true"></ul>
            </div>
        </div>
    </div>
</div>
<div data-role="page" id="instance">
    <div data-role="header">
        <h1><span class="orthanc-name"></span>
            <a href="#" class="patient-link"><?=_('Patient')?></a>&raquo; <a href="#"
                class="study-link"><?=_('Study')?></a>&raquo; <a href="#"
                class="series-link"><?=_('Series')?></a>&raquo; <?=_('Instance')?>
        </h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#upload" data-icon="arrow-u" data-role="button"><?=_('Upload')?></a>
            <a href="#query-retrieve" data-icon="search" data-role="button"><?=_('Query/Retrieve')?></a>
        </div>
    </div>
    <div data-role="content">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <ul data-role="listview" data-inset="true" data-theme="a" id="instance-info"></ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Interact')?></li>
                    <li data-icon="delete">
                        <a href="#" id="instance-delete"><?=_('Delete this instance')?></a>
                    </li>
                    <li data-icon="forward">
                        <a href="#" id="instance-store"><?=_('Send to DICOM modality')?></a>
                    </li>
                </ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
                    <li data-role="list-divider"><?=_('Access')?></li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="instance-anonymized-from"><?=_('Before anonymization')?></a>
                    </li>
                    <li data-icon="info" data-theme="e" style="display:none">
                        <a href="#" id="instance-modified-from"><?=_('Before modification')?></a>
                    </li>
                    <li data-icon="arrow-d">
                        <a href="#" id="instance-download-dicom"><?=_('Download the DICOM file')?></a>
                    </li>
                    <li data-icon="arrow-d">
                        <a href="#" id="instance-download-json"><?=_('Download the JSON file')?></a>
                    </li>
                    <li data-icon="search">
                        <a href="#" id="instance-preview"><?=_('Preview the instance')?></a>
                    </li>
                </ul>
            </div>
            <div class="ui-block-b">
                <div class="ui-body ui-body-b">
                    <h1><?=_('DICOM Tags')?></h1>
                    <p align="right">
                        <input type="checkbox" id="show-tag-name" checked="checked" class="custom" data-mini="true" />
                        <label for="show-tag-name"><?=_('Show tag description')?></label>
                    </p>
                    <div id="dicom-tree"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-role="page" id="plugins">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('Plugins')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#jobs" data-icon="refresh" data-role="button" data-direction="reverse"><?=_('Jobs')?></a>
        </div>
    </div>
    <div data-role="content">
        <ul id="all-plugins" data-role="listview" data-inset="true" data-filter="true"></ul>
    </div>
</div>
<div data-role="page" id="query-retrieve">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('DICOM Query/Retrieve')?> (1/4)</h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
            <a href="#jobs" data-icon="refresh" data-role="button" data-direction="reverse"><?=_('Jobs')?></a>
        </div>
    </div>
    <div data-role="content">
        <form data-ajax="false">
            <div data-role="fieldcontain">
                <label for="qr-server"><?=_('DICOM server:')?></label>
                <select name="qr-server" id="qr-server"></select>
            </div>
            <div data-role="fieldcontain" id="qr-fields">
                <fieldset data-role="controlgroup">
                    <legend><?=_('Field of interest:')?></legend>
                    <input type="radio" name="qr-field" id="qr-patient-id" value="PatientID" checked="checked" />
                    <label for="qr-patient-id"><?=_('Patient ID')?></label>
                    <input type="radio" name="qr-field" id="qr-patient-name" value="PatientName" />
                    <label for="qr-patient-name"><?=_('Patient Name')?></label>
                    <input type="radio" name="qr-field" id="qr-accession-number" value="AccessionNumber" />
                    <label for="qr-accession-number"><?=_('Accession Number')?></label>
                    <input type="radio" name="qr-field" id="qr-study-description" value="StudyDescription" />
                    <label for="qr-study-description"><?=_('Study Description')?></label>
                </fieldset>
            </div>
            <div data-role="fieldcontain">
                <label for="qr-value"><?=_('Value for this field:')?></label>
                <input type="text" name="qr-value" id="qr-value" value="*" />
            </div>
            <div data-role="fieldcontain">
                <label for="qr-date"><?=_('Study date:')?></label>
                <select name="qr-date" id="qr-date"></select>
            </div>
            <div data-role="fieldcontain" id="qr-modalities">
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <legend><?=_('Modalities:')?></legend>
                        <input type="checkbox" name="CR" id="qr-cr" class="custom" />
                        <label for="qr-cr">CR</label>
                        <input type="checkbox" name="CT" id="qr-ct" class="custom" />
                        <label for="qr-ct">CT</label>
                        <input type="checkbox" name="MR" id="qr-mr" class="custom" />
                        <label for="qr-mr">MR</label>
                        <input type="checkbox" name="NM" id="qr-nm" class="custom" />
                        <label for="qr-nm">NM</label>
                        <input type="checkbox" name="PT" id="qr-pt" class="custom" />
                        <label for="qr-pt">PT</label>
                        <input type="checkbox" name="US" id="qr-us" class="custom" />
                        <label for="qr-us">US</label>
                        <input type="checkbox" name="XA" id="qr-xa" class="custom" />
                        <label for="qr-xa">XA</label>
                        <input type="checkbox" name="DR" id="qr-dr" class="custom" />
                        <label for="qr-dr">DR</label>
                        <input type="checkbox" name="DX" id="qr-dx" class="custom" />
                        <label for="qr-dx">DX</label>
                        <input type="checkbox" name="MG" id="qr-mg" class="custom" />
                        <label for="qr-mg">MG</label>
                    </fieldset>
                </div>
            </div>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><button id="qr-echo" data-theme="a"><?=_('Test Echo')?></button></div>
                <div class="ui-block-b"><button id="qr-submit" type="submit"
                        data-theme="b"><?=_('Search studies')?></button></div>
            </fieldset>
        </form>
    </div>
</div>
<div data-role="page" id="query-retrieve-2">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('DICOM Query/Retrieve')?> (2/4)</h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
        </div>
        <a href="#query-retrieve" data-icon="search" class="ui-btn-right"
            data-direction="reverse"><?=_('Query/Retrieve')?></a>
    </div>
    <div data-role="content">
        <ul data-role="listview" data-inset="true" data-filter="true" data-split-icon="arrow-d" data-split-theme="b">
        </ul>
    </div>
</div>
<div data-role="page" id="query-retrieve-3">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('DICOM Query/Retrieve')?> (3/4)</h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
        </div>
        <a href="#query-retrieve" data-icon="search" class="ui-btn-right"
            data-direction="reverse"><?=_('Query/Retrieve')?></a>
    </div>
    <div data-role="content">
        <ul data-role="listview" data-inset="true" data-filter="true"></ul>
    </div>
</div>
<div data-role="page" id="query-retrieve-4">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('DICOM Query/Retrieve')?> (4/4)</h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
        </div>
        <a href="#query-retrieve" data-icon="search" class="ui-btn-right"
            data-direction="reverse"><?=_('Query/Retrieve')?></a>
    </div>
    <div data-role="content">
        <form data-ajax="false" id="retrieve-form">
            <div data-role="fieldcontain">
                <label for="retrieve-target"><?=_('Target AET:')?></label>
                <input type="text" name="retrieve-target" id="retrieve-target"></input>
            </div>
            <fieldset class="ui-grid-b">
                <div class="ui-block-a"></div>
                <div class="ui-block-b"><button id="retrieve-submit" type="submit"
                        data-theme="b"><?=_('Retrieve')?></button></div>
                <div class="ui-block-c"></div>
            </fieldset>
        </form>
    </div>
</div>
<div data-role="page" id="jobs">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('Jobs')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
        </div>
    </div>
    <div data-role="content">
        <ul id="all-jobs" data-role="listview" data-inset="true" data-filter="true"></ul>
    </div>
</div>
<div data-role="page" id="job">
    <div data-role="header">
        <h1><span class="orthanc-name"></span><?=_('Job')?></h1>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-left">
            <a href="#lookup" data-icon="arrow-l" data-role="button" data-direction="reverse"><?=_('Lookup')?></a>
        </div>
        <div data-type="horizontal" data-role="controlgroup" class="ui-btn-right">
            <a href="#plugins" data-icon="grid" data-role="button" data-direction="reverse"><?=_('Plugins')?></a>
            <a href="#jobs" data-icon="refresh" data-role="button" data-direction="reverse"><?=_('Jobs')?></a>
        </div>
    </div>
    <div data-role="content">
        <ul data-role="listview" data-inset="true" data-filter="true" id="job-info"></ul>
        <fieldset class="ui-grid-b">
            <div class="ui-block-a"></div>
            <div class="ui-block-b"><button id="job-cancel" data-theme="b"><?=_('Cancel job')?></button><button
                    id="job-resubmit" data-theme="b"><?=_('Resubmit job')?></button><button id="job-pause"
                    data-theme="b"><?=_('Pause job')?></button><button id="job-resume"
                    data-theme="b"><?=_('Resume job')?></button></div>
            <div class="ui-block-c"></div>
        </fieldset>
    </div>
</div>
<div id="peer-store" style="display:none;" class="ui-body-c">
    <p align="center"><b><?=_('Sending to Orthanc peer...')?></b></p>
    <p><img src="libs/images/ajax-loader.gif" alt="" /></p>
</div>
<div id="dicom-store" style="display:none;" class="ui-body-c">
    <p align="center"><b><?=_('Sending to DICOM modality...')?></b></p>
    <p><img src="libs/images/ajax-loader.gif" alt="" /></p>
</div>
<div id="info-retrieve" style="display:none;" class="ui-body-c">
    <p align="center"><b><?=_('Retrieving images from DICOM modality...')?></b></p>
    <p><img src="libs/images/ajax-loader.gif" alt="" /></p>
</div>
<div id="dialog" style="display:none"></div>
<div id="template-insecure" style="display:none">
    <div class="warning-insecure ui-body ui-body-e">
        <h1><?=_('Insecure setup')?></h1>
        <p><?=_('Your Orthanc server is accepting remote connections, but is using the default username and password, or has user authentication explicitly turned off. Please carefully read your logs and review your configuration, especially options')?>
            <tt>RemoteAccessAllowed</tt>,
            <tt>AuthenticationEnabled</tt>, <?=_('and')?> <tt>RegisteredUsers</tt>.
        </p>
    </div>
</div>
<?php
include("includes/footer.php");
?>
<script>
// * new function added to original Orthanc's STARTS here *
function updateLang() {
    var e = document.getElementById("language");
    var cookieValue = e.options[e.selectedIndex].value;
    // write the cookie and reload the explorer
    document.cookie = "NG_TRANSLATE_LANG_KEY" + "=" + cookieValue + ";" + ";path=/";
    window.location.reload();
    return false;
}
// * new function added to original Orthanc's ENDS here *
// * original Orthanc's explorer.js STARTS here *
// http://stackoverflow.com/questions/1663741/is-there-a-good-jquery-drag-and-drop-file-upload-plugin
// Forbid the access to IE
if ($.browser.msie) {
    alert('<?=_("Please use Mozilla Firefox or Google Chrome. Microsoft Internet Explorer is not supported.")?>');
}
// http://jquerymobile.com/demos/1.1.0/docs/api/globalconfig.html
//$.mobile.ajaxEnabled = false;
//$.mobile.page.prototype.options.addBackBtn = true;
//$.mobile.defaultPageTransition = 'slide';
var LIMIT_RESOURCES = 100;
var currentPage = '';
var currentUuid = '';
function DeepCopy(obj) {
    return jQuery.extend(true, {}, obj);
}
function ChangePage(page, options) {
    var first = true;
    var value;
    if (options) {
        for (var key in options) {
            value = options[key];
            if (first) {
                page += '?';
                first = false;
            } else {
                page += '&';
            }
            page += key + '=' + value;
        }
    }
    // Translator's comment - link changed from explorer.html to explorer.php
    window.location.replace('explorer.php#' + page);
    /*$.mobile.changePage('#' + page, {
      changeHash: true
    });*/
}
function Refresh() {
    if (currentPage == 'patient')
        RefreshPatient();
    else if (currentPage == 'study')
        RefreshStudy();
    else if (currentPage == 'series')
        RefreshSeries();
    else if (currentPage == 'instance')
        RefreshInstance();
}
$(document).ready(function() {
    var $tree = $('#dicom-tree');
    $tree.tree({
        autoEscape: false
    });
    $('#dicom-tree').bind(
        'tree.click',
        function(event) {
            if (event.node.is_open)
                $tree.tree('closeNode', event.node, true);
            else
                $tree.tree('openNode', event.node, true);
        }
    );
    // Inject the template of the warning about insecure setup as the
    // first child of each page
    var insecure = $('#template-insecure').html();
    $('[data-role="page"]>[data-role="content"]').prepend(insecure);
    currentPage = $.mobile.pageData.active;
    currentUuid = $.mobile.pageData.uuid;
    if (!(typeof currentPage === 'undefined') &&
        !(typeof currentUuid === 'undefined') &&
        currentPage.length > 0 &&
        currentUuid.length > 0) {
        Refresh();
    }
});
function GetAuthorizationTokensFromUrl() {
    var urlVariables = window.location.search.substring(1).split('&');
    var dict = {};
    for (var i = 0; i < urlVariables.length; i++) {
        var split = urlVariables[i].split('=');
        if (split.length == 2 && (split[0] == "token" || split[0] == "auth-token" || split[0] == "authorization")) {
            dict[split[0]] = split[1];
        }
    }
    return dict;
};
var authorizationTokens = GetAuthorizationTokensFromUrl();
/* Copy the authoziation toekn from the url search parameters into HTTP headers in every request to the Rest API.  
Thanks to this behaviour, you may specify a ?token=xxx in your url and this will be passed 
as the "token" header in every request to the API allowing you to use the authorization plugin */
$.ajaxSetup({
    headers: authorizationTokens
});
function SplitLongUid(s) {
    return '<span>' + s.substr(0, s.length / 2) + '</span> <span>' + s.substr(s.length / 2, s.length - s.length /
        2) + '</span>';
}
function ParseDicomDate(s) {
    y = parseInt(s.substr(0, 4), 10);
    m = parseInt(s.substr(4, 2), 10) - 1;
    d = parseInt(s.substr(6, 2), 10);
    if (y == null || m == null || d == null ||
        !isFinite(y) || !isFinite(m) || !isFinite(d)) {
        return null;
    }
    if (y < 1900 || y > 2100 ||
        m < 0 || m >= 12 ||
        d <= 0 || d >= 32) {
        return null;
    }
    return new Date(y, m, d);
}
function FormatDicomDate(s) {
    if (s == undefined)
        return "No date";
    var d = ParseDicomDate(s);
    if (d == null)
        return '?';
    else
        return d.toString('dddd, MMMM d, yyyy');
}
function Sort(arr, fieldExtractor, isInteger, reverse) {
    var defaultValue;
    if (isInteger)
        defaultValue = 0;
    else
        defaultValue = '';
    arr.sort(function(a, b) {
        var ta = fieldExtractor(a);
        var tb = fieldExtractor(b);
        var order;
        if (ta == undefined)
            ta = defaultValue;
        if (tb == undefined)
            tb = defaultValue;
        if (isInteger) {
            ta = parseInt(ta, 10);
            tb = parseInt(tb, 10);
            order = ta - tb;
        } else {
            if (ta < tb)
                order = -1;
            else if (ta > tb)
                order = 1;
            else
                order = 0;
        }
        if (reverse)
            return -order;
        else
            return order;
    });
}
function SortOnDicomTag(arr, tag, isInteger, reverse) {
    return Sort(arr, function(a) {
        return a.MainDicomTags[tag];
    }, isInteger, reverse);
}
function GetResource(uri, callback) {
    $.ajax({
        url: '..' + uri,
        dataType: 'json',
        async: false,
        cache: false,
        success: function(s) {
            callback(s);
        }
    });
}
function CompleteFormatting(node, link, isReverse, count) {
    if (count != null) {
        node = node.add($('<span>')
            .addClass('ui-li-count')
            .text(count));
    }
    if (link != null) {
        node = $('<a>').attr('href', link).append(node);
        if (isReverse)
            node.attr('data-direction', 'reverse')
    }
    node = $('<li>').append(node);
    if (isReverse)
        node.attr('data-icon', 'back');
    return node;
}
function FormatMainDicomTags(target, tags, tagsToIgnore) {
    var v;
    for (var i in tags) {
        if (tagsToIgnore.indexOf(i) == -1) {
            v = tags[i];
            if (i == "PatientBirthDate" ||
                i == "StudyDate" ||
                i == "SeriesDate") {
                v = FormatDicomDate(v);
            } else if (i == "DicomStudyInstanceUID" ||
                i == "DicomSeriesInstanceUID") {
                v = SplitLongUid(v);
            }
            target.append($('<p>')
                .text(i + ': ')
                .append($('<strong>').text(v)));
        }
    }
}
function FormatPatient(patient, link, isReverse) {
    var node = $('<div>').append($('<h3>').text(patient.MainDicomTags.PatientName));
    FormatMainDicomTags(node, patient.MainDicomTags, [
        "PatientName"
        // "OtherPatientIDs"
    ]);
    return CompleteFormatting(node, link, isReverse, patient.Studies.length);
}
function FormatStudy(study, link, isReverse, includePatient) {
    var label;
    var node;
    if (includePatient) {
        label = study.Label;
    } else {
        label = study.MainDicomTags.StudyDescription;
    }
    node = $('<div>').append($('<h3>').text(label));
    if (includePatient) {
        FormatMainDicomTags(node, study.PatientMainDicomTags, [
            'PatientName'
        ]);
    }
    FormatMainDicomTags(node, study.MainDicomTags, [
        'StudyDescription',
        'StudyTime'
    ]);
    return CompleteFormatting(node, link, isReverse, study.Series.length);
}
function FormatSeries(series, link, isReverse) {
    var c;
    var node;
    if (series.ExpectedNumberOfInstances == null ||
        series.Instances.length == series.ExpectedNumberOfInstances) {
        c = series.Instances.length;
    } else {
        c = series.Instances.length + '/' + series.ExpectedNumberOfInstances;
    }
    node = $('<div>')
        .append($('<h3>').text(series.MainDicomTags.SeriesDescription))
        .append($('<p>').append($('<em>')
            .text('<?=_("Status: ")?>')
            .append($('<strong>').text(series.Status))));
    FormatMainDicomTags(node, series.MainDicomTags, [
        "SeriesDescription",
        "SeriesTime",
        "Manufacturer",
        "ImagesInAcquisition",
        "SeriesDate",
        "ImageOrientationPatient"
    ]);
    return CompleteFormatting(node, link, isReverse, c);
}
function FormatInstance(instance, link, isReverse) {
    var node = $('<div>').append($('<h3>').text('<?=_("Instance: ")?>' + instance.IndexInSeries));
    FormatMainDicomTags(node, instance.MainDicomTags, [
        "AcquisitionNumber",
        "InstanceNumber",
        "InstanceCreationDate",
        "InstanceCreationTime",
        "ImagePositionPatient"
    ]);
    return CompleteFormatting(node, link, isReverse);
}
$('[data-role="page"]').live('pagebeforeshow', function() {
    $.ajax({
        url: '../system',
        dataType: 'json',
        async: false,
        cache: false,
        success: function(s) {
            if (s.Name != "") {
                $('.orthanc-name').html($('<a>')
                    .addClass('ui-link')
                    // Translator's comment - link changed from explorer.html to explorer.php
                    .attr('href', 'explorer.php')
                    .text(s.Name)
                    .append(' &raquo; '));
            }
            // New in Orthanc 1.5.8
            if ('IsHttpServerSecure' in s &&
                !s.IsHttpServerSecure) {
                $('.warning-insecure').show();
            } else {
                $('.warning-insecure').hide();
            }
        }
    });
});
$('#lookup').live('pagebeforeshow', function() {
    // NB: "GenerateDicomDate()" is defined in "query-retrieve.js"
    var target = $('#lookup-study-date');
    $('option', target).remove();
    target.append($('<option>').attr('value', '*').text('<?=_("Any date")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(0)).text('<?=_("Today")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(-1)).text('<?=_("Yesterday")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(-7) + '-').text('<?=_("Last 7 days")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(-31) + '-').text('<?=_("Last 31 days")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(-31 * 3) + '-').text(
        '<?=_("Last 3 months")?>'));
    target.append($('<option>').attr('value', GenerateDicomDate(-365) + '-').text('<?=_("Last year")?>'));
    target.selectmenu('refresh');
    $('#lookup-result').hide();
});
$('#lookup-submit').live('click', function() {
    var lookup;
    $('#lookup-result').hide();
    lookup = {
        'Level': 'Study',
        'Expand': true,
        'Limit': LIMIT_RESOURCES + 1,
        'Query': {
            'StudyDate': $('#lookup-study-date').val()
        }
    };
    $('#lookup-form input').each(function(index, input) {
        if (input.value.length != 0) {
            if (input.id == 'lookup-patient-id') {
                lookup['Query']['PatientID'] = input.value;
            } else if (input.id == 'lookup-patient-name') {
                lookup['Query']['PatientName'] = input.value;
            } else if (input.id == 'lookup-accession-number') {
                lookup['Query']['AccessionNumber'] = input.value;
            } else if (input.id == 'lookup-study-description') {
                lookup['Query']['StudyDescription'] = input.value;
            } else {
                console.error('Unknown lookup field: ' + input.id);
            }
        }
    });
    $.ajax({
        url: '../tools/find',
        type: 'POST',
        data: JSON.stringify(lookup),
        dataType: 'json',
        async: false,
        error: function() {
            alert('<?=_("Error during lookup")?>');
        },
        success: function(studies) {
            FormatListOfStudies('#lookup-result ul', '#lookup-alert', '#lookup-count', studies);
            $('#lookup-result').show();
        }
    });
    return false;
});
$('#find-patients').live('pagebeforeshow', function() {
    GetResource('/patients?expand&since=0&limit=' + (LIMIT_RESOURCES + 1), function(patients) {
        var target = $('#all-patients');
        var count, showAlert, p;
        $('li', target).remove();
        SortOnDicomTag(patients, 'PatientName', false, false);
        if (patients.length <= LIMIT_RESOURCES) {
            count = patients.length;
            showAlert = false;
        } else {
            count = LIMIT_RESOURCES;
            showAlert = true;
        }
        for (var i = 0; i < count; i++) {
            p = FormatPatient(patients[i], '#patient?uuid=' + patients[i].ID);
            target.append(p);
        }
        target.listview('refresh');
        if (showAlert) {
            $('#count-patients').text(LIMIT_RESOURCES);
            $('#alert-patients').show();
        } else {
            $('#alert-patients').hide();
        }
    });
});
function FormatListOfStudies(targetId, alertId, countId, studies) {
    var target = $(targetId);
    var patient, study, s;
    var count, showAlert;
    $('li', target).remove();
    for (var i = 0; i < studies.length; i++) {
        patient = studies[i].PatientMainDicomTags.PatientName;
        study = studies[i].MainDicomTags.StudyDescription;
        s = "";
        if (typeof patient === 'string') {
            s = patient;
        }
        if (typeof study === 'string') {
            if (s.length > 0) {
                s += ' - ';
            }
            s += study;
        }
        studies[i]['Label'] = s;
    }
    Sort(studies, function(a) {
        return a.Label
    }, false, false);
    if (studies.length <= LIMIT_RESOURCES) {
        count = studies.length;
        showAlert = false;
    } else {
        count = LIMIT_RESOURCES;
        showAlert = true;
    }
    for (var i = 0; i < count; i++) {
        s = FormatStudy(studies[i], '#study?uuid=' + studies[i].ID, false, true);
        target.append(s);
    }
    target.listview('refresh');
    if (showAlert) {
        $(countId).text(LIMIT_RESOURCES);
        $(alertId).show();
    } else {
        $(alertId).hide();
    }
}
$('#find-studies').live('pagebeforeshow', function() {
    GetResource('/studies?expand&since=0&limit=' + (LIMIT_RESOURCES + 1), function(studies) {
        FormatListOfStudies('#all-studies', '#alert-studies', '#count-studies', studies);
    });
});
function SetupAnonymizedOrModifiedFrom(buttonSelector, resource, resourceType, field) {
    if (field in resource) {
        $(buttonSelector).closest('li').show();
        $(buttonSelector).click(function(e) {
            // Translator's comment - link changed from explorer.html to explorer.php
            window.location.assign('explorer.php#' + resourceType + '?uuid=' + resource[field]);
        });
    } else {
        $(buttonSelector).closest('li').hide();
    }
}
function RefreshPatient() {
    var pageData, target, v;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        GetResource('/patients/' + pageData.uuid, function(patient) {
            GetResource('/patients/' + pageData.uuid + '/studies', function(studies) {
                SortOnDicomTag(studies, 'StudyDate', false, true);
                $('#patient-info li').remove();
                $('#patient-info')
                    .append('<li data-role="list-divider"><?=_("Patient")?></li>')
                    .append(FormatPatient(patient))
                    .listview('refresh');
                target = $('#list-studies');
                $('li', target).remove();
                for (var i = 0; i < studies.length; i++) {
                    if (i == 0 || studies[i].MainDicomTags.StudyDate != studies[i - 1].MainDicomTags
                        .StudyDate) {
                        target.append($('<li>')
                            .attr('data-role', 'list-divider')
                            .text(FormatDicomDate(studies[i].MainDicomTags.StudyDate)));
                    }
                    target.append(FormatStudy(studies[i], '#study?uuid=' + studies[i].ID));
                }
                SetupAnonymizedOrModifiedFrom('#patient-anonymized-from', patient, 'patient',
                    'AnonymizedFrom');
                SetupAnonymizedOrModifiedFrom('#patient-modified-from', patient, 'patient',
                    'ModifiedFrom');
                target.listview('refresh');
                // Check whether this patient is protected
                $.ajax({
                    url: '../patients/' + pageData.uuid + '/protected',
                    type: 'GET',
                    dataType: 'text',
                    async: false,
                    cache: false,
                    success: function(s) {
                        v = (s == '1') ? 'on' : 'off';
                        $('#protection').val(v).slider('refresh');
                    }
                });
                currentPage = 'patient';
                currentUuid = pageData.uuid;
            });
        });
    }
}
function RefreshStudy() {
    var pageData, target;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        GetResource('/studies/' + pageData.uuid, function(study) {
            GetResource('/patients/' + study.ParentPatient, function(patient) {
                GetResource('/studies/' + pageData.uuid + '/series', function(series) {
                    SortOnDicomTag(series, 'SeriesDate', false, true);
                    $('#study .patient-link').attr('href', '#patient?uuid=' + patient.ID);
                    $('#study-info li').remove();
                    $('#study-info')
                        .append('<li data-role="list-divider"><?=_("Patient")?></li>')
                        .append(FormatPatient(patient, '#patient?uuid=' + patient.ID, true))
                        .append('<li data-role="list-divider"><?=_("Study")?></li>')
                        .append(FormatStudy(study))
                        .listview('refresh');
                    SetupAnonymizedOrModifiedFrom('#study-anonymized-from', study, 'study',
                        'AnonymizedFrom');
                    SetupAnonymizedOrModifiedFrom('#study-modified-from', study, 'study',
                        'ModifiedFrom');
                    target = $('#list-series');
                    $('li', target).remove();
                    for (var i = 0; i < series.length; i++) {
                        if (i == 0 || series[i].MainDicomTags.SeriesDate != series[i - 1]
                            .MainDicomTags.SeriesDate) {
                            target.append($('<li>')
                                .attr('data-role', 'list-divider')
                                .text(FormatDicomDate(series[i].MainDicomTags
                                    .SeriesDate)));
                        }
                        target.append(FormatSeries(series[i], '#series?uuid=' + series[i]
                            .ID));
                    }
                    target.listview('refresh');
                    currentPage = 'study';
                    currentUuid = pageData.uuid;
                });
            });
        });
    }
}
function RefreshSeries() {
    var pageData, target;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        GetResource('/series/' + pageData.uuid, function(series) {
            GetResource('/studies/' + series.ParentStudy, function(study) {
                GetResource('/patients/' + study.ParentPatient, function(patient) {
                    GetResource('/series/' + pageData.uuid + '/instances', function(
                        instances) {
                        Sort(instances, function(x) {
                            return x.IndexInSeries;
                        }, true, false);
                        $('#series .patient-link').attr('href', '#patient?uuid=' +
                            patient.ID);
                        $('#series .study-link').attr('href', '#study?uuid=' + study
                            .ID);
                        $('#series-info li').remove();
                        $('#series-info')
                            .append(
                                '<li data-role="list-divider"><?=_("Patient")?></li>'
                            )
                            .append(FormatPatient(patient, '#patient?uuid=' +
                                patient.ID, true))
                            .append(
                                '<li data-role="list-divider"><?=_("Study")?></li>')
                            .append(FormatStudy(study, '#study?uuid=' + study.ID,
                                true))
                            .append(
                                '<li data-role="list-divider"><?=_("Series")?></li>'
                            )
                            .append(FormatSeries(series))
                            .listview('refresh');
                        SetupAnonymizedOrModifiedFrom('#series-anonymized-from',
                            series, 'series', 'AnonymizedFrom');
                        SetupAnonymizedOrModifiedFrom('#series-modified-from',
                            series, 'series', 'ModifiedFrom');
                        target = $('#list-instances');
                        $('li', target).remove();
                        for (var i = 0; i < instances.length; i++) {
                            target.append(FormatInstance(instances[i],
                                '#instance?uuid=' + instances[i].ID));
                        }
                        target.listview('refresh');
                        currentPage = 'series';
                        currentUuid = pageData.uuid;
                    });
                });
            });
        });
    }
}
function EscapeHtml(value) {
    var ENTITY_MAP = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
    };
    return String(value).replace(/[&<>"'`=\/]/g, function(s) {
        return ENTITY_MAP[s];
    });
}
function ConvertForTree(dicom) {
    var result = [];
    var label, c;
    for (var i in dicom) {
        if (dicom[i] != null) {
            label = (i + '<span class="tag-name"> (<i>' +
                EscapeHtml(dicom[i]["Name"]) +
                '</i>)</span>: ');
            if (dicom[i]["Type"] == 'String') {
                result.push({
                    label: label + '<strong>' + EscapeHtml(dicom[i]["Value"]) + '</strong>',
                    children: []
                });
            } else if (dicom[i]["Type"] == 'TooLong') {
                result.push({
                    label: label + '<i>Too long</i>',
                    children: []
                });
            } else if (dicom[i]["Type"] == 'Null') {
                result.push({
                    label: label + '<i>Null</i>',
                    children: []
                });
            } else if (dicom[i]["Type"] == 'Sequence') {
                c = [];
                for (var j = 0; j < dicom[i]["Value"].length; j++) {
                    c.push({
                        label: 'Item ' + j,
                        children: ConvertForTree(dicom[i]["Value"][j])
                    });
                }
                result.push({
                    label: label + '[]',
                    children: c
                });
            }
        }
    }
    return result;
}
function RefreshInstance() {
    var pageData;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        GetResource('/instances/' + pageData.uuid, function(instance) {
            GetResource('/series/' + instance.ParentSeries, function(series) {
                GetResource('/studies/' + series.ParentStudy, function(study) {
                    GetResource('/patients/' + study.ParentPatient, function(patient) {
                        $('#instance .patient-link').attr('href', '#patient?uuid=' +
                            patient.ID);
                        $('#instance .study-link').attr('href', '#study?uuid=' +
                            study.ID);
                        $('#instance .series-link').attr('href', '#series?uuid=' +
                            series.ID);
                        $('#instance-info li').remove();
                        $('#instance-info')
                            .append(
                                '<li data-role="list-divider"><?=_("Patient")?></li>'
                            )
                            .append(FormatPatient(patient, '#patient?uuid=' +
                                patient.ID, true))
                            .append(
                                '<li data-role="list-divider"><?=_("Study")?></li>')
                            .append(FormatStudy(study, '#study?uuid=' + study.ID,
                                true))
                            .append(
                                '<li data-role="list-divider"><?=_("Series")?></li>'
                            )
                            .append(FormatSeries(series, '#series?uuid=' + series
                                .ID, true))
                            .append(
                                '<li data-role="list-divider"><?=_("Instance")?></li>'
                            )
                            .append(FormatInstance(instance))
                            .listview('refresh');
                        GetResource('/instances/' + instance.ID + '/tags', function(
                            s) {
                            $('#dicom-tree').tree('loadData',
                                ConvertForTree(s));
                        });
                        SetupAnonymizedOrModifiedFrom('#instance-anonymized-from',
                            instance, 'instance', 'AnonymizedFrom');
                        SetupAnonymizedOrModifiedFrom('#instance-modified-from',
                            instance, 'instance', 'ModifiedFrom');
                        currentPage = 'instance';
                        currentUuid = pageData.uuid;
                    });
                });
            });
        });
    }
}
$(document).live('pagebeforehide', function() {
    currentPage = '';
    currentUuid = '';
});
$('#patient').live('pagebeforeshow', RefreshPatient);
$('#study').live('pagebeforeshow', RefreshStudy);
$('#series').live('pagebeforeshow', RefreshSeries);
$('#instance').live('pagebeforeshow', RefreshInstance);
$(function() {
    $(window).hashchange(function(e, data) {
        // This fixes the navigation with the back button and with the anonymization
        if ('uuid' in $.mobile.pageData &&
            currentPage == $.mobile.pageData.active &&
            currentUuid != $.mobile.pageData.uuid) {
            Refresh();
        }
    });
});
// Added by Ludwig Moreno
// Esto esta funcionando****
function OpenLogoutDialog(title) {
    $(document).simpledialog2({
        mode: 'button',
        animate: false,
        headerText: title,
        headerClose: true,
        width: '80%',
        buttons: {
            '<?=_("OK")?>': {
                click: function() {
                    window.location = "libs/php/cerrar.php";
                },
                icon: "delete",
                theme: "c"
            },
            '<?=_("Cancel")?>': {
                click: function() {}
            }
        }
    });
}
$('#logout').live('click', function() {
    OpenLogoutDialog('<?=_("¿Do you want to leave the DICOM Explorer?")?>');
});
function OpenUploadReportDialog(path) {
    document.location.href = "libs/php/pdf2orthanc.php?" + path
    // window.open("libs/php/pdf2orthanc.php?" + path, "", "width=340,height=440")
    //window.location = "https://misimagenes.online/ngl/app/pdf2orthanc.php?" + path;
};
$('#upload-report').live('click', function() {
    OpenUploadReportDialog($.mobile.pageData.uuid);
});
function OpenUploadImageDialog(path) {
    document.location.href = "libs/php/img2orthanc.php?" + path
    //  window.location = "https://misimagenes.online/ngl/app/img2orthanc.php?" + path;
};
$('#upload-picture').live('click', function() {
    OpenUploadImageDialog('patient=' + $.mobile.pageData.uuid);
});
function OpenUploadImageSDialog(path) {
    document.location.href = "libs/php/img2orthanc.php?" + path
    //  window.location = "https://misimagenes.online/ngl/app/img2orthanc.php?" + path;
};
$('#upload-picture2').live('click', function() {
    OpenUploadImageSDialog('study=' + $.mobile.pageData.uuid);
});
// End of added by Ludwig Moreno
function DeleteResource(path) {
    $.ajax({
        url: path,
        type: 'DELETE',
        dataType: 'json',
        async: false,
        success: function(s) {
            var ancestor = s.RemainingAncestor;
            if (ancestor == null)
                $.mobile.changePage('#lookup');
            else
                $.mobile.changePage('#' + ancestor.Type.toLowerCase() + '?uuid=' + ancestor.ID);
        }
    });
}
function OpenDeleteResourceDialog(path, title) {
    $(document).simpledialog2({
        // http://dev.jtsage.com/jQM-SimpleDialog/demos2/
        // http://dev.jtsage.com/jQM-SimpleDialog/demos2/options.html
        mode: 'button',
        animate: false,
        headerText: title,
        headerClose: true,
        width: '500px',
        buttons: {
            '<?=_("OK")?>': {
                click: function() {
                    DeleteResource(path);
                },
                icon: "delete",
                theme: "c"
            },
            '<?=_("Cancel")?>': {
                click: function() {}
            }
        }
    });
}
$('#instance-delete').live('click', function() {
    OpenDeleteResourceDialog('../instances/' + $.mobile.pageData.uuid,
        '<?=_("Delete this instance?")?>');
});
$('#study-delete').live('click', function() {
    OpenDeleteResourceDialog('../studies/' + $.mobile.pageData.uuid,
        '<?=_("Delete this study?")?>');
});
$('#series-delete').live('click', function() {
    OpenDeleteResourceDialog('../series/' + $.mobile.pageData.uuid,
        '<?=_("Delete this series?")?>');
});
$('#patient-delete').live('click', function() {
    OpenDeleteResourceDialog('../patients/' + $.mobile.pageData.uuid,
        '<?=_("Delete this patient?")?>');
});
$('#instance-download-dicom').live('click', function(e) {
    // http://stackoverflow.com/a/1296101
    e.preventDefault(); //stop the browser from following
    window.location.href = '../instances/' + $.mobile.pageData.uuid + '/file';
});
$('#instance-download-json').live('click', function(e) {
    // http://stackoverflow.com/a/1296101
    e.preventDefault(); //stop the browser from following
    window.location.href = '../instances/' + $.mobile.pageData.uuid + '/tags';
});
$('#instance-preview').live('click', function(e) {
    var pageData, pdf, images;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        pdf = '../instances/' + pageData.uuid + '/pdf';
        $.ajax({
            url: pdf,
            cache: false,
            success: function(s) {
                window.location.assign(pdf);
            },
            error: function() {
                GetResource('/instances/' + pageData.uuid + '/frames', function(frames) {
                    if (frames.length == 1) {
                        // Viewing a single-frame image
                        jQuery.slimbox('../instances/' + pageData.uuid + '/preview',
                            '', {
                                overlayFadeDuration: 1,
                                resizeDuration: 1,
                                imageFadeDuration: 1
                            });
                    } else {
                        // Viewing a multi-frame image
                        images = [];
                        for (var i = 0; i < frames.length; i++) {
                            images.push(['../instances/' + pageData.uuid + '/frames/' +
                                i + '/preview'
                            ]);
                        }
                        jQuery.slimbox(images, 0, {
                            overlayFadeDuration: 1,
                            resizeDuration: 1,
                            imageFadeDuration: 1,
                            loop: true
                        });
                    }
                });
            }
        });
    }
});
$('#series-preview').live('click', function(e) {
    var pageData, images;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        GetResource('/series/' + pageData.uuid, function(series) {
            GetResource('/series/' + pageData.uuid + '/instances', function(instances) {
                Sort(instances, function(x) {
                    return x.IndexInSeries;
                }, true, false);
                images = [];
                for (var i = 0; i < instances.length; i++) {
                    images.push(['../instances/' + instances[i].ID + '/preview',
                        (i + 1).toString() + '/' + instances.length.toString()
                    ])
                }
                jQuery.slimbox(images, 0, {
                    overlayFadeDuration: 1,
                    resizeDuration: 1,
                    imageFadeDuration: 1,
                    loop: true
                });
            });
        });
    }
});
function ChooseDicomModality(callback) {
    var clickedModality = '';
    var clickedPeer = '';
    var items = $('<ul>')
        .attr('data-divider-theme', 'd')
        .attr('data-role', 'listview');
    // Retrieve the list of the known DICOM modalities
    $.ajax({
        url: '../modalities',
        type: 'GET',
        dataType: 'json',
        async: false,
        cache: false,
        success: function(modalities) {
            var name, item;
            if (modalities.length > 0) {
                items.append('<li data-role="list-divider"><?=_("DICOM modalities")?></li>');
                for (var i = 0; i < modalities.length; i++) {
                    name = modalities[i];
                    item = $('<li>')
                        .html('<a href="#" rel="close">' + name + '</a>')
                        .attr('name', name)
                        .click(function() {
                            clickedModality = $(this).attr('name');
                        });
                    items.append(item);
                }
            }
            // Retrieve the list of the known Orthanc peers
            $.ajax({
                url: '../peers',
                type: 'GET',
                dataType: 'json',
                async: false,
                cache: false,
                success: function(peers) {
                    var name, item;
                    if (peers.length > 0) {
                        items.append(
                            '<li data-role="list-divider"><?=_("Orthanc peers")?></li>');
                        for (var i = 0; i < peers.length; i++) {
                            name = peers[i];
                            item = $('<li>')
                                .html('<a href="#" rel="close">' + name + '</a>')
                                .attr('name', name)
                                .click(function() {
                                    clickedPeer = $(this).attr('name');
                                });
                            items.append(item);
                        }
                    }
                    // Launch the dialog
                    $('#dialog').simpledialog2({
                        mode: 'blank',
                        animate: false,
                        headerText: '<?=_("Choose target")?>',
                        headerClose: true,
                        forceInput: false,
                        width: '100%',
                        blankContent: items,
                        callbackClose: function() {
                            var timer;
                            function WaitForDialogToClose() {
                                if (!$('#dialog').is(':visible')) {
                                    clearInterval(timer);
                                    callback(clickedModality, clickedPeer);
                                }
                            }
                            timer = setInterval(WaitForDialogToClose, 100);
                        }
                    });
                }
            });
        }
    });
}
$('#instance-store,#series-store,#study-store,#patient-store').live('click', function(e) {
    ChooseDicomModality(function(modality, peer) {
        var pageData = DeepCopy($.mobile.pageData);
        var url, loading;
        if (modality != '') {
            url = '../modalities/' + modality + '/store';
            loading = '#dicom-store';
        }
        if (peer != '') {
            url = '../peers/' + peer + '/store';
            loading = '#peer-store';
        }
        if (url != '') {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'text',
                data: pageData.uuid,
                async: true, // Necessary to block UI
                beforeSend: function() {
                    $.blockUI({
                        message: $(loading)
                    });
                },
                complete: function(s) {
                    $.unblockUI();
                },
                success: function(s) {},
                error: function() {
                    alert('<?=_("Error during store")?>');
                }
            });
        }
    });
});
$('#show-tag-name').live('change', function(e) {
    var checked = e.currentTarget.checked;
    if (checked)
        $('.tag-name').show();
    else
        $('.tag-name').hide();
});
$('#patient-archive').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../patients/' + $.mobile.pageData.uuid + '/archive';
});
$('#study-archive').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../studies/' + $.mobile.pageData.uuid + '/archive';
});
$('#series-archive').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../series/' + $.mobile.pageData.uuid + '/archive';
});
$('#patient-media').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../patients/' + $.mobile.pageData.uuid + '/media';
});
$('#study-media').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../studies/' + $.mobile.pageData.uuid + '/media';
});
$('#series-media').live('click', function(e) {
    e.preventDefault(); //stop the browser from following
    window.location.href = '../series/' + $.mobile.pageData.uuid + '/media';
});
$('#protection').live('change', function(e) {
    var isProtected = e.target.value == "on";
    $.ajax({
        url: '../patients/' + $.mobile.pageData.uuid + '/protected',
        type: 'PUT',
        dataType: 'text',
        data: isProtected ? '1' : '0',
        async: false
    });
});
function OpenAnonymizeResourceDialog(path, title) {
    $(document).simpledialog2({
        mode: 'button',
        animate: false,
        headerText: title,
        headerClose: true,
        width: '500px',
        buttons: {
            '<?=_("OK")?>': {
                click: function() {
                    $.ajax({
                        url: path + '/anonymize',
                        type: 'POST',
                        data: '{ "Keep" : [ "SeriesDescription", "StudyDescription" ] }',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        success: function(s) {
                            // The following line does not work...
                            //$.mobile.changePage('explorer.html#patient?uuid=' + s.PatientID);
                            // Translator's comment - link changed from explorer.html to explorer.php
                            window.location.assign('explorer.php#patient?uuid=' + s
                                .PatientID);
                            //window.location.reload();
                        }
                    });
                },
                icon: "delete",
                theme: "c"
            },
            '<?=_("Cancel")?>': {
                click: function() {}
            }
        }
    });
}
$('#instance-anonymize').live('click', function() {
    OpenAnonymizeResourceDialog('../instances/' + $.mobile.pageData.uuid,
        '<?=_("Anonymize this instance?")?>');
});
$('#study-anonymize').live('click', function() {
    OpenAnonymizeResourceDialog('../studies/' + $.mobile.pageData.uuid,
        '<?=_("Anonymize this study?")?>');
});
$('#series-anonymize').live('click', function() {
    OpenAnonymizeResourceDialog('../series/' + $.mobile.pageData.uuid,
        '<?=_("Anonymize this series?")?>');
});
$('#patient-anonymize').live('click', function() {
    OpenAnonymizeResourceDialog('../patients/' + $.mobile.pageData.uuid,
        '<?=_("Anonymize this patient?")?>');
});
$('#plugins').live('pagebeforeshow', function() {
    $.ajax({
        url: '../plugins',
        dataType: 'json',
        async: false,
        cache: false,
        success: function(plugins) {
            var target = $('#all-plugins');
            $('li', target).remove();
            plugins.map(function(id) {
                return $.ajax({
                    url: '../plugins/' + id,
                    dataType: 'json',
                    async: false,
                    cache: false,
                    success: function(plugin) {
                        var li = $('<li>');
                        var item = li;
                        if ('RootUri' in plugin) {
                            item = $('<a>');
                            li.append(item);
                            item.click(function() {
                                window.open(plugin.RootUri);
                            });
                        }
                        item.append($('<h1>').text(plugin.ID));
                        item.append($('<p>').text(plugin.Description));
                        item.append($('<span>').addClass('ui-li-count')
                            .text(plugin.Version));
                        target.append(li);
                    }
                });
            });
            target.listview('refresh');
        }
    });
});
function ParseJobTime(s) {
    var t = (s.substr(0, 4) + '-' +
        s.substr(4, 2) + '-' +
        s.substr(6, 5) + ':' +
        s.substr(11, 2) + ':' +
        s.substr(13));
    var utc = new Date(t);
    // Convert from UTC to local time
    return new Date(utc.getTime() - utc.getTimezoneOffset() * 60000);
}
function AddJobField(target, description, field) {
    if (!(typeof field === 'undefined')) {
        target.append($('<p>')
            .text(description)
            .append($('<strong>').text(field)));
    }
}
function AddJobDateField(target, description, field) {
    if (!(typeof field === 'undefined')) {
        target.append($('<p>')
            .text(description)
            .append($('<strong>').text(ParseJobTime(field))));
    }
}
$('#jobs').live('pagebeforeshow', function() {
    $.ajax({
        url: '../jobs?expand',
        dataType: 'json',
        async: false,
        cache: false,
        success: function(jobs) {
            var target = $('#all-jobs');
            var running, pending, inactive;
            $('li', target).remove();
            running = $('<li>')
                .attr('data-role', 'list-divider')
                .text('<?=_("Currently running")?>');
            pending = $('<li>')
                .attr('data-role', 'list-divider')
                .text('<?=_("Pending jobs")?>');
            inactive = $('<li>')
                .attr('data-role', 'list-divider')
                .text('<?=_("Inactive jobs")?>');
            target.append(running);
            target.append(pending);
            target.append(inactive);
            jobs.map(function(job) {
                var li = $('<li>');
                var item = $('<a>');
                li.append(item);
                item.attr('href', '#job?uuid=' + job.ID);
                item.append($('<h1>').text(job.Type));
                item.append($('<span>').addClass('ui-li-count').text(job.State));
                AddJobField(item, '<?=_("ID: ")?>', job.ID);
                AddJobField(item, '<?=_("Local AET: ")?>', job.Content.LocalAet);
                AddJobField(item, '<?=_("Remote AET: ")?>', job.Content.RemoteAet);
                AddJobDateField(item, '<?=_("Creation time: ")?>', job.CreationTime);
                AddJobDateField(item, '<?=_("Completion time: ")?>', job
                    .CompletionTime);
                AddJobDateField(item, '<?=_("ETA: ")?>', job.EstimatedTimeOfArrival);
                if (job.State == 'Running' ||
                    job.State == 'Pending' ||
                    job.State == 'Paused') {
                    AddJobField(item, 'Priority: ', job.Priority);
                    AddJobField(item, 'Progress: ', job.Progress);
                }
                if (job.State == 'Running') {
                    li.insertAfter(running);
                } else if (job.State == 'Pending' ||
                    job.State == 'Paused') {
                    li.insertAfter(pending);
                } else {
                    li.insertAfter(inactive);
                }
            });
            target.listview('refresh');
        }
    });
});
$('#job').live('pagebeforeshow', function() {
    var pageData, target;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        $.ajax({
            url: '../jobs/' + pageData.uuid,
            dataType: 'json',
            async: false,
            cache: false,
            success: function(job) {
                var block, value;
                target = $('#job-info');
                $('li', target).remove();
                target.append($('<li>')
                    .attr('data-role', 'list-divider')
                    .text('<?=_("General information about the job")?>')); {
                    block = $('<li>');
                    for (var i in job) {
                        if (i == 'CreationTime' ||
                            i == 'CompletionTime' ||
                            i == 'EstimatedTimeOfArrival') {
                            AddJobDateField(block, i + ': ', job[i]);
                        } else if (i != 'InternalContent' &&
                            i != 'Content' &&
                            i != 'Timestamp') {
                            AddJobField(block, i + ': ', job[i]);
                        }
                    }
                }
                target.append(block);
                target.append($('<li>')
                    .attr('data-role', 'list-divider')
                    .text('<?=_("Detailed information")?>')); {
                    block = $('<li>');
                    for (var item in job.Content) {
                        var value = job.Content[item];
                        if (typeof value !== 'string') {
                            value = JSON.stringify(value);
                        }
                        AddJobField(block, item + ': ', value);
                    }
                }
                target.append(block);
                target.listview('refresh');
                $('#job-cancel').closest('.ui-btn').hide();
                $('#job-resubmit').closest('.ui-btn').hide();
                $('#job-pause').closest('.ui-btn').hide();
                $('#job-resume').closest('.ui-btn').hide();
                if (job.State == 'Running' ||
                    job.State == 'Pending' ||
                    job.State == 'Retry') {
                    $('#job-cancel').closest('.ui-btn').show();
                    $('#job-pause').closest('.ui-btn').show();
                } else if (job.State == 'Success') {} else if (job.State == 'Failure') {
                    $('#job-resubmit').closest('.ui-btn').show();
                } else if (job.State == 'Paused') {
                    $('#job-resume').closest('.ui-btn').show();
                }
            }
        });
    }
});
function TriggerJobAction(action) {
    $.ajax({
        url: '../jobs/' + $.mobile.pageData.uuid + '/' + action,
        type: 'POST',
        async: false,
        cache: false,
        complete: function(s) {
            window.location.reload();
        }
    });
}
$('#job-cancel').live('click', function() {
    TriggerJobAction('cancel');
});
$('#job-resubmit').live('click', function() {
    TriggerJobAction('resubmit');
});
$('#job-pause').live('click', function() {
    TriggerJobAction('pause');
});
$('#job-resume').live('click', function() {
    TriggerJobAction('resume');
});
// * original Orthanc's explorer.js ENDS here *
// ** original Orthanc's query-retrieve.js STARTS here **
function JavascriptDateToDicom(date) {
    var s = date.toISOString();
    return s.substring(0, 4) + s.substring(5, 7) + s.substring(8, 10);
}
function GenerateDicomDate(days) {
    var today = new Date();
    var other = new Date(today);
    other.setDate(today.getDate() + days);
    return JavascriptDateToDicom(other);
}
$('#query-retrieve').live('pagebeforeshow', function() {
    var targetDate;
    $.ajax({
        url: '../modalities',
        dataType: 'json',
        async: false,
        cache: false,
        success: function(modalities) {
            var targetServer = $('#qr-server');
            var option;
            $('option', targetServer).remove();
            for (var i = 0; i < modalities.length; i++) {
                option = $('<option>').text(modalities[i]);
                targetServer.append(option);
            }
            targetServer.selectmenu('refresh');
        }
    });
    targetDate = $('#qr-date');
    $('option', targetDate).remove();
    targetDate.append($('<option>').attr('value', '*').text('<?=_("Any date")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(0)).text('<?=_("Today")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(-1)).text('<?=_("Yesterday")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(-7) + '-').text(
        '<?=_("Last 7 days")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(-31) + '-').text(
        '<?=_("Last 31 days")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(-31 * 3) + '-').text(
        '<?=_("Last 3 months")?>'));
    targetDate.append($('<option>').attr('value', GenerateDicomDate(-365) + '-').text(
        '<?=_("Last year")?>'));
    targetDate.selectmenu('refresh');
});
$('#qr-echo').live('click', function() {
    var server = $('#qr-server').val();
    var message = '<?=_("Error: The C-Echo has failed!")?>';
    $.ajax({
        url: '../modalities/' + server + '/echo',
        type: 'POST',
        cache: false,
        async: false,
        success: function() {
            message = '<?=_("The C-Echo has succeeded!")?>';
        }
    });
    $('<div>').simpledialog2({
        mode: 'button',
        headerText: '<?=_("Echo result")?>',
        headerClose: true,
        buttonPrompt: message,
        animate: false,
        buttons: {
            '<?=_("OK")?>': {
                click: function() {}
            }
        }
    });
    return false;
});
$('#qr-submit').live('click', function() {
    var query, server, modalities, field;
    query = {
        'Level': 'Study',
        'Query': {
            'AccessionNumber': '',
            'PatientBirthDate': '',
            'PatientID': '',
            'PatientName': '',
            'PatientSex': '',
            'StudyDate': $('#qr-date').val(),
            'StudyDescription': '*'
        }
    };
    modalities = '';
    field = $('#qr-fields input:checked').val();
    query['Query'][field] = $('#qr-value').val().toUpperCase();
    $('#qr-modalities input:checked').each(function() {
        var s = $(this).attr('name');
        if (modalities == '')
            modalities = s;
        else
            modalities += '\\' + s;
    });
    if (modalities.length > 0) {
        query['Query']['ModalitiesInStudy'] = modalities;
    }
    server = $('#qr-server').val();
    $.ajax({
        url: '../modalities/' + server + '/query',
        type: 'POST',
        data: JSON.stringify(query),
        dataType: 'json',
        async: false,
        error: function() {
            alert('<?=_("Error during query (C-Find)")?>');
        },
        success: function(result) {
            ChangePage('query-retrieve-2', {
                'server': server,
                'uuid': result['ID']
            });
        }
    });
    return false;
});
$('#query-retrieve-2').live('pagebeforeshow', function() {
    var pageData, uri;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        uri = '../queries/' + pageData.uuid + '/answers';
        $.ajax({
            url: uri,
            dataType: 'json',
            async: false,
            success: function(answers) {
                var target = $('#query-retrieve-2 ul');
                $('li', target).remove();
                for (var i = 0; i < answers.length; i++) {
                    $.ajax({
                        url: uri + '/' + answers[i] + '/content?simplify',
                        dataType: 'json',
                        async: false,
                        success: function(study) {
                            var series = '#query-retrieve-3?server=' + pageData
                                .server + '&uuid=' + study['StudyInstanceUID'];
                            var content = ($('<div>')
                                .append($('<h3>').text(study['PatientID'] +
                                    ' - ' + study['PatientName']))
                                .append($('<p>').text(
                                        '<?=_("Accession number: ")?>')
                                    .append($('<b>').text(study[
                                        'AccessionNumber'])))
                                .append($('<p>').text('<?=_("Birth date: ")?>')
                                    .append($('<b>').text(study[
                                        'PatientBirthDate'])))
                                .append($('<p>').text('<?=_("Patient sex: ")?>')
                                    .append($('<b>').text(study['PatientSex'])))
                                .append($('<p>').text(
                                        '<?=_("Study description: ")?>')
                                    .append($('<b>').text(study[
                                        'StudyDescription'])))
                                .append($('<p>').text('<?=_("Study date: ")?>')
                                    .append($('<b>').text(FormatDicomDate(study[
                                        'StudyDate'])))));
                            var info = $('<a>').attr('href', series).html(content);
                            var answerId = answers[i];
                            var retrieve = $('<a>').text(
                                '<?=_("Retrieve all study")?>').click(
                                function() {
                                    ChangePage('query-retrieve-4', {
                                        'query': pageData.uuid,
                                        'answer': answerId,
                                        'server': pageData.server
                                    });
                                });
                            target.append($('<li>').append(info).append(retrieve));
                        }
                    });
                }
                target.listview('refresh');
            }
        });
    }
});
$('#query-retrieve-3').live('pagebeforeshow', function() {
    var pageData, query;
    if ($.mobile.pageData) {
        pageData = DeepCopy($.mobile.pageData);
        query = {
            'Level': 'Series',
            'Query': {
                'Modality': '*',
                'ProtocolName': '*',
                'SeriesDescription': '*',
                'SeriesInstanceUID': '*',
                'StudyInstanceUID': pageData.uuid
            }
        };
        $.ajax({
            url: '../modalities/' + pageData.server + '/query',
            type: 'POST',
            data: JSON.stringify(query),
            dataType: 'json',
            async: false,
            error: function() {
                alert('<?=_("Error during query (C-Find)")?>');
            },
            success: function(answer) {
                var queryUuid = answer['ID'];
                var uri = '../queries/' + answer['ID'] + '/answers';
                $.ajax({
                    url: uri,
                    dataType: 'json',
                    async: false,
                    success: function(answers) {
                        var target = $('#query-retrieve-3 ul');
                        $('li', target).remove();
                        for (var i = 0; i < answers.length; i++) {
                            $.ajax({
                                url: uri + '/' + answers[i] +
                                    '/content?simplify',
                                dataType: 'json',
                                async: false,
                                success: function(series) {
                                    var content = ($('<div>')
                                        .append($('<h3>').text(
                                            series[
                                                'SeriesDescription'
                                            ]))
                                        .append($('<p>').text(
                                                '<?=_("Modality: ")?>'
                                            )
                                            .append($('<b>').text(
                                                series[
                                                    'Modality']
                                            )))
                                        // missing space in the original file ProtocolName
                                        .append($('<p>').text(
                                                '<?=_("Protocol Name: ")?>'
                                            )
                                            .append($('<b>').text(
                                                series[
                                                    'ProtocolName'
                                                ]))));
                                    var info = $('<a>').html(content);
                                    var answerId = answers[i];
                                    info.click(function() {
                                        ChangePage(
                                            'query-retrieve-4', {
                                                'query': queryUuid,
                                                'study': pageData
                                                    .uuid,
                                                'answer': answerId,
                                                'server': pageData
                                                    .server
                                            });
                                    });
                                    target.append($('<li>').attr(
                                            'data-icon', 'arrow-d')
                                        .append(info));
                                }
                            });
                        }
                        target.listview('refresh');
                    }
                });
            }
        });
    }
});
$('#query-retrieve-4').live('pagebeforeshow', function() {
    var pageData, uri;
    if ($.mobile.pageData) {
        var pageData = DeepCopy($.mobile.pageData);
        var uri = '../queries/' + pageData.query + '/answers/' + pageData.answer + '/retrieve';
        $.ajax({
            url: '../system',
            dataType: 'json',
            async: false,
            cache: false,
            success: function(system) {
                $('#retrieve-target').val(system['DicomAet']);
                $('#retrieve-form').submit(function(event) {
                    var aet;
                    event.preventDefault();
                    aet = $('#retrieve-target').val();
                    if (aet.length == 0) {
                        aet = system['DicomAet'];
                    }
                    $.ajax({
                        url: uri,
                        type: 'POST',
                        async: true, // Necessary to block UI
                        dataType: 'text',
                        data: aet,
                        beforeSend: function() {
                            $.blockUI({
                                message: $('#info-retrieve')
                            });
                        },
                        complete: function(s) {
                            $.unblockUI();
                        },
                        success: function() {
                            if (pageData.study) {
                                // Go back to the list of series
                                ChangePage('query-retrieve-3', {
                                    'server': pageData.server,
                                    'uuid': pageData.study
                                });
                            } else {
                                // Go back to the list of studies
                                ChangePage('query-retrieve-2', {
                                    'server': pageData.server,
                                    'uuid': pageData.query
                                });
                            }
                        },
                        error: function() {
                            alert('<?=_("Error during retrieve")?>');
                        }
                    });
                });
            }
        });
    }
});
// ** original Orthanc's query-retrieve.js ENDS here **
// *** original Orthanc's file-upload.js STARTS here **
var pendingUploads = [];
var currentUpload = 0;
var totalUpload = 0;
var alreadyInitialized = false; // trying to debug Orthanc issue #1
$(document).ready(function() {
    if (alreadyInitialized) {
        console.log("Orthanc issue #1: the fileupload has been initialized twice !");
    } else {
        alreadyInitialized = true;
    }
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
            //dataType: 'json',
            //maxChunkSize: 500,
            //sequentialUploads: true,
            limitConcurrentUploads: 3,
            add: function(e, data) {
                pendingUploads.push(data);
            }
        })
        .bind('fileuploadstop', function(e, data) {
            $('#upload-button').removeClass('ui-disabled');
            //$('#upload-abort').addClass('ui-disabled');
            $('#progress .bar').css('width', '100%');
            if ($('#progress .label').text() != 'Failure')
                $('#progress .label').text('<?=_("Done")?>');
        })
        .bind('fileuploadfail', function(e, data) {
            $('#progress .bar')
                .css('width', '100%')
                .css('background-color', 'red');
            $('#progress .label').text('<?=_("Failure")?>');
        })
        .bind('fileuploaddrop', function(e, data) {
            console.log("dropped " + data.files.length + " files: ", data);
            appendFilesToUploadList(data.files);
        })
        .bind('fileuploadsend', function(e, data) {
            // Update the progress bar. Note: for some weird reason, the
            // "fileuploadprogressall" does not work under Firefox.
            var progress = parseInt(currentUpload / totalUploads * 100, 10);
            currentUpload += 1;
            $('#progress .label').text('<?=_("Uploading: ")?>' + progress + '%');
            $('#progress .bar')
                .css('width', progress + '%')
                .css('background-color', 'green');
        });
});
function appendFilesToUploadList(files) {
    var target = $('#upload-list');
    $.each(files, function(index, file) {
        target.append('<li class="pending-file">' + file.name + '</li>');
    });
    target.listview('refresh');
}
$('#fileupload').live('change', function(e) {
    appendFilesToUploadList(e.target.files);
})
function ClearUploadProgress() {
    $('#progress .label').text('');
    $('#progress .bar').css('width', '0%').css('background-color', '#333');
}
$('#upload').live('pagebeforeshow', function() {
    if (navigator.userAgent.toLowerCase().indexOf('firefox') == -1) {
        $("#issue-21-warning").css('display', 'none');
    }
    ClearUploadProgress();
});
$('#upload').live('pageshow', function() {
    $('#fileupload').fileupload('enable');
});
$('#upload').live('pagehide', function() {
    $('#fileupload').fileupload('disable');
});
$('#upload-button').live('click', function() {
    var pu = pendingUploads;
    pendingUploads = [];
    $('.pending-file').remove();
    $('#upload-list').listview('refresh');
    ClearUploadProgress();
    currentUpload = 1;
    totalUploads = pu.length + 1;
    if (pu.length > 0) {
        $('#upload-button').addClass('ui-disabled');
        //$('#upload-abort').removeClass('ui-disabled');
    }
    for (var i = 0; i < pu.length; i++) {
        pu[i].submit();
    }
});
$('#upload-clear').live('click', function() {
    pendingUploads = [];
    $('.pending-file').remove();
    $('#upload-list').listview('refresh');
});
/*$('#upload-abort').live('click', function() {
  $('#fileupload').fileupload().abort();
  });*/
// *** original Orthanc's file-upload.js ENDS here **
</script>