<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title><?php echo title?></title>

<!--<meta http-equiv="refresh" content="30;url=samplemaper.jsp">-->
<?php 
$userLoginName = $lat = $lon = $sid = $dir = $status = $report = $unit = $location = $statusEnd = $reportEnd = $unitEnd = $locationEnd = "";
if(isset($lati))
	$lat=$lati;
if(isset($long))
	$lon=$long;
if(isset($statusid))
	$sid=$statusid;
if(isset($direction))
	$dir=$direction;
if(isset($statusArr))
	$status=$statusArr;
if(isset($reportArr))
	$report=$reportArr;
if(isset($unitArr))
	$unit=$unitArr;
if(isset($locArr))
	$location=$locArr;

//String lat=request.getParameter("lati");
//String lon=request.getParameter("long");
//String sid=request.getParameter("statusid");
//String dir=request.getParameter("direction");
$lonend = $latend = $statend="";
if(isset($latendpost))
	$latend = $latendpost;
if(isset($lonendpost))
	$lonend =$lonendpost;

if(isset($statendpost))
	$statend =$statendpost;
if(isset($statusEndArr))
	$statusEnd=$statusEndArr;
if(isset($reportEndArr))
	$reportEnd=$reportEndArr;
if(isset($unitEndArr))
	$unitEnd=$unitEndArr;
if(isset($locEndArr))
	$locationEnd=$locEndArr;

$Unitname = "Ladle No. : ".$Unitnamepost."  ";

$Reportname = "Report Type : ".$Reportnamepost."  ";
$Groupname="Group Name : ".$Groupnamepost."  ";

?>
<link rel="shortcut icon" href="<?php echo asset_url()?>images/favicon.ico" />

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCzNXnFP26CcdfxZrvT2OP4q8GbdkdQ3aw"></script> 
<script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo asset_url();?>js/staticConstants.js"></script>
<style>
html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
           #map_canvas .terms-of-use-link {
	display: none;
}

#map_canvas div span {
	display: none;
}

#map_canvas div span {
	display: none;
}

#map_canvas div a {
	display: none;
}
 #map_canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    
<script type="text/javascript"><!--
var mapView;
function sleep(milliseconds) {
	var start = new Date().getTime();
	while ((new Date().getTime() - start) < milliseconds){
	// Do nothing
	}
	}


