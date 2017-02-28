<?php
################################################################
#                                                              #
# This Script displays the flight map                          #
#                                                              #
#                                                              #
#          Written by:                                         #
#                       Eric Pine                              # 
#                       Data Systems of North Florida          #
#                       ericpine@datasystems-fl.com            #            
#                                                              #
################################################################ 
ob_start();
require_once('SOAP/Client.php');
 
$DirectFlight_Authentication = array(
'user'          => 'MichelleDanisovszky',
'pass'          => '38a1f862a79859d0f04839566de14804f5eecf49',
);

$wsdl_url = 'http://flightaware.com/commercial/flightxml/data/wsdl1.xml';
$WSDL = new SOAP_WSDL($wsdl_url,$DirectFlight_Authentication);
$soap = $WSDL->getProxy();
$mapdata = $soap->MapFlight_Beta('GNV',500,450);
#$image = ImageCreateFromJPEG($mapdata->return);
#imagestring($mapdata);
#header(”Content-type: image/jpg”);
#imagejpeg($image);
#imagedestroy($image);
echo $mapdata->return;
?>