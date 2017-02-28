<?php
################################################################
#                                                              #
# This Script pulls data from FlightAware using SOAP and       #
# Displays it formated on the page.                            #
#                                                              #
#          Written by:                                         #
#                       Eric Pine                              # 
#                       Data Systems of North Florida          #
#                       ericpine@datasystems-fl.com            #            
#                                                              #
################################################################ 

require_once('SOAP/Client.php');
 
$DirectFlight_Authentication = array(
'user'          => 'MichelleDanisovszky',
'pass'          => '38a1f862a79859d0f04839566de14804f5eecf49',
);
 
$wsdl_url = 'http://flightaware.com/commercial/flightxml/data/wsdl1.xml';
$WSDL = new SOAP_WSDL($wsdl_url,$DirectFlight_Authentication);
$soap = $WSDL->getProxy();
$addtotime=60*60
##############################<--- HTML --->################################
?><html>
<head>
   <!-- CHARACTER SPECIFICATION BEGIN -->
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<!-- CHARACTER SPECIFICATION END -->
<link rel="stylesheet" href="Site.css" type="text/css" title="" />
<link rel="stylesheet" href="Access.css" type="text/css" title="" />
<script src="Site.js" type="text/javascript"></script>
   <title>Gainesville Regional Airport (GNV), Gainesville, FL</title>
   <script src="FlightviewStatus.js"></script>
   <script src="Redirect.js"></script>
   <script src="Timestamp.js"></script>
   <script src="Fids.js"></script>
   <link rel="stylesheet" href="FlightFinder.css" type="text/css" type="text/css" title=""/>
   <link rel="stylesheet" href="basic_Gainesville.css" type="text/css" title=""/>
         <link rel="stylesheet" href="basic_Gainesville.css" type="text/css" title=""/>
<link rel="stylesheet" href="ffterm_Gainesville.css" type="text/css" title=""/>
<link rel="stylesheet" href="basic_Gainesville.css" type="text/css" title=""/>
<link rel="stylesheet" href="ffterm_Gainesville.css" type="text/css" title=""/>
<link rel="stylesheet" href="15401_Gainesville.css" type="text/css" title=""/>
</head>
<body>
   <div class="fidsMain">
      
         <div class="fidsLogo"><img src="Gainesville_Logo_3.jpg"></div>
         
      <div class="fidsPrimary">
      <h1 class="fidsTitle">ARRIVALS</h1>
            <div class="ffResult">
               <center>
                  <div class="ffResultList" xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:msxml="urn:schemas-microsoft-com:xslt">
<div class="header">
<table cellspacing="0" border="0" cellpadding="0">
<tr>
<th class="column1" style="width:31%">Airline</th>
<th class="column2" style="width:9%">Flight Number</th>
<th class="column3" style="width:19%">Status</th>
<th class="column4" style="width:20%">Origin</th>
<th class="column5" style="width:7%">Airport Code</th>
<th class="column6" style="width:14%">Arrives</th>
</tr>
</table>
</div><?php
#################################<--- End HTML --->###############################
        
##################################################
#                                                #
#               Flights Arrived                  #
#                                                #
##################################################

echo "<div class=\"data\">";
echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\">";
$result = $soap->Arrived('GNV',15,'airline',0);
$counter=2;
$result->arrivals = array_reverse($result->arrivals);
foreach ($result->arrivals as $value) {
        
        $airline=$value->ident;
        $airline=preg_replace("/[[:^alpha:]]/", "", $airline);
        if($value->actualarrivaltime-time()>=6*60*60*-1&&($airline=="ASQ"||$airline=="JIA")){
        #only display arrivals in the last 6 hours
             echo "<tr class=\"";
             if ($counter==1){echo "data odd\">"; $counter=2;}
             elseif ($counter==2){echo "data even\">"; $counter=1;}
             echo "<td style=\"width:31%\">";
             if ($airline=="ASQ"){$airline=str_replace("ASQ","ASA/Delta Connection",$airline);}
             if ($airline=="JIA"){$airline=str_replace("JIA","US Airways Express",$airline);}
             echo $airline;
             echo "</td><td style=\"width:9%\">";
             $fltnum=$value->ident;
             $fltnum=preg_replace("/[[:^digit:]]/", "", $fltnum);
             echo $fltnum;
             echo "</td><td style=\"width:19%\"><p> Landed </p></td> <td style=\"width:20%\"><span class=\"city\">";
             echo $value->originCity;
             echo "</td><td style=\"width:7%\">";
             $origin=$value->origin;
             $origin=str_replace("K", "", $origin);
             echo $origin;
             echo "</td><td style=\"width:14%\"><p>"; 
             $atime=$value->actualarrivaltime+$addtotime;
             echo date("g:i A", $atime);
             echo "</p></td></tr>";
        }
}

##################################################
#                                                #
#               Flights Enroute                  #
#                                                #
##################################################