function movingDirc(mapDirection){
	   var directionIcon = "";
	   if(348.75 < mapDirection && mapDirection <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/0.png';
		else if(0 <= mapDirection && mapDirection <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/0.png'; 
		else if(11.25 < mapDirection && mapDirection <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/1.png';
		else if(33.75 < mapDirection && mapDirection <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/2.png';
		else if(56.25 < mapDirection && mapDirection <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/3.png';
		else if(78.75 < mapDirection && mapDirection <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/4.png';		
		else if(101.25 < mapDirection && mapDirection <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/5.png';
		else if(123.75 < mapDirection && mapDirection <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/6.png';
		else if(146.25 < mapDirection && mapDirection <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/7.png';
		else if(168.75 < mapDirection && mapDirection <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/8.png';
		else if(191.25 < mapDirection && mapDirection <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/9.png';
		else if(213.75 < mapDirection && mapDirection <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/10.png';
		else if(236.25 < mapDirection && mapDirection <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/11.png';
		else if(258.75 < mapDirection && mapDirection <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/12.png';
		else if(281.25 < mapDirection && mapDirection <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/13.png';
		else if(303.75 < mapDirection && mapDirection <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/14.png';
		else if(326.25 < mapDirection && mapDirection <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Moving/15.png';
		return directionIcon;
	}

function ignDirc(mapDirection){
		var directionIcon = "";
		if(348.75 < mapDirection && mapDirection <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/0.png';
		else if(0 <= mapDirection && mapDirection <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/0.png'; 
		else if(11.25 < mapDirection && mapDirection <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/1.png';
		else if(33.75 < mapDirection && mapDirection <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/2.png';
		else if(56.25 < mapDirection && mapDirection <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/3.png';
		else if(78.75 < mapDirection && mapDirection <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/4.png';		
		else if(101.25 < mapDirection && mapDirection <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/5.png';
		else if(123.75 < mapDirection && mapDirection <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/6.png';
		else if(146.25 < mapDirection && mapDirection <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/7.png';
		else if(168.75 < mapDirection && mapDirection <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/8.png';
		else if(191.25 < mapDirection && mapDirection <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/9.png';
		else if(213.75 < mapDirection && mapDirection <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/10.png';
		else if(236.25 < mapDirection && mapDirection <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/11.png';
		else if(258.75 < mapDirection && mapDirection <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/12.png';
		else if(281.25 < mapDirection && mapDirection <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/13.png';
		else if(303.75 < mapDirection && mapDirection <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/14.png';
		else if(326.25 < mapDirection && mapDirection <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Ignition/15.png';
		return directionIcon;
	}


function slowIdleDirc(mapDirection){
		var directionIcon = "";
		if(348.75 < mapDirection && mapDirection <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/0.png';
		else if(0 <= mapDirection && mapDirection <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/0.png'; 
		else if(11.25 < mapDirection && mapDirection <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/1.png';
		else if(33.75 < mapDirection && mapDirection <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/2.png';
		else if(56.25 < mapDirection && mapDirection <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/3.png';
		else if(78.75 < mapDirection && mapDirection <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/4.png';		
		else if(101.25 < mapDirection && mapDirection <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/5.png';
		else if(123.75 < mapDirection && mapDirection <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/6.png';
		else if(146.25 < mapDirection && mapDirection <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/7.png';
		else if(168.75 < mapDirection && mapDirection <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/8.png';
		else if(191.25 < mapDirection && mapDirection <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/9.png';
		else if(213.75 < mapDirection && mapDirection <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/10.png';
		else if(236.25 < mapDirection && mapDirection <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/11.png';
		else if(258.75 < mapDirection && mapDirection <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/12.png';
		else if(281.25 < mapDirection && mapDirection <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/13.png';
		else if(303.75 < mapDirection && mapDirection <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/14.png';
		else if(326.25 < mapDirection && mapDirection <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SlowIdle/15.png';
		return directionIcon;
	}

function overSpdDirc(mapDirection){
		var directionIcon = "";
		if(348.75 < mapDirection && mapDirection <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/0.png';
		else if(0 <= mapDirection && mapDirection <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/0.png'; 
		else if(11.25 < mapDirection && mapDirection <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/1.png';
		else if(33.75 < mapDirection && mapDirection <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/2.png';
		else if(56.25 < mapDirection && mapDirection <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/3.png';
		else if(78.75 < mapDirection && mapDirection <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/4.png';		
		else if(101.25 < mapDirection && mapDirection <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/5.png';
		else if(123.75 < mapDirection && mapDirection <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/6.png';
		else if(146.25 < mapDirection && mapDirection <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/7.png';
		else if(168.75 < mapDirection && mapDirection <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/8.png';
		else if(191.25 < mapDirection && mapDirection <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/9.png';
		else if(213.75 < mapDirection && mapDirection <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/10.png';
		else if(236.25 < mapDirection && mapDirection <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/11.png';
		else if(258.75 < mapDirection && mapDirection <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/12.png';
		else if(281.25 < mapDirection && mapDirection <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/13.png';
		else if(303.75 < mapDirection && mapDirection <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/14.png';
		else if(326.25 < mapDirection && mapDirection <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Overspeed/15.png';
		return directionIcon;
	}

	function suddenDirc(mapDirection){
		var directionIcon = "";
		if(348.75 < mapDirection && mapDirection <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/0.png';
		else if(0 <= mapDirection && mapDirection <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/0.png'; 
		else if(11.25 < mapDirection && mapDirection <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/1.png';
		else if(33.75 < mapDirection && mapDirection <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/2.png';
		else if(56.25 < mapDirection && mapDirection <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/3.png';
		else if(78.75 < mapDirection && mapDirection <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/4.png';		
		else if(101.25 < mapDirection && mapDirection <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/5.png';
		else if(123.75 < mapDirection && mapDirection <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/6.png';
		else if(146.25 < mapDirection && mapDirection <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/7.png';
		else if(168.75 < mapDirection && mapDirection <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/8.png';
		else if(191.25 < mapDirection && mapDirection <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/9.png';
		else if(213.75 < mapDirection && mapDirection <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/10.png';
		else if(236.25 < mapDirection && mapDirection <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/11.png';
		else if(258.75 < mapDirection && mapDirection <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/12.png';
		else if(281.25 < mapDirection && mapDirection <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/13.png';
		else if(303.75 < mapDirection && mapDirection <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/14.png';
		else if(326.25 < mapDirection && mapDirection <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/SuddenBreak/15.png';
		return directionIcon;
	}

	function geoDirc(mapDirection){
		var directionIcon = "";
		if(348.75 < directionArr[i] && directionArr[i] <= 360)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/0.png';
		else if(0 <= directionArr[i] && directionArr[i] <= 11.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/0.png'; 
		else if(11.25 < directionArr[i] && directionArr[i] <= 33.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/1.png';
		else if(33.75 < directionArr[i] && directionArr[i] <= 56.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/2.png';
		else if(56.25 < directionArr[i] && directionArr[i] <= 78.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/3.png';
		else if(78.75 < directionArr[i] && directionArr[i] <= 101.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/4.png';		
		else if(101.25 < directionArr[i] && directionArr[i] <= 123.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/5.png';
		else if(123.75 < directionArr[i] && directionArr[i] <= 146.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/6.png';
		else if(146.25 < directionArr[i] && directionArr[i] <= 168.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/7.png';
		else if(168.75 < directionArr[i] && directionArr[i] <= 191.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/8.png';
		else if(191.25 < directionArr[i] && directionArr[i] <= 213.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/9.png';
		else if(213.75 < directionArr[i] && directionArr[i] <= 236.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/10.png';
		else if(236.25 < directionArr[i] && directionArr[i] <= 258.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/11.png';
		else if(258.75 < directionArr[i] && directionArr[i] <= 281.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/12.png';
		else if(281.25 < directionArr[i] && directionArr[i] <= 303.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/13.png';
		else if(303.75 < directionArr[i] && directionArr[i] <= 326.25)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/14.png';
		else if(326.25 < directionArr[i] && directionArr[i] <= 348.75)
			directionIcon = baseUrl+'MapIcon/direction_icons/Geo/15.png';
		return directionIcon;
	}

  function initialize() {
	  /* popup window clicking on reports in context menu of fleetview and set the mapview.Mainly for RouteReport popup*/
	  mapView = document.getElementById("mapView").value;
	  switch(mapView){
	  	case "H": mapView=google.maps.MapTypeId.HYBRID;break;
	  	case "M": mapView=google.maps.MapTypeId.ROADMAP;break;
	  	case "S": mapView=google.maps.MapTypeId.SATELLITE;break;
	  	default : mapView=google.maps.MapTypeId.ROADMAP;break;
	  }
var unitNamer = new Array();
if(document.getElementById('Groupname').innerHTML=="UnitName:null")
	var unitnames=document.getElementById('Groupname').value;
else
var unitnames=document.getElementById('Unitname').innerHTML;
unitNamer=unitnames.split(":");
var unit=unitNamer[1];

	  var latArr=new Array();
		var lat=document.getElementById('lat').value;
		latArr=lat.split(",");

		var lonArr=new Array();
		var lon=document.getElementById('lon').value;
		lonArr=lon.split(",");

		var locArr=new Array();
		var loc=document.getElementById('location').innerHTML;
		locArr=loc.split("_");
		var statusArr=new Array();
		var status=document.getElementById('status').innerHTML;
		statusArr=status.split("_");

		var unitArr=new Array();
		var unit=document.getElementById('unit').innerHTML;
		unitArr=unit.split("_");

		var reportArr=new Array();
		var report=document.getElementById('report').innerHTML;
		reportArr=report.split("_");
		var sidArr=new Array();
		var sid=document.getElementById('sid').value;
		sidArr=sid.split(",");
		

		var latendArr=new Array();
		var latend=document.getElementById('latend').value;
		latendArr=latend.split(",");

		var lonendArr=new Array();
		var lonend=document.getElementById('lonend').value;
		lonendArr=lonend.split(",");
		
		
		var sidendArr=new Array();
		var sidend=document.getElementById('statend').value;
		sidendArr=sidend.split(",");

		var locEndArr=new Array();
		var locEnd=document.getElementById('locationEnd').innerHTML;
		locEndArr=locEnd.split("_");
		
		var statusEndArr=new Array();
		var statusEnd=document.getElementById('statusEnd').innerHTML;
		statusEndArr=statusEnd.split("_");

		var unitEndArr=new Array();
		var unitEnd=document.getElementById('unitEnd').innerHTML;
		unitEndArr=unitEnd.split("_");

		var reportEndArr=new Array();
		var reportEnd=document.getElementById('reportEnd').innerHTML;
		reportEndArr=reportEnd.split("_");
		if(latend.length>0)
		{
		var k=latArr.length;
		for(var j=0;j<latendArr.length;j++)
		{
			latArr[k]=latendArr[j];
			lonArr[k]=lonendArr[j];
			sidArr[k]=sidendArr[j];
			locArr[k]=locEndArr[j];
			statusArr[k]=statusEndArr[j];
			unitArr[k]=unitEndArr[j];
			reportArr[k]=reportEndArr[j];
			
			k++;
			}
		}
		var dirArr=new Array();
		var dir=document.getElementById('dir').value;
		if(dir.length>0)
		dirArr=dir.split(",");

		

		 
    // Create the map 
    // No need to specify zoom and center as we fit the map further down.
    
    var myOptions = {
    		
    mapTypeControl: true,
    mapTypeControlOptions: {
   	 mapTypeIds: [
   	                google.maps.MapTypeId.ROADMAP, 
   	                google.maps.MapTypeId.SATELLITE, 
   	                google.maps.MapTypeId.HYBRID
   	            ]
   },
    zoomControl: true,
    navigationControl: false,
    gestureHandling: 'greedy',
    streetViewControl: false,
    navigationControlOptions: {
      style: google.maps.ZoomControlStyle.ZOOM_PAN
    },
    mapTypeId: mapView
  }
  var map = new google.maps.Map(document.getElementById("map_canvas"),
      myOptions);
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
    // Create the shared infowindow with two DIV placeholders
    // One for a text string, the other for the StreetView panorama.
   var content = document.createElement("DIV");
    
    var title = document.createElement("DIV");
    content.appendChild(title);
    
    var infomyOptions = {
            content: content
           ,disableAutoPan: false
           ,maxWidth: 0
           ,pixelOffset: new google.maps.Size(-133, 15)
           ,zIndex: 20
           ,boxStyle: { 
             background: "url('MapIcon/infobox/tipbox.gif') no-repeat",
             
             color:'#FFFFFF'
             ,opacity: 1
             
             ,width: "280px"
            }
           ,closeBoxMargin: "10px 2px 2px 2px"
           ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
           ,infoBoxClearance: new google.maps.Size(0, 0)
           ,isHidden: false
           ,pane: "floatPane"
           ,enableEventPropagation: false
   };
    var infowindow = new InfoBox(infomyOptions);


    
    var markers;
    // Define the list of markers.
    // This could be generated server-side with a script creating the array.
    
  var markerIcon="";
    var directionIcon="";
  
    

    // Create the markers
    
    var markerIconArr = new Array();
   	    markerIconArr[1] = "IgnOff.png";
   	    markerIconArr[2] = "Moving.png";
   	    markerIconArr[3] = "SuddenBreak.png";
   	    markerIconArr[6] = "Illegal.png";
   	    markerIconArr[12] = "IgnOn.png";
   	    markerIconArr[13] = "OverSpeed.png";
   	    markerIconArr[15] = "IdleEnd.png";
   	    markerIconArr[16] = "Illegal.png";
   	    markerIconArr[17] = "IdleStart.png";
   	    markerIconArr[18] = "NoResponse.png";
   	    markerIconArr[19] = "NoGps.png";
   	    markerIconArr[20] = "NoPower.png";
   	    markerIconArr[21] = "NoResponse.png";

   	    markerIconArr["start"] = "IgnOn.png";
	    markerIconArr["end"] = "IgnOff.png";
	    markerIconArr["geoStart"] = "Moving.png";
	    markerIconArr["geoEnd"] = "Moving.png";
  
    
   for ( var i = 0; i < latArr.length; i++) 
	{
	   markerIcon = baseUrl+'MapIcon/fill_icons/'+markerIconArr[sidArr[i]];
	   
	   var markerImage = new google.maps.MarkerImage(
			   markerIcon,
			   new google.maps.Size(13, 13),
		        new google.maps.Point(0,0),
		        new google.maps.Point(0, 0),
		        new google.maps.Size(13, 13));
			  
	   if(dirArr[i]=="")
			directionIcon = '';
	   else{
			   var dir = dirArr[i], locationSub = locArr[i];
				directionIcon = '';
				//console.log("stta"+sidArr); 
				//console.log("sttaoo-"+i);
				switch(sidArr[i]){
					case "2": if(locationSub.substring(0,3)!='Geo'){directionIcon = movingDirc(dir);}break;
   					case "3": if(locationSub.substring(0,3)!='Geo'){directionIcon = suddenDirc(dir);}break;
   					case "6": directionIcon = geoDirc(dir);break;
   					case "12": if(locationSub.substring(0,3)!='Geo'){directionIcon = ignDirc(dir);}break;
   					case "13": if(locationSub.substring(0,3)!='Geo'){directionIcon = overSpdDirc(dir);}break;   
   					case "15": if(locationSub.substring(0,3)!='Geo'){directionIcon = slowIdleDirc(dir);}break;   										
   					default : if(locationSub.substring(0,3)=='Geo'){directionIcon = geoDirc(dir);}else{directionIcon = "";}break;
				}	
		   }
		
	   var directionImage = new google.maps.MarkerImage(
			   directionIcon,
			   new google.maps.Size(13, 13),
		        new google.maps.Point(0,0),
		        new google.maps.Point(0, 0),
		        new google.maps.Size(13, 13));
		
		   if(directionIcon=="")
		   {
		        addMarker(latArr[i],lonArr[i],locArr[i],unitArr[i],reportArr[i],statusArr[i],markerImage);
		   }
		   else
		   {
			   addMarkerStatus(latArr[i],lonArr[i],locArr[i],unitArr[i],reportArr[i],statusArr[i],markerImage,directionImage);
		   }

		}
 

    function addMarkerStatus(lat,longi,loc,unit,report,status,markerImage,directionImage) {
    	var contents = document.createElement("div");
    	contents.style.cssText = "border: 5px double #D4BF37; margin-top: 8px; background: #00B050; padding: 5px;";
    	contents.innerHTML = '<div  style="font:bolder 11px tahoma, arial, helvetica, sans-serif;">'+unit.replace(/,/g,' ')+'<br/>'+loc.replace(/,/g,' ')+'<br/>'+report.replace(/,/g,' ')+'<br/>'+status.replace(/,/g,' ')+'</div>';
  	   var marker = new google.maps.Marker({
		 position: new google.maps.LatLng(lat, longi),
		 icon:directionImage,
		 map: map,
		 //shadow:markerImage,
		 title: unit.replace(/,/g,' ')
		 });
		 google.maps.event.addListener(marker, "click", function() {
			 openInfoWindow(marker,contents);
		 });
	}

    function addMarker(lat,longi,loc,unit,report,status,markerImage) {
    	var contents = document.createElement("div");
    	contents.style.cssText = "border: 5px double #D4BF37; margin-top: 8px; background: #00B050; padding: 5px;";
    	contents.innerHTML = '<div  style="font:bolder 11px tahoma, arial, helvetica, sans-serif;">'+unit.replace(/,/g,' ')+'<br/>'+loc.replace(/,/g,' ')+'<br/>'+report.replace(/,/g,' ')+'<br/>'+status.replace(/,/g,' ')+'</div>';

 	   var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, longi),
		icon:markerImage,
		map: map,
		     title: unit.replace(/,/g,' ')
		});
		google.maps.event.addListener(marker, "click", function() {
			openInfoWindow(marker,contents);
		});
	}

    // Zoom and center the map to fit the markers
    // This logic could be conbined with the marker creation.
    // Just keeping it separate for code clarity.
    var bounds = new google.maps.LatLngBounds();
   
    for ( var i = 0; i < latArr.length; i++) {
  
   bounds.extend(new google.maps.LatLng(latArr[i],lonArr[i]));
   if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
	   var extendPoint = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.009, bounds.getNorthEast().lng() + 0.00);
	   bounds.extend(extendPoint);
	}
 }
    
 	map.fitBounds(bounds); 
 
    // Handle the DOM ready event to create the StreetView panorama
    // as it can only be created once the DIV inside the infowindow is loaded in the DOM.
    var panorama = null;
    var pin = new google.maps.MVCObject();
   
    // Set the infowindow content and display it on marker click.
    // Use a 'pin' MVCObject as the order of the domready and marker click events is not garanteed.
    function openInfoWindow(marker,contents) {
	   title.innerHTML = marker.getTitle();
	   pin.set("position", marker.getPosition());
	   infowindow.open(map, marker);
	   infowindow.setContent(contents);
	    }
  }

  window.unclutter = function() {
      var executed = false;
      var images = document.getElementsByTagName('img');
      for (var index = 0; index < images.length; index++) {
          var node = images[index];
          if (node.src && node.src.indexOf("mapfiles/poweredby.icon") > 0) {
              node.style.display = 'none';
              executed = true;
          }
      }

      if (! executed) {
          setTimeout(window.unclutter, 250);
      }
  };
</script> 
</head> 
<body onload="initialize()" style="overflow: hidden;margin: -2px 0% 0% -0px;width: auto;"> 
		<?php 
	
	if($Unitnamepost == null) {
	?>
	<input type="hidden" style="border: none; " id="Unitname" value="<?php echo $Unitname?>">
	<?php  }else{ ?>

	<div style="font:normal 12px tahoma, arial, helvetica, sans-serif;" id="Unitname"><?php echo $Unitname?>  <span style="padding-left:10%"><?php echo $Reportname?></span> </div>

	<?php  }?>
	<?php 
	if($Groupnamepost == null){
	?>
	<input type="hidden" style="border: none;width:auto;" id="Groupname" value="<?php echo $Groupname?>"> 
	<?php  }else{ ?>
<div style="font:normal 12px tahoma, arial, helvetica, sans-serif;" id="Groupname"><?php echo $Groupname?>   <span style="padding-left:10%"><?php echo $Reportname?></span></div>
	<?php  }?>


<div id="map_canvas"></div>
<div id="myMapContainerId"></div>

<input type="hidden" id="lat" value="<?php echo $lat?>">
<input type="hidden" id="lon" value="<?php echo $lon?>">
<input type="hidden" id="sid" value="<?php echo $sid?>">
<input type="hidden" id="dir" value="<?php echo $dir?>">	
<input type="hidden" id="latend" value="<?php echo $latend?>">
<input type="hidden" id="lonend" value="<?php echo $lonend?>">
<input type="hidden" id="statend" value="<?php echo $statend?>">
<div style="visibility:hidden" id="status"><?php echo $status?></div>
<div style="visibility:hidden" id="location"><?php echo $location?></div>
<div style="visibility:hidden" id="unit"><?php echo $unit?></div>
<div style="visibility:hidden" id="report"><?php echo $report?></div>
<div style="visibility:hidden" id="statusEnd"><?php echo $statusEnd?></div>
<div style="visibility:hidden" id="locationEnd"><?php echo $locationEnd?></div>
<div style="visibility:hidden" id="unitEnd"><?php echo $unitEnd?></div>
<div style="visibility:hidden" id="reportEnd"><?php echo $reportEnd?></div>
<input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView?>">


</body>
</html>
