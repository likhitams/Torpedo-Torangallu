<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/bootstrap-datepicker.css" rel="stylesheet">
    
    <style>
		
		  /* Always set the map height explicitly to define the size of the div   
		   * element that contains the map. */
		  #map {
			height: 100%;
			
		  }
		  /* Optional: Makes the sample page fill the window. */
		  html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		  }
		  
		  .gm-style{
			  
		  }
		  
		  .upt{
			  display:none;
		  }
		  
		  
.scrollFix h3 {
    border-bottom: 1px solid #ccc;
    font-size: 14px;
    margin: 0 0 12px;
    padding: 5px 0 8px;
	
}
.scrollFix ul {
    list-style: outside none none;
    padding: 0;
}
.scrollFix ul li {
    margin-bottom: 5px;
}
.scrollFix {
    float: left;
    width: 100%;
	min-width:150px;
	border-radius:15px;
}
/*.gm-style-iw > div {
    display: list-item;
    width: 100%;
}*/
.gm-style div {
}
/*.scrollFix img {
    position: absolute;
    right: -18px;
    top: 3px;
}*/

		  
		.gm-style-cc {
			display: none;
		}
		.gmnoprint {
			position: absolute;
			top: 0;
			left: 0;
		}
		
		html, body{
	overflow:hidden;
}

	.refresh {
	    background-color: #fff;
	    border-radius: 100%;
	    bottom: 10px;
	    box-shadow: 0 0 12px -1px #505050;
	    cursor: pointer;
	    font-size: 18px;
	    height: 50px;
	    padding: 13px;
	    position: fixed;
	    right: 10px;
	    text-align: center;
	    width: 50px;
	    z-index: 999;
	}
	
	
	
	.refresh:hover {
	    background-color: #005596;
		color:#fff;
	}
	
	.refresh:hover i {
	    transform: rotate(360deg);
		-moz-transform: rotate(360deg);
		-webkit-transform: rotate(360deg);
		-ms-transform: rotate(360deg);
		-o-transform: rotate(360deg);
	}
	.refresh i {
	    transition: all 0.5s ease 0s;
		-o-transition: all 0.5s ease 0s;
		-moz-transition: all 0.5s ease 0s;
		-ms-transition: all 0.5s ease 0s;
		-webkit-transition: all 0.5s ease 0s;
	}

.gm-style div {
   /*margin-top: 20px;*/
}
.battery_icon {
    position: absolute;
    right: 25px;
    top: 2px;
}

.battery_icon > img {
    width: 12px;
}

.gm-style div {
    border-radius: 14px!important;
}

.gmnoprint{
	display: none;
}

		
	</style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php echo $updatelogin;
    
    $uid = $detail[0]->userId;
    $compny = $detail[0]->companyid;
    $language = $detail[0]->language;
    
    
    ?>
    <style type="text/css">
    /* fix for unwanted scroll bar in InfoWindow */
	.scrollFix {
		line-height: 1.35;
		overflow: hidden;
		white-space: nowrap;
	}
    </style>
  </head>
  <body onload="getData();">
  <span class="refresh"  title="Refresh" onclick="refreshMarkers();"><i class="fa fa-refresh" aria-hidden="true"></i></span>
   <?php echo $header;?>
    
   <div id="map"></div>
  
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzNXnFP26CcdfxZrvT2OP4q8GbdkdQ3aw"></script>
    
    <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
    <script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
    <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>


