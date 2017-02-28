<?php
//XML to HTML FIDS parser
//Originally written by Eric Pine ericpine@datasystems-fl.com
//Rewritten by Tyler Mays on 5/5/2013 tyler@bitcraft-fl.com

$minsToShowFuture = 300; // show flights this number of minutes from the current time 
$minsToShowPast = 120; // keep flights on the screen with eta this many minutes in the past
?>

<style>

body {
}

tr {
}
th {
text-align:center !important;
}
td {
white-space:nowrap;
border-spacing:0px;
}
.flightTable {
line-height: 2;
border-collapse: collapse;
border-spacing: 0;
color:#3a3636 !important;
}
.headerRow {
width:100% !important;
http://colorzilla.com/gradient-editor/#9ed9f6+1,8dc6e3+41,84bfdc+100 */
background: rgb(158,217,246); /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover, rgba(158,217,246,1) 1%, rgba(141,198,227,1) 41%, rgba(132,191,220,1) 100%); /* FF3.6-15 */
background: -webkit-radial-gradient(center, ellipse cover, rgba(158,217,246,1) 1%,rgba(141,198,227,1) 41%,rgba(132,191,220,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: radial-gradient(ellipse at center, rgba(158,217,246,1) 1%,rgba(141,198,227,1) 41%,rgba(132,191,220,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9ed9f6', endColorstr='#84bfdc',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
width:100% !important;
height:30px !important;
}
.headerRow th{
height: 40px !important;

}

.dataRow {
}
.dataRow td{
padding-left:20px ;
padding-right:20px ;
}

.th_column1 {
text-align:center;
width:270px !important;
border-left-style:none !important;
border-left-width:0px !important;
}
.th_column2 {
text-align:center;
width:250px !important;
}
.th_column3 {
text-align:center;
width:200px !important;
}
.th_column4 {
text-align:center;
width:100px !important;
}
.th_column5 {
text-align:center;
width:200px !important;
}

.td_column1 {
padding-left:0px !important;
/*padding-right:0px !important;*/
}
.td_column2 {
text-align:center;
}
.td_column3 {
text-align:left;
}
.td_column4 {
text-align:right;
padding-right:25px !important;
padding-left:25px !important;
}
.td_column5 {
text-align:center;
padding-right:25px !important;
padding-left:25px !important;
border-right-style:none !important;
border-right-width:0px !important;
}
.even {
background: -moz-linear-gradient(45deg, rgba(195,229,244,0.65) 0%, rgba(195,229,244,0.64) 1%, rgba(0,0,0,0) 100%) !important; /* FF3.6-15 */
background: -webkit-linear-gradient(45deg, rgba(195,229,244,0.65) 0%,rgba(195,229,244,0.64) 1%,rgba(0,0,0,0) 100%)!important; /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(45deg, rgba(195,229,244,0.65) 0%,rgba(195,229,244,0.64) 1%,rgba(0,0,0,0) 100%)!important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6c3e5f4', endColorstr='#00000000',GradientType=1 )!important; /* IE6-9 fallback on horizontal gradient */
background-color:white !important;
}
.even td{
text-shadow: 0px 0px 8px rgb(255, 255, 255);
}
/* border-color:lightblue !important;
border-right-style:dotted !important;
border-width:1px !important; */
.odd {
http://colorzilla.com/gradient-editor/#9ed9f6+1,8dc6e3+41,84bfdc+100 */
background: rgb(158,217,246); /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover, rgba(158,217,246,1) 1%, rgba(141,198,227,1) 41%, rgba(132,191,220,1) 100%); /* FF3.6-15 */
background: -webkit-radial-gradient(center, ellipse cover, rgba(158,217,246,1) 1%,rgba(141,198,227,1) 41%,rgba(132,191,220,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: radial-gradient(ellipse at center, rgba(158,217,246,1) 1%,rgba(141,198,227,1) 41%,rgba(132,191,220,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9ed9f6', endColorstr='#84bfdc',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
background-color:lightblue;
}
/*.odd td :not(.tdPadding){
text-shadow: 0px 0px 8px rgb(255, 255, 255);
border-color:white;
border-right-style:dotted;
border-left-style:none;
border-left-width:0px;
border-width:1px !important;
}*/
.fidsTitle {
color:#3a3636 !important;
}
.tdPadding {
width:50% !important;
border-style:none;
border-width:0px;
}
.headerRow .tdPadding {
background-color:rgba(141,198,227,1) !important;
}
.odd .tdPadding {
background-color:rgba(141,198,227,1) !important;
}
.even .tdPadding {
background-color:rgba(255,255,255,1) !important;
}
.even .tdPadding:nth-child(1) {
background-color:rgba(195,229,244,0.65) !important;
}

</style>



<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>Region Airport for Gainesville, Florida</title>

        <script src="FlightviewStatus.js"></script>
        <script src="Redirect.js"></script>
        <script src="Timestamp.js"></script>
        <script src="Fids.js"></script>
        
        <link rel="stylesheet" href="Site.css" type="text/css" />
        <link rel="stylesheet" href="Access.css" type="text/css" />
        <link rel="stylesheet" href="FlightFinder.css" type="text/css" />
        <link rel="stylesheet" href="basic_Gainesville.css" type="text/css" />
        <link rel="stylesheet" href="ffterm_Gainesville.css" type="text/css" />
        <link rel="stylesheet" href="15401_Gainesville.css" type="text/css" />
    </head>
    <body onload="Clock()">
    <div class="background-image"></div> 
        <div class="fidsMain" style="width:100% !important">
        <div class="fidsLogo"><img src="Gainesville_Logo_3.jpg"></div>         
        <div class="fidsPrimary" style="width:100% !important">
        <h1 class="fidsTitle">Arrivals <span id=clock></span></h1>
                <div class="ffResult">
                <center>
                      <div class="" xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:msxml="urn:schemas-microsoft-com:xslt">


        <table class="flightTable" bgcolor=lightblue>

        <tr class="headerRow">
        <th class="tdPadding"></th>
        <th class="th_column1">Airline</th>
        <th class="th_column2">Flight</th>
        <th class="th_column3">From</th>
        <th class="th_column4">Time</th>
        <th class="th_column5">Status</th>
        <th class="tdPadding"></th>
        </tr>

<?PHP 
//Load XML file
$objDOM1 = new DOMDocument(); 
$objDOM1->load("/home/gragnv/public_html/DSIFlightView/arrivals.xml"); 
$Flight = $objDOM1->getElementsByTagName("row");

//Init row counter
$counter = 2;

//Do the work
foreach($Flight as $value)
{
    $FlightNumber = $value->getElementsByTagName("flight"); //Flight number here
    $NumberFlight = $FlightNumber->item(0)->nodeValue;
    
    $AirlineName = $value->getElementsByTagName("airline");
	$AN = trim(substr($AirlineName->item(0)->nodeValue, strpos($AirlineName->item(0)->nodeValue, ")") + 1));//Remove the airport's short name

    $FromCity = $value->getElementsByTagName("city");
	$FC = trim(substr($FromCity->item(0)->nodeValue, strpos($FromCity->item(0)->nodeValue, ")") + 1));//Remove the departure city short name
    
    $Status = $value->getElementsByTagName("status"); //Flight status
    $FlightStatus = $Status->item(0)->nodeValue;
     
    $estTimeArrival = $value->getElementsByTagName("est_time");
      $estTime = $estTimeArrival->item(0)->nodeValue;
      $TimeDepart = date("g:i A", strtotime($estTime." ".$est_date));      
    $estDateArrival = $value->getElementsByTagName("est_date");
      $estDate = $estDateArrival->item(0)->nodeValue;	
	
    if (strtotime($estTime." ".$est_date) - time() < ($GLOBALS['minsToShowFuture']*60) && strtotime($estTime." ".$est_date) - time() > ($GLOBALS['minsToShowPast']*60*(-1)))
    {
        
	    $airline = $value->ident;
	    echo "<tr class=\"";
	    if ($counter == 2)
	    {
		    echo "dataRow data even\">";
		    $counter = 1;
	    }
	    elseif ($counter == 1)
	    {
		    echo "dataRow data odd\">";
		    $counter = 2;
	    }
            echo "<td class=\"tdPadding\"></td>";

	    echo "<td class=\"td_column1\"><div>$AN</div></td>";

            echo "<td class=\"td_column2\">$NumberFlight</td>";
	     
	    echo "<td class=\"td_column3\">$FC</div></td>";

	    echo "<td class=\"td_column4\">$TimeDepart</td>";
            
	    echo "<td class=\"td_column5\">";
                        
	  
        echo ucwords($FlightStatus);
	    echo "</td>";

            echo "<td class=\"tdPadding\"></td>";
        echo "</tr>";
    }
}
?>
        </table>
   </body>
</html>