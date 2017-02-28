<?php
//XML to HTML FIDS parser
//Originally written by Eric Pine ericpine@datasystems-fl.com
//Rewritten by Tyler Mays on 5/5/2013 tyler@bitcraft-fl.com

//............................................                                            .  .   . .  
//........ ......................  ............ ...:,.   .        . .. .. .. .        . ........ ...  
//......   ..             . ...,$DDMD$ODI...  . .?N7IDZDM.. . ..  . ........ .. . ..  . ..............
//......      ..  .  ..   ..,~ZO????????IOO8ZI~78I????I?IDO?:.      .                   .    ..  . .  
//......   .. ..  .  ..  .$OI??????7ZMDZDMI?7ZOMI?????I??I$ZDM    . .. .. .. .  .     . ........ ...  
//.... .      ..  ..  .,OD??????IZZ$D+?$7$OM?7Z$OZZI???????$Z$O..   .. .. .. .        . ........ ...  
//......     ..=$OONDMDO???????I$ZZDDM+:,~87M$ZZZZZZZZZZZZZZZZODDO?,.. .. .. ..      .. ........ ...  
//.......,+OO$7??????I77??????$88OZO8. IMM?D$ZZZZZZ7I?I?I7$777ZZ$I?IZO$,.....             . . .. .    
//.... ?NZI????????7ZZ$I???????+??I??OI.II,=DZMO7II??7$??????????I?????O8M888?..      . ............ .
//...=DI?????????7ZZZ$$????????$7???O??8DDO$O???????????????????77+?II7??????IM7$I,.  . ..............
//..M$?????????IZZZZDM????????ZZZ????MDZ$ZMD??I$?$I??III????????I?MD7I???I7I??????DM... ........ .... 
//IMI????????I$ZZZ$I??????????II$I?????I7I???IZZZ$?????ZZZ$????????777N$?????IZ$????DDD? .            
//???????????$ZZZ7????????????????II????7$ZZ7????????ZZ??????I?????????7??7MOZZZZZZZZZZ$N$I..... ...  
//???????????ZZZZ$?????????????????????????????????7ZZZZ$????????????$7????$OOMZZZZZZZZZZ$ZMO... .    
//??????????IZZZZI????????????????????????????????7ZZZZZZZZ$I???????I7I????II??D8ZZZZZZZZZZZO8=.......
//?????????$$$8$?????????????????????????I$77777$ZZZZZZZZZZZZZ$I?????????ZI????I$$ZZZZZZZZZZZZZ$,.....
//????IZ7?IZZMO?????????????7ZZ77???????????7$ZZZZZZZZZZZI??II??7????????????Z7???7ZZZZZZZZZZZZ$D.....
//????$Z??IZ$DZ???????????????77I????????????????7ZZZZZZZZZZ7????????????????77?????????ZZZZZZZZ$M?...
//????$???IZ$DZ?????????????????????????????????ZZZZZZZZZZZZZZ$?????????????????????$MM8?ZZZZZZZZZM:..
//????????IZOZZ????????????????????????????II7ZZZZZZZZZZZZZZZ$I7I???????????????????I$MMM8ZZZZZZZ$D=..
//????????IZZOZ??????????????????????7ZZZZZZZZZZZZZZZZZZZZZZZI??????I$Z$7I??????????Z7?7MM8ZZZZZZ$D=..
//?????I$IIZ$OZ7???????????????????????$ZZZZZZZZZZZZZZZZZZZZZZ????????I??I??I$7?????7ZZZZZZZZZZZZ$D:..
//??$7ZZ??7Z$8ZZ$?????????????????????7ZZZZZZZZZZZZZZZZZZZZ$ZI???????????????I?II???IZZZZZZZZZZZZZD,..
//??Z$ZI??$ZZMZZZ$???????????????????$ZZZZZZZZZZZZZZZZZIIZ$IZI?????????????????????IZZZZZZZZZZZZZZD,..
//??ZZ???ZZ$O$ZODMM8OZZ$I????$Z??$Z??IZZZZZZZZZZZZZZZZZ$?ZZIZZ$Z??Z7??$?????????????ZZZZZZZZZZZZZZM,..
//?IZZ??ZZ$DDZZZZZZDD8MMOO$$ZZZZZZZI??$ZZZZZZZZZZZZZZZ$ZZZZZZZZZ??ZZ?IZ?????????????ZZZZZZZZZZZZZMI...
//?7ZI??ZZDOZ$$ZZZZZDM$Z88DDM888Z$ZZZ$$$Z$ZZ88MMMMDMOMMM888OZO$$$$ZZ?Z$???ZI?7Z??I$IZZZZZZZZZ$$DM.....
//?77??$ZNNZZ?7ZZZZZZZOZNDO88888888OD88888888888888DOD=DD=MZ.ZZ+NNZ8N8OOOZZ$7ZZZZZZZZZOO8O8DDI7O~.....
//??I?$ZNO8$??$ZZZZZZZOM$$888888888888888888888888888MNDON8ZM8$.?I.+M:,M7..MO,$O~~$M,,OO..7O=?M~......
//I?I?Z$DO8I?IZ$?7Z7??Z$OZDD8888888888888888888888888888M88MO$IO.O~ON.?=O.+7$=OI..O$.+?O.=Z8.OM.......
//$???Z$OD8??IZ7??77???7MDZD8O88888888888888888888888888888Z,.M=,OO~I=O+O~M7+O,?.::I=O~O:M~$IM~ ......
//Z$??$Z$DOI??Z?????????IOZZDNO888888888888888888888888888?.....:Z.,D+.O=D,DO..7IO,D?.I$$,.=~.........
//IZ??7O7D8I??7I??????????MO$ON8888888888888888888888888O..............OM. ,...M=..: .OO..............
//?7I?7DIO8$???$????????I?$M77OO88888888888888888888888$,............. :  .....  .....................
//$?$?ZM?7NZ7??7Z???????$I?Z$I?M88888888888888888888888...............................................
//D?ZIOD??D$Z???7ZI?????IZ??NZ?7MO8888888888888888888$:...............................................
//$?ZZDDOIIDZ$???7Z7??????ZI$88??D8O88888D88888888888. ...............................................
//$?Z$8?NZ?MDZ$????ZZZI???7ZZ$D??MD8888888M888888888~.................................................
//$I$M??8D$?D$ZI?????$$I???7ZZZZ?7M88888888NO88888O:..................................................
//Z$NZ$7?88I?N8$$?????ZI????$ZZNZ?788888NN88M88888I...................................................
//ZZ7?$II?8Z$??DZ$I????I????I$ZZZ??M888888M8ON888$,...................................................
//OMIZ7I?7IMOI?IM$ZI?????????IZZZ??7M888888M88NDO:....................................................
//8ZZZZ77?$?87I??M8Z7?????????$ZZ7??D8888OO8D88MI.....................................................
//O?ZZOD$??$IZD7IZ$D8Z$I??????IZZZ7??MNODN8ODN88$7D...................................................
//+?Z$ZD7$??Z??$ZZZZZM$Z$I?????ZZZZ??D+8O8MD8888OM+,? ................................................
//$ZZZ7D?Z7??ZI?7$ZZ$$NDZZ?????$ZZZ$?7MDI:N888MD8MO7M.................................................
//$IZZ????$??IZ??MZZZZZZ8$ZI????Z?7Z7?O+7NDMMD8888MI.IM,..............................................
//$?7ZI???IZI??ZIIDOZZZZOM$ZI???I7?ZZ??NMO ~8888888MM~N...............................................
//7???$III??$??DMMMMOZZZZZMDZZ7??$$?$I?ZI?NNMN8888OO8$I=..............................................
//DO???I?ZI?IDMMMMDZOMDODM.+OZZ7??I?7$?IMO.~88DD88NO88N,... ..........................................
//$8??????$?$MMMMM8ZZZZZZZ7.$M$Z7????ZMI7MMNMOMD888MDO8DMMO...........................................
//?8??I7??INMMMMM8ODZZZZZZ8,.,8$Z????7OZ?$7+:O88DND88N888D8:.: .......................................
//I+O???ZI8$ZMM8ZD8ZODDDDD?. ..M8ZI???$DI?8OMM$:$N8888OMD88DMO........................................
//I?DO??7DO??I$ZZMZZZZZZZ$M? ...$$Z????$M7DM,.,ONN88888888888N,.......................................
//Z7IM7?IM7???$ZZD8$$$Z$ZZOM.....MZ$????OM?M.?DNMMD88NMD8O8888M:......................................
//?7I?NON$???$ONMDMMMMMMOOZD,....,Z$$????Z??MI:~N88888DON8NO888M......................................
//?IZ7?OI???I87DMMMMMM8ZZZDM.. .. .MZI????M?Z8MDDON8888N:.?ZOMO= .....................................
//7?ZZDD???DD?IDMMMMMDZZOOZ8,. .. .~MZ$???DD?Z$~$D8ODN88MMMO+O..~.....................................
//777$Z??+8I???7ZDDODDZZZZZZ7. .....=7Z7?7?D??OI88N+=8888I.?O.$OO, ...................................
//?Z$M??ODI??????+?DOZZZZZZZM~... . .MOZ$I77O?ZN?:.MD88O8NOMOO,O.. ...................................
//I?8I?????????MO??N$ZZZZZZZD7 .. . ..+DZZZZOM$$MNNM$ON888M.~O=ON7 ...................................
//ZID?????????8$Z??$MZZZZZZZN+... . .. $DZZZ$OZZOM,.IO8DM88MMM~~+. ...................................
//Z$D????????8M$ZZ7?78DZZ$Z8?. .. .... .?M$ZZZD8$ODM8MO7D88$..OMM~....................................
//77M7?????ZD??DNZZZ$7I7$8ZZZ. .. . ..   .O8ZZZZOZZN$:$8DZ$8ZODZ......................................
//??DD??8DNZZZ7??MOZZZZZZZZZ8O... . ..   . .$M$ZOM8Z$MM..MI7MM.. .....................................
//??OD??I$OOZZZZZ?DOZZZZZZZZOM:...............?MOZOD$Z$NMOM887........................................
//??8$???$ZMZZZZZI?DZZZZZZZZZD~.. . ..   ..   ..,+OMMZZ$ZZ$OO,......:=??= ............................
//??8?????$ZNZZZZZZ$OD8ZZZZZ8D... . ..   ..   ........:=?7?, ...IONMMMMO$?+...........................
//?7MI?????$OOZZZZZZZZ$ODMDM$. .. . ..   ..   ...............=8Z????OM~...............................
//$DMO?????$ZDZZZZZZZZZZZZZZOM~.. . ..   ..   .........,=+$DDI??????$D?...............................
//$ZDM+????$$DZZZZZZZZZZZZZZZ$8. .. ..   ..   .......=M$I???????I7$ZZM=...............................
//??$MDD???7$OZZZZZZZZZZZZZZZZOO  . ..   ..   .....IMI????I$ZZM8DMDMO$8:..............................
?>
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
        <div class="fidsMain">
        <div class="fidsLogo"><img src="Gainesville_Logo_3.jpg"></div>         
        <div class="fidsPrimary">
        <h1 class="fidsTitle">Arrivals <span id=clock></span></h1>
                <div class="ffResult">
                <center>
                      <div class="ffResultList" xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:msxml="urn:schemas-microsoft-com:xslt">
        <div class="header">
        <table cellspacing="0" border="0" cellpadding="0" bgcolor="lightblue" style="text-align:center;">
        <tr>
        <th class="column1" style="width:30%">Airline</th>
        <th class="column2" style="width:9%">Flight#</th>
        <th class="column4" style="width:20%">Origin</th>
        <th class="column6" style="width:14%">Time</th>
        <th class="column3" style="width:27%">Status</th>
        </tr>
        </table>
        </div>
        <div class="data">
        <table cellspacing="0" border="0" cellpadding="0" width="100%" style="white-space:nowrap;text-align:center;">
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
    
    $Status = $value->getElementsByTagName("status"); //Flight status
    $FlightStatus = $Status->item(0)->nodeValue;
    
    $DestinationCity = $value->getElementsByTagName("city");
	$CityDestination = substr($DestinationCity->item(0)->nodeValue, strpos($DestinationCity->item(0)->nodeValue, ")") + 1);//Remove the airport's short name
    
    $DepartTime = $value->getElementsByTagName("est_time");//This may be the wrong value!
	$TimeDepart = $DepartTime->item(0)->nodeValue;
    $TimeDepart = date("g:i A", strtotime($TimeDepart));
        
    if ((time() - strtotime($DepartTime->item(0)->nodeValue)) < 7200  || $FlightStatus == 'Delayed')
    {
        
        $airline = $value->ident;
        echo "<tr class=\"";
        if ($counter == 2)
        {
            echo "data even\">";
            $counter = 1;
        }
        elseif ($counter == 1)
        {
            echo "data odd\">";
            $counter = 2;
        }

        echo "<td style=\"width:30%\">";
        echo $AN;
        echo "</td><td style=\"width:9%\">";
        echo $NumberFlight;
        echo "</td><td style=\"width:20%\">";

        // print status
        echo $CityDestination; //. "," . $StateDestination;

        // html formatting

        echo "<td style=\"width:14%\"><span class=\"city\">";

        // output city and state

        echo $TimeDepart;
        
        // html formatting

        echo "</td><td style=\"width:27%\"><p>";

        // output departure time
        echo ucwords($FlightStatus);
        echo "</p></td>";
        
        echo "</tr>";
    }
}

