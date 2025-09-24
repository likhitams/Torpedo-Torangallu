<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCeBKXuvVI3hAHK5uv2ZIwhymQXX6wqAa4&libraries=drawing&v=3"></script>
	
	<script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
	 <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>
	 <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	       
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
 
 
<script type="text/javascript" src="<?php echo asset_url();?>js/staticConstants.js"></script>
<script type="text/javascript">
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

function setDrawMode(){
	parent.IsShowHide = true;
	draw.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
}
function setRectMode(){
	parent.IsShowHide = true;
	draw.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
}
function setPolyMode(){
	parent.IsShowHide = true;
	draw.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
}

function setPolylineMode(){
	parent.showtrackHide = true;
	draw.setDrawingMode(google.maps.drawing.OverlayType.POLYLINE);
}
  

/*to hide the distance line om map*/
function hideDistancePoly(){
	google.maps.event.removeListener(distHandler);
	map.setOptions({draggableCursor: 'pointer'});
	  poly.setVisible(false);
	  distPonts=null;
}
/*enable the distance line for map*/
function callDistancePoly(){
	map.setOptions({draggableCursor: 'crosshair'});
	 var polyOptions = {
			    strokeColor: '#990066',
			    strokeOpacity: 0.3,
			    strokeWeight: 3
			  };
			  poly = new google.maps.Polyline(polyOptions);
			  poly.setMap(map);
			// Add a listener for the click event
			 distHandler=google.maps.event.addListener(map, 'click', addLatLng);
			  google.maps.event.addListener(map, 'rightclick', function(){
				  google.maps.event.removeListener(distHandler);
				  poly.setVisible(false);
				  distPonts=null;
				  window.parent.closeDistance();
				  }
			  );
}
/*function to calculate distance by the polyline drawn on map*/
function addLatLng(event) {
	  var path = poly.getPath();
	  path.push(event.latLng);
	  // Update the text field to display the polyline encodings
	  var encodeString = google.maps.geometry.encoding.encodePath(path);
	  if (encodeString != null) {
	    if(path.getArray().length>1)
	    {
		    //alert(window.parent.document.getElementById('distance_val').innerHTML);
	    	window.parent.document.getElementById('distance_val').innerHTML = ((parseFloat(window.parent.document.getElementById('distance_val').innerHTML)+google.maps.geometry.spherical.computeDistanceBetween(path.getAt(path.getArray().length-2), path.getAt(path.getArray().length-1))/1000).toFixed(2));
	    }
	  }
	}

//to display show hide geofences
function showCircleGeo(){	
	
	 for(var i=0;i<circleArr.length;i++)
	    {
		 if(parent.IsShowHide && circleArr[i].getVisible()){
			
			 circleArr[i].setVisible(false);		 
			 mapLabelArr[i].setMap(null);
		 }		
		    if(!circleArr[i].getVisible())
		    {			    	
		 	circleArr[i].setVisible(true);
		 	mapLabelArr[i].setMap(map);
		 	
		    }
		 else
		 {	
			
			 circleArr[i].setVisible(false);
			 mapLabelArr[i].setMap(null);
			 parent.showGeoHide=false;
		 }
		}
	 
	 for(var i=0;i<rectArr.length;i++)
	  {
	 if(parent.IsShowHide && rectArr[i].getVisible()){			
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		 }	
		 	
		    if(!rectArr[i].getVisible())
		    {		    	
				rectArr[i].setVisible(true);
		    	mapRecLabelArr[i].setMap(map);
		    }
		 else
		 {			 
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		 }
		}
	 //console.log(polyArr);
	 for(var k=0;k<polyArr.length;k++)
	    {
 	
	     if(parent.IsShowHide && polyArr[k].getVisible()){			
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
		 }	
		 	
		    if(!polyArr[k].getVisible())
		    {		    	
		          
		    	polyArr[k].setVisible(true);
		    	mapPolyLabelArr[k].setMap(map);
		    }
		 else
		 {			 
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
			 
		 }
		} 
	 
	 parent.IsShowHide = false;
	 
}

function showCircleGeoif(){	
	 if(parent.IsShowHide){
	 for(var i=0;i<circleArr.length;i++)
	    {
		 if(parent.IsShowHide && circleArr[i].getVisible()){	
			 
			 circleArr[i].setVisible(false);		 
			 mapLabelArr[i].setMap(null);
		 }		
		    if(parent.IsShowHide&&!circleArr[i].getVisible())
		    {	
		    	   circleArr[i].setVisible(true);
				 	mapLabelArr[i].setMap(map);
		  
		    }
		 else
		 {
			
			 circleArr[i].setVisible(true);
			 	mapLabelArr[i].setMap(map);
		 }
	    }


	 for(var i=0;i<rectArr.length;i++)
	    {
		    
		
	    if(parent.IsShowHide && rectArr[i].getVisible()){			
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		
	 }	
		    if( !rectArr[i].getVisible())
		    {    	
		
		    	rectArr[i].setVisible(true);
		    	mapRecLabelArr[i].setMap(map);
		    }
		 else
		 {			 
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		 }
	    }

	 for(var k=0;k<polyArr.length;k++)
	    {
	
	     if(parent.IsShowHide && polyArr[k].getVisible()){			
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
		 }	
		 	
		    if(!polyArr[k].getVisible())
		    {		    	
		          
		    	polyArr[k].setVisible(true);
		    	mapPolyLabelArr[k].setMap(map);
		    }
		 else
		 {			 
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
			 
		 }
		} 
		}
	    
	 parent.IsShowHide = false;	 
}

function showCircleGeoall(){		
	if(parent.showGeoHide){
		
	 for(var i=0;i<circleArr.length;i++)
	    {
		 if( circleArr[i].getVisible()){	
			 
			 circleArr[i].setVisible(false);		 
			 mapLabelArr[i].setMap(null);
		 }		
		    if(parent.IsShowHide&&!circleArr[i].getVisible())
		    {	
		    	   circleArr[i].setVisible(true);
				 	mapLabelArr[i].setMap(map);
				 	
		    }
		 else
		 {
			
			 circleArr[i].setVisible(true);
			 	mapLabelArr[i].setMap(map);
		 }
	   
		}
	 
	 for(var i=0;i<rectArr.length;i++)
	    {
		
	 if( rectArr[i].getVisible()){			
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		
	 }	
		    if( !rectArr[i].getVisible())
		    {    	
		
		    	rectArr[i].setVisible(true);
		    	mapRecLabelArr[i].setMap(map);
		    }
		 else
		 {			 
			 rectArr[i].setVisible(false);
			 mapRecLabelArr[i].setMap(null);
		 }
	 
	   
	    }
	 for(var k=0;k<polyArr.length;k++)
	    {
	
	     if(parent.IsShowHide && polyArr[k].getVisible()){			
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
		 }	
		 	
		    if(!polyArr[k].getVisible())
		    {		    	
		          
		    	polyArr[k].setVisible(true);
		    	mapPolyLabelArr[k].setMap(map);
		    }
		 else
		 {			 
			 polyArr[k].setVisible(false);
			 mapPolyLabelArr[k].setMap(null);
			 
		 }
		} 
  



	    
	}
	 
}