<?php echo $jsfile;?>

 <script>
 var on = true;
 	var baseUrl = '<?php echo jquery_url()?>assets/direction_icons1/';
    var httpResponse, map, activeInfoWindow ;	
    var gmarkers = [], newFeature = [];
    var lineCoordinates=new Array();
    var polyArr=new Array(), mapPolyLabelArr = new Array(), statusesArr = new Array();
    var latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array();
    function getData(){
	    var httpRequest = new XMLHttpRequest();
	    httpRequest.open('GET', '<?php echo jquery_url()?>lists/getListfivemtdata');
	    httpRequest.send();
	    httpRequest.onreadystatechange = function() {
	        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
		        //alert(httpRequest.responseText);
	            httpResponse = JSON.parse(httpRequest.responseText);
	            httpResponse.forEach( function(data, index) { 
	  	 		  latitudeArr.push(data.latitude);
	  	 		  longitudeArr.push(data.longitude);
	  	 		  unitnameArr.push(data.unitname);	
	  	 		  regArr.push(data.registration);
	  	 		  statusesArr.push(data.LOAD_STATUS);
	  	 		  cdreset();
	  	 	  });
	               // console.log(httpResponse);
	            initMap();       
	        }
	    };
    }

    var CCOUNT = 30;
    
    var t, count, timer;
    
    function cddisplay() {
        // displays time in span
        if(CCOUNT >= 0){
	        if(count >= 0){
        	$("#countdown").html(count);
	        }
        }
        else{
        	$("#countdown").html("");
        }
    };
    
    function countdown() {
        // starts countdown
        cddisplay();
       // console.log(count);
        if (count < 0) {
            // time is up
            if(CCOUNT > 0){
            	refreshMarkers();
            	refreshCountList();
            }
            
        } else {
            count--;
            t = setTimeout("countdown()", 1000);
        }
    };
    
    function cdpause() {
        // pauses countdown
        clearTimeout(t);
    };
    
    function cdreset() {
        // resets countdown				        
        cdpause();
        CCOUNT = 30;
        count = CCOUNT;
        cddisplay();
        countdown();
    };

    function refreshMarkers(){
		var bounds = new google.maps.LatLngBounds();
		//alert(gmarkers.length);
	    // delete all existing markers first
	    //removeElementsByClass('infoBox');
	    
	    lineCoordinates = [];
	    // add new markers from the JSON data
	    listMarkers();
	    //console.log(gmarkers.length);
	    cdreset();
		   /* for (var i = 0; i < gmarkers.length; i++) {
		        gmarkers[i].setMap(map);
		    }*/
	    // zoom the map to show all the markers, may not be desirable.
	   // map.fitBounds(bounds);
	}

    function refreshCountList(){
		$.get("<?php echo base_url()?>dashboard/getfivemtListCount", function(data){
			$("#refCount").html(data);
		});
	}

 // ------------------------------------------------------------------------------- //
	// create markers on the map tooltip
	// ------------------------------------------------------------------------------- //
	function fnPlaceMarkers(markermap, textplace){
		
		// create an InfoWindow - for mouseover
		var infoWnd = new google.maps.InfoWindow();						

		// create an InfoWindow -  for mouseclick
		var infoWnd2 = new google.maps.InfoWindow();
		
		// -----------------------
		// ON MOUSEOVER
		// -----------------------
		
		// add content to your InfoWindow
		infoWnd.setContent('<div class="scrollFix">' + textplace + '</div>');
		//infoWnd.setContent('<div class="scrollFix"><h3>Laddle no 12 <span class="battery_icon"><img src="http://ivarustech.com/jsw/assets/images/battery_f.png"/></span></h3><ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul></div>');
		
		// add listener on InfoWindow for mouseover event
		google.maps.event.addListener(markermap, 'mouseover', function() {
			
			// Close active window if exists - [one might expect this to be default behaviour no?]				
			if(activeInfoWindow != null) activeInfoWindow.close();

			// Close info Window on mouseclick if already opened
			infoWnd2.close();
		
			// Open new InfoWindow for mouseover event
			infoWnd.open(map, markermap);
			
			// Store new open InfoWindow in global variable
			activeInfoWindow = infoWnd;		
			closeImageBtn();		
		}); 							
		
		// on mouseout (moved mouse off marker) make infoWindow disappear
		google.maps.event.addListener(markermap, 'mouseout', function() {
			infoWnd.close();	
		});
		
		// --------------------------------
		// ON MARKER CLICK - (Mouse click)
		// --------------------------------
		
		// add content to InfoWindow for click event 
		infoWnd2.setContent('<div class="scrollFix">' + textplace + '</div>');
		//infoWnd2.setContent('<div class="scrollFix"><h3>Laddle no 12 <span class="battery_icon"><img src="http://ivarustech.com/jsw/assets/images/battery_f.png"/></span></h3><ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul></div>');
		
		// add listener on InfoWindow for click event
		google.maps.event.addListener(markermap, 'click', function() {
			
			//Close active window if exists - [one might expect this to be default behaviour no?]				
			if(activeInfoWindow != null) activeInfoWindow.close();

			// Open InfoWindow - on click 
			infoWnd2.open(map, markermap);
			
			// Close "mouseover" infoWindow
			infoWnd.close();
			
			// Store new open InfoWindow in global variable
			activeInfoWindow = infoWnd2;
			closeImageBtn();
		}); 							
		
	}

	function laddlecarIcons(mapDirection, Color){
	 	   var directionIcon = "";
	 	  if(348.75 < mapDirection && mapDirection <= 360)
				directionIcon = baseUrl+Color+'/1.png';
			else if(0 <= mapDirection && mapDirection <= 11.25)
				directionIcon = baseUrl+Color+'/1.png'; 
			else if(11.25 < mapDirection && mapDirection <= 33.75)
				directionIcon = baseUrl+Color+'/2.png';
			else if(33.75 < mapDirection && mapDirection <= 56.25)
				directionIcon = baseUrl+Color+'/3.png';
			else if(56.25 < mapDirection && mapDirection <= 78.75)
				directionIcon = baseUrl+Color+'/4.png';
			else if(78.75 < mapDirection && mapDirection <= 101.25)
				directionIcon = baseUrl+Color+'/5.png';		
			else if(101.25 < mapDirection && mapDirection <= 123.75)
				directionIcon = baseUrl+Color+'/6.png';
			else if(123.75 < mapDirection && mapDirection <= 146.25)
				directionIcon = baseUrl+Color+'/7.png';
			else if(146.25 < mapDirection && mapDirection <= 168.75)
				directionIcon = baseUrl+Color+'/8.png';
			else if(168.75 < mapDirection && mapDirection <= 191.25)
				directionIcon = baseUrl+Color+'/9.png';
			else if(191.25 < mapDirection && mapDirection <= 213.75)
				directionIcon = baseUrl+Color+'/10.png';
			else if(213.75 < mapDirection && mapDirection <= 236.25)
				directionIcon = baseUrl+Color+'/11.png';
			else if(236.25 < mapDirection && mapDirection <= 258.75)
				directionIcon = baseUrl+Color+'/12.png';
			else if(258.75 < mapDirection && mapDirection <= 281.25)
				directionIcon = baseUrl+Color+'/13.png';
			else if(281.25 < mapDirection && mapDirection <= 303.75)
				directionIcon = baseUrl+Color+'/14.png';
			else if(303.75 < mapDirection && mapDirection <= 326.25)
				directionIcon = baseUrl+Color+'/15.png';
			else if(326.25 < mapDirection && mapDirection <= 348.75)
				directionIcon = baseUrl+Color+'/16.png';
			return directionIcon;
	 	}
 
    function listMarkers(){
    	httpResponse, latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array(), statusesArr = new Array();
    	var temp_gmarkers = gmarkers;
	 		
		    gmarkers = [];
    	$.ajax({
	           url:  '<?php echo jquery_url()?>lists/getListfivemtdata',
	           dataType: 'text',
	           success: function(responseText){	
	                   //    console.log(responseText);
	        	   httpResponse = JSON.parse(responseText);
		            httpResponse.forEach( function(data, index) { 
		  	 		  latitudeArr.push(data.latitude);
		  	 		  longitudeArr.push(data.longitude);
		  	 		  unitnameArr.push(data.unitname);	
		  	 		  regArr.push(data.registration);
		  	 		  statusesArr.push(data.LOAD_STATUS);
		  	 	  });


		  	 		latitudeArr.forEach(function(feature, index) {
		  	            if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
		  	          var dir = httpResponse[index].direction;            
		              if(dir == ""){            	
		                  dir = 0;            
		                  } 
		              switch(statusesArr[index]){
		            	case "201": directionIcon = laddlecarIcons(dir, 'Green');break;
		            	case "202": directionIcon = laddlecarIcons(dir, 'Green');break;
		            	case "203": directionIcon = laddlecarIcons(dir, 'Red');break;
		            	case "204": directionIcon = laddlecarIcons(dir, 'Red');break;
						case "205": directionIcon = laddlecarIcons(dir, 'Green');break;
		            	default: directionIcon = laddlecarIcons(dir, "Orange");break;
		            }

		              if(httpResponse[index].cycle == 0){
		              	directionIcon = laddlecarIcons(dir, "Orange");
		  	         }
			  	         
		              var markerIcon = {
		            		  url: directionIcon,
		            		  //scaledSize: new google.maps.Size(80, 80),
		            		  //origin: new google.maps.Point(0, 0),
		            		 // anchor: new google.maps.Point(32,65),
		            		  labelOrigin: new google.maps.Point(10,35)
		            		  //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
		            		};
	            		
		              var marker = new google.maps.Marker({
		  	            position: new google.maps.LatLng(latitudeArr[index], longitudeArr[index]),
		  	            icon: markerIcon,
		  	            title: unitnameArr[index],
		  	            //label: unitnameArr[index],
		  	            map: map,
		  	            label: {
		  		                color: '#2a4dce',
		  		                fontWeight: 'bold',
		  		                fontSize: '11px',
		  		                text: unitnameArr[index]
		  	              },
		  	              optimized: false,
		  	              
		  	          });
		              
		  	          
		  	          //marker.metadata = {type: "point", id: index};
		  	          if(regArr[index] != "" && statusesArr[index] != null){
			        	  var text = "";
			        	  text = getText(statusesArr[index], index);
			  	          
			  	          //console.log(statusesArr[index]);
			  	        //console.log(text);
			  	        if(text != ""){
			  	            fnPlaceMarkers(marker, text);
			  	        }
		  	          }
		  	       // console.log(marker);
		  	          gmarkers.push(marker);
		  	        });

		  	 		for (var i = 0; i < temp_gmarkers.length; i++) {
		  	 			temp_gmarkers[i].setMap(null);
		  		    }
		  	 		animateMarkers();
	           }
	       });	
	      
    }
    

    function getText(status, index){
        //<ul><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li><li><strong>Laddle no:</strong> 2215 </li></ul>
        var img = '<?php echo asset_url();?>images/battery_emp.png';
        if(parseFloat(httpResponse[index].fuel) > 10){
        	img = '<?php echo asset_url();?>images/battery_f.png';
        }
        var timehours = httpResponse[index].timehours;
        var minutes = Math.floor(timehours / 60);
        var idlet = "";
        if(minutes > 90 && httpResponse[index].cycle=="1"){
        	idlet = "<li><strong>Idle Time(min):</strong> "+minutes+" </li>";
        }
    	switch(status){
        case "201": text = "<h3>"+httpResponse[index].ladleno+" ("+httpResponse[index].unitname+") <span class='battery_icon'><img src='"+img+"'/></span></h3>"+													
						"<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
						"<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
						"<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
						"<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
						"<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
						"<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+idlet+"</ul>";
				  break;
      	case "202": text = "<h3>"+httpResponse[index].ladleno+" ("+httpResponse[index].unitname+") <span class='battery_icon'><img src='"+img+"'/></span></h3>"+													
							"<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
							"<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
							"<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
							"<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
							"<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
							"<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+
							"<li><strong>Gross Weight:</strong> "+httpResponse[index].GROSS_WEIGHT+" </li>"+
							"<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
							"<li><strong>Net Weight:</strong> "+httpResponse[index].NET_WEIGHT+" </li>"+idlet+"</ul>";
					  break; 
      	case "203": text = "<h3>"+httpResponse[index].ladleno+" ("+httpResponse[index].unitname+") <span class='battery_icon'><img src='"+img+"'/></span></h3>"+													
							"<ul><li><strong>Unload time:</strong> "+httpResponse[index].UNLOAD_DATE+" </li>"+
							"<li><strong>Destination:</strong> "+httpResponse[index].DEST+" </li>"+
							"<li><strong>Gross Weight:</strong> "+httpResponse[index].GROSS_WEIGHT+" </li>"+
							"<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
							"<li><strong>Net Weight:</strong> "+httpResponse[index].NET_WEIGHT+" </li>"+idlet+"</ul>";
					  break; 
      	case "204": text = "<h3>"+httpResponse[index].ladleno+" ("+httpResponse[index].unitname+") <span class='battery_icon'><img src='"+img+"'/></span></h3>"+													
							"<ul><li><strong>Unload time:</strong> "+httpResponse[index].UNLOAD_DATE+" </li>"+
							"<li><strong>2nd Tare Weight:</strong> "+httpResponse[index].TARE_WT2+" </li>"+
							"<li><strong>2nd Net Weight:</strong> "+httpResponse[index].NET_WT2+" </li>"+idlet;
      						if(httpResponse[index].remarks != null){ text += "<li><strong>Remarks:</strong> "+httpResponse[index].remarks+" </li>";}
      						text += "</ul>";
					  break; 
					  
		case "205": text = "<h3>"+httpResponse[index].ladleno+" ("+httpResponse[index].unitname+") <span class='battery_icon'><img src='"+img+"'/></span></h3>"+													
							"<ul><li><strong>Cast No:</strong> "+httpResponse[index].TAPNO+" </li>"+
							"<li><strong>Loadtime:</strong> "+httpResponse[index].LOAD_DATE+" </li>"+
							"<li><strong>Source:</strong> "+httpResponse[index].SOURCE+" </li>"+
							"<li><strong>Runner HM Si%:</strong> "+httpResponse[index].SI+" </li>"+
							"<li><strong>Runner HM Sulphur%:</strong> "+httpResponse[index].S+" </li>"+
							"<li><strong>Runner Temp:</strong> "+parseInt(httpResponse[index].TEMP)+" </li>"+
							"<li><strong>Gross Weight:</strong> "+httpResponse[index].GROSS_WEIGHT+" </li>"+
							"<li><strong>Tare Weight:</strong> "+httpResponse[index].TARE_WEIGHT+" </li>"+
							"<li><strong>Net Weight:</strong> "+httpResponse[index].NET_WEIGHT+" </li>"+idlet+"</ul>";
					  break; 
  
      	default: text="";break;
    }
    	
	    return text;
    }

	function setGeofence(){


		   
		   		 
		  /* $.ajax({
	           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=2',
	           dataType: 'json',
	           success: function(data){		           
	        	   rectangularGeoStore = data;
	           }
	       });	*/

		   $.ajax({
	           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=3',
	           dataType: 'json',
	           success: function(data){		           
	        	   var polyResponse = data;

	        	   polyResponse.forEach( function(data, i) {
	   		        var PolyCoords= new Array();
	   		        var polyGeobounds = new google.maps.LatLngBounds();
	   		        var allGeobounds = new google.maps.LatLngBounds();
	   		         var latlon =  data.latlon;
	   		  	      var latlonsplit= latlon.split(":");
	   			       for(var k=0;k<latlonsplit.length;k++)
	   			       {
	   			  	       if(latlonsplit[k]!="")
	   			  	       {
		   			  	    	var s = latlonsplit[k].toString();
		   			  	 	    var s1 = s.substring(1,s.length-1);
		   			  	 	    var s2 = s1.split(",");
		   			  	 	    var ln = new google.maps.LatLng(parseFloat(s2[0]),parseFloat(s2[1]));
		   			  	        PolyCoords.push(ln);
	   			  	       }
	   			       }
  			                       var colr = data.colour;
	   			             var polygon =  new google.maps.Polygon({
	   					        map:map,
	   					        paths: PolyCoords,
	   					     	strokeColor: colr,
		                         strokeOpacity: 2.35,
		                         strokeWeight: 2,
		                         fillColor: colr,
		                         fillOpacity: 0.35
	   					       
	   					      });
	   					   	//geofence label color
	   					     var mapLabel = new MapLabel({
	   					    	  map: map,
	   					          fontSize: 14,
	   					          fontColor:'#000',
	   					         fontWeight: 'bold',
	   					          strokeWeight:1.2,
	   					          strokeColor:'#000',
	   					          labelClass: "labels",
	   					          align: 'center',	   					          
	   					          rotation: 50
	   					     });

	   		         
	   					   for (var j = 0; j<PolyCoords.length; j++) {
	   						   allGeobounds.extend(PolyCoords[j]);
	   						   polyGeobounds.extend(PolyCoords[j]);
	   					        
	   					      }
	   		       
	   					//console.log(polyGeobounds);//console.log(data.lat);//console.log(data.lon);
	   					
	   				     mapLabel.set('position',new google.maps.LatLng(data.lat, data.lon));
	   					 mapLabel.set('text',  data.geofenceName);
	   					 polygon.bindTo('map', mapLabel);
	   					 polygon.bindTo('position', mapLabel);
	   					 //addPolygonClick(polygon,mapLabel);
	   					 //map.fitBounds(polyGeobounds);
	   					 polygon.setVisible(true);
	   					// mapPolyLabelArr.push(mapLabel);
	   					 mapLabel.setMap(map);
	   					// polyArr.push(polygon);  
	   					

	   		});
	           }
	       });

		   $.ajax({
	           url:  '<?php echo base_url();?>lists/getTrack',
	           dataType: 'json',
	           success: function(data){		           
	        	   var polylineResponse = data;

	        	   polylineResponse.forEach( function(data, i) {
	    		       
	   		        var PolyCoords= new Array();
	   		        var polyGeobounds = new google.maps.LatLngBounds();
	   		        var allGeobounds = new google.maps.LatLngBounds();
	   		         var latlon =  data.latlon;
	   		  	      var latlonsplit= latlon.split(":");
	   			       for(var k=0;k<latlonsplit.length;k++)
	   			       {
	   			  	       if(latlonsplit[k]!="")
	   			  	       {
		   			  	    	var s = latlonsplit[k].toString();
		   			  	 	    var s1 = s.substring(1,s.length-1);
		   			  	 	    var s2 = s1.split(",");
		   			  	 	    var ln = new google.maps.LatLng(parseFloat(s2[0]),parseFloat(s2[1]));
		   			  	        PolyCoords.push(ln);
	   			  	       }
	   			       }
  			                       
	   			    var line = new google.maps.Polyline({
	  		          path: PolyCoords,
	  		          strokeOpacity: 0,
	  		          icons: [{
	  		            icon: lineSymbol,
	  		            offset: '0',
	  		            repeat: '13px',
	  		            title: data.geofenceName,
	  		          }],
	  		          map: map
	  		        });
	   					   	
	   					  
	   					
	   				   
	   					 //addPolygonClick(polygon,mapLabel);
	   					 //map.fitBounds(polyGeobounds);
	   					 line.setVisible(true);
	   					

	   		});
	           }
	       });
	        
			
				 $.ajax({
	           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=1',
	           dataType: 'json',
	           success: function(data){	
	        	   cirResponse = data;
				   cirResponse.forEach( function(data, i) {  	
                     var colr = data.colour;				   
					 var circle = new google.maps.Circle({
						 
						   map:map,
						   center:new google.maps.LatLng(data.latitude, data.longitude),
						   radius: parseFloat(data.radius)+0.00,
						   options:{
							   strokeWeight: 0,
							   fillOpacity: 0.45,
							   fillColor: colr,
							   title:data.geofenceName,
							   editable: false,
							   visible:true
							 }			      
						 });
				   var mapLabel = new MapLabel({
					   map:map,
					   fontSize: 12,
					   fontColor:'#fff000',
					   fontWeight:10,
					   strokeWeight:3,
					   strokeColor:'#000000',
					   labelClass: "labels",
					   align: 'center'
					 });
				 mapLabel.set('position', circle.getCenter());
				 mapLabel.set('text',data.geofenceName);
				 circle.bindTo('map', mapLabel);
				 circle.bindTo('position', mapLabel);
				 circle.setVisible(true);
				 mapLabel.setMap(map);
				
						});
					}

	       });	
		
	}

	var iconBase = '<?php echo asset_url()?>images/';
    /*var icons = {
      laddlecars: {
        icon: iconBase + 'm.png'
      },
	  laddlecarsidel: {
        icon: iconBase + 'm1.png'
      },
      laddlecarOrange: {
        icon: iconBase + 'orange.png'
      },
      laddlecarRed: {
        icon: iconBase + 'red.png'
      },
      laddlecarYellow: {
        icon: iconBase + 'yellow.png'
      },
      laddlecarGreen: {
        icon: iconBase + 'green.png'
      },
      laddlecarsmove: {
          icon: iconBase + 'green.png'
        },
      blink_c: {
        icon: iconBase + 'gg.gif'
      }
      

	};*/

	var icons = {
		      laddlecarOrange: {
		        icon: 'orange'
		      },
		      laddlecarRed: {
		        icon: 'M46.359001,50.5c-0.205002,0 -0.410999,-0.046001 -0.602001,-0.141998l-13.757,-6.878002l-13.757,6.877998c-0.507,0.255001 -1.121,0.163002 -1.532,-0.230999c-0.411001,-0.393002 -0.531,-1.000999 -0.301001,-1.52l14.360001,-32.307999c0.216,-0.486 0.698,-0.799 1.23,-0.799c0.532001,0 1.014,0.313 1.23,0.799l14.359001,32.307999c0.23,0.519001 0.110001,1.126999 -0.301003,1.52c-0.254997,0.245003 -0.589996,0.373001 -0.928997,0.373001zm-14.359001,-9.872002c0.206001,0 0.412998,0.047001 0.602001,0.141998l11.002998,5.502003l-11.605,-26.111l-11.605,26.111l11.003,-5.501999c0.188999,-0.094002 0.396,-0.142002 0.601999,-0.142002z'
		      },
		      laddlecarYellow: {
		        icon: 'yellow.png'
		      },
		      laddlecarGreen: {
		        icon: 'M46.359001,50.5c-0.205002,0 -0.410999,-0.046001 -0.602001,-0.141998l-13.757,-6.878002l-13.757,6.877998c-0.507,0.255001 -1.121,0.163002 -1.532,-0.230999c-0.411001,-0.393002 -0.531,-1.000999 -0.301001,-1.52l14.360001,-32.307999c0.216,-0.486 0.698,-0.799 1.23,-0.799c0.532001,0 1.014,0.313 1.23,0.799l14.359001,32.307999c0.23,0.519001 0.110001,1.126999 -0.301003,1.52c-0.254997,0.245003 -0.589996,0.373001 -0.928997,0.373001zm-14.359001,-9.872002c0.206001,0 0.412998,0.047001 0.602001,0.141998l11.002998,5.502003l-11.605,-26.111l-11.605,26.111l11.003,-5.501999c0.188999,-0.094002 0.396,-0.142002 0.601999,-0.142002z'
		      },
		      laddlecarsmove: {
		          icon: 'green.png'
		        },
		      blink_c: {
		        icon: 'gg.gif'
		      }
		      

			};

 // Define a symbol using SVG path notation, with an opacity of 1.
    var lineSymbol = {
      path: 'M 0,-1 0,3',
      strokeOpacity: 1,
      scale: 2.0,
	  strokeColor:'#000',
	  fillColor: '#000',
	  fillOpacity: 0

    };
	
      // This example converts a polyline to a dashed line, by
      // setting the opacity of the polyline to 0, and drawing an opaque symbol
      // at a regular interval on the polyline.

      function initMap() {
		  
		// Create a new StyledMapType object, passing it an array of styles,
        // and the name to be displayed on the map type control.
        var styledMapType = new google.maps.StyledMapType(
            [
              {elementType: 'geometry', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#fff'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#fff'}]},
              {
                featureType: 'administrative',
                elementType: 'geometry.stroke',
                stylers: [{color: '#7aa5cd'}]
              },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'geometry.stroke',
                stylers: [{color: '#7aa5cd'}]
              },
			  {
				featureType: 'all',
				elementType: 'labels',
				stylers: [{ 
					visibility: 'off' 
				 }]
			 },
              {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#000000'}]
              },
              {
                featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#7aa5cd'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#ffc000'}]
              },
              {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [{color: '#fdfcf8'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#7aa7c7'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#7aa7c7'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: 'red'}]
              },
              {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
              },
              {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
              },
              {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#7aa5cd'}]
              },
              {
                featureType: 'water',
                elementType: 'geometry.fill',
                stylers: [{color: '#ffffff'}]
              },
              {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#ffffff'}]
              }
            ],
            {name: 'Map'});


         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
		  rotation: 5,
		  
          //center: {lat:15.178180945596363, lng:76.65809154510498},
		  //center: {lat:15.177870, lng:76.665891},
		  center: {lat:15.1787608, lng:76.6641855},
		  //mapTypeId: 'terrain',
		  mapTypeControlOptions: {
            mapTypeIds: ['styled_map', 'satellite']
          }
        });
		

		
		
        var features = [];
		
        setGeofence();
		

        // Create markers.
        latitudeArr.forEach(function(feature, index) {
            if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
            var dir = httpResponse[index].direction;            
            if(dir == ""){            	
                dir = 0;            
                } 
            switch(statusesArr[index]){
          	case "201": directionIcon = laddlecarIcons(dir, 'Green');break;
          	case "202": directionIcon = laddlecarIcons(dir, 'Green');break;
          	case "203": directionIcon = laddlecarIcons(dir, 'Red');break;
          	case "204": directionIcon = laddlecarIcons(dir, 'Red');break;
		    case "205": directionIcon = laddlecarIcons(dir, 'Green');break;
          	default: directionIcon = laddlecarIcons(dir, "Orange");break;
          }

            if(httpResponse[index].cycle == 0){
            	directionIcon = laddlecarIcons(dir, "Orange");
	         }
	        // console.log(directionIcon);
            var markerIcon = {
          		  url: directionIcon,
          		  //scaledSize: new google.maps.Size(80, 80),
          		  //origin: new google.maps.Point(0, 0),
          		 // anchor: new google.maps.Point(32,65),
          		  labelOrigin: new google.maps.Point(10,35)
          		  //M57.5,32.599998c-3.299999,3.599998 -6.700001,7.599998 -7.5,8.900002c-0.799999,1.199997 -3.599998,4.399998 -6.200001,7c-14.499998,14.399998 -10.399998,37.800003 8.200001,47.900002c10.900002,6 26.900002,3 35.5,-6.5c5.300003,-5.900002 7.5,-11.800003 7.5,-19.900002c0,-8.900002 -2.699997,-15.900002 -8.799995,-22.600002c-2.600006,-2.799999 -7.800003,-8.799999 -11.700005,-13.200001c-4.299995,-4.999998 -7.799995,-8.099998 -9,-8.199999c-1.199997,0 -4.299999,2.6 -8,6.6zm14.300003,27.900002c4.299995,3.599998 5.699997,7.5 4.199997,11.900002c-1.699997,5.199997 -5.299995,7.599998 -11.199997,7.599998c-5.900002,0 -9.300003,-2.800003 -10.300003,-8.400002c-1.899998,-10.099998 9.700005,-17.5 17.300003,-11.099998z
          		};
					//console.log(unitnameArr[index]+"------"+parseInt(dir));
          		
	          var marker = new google.maps.Marker({
	            position: new google.maps.LatLng(latitudeArr[index], longitudeArr[index]),
	            icon: markerIcon,
	            title: unitnameArr[index],
	            //label: unitnameArr[index],
	            map: map,
	            label: {
		                color: '#2a4dce',
		                fontWeight: 'bold',
		                fontSize: '11px',
		                text: unitnameArr[index]
	              },
	              optimized: false,
	              
	          });
	          
	          if(regArr[index] != "" && statusesArr[index] != null){
	        	  var text = "";
	        	  //console.log(color+"----"+unitnameArr[index]+"----"+statusesArr[index]+"----"+icons[color].icon);
	        	  text = getText(statusesArr[index], index);
	  	          
	  	          //console.log(statusesArr[index]);  
	  	        //console.log(text);
	  	        if(text != ""){
	  	            fnPlaceMarkers(marker, text);
	  	        }
  	          }
          gmarkers.push(marker);
        });
      

     // Overlay view allows you to organize your markers in the DOM
        // https://developers.google.com/maps/documentation/javascript/reference#OverlayView
       var myoverlay = new google.maps.OverlayView();
       myoverlay.draw = function () {
           // add an id to the layer that includes all the markers so you can use it in CSS
           this.getPanes().markerLayer.id='markerLayer';
       };
       myoverlay.setMap(map);



		 map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
		
        
		//console.log(map);
		google.maps.event.addListenerOnce(map, 'idle', function(){
		    //loaded fully
			timer = setTimeout("animateMarkers()", 1000);
			
		});
		/*
		google.maps.event.addListener(map, 'zoom_changed', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'heading_changed', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'dragstart', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'dragend', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'drag', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'dblclick', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'click', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'center_changed', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'bounds_changed', function() {
			startTimer();
		});
		
		
		google.maps.event.addListener(map, 'maptypeid_changed', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'mousemove', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'mouseout', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'mouseover', function() {
			startTimer();
		});
		
		
		
		google.maps.event.addListener(map, 'projection_changed', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'resize', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'rightclick', function() {
			startTimer();
		});
		
		
		google.maps.event.addListener(map, 'tilesloaded', function() {
			startTimer();
		});

		google.maps.event.addListener(map, 'tilt_changed', function() {
			startTimer();
		});*/
		
		
      }

      function animateMarkers(){
          //console.log("ddd");
          //console.log(gmarkers);
          httpResponse.forEach(function(feature, index) {
			   if(httpResponse[index].registration != ""){httpResponse[index].unitname = httpResponse[index].registration;}
			   var timehours = httpResponse[index].timehours;
		          var minutes = Math.floor(timehours / 60);
				  //console.log(minutes+"-----"+httpResponse[index].unitname+"---"+httpResponse[index].cycle);
		          if((minutes > 90 && httpResponse[index].cycle=="1") || 
				          (httpResponse[index].LOAD_STATUS == "204" && parseInt(httpResponse[index].TARE_WT2) > 110 && httpResponse[index].cycle=="1" && httpResponse[index].lmid >= 1 && httpResponse[index].lmid <= 55) || 
				          (httpResponse[index].LOAD_STATUS == "204" && parseInt(httpResponse[index].TARE_WT2) > 180 && httpResponse[index].cycle=="1" && httpResponse[index].lmid >= 56)
				          ){
		        	  //gmarkers[index].setMap(null);
		        	  gmarkers[index].setVisible(false);
		        	  //setTimeout(function () {gmarkers[index].setMap(map);}, 200);
		        	  setTimeout(function () {gmarkers[index].setVisible(true);}, 200);
		        	  //gmarkers[index].setAnimation(google.maps.Animation.BOUNCE);
		          }
		   });
    	  /*for (var i = 0; i < gmarkers.length; i++) {  
			//console.log(gmarkers[i]);
			gmarkers[i].setAnimation(google.maps.Animation.BOUNCE);
    	  }*/
          setTimeout("animateMarkers()", 1000);
      }

      
      closeImageBtn();
      function closeImageBtn(){
         /* $('img[src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png"]').parent().addClass("closeImage");
          console.log($('img[src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png"]').parent());*/

          $(".gm-style-iw").next().remove();
      }
    </script>	
    <style>
    .closeImage{
    	display: none !important;
    }
    </style>

  </body>
</html>