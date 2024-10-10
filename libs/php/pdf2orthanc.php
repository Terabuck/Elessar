<?php
require("../../includes/auth.php");

// System variables are defined in the following file:
require("../../includes/localdefs.php");

// Execute only after file submission
if (isset($_POST['submit']))
{
  // Get current actual URL
  $actualLink      = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

  //TODO get the type of pdf to process, ie lab, dmo, survey, report
  
  // Get the study ID from the query param of the calling URL
  $urlQuery  = parse_url($actualLink, PHP_URL_QUERY);
  // echo 'StudyID: '. $studyId ."<br /> ";
  $urlBlocks = explode("/", $urlQuery);
  // echo $urlBlocks[0] . " = " . $urlBlocks[1] . "<br /> ";
  // echo 'Actual Link: ' . $actualLink . "<br /> ";
  // echo "url Blocks 0 =" . $urlBlocks[0] . "<br /> ". 'url Blocks 1=' . $urlBlocks[1] . "<br /> " . "url Blocks 2=" . $urlBlocks[2] . "<br /> " ;

  // Get the host and path from the query param of the calling URL
  $getHOST       = parse_url($actualLink, PHP_URL_HOST);
  // echo 'getHost: '.$getHOST."<br /> ";
  // echo 'LocalServer: '.$LocalServer."<br /> ";
  
  // Compare calling url to enabled Origin and proceed if correct
  if ($getHOST != $LocalServer)
  {
    echo ("<p style='background-color:yellow;color:red;font-size:25px;'>ERROR: The upload systema has been invoked from the wrong addresss.</p><p> Please send an email to ludwig.moreno@gmail.com with Orthanc-PDF2DCM in the subject</p>");
}
else
{
    // Create a temporal folder with the UID Code
    $filesPlace = $PublicPath. $urlBlocks[1];
    $cmdMKDIRtemp = 'mkdir -p ' . $filesPlace;
    exec($cmdMKDIRtemp);
    // echo 'the temporal folder with the name of the study is: '. $filesPlace. " <br />";
    
    // Upload the PDF file
    if (is_uploaded_file($_FILES['pdf']['tmp_name']))
    {
      if ($_FILES['pdf']['type'] != "application/pdf")
      {
        echo "<p>Solamente se acepta el formato PDF.</p>";
    }
    else
    {
        // echo "<p>The PDF file is properly structured.</p>". " <br />";
        
        // Saves the PDF in the temporal folder
        define("filesplace", $filesPlace);
        $name                 = $_POST['name'];
        $result               = move_uploaded_file($_FILES['pdf']['tmp_name'], filesplace . "/$name.pdf");
        if ($result == 1)
        {
          // echo 'Result is 1';
          
          // Compress the incoming temporal using GhostScript as in https://superuser.com/questions/435410/where-are-ghostscript-options-switches-documented
          $fileInPDF  = $filesPlace . '/temp.pdf';
          $compressedPDF = $filesPlace. '/compressedPDF.pdf';
          $cmdPdfCompress     = 'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=' . $compressedPDF . ' '. $fileInPDF;
          exec($cmdPdfCompress); 
                
          // Prepare the system via REST to extract json from current Code to get an instanceId
          $OrthancRESTpatients  = '/patients';
          $OrthancRESTstudies   = '/studies';
          $OrthancRESTinstances = '/instances';
          if ($urlBlocks[0] === 'study')
          {
              $OrthancRESTcode      = $OrthancRESTstudies;
          }
          if ($urlBlocks[0] === 'patient')
          {
              $OrthancRESTcode      = $OrthancRESTpatients;
          }
                
          // Fetch the first instanceId belonging to the $OrthancRESTcode
          // echo '$OrthancRESTcode 0 '. $OrthancRESTcode  . " <br />";
          $json_string          = $OrthancUrl . $OrthancRESTcode . "/" . $urlBlocks[1] . $OrthancRESTinstances;
          $jsondata             = file_get_contents($json_string);
          $obj                  = json_decode($jsondata, true);
          $obj                  = array_shift($obj);
          $obj['ID'];
          $instanceId   = $obj['ID'];
          $dcmExtension = ".dcm";
          $dcmTemplate  = $filesPlace . "/" . $instanceId . $dcmExtension;
          
          // Donwload the DICOM file template belonging to parent study
          $downloadCMD = "curl -v http://localhost:8042/instances/". $instanceId . "/file" . " --output " . $dcmTemplate;
          exec($downloadCMD);

          // echo "Download command: " . $downloadCMD . " <br />";
          
          // Fix Date and other Tags
          $timeCap = date('Ymd');

          // Create string with actual date & time
          $tags       = ' -k &quot;StudyDate&quot;=' . $timeCap . ' -k &quot;SeriesDate&quot;=' . $timeCap . ' -k &quot;AcquisitionDate&quot;=' . $timeCap . ' -k &quot;SeriesDescription&quot;=&quot;'. $urlBlocks[2] .'&quot; -k &quot;Modality&quot;=DOC -k &quot;InstanceNumber&quot;=1 -k &quot;Manufacturer&quot;=&quot;cloud dicomized at misimagenes.online&quot;';
          
          $cmdFxdTags = htmlspecialchars_decode($tags, ENT_QUOTES);
          // echo "Fecha: " . $timeCap . " <br />";
          // echo "DICOM tags: " . $cmdFxdTags . " <br />";
          
          // Create the DCM with with corresponding tags imported from $InstanceId.dcm using DCMTK's pdf2dcm
          $PDF2DCM = $filesPlace . '/output.dcm';
          // echo 'The encapsulated PDF file in DICOM format is: '.$PDF2DCM . " <br />";
          $cmdP2D     = 'pdf2dcm ' . $compressedPDF . ' ' . $PDF2DCM . ' +st '. $dcmTemplate . $cmdFxdTags;
          exec($cmdP2D);
          // echo 'The command to create the encapsulated PDF is: '.$cmdP2D . " <br />";
                        
          //Create a new SeriesID and a StudyInstanceUID only if necessary
          if ($urlBlocks[0] === 'patient')
          {
              $tags       = ' -i &quot;StudyDescription&quot;=&quot; '. $urlBlocks[2] . '&quot; ';
              $cmdFxdTags = htmlspecialchars_decode($tags, ENT_QUOTES);
              $cmdCreateNewStudyID = 'dcmodify -gst -gse ' . $cmdFxdTags . $PDF2DCM;
              exec($cmdCreateNewStudyID);
              // echo 'StudyInstanceUID has been modified' . " <br />";
          }
          if ($urlBlocks[0] === 'study')
          {
              $cmdCreateNewSeriesID = 'dcmodify -gse ' . $PDF2DCM;
              exec($cmdCreateNewSeriesID);
              // echo 'SeriesInstanceUID has been modified' . " <br />";
          }
          // echo "file before compression: " . $PDF2DCM . " <br />";
          $chkfile = 'file ' . $PDF2DCM;
          // echo "chk file command and result are: " . (exec($chkfile)) . " <br />";

          // Upload the newly created .dcm to the Orthanc Dicom Server
          // $post_url = $OrthancUrl . $OrthancRESTinstances;
          // echo 'post url is: ' .  $post_url . " <br />";
          // $post_str = file_get_contents($PDF2DCM);
          // echo 'post string is: ' . $post_str . " <br />";
          // $headers  = "Expect: ";
          // echo 'header is: ' . $headers . " <br />"; 

          // Use DCMTK dcmsend
          $cmdDCMsend = "dcmsend 127.0.0.1 4242 " . $PDF2DCM;
          exec($cmdDCMsend);
          // echo 'The file was uploaded with the command: '.$cmdDCMsend. " <br />";

          $cmdDELtemp = 'rm -r ' . $filesPlace;
          exec($cmdDELtemp);
          // echo "deltemp is: " . (exec($cmdDELtemp)) . " <br />";
          
          // Smile
          // echo "<p>The DCM file upload was successfull.</p>";
                            
          // sleep(3);
          // Redirect this window to the calling page
          $stringAlfa  = '<script type= &quot;text/javascript &quot;> document.location.href = &quot;';
          $stringOmega = '&quot;; </script>';
          $callingURL  = $OrthancExplorer . "#" . $urlBlocks[0] . "?uuid=" . $urlBlocks[1];
          // echo $callingURL . " <br />";
          
          // Return to the calling page
          echo htmlspecialchars_decode($stringAlfa) . $callingURL . htmlspecialchars_decode($stringOmega);
        } #endIF
        else 
        echo "<p>Undefined error. Please contact administrator. </p>";          
      } #endIF
    } #endIF
    
  } #endIF
  
} #endIF
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dicomize</title>
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../styles/login.app.css">