function addRectClick(c,mapLabel) {
	 google.maps.event.addListener(mapLabel, 'rightclick', function() {	        
	    });
  google.maps.event.addListener(c, 'rightclick', function() {
  	google.maps.event.trigger(mapLabel, "rightclick");
      //window.parent.delRectGeofence(c.getBounds(),mapLabel.get('text'));
  });

}
function addCircleClick(c,mapLabel) {
	 google.maps.event.addListener(mapLabel, 'rightclick', function() {	        
	    });
   google.maps.event.addListener(c, 'rightclick', function() {
   	google.maps.event.trigger(mapLabel, "rightclick");
      // window.parent.delGeofence(c.getCenter(),mapLabel.get('text'));
   });

}
function addPolygonClick(c,mapLabel) {
	 google.maps.event.addListener(mapLabel, 'rightclick', function() {	        
	    });
  google.maps.event.addListener(c, 'rightclick', function() {
  	google.maps.event.trigger(mapLabel, "rightclick");
      window.parent.delGeofence(c.getCenter(),mapLabel.get('text'));
  });

}

	function addClickListener(){
		google.maps.event.addListenerOnce(map, 'click', function(event) {
			window.parent.showAddLocation(event.latLng.lat(), event.latLng.lng());
		 });
	}
	
	function showLocation1(){
		
		if(username=='bmm'){
		 for(var i=0;i<locationArr1.length;i++)
		    {
			 if(parent.IsLocShowHide && locationArr1[i].getVisible()){			
				 locationArr1[i].setVisible(false);
				 locLabelArr1[i].setMap(null);
			 }	
			 
			 
			    if(!locationArr[i].getVisible())
			    {
			 	locationArr1[i].setVisible(true);
			 	locLabelArr1[i].setMap(map);		
				parent.routeLocHide=false;
			    }
			 else
			 {
				 locationArr1[i].setVisible(false);
				 locLabelArr1[i].setMap(null);			
				 
			 }
			}
		}else{
			for(var i=0;i<locationArr1.length;i++)
		    {
			 if(parent.IsLocShowHide && locationArr1[i].getVisible()){			
				 locationArr1[i].setVisible(false);
				 locLabelArr1[i].setMap(null);
			 }	 
			 
			    if(!locationArr1[i].getVisible())
			    {
			 	locationArr1[i].setVisible(true);
			 	locLabelArr1[i].setMap(map);			 	
			    }
			 else
			 {
				 locationArr1[i].setVisible(false);
				 locLabelArr1[i].setMap(null);
				 parent.routeLocHide=false;
				 
			 }
			}for(var i=0;i<locationArr.length;i++)
		    {
			     locationArr[i].setVisible(false);
				 locLabelArr[i].setMap(null);
				 parent.replyLocHide=false;
				 
			
			}
		}
	}

//Function to show/hide the location depending upon visibility
function showLocation(){	
	if(username=='bmm'){
	 for(var i=0;i<locationArr.length;i++)
	    {
		 if(parent.IsLocShowHide && locationArr[i].getVisible()){			
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }	
		 
		 
		    if(!locationArr[i].getVisible())
		    {
		 	locationArr[i].setVisible(true);
		 	locLabelArr[i].setMap(map);		
			parent.replyLocHide=false;
		    }
		 else
		 {
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);			
			 
		 }
		}
	}else{
		for(var i=0;i<locationArr.length;i++)
	    {
		 if(parent.IsLocShowHide && locationArr[i].getVisible()){			
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }	 
		 
		    if(!locationArr[i].getVisible())
		    {
		 	locationArr[i].setVisible(true);
		 	locLabelArr[i].setMap(map);			 	
		    }
		 else
		 {
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
			 parent.replyLocHide=false;
			 
		 }
		}
	} 
}

function showGauge(length){
	//alert(length);
	 if(username=='bmm'){
		 //alert("1111111");
	 for(var i=0;i<length;i++)
	    {	 			
		    if(!odoArr[i].getVisible())
		    {
		    	odoArr[i].setVisible(true);
		 	gaugeLabelArr[i].setMap(map);
		 	parent.showLocHide=false;
		    }
		 else
		 {
			 odoArr[i].setVisible(false);
			 gaugeLabelArr[i].setMap(null);
		 }
	    }
	    }
		 else{
		//alert("=="+odoArr.length);
			 for(var i=0;i<length;i++)
			    {
			 if(!odoArr[i].getVisible())
			    {
				 odoArr[i].setVisible(true);
			 	gaugeLabelArr[i].setMap(map);			 	
			    }
			 else
			 {
				 odoArr[i].setVisible(false);
				 gaugeLabelArr[i].setMap(null);
			 parent.showLocHide=false;
			 }
			 
			 }
		 }
	parent.IsLocShowHide = false;
	 
}
function showLocationLatest(){		
	if(parent.IsLocShowHide){		
	 for(var i=0;i<locationArr.length;i++)
	    {
		 if(parent.IsLocShowHide && locationArr[i].getVisible()){			
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }	
		    if(!locationArr[i].getVisible())
		    {
		 	locationArr[i].setVisible(true);
		 	locLabelArr[i].setMap(map);
		    }
		 else
		 {
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }
		}
	}
	 parent.IsLocShowHide = false;
	 
}
function showLocationall(){		
	if(username=='bmm'){
	//	alert("333333");
	if(!parent.showLocHide){		
		
	 for(var i=0;i<locationArr.length;i++)
	    {
		 if(parent.IsLocShowHide && locationArr[i].getVisible()){			
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }	
		    if(!locationArr[i].getVisible())
		    {
		 	locationArr[i].setVisible(true);
		 	locLabelArr[i].setMap(map);
		    }
		 else
		 {
			 locationArr[i].setVisible(false);
			 locLabelArr[i].setMap(null);
		 }
		}	
	}
	}else{
		//alert("444444");			
		if(parent.showLocHide){
			
			
			 for(var i=0;i<locationArr.length;i++)
			    {			 
				    if(!locationArr[i].getVisible())
				    {
				 	locationArr[i].setVisible(true);
				 	locLabelArr[i].setMap(map);
				    }
				 else
				 {
					 locationArr[i].setVisible(false);
					 locLabelArr[i].setMap(null);
				 }
				}	
			}
	}
}


//Add right click listener to location for the deletion operation and call the delLocation method in locationContent.js
function addLocationClick(marker) {
    google.maps.event.addListener(marker, 'rightclick', function() {
    	//window.parent.delLocation(marker.getPosition(),marker.getTitle())
    });
}

//alert(baseUrl);
//initialize location image path from server
var markerIcon1 = baseUrl+'MapIcon/fill_icons/Location.icon';

var gaugeIcon = 'images/gauge.jpg';
//function to add markerimage to locations
var markerImage1 = new google.maps.MarkerImage(
		   markerIcon1,
		   new google.maps.Size(32, 32),
	        new google.maps.Point(0,0),
	        new google.maps.Point(3, 10),
	        new google.maps.Size(22, 22));

