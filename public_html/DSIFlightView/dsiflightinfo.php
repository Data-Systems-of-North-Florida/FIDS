<?php
echo "<!--
################################################################
#                                                              #
# This Script pulls data from cached xml source and            #
# formats it for display in browser for a FIDS                 #
#                                                              #
#          Written by:                                         #
#                       Eric Pine                              # 
#                       Data Systems of North Florida          #
#                                                              #            
#                                                              #
################################################################ 
--!>";

##############################<--- HTML Header --->########################################
#                                                                                         #
###########################################################################################
$username="gragnv_flghtdsp";
$password="fl1ghto7";
$database="gragnv_flightdisplay";
date_default_timezone_set('America/New_York');
?>
<style type="text/css">
table {font-size: 100%;}
</style>

<font face="Arial" size="0">
      <center><b><font size =+2>Arrivals</font></b></center
            <div >
            <center>
                  <div  xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:msxml="urn:schemas-microsoft-com:xslt">
<div>
<table cellspacing="" border="0" cellpadding="0">
<tr>
<th class="column1" style="width:31%">Airline</th>
<th class="column2" style="width:9%">Flight Number</th>
<th class="column3" style="width:19%">Status</th>
<th class="column4" style="width:20%">Origin</th>
<th class="column5" style="width:10%"><div align=left>Airport Code</div></th>
<th class="column6" style="width:14%"><div align=left>Arrives</div></th>
</tr>

</div>

<?php

#################################<--- End HTML Header --->###############################

######################## Load XML from arrivals.xml and output data #######################
#                                                                                         #
###########################################################################################

  $objDOM1 = new DOMDocument(); 
  $objDOM1->load("/home/gragnv/public_html/DSIFlightView/arrivals.xml"); 

#Initialize value of counter that will rotate blue to white output lines
$counter=2;

#load data into array from main XML DOM object
$Flight = $objDOM1->getElementsByTagName("Flight"); 