</head>

<body style="background: #525252;">
    <div class="container-form">

        <form action="" enctype="multipart/form-data" method="post" style="padding: 1rem; color: #beff7d;">
            <br />
            <span style="font-size: x-large;"><?=_('Attach PDF report')?> </span>
            <br />
            <a>
                <?=_('to include it in the DICOM DB')?>
            </a>
            <br />
            <canvas id="pdf-preview" width=336 height=336 style="border: 1px solid #009542; margin: auto" ;>
                <?=_('Sorry, your browser is not accepting CANVAS HTML tag.')?></canvas>
                <input type="hidden" name="name" value="temp" />
                <br />
                <div id="pdf-loader"></div>
                <br />

                <span id="pdf-name" style="max-width:336px;overflow-wrap:anywhere;"></span>
                <br />
                <br />

                <label for="pdf-file"
                style="width:15.4rem;height:4rem;border: 1px solid #ccc; float:left; padding: 6px 12px; cursor: pointer;">
                <?=_('Select file')?>
            </label>
            <input accept="application/pdf" id="pdf-file" type="file" name="pdf" value="" style="display: none;">
            <label for="pdf-submit">
                <img src="../images/pdf2dcm.svg" alt="Submit"
                style="max-width: 4rem; float:right; margin-right: 10px; cursor: pointer;">
            </label>
            <input id=pdf-submit type="submit" name="submit" style="display: none;">

        </form>
    </div>
    <script src="../scripts/pdf.js"></script>
    <script src="../scripts/pdf.worker.js"></script>
    <script type="text/javascript">
        var _PDF_DOC,
        _CANVAS = document.querySelector('#pdf-preview'),
        _OBJECT_URL;

        function showPDF(pdf_url) {
            PDFJS.getDocument({
                url: pdf_url
            }).then(function(pdf_doc) {
                _PDF_DOC = pdf_doc;
            // Show the first page
                showPage(1);
            // destroy previous object url
                URL.revokeObjectURL(_OBJECT_URL);
            });
        }

        function showPage(page_no) {
        // fetch the page
            _PDF_DOC.getPage(page_no).then(function(page) {
            // set the scale of viewport
                var scale_required = _CANVAS.width / page.getViewport(1).width;
            // get viewport of the page at required scale
                var viewport = page.getViewport(scale_required);
            // set canvas height
                _CANVAS.height = viewport.height;
                var renderContext = {
                    canvasContext: _CANVAS.getContext('2d'),
                    viewport: viewport
                };
            // render the page contents in the canvas
                page.render(renderContext).then(function() {
                    document.querySelector("#pdf-preview").style.display = 'inline-block';
                    document.querySelector("#pdf-loader").style.display = 'none';
                });
            });
        }


    /* Selected File has changed */
        document.querySelector("#pdf-file").addEventListener('change', function() {
        // user selected file
            var file = this.files[0];
        // allowed MIME types
            var mime_types = ['application/pdf'];
        // Validate whether PDF
            if (mime_types.indexOf(file.type) == -1) {
                alert('Error : Incorrect file type');
                return;
            }
        // validate file size
            if (file.size > 10 * 1024 * 1024) {
                alert('Error : Exceeded size 10MB');
                return;
            }
        // set name of the file
            document.querySelector("#pdf-name").innerText = file.name;
            document.querySelector("#pdf-name").style.display = 'inline-block';
        // Show the PDF preview loader
            document.querySelector("#pdf-loader").style.display = 'inline-block';
        // object url of PDF 
            _OBJECT_URL = URL.createObjectURL(file)
        // send the object url of the pdf to the PDF preview function
            showPDF(_OBJECT_URL);
        });
    </script>
</body>

</html>