#close html table with departure results
echo "</table>";

#####################End Load XML from arrivals.xml and output data####################

##################### HTML formatting for results table for departures ####################
#                                                                                         #
###########################################################################################
echo "</div></div></center></div></div><div class=\"fidsSecondary\"><h1 class=\"fidsTitle\">Departures</h1><div class=\"ffResult\"><center><div class=\"ffResultList\">
<div class=\"header\"><table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" style='text-align:center;'><tr>
<th class=\"column1\" style=\"width:30%\">Airline</th>
<th class=\"column2\" style=\"width:9%\">Flight#</th>
<th class=\"column4\" style=\"width:20%\">Origin</th>
<th class=\"column6\" style=\"width:14%\">Time</th>
<th class=\"column3\" style=\"width:27%\">Status</th>
</tr></table></div><div class=\"data\"><table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" style='text-align:center;'>";

##################### End HTML formatting for results table for departures ####################

#######################Load XML from departures.xml and output data########################
#                                                                                         #
###########################################################################################
$objDOM2 = new DOMDocument(); 
$objDOM2->load("/home/gragnv/public_html/DSIFlightView/departures.xml"); 
$Flight = $objDOM2->getElementsByTagName("row");

//Init row counter
$counter = 2;

//Do the work
foreach($Flight as $value)
{
    $FlightNumber = $value->getElementsByTagName("flight"); //Flight number here
    $NumberFlight = $FlightNumber->item(0)->nodeValue;
    
    $AirlineName = $value->getElementsByTagName("airline");
	$AN = trim(substr($AirlineName->item(0)->nodeValue, strpos($AirlineName->item(0)->nodeValue, ")") + 1));//Remove the airport's short name
    
    $Status = $value->getElementsByTagName("status"); //Flight status
    $FlightStatus = $Status->item(0)->nodeValue;
    
    $DestinationCity = $value->getElementsByTagName("city");
	$CityDestination = substr($DestinationCity->item(0)->nodeValue, strpos($DestinationCity->item(0)->nodeValue, ")") + 1);//Remove the airport's short name
    
    $DepartTime = $value->getElementsByTagName("est_time");
	$TimeDepart = $DepartTime->item(0)->nodeValue;
    $TimeDepart = date("g:i A", strtotime($TimeDepart));
        
    if ((time() - strtotime($DepartTime->item(0)->nodeValue)) < 7200 || $FlightStatus == 'Delayed')
    {
        
        $airline = $value->ident;
        echo "<tr class=\"";
        if ($counter == 2)
        {
            echo "data even\">";
            $counter = 1;
        }
        elseif ($counter == 1)
        {
            echo "data odd\">";
            $counter = 2;
        }

        echo "<td style=\"width:30%\">";
        echo $AN;
        echo "</td><td style=\"width:9%\">";
        echo $NumberFlight;
        echo "</td><td style=\"width:20%\">";

        // print status
        echo $CityDestination; //. "," . $StateDestination;

        // html formatting

        echo "<td style=\"width:14%\"><span class=\"city\">";

        // output city and state

        echo $TimeDepart;
        
        // html formatting

        echo "</td><td style=\"width:27%\"><p>";

        // output departure time
        echo ucwords($FlightStatus);
        echo "</p></td>";
        
        echo "</tr>";
    }
}
?>
        </table>
    </body>
</html>