var gaugeImage = new google.maps.MarkerImage(
		   gaugeIcon,
		   new google.maps.Size(32, 32),
	        new google.maps.Point(0,0),
	        new google.maps.Point(3, 10),
	        new google.maps.Size(22, 22));

	//function to draw image for the location
	function addLocMarker(lat,longi,location) {
		var contents = document.createElement("div");
		contents.style.cssText = "";
		contents.innerHTML = '';
		
		   var marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat, longi),
							icon:markerImage1,
							map: map,
							title:location,
							labelContent:location					 
						});
		   //add right click listener to location marker
		   addLocationClick(marker);
		   //variable to add label to location
			var mapLabel = new MapLabel({
							 map: map,
						     fontSize: 12,
						     fontColor:'#fff000',
						     fontWeight:10,
						     strokeWeight:3,
						     strokeColor:'#000000',
						     align: 'left'
						  });
			  mapLabel.set('position', new google.maps.LatLng(lat, longi));
			  mapLabel.set('text', location);
			  //bind the  lable to map through marker
			  marker.bindTo('map', mapLabel);
			  marker.bindTo('position', mapLabel);
			  //push the location marker and label to array for show hide purpose 
			  locationArr.push(marker);
			  locLabelArr.push(mapLabel);
			  //window.parent.maplocation=marker;
			  //initially hide all marker and label
			  marker.setVisible(false);
			  mapLabel.setMap(null);
	}
	
	function addLocMarker1(lat,longi,location) {
		var contents = document.createElement("div");
		contents.style.cssText = "";
		contents.innerHTML = '';
		
		   var marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat, longi),
							icon:markerImage1,
							map: map,
							title:location,
							labelContent:location
						 
						});
		   //add right click listener to location marker
		   addLocationClick(marker);
		   //variable to add label to location
			var mapLabel = new MapLabel({
							 map: map,
						     fontSize: 12,
						     fontColor:'#fff000',
						     fontWeight:10,
						     strokeWeight:3,
						     strokeColor:'#000000',
						     align: 'right'
			  			});
			  mapLabel.set('position', new google.maps.LatLng(lat, longi));
			  mapLabel.set('text', location);
			  //bind the  lable to map through marker
			  marker.bindTo('map', mapLabel);
			  marker.bindTo('position', mapLabel);
			  //push the location marker and label to array for show hide purpose 
			  locationArr1.push(marker);
			  locLabelArr1.push(mapLabel);
			  window.parent.maplocation=marker;
			  //initially hide all marker and label
			  marker.setVisible(false);
			  mapLabel.setMap(null);
	}


	function addLastMarker(lat,longi,location) {
		var contents = document.createElement("div");
		contents.style.cssText = "";
		contents.innerHTML = '';
		
		   var marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat, longi),
							icon:markerImage1,
							map: map,
							title:location,
							labelContent:location					 
						});
		   //add right click listener to location marker
		   addLocationClick(marker);
		   //variable to add label to location
			var mapLabel = new MapLabel({
				 map: map,
			     fontSize: 12,
			     fontColor:'#fff000',
			     fontWeight:10,
			     strokeWeight:3,
			     strokeColor:'#000000',
			     align: 'right'
			  });
			  mapLabel.set('position', new google.maps.LatLng(lat, longi));
			  mapLabel.set('text', location);
			  //bind the  lable to map through marker
			  marker.bindTo('map', mapLabel);
			  marker.bindTo('position', mapLabel);  
	  
	}

function addGaugeMarker(lat,longi,odo) {

	var marker = new google.maps.Marker({
position: new google.maps.LatLng(lat, longi),
icon:gaugeImage,
map: map,
title:odo,
labelContent:odo
 
});
	   

var gaugeLabel = new MapLabel({
	 map: map,
    fontSize: 12,
    fontColor:'#fff000',
    fontWeight:10,
    strokeWeight:3,
    strokeColor:'#000000',
    align: 'right'
 });

  
  gaugeLabel.set('position', new google.maps.LatLng(lat, longi));
  gaugeLabel.set('text', '');
  //bind the  lable to map through marker
  marker.bindTo('map', gaugeLabel);
  marker.bindTo('position', gaugeLabel);
  //push the location marker and label to array for show hide purpose 
  odoArr.push(marker);
  gaugeLabelArr.push(gaugeLabel);
  //initially hide all marker and label
  marker.setVisible(false);
  gaugeLabel.setMap(null);


//alert(odo);
  
  var infoWindowContent = '<div id="map-form" style="height:110px;width:50px;"></div>';

 var info = new google.maps.InfoWindow({
      content: infoWindowContent
  });


 google.maps.event.addListener(info, 'domready', function() {

 drawChart();

 });

 google.maps.event.addListener(marker, 'click', function() {


	 info.open(map, marker);


	 });
  
}

function drawChart() {

   // alert("hi");
  var data = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['Odo', 80],
    ]);

  var options = {
    width: 100, height: 100,
    redFrom: 90, redTo: 100,
    yellowFrom:75, yellowTo: 90,
    minorTicks: 5
  };
//alert("1=="+document.getElementById("map-form"));
 var chart = new google.visualization.Gauge(document.getElementById('map-form'));
chart.draw(data, options);

}