#loop through each flight and print output
  foreach( $Flight as $value ) 
  { 
    $FlightNumber = $value->getElementsByTagName("FlightNumber");
    $NumberFlight = $FlightNumber->item(0)->nodeValue;   
    $AirlineName = $value->getElementsByTagName("AirlineName");
    $AN = $AirlineName->item(0)->nodeValue;

    #load all possible flight statuses
    $FlightLanded = $value->GetElementsByTagName("Landed");    
    $LandedFlight = $FlightLanded->item(0)->nodeName;  
    $FlightCancelled = $value->GetElementsByTagName("Cancelled");   
    $CancelledFlight = $FlightCancelled->item(0)->nodeName;  
    $FlightScheduled = $value->GetElementsByTagName("Scheduled");   
    $ScheduledFlight = $FlightScheduled->item(0)->nodeName; 
    $FlightProposed = $value->GetElementsByTagName("Proposed");   
    $ProposedFlight = $FlightProposed->item(0)->nodeName; 
    $FlightUnknown = $value->GetElementsByTagName("Unknown");   
    $UnknownFlight = $FlightUnknown->item(0)->nodeName;
    $FlightScheduled = $value->GetElementsByTagName("Scheduled");   
    $ScheduledFlight = $FlightUnknown->item(0)->nodeName;
    $FlightInAir = $value->GetElementsByTagName("InAir");   
    $InAirFlight = $FlightInAir->item(0)->nodeName;
 
    $DestinationCity = $value->getElementsByTagName("CityName");
    $CityDestination = $DestinationCity->item(0)->nodeValue;
    $DestinationState = $value->getElementsByTagName("StateId");
    $StateDestination = $DestinationState->item(0)->nodeValue;
    $DestinationAirportCode = $value->getElementsByTagName("AirportCode");
    $AirportCodeDestination = $DestinationAirportCode->item(0)->nodeValue;
    $DepartTime = $value->getElementsByTagName("Time");
    $TimeDepart = $DepartTime->item(1)->nodeValue;        
    $TimeDepart= date("g:i A", strtotime("$TimeDepart"));
      

#retreive airlines from databae
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM flightdisplay";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();

$i=0;
while ($i < $num) 
{

	$ID=mysql_result($result,$i,"Index");
	$ANumberOutput=mysql_result($result,$i,"flight_number");
	$ANameOutput=mysql_result($result,$i,"airline_name");
	$FANameOutput=mysql_result($result,$i,"formatted_airline_name");
	$NHOutput=mysql_result($result,$i,"number_of_hours");

    #print only the airlines needed

   if ($AN == $ANameOutput && $NumberFlight == $ANumberOutput && ($NHOutput >= abs((strtotime("$TimeDepart")-time())/60/60) || $NHOutput >= abs(((strtotime("$TimeDepart")+(24*60*60))-time())/60/60)|| $NHOutput >= abs(((strtotime("$TimeDepart")-(24*60*60))-time())/60/60)))
    { 
 	$airline=$value->ident;    
 	echo "<tr bgcolor=\"";
       if ($counter==2)
	{
       	echo "lightblue\">"; 
       	$counter=1;
	}
       elseif ($counter==1)
	{
		echo "white\">"; 
		$counter=2;
	}
       echo "<td style=\"width:31% \">";
	
       	echo "<center>";
		echo $FANameOutput;
		echo "</center>";
    

       echo "</td><td style=\"width:9%\"><center>";
	echo $NumberFlight;
	
       echo "</center></td><td >";
       echo "<center>";

       #print status
       if ($LandedFlight != NULL)
	{
       	echo "Landed";
       }
       if ($UnknownFlight != NULL)
	{
       	echo "Delayed";
       }
       if ($ProposedFlight != NULL)
	{
       	echo "Scheduled";
       }
	if ($CancelledFlight != NULL)
	{
		echo $CancelledFlight;
	}
 	if ($InAirFlight != NULL)
	{
       	echo "In Air";
       }
	if ($LandedFlight==Null&&$UnknownFlight==Null&&$ProposedFlight==Null&&$CancelledFlight==Null&&$InAirFlight==Null)
	{
       	echo "Scheduled";
	}
	
	#html formatting
	echo "</center><td style=\"width:20%\"><span >";
	
	#output city and state
       if ($CityDestination == "FORT LAUDERDALE")
        {
        echo "LAUDERDALE";
        }
        if ($CityDestination != "FORT LAUDERDALE")
        {
        echo $CityDestination;
	}
	echo ",";
	echo $StateDestination;
	
	#html formatting
	echo "</td><td style=\"width:7%\">";
	
	#output destination airport code and html formatting
	echo $AirportCodeDestination;
	echo "</td><td style=\"width:14%\"><p>"; 
	
	#output departure time
	echo $TimeDepart;
	echo "</p></td></tr>";  

    }
$i++;
}
 } 

#close html table with departure results
echo "</table>";

#####################End Load XML from departures.xml and output data####################

##################### HTML formatting for results table for departures ####################
#                                                                                         #
###########################################################################################
echo "<br></div></div></center></div></div><div ><center><b><font size=+2>Departures</font></b></center><div ><br><center>
<div>
<div ><table cellspacing=\"\" border=\"0\" cellpadding=\"0\"><tr>
<th class=\"column1\" style=\"width:31%\">Airline</th>
<th class=\"column2\" style=\"width:9%\">Flight Number</th>
<th class=\"column3\" style=\"width:19%\">Status</th>
<th class=\"column4\" style=\"width:20%\">Destination</th>
<th class=\"column5\" style=\"width:10%\"><div align=left>Airport Code</div></th>
<th class=\"column6\" style=\"width:14%\"><div align=left>Departs</div></th>
</tr></div><div >";

##################### End HTML formatting for results table for departures ####################

#######################Load XML from departures.xml and output data########################
#                                                                                         #
###########################################################################################
  $objDOM = new DOMDocument(); 
  $objDOM->load("/home/gragnv/public_html/DSIFlightView/departures.xml"); 

#Initialize value of counter that will rotate blue to white output lines
$counter=2;