$result = $soap->Enroute('GNV',15,'airline',0);
foreach ($result->enroute as $value) {
        $airline=$value->ident;
        $airline=preg_replace("/[[:^alpha:]]/", "", $airline);
        if($value->estimatedarrivaltime-time()<=24*60*60&&($airline=="ASQ"||$airline=="JIA")){
        # Display enroute for the next 24 hours
             echo "<tr class=\"";
             if ($counter==2){echo "data even\">"; $counter=1;}
             elseif ($counter==1){echo "data odd\">"; $counter=2;}
             echo "<td style=\"width:31%\">";
             if ($airline=="ASQ"){$airline=str_replace("ASQ","ASA/Delta Connection",$airline);}
             if ($airline=="JIA"){$airline=str_replace("JIA","US Airways Express",$airline);}
             echo $airline;
             echo "</td><td style=\"width:9%\">";
             $fltnum=$value->ident;
             $fltnum=preg_replace("/[[:^digit:]]/", "", $fltnum);
             echo $fltnum;
             echo "</td><td style=\"width:19%\"><p> Scheduled </p></td> <td style=\"width:20%\"><span class=\"city\">";
             echo $value->originCity;
             echo "</td><td style=\"width:7%\">";
             $origin=$value->origin;
             $origin=str_replace("K", "", $origin);
             echo $origin;
             echo "</td><td style=\"width:14%\"><p>"; 
             $value->estimatedarrivaltime=$value->estimatedarrivaltime+$addtotime;
             echo date("g:i A", $value->estimatedarrivaltime);
             echo "</p></td></tr>";         
        }
} echo "</table>";

##################################################
#                                                #
#               Flights Departed                 #
#                                                #
##################################################

$counter=2;

echo "</div></div></center></div></div><div class=\"fidsSecondary\"><h1 class=\"fidsTitle\">DEPARTURES</h1><div class=\"ffResult\"><center><div class=\"ffResultList\">
<div class=\"header\"><table cellspacing=\"0\" border=\"0\" cellpadding=\"0\"><tr>
<th class=\"column1\" style=\"width:31%\">Airline</th>
<th class=\"column2\" style=\"width:9%\">Flight Number</th>
<th class=\"column3\" style=\"width:19%\">Status</th>
<th class=\"column4\" style=\"width:20%\">Destination</th>
<th class=\"column5\" style=\"width:7%\">Airport Code</th>
<th class=\"column6\" style=\"width:14%\">Departs</th>
</tr></table></div><div class=\"data\"><table cellspacing=\"0\" border=\"0\" cellpadding=\"0\">";


$result = $soap->Departed('GNV',15,'airline',0);
$result->departures = array_reverse($result->departures);
foreach ($result->departures as $value) {
        $airline=$value->ident;
        $airline=preg_replace("/[[:^alpha:]]/", "", $airline);
        if($value->actualdeparturetime-time()>=2*60*60*-1&&($airline=="ASQ"||$airline=="JIA")){
        #only display departures in the last 2 hours
             echo "<tr class=\"";
             if ($counter==2){echo "data even\">"; $counter=1;}
             elseif ($counter==1){echo "data odd\">"; $counter=2;}
             echo "<td style=\"width:31%\">";
             if ($airline=="ASQ"){$airline=str_replace("ASQ","ASA/Delta Connection",$airline);}
             if ($airline=="JIA"){$airline=str_replace("JIA","US Airways Express",$airline);}
             echo $airline;
             echo "</td><td style=\"width:9%\">";
             $fltnum=$value->ident;
             $fltnum=preg_replace("/[[:^digit:]]/", "", $fltnum);
             echo $fltnum;
             echo "</td><td style=\"width:19%\"><p> Departed </p></td> <td style=\"width:20%\"><span class=\"city\">";
             echo $value->destinationCity;
             echo "</td><td style=\"width:7%\">";
             $origin=$value->destination;
             $origin=str_replace("K", "", $origin);
             echo $origin;
             echo "</td><td style=\"width:14%\"><p>"; 
             $value->actualdeparturetime=$value->actualdeparturetime+$addtotime;
             echo date("g:i A", $value->actualdeparturetime);
             echo "</p></td></tr>";  
        }
}

##################################################
#                                                #
#               Flights Scheduled                #
#                                                #
##################################################

$result = $soap->Scheduled('GNV',15,'airline',0);
foreach ($result->scheduled as $value) {
        
        $airline=$value->ident;
        $airline=preg_replace("/[[:^alpha:]]/", "", $airline);
        if($value->filed_departuretime-time()>=24*60*60*-1&&($airline=="ASQ"||$airline=="JIA")){
        #Display departures in the last 24 hours
             
             echo "<tr class=\"";
             if ($counter==2){echo "data even\">"; $counter=1;}
             elseif ($counter==1){echo "data odd\">"; $counter=2;}
             echo "<td style=\"width:31%\">";
             
             if ($airline=="ASQ"){$airline=str_replace("ASQ","ASA/Delta Connection",$airline);}
             if ($airline=="JIA"){$airline=str_replace("JIA","US Airways Express",$airline);}
             echo $airline;
             echo "</td><td style=\"width:9%\">";
             $fltnum=$value->ident;
             $fltnum=preg_replace("/[[:^digit:]]/", "", $fltnum);
             echo $fltnum;
             echo "</td><td style=\"width:19%\"><p> Scheduled </p></td> <td style=\"width:20%\"><span class=\"city\">";
             echo $value->destinationCity;
             echo "</td><td style=\"width:7%\">";
             $origin=$value->destination;
             $origin=str_replace("K", "", $origin);
             echo $origin;
             echo "</td><td style=\"width:14%\"><p>"; 
             $value->filed_departuretime=$value->filed_departuretime+$addtotime;
             echo date("g:i A", $value->filed_departuretime);
             echo "</p></td></tr>";  
        }


}
echo"</table>";




 
 	php?>
