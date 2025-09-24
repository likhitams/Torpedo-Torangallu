<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCeBKXuvVI3hAHK5uv2ZIwhymQXX6wqAa4"></script>	
	
	<script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
	<script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
	 <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>
	       
<style>

	/* Always set the map height explicitly to define the size of the div
		   * element that contains the map. */
		  #map_canvas {
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
		  
		  
		.gm-style-cc {
			display: none;
		}
		.gmnoprint {
			position: absolute;
			top: 0;
			left: 0;
		}
		

</style>
 
 
<script type="text/javascript" src="<?php echo asset_url();?>js/staticConstants.js"></script>
<script>

var map, dropInfoBox;
var myOptions;
var mapView;

var markerSize=0;
var marker = [];
var gmarkers = [];
var markerLoc;
var line;
var lineCoordinates=new Array();
var circleArr=new Array();
var rectArr=new Array();
var polyArr=new Array();
var polylineArr=new Array();
var mapLabelArr=new Array();
var circleRecArr=new Array();
var mapPolyLabelArr=new Array();
var mapPolylineLabelArr=new Array();
var mapRecLabelArr=new Array();
var circleshowArr=new Array();
var mapLabelshowArr=new Array();
var showmarker;
var showmapView;
var draw;
var showmap;
var locationArr=new Array();
var locationArr1=new Array();
var locLabelArr1=new Array();
var odoArr=new Array();
//alert("==>"+odoArr.length);
var locLabelArr=new Array();
var gaugeLabelArr=new Array();
var username='<?php echo $detail[0]->username;?>';	
var curMar=0;
var bounds = new google.maps.LatLngBounds();
var locbounds = new google.maps.LatLngBounds();
var allgeobounds = new google.maps.LatLngBounds();

 var on = true;
 	var baseUrl = '<?php echo jquery_url()?>assets/direction_icons1/';
    var httpResponse, map, activeInfoWindow ;	
    var gmarkers = [], newFeature = [];
    var lineCoordinates=new Array();
    var polyArr=new Array(), mapPolyLabelArr = new Array(), statusesArr = new Array(), statArr= new Array();
    var latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array();
    function getData(){
	    var httpRequest = new XMLHttpRequest();
	    httpRequest.open('GET', '<?php echo jquery_url()?>lists/getListdata');
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
	  	 		  statArr.push(data.statusid);
	  	 		 // cdreset();
	  	 	  });
	               // console.log(httpResponse);
	            initMap();       
	        }
	    };
    }

    function refreshMarkers(){
		var bounds = new google.maps.LatLngBounds();
		//alert(gmarkers.length);
	    // delete all existing markers first
	    //removeElementsByClass('infoBox');
	    
	    lineCoordinates = [];
	    // add new markers from the JSON data
	    listMarkers();
	    //console.log(gmarkers.length);
	   //cdreset();
		   /* for (var i = 0; i < gmarkers.length; i++) {
		        gmarkers[i].setMap(map);
		    }*/
	    // zoom the map to show all the markers, may not be desirable.
	   // map.fitBounds(bounds);
	}
    
    
    /*to display  location depending upon selection from grid*/
    function dispUptoRow(j){
    	hideinfoBox();
    if(curMar==0){
    	
    	hideAllNode();
    }
    	if(j<curMar){
    		for(var i=curMar;i>j;i--)
    		{
    			if(gmarkers[i].getVisible())
    		 gmarkers[i].setVisible(false);
    		if(i==(j+1))
    		{
    			 map.panTo(gmarkers[i-1].getPosition());
    			 google.maps.event.trigger(gmarkers[i-1], "click");
    		}
    		}
    		}
    	else{
    		for(var i=0;i<=j;i++)
    		{
    			if(!gmarkers[i].getVisible())
    			 gmarkers[i].setVisible(true);
    		
    			if(i==j)
    			{
    				 map.panTo(gmarkers[i].getPosition());
    				 google.maps.event.trigger(gmarkers[i], "click");
    			}
    		}
    	}
    	curMar=j;
    	
    }


    /*to hide all the location */
    function hideAllNode(){
    	//console.log(gmarkers.length);
    //	removeElementsByClass('infoBox');
    	for (var i = 0; i < gmarkers.length; i++) 
    		{
    			if(gmarkers[i].getVisible()){
    			  gmarkers[i].setVisible(false);
    		}
    			else
    				break;
    	}
    }

    /*to display all the location */
    function dispAllNode(selected){
    	for (var i = selected; i < gmarkers.length; i++) 
    	{
    		if(!gmarkers[i].getVisible())
    		{
    			
    			gmarkers[i].setVisible(true);
    		}
    		if(i==(gmarkers.length-1))
    		{
    			 map.panTo(gmarkers[i].getPosition());
    			 google.maps.event.trigger(gmarkers[i], "click");
    		}
    	}
    	curMar=0;
    	hideinfoBox();
    }

    /*to display single previous location make it visible*/
    function dispPreNode(i){ 
    	if(gmarkers[i])
    	{
    		
    		gmarkers[i].setVisible(false);
    		  map.panTo(gmarkers[i-1].getPosition());
    		  google.maps.event.trigger(gmarkers[i-1], "click");
    	}
    }

    /*to display single next location make it visible*/
    function dispNextNode(i){
    	if(gmarkers[i])
    	{	
    		 gmarkers[i].setVisible(true);
    		 map.panTo(gmarkers[i].getPosition());
    		 google.maps.event.trigger(gmarkers[i], "click");
    	}
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


	function laddlecarIconsNew(mapDirection, statusid, Color){

		

		  if(statusid==18)
		 {
		   var  Color="Idle";
	 	   var directionIcon = "";
	 	  if(348.75 < mapDirection && mapDirection <= 360)
				directionIcon = baseUrl+Color+'/1.icon';
			else if(0 <= mapDirection && mapDirection <= 11.25)
				directionIcon = baseUrl+Color+'/1.icon'; 
			else if(11.25 < mapDirection && mapDirection <= 33.75)
				directionIcon = baseUrl+Color+'/2.icon';
			else if(33.75 < mapDirection && mapDirection <= 56.25)
				directionIcon = baseUrl+Color+'/3.icon';
			else if(56.25 < mapDirection && mapDirection <= 78.75)
				directionIcon = baseUrl+Color+'/4.icon';
			else if(78.75 < mapDirection && mapDirection <= 101.25)
				directionIcon = baseUrl+Color+'/5.icon';		
			else if(101.25 < mapDirection && mapDirection <= 123.75)
				directionIcon = baseUrl+Color+'/6.icon';
			else if(123.75 < mapDirection && mapDirection <= 146.25)
				directionIcon = baseUrl+Color+'/7.icon';
			else if(146.25 < mapDirection && mapDirection <= 168.75)
				directionIcon = baseUrl+Color+'/8.icon';
			else if(168.75 < mapDirection && mapDirection <= 191.25)
				directionIcon = baseUrl+Color+'/9.icon';
			else if(191.25 < mapDirection && mapDirection <= 213.75)
				directionIcon = baseUrl+Color+'/10.icon';
			else if(213.75 < mapDirection && mapDirection <= 236.25)
				directionIcon = baseUrl+Color+'/11.icon';
			else if(236.25 < mapDirection && mapDirection <= 258.75)
				directionIcon = baseUrl+Color+'/12.icon';
			else if(258.75 < mapDirection && mapDirection <= 281.25)
				directionIcon = baseUrl+Color+'/13.icon';
			else if(281.25 < mapDirection && mapDirection <= 303.75)
				directionIcon = baseUrl+Color+'/14.icon';
			else if(303.75 < mapDirection && mapDirection <= 326.25)
				directionIcon = baseUrl+Color+'/15.icon';
			else if(326.25 < mapDirection && mapDirection <= 348.75)
				directionIcon = baseUrl+Color+'/16.icon';
			
			return directionIcon;
			
		 }
		  else
		  {
			  var   Color="Moving";
			  var directionIcon = "";
		 	  if(348.75 < mapDirection && mapDirection <= 360)
					directionIcon = baseUrl+Color+'/1.icon';
				else if(0 <= mapDirection && mapDirection <= 11.25)
					directionIcon = baseUrl+Color+'/1.icon'; 
				else if(11.25 < mapDirection && mapDirection <= 33.75)
					directionIcon = baseUrl+Color+'/2.icon';
				else if(33.75 < mapDirection && mapDirection <= 56.25)
					directionIcon = baseUrl+Color+'/3.icon';
				else if(56.25 < mapDirection && mapDirection <= 78.75)
					directionIcon = baseUrl+Color+'/4.icon';
				else if(78.75 < mapDirection && mapDirection <= 101.25)
					directionIcon = baseUrl+Color+'/5.icon';		
				else if(101.25 < mapDirection && mapDirection <= 123.75)
					directionIcon = baseUrl+Color+'/6.icon';
				else if(123.75 < mapDirection && mapDirection <= 146.25)
					directionIcon = baseUrl+Color+'/7.icon';
				else if(146.25 < mapDirection && mapDirection <= 168.75)
					directionIcon = baseUrl+Color+'/8.icon';
				else if(168.75 < mapDirection && mapDirection <= 191.25)
					directionIcon = baseUrl+Color+'/9.icon';
				else if(191.25 < mapDirection && mapDirection <= 213.75)
					directionIcon = baseUrl+Color+'/10.icon';
				else if(213.75 < mapDirection && mapDirection <= 236.25)
					directionIcon = baseUrl+Color+'/11.icon';
				else if(236.25 < mapDirection && mapDirection <= 258.75)
					directionIcon = baseUrl+Color+'/12.icon';
				else if(258.75 < mapDirection && mapDirection <= 281.25)
					directionIcon = baseUrl+Color+'/13.icon';
				else if(281.25 < mapDirection && mapDirection <= 303.75)
					directionIcon = baseUrl+Color+'/14.icon';
				else if(303.75 < mapDirection && mapDirection <= 326.25)
					directionIcon = baseUrl+Color+'/15.icon';
				else if(326.25 < mapDirection && mapDirection <= 348.75)
					directionIcon = baseUrl+Color+'/16.icon';
				return directionIcon;
			  
		  }
	 	}
 
    function listMarkers(){
    	httpResponse, latitudeArr = new Array(), longitudeArr = new Array(), unitnameArr = new Array(), regArr = new Array(), statusesArr = new Array(),statArr= new Array();
    	var temp_gmarkers = gmarkers;
    	var httpResponse = window.parent.httpResponse;
		    gmarkers = [];

		    httpResponse.forEach( function(data, index) { 
	  	 		  latitudeArr.push(data.latitude);
	  	 		  longitudeArr.push(data.longitude);
	  	 		  unitnameArr.push(data.unitname);	
	  	 		  regArr.push(data.lno);
	  	 		  statusesArr.push(data.loadstatus);
	  	 		  statArr.push(data.statusid);
	  	 	  });

		    latitudeArr.forEach(function(feature, index) {
  	            //if(regArr[index] != ""){unitnameArr[index] = regArr[index];}
  	          var dir = httpResponse[index].direction;       
  	          var statusid = httpResponse[index].statusid;            
              if(dir == ""){            	
                  dir = 0;            
                  } 
              switch(statusesArr[index]){
            	case "201": directionIcon = laddlecarIcons(dir,'Green');break;
            	case "202": directionIcon = laddlecarIcons(dir,'Green');break;
            	case "203": directionIcon = laddlecarIcons(dir,'Red');break;
            	case "204": directionIcon = laddlecarIcons(dir,'Red');break;
            	default: directionIcon = laddlecarIcons(dir,'Red');break;
            }

            /*  if(httpResponse[index].cycle == 0){
              	directionIcon = laddlecarIcons(dir, "Orange");
  	         }*/
	  	         
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
  	            title: regArr[index],
  	            //label: unitnameArr[index],
  	            map: map,
  	              optimized: false,
  	              
  	          });
              
  	          
  	        
  	          gmarkers.push(marker);
  	        });

  	 		for (var i = 0; i < temp_gmarkers.length; i++) {
  	 			temp_gmarkers[i].setMap(null);
  		    }
	      
    }
    
    /* hide onfo box */
    function hideinfoBox(){
  	  //removeElementsByClass('infoBox');
  }
   

	function setGeofence(){

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
	        
		
	}

	var iconBase = '<?php echo asset_url()?>images/';
 
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
              // {
              //   featureType: 'administrative',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'administrative.land_parcel',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa5cd'}]
              // },
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
                // featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dbecec'}]
              },
              // {
              //   featureType: 'poi',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#7aa5cd'}]
              // },
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
                // stylers: [{color: '#ffc000'}]
              },
              // {
              //   featureType: 'road.arterial',
              //   elementType: 'geometry',
              //   // stylers: [{color: '#fdfcf8'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa7c7'}]
              // },
              // {
              //   featureType: 'road.highway',
              //   elementType: 'geometry.stroke',
              //   stylers: [{color: '#7aa7c7'}]
              // },
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
              // {
              //   featureType: 'transit.line',
              //   elementType: 'geometry',
              //   stylers: [{color: '#dfd2ae'}]
              // },
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
              // {
              //   featureType: 'transit.station',
              //   elementType: 'geometry',
              //   stylers: [{color: '#7aa5cd'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'geometry.fill',
              //   stylers: [{color: '#ffffff'}]
              // },
              // {
              //   featureType: 'water',
              //   elementType: 'labels.text.fill',
              //   stylers: [{color: '#ffffff'}]
              // }
            ],
            {name: 'Map'});


         map = new google.maps.Map(document.getElementById('map_canvas'), {
          zoom: 15,
		  rotation: 5,
		   gestureHandling: "greedy",
		  
          //center: {lat:15.178180945596363, lng:76.65809154510498},   
		  //center: {lat:15.177870, lng:76.665891},lat:15.177870, lng:76.665891
		  center: {lat:15.1787608, lng:76.6641855},
		  //mapTypeId: 'terrain',
		  mapTypeControl: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.LEFT_TOP
        },
        mapTypeControlOptions: {
          position: google.maps.ControlPosition.BOTTOM_LEFT,
          // mapTypeIds: ['satellite','roadmap']
          mapTypeIds: ['styled_map', 'satellite'],
        },
        zoomControl: true,
        fullscreenControl: true,
        streetViewControl: false,
        
        
        });
		

		
		
        var features = [];
		
        setGeofence();
        listMarkers();

		 map.mapTypes.set('styled_map', styledMapType);
         map.setMapTypeId('styled_map');
		
      
		
      }
    </script>
</head>
<body onload="getData()" style="overflow:hidden;font-family: Arial;border: 0 none;">
<div id="map_canvas"></div>    
    

<form id="locForm" action="" method="get">
	
	
	   <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView?>">
	 

	 </form>
</body>
</html>
