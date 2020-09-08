# Elessar

Orthanc Explorer in dark mode (green and grey). PHP gettext translation. PDF &amp; JPG uploaders. Mobile friendly navigation bar.

"The Elessar I leave with thee, for there are grievous hurts to Middle-earth which thou maybe shalt heal."

This "tuning" is entirely based on the original Orthanc Explorer that can be found in https://www.orthanc-server.com/

Motivated to avoid the visual stress of a white background, the interface matches the colors of the Osimis Webviewer Elessar available at https://github.com/Terabuck/Osimis-Dicom-Viewer-Elessar-

Pre-requisites:

The login/register are running in traditional PHP.
The translation has been done using  gettext 
The JPG and PDF uploaders rely on CURL, DCMTK and GhostScript  

Configuration:

1. Files are to be downloaded to /var/www/html/ngl/xpl folder
2. /includes/localdefs.php file must be updated to match the server configuration
3. This must be added to the server configuration file:
   location /ngl/xpl/ {
                index explorer.php;
   }