#load data into array from main XML DOM object
$Flight = $objDOM->getElementsByTagName("Flight");    
  
  #loop through each flight and print output
  foreach( $Flight as $value ) 
  { 
    $FlightNumber = $value->getElementsByTagName("FlightNumber");
    $NumberFlight = $FlightNumber->item(0)->nodeValue;   
    $AirlineName = $value->getElementsByTagName("AirlineName");
    $AN = $AirlineName->item(0)->nodeValue;

    #load all possible flight statuses
    $FlightLanded = $value->GetElementsByTagName("Landed");    
    $LandedFlight = $FlightLanded->item(0)->nodeName;  
    $FlightCancelled = $value->GetElementsByTagName("Cancelled");   
    $CancelledFlight = $FlightCancelled->item(0)->nodeName;  
    $FlightScheduled = $value->GetElementsByTagName("Scheduled");   
    $ScheduledFlight = $FlightScheduled->item(0)->nodeName; 
    $FlightProposed = $value->GetElementsByTagName("Proposed");   
    $ProposedFlight = $FlightProposed->item(0)->nodeName; 
    $FlightUnknown = $value->GetElementsByTagName("Unknown");   
    $UnknownFlight = $FlightUnknown->item(0)->nodeName;
    $FlightScheduled = $value->GetElementsByTagName("Scheduled");   
    $ScheduledFlight = $FlightUnknown->item(0)->nodeName;
    $FlightInAir = $value->GetElementsByTagName("InAir");   
    $InAirFlight = $FlightInAir->item(0)->nodeName;

    $DestinationCity = $value->getElementsByTagName("CityName");
    $CityDestination = $DestinationCity->item(1)->nodeValue;
    $DestinationState = $value->getElementsByTagName("StateId");
    $StateDestination = $DestinationState->item(1)->nodeValue;
    $DestinationAirportCode = $value->getElementsByTagName("AirportCode");
    $AirportCodeDestination = $DestinationAirportCode->item(1)->nodeValue;
    $DepartTime = $value->getElementsByTagName("Time");
    $TimeDepart = $DepartTime->item(0)->nodeValue;        
    $TimeDepart= date("g:i A", strtotime("$TimeDepart"));

$i=0;
while ($i < $num) 
{

	$ID=mysql_result($result,$i,"Index");
	$ANumberOutput=mysql_result($result,$i,"flight_number");
	$ANameOutput=mysql_result($result,$i,"airline_name");
	$FANameOutput=mysql_result($result,$i,"formatted_airline_name");
	$NHOutput=mysql_result($result,$i,"number_of_hours");
    
    #print only the airlines needed
  if ($AN == $ANameOutput && $NumberFlight == $ANumberOutput && ($NHOutput >= abs((strtotime("$TimeDepart")-time())/60/60) || $NHOutput >= abs(((strtotime("$TimeDepart")+(24*60*60))-time())/60/60)|| $NHOutput >= abs(((strtotime("$TimeDepart")-(24*60*60))-time())/60/60)))
   {
 	$airline=$value->ident;    
 	echo "<tr bgcolor=\"";
       if ($counter==2)
	{
       	echo "lightblue\">"; 
       	$counter=1;
	}
       elseif ($counter==1)
	{
		echo "white\">"; 
		$counter=2;
	}
       echo "<td style=\"width:31%\"><center>";

	echo "<center>";
		echo $FANameOutput;
		echo "</center>";

       echo "</td><td style=\"width:9%\"><center>";
	echo $NumberFlight;
	
       echo "</td><td style=\"width:9%\"><center>";
       
       #print status
       if ($LandedFlight != NULL)
	{
       	echo "Departed";
       }
 	if ($InAirFlight != NULL)
	{
       	echo "In Air";
       }

       if ($UnknownFlight != NULL)
	{
       	echo "Delayed";
       }
       if ($ProposedFlight != NULL)
	{
       	echo "Scheduled";
       }
	if ($CancelledFlight != NULL)
	{
		echo $CancelledFlight;
	}
	if ($LandedFlight==Null&&$UnknownFlight==Null&&$ProposedFlight==Null&&$CancelledFlight==Null&&$InAirFlight==Null)
	{
       	echo "Scheduled";
	}
	
	#html formatting
	echo "<td style=\"width:20%\"><span class=\"city\"></center>";
	
	#output city and state
        if ($CityDestination == "FORT LAUDERDALE")
        {
        echo "LAUDERDALE";
        }
        if ($CityDestination != "FORT LAUDERDALE")
        {
        echo $CityDestination;
	}
        echo ",";
	echo $StateDestination;
	
	#html formatting
	echo "</td><td style=\"width:7%\">";
	
	#output destination airport code and html formatting
	echo $AirportCodeDestination;
	echo "</td><td style=\"width:14%\"><p>"; 
	
	#output departure time
	echo $TimeDepart;
	echo "</p></td></tr>";  

      }
$i++;
}
 } 

#close html table with departure results
echo "</table>";

##################### End Load XML from departures.xml and output data ####################