<?php
require("../../includes/auth.php");
// System variables are defined in the following file:
require("../../includes/localdefs.php");

// Execute only after file submission
if (count($_POST) && (strpos($_POST['img'], 'data:image') === 0))
{
  $img             = $_POST['img'];
  // Get current actual URL
  $actualLink      = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  // echo 'Actual Link: ' . $actualLink . "<br /> ";

  // Get the study ID from the query param of the calling UR
  $urlQuery  = parse_url($actualLink, PHP_URL_QUERY);
  // echo 'StudyID: '. $studyId ."<br /> ";
  $urlBlocks = explode("=", $urlQuery);
  $PathCode  = $urlBlocks[1];
  // echo $urlBlocks[0] . " = " . $PathCode . "<br /> ";
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
    // Create a temporal folder with the Code
    $filesPlace = $PublicPath. $PathCode;
    $cmdMKDIRtemp = 'mkdir -p ' . $filesPlace;
    exec($cmdMKDIRtemp);
    // echo 'the temporal folder with the name of the study is: '. $filesPlace. " <br />";
    // Upload the JPG file
    if (strpos($img, 'data:image/jpeg;base64,') === 0)
    {
      $img    = str_replace('data:image/jpeg;base64,', '', $img);
      $ext    = '.jpg';
    }
    $img    = str_replace(' ', '+', $img);
    $data   = base64_decode($img);
    $source = $filesPlace . '/img' . date("YmdHis") . $ext;
    if (file_put_contents($source, $data))
    {
      // echo "<p>The image was saved as $source.</p>";
    }
    else
    {
      echo "<p>The image could not be saved.</p>";
    }
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
    // Fetch the first instance belonging to the $PathCode;
    // echo '$OrthancRESTcode 0 '. $OrthancRESTcode  . " <br />";
    $json_string          = $OrthancUrl . $OrthancRESTcode . "/" . $PathCode . $OrthancRESTinstances;
    $jsondata             = file_get_contents($json_string);
    $obj                  = json_decode($jsondata, true);
    $obj                  = array_shift($obj);
    $obj['ID'];
    $instanceId   = $obj['ID'];
    $dcmExtension = ".dcm";
    $dcmTemplate  = $filesPlace . "/" . $instanceId . $dcmExtension;
    // Open file descriptor
    $fp           = fopen($dcmTemplate, 'w+') or die('Process error, please contact the administrator.');
    // Download the instance from Orthanc Dicom Server to local filesystem
    $ch           = curl_init($OrthancUrl . $OrthancRESTinstances . "/" . $instanceId . "/file");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
    curl_setopt($ch, CURLOPT_USERAGENT, 'any');
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    // echo "template: " . $dcmTemplate . " <br />";
    // $chkfile = 'file ' . $dcmTemplate;
    // echo (exec($chkfile)) . " <br />";
    // echo "source: " . $source . " <br />";
    // $chkfile = 'file ' . $source;
    // echo (exec($chkfile)) . " <br />";
    // Fix Date and  Tags
    $timeCap    = date('Ymd');
    $tags       = ' -k &quot;StudyDate&quot;=' . $timeCap . ' -k &quot;SeriesDate&quot;=' . $timeCap . ' -k &quot;AcquisitionDate&quot;=' . $timeCap . ' -k &quot;StudyDescription&quot;=Image -k &quot;Modality&quot;=XC -k &quot;InstanceNumber&quot;=1 -k &quot;Manufacturer&quot;=&quot;cloud dicomized at misimagenes.online&quot;';
    $cmdFxdTags = htmlspecialchars_decode($tags, ENT_QUOTES);
    // echo "Fecha: " . $timeCap . " <br />";
    // echo "DICOM tags: " . $cmdFxdTags . " <br />";
    // Create the DCM with with corresponding tags imported from $InstanceId.dcms using DCMTK's img2dcm
    $uncompressedDCM = $filesPlace . '/img_output.dcm';
    $cmdP2D          = 'img2dcm ' . $source . ' ' . $uncompressedDCM . ' -stf ' . $dcmTemplate . $cmdFxdTags;
    exec($cmdP2D);
    // echo $cmdP2D . " <br />";
    // Free the memory
    imagedestroy($source);
    //Create a new StudyInstanceUID if necessary
    if ($urlBlocks[0] === 'patient')
    {
      $cmdCreateNewStudyID = 'dcmodify -gst -gse ' . $uncompressedDCM;
      exec($cmdCreateNewStudyID);
      // echo 'StudyInstanceUID has been modified' . " <br />";
    }
    // echo "file before compression: " . $uncompressedDCM . " <br />";
    $chkfile = 'file ' . $uncompressedDCM;
    // echo (exec($chkfile)) . " <br />";
          // Upload the newly created .dcm in the Orthanc Dicom Server
          $post_url = $OrthancUrl . $OrthancRESTinstances;
          $post_str = file_get_contents($uncompressedDCM);
          $headers  = "Expect: ";
          $ch       = curl_init();
          $ch       = curl_init();
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_URL, $post_url);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
          curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_VERBOSE, true);
          curl_setopt($ch, CURLOPT_STDERR, fopen("header.txt", "w+"));
          $http_body = curl_exec($ch);
          curl_close($ch);
    // Delete temporal files
    $cmdDELtemp = 'rm -r ' . $filesPlace;
    // exec($cmdDELtemp);
    
    // Smile
    // echo "<p>The pdf file upload was successfull.</p>";
    // sleep(3);
    // Redirect this window to the calling page
    $stringAlfa  = '<script type= &quot;text/javascript &quot;> document.location.href = &quot;';
    $stringOmega = '&quot;; </script>';
    $callingURL  = $OrthancExplorer . "#" . $urlBlocks[0] . "?uuid=" . $PathCode;
    // echo $callingURL . " <br />";
    echo htmlspecialchars_decode($stringAlfa) . $callingURL . htmlspecialchars_decode($stringOmega);
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
        <form action="" method="post" style="padding: 1rem; color: #beff7d">
            <br />
            <span style="font-size: x-large;"><?=_('Add JPG image')?> </span>
            <br />
            <a>
                <?=_('to include it in the DICOM DB')?>
            </a>
            <br />
            <canvas id="canvas2" width=336 height=336 style="border: 1px solid #009542; margin: auto" ;>
                <?=_('Sorry, your browser is not accepting CANVAS HTML tag.')?></canvas>
            <br />
            <br />
            <label for="input_image"
                style="width:15.4rem;height:4rem;border: 1px solid #ccc; float:left; padding: 6px 12px; cursor: pointer;">
                <?=_('Select file')?>
            </label>
            <input id="output_image" name="img" type="hidden" value="">
            <input accept="image/jpeg" id="input_image" type="file" style="display: none;">
            <label for="jpg-submit">
                <img src="../images/jpg2dcm.svg" alt="Submit"
                    style=" max-width: 4rem; float:right; margin-right: 10px; cursor: pointer;">
            </label>
            <input id="jpg-submit" type="submit" name="submit" style="display: none;">

        </form>
    </div>
    <canvas id="canvas" width=1024 height=1024 style="margin-top: 2000px" ;></canvas>
    <script type="text/javascript">
    // set name of the file
    let fileInput = document.getElementById("input_image");
    fileInput.addEventListener("change", function(ev) {
        if (ev.target.files) {
            let file = ev.target.files[0];
            var reader = new FileReader();
            var imageObj = new Image();
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            reader.readAsDataURL(file);
            reader.onloadend = function(e) {
                imageObj.src = e.target.result;
                imageObj.onload = function(ev) {
                    var canvas = document.getElementById("canvas");
                    var imageAspectRatio = imageObj.width / imageObj.height;
                    var renderableHeight, renderableWidth;
                    if (imageAspectRatio < 1) {
                        renderableHeight = canvas.height;
                        renderableWidth = imageObj.width * (renderableHeight / imageObj.height);
                        canvas.width = renderableWidth;
                    } else if (imageAspectRatio > 1) {
                        renderableWidth = canvas.width
                        renderableHeight = imageObj.height * (renderableWidth / imageObj.width);
                        canvas.height = renderableHeight;
                    }
                    ctx.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
                    var dataURL = canvas.toDataURL("image/jpeg", 0.8);
                    document.getElementById("output_image").value = dataURL;
                    canvas2.width = canvas.width / 3 - 6;
                    canvas2.height = canvas.height / 3 - 6;
                    var ctx2 = canvas2.getContext("2d");
                    ctx2.clearRect(0, 0, canvas2.width, canvas2.height);
                    ctx2.drawImage(canvas, 0, 0, canvas2.width, canvas2.height);

                };
            };
        }
    });
    </script>
</body>

</html>