function HomeControl(controlDiv, map) {

    controlDiv.style.padding = '0px';
    var controlUI = document.createElement('div');
    controlUI.style.cssText='margin-top: 8px;  padding: 5px;color:white';
  	controlUI.style.marginRight = '5px';
  	controlUI.style.marginTop = '-5px';
    controlUI.style.textAlign = 'center';
    controlDiv.appendChild(controlUI);

    var controlText = document.createElement('div');
  
    controlText.style.paddingLeft = '100px';
    controlText.style.paddingRight = '0px';
    controlText.style.paddingTop = '0px';
    controlText.style.paddingBottom = '100px';
    controlText.style.width = '50px';
    controlText.style.height = '50px';
    
    controlUI.appendChild(controlText);


    //  google.maps.event.addDomListener(controlUI, 'load', function() { 
    //	 drawVisualization();
     
   //   });
    

 
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

/* hide onfo box */
  function hideinfoBox(){
	  removeElementsByClass('infoBox');
}
 

/*to hide all the location */
function hideAllNode(){
	//console.log(gmarkers.length);
	removeElementsByClass('infoBox');
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

	function listMarkers(first, track){

   	 var longitudeArr = new Array();
		var latitudeArr = new Array();
		var longitudebmArr = new Array('76.3761425','76.3762114','76.3774204','76.3791213','76.377983','76.384764');
		var latitudebmArr = new Array('15.1752909','15.1755593','15.1719339','15.1717633','15.170808','15.171181');
		var directionArr = new Array();
		var unirnameArr = new Array();
		var statusesArr  = new Array();
		var statusColorArr = new Array();
		var reporttimeArr = new Array();
		var locationArr = new Array();
		var speedArr = new Array();
		
	  
   	 var markers;
   	    // Define the list of markers.
   	    // This could be generated server-side with a script creating the array.
   	    
   	    var markerIcon="";
   	    var directionIcon="";
   	   

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

   	 //var trackcombo = parent.document.getElementById("trackVehicle").value;
		if(track){
		//	alert();
			var response = window.parent.httpResponse1;
			//console.log(response);
		}
		else{
	 	  var response = window.parent.httpResponse;
		}
		if(response.length){
	 	  response.forEach( function(data, index) { 
	 		  latitudeArr.push(data.latitude);
	 		  longitudeArr.push(data.longitude);
	 		  directionArr.push(data.direction);
	 		  unirnameArr.push(data.unitname);
	 		  statusesArr.push(data.STATUS);
	 		  statusColorArr.push(data.statusColor);
	 		  reporttimeArr.push(data.reportTime);
	 		  speedArr.push(data.speed);
	 		  locationArr.push(data.location);		  
	 	  });
   	    // Create the markers
   	    
   	   for ( var i = 0; i < longitudeArr.length; i++) 
   		{
   		   markerIcon = "";
   		   //console.log(statusColorArr[i]);
   		   if(markerIconArr[statusColorArr[i]] != 'undefined'){
   	       	markerIcon = baseUrl+'MapIcon/fill_icons/'+markerIconArr[statusColorArr[i]];
   	       }
   		//console.log(markerIcon);
   		   var markerImage = new google.maps.MarkerImage(
   				   markerIcon,
   				   new google.maps.Size(13, 13),
   			        new google.maps.Point(0,0),
   			        new google.maps.Point(0,0),
   			        new google.maps.Size(13, 13));

   		   if(directionArr[i]=="")
   				directionIcon = '';
   		   else{
   			   var dir = directionArr[i], locationSub = locationArr[i];
   				directionIcon = '';
   				switch(statusColorArr[i]){
   					case "2": if(locationSub.substring(0,3)!='Geo'){directionIcon = movingDirc(dir);}break;
   					case "3": if(locationSub.substring(0,3)!='Geo'){directionIcon = suddenDirc(dir);}break;
   					case "6": directionIcon = geoDirc(dir);break;
   					case "12": if(locationSub.substring(0,3)!='Geo'){directionIcon = ignDirc(dir);}break;
   					case "13": if(locationSub.substring(0,3)!='Geo'){directionIcon = overSpdDirc(dir);}break;   
   					case "15": if(locationSub.substring(0,3)!='Geo'){directionIcon = slowIdleDirc(dir);}break;   										
   					default : if(locationSub.substring(0,3)=='Geo'){directionIcon = geoDirc(dir);}else{directionIcon = "";}break;
   				}	
   		   }
   		//console.log(directionIcon);
   		   var directionImage = new google.maps.MarkerImage(
   				   directionIcon,
   				   new google.maps.Size(13, 13),
   			        new google.maps.Point(0,0),
   			        new google.maps.Point(0, 0),
   			        new google.maps.Size(13, 13));
   				  
   			
	   		   if(directionIcon=="")
	   		   {
	   	   	
		   		   if((parent.document.getElementById("statusButton").value == "Ign" && statusesArr[i].substring(0,3)=='Ign') ||
		   		   		(parent.document.getElementById("statusButton").value == "Slow/Idle" && statusesArr[i].substring(0,9)=='Slow/Idle') ||
		   		   		(parent.document.getElementById("statusButton").value == "Geoentry" && statusesArr[i].substring(0,3)=='Geo') ||
		   		   	    (parent.document.getElementById("statusButton").value == "Suddenbrakestart" && statusesArr[i].substring(0,12)=='Sudden Brake') ||
		   		   		parent.document.getElementById("statusButton").value == ""){
		 			   addMarker(track,latitudeArr[i],longitudeArr[i],unirnameArr[i],locationArr[i],reporttimeArr[i],statusesArr[i],markerImage,i);
		 		   }
	   		   }
	   		   else{
		   			if((parent.document.getElementById("statusButton").value == "Moving" && statusesArr[i]=='Moving') ||
			   		   		(parent.document.getElementById("statusButton").value == "Slow/Idle" && statusesArr[i].substring(0,9)=='Slow/Idle') ||
				   		   	(parent.document.getElementById("statusButton").value == "Overspeed" && statusesArr[i].substring(0,9)=='Overspeed') ||
				   		    (parent.document.getElementById("statusButton").value == "HarshAccel" && statusesArr[i].substring(0,11)=='Harsh Accel') ||
			   		   		(parent.document.getElementById("statusButton").value == "Geoentry" && statusesArr[i].substring(0,3)=='Geo') ||
			   		   	    (parent.document.getElementById("statusButton").value == "Suddenbrakestart" && statusesArr[i].substring(0,12)=='Sudden Brake') ||
			   		   		parent.document.getElementById("statusButton").value == ""){
		   		   		//console.log(statusesArr[i]);
	   				    addMarkerStatus(track,latitudeArr[i],longitudeArr[i],unirnameArr[i],locationArr[i],reporttimeArr[i],statusesArr[i],markerImage,directionImage,i);
		   			}
   			   }
			   //if(track){
   					lineCoordinates.push(new google.maps.LatLng(latitudeArr[i],longitudeArr[i]));
			  // }
   			}
	
   //	 alert(first);
		/*if(first){
			// Zoom and center the map to fit the markers
	    	// This logic could be conbined with the marker creation.
	    	// Just keeping it separate for code clarity.
			var bounds = new google.maps.LatLngBounds();
		    var locbounds = new google.maps.LatLngBounds();
		    //alert(bounds);
		    if(temp != "" && temp1 != ""&&temp != 'undefined')
		    {
		    	bounds.extend(new google.maps.LatLng(temp1,temp));
		    	
		    	if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
		    		   var extendPoint = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
		    		   bounds.extend(extendPoint);
		    		}
		    	
		    }  
		    else{
		    	if(username=='bmm'){      		
		    		for ( var i = 0; i < longitudebmArr.length; i++) {    			
		 			   bounds.extend(new google.maps.LatLng(latitudebmArr[i],longitudebmArr[i]));
		 			 }     	
		 	}
		    	
		    	else{
		    		 for ( var i = 0; i < longitudeArr.length; i++) {
		    			  
		    			   bounds.extend(new google.maps.LatLng(latitudeArr[i],longitudeArr[i]));
		    			 }     	
		    	}
		    }
	
		   
		    var parBounds=document.getElementById('parambounds').value;    
		    var paramCenter=document.getElementById('paramCenter').value;
		    paramCenter=(paramCenter.replace('(','')).replace(')','');
		    var zooms=parseInt(parBounds);
		    var paramCenterArray=new Array();
		    paramCenterArray=paramCenter.split(',');
		    if((document.getElementById('parambounds').value=="")||(document.getElementById('parambounds').value=='undefined'))
		    {
		    	map.fitBounds(bounds);
		    }
		    else
		    {
		        if(window.parent.enableZoom=='undefined')
		        {
		        	map.fitBounds(bounds);
		        }
		        else if(window.parent.enableZoom)
		        {        	
		    		map.setCenter(new google.maps.LatLng(paramCenterArray[0],paramCenterArray[1]));
		    		 map.setZoom(zooms);
		    		 window.parent.mapZoomer=map.getZoom();
		    		 window.parent.mapCenter=map.getCenter();
		    		 if(temp != "" && temp1 != ""&&temp != 'undefined')
		    		    {
		    			 map.panTo(new google.maps.LatLng(temp1,temp));	
		    		    } 
		        }
		        else
		        {
		        	 map.fitBounds(bounds);    
		        }
		    } 
		} */

		//if(track){
			var lineSymbol = {
			   		  path: 'M 0,-1 0,1',
			   		  strokeOpacity: 0.5,
			   		  strokeColor: '#FF0000',
			   		  scale: 4
			   		};
			   line = new google.maps.Polyline({
			       path: lineCoordinates,
			       strokeOpacity: 0,
			       icons: [{
			           icon: lineSymbol,
			           offset: '0',
			           repeat: '20px'
			         }],
			       map: map
			     });
			   line.setVisible(false); 
			   showLinePath(); 
		//}
	}
	}

	function showLinePath(){	
		/*if(!line.getVisible() && parent.showtrackHide == true){		
			line.setVisible(true);			
		}
		else if(parent.showtrackHide == true){
			line.setVisible(true);			
		}
		else{		
			line.setVisible(false);
			parent.showtrackHide=false;
		}*/

		for(var k=0;k<polylineArr.length;k++)
	    {
 	
	     if(parent.showtrackHide && polylineArr[k].getVisible()){			
			 polylineArr[k].setVisible(false);
			 mapPolylineLabelArr[k].setMap(null);
		 }	
		 	
		    if(!polylineArr[k].getVisible())
		    {		    	
		          
		    	polylineArr[k].setVisible(true);
		    	mapPolylineLabelArr[k].setMap(map);
		    }
		 else
		 {			 
			 polylineArr[k].setVisible(false);
			 mapPolylineLabelArr[k].setMap(null);
			 
		 }
		} 
	 
	 parent.showtrackHide = false;
	}

	function markerStatus(status){
		var st = "";
		switch(status){
			case "Ign Off": st = "border: 2px double #E2B227; margin-top: 0px; background: #0033CC; padding: 2px;";break;
			case "Poll R": st = "border: 2px double #E2B227; margin-top: 0px; background: #0033CC; padding: 2px;";break;
			case "Ign On": st = "border: 2px double #E2B227; margin-top: 0px; background: #3368CC; padding: 2px;";break;
			case "Moving": st = "border: 2px double #E2B227; margin-top: 0px; background: #33CC00; padding: 2px;";break;
			case "Overspeed": st = "border: 2px double #E2B227; margin-top: 0px; background: #980066; padding: 2px;";break;
			case "Slow/Idle": st = "border: 2px double #E2B227; margin-top: 0px; background: #AC3B00; padding: 2px;";break;
			case "Slow/Idle End": st = "border: 2px double #E2B227; margin-top: 0px; background: #AC3B00; padding: 2px;";break;
			case "Overspeed End": st = "border: 2px double #E2B227; margin-top: 0px; background: #980066; padding: 2px;";break;
			case "Unreachable": st = "border: 2px double #E2B227; margin-top: 0px; background: #ACACAC; padding: 2px;";break;
			default: st = "border: 2px double #E2B227; margin-top: 0px; background: #00B050; padding: 2px;";break;
		}
		return st;
   	 }
    
 
    function addMarker(track,lat,longi,unitname,location,reporttime,status,markerImage,speed) {
    	var contents = document.createElement("div");
    	var comval = parent.document.getElementById('showMarkers').value;  
    	contents.style.cssText = markerStatus(status);
    	
       var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat, longi),
				icon:markerImage,
				map: map,
				title:status
				//labelContent:unitname		
			});
		
       gmarkers.push(marker);
       google.maps.event.addListener(marker, 'click', function() {
    	   //alert(status);
    	   
    	   if(comval == "" || comval == "Show / Hide Labels"){
        	   var width = "280px";
        		   width = "280px";
        		   contents.style.cssText = "text-align:left;border: 5px double #D4BF37; margin-top: 8px; background: #00B050; padding: 5px;";
        		   contents.innerHTML = '<div  style="opacity:1;font:bolder 11px tahoma, arial, helvetica, sans-serif;padding:2%">'+location+'<br/>'+reporttime+'<br/>'+status+'</div>';
        	   
	    	   dropInfoBox = new InfoBox({
	 	          //content: contents,
	 	          disableAutoPan: false,
	 	          closeBoxMargin : "2px",
	 	          pixelOffset: new google.maps.Size(5, 14),
	 	          zIndex: null,
	 	        // pane :"mapPane",
	 	          boxStyle: {
	 	 			  border: "5px",
	 	 			  background: "url('tipbox.gif') no-repeat",
	 	              color: 'white',
	 	              textAlign: "center",
	 	             // background: '#00B050',
	 	              width: width
	 	          },
	 	          
	 	          infoBoxClearance: new google.maps.Size(1, 1)
	 	      }); 
	    	 dropInfoBox.setContent(contents);
	    	 dropInfoBox.open(map, marker);
    	   }
       });

      // title.innerHTML = marker.getTitle();
      
      
      if(comval == 2 || comval == 4 || comval == 5){
    	  
          var arr = ["", unitname, reporttime, speed, status, location];
          var arrWidth = ["", "120px", "130px", "40px", "90px", "200px"];
          var arrAlign = ["", "center", "left", "center", "center", "center"];
    	  contents.innerHTML = '<div  style="opacity:1;font:bolder 11px tahoma, arial, helvetica, sans-serif;padding:1%">'+arr[comval]+'</div>';
	   	   dropInfoBox = new InfoBox({
		          //content: contents,
		          disableAutoPan: false,
		          closeBoxMargin : "2px",
		          pixelOffset: new google.maps.Size(5, 14),
		          zIndex: null,
		        // pane :"mapPane",
		          boxStyle: {
		 			  border: "5px",
		              color: 'white',
		              textAlign: arrAlign[comval],
		              width: arrWidth[comval]
		          },
		          
		          infoBoxClearance: new google.maps.Size(1, 1)
		      }); 
	   	 dropInfoBox.setContent(contents);
	   	 dropInfoBox.open(map, marker);
      }
	
 		}

    function addMarkerStatus(track,lat,longi,mapUnitname,mapLocation,mapReporttime,mapStatus,markerImage,directionImage,mapSpeed) {
    	var contents = document.createElement("div");
    	
    	var comval = parent.document.getElementById('showMarkers').value;  
    	contents.style.cssText = markerStatus(mapStatus);
    	
 	   	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, longi),
		icon:directionImage,
		map: map,
		title:mapStatus
   
		});
 	   gmarkers.push(marker);
 	   
 	   google.maps.event.addListener(marker, 'click', function() {
 		  
    	   if(comval == "" || comval == "Show / Hide Labels"){
    		   var width = "280px";
        		   contents.style.cssText = "text-align:left;border: 5px double #D4BF37; margin-top: 8px; background: #00B050; padding: 5px;";
        		   contents.innerHTML = '<div  style="opacity:1;font:bolder 11px tahoma, arial, helvetica, sans-serif;padding:2%">'+mapLocation+'<br/>'+mapReporttime+'<br/>'+mapStatus+'</div>';
        	  
	    	   dropInfoBox = new InfoBox({
	 	          //content: contents,
	 	          disableAutoPan: false,
	 	          closeBoxMargin : "2px",
	 	          pixelOffset: new google.maps.Size(5, 14),
	 	          zIndex: null,
	 	        // pane :"mapPane",
	 	          boxStyle: {
	 	 			  border: "5px",
	 	 			  background: "url('tipbox.gif') no-repeat",
	 	              color: 'white',
	 	              textAlign: "center",
	 	             // background: '#00B050',
	 	              width: width
	 	          },
	 	          
	 	          infoBoxClearance: new google.maps.Size(1, 1)
	 	      }); 
	    	 dropInfoBox.setContent(contents);
	    	 dropInfoBox.open(map, marker);
    	   }
       });

	 	  //title.innerHTML = marker.getTitle();
 	
 	  if(comval == 2 || comval == 4 || comval == 5){
 	 	
          var arr = ["", mapUnitname, mapReporttime, mapSpeed, mapStatus, mapLocation];
          var arrWidth = ["", "120px", "130px", "40px", "90px", "200px"];
          var arrAlign = ["", "center", "left", "center", "center", "center"];
    	  contents.innerHTML = '<div  style="opacity:1;font:bolder 11px tahoma, arial, helvetica, sans-serif;padding:1%">'+arr[comval]+'</div>';
	   	   dropInfoBox = new InfoBox({
		          //content: contents,
		          disableAutoPan: false,
		          closeBoxMargin : "2px",
		          pixelOffset: new google.maps.Size(5, 14),
		          zIndex: null,
		        // pane :"mapPane",
		          boxStyle: {
		 			  border: "5px",
		              color: 'white',
		              textAlign: arrAlign[comval],
		              width: arrWidth[comval]
		          },
		          
		          infoBoxClearance: new google.maps.Size(1, 1)
		      }); 
	   	 dropInfoBox.setContent(contents);
	   	 dropInfoBox.open(map, marker);
      }
 	 
	 }

    function removeElementsByClass(className){
        var elements = document.getElementsByClassName(className);
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
    }

    function refreshMarkers(val, track){
		var bounds = new google.maps.LatLngBounds();
		//alert(gmarkers.length);
	    // delete all existing markers first
	    //document.getElementsByClassName("infoBox").remove();
	    removeElementsByClass('infoBox');
	    for (var i = 0; i < gmarkers.length; i++) {
	        gmarkers[i].setMap(null);
	    }
	    gmarkers = [];
	    lineCoordinates = [];
	    // add new markers from the JSON data
	    listMarkers(val, track);

	    // zoom the map to show all the markers, may not be desirable.
	   // map.fitBounds(bounds);
	}

 // Define a symbol using SVG path notation, with an opacity of 1.
    var lineSymbol = {
      path: 'M 0,-1 0,3',
      strokeOpacity: 1,
      scale: 1.5,
	  strokeColor:'#FF0000',
	  fillColor: '#FF0000',
	  fillOpacity: 0

    };

	function setGeofence(){
		var rectResponse = window.parent.rectangularGeoStore;
		var cirResponse = window.parent.circularGeoStore;
		var polyResponse = window.parent.polygonGeoStore;
		var polylineResponse = window.parent.polylineGeoStore;
		var locResponse = window.parent.locationStore;  
			//console.log(locResponse);
		locResponse.forEach( function(data, i) {		   
	    	//call marker draw function get the latitude longitude and name from ext location store
	    	addLocMarker(data.latitude,data.longitude,data.locationName);
	    	//set map view/bounds to show all locations	    	    		
	    	//locbounds.extend(new google.maps.LatLng(data.latitude,data.longitude));   		
    	});
			
		rectResponse.forEach( function(data, i) {
		  	//rect get all latitude,longitude and other details from ext js page store  	
					 var rectBound=new google.maps.LatLngBounds(new google.maps.LatLng(data.latitude1, data.longitude1), 
					           new google.maps.LatLng(data.latitude2, data.longitude2));
					   		var rectangle =  new google.maps.Rectangle({
					        map:map,
					        bounds:rectBound,			     
					        options:{
					   			strokeWeight: 0,
					            fillOpacity: 0.45,
					            fillColor: '#00806A',
					            title:data.geofenceName,
					            editable: false
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
					 mapLabel.set('position', rectBound.getCenter());
					 allgeobounds.extend(rectBound.getCenter());
					 mapLabel.set('text', data.geofenceName);
					 rectangle.bindTo('map', mapLabel);
					 rectangle.bindTo('position', mapLabel);
					 addRectClick(rectangle,mapLabel);
					 rectangle.setVisible(false);
					 mapRecLabelArr.push(mapLabel);
					 mapLabel.setMap(null);
					 rectArr.push(rectangle);
		    });
 
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
			             var polygon =  new google.maps.Polygon({
					        map:map,
					        paths: PolyCoords,
					        options:{
		                	strokeWeight: 0,
				            fillOpacity: 0.45,
				            fillColor: '#FF0000',
				            title: data.geofenceName,
				            editable: false
				          }
					       
					      });
					   	
					     var mapLabel = new MapLabel({
					    	  map: map,
					          fontSize: 18,
					          fontColor:'#fff000',
					          fontWeight:10,
					          strokeWeight:3,
					          strokeColor:'#000000',
					          labelClass: "labels",
					          align: 'center'
					     });

		         
					    for (var j = 0; j<PolyCoords.length; j++) {
						   allGeobounds.extend(PolyCoords[j]);
						   polyGeobounds.extend(PolyCoords[j]);
					        
					      }
		       
					
				     mapLabel.set('position',polyGeobounds.getCenter());
					 mapLabel.set('text',  data.geofenceName);
					 polygon.bindTo('map', mapLabel);
					 polygon.bindTo('position', mapLabel);
					 addPolygonClick(polygon,mapLabel);
					 //map.fitBounds(polyGeobounds);
					 polygon.setVisible(false);
					 mapPolyLabelArr.push(mapLabel);
					 mapLabel.setMap(null);
					 polyArr.push(polygon);  
					

		});


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

		    // Create the polyline, passing the symbol in the 'icons' property.
		        // Give the line an opacity of 0.
		        // Repeat the symbol at intervals of 20 pixels to create the dashed effect.
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
				   	
				     var mapLabel = new MapLabel({
				    	  map: map,
				          fontSize: 18,
				          fontColor:'#fff000',
				          fontWeight:10,
				          strokeWeight:3,
				          strokeColor:'#000000',
				          labelClass: "labels",
				          align: 'center'
				     });

	         
				    for (var j = 0; j<PolyCoords.length; j++) {
					   allGeobounds.extend(PolyCoords[j]);
					   polyGeobounds.extend(PolyCoords[j]);
				        
				      }
	       
				
			     mapLabel.set('position',polyGeobounds.getCenter());
				 mapLabel.set('text',  data.geofenceName);
				 line.bindTo('map', mapLabel);
				 line.bindTo('position', mapLabel);
				 //addPolygonClick(polygon,mapLabel);
				 //map.fitBounds(polyGeobounds);
				 line.setVisible(false);
				 mapPolylineLabelArr.push(mapLabel);
				 mapLabel.setMap(null);
				 polylineArr.push(line);  
				

	});

		//circle get all latitude,longitude and other details from ext js page store
		cirResponse.forEach( function(data, i) {  				
		 var circle = new google.maps.Circle({
			 
		       map:map,
		       center:new google.maps.LatLng(data.latitude, data.longitude),
		       radius: parseFloat(data.radius)+0.00,
		       options:{
		           strokeWeight: 0,
		           fillOpacity: 0.45,
		           fillColor: '#990000',
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
		     allgeobounds.extend(circle.getCenter());
		     mapLabel.set('text',data.geofenceName+" : "+data.radius+"(in Mts)");
		     circle.bindTo('map', mapLabel);
		     circle.bindTo('position', mapLabel);
		     addCircleClick(circle,mapLabel);
		     circle.setVisible(false);
		     mapLabelArr.push(mapLabel);
		     mapLabel.setMap(null);
		     circleArr.push(circle);
		});
	}

	function setLatestGeofence(){
		var rectLatestResponse = window.parent.rectangularGeoLatestStore;
		var cirLatestResponse = window.parent.circularGeoLatestStore;
		var polyLatestResponse = window.parent.polygonGeoLatestStore; 
		var polylineLatestResponse = window.parent.polylineGeoLatestStore;
		var locLatestResponse = window.parent.locationLatestStore;
		var routeResponse = window.parent.routeLocation;

		polylineLatestResponse.forEach( function(data, i) {
	         
		   	   var allGeobounds = new google.maps.LatLngBounds();
		          var PolyCoords= new Array();
		          var latlon = data.latlon;
			       var polyGeobounds = new google.maps.LatLngBounds();
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

			    // Create the polyline, passing the symbol in the 'icons' property.
			        // Give the line an opacity of 0.
			        // Repeat the symbol at intervals of 20 pixels to create the dashed effect.
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
					   	
					     var mapLabel = new MapLabel({
					    	  map: map,
					          fontSize: 18,
					          fontColor:'#fff000',
					          fontWeight:10,
					          strokeWeight:3,
					          strokeColor:'#000000',
					          labelClass: "labels",
					          align: 'center'
					     });

		           
					    for (var j = 0; j<PolyCoords.length; j++) {
						   allGeobounds.extend(PolyCoords[j]);
						   polyGeobounds.extend(PolyCoords[j]);
					        
					      }
		         
					 
				     mapLabel.set('position',polyGeobounds.getCenter());
					 mapLabel.set('text', data.geofenceName);
					 line.bindTo('map', mapLabel);
					 line.bindTo('position', mapLabel);
					 //addPolygonClick(polygon,mapLabel);
					 mapPolylineLabelArr.push(line);
					// map.fitBounds(polyGeobounds);
				
		              // window.parent.hideMsg();

		      });

		locLatestResponse.forEach( function(data, i) {		
	    	//call marker draw function get the latitude longitude and name from ext location store
	    	addLastMarker(data.latitude,data.longitude,data.locationName);
	    	//set map view/bounds to show all locations  
	    	if(username!='bmm')
	        bounds.extend(new google.maps.LatLng(data.latitude,data.longitude));
	    });

		routeResponse.forEach( function(data, i) {
	    	//call marker draw function get the latitude longitude and name from ext location store
	    	addLocMarker1(data.latitude,data.longitude,data.location);
	    	//set map view/bounds to show all locations		    	   	    		
	    	locbounds.extend(new google.maps.LatLng(data.latitude,data.longitude));   		
	    });
   	 	
		rectLatestResponse.forEach( function(data, i) {
	   		//rect get all latitude,longitude and other details from ext js page store
	   			 var rectBound=new google.maps.LatLngBounds(new google.maps.LatLng(data.latitude1, data.longitude1), 
	   			       new google.maps.LatLng(data.latitude2, data.longitude2));
	   			   		var rectangle =  new google.maps.Rectangle({
	   			        map:map,
	   			        bounds:rectBound,		     
	   			        options:{

	   			   			strokeWeight: 0,
	   			            fillOpacity: 0.45,
	   			            fillColor: '#00806A',
	   			            title:data.geofenceName,
	   			            editable: false
	   			          }		       
	   			      });		   	
	   			     var mapLabel = new MapLabel({
	   			    	  map: map,
	   			          fontSize: 12,
	   			          fontColor:'#fff000',
	   			          fontWeight:10,
	   			          strokeWeight:3,
	   			          strokeColor:'#000000',
	   			          labelClass: "labels",
	   			          align: 'center'
	   			     });
	   			 mapLabel.set('position', rectBound.getCenter());
	   			 allgeobounds.extend(rectBound.getCenter());
	   			 mapLabel.set('text', data.geofenceName);
	   			 rectangle.bindTo('map', mapLabel);
	   			 rectangle.bindTo('position', mapLabel);
	   			 addRectClick(rectangle,mapLabel);  
	   			if(parent.buttonvalue && username!='bmm'){
	   			 //map.fitBounds(rectangle.getBounds());
	   			}
	   			else{
	   				if(username!='bmm'){
	   			 //map.fitBounds(rectangle.getBounds());
	   			// map.setZoom(12);
	   			}
	   			}
	   	 
	  		});
	   
		polyLatestResponse.forEach( function(data, i) {
	         
	   	   var allGeobounds = new google.maps.LatLngBounds();
	          var PolyCoords= new Array();
	          var latlon = data.latlon;
		       var polyGeobounds = new google.maps.LatLngBounds();
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
		             var polygon =  new google.maps.Polygon({
				        map:map,
				        paths: PolyCoords,
	 			        options:{
	                  	strokeWeight: 0,
			            fillOpacity: 0.45,
			            fillColor: '#FF0000',
			            title:data.geofenceName,
			            editable: false
			          }
				       
				      });
				   	
				     var mapLabel = new MapLabel({
				    	  map: map,
				          fontSize: 18,
				          fontColor:'#fff000',
				          fontWeight:10,
				          strokeWeight:3,
				          strokeColor:'#000000',
				          labelClass: "labels",
				          align: 'center'
				     });

	           
				    for (var j = 0; j<PolyCoords.length; j++) {
					   allGeobounds.extend(PolyCoords[j]);
					   polyGeobounds.extend(PolyCoords[j]);
				        
				      }
	         
				 
			     mapLabel.set('position',polyGeobounds.getCenter());
				 mapLabel.set('text', data.geofenceName);
				 polygon.bindTo('map', mapLabel);
				 polygon.bindTo('position', mapLabel);
				 addPolygonClick(polygon,mapLabel);
				 mapPolyLabelArr.push(polygon);
				 //map.fitBounds(polyGeobounds);
			
	              // window.parent.hideMsg();

	      });

	  		
	   	    //circle get all latitude,longitude and other details from ext js page store
	   			cirLatestResponse.forEach( function(data, i) {		
	   				 var circle = new google.maps.Circle({
	   				       map: map,
	   				       center:new google.maps.LatLng(data.latitude, data.longitude),
	   				       radius: parseFloat(data.radius)+0.00,
	   				       options:{
	   				           strokeWeight: 0,
	   				           fillOpacity: 0.45,
	   				           fillColor: '#990000',
	   				           title:data.geofenceName,
	   				           editable: false,
	   				           visible:true
	   				         }			      
	   				     });			
	   				   var mapLabel = new MapLabel({
	   				       map: map,
	   				       fontSize: 12,
	   				       fontColor:'#fff000',
	   				       fontWeight:10,
	   				       strokeWeight:3,
	   				       strokeColor:'#000000',
	   				       labelClass: "labels",
	   				       align: 'center'
	   				     });
	   				     mapLabel.set('position', circle.getCenter());
	   				     allgeobounds.extend(circle.getCenter());
	   				     mapLabel.set('text',data.geofenceName+" : "+data.radius+"(in Mts)");
	   				     circle.bindTo('map', mapLabel);
	   				     circle.bindTo('position', mapLabel); 	
	   				     addCircleClick(circle,mapLabel);  
	   				  if(username!='bmm'){
	   				  	//map.fitBounds(circle.getBounds()); 
	   				  }
	   				});
	}
	
     function initialize() {

	  mapView = document.getElementById("mapView").value;
	  switch(mapView){
	  	case "H": mapView=google.maps.MapTypeId.HYBRID;break;
	  	case "M": mapView=google.maps.MapTypeId.ROADMAP;break;
	  	case "S": mapView=google.maps.MapTypeId.SATELLITE;break;
	  	default : mapView=google.maps.MapTypeId.ROADMAP;break;
	  }
	  
	  var mapCont=document.getElementById("map_canvas");

		var splitval=" ", splitdate=" ", dateval="", recordval="", value="";
		
    // Create the map 
    // No need to specify zoom and center as we fit the map further down.
     var content = document.createElement("DIV");
    
    var title = document.createElement("DIV");
    content.appendChild(title);
    myOptions = {		 
    		//content:content,  
    		zoom: 15,
		  rotation: 5,
		  
		  center: {lat:15.1787608, lng:76.6641855},
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
        style: google.maps.NavigationControlStyle.ZOOM_PAN
      },
    mapTypeId:mapView
  };

   map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    // Create the shared infowindow with two DIV placeholders
 
    
    var infomyOptions = {
            content: content
            
           ,disableAutoPan: false
           ,maxWidth: 0
           ,pixelOffset: new google.maps.Size(-133, 0)
           ,zIndex: 20
           ,boxStyle: { 
             background: 'url("MapIcon/infobox/tipbox.gif") no-repeat',
             color:'#000000'
             ,opacity: 1
             ,width: "280px"
            }
           ,closeBoxMargin: "10px 2px 2px 2px"
           ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
           ,infoBoxClearance: new google.maps.Size(1,1)
           ,isHidden: false
           ,pane: "floatPane"
           ,enableEventPropagation: false
   };
    var infowindow = new InfoBox(infomyOptions);

 // Handle the DOM ready event to create the StreetView panorama
    // as it can only be created once the DIV inside the infowindow is loaded in the DOM.
    var panorama = null;
    var pin = new google.maps.MVCObject();
	   
    draw = new google.maps.drawing.DrawingManager({
    	drawingControl: false,
        drawingControlOptions: {
          position: google.maps.ControlPosition.BOTTOM_LEFT,
          drawingModes: [
            //google.maps.drawing.OverlayType.CIRCLE,
            google.maps.drawing.OverlayType.RECTANGLE,
            google.maps.drawing.OverlayType.POLYGON,
            //google.maps.drawing.OverlayType.POLYLINE
          ]
        },
        rectangleOptions: {
            fillColor: '#00806A',
            fillOpacity: .4,
            strokeWeight: 0,
            //strokeColor: '#999',
            clickable: true,
            editable: false,
            zIndex: 1
          },
          circleOptions:{
              strokeWeight: 0,
              fillOpacity: 0.45,
              fillColor: '#990000',
              editable: false
            },
            polygonOptions: {
                fillColor: '#FF0000',
                fillOpacity: .4,
                strokeWeight: 0,
                //strokeColor: '#999',
                clickable: true,
                editable: false,
                zIndex: 1
              }
        });

    google.maps.event.addListener(map,'maptypeid_changed', function() { 
        switch(map.getMapTypeId()){
	        case "hybrid": mapView=document.getElementById("mapView").value='H';break;
		  	case "roadmap": mapView=document.getElementById("mapView").value='M';break;
		  	case "satellite": mapView=document.getElementById("mapView").value='S';break;
		  	default : mapView=document.getElementById("mapView").value='M';break;
        }
    	 
    });
    listMarkers(0,0);
    
    var longitudeArr = new Array();
	var latitudeArr = new Array();
	var longitudebmArr = new Array('76.3761425','76.3762114','76.3774204','76.3791213','76.377983','76.384764');
	var latitudebmArr = new Array('15.1752909','15.1755593','15.1719339','15.1717633','15.170808','15.171181');
	 
 	  var response = window.parent.httpResponse;
 	  if(response.length){
 	  response.forEach( function(data, index) { 
 		  latitudeArr.push(data.latitude);
 		  longitudeArr.push(data.longitude);		  
 	  });
  
	    // Define the list of markers.
	    // This could be generated server-side with a script creating the array.
	   
   
     
	    //alert(bounds);
	    if(username=='bmm'){ 
			for ( var i = 0; i < longitudebmArr.length; i++) {    	
				   bounds.extend(new google.maps.LatLng(latitudebmArr[i],longitudebmArr[i]));
				 }     	
		}
		
		else{
	   for ( var i = 0; i < longitudeArr.length; i++) {
			 
			  bounds.extend(new google.maps.LatLng(latitudeArr[i],longitudeArr[i]));
			   } 
		}
	    //map.fitBounds(bounds);
	    //setGeofence();
	    if(window.parent.latestGeo == true){
			 setLatestGeofence();
		}
		if(parent.buttonvalue && username!='bmm'){      	
		      map.fitBounds(bounds);     
		     }else{  
		    	// map.fitBounds(bounds);  
		    	 //if(username!='bmm'){
		    	  map.fitBounds(allgeobounds);  
		         //map.fitBounds(locbounds);
		     //}
		     }   
 	  }
 	  else if(window.parent.latestGeo == true){ 		 
		 setLatestGeofence();		
     }

 	 setGeofence();
 	//setLines();
	    

	    for ( var i = 0; i < longitudeArr.length; i++) 
		{		   
	    	//call marker draw function get the latitude longitude and name from ext location store
	    	addGaugeMarker(latitudeArr[i],longitudeArr[i],odoArr[i]);
	    	//set map view/bounds to show all locations	    	    		
	    	locbounds.extend(new google.maps.LatLng(latitudeArr[i],longitudeArr[i]));   		
    	}  
		
		  
	   
  
 // map.fitBounds(allgeobounds);   
  //map.setZoom(12);
          //showmap.fitBounds(allgeobounds);      
           // adds a listener for completed overlays, most work done in here
           google.maps.event.addListener(draw, 'overlaycomplete', function(event) {
               draw.setDrawingMode(null); // put the cursor back to the hand
               if (event.type == google.maps.drawing.OverlayType.POLYLINE) {
               	  google.maps.event.addListener(event.overlay, 'click', function() {
                         this.setMap(null);                     
                         draw.setDrawingMode(google.maps.drawing.OverlayType.POLYLINE);                     
                       });
               }
               if (event.type == google.maps.drawing.OverlayType.RECTANGLE) {
                   // on click, unset the overlay, and switch the cursor back to rectangle
                   google.maps.event.addListener(event.overlay, 'click', function() {
                     this.setMap(null);             
                     draw.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);             
                   });         
                 }       
               if (event.type == google.maps.drawing.OverlayType.POLYGON) {
                   // on click, unset the overlay, and switch the cursor back to rectangle
                   google.maps.event.addListener(event.overlay, 'click', function() {
                     this.setMap(null);          
                     draw.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);           
                   });       
                 }
             
                       
         });        
           // end of initialize
           
           if(username=='bmm'){    	  
           	 map.fitBounds(bounds);  
            }
         draw.setMap(map);  
         google.maps.event.addListener(draw, 'rectanglecomplete', function(mapRectangle) {	 
        	 window.parent.showGeoWin(mapRectangle, 2);
              draw.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);  
            
         });  
         
         google.maps.event.addListener(draw, 'polylinecomplete', function(mapPolyline) {
        	 window.parent.showGeoWin(mapPolyline, 4);
        	 var latpoly="";
    	     var j = 0;
    	     for (var i = 0; i < mapPolyline.getPath().getArray().length; i++) {
    	        latpoly = latpoly+"("+ mapPolyline.getPath().getAt(i).lat().toFixed(7)+ ","+mapPolyline.getPath().getAt(i).lng().toFixed(7)+")"+":";
    	     }
             draw.setDrawingMode(google.maps.drawing.OverlayType.POLYLINE);             
         });  
                
         google.maps.event.addListener(draw, 'polygoncomplete', function(mapPolygon) {
             
        	 window.parent.showGeoWin(mapPolygon, 3);   		  
    	     var latpoly="";
    	     var j = 0;
    	     for (var i = 0; i < mapPolygon.getPath().getArray().length; i++) {
    	        latpoly = latpoly+"("+ mapPolygon.getPath().getAt(i).lat().toFixed(7)+ ","+mapPolygon.getPath().getAt(i).lng().toFixed(7)+")"+":";
    	     }
    	     draw.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

          }); 
    
       

    google.maps.event.addListener(map, 'zoom_changed', function() {
        
        zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function(event) {
        	window.parent.mapZoomer=map.getZoom();
        	window.parent.mapCenter=map.getCenter();
        	
        });
    });
 
    google.maps.event.addListener(map,'maptypeid_changed', function() { 
    	switch(map.getMapTypeId()){
        case "hybrid": mapView=document.getElementById("mapView").value='H';break;
	  	case "roadmap": mapView=document.getElementById("mapView").value='M';break;
	  	case "satellite": mapView=document.getElementById("mapView").value='S';break;
	  	default : mapView=document.getElementById("mapView").value='M';break;
    }
    });

    // Handle the DOM ready event to create the StreetView panorama
    // as it can only be created once the DIV inside the infowindow is loaded in the DOM.
    var panorama = null;
    var pin = new google.maps.MVCObject();
    // Set the infowindow content and display it on marker click.
    // Use a 'pin' MVCObject as the order of the domready and marker click events is not garanteed.
   

 //var homeControlDiv = document.createElement('div');
 //var homeControl = new HomeControl(homeControlDiv, map);
 //google.maps.event.addDomListener(homeControlDiv, 'load', drawVisualization);
  //homeControlDiv.index = 1;
 //map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(homeControlDiv);
//google.maps.event.addDomListener(homeControlDiv, 'load', drawVisualization);
 
     }

     
  window.unclutter = function() {
      var executed = false;
      var images = document.getElementsByTagName('img');
      for (var index = 0; index < images.length; index++) {
          var node = images[index];
          if (node.src && node.src.indexOf("mapfiles/poweredby.png") > 0) {
              node.style.display = 'none';
              executed = true;
          }
      }

      if (! executed) {
          setTimeout(window.unclutter, 250);
      }
  };
 window.onbeforeunload=function(){
	  
	parent.document.dataGridFrom.bounds.value=map.getCenter();
	  }
 
	  function init(){
		 // alert("_--");
		//  initialize();
		//  drawVisualization();
		 // showCircleGeoif();
		  showLocationLatest();		  
		  showLocationall();	  
		  showCircleGeoall();
	  }
	  google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body onload="init()" style="overflow:hidden;font-family: Arial;border: 0 none;">
<div id="map_canvas"></div>    
    

<form id="locForm" action="" method="get">
	
	
	   <input type="hidden" id="mapView" value="<?php echo $detail[0]->mapView?>">
	 

	 </form>
</body>
</html>
