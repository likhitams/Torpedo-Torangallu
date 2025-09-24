<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>

    <!-- Bootstrap -->
    <!-- <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet"> -->
   

    <link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo asset_url(); ?>css/token-input.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
	<link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
  <?php echo $updatelogin;?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

	ul.token-input-list-facebook{
		height: 35px !important;
		border-radius: 0px;
		width:135px !important;
		font-size: 12px;
	}
	
	ul.token-input-list-facebook li input{
		padding: 0px 8px;
		width:135px !important;
	}
	
	.search_header .input-group {
	    width: 179px;
	}
	
	.sro {
		margin-top: 0px!important;
	}
	
	.icon_settings_down {
		position: absolute;
		bottom: -30px;
		right: 4px;
		font-size: 28px;
		cursor:pointer;
		color:#005596;
	}
	
	.icon_settings_down:hover {
		color:#1065A6;
	}
	
		body{
			background:#fff;
		}
		
		.map_full {
			height: 100%;
			overflow: hidden;
			position: relative;
			width: 100%;
		}
		/*.map_full iframe {
			height: 71%;
			position: fixed;
			width: 59%;
		}*/

	.map_full iframe {
    height: 71%;
    position: fixed;
    width: 46%;
    top: 186px;
    right: 0px;
}
	
	#contextMenu {
		    padding: -1px;
		    border: 1px solid #ccc;
		}
		
		
		#contextMenu ul li {
		    font-size: 12px;
		    border-bottom: 1px solid #ccc;
		    padding: 7px 15px;
		    cursor: pointer;
		}
		
		#contextMenu ul {
		    padding: 0;
		    margin: -1px;
		}
		
		
	
    </style>
  </head>
  <body class="dark-sidenav" oncontextmenu="return false;">
   
   <button data-toggle="modal" data-target="#errorModal" style="display: none;" id="alertbox"></button>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
      <div class="modal-dialog" role="document" style="width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            <h4 class="modal-title" id="errorModalLabel">Alert !!</h4>
          </div>
          <div class="modal-body">
            <p id="error-msg"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="far fa-check-circle"></i> &nbsp;OK</button>
            
          </div>
        </div>
      </div>
    </div>
  
   
   <?php echo $header;?>	
    
	<div class="main_container">
    	<div class="search_header">
              
              <div class="top_list_box">
              	<input type="text" class="form-control" placeholder="Ladle Number" name="unitno" id="unitno"/>
              </div>
              
              <div class="top_list_box">
              	<div class="form-group">
                    <div class='input-group date date-picker1'>
                        <input type='text' class="form-control" title="Start Date & Time" placeholder="Start Date & Time" name="start_date" id="start_date" />
                        <span class="input-group-addon cal-icon">
                            <span class="fa-regular fa-calendar"></span>
                        </span>
                    </div>
                </div>
              </div>
              
              <div class="top_list_box">
              	<div class="form-group">
                    <div class='input-group date date-picker1'>
                        <input type='text' class="form-control" title="End Date & Time" placeholder="End Date & Time" name="to_date" id="to_date" />
                        <span class="input-group-addon cal-icon">
                            <span class="fa-regular fa-calendar"></span>
                        </span>
                    </div>
                </div>
              </div>
              
               
              
                <button type="button" class="btn btn-warning" onclick="getReplayDetails();">GET</button>
                <button type="button" class="btn btn-danger" onclick="resetDetails();"><i class="fa fa-repeat"></i> RESET</button>
              
              
        </div>
        
      
				
				
				
				
       
       <div class="full_body"> 
	       <div class="col-md-6 p0"> 
	       <div id="myGrid" style="width: 116%; height: 450px;" class="ag-blue"></div>
	    	
	      </div>
	      
	      <div class="col-md-6 p0">
        	<div class="map_full">
        		<iframe id="mapFrame" name="mapFrame" src="" style="overflow:hidden;width:42%; height:126%;"  frameborder="0" style="border:0" ></iframe>
        	</div>
          </div>
        
       </div>
    </div>







    
    <form name="dataGridFrom" id="dataGridFrom" action="datagrid" method="POST" validate="true">
    	
    	<input type="hidden" id="bounds" name="bounds" value="">
    	<input type="hidden" id="ureports" name="ureports"  value="" />
    	</form>
    
    <div id="contextMenu" style="z-index: 999;display: none;position: fixed;background-color: #fff;overflow: hidden;height: auto;">
    	<ul id="contextDropDown">
    		<li onclick='selectRow();'>Select Row</li><li onclick='resetRow();'>Reset</li>
    	</ul>
    </div>
    
    
     </body>
   <?php echo $jsfileone; ?>

	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	
	<script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>

	<?php echo $jsfile; ?>

	<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.tokeninput.js"></script>
	<script src="<?php echo asset_url() ?>js/bootstrap.js"></script>

   
      <script>
    
    var resetGeo = false, latestGeo = false, firstRow = 0, buttonvalue = false, showtrackHide = false, IsLocShowHide = false, IsShowHide = false;
    var routeLocHide = false, replyLocHide=false, replyGeoHide=false, replyshowTrac=false, replyLocAllHide=false;
    var circularGeoStore = new Array(), rectangularGeoStore = new Array(), locationStore = new Array(), polygonGeoStore = new Array();
    var circularGeoLatestStore = new Array(), rectangularGeoLatestStore = new Array(), polygonGeoLatestStore = new Array(), locationLatestStore = new Array();
    var pauseVar = true, mapCircleVar;
	function updateMap(val, track) {
		document.getElementById('mapFrame').contentWindow.refreshMarkers(val, track);
	}

	function showTrack() {
		document.getElementById('mapFrame').contentWindow.showLinePath();
	}

	function addGeofence(){
		$("#error-msg").html("Select geofence type from bottom right corner menu");
		$("#alertbox").click();
		document.getElementById('mapFrame').contentWindow.setDrawMode();
		IsShowHide = true;
	}

	function showGeofence(){
		replyGeoHide = true;
		// show and hide geofence
		//alert(IsShowHide);
		if (IsShowHide) {							
			document.getElementById('mapFrame').src = "<?php echo base_url();?>retrac/replaymap";
			IsShowHide = false;
		} else {
			document.getElementById('mapFrame').contentWindow.showCircleGeo();
		}
	}

	function routeLocations(){
		// show and hide location
		routeLocHide = true;
		if (IsLocShowHide) {
			// document.getElementById('mapFrame').contentWindow.initialize();
			document.getElementById('mapFrame').src = "<?php echo base_url();?>retrac/replaymap";
		} else {

			document.getElementById('mapFrame').contentWindow.showLocation1();

		}
	}

	function showDistance(){
		$( "#distanceDialog" ).dialog( "open" );	
		$("#distance_val").html(0.00);
		document.getElementById('mapFrame').contentWindow.callDistancePoly();
	}

	function showGauge(){
		var selectedRows = gridOptions.api.getSelectedRows();
		var selectedRowsString = '';
		var fuel = 0, speed = 0, next = 0, capacity = 0;
		reDrawGauge();
		$( "#dialog" ).dialog( "open" );	
	}

	function reDrawGauge(){
		var selectedRows = gridOptions.api.getSelectedRows();
		var selectedRowsString = '';
		var fuel = 0, speed = 0, next = 150, capacity = 0;
		google.charts.setOnLoadCallback(drawChart);
		google.charts.setOnLoadCallback(drawChart1);
		if(selectedRows.length){	
			var cnt = selectedRows.length-1;
			fuel = selectedRows[cnt].fuel;
			speed = selectedRows[cnt].speed;
			capacity = selectedRows[cnt].fuelCapacity;		
			
	    	  var expr = new RegExp("^[-]?[0-9]*[\.]?[0-9]*$");
			  var num = expr.test(fuel);
	         if(fuel<0){
		       	   fuel = 0;
		           speed = 0;
		           next = 150;
			  }
	         else if(fuel==0){
               fuel = 0;
               next = 150;
			  }
	         else if(num==false){
         	  	fuel = 0;
                next = 150;
	         }
	         else if(fuel>0)
			  {
				var next = Math.round(capacity);
			  }
		}
		drawChart(fuel,next);
		drawChart1(parseInt(speed));
	}


	function closeDistance(){
		//$("#distance_label").hide();
		document.getElementById('mapFrame').contentWindow.hideDistancePoly();
	}

	function showLocation(){
		// show and hide location  
		replyLocHide = true;
		if (IsLocShowHide) {
			document.getElementById('mapFrame').src = "<?php echo base_url();?>retrac/replaymap";
		} 
		else {
			document.getElementById('mapFrame').contentWindow.showLocation();
		}
	}

	function addLocation(){
		$("#error-msg").html("Click on map to create location");
		$("#alertbox").click();
		// set the cursor to create location
		document.getElementById('mapFrame').contentWindow.addClickListener();
		document.getElementById('mapFrame').contentWindow.map
				.setOptions({
					draggableCursor : 'crosshair'
				});
		IsLocShowHide = true;
	}

	function showAddLocation(lat, lon){		
		$("#getAddLocation").click();
		$(".vehicleClass").val("");
		$("#locLatitude").val(lat);
		$("#locLongitude").val(lon);
	}
	
	function showGeoWin(mapCircle, type){
		mapCircleVar=mapCircle;
		$("#getunit").click();
		$(".circle, .rect, .poly").hide();
		$(".vehicleClass").val("");
		//alert(type);
		$("#geoType").val(type);
		//alert($("#geoType").val());
		
		switch(type){
			case 1: $("#geoLatitude").val(mapCircle.getCenter().lat().toFixed(7));
					$("#geoLongitude").val(mapCircle.getCenter().lng().toFixed(7));
					$("#geoRadius").val(mapCircle.getRadius().toFixed(2));
					$(".circle").show();break;
			case 2: $("#geoLatitude").val(mapCircle.getBounds().getSouthWest().lat().toFixed(7));
					$("#geoLongitude").val(mapCircle.getBounds().getSouthWest().lng().toFixed(7));
					$("#geoLatitude2").val(mapCircle.getBounds().getNorthEast().lat().toFixed(7));
					$("#geoLongitude2").val(mapCircle.getBounds().getNorthEast().lng().toFixed(7));
					$(".rect").show();break;
			case 3: var latpoly="";
			   	     var j = 0;
				     for (var i = 0; i < mapCircle.getPath().getArray().length; i++) {
				        latpoly = latpoly+"("+ mapCircle.getPath().getAt(i).lat().toFixed(7)+ ","+mapCircle.getPath().getAt(i).lng().toFixed(7)+")"+":";
				     }
				     $("#geoPolyLatLong").val(latpoly);
				     $("#geoPolyLatLongdiv").html(latpoly);
				     $(".poly").show();break;
		}
	}

	function resetGeofence(){
		locationLatestStore = new Array(), circularGeoLatestStore = new Array(), rectangularGeoLatestStore = new Array(), polygonGeoLatestStore = new Array();
		$(".resetval").val("");
	}

	

	function submitGeofence(){
		if(v.form()){
			$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
			var str = $("#form-validate").serialize();
			var geoType = $("#geoType").val();
			//str = str+"&unitnumber=0";
			//alert(str);
			$.post("<?php echo base_url();?>lists/saveGeoDetails",str,function(data){
				//alert(data);
				if(parseInt(data) == 1){
					$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
					resetGeofence();
					$("#closeButton").click();
					$.ajax({
				           url:  '<?php echo base_url();?>lists/getLatestReplayGeofence?type='+geoType,
				           dataType: 'json',
				           success: function(data){
				        	   switch(geoType){
				        	   		case "1":circularGeoLatestStore = data;break;
				        	   		case "2":rectangularGeoLatestStore = data;break;
				        	   		case "3":polygonGeoLatestStore = data;break;
				        	   		default:break;
				        	   }
				        	   latestGeo = true;
				        	   document.getElementById('mapFrame').contentWindow.initialize();
				        	   latestGeo = false;
				           }
				       });	

					$.ajax({
				           url:  '<?php echo base_url();?>lists/getReplayGeofence?type='+geoType,
				           dataType: 'json',
				           success: function(data){		
				        	   switch(geoType){
				        	   		case "1":circularGeoStore = data;break;
				        	   		case "2":rectangularGeoStore = data;break;
				        	   		case "3":polygonGeoStore = data;break;
				        	   		default:break;
				        	   }				        	   
				           }
				       });
					setManageGeofence();			
				       	
				}
				else{
					$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
				}
			});
		}
	}

	function submitLocation(){
		//alert(v1.form());
		if(v1.form()){
			$("#locmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
			var str = $("#form-validateloc").serialize();
			
			$.post("<?php echo base_url();?>lists/saveLocDetails",str,function(data){
				//alert(data);
				if(parseInt(data) == 1){
					$("#locmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
					resetGeofence();
					$("#closeLocButton").click();
					$.ajax({
				           url:  '<?php echo base_url();?>lists/getLatestReplayLocation',
				           dataType: 'json',
				           success: function(data){
				        	   locationLatestStore = data;
				        	   latestGeo = true;
				        	   document.getElementById('mapFrame').contentWindow.initialize();
				        	   latestGeo = false;
				           }
				       });	

					setLocationDetails();		
				}
				else{
					$("#locmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
				}
			});
		}
	}

	function setLocationDetails(){
		$.ajax({
	           url:  '<?php echo base_url();?>lists/getReplayLocation',
	           dataType: 'json',
	           success: function(data){		           
	        	   locationStore = data;
	        	   setRowDataLoc(locationStore);
	           }
	       });
	}

	function submitmLocation(){
		//alert(v1.form());
		if(v2.form()){
			
			var str = $("#form-validatemloc").serialize();
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			var selectedRowsString = '';
			if(selectedRows.length){
				$("#mlocmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
				selectedRows.forEach( function(selectedRow, index) {
					selectedRowsString = selectedRow.locationNumber;
				});
				str = str+"&locid="+selectedRowsString;
				$.post("<?php echo base_url();?>lists/updateLocDetails",str,function(data){
					//alert(data);
					if(parseInt(data) == 1){
						$("#mlocmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
						setLocationDetails();							
					}
					else{
						$("#mlocmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
					}
				});
			}
			else{
				alert("Please select Location");
			}
		}
	}

	function deleteLocation(){
		var selectedRows = gridOptionsLoc.api.getSelectedRows();
		var selectedRowsString = '';
		if(selectedRows.length){
			$("#mlocmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
			selectedRows.forEach( function(selectedRow, index) {				
				selectedRowsString = selectedRow.locationNumber;
				$.post("<?php echo base_url();?>lists/deleteLocDetails",{latitude:selectedRow.latitude, longitude:selectedRow.longitude},function(data){
					//alert(data);
					if(parseInt(data) == 1){
						$("#mlocmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
						gridOptionsLoc.api.deselectAll();
						setLocationDetails();
						$(".vehicleClass").val("");
						$(".vehicleClass").html("");						
					}
					else{
						$("#mlocmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Location.</div>');
					}
				});
			});
		}
		else{
			alert("Please select Location");
		}
	}

	function deleteGeofence(){
		var selectedRows = gridOptionsGeo1.api.getSelectedRows();
		var selectedRowsString = '';
		if(selectedRows.length){
			var r = confirm('Do You want to delete "'+selectedRows[0].geofenceName+'" geofence\n and respective alerts(If configured)');
			if(r == true){
				$("#mgeomsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleting, please wait...</div>');
				switch(selectedRows[0].geofenceType){
					case "1": $.post("<?php echo base_url();?>lists/deleteCircleGeo",{latitude:selectedRows[0].latitude, longitude:selectedRows[0].longitude},function(data){
								//alert(data);
								if(parseInt(data) == 1){
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();						
								}
								else{
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
					case "2":$.post("<?php echo base_url();?>lists/deleteRectGeo",{latitude:selectedRows[0].latitude, longitude:selectedRows[0].longitude,latitude1:selectedRows[0].latitude1, longitude1:selectedRows[0].longitude1},function(data){
								//alert(data);
								if(parseInt(data) == 1){
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();						
								}
								else{
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
					case "3":$.post("<?php echo base_url();?>lists/deletePolyGeo",{geofenceNumber:selectedRows[0].geofenceNumber},function(data){
								//alert(data);
								if(parseInt(data) == 1){
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();						
								}
								else{
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
					default:break;
				}
			}
		}
		else{
			alert("Please select Geofence");
		}
	}

	function submitmGeofence(){
		var selectedRows = gridOptionsGeo1.api.getSelectedRows();
		var selectedRowsString = '';
		if(selectedRows.length == 0){
			$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Select a geofence</div>');
		}
		else{
			var geoUnitArr = new Array();
			var geoUnitGrid = gridOptionsGeo3.api.getSelectedNodes();
			geoUnitGrid.forEach( function(selectedRow, index) {
				//alert(selectedRow.id);
				geoUnitArr.push(selectedRow.id);
			});
			
	       	 /*for(var i=0;i<geoConfigUnitStore.getCount();i++){
	       		 geoConfigUnitArr.push(geoConfigUnitStore.getAt(i).get('unitnumber'))
	       	 }*/
	       	selectedRows.forEach( function(selectedRow, index) {
	       	
			$.post("<?php echo base_url();?>lists/updateManageGeo",{geoUnitArr:geoUnitArr.join(","), geoActualUnit:geoActualUnit.join(","), geofenceNumber: selectedRow.geofenceNumber},function(data){
				//alert(data);
				if(parseInt(data) == 1){
					$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
					resetmGeofence();						
				}
				else{
					$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in Updating Geofence.</div>');
				}
			});
	       	});
		}
	}


   function setinputbox(id,data){
   	$("#"+id).tokenInput('<?php echo base_url();?>reports/getLadles', {
   		
   		prePopulate: data,
           theme: "facebook",
           placeholder: 'Type Ladle No.',
           queryParam: "q",
           hintText: "Type atleast two letters",
           //preventDuplicates: true,
           minChars: 1,
           tokenLimit: 1,
           propertyToSearch: "name",
           onDelete: function (item) {

   			}
       });

   	 $("ul.token-input-list-facebook").css("width","100px");
   }

   

   $(document).ready(function() {   

	   $("#geoModal").on("hidden.bs.modal", function () {
		   resetGeofence();
		   $("#msg_box").html("");
		   if (typeof mapCircleVar !== 'undefined') {
			    // the variable is defined
	       	    document.getElementById('mapFrame').contentWindow.draw.setDrawingMode(null);
	       	    mapCircleVar.setVisible(false);
			}
		 }); 

	   $("#locModal").on("hidden.bs.modal", function () {
		   resetGeofence();
		   $("#locmsg_box").html("");
      	 	document.getElementById('mapFrame').contentWindow.map.setOptions({draggableCursor: 'pointer'});
		 }); 

	   $("#mlocModal").on("hidden.bs.modal", function () {
		   $(".vehicleClass").val("");
		   $(".vehicleClass").html("");
		   $("#mlocmsg_box").html("");
		   gridOptionsLoc.api.deselectAll();
		   setLocationDetails();
		   document.getElementById('mapFrame').src="<?php echo base_url()?>retrac/replaymap";
		 });

	   $("#mgeoModal").on("hidden.bs.modal", function () {		   
		   $("#mgeomsg_box").html("");
		   resetmGeofence();
		   document.getElementById('mapFrame').src="<?php echo base_url()?>retrac/replaymap";
		 });

	   $.ajax({
           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=1',
           dataType: 'json',
           success: function(data){	
                       
        	   circularGeoStore = data;
           }
       });	

	   $.ajax({
           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=2',
           dataType: 'json',
           success: function(data){		           
        	   rectangularGeoStore = data;
           }
       });	

	   $.ajax({
           url:  '<?php echo base_url();?>lists/getReplayGeofence?type=3',
           dataType: 'json',
           success: function(data){		           
        	   polygonGeoStore = data;
           }
       });	

	   setLocationDetails();	
   	  
   	<?php 
   		$replayUnit = $this->session->userdata("replayUnit");
   		$tripstart = $this->session->userdata("tripstart");
   		$tripend = $this->session->userdata("tripend");
   		if($replayUnit){?>			 
	       // Get all the products
	       
	       $.ajax({
	           url:  '<?php echo base_url();?>reports/getLadles?q=<?php echo $replayUnit;?>',
	           dataType: 'json',
	           success: function(data){		           
	           	setinputbox('unitno',data); 
	           	<?php 
	        	    	if($tripstart && $tripend && $replayUnit){?>
	        	    	getReplayDetails();
	        	    <?php }
	        	    ?>
	           }
	       });
		<?php }
		else{
		?>  	
		setinputbox('unitno',''); 
		<?php }?> 
		
   });
		
</script>

	<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">


    
    <script type="text/javascript">

		var httpResponse = new Array(), routeLocation = new Array();
		
		var columnDefsLoc = [
		                  		{headerName: "Location", field: "locationName", width: 440, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}}
		              		];
		
		var gridOptionsLoc = {
		        debug: true,
		        enableServerSideSorting: true,
		        enableServerSideFilter: true,
		        enableColResize: true,
		        rowSelection: 'single',
		        onRowSelected: onSelectionChanged,
		        rowDeselection: true,
		        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
		        columnDefs: columnDefsLoc,
		        rowModelType: 'virtual',
		        paginationPageSize: 100,
		        paginationOverflowSize: 2,            
		        maxConcurrentDatasourceRequests: 2,
		        paginationInitialRowCount: 0,
		        maxPagesInCache: 2,
		        getRowNodeId: function(item) {
		            return item.id;
		        }
		    };

		var columnDefsGeo1 = [
		                  		{headerName: "Geofence", field: "geofenceName", width: 450, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}}
		              		];
		
		var gridOptionsGeo1 = {
		        debug: true,
		        enableServerSideSorting: true,
		        enableServerSideFilter: true,
		        enableColResize: true,
		        rowSelection: 'single',
		       // onRowSelected: onSelectionChangedGeo1,
		        rowDeselection: true,
		        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
		        columnDefs: columnDefsGeo1,
		        rowModelType: 'virtual',
		        paginationPageSize: 100,
		        paginationOverflowSize: 2,            
		        maxConcurrentDatasourceRequests: 2,
		        paginationInitialRowCount: 0,
		        maxPagesInCache: 2,
		        getRowNodeId: function(item) {
		            return item.id;
		        }
		    };

		var columnDefsGeo2 = [
								{headerName: "id", field: "id", width: 0,hide:true, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}},
		                  		{headerName: "Groups", field: "groupname", width: 450, checkboxSelection: true, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}}
		                  				                  			                  		
		              		];
		
		var gridOptionsGeo2 = {
		        debug: true,
		        rowData: null,
		        rowSelection: 'multiple',
		        enableFilter: false,
		        onRowSelected: onSelectionChangedGeo2,
		       // headerCellRenderer: headerCellRendererFunc,
		        rowDeselection: true,
		        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
		        columnDefs: columnDefsGeo2,
		        getRowNodeId: function(item) {
		            return item.id;
		        }
		    		        
		    };

		function headerCellRendererFunc(params) {
    		//console.log("dddd");
	        if (params.colDef.field != "groupname")
	            return params.colDef.headerName;
	        ///console.log(params.colDef.headerName);
	        var cb = document.createElement('input');
	        cb.setAttribute('type', 'checkbox');
	        cb.setAttribute('id', 'myCheckboxgroup')

	        var eHeader = document.createElement('label');
	        var eTitle = document.createTextNode(params.colDef.headerName);
	        eHeader.appendChild(cb);
	        eHeader.appendChild(eTitle);

	        cb.addEventListener('change', function (e) {
	      
	          if (this.checked) {
	              //console.log(gridOptions1.api.getModel());
	              gridOptionsGeo2.api.getModel().forEachNode(function(node){
	            	  node.setSelected(true);
	              });
	          } else {
	        	  gridOptionsGeo2.api.getModel().forEachNode(function(node){
	            	  node.setSelected(false);
	              });
	          }
	        });
	        
	        return eHeader;
	    }

		var columnDefsGeo3 = [
								{headerName: "id", field: "id", width: 0,hide:true, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}},
		                  		{headerName: "Units", field: "unitname", width: 450, checkboxSelection: true, filter: 'text', filterParams: {apply: true,newRowsAction: 'keep'}}
		                  				                  			                  		
		              		];
		
		var gridOptionsGeo3 = {
		        debug: true,
		        rowData: null,
		        rowSelection: 'multiple',
		        enableFilter: false,
		        headerCellRenderer: headerCellRendererFunc1,
		        onRowSelected: onSelectionChangedGeo3,
		        rowDeselection: true,
		        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
		        columnDefs: columnDefsGeo3,
		        getRowNodeId: function(item) {
		            return item.id;
		        }
		    		        
		    };

	    function onSelectionChangedGeo3(event){
	    	var selectedRows = gridOptionsGeo3.api.getSelectedRows().length;
			var cnt = gridOptionsGeo3.api.getModel().rowsToDisplay.length;
			
			$("#myCheckboxunit").prop("checked", false);
			if(selectedRows == cnt){
				$("#myCheckboxunit").prop("checked", true);
			}
	    }

		function headerCellRendererFunc1(params) {
    		//console.log("dddd");
	        if (params.colDef.field != "unitname")
	            return params.colDef.headerName;
	        ///console.log(params.colDef.headerName);
	        var cb = document.createElement('input');
	        cb.setAttribute('type', 'checkbox');
	        cb.setAttribute('id', 'myCheckboxunit')

	        var eHeader = document.createElement('label');
	        var eTitle = document.createTextNode(params.colDef.headerName);
	        eHeader.appendChild(cb);
	        eHeader.appendChild(eTitle);

	        cb.addEventListener('change', function (e) {
	      
	          if (this.checked) {
	              //console.log(gridOptions1.api.getModel());
	              gridOptionsGeo3.api.getModel().forEachNode(function(node){
	            	  node.setSelected(true);
	              });
	          } else {
	        	  gridOptionsGeo3.api.getModel().forEachNode(function(node){
	            	  node.setSelected(false);
	              });
	          }
	        });
	        
	        return eHeader;
	    }
	    
		var columnDefs = [
						  {headerName: "Car No.", field: "unitname", width: 90, suppressFilter:true, hide:true},
		                  {headerName: "Report Time", field: "reportTime", width: 100, suppressFilter:true},
		                  {headerName: "Speed", field: "speed", width: 60, suppressFilter:true},
		                  {headerName: "Distance", field: "distance", width: 70, suppressFilter:true},
		                  {headerName: "Status", field: "STATUS", width: 130, suppressFilter:true,cellRenderer: checkStatus},
		                //  {headerName: "Load Status", field: "loadstatus", width: 100, suppressFilter:true,cellRenderer: checkLoadStatus},
		                  {headerName: "Location", field: "location", width: 400, suppressFilter:true}
		              ];

		function checkStatus(params){
			//console.log(params);
			var val = "";	
			if (params.data === undefined || params.data === null) {	
				return false;
			}
			else{		
			//return arr.indexOf(parseInt(data[params.rowIndex].statusColor)) > -1;
			//return arr.indexOf(parseInt(params.data.statusColor)) > -1;
				switch(params.data.statusColor){
						case "2":  reval = '<span class="moving"><span class="dot"></span>'+params.value+'</span>';break;
						case "15":  reval = '<span class="moving"><span class="dot"></span>'+params.value+'</span>';break;
						case "17":  reval = '<span class="idel"><span class="dot"></span>'+params.value+'</span>';break;
						default:  reval = '<span class="idel"><span class="dot"></span>'+params.value+'</span>';break;
					}
					return reval;
			}
		}

		function checkLoadStatus(params){
			if (params.data === undefined || params.data === null) {	
				return false;
			}
			else{
				switch(params.value){
					case "201":  reval = '<span class="load"><span class="dot"></span>Load</span>';break;
					case "202":  reval = '<span class="load"><span class="dot"></span>Load</span>';break;
					default:  reval = '<span class="empty"><span class="dot"></span>Empty</span>';break;
				}
				return reval;
				/*var tempCurrentOdo = params.value;
				// console.log("ddf="+params.rowIndex);
				var tempNextService = params.data.nextservice;
				return calculateOdo(tempCurrentOdo, tempNextService);*/
			}
		}
		
		var gridOptions = {
		        debug: true,
		        enableServerSideSorting: false,
		        enableServerSideFilter: true,
		        enableColResize: true,
		        rowSelection: 'multiple',
		        rowDeselection: true,
		        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
		        columnDefs: columnDefs,
		        rowModelType: 'infinite',
		        paginationPageSize: 100,
		        cacheOverflowSize: 2,            
		        maxConcurrentDatasourceRequests: 2,
		        paginationInitialRowCount: 0,
		        maxBlocksInCache: 2,
		        getRowNodeId: function(item) {
		            return item.id;
		        }
		    };

		var httpResultGeoGroup = [];
		document.addEventListener('DOMContentLoaded', function() {
		    var gridDiv = document.querySelector('#myGrid');
		    new agGrid.Grid(gridDiv, gridOptions);
		    document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
		    
		    var gridDivloc = document.querySelector('#locGrid');
		    new agGrid.Grid(gridDivloc, gridOptionsLoc);
		    
		    var gridDivgeo1 = document.querySelector('#geo1Grid');
		    new agGrid.Grid(gridDivgeo1, gridOptionsGeo1);
		    
		    gridDivgeo1 = document.querySelector('#geo2Grid');
		    new agGrid.Grid(gridDivgeo1, gridOptionsGeo2);
		    setManageGeofence();

		    gridDivgeo1 = document.querySelector('#geo3Grid');
		    new agGrid.Grid(gridDivgeo1, gridOptionsGeo3); 
		    gridOptionsGeo3.api.setRowData([]);  
		    gridOptionsGeo3.api.hideOverlay(); 
		});

		
		var geoActualUnit = new Array(), groupselect = new Array();

		function setManageGeofence(){
			$.ajax({
		           url:  '<?php echo base_url();?>lists/getAllGeoData',
		           dataType: 'json',
		           success: function(data){	
		        	   setRowDataGeo1(data);
		           }
		       });
			var httpRequest = new XMLHttpRequest();
		    httpRequest.open('GET', '<?php echo base_url();?>lists/getManageGeoGroup');
		    httpRequest.send();
		    httpRequest.onreadystatechange = function() {
		        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
		        	httpResultGeoGroup = JSON.parse(httpRequest.responseText);
		            gridOptionsGeo2.api.setRowData(httpResultGeoGroup);
		        }
		    };
		}
		
		function onSelectionChangedGeo1(event){
			//console.log(event.node.id);
			//var node = gridOptionsGeo1.api.getModel().getRow(event.node.id);
			//console.log(node);
			   //node.setSelected(true);
			var arr = new Array("", "Circle", "Rectangle", "Polygon");
			var selectedRows = gridOptionsGeo1.api.getSelectedRows();
			clearGridFilter2("groupname");
			clearGridFilter3("unitname");
			//gridOptionsGeo3.api.clearFocusedCell();
			gridOptionsGeo3.api.setRowData([]);
			gridOptionsGeo3.api.showLoadingOverlay();
			var selectedRowsString = '';
			selectedRows.forEach( function(selectedRow, index) {
				//console.log(selectedRow.id);
				var config_geo = new Array();
				$("#geoFormType").html(arr[selectedRow.geofenceType]);
				$("#geoFormName").html(selectedRow.geofenceName);
				$.ajax({
			           url:  '<?php echo base_url();?>lists/getConfigGeo?type='+selectedRow.geofenceNumber,
			           dataType: 'json',
			           success: function(data){		
			        	   config_geo = data;
			        	   var grpselect = new Array(); groupselect = new Array(); geoActualUnit = new Array();
			        	   config_geo.forEach( function(data, index) {
			        		   geoActualUnit.push(data.unitnumber);
			        		   grpselect.push(data.groupnumber);
			        		   groupselect.push(data.groupnumber);
							   		        		   
			        	   });   
							if(groupselect.length > 0){
								$.map(httpResultGeoGroup, function(val, index) {
									   
								    if(groupselect.indexOf(val.id) > -1){
								    	var node = gridOptionsGeo2.api.getModel().getRow(index);
							   			node.setSelected(true);
								    }
								});	
								
				        	   $.ajax({
						           url:  '<?php echo base_url();?>lists/getGroupUnits?groups='+groupselect.join(","),
						           dataType: 'json',
						           success: function(data1){	
						        	   httpUnitsResponse = data1;	
						        	   //console.log(httpUnitsResponse);
						        	   gridOptionsGeo3.api.setRowData(data1);
									   $.map(httpUnitsResponse, function(val, index) {
										    if(geoActualUnit.indexOf(val.id) > -1 ){
										    	var node = gridOptionsGeo3.api.getModel().getRow(index);
									   			node.setSelected(true);
										    }
										});	
						           }
						       });	 
							}  
							else{
								gridOptionsGeo3.api.setRowData([]);
							}
			           }
			       });

			});
			
			
		}

		var httpUnitsResponse = new Array();
		function onSelectionChangedGeo2(event){
			
			var selectedRows = gridOptionsGeo2.api.getSelectedRows();			
		
			clearGridFilter3("unitname");
			gridOptionsGeo3.api.setRowData([]);
			gridOptionsGeo3.api.showLoadingOverlay();
			var grpselect = [];
			selectedRows.forEach( function(selectedRow, index) {
				grpselect.push(selectedRow.id);
				
			});
			
			if(grpselect.length > 0 && resetGeo == false){
				//console.log("selected");
				//console.log(grpselect);
	        	   $.ajax({
			           url:  '<?php echo base_url();?>lists/getGroupUnits?groups='+grpselect.join(),
			           dataType: 'json',
			           success: function(data){	
			        	   httpUnitsResponse = data;	
			        	   gridOptionsGeo3.api.setRowData(data);
			        	   $.map(httpUnitsResponse, function(val, index) {
								   //console.log(val.id +"-"+ val.groupnumber);
								    if(geoActualUnit.indexOf(val.id) > -1 ){
								    	//console.log(val.id);
										//console.log(data.groupnumber);
								    	var node = gridOptionsGeo3.api.getModel().getRow(index);
							   			node.setSelected(true);
								    	//console.log(gridOptionsGeo2.);
								    }
								    else if(groupselect.indexOf(val.groupnumber) == -1 && grpselect.indexOf(val.groupnumber) > -1 ){
									    //console.log(grpselect.indexOf(val.id));
								    	var node = gridOptionsGeo3.api.getModel().getRow(index);
							   			node.setSelected(true);
								    }
								});
			           }
			       });	 
			}
			else{
				gridOptionsGeo3.api.setRowData([]);
			}
			
		}

		function setRowDataGeo1(allOfTheData) {
        	// give each row an id
        	//console.log("data is here");
        	//console.log(allOfTheData);
        	var distance = ignCount = 0, movingCount = 0, slowCount = 0, overCount = 0, geoCount = 0, harshCount = 0, suddenCount = 0, c = 0;
	    	var Event = null, Idle_Start_Time = null, Idle_Start_TimeUnix = null, Location = null, Idle_time_unix = null, idle = null, idletime = null;
			var cnt = allOfTheData.length;
        	
        	    allOfTheData.forEach( function(data, index) {
        	        data.id = (index + 1);

        	        var status = data.STATUS.replace(" ","").toLowerCase();
	    	    	//console.log(cnt-2+"-"+index-1);
	    	    	
	    	    	//distance += parseFloat(data.distance);
                    if (status.indexOf("ign") >= 0){
                    	ignCount++;
                    }
                    else if (status.indexOf("moving") >= 0){
                    	movingCount++;
                    }
                    else if (status.indexOf("slow/idle") >= 0){
                    	slowCount++;
                    }
                    else if (status.indexOf("overspeed") >= 0){
                    	overCount++;
                    }
                    else if (status.indexOf("geoentry") >= 0){
                    	geoCount++;
                    }
                    else if (status.indexOf("harshhccel") >= 0){
                    	harshCount++;
                    }
                    else if (status.indexOf("suddenbrake") >= 0){
                    	suddenCount++;
                    }
                    if(cnt != index){
                    	if(data.statusid == "18")
                        {
                        	Idle_time_unix = data.reporttimeunix;
                        		 
                        		 if(Idle_Start_TimeUnix != null)
                        		 {
                        			 allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                        		 }
                        		 Idle_Start_TimeUnix = data.reporttimeunix;
                        }
                    	else if(data.statusid == "1" || data.statusid == "9" || data.statusid == "14" || data.statusid == "23")
                	   {
                	        Idle_time_unix = data.reporttimeunix;
                	        if(Idle_Start_TimeUnix!=null)
                	        {
                	        	allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                	        }
                	        Idle_Start_TimeUnix = null;
                	   }
                       else if(data.statusid == "19" || data.statusid == "0" || data.statusid == "14" || 
                    		   data.statusid == "2" || data.statusid == "3" || data.statusid == "4")
                       {
                           Idle_time_unix = data.reporttimeunix;
                           if(Idle_Start_TimeUnix!=null)
                           {
                        	   allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                           }
                           Idle_Start_TimeUnix = null;   
                       }

                    	if(data.statusid == "0" || data.statusid == "9" || data.statusid == "14")
                	       {
                	        	Idle_Start_TimeUnix =  data.reporttimeunix;
                	       }
                    }
        	        
        	    });

        	    httpResponse = allOfTheData;
        	    routeLocation = httpResponse;	
    	    	    $("#ignEvents").html(ignCount);
    	    	    $("#movingEvents").html(movingCount);
    	    	    $("#slowEvents").html(slowCount);
    	    	    $("#speedEvents").html(overCount);
    	    	    $("#geoEvents").html(geoCount);
    	    	    $("#harshEvents").html(harshCount);
    	    	    $("#suddenEvents").html(suddenCount);
    	    	    $("#allEvents").html(allOfTheData.length);
          	   
        	    var dataSource = {
        	        rowCount: null, // behave as infinite scroll
        	        getRows: function (params) {
        	            console.log('asking for ' + params.startRow + ' to ' + params.endRow);
        	            onBtShowLoading();
        	            // At this point in your code, you would call the server, using $http if in AngularJS.
        	            // To make the demo look real, wait for 500ms before returning
        	            setTimeout(function () {
        	                // take a slice of the total rows
        	                var dataAfterSortingAndFiltering = sortAndFilterGeo1(allOfTheData, params.sortModel, params.filterModel);
        	                var rowsThisPage = dataAfterSortingAndFiltering.slice(params.startRow, params.endRow);
        	                // if on or after the last page, work out the last row.
        	                var lastRow = -1;
        	                if (dataAfterSortingAndFiltering.length <= params.endRow) {
        	                    lastRow = dataAfterSortingAndFiltering.length;
        	                }
        	                // call the success callback
        	                params.successCallback(rowsThisPage, lastRow);
        	                //applyOdoClass();
        	                onBtHide();
        	            }, 50);
        	            onBtHide();
        	        }
        	    };

        	    gridOptionsGeo1.api.setDatasource(dataSource);
          }

		function sortAndFilterGeo1(allOfTheData, sortModel, filterModel) {
            return sortDataGeo1(sortModel, filterDataGeo1(filterModel, allOfTheData))
        }

        function sortDataGeo1(sortModel, data) {
        	var sortPresent = sortModel && sortModel.length > 0;
            if (!sortPresent) {
                return data;
            }

            // do an in memory sort of the data, across all the fields
            var resultOfSort = data.slice();
            resultOfSort.sort(function(a,b) {
                for (var k = 0; k<sortModel.length; k++) {

                    var sortColModel = sortModel[k];
                    var valueA = a[sortColModel.colId];
                    var valueB = b[sortColModel.colId];

                    // this filter didn't find a difference, move onto the next one
                    if (valueA==valueB) {
                        continue;
                    }

                    var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
                    if (valueA > valueB) {
                        return sortDirection;
                    } else {
                        return sortDirection * -1;
                    }
                }
                // no filters found a difference
                return 0;
            });

            return resultOfSort;
        }

		function filterDataGeo1(filterModel, data) {
			//console.log(filterModel.locationName);
            var filterPresent = filterModel && Object.keys(filterModel).length > 0;
            if (!filterPresent) {
                return data;
            }
            var resultOfFilter = [];
            for (var i = 0; i<data.length; i++) {
                var item = data[i];
				 
				  if (filterPresent && filterModel.geofenceName) {
              	  var geoname = item.geofenceName;
                    var allowedLName = filterModel.geofenceName.filter;
                    var flagLName = checkStrLoop(filterModel.geofenceName.type, geoname.toLowerCase(), allowedLName.toLowerCase());
                   /// console.log(flagLName);
					if(flagLName == 1){
						continue;
					}
                }
				
                resultOfFilter.push(item);
            }
           
            return resultOfFilter;
        }
		
		function manageLocation(){
			//onBtShowLoading();
			gridOptionsLoc.api.deselectAll();
			$("#getlocpop").click();
		}

		function manageGeofence(){
			gridOptionsGeo1.api.deselectAll();
			$("#getgeopop").click();
		}

		function onSelectionChanged(){
			//console.log("ggg");
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			var selectedRowsString = '';
			selectedRows.forEach( function(selectedRow, index) {
				$("#mlocName").val(selectedRow.locationName);
				$("#mlocDes").val(selectedRow.description);
				$("#mlocLatitude").val(selectedRow.latitude);
				$("#mlocLongitude").val(selectedRow.longitude);
				$("#mlocRadius").val(selectedRow.radius);
				$("#mlocRefRadius").val(selectedRow.radiusRefer);
			});
		}

		function resetmLocation(){
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			if(selectedRows.length){
				onSelectionChanged();
			}
			else{
				alert("Please select the Location");
			}
		}

		function resetmGeofence(){		
			resetGeo = true;
			
			clearGridFilter2("groupname");
			clearGridFilter1("geofenceName");
			clearGridFilter3("unitname");	
			geoActualUnit = new Array(), groupselect = new Array();
			
			gridOptionsGeo3.api.setRowData([]);
			$("#geoFormType, #geoFormName").html("");
			resetGeo = false;
		}

		function clearGridFilter1(param){
			gridOptionsGeo1.api.deselectAll();
			var ageFilterComponent = gridOptionsGeo1.api.getFilterInstance(param);
			ageFilterComponent.setType('contains');
			ageFilterComponent.setFilter("");
			gridOptionsGeo1.api.onFilterChanged();
		}

		function clearGridFilter2(param){
			gridOptionsGeo2.api.deselectAll();
			var ageFilterComponent = gridOptionsGeo2.api.getFilterInstance(param);
			ageFilterComponent.setType('contains');
			ageFilterComponent.setFilter("");
			gridOptionsGeo2.api.onFilterChanged();
		}

		function clearGridFilter3(param){
			gridOptionsGeo3.api.deselectAll();
			var ageFilterComponent = gridOptionsGeo3.api.getFilterInstance(param);
			ageFilterComponent.setType('contains');
			ageFilterComponent.setFilter("");
			gridOptionsGeo3.api.onFilterChanged();
		}

		function setRowDataLoc(allOfTheData) {
        	// give each row an id
        	//console.log("data is here");
        	//console.log(allOfTheData);
        	    allOfTheData.forEach( function(data, index) {
        	        data.id = (index + 1);
        	    });
        	   
        	    var dataSource = {
        	        rowCount: null, // behave as infinite scroll
        	        getRows: function (params) {
        	            console.log('asking for ' + params.startRow + ' to ' + params.endRow);
        	            onBtShowLoading();
        	            // At this point in your code, you would call the server, using $http if in AngularJS.
        	            // To make the demo look real, wait for 500ms before returning
        	            setTimeout(function () {
        	                // take a slice of the total rows
        	                var dataAfterSortingAndFiltering = sortAndFilterLoc(allOfTheData, params.sortModel, params.filterModel);
        	                var rowsThisPage = dataAfterSortingAndFiltering.slice(params.startRow, params.endRow);
        	                // if on or after the last page, work out the last row.
        	                var lastRow = -1;
        	                if (dataAfterSortingAndFiltering.length <= params.endRow) {
        	                    lastRow = dataAfterSortingAndFiltering.length;
        	                }
        	                // call the success callback
        	                params.successCallback(rowsThisPage, lastRow);
        	                //applyOdoClass();
        	                onBtHide();
        	            }, 50);
        	            onBtHide();
        	        }
        	    };

        	    gridOptionsLoc.api.setDatasource(dataSource);
          }

		function sortAndFilterLoc(allOfTheData, sortModel, filterModel) {
            return sortDataLoc(sortModel, filterDataLoc(filterModel, allOfTheData))
        }

        function sortDataLoc(sortModel, data) {
        	var sortPresent = sortModel && sortModel.length > 0;
            if (!sortPresent) {
                return data;
            }

            // do an in memory sort of the data, across all the fields
            var resultOfSort = data.slice();
            resultOfSort.sort(function(a,b) {
                for (var k = 0; k<sortModel.length; k++) {

                    var sortColModel = sortModel[k];
                    var valueA = a[sortColModel.colId];
                    var valueB = b[sortColModel.colId];

                    // this filter didn't find a difference, move onto the next one
                    if (valueA==valueB) {
                        continue;
                    }

                    var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
                    if (valueA > valueB) {
                        return sortDirection;
                    } else {
                        return sortDirection * -1;
                    }
                }
                // no filters found a difference
                return 0;
            });

            return resultOfSort;
        }

		function filterDataLoc(filterModel, data) {
			//console.log(filterModel.locationName);
            var filterPresent = filterModel && Object.keys(filterModel).length > 0;
            if (!filterPresent) {
                return data;
            }
            var resultOfFilter = [];
            for (var i = 0; i<data.length; i++) {
                var item = data[i];
				 
				  if (filterPresent && filterModel.locationName) {
              	  var locationname = item.locationName;
                    var allowedLName = filterModel.locationName.filter;
                    var flagLName = checkStrLoop(filterModel.locationName.type, locationname.toLowerCase(), allowedLName.toLowerCase());
                   /// console.log(flagLName);
					if(flagLName == 1){
						continue;
					}
                }
				
                resultOfFilter.push(item);
            }
           
            return resultOfFilter;
        }

		function applyClass(params, arr){			
			var val = "";	
			if (params.data === undefined || params.data === null) {	
				return false;
			}
			else{	
				//console.log(params.data.statusColor);	
			return arr.indexOf(parseInt(params.data.statusColor)) > -1;
			}			
		}
		
		var tinterval = 1000 ;
		var myintr1;
		function playTrack(){
			if(httpResponse.length > 0){
				if(pauseVar == true){
					pauseVar = false;
					
					var replaySelection = gridOptions.api.getSelectedNodes();
					if (replaySelection.length == 0) {
						document.getElementById('mapFrame').contentWindow.hideAllNode();
					}
					//gridOptions.api.deselectAll();
					myintr1 = setInterval(replayMap, tinterval);
				}
				else{
					$("#error-msg").html("wait...");
					$("#alertbox").click();
				}
			}
			else{
				$("#error-msg").html("No records for the selection");
				$("#alertbox").click();
			}
		}

		function pauseMap() {
			pauseVar = true;
			$("#startButton, #playButton, #rewindButton, #endButton, #forwardButton").prop("disabled", false);
			//replayMapGrid.setDisabled(false);
			clearInterval(myintr1);
		}
		
		function replayMap() {
			//console.log("call");
			if(httpResponse.length > 0){
				var replaySelection = gridOptions.api.getSelectedNodes();
				 $("#startButton, #playButton, #rewindButton, #endButton, #forwardButton").prop("disabled", true);
				if(replaySelection.length == 0){
					node = gridOptions.api.getModel().getRow(0);
					node.setSelected(true);
					//console.log(node.data.id);
					document.getElementById('mapFrame').contentWindow.dispNextNode(0);
				}
				else if(replaySelection.length != httpResponse.length){				
					var nextRow = replaySelection.length;
					node = gridOptions.api.getModel().getRow(nextRow);
					node.setSelected(true);	
					//console.log(node.data.id);
					gridOptions.api.ensureIndexVisible(nextRow);	
					document.getElementById('mapFrame').contentWindow.hideinfoBox();		
					document.getElementById('mapFrame').contentWindow.dispNextNode(nextRow);
					if (replaySelection.length == httpResponse.length - 1) {
						pauseMap();
					}
				}
				else{
					pauseMap();
				}
			}
			else{
				$("#error-msg").html("No records for the selection");
				$("#alertbox").click();
				pauseMap();
			}
		}

		function startMap(){
			
			if(checkPause()){
				gridOptions.api.deselectAll();
				node = gridOptions.api.getModel().getRow(0);
				node.setSelected(true);	
				document.getElementById('mapFrame').contentWindow.hideAllNode();
				document.getElementById('mapFrame').contentWindow.dispNextNode(0);
				gridOptions.api.ensureIndexVisible(0);	
			}
			//playVar = false;
		}

		var tintervalend = 1000 ;
		var myintrend;var virtualcnt = 100, startcnt = 0;
		function lastrowMap(){
			virtualcnt = 100, startcnt = 0;
			if(checkPause()){
				//console.log("start");
				document.getElementById('mapFrame').contentWindow.dispAllNode(gridOptions.api.getSelectedNodes().length);
				var len = httpResponse.length;
				if(virtualcnt >= len){
					virtualcnt = len;
				}
				myintrend = setInterval(endMap, tintervalend);
			}
		}

		function endMap(){
			if(checkPause()){	
				var len = httpResponse.length;
				//gridOptions.api.selectAll();
				//console.log(startcnt+"=beforevirtual="+virtualcnt);
				for(var i=startcnt; i < virtualcnt; i++){
					//console.log(i);
					node = gridOptions.api.getModel().getRow(i);
					node.setSelected(true);	
					gridOptions.api.ensureIndexVisible(i);
				}
				//console.log(startcnt+"=virtual="+virtualcnt);
				if(virtualcnt >= len){
					clearInterval(myintrend);
				}
				startcnt = virtualcnt;
				virtualcnt += 100;
				if(virtualcnt >= len){
					virtualcnt = len;
				}
			}
			
		}

		function forwardMap(){
			if(checkPause()){
				var replaySelection = gridOptions.api.getSelectedNodes();
				
				if (replaySelection.length == 0) {
					document.getElementById('mapFrame').contentWindow.hideinfoBox();
					node = gridOptions.api.getModel().getRow(0);
					node.setSelected(true);	
					gridOptions.api.ensureIndexVisible(0);
					document.getElementById('mapFrame').contentWindow.dispNextNode(0);
				} else if (replaySelection.length != httpResponse.length) {
					document.getElementById('mapFrame').contentWindow.hideinfoBox();
					var nextRow = replaySelection.length;
					node = gridOptions.api.getModel().getRow(nextRow);
					node.setSelected(true);	
					document.getElementById('mapFrame').contentWindow.dispNextNode(nextRow);
					gridOptions.api.ensureIndexVisible(nextRow);
				}
			}
		}

		function rewindMap(){
			if(checkPause()){
				var replaySelection = gridOptions.api.getSelectedNodes();
				
				if (replaySelection.length != 1) {
					document.getElementById('mapFrame').contentWindow.hideinfoBox();
					var previousRow = replaySelection.length - 2;
					node = gridOptions.api.getModel().getRow(previousRow + 1);
					node.setSelected(false);	
					document.getElementById('mapFrame').contentWindow.dispPreNode(previousRow + 1);
					gridOptions.api.ensureIndexVisible(previousRow);
				}
			}
		}

		function checkPause(){
			//alert(pauseVar);true->paused; false->not paused
			if(pauseVar == true){
				return 1;
			}
			else{
				$("#error-msg").html("wait..");
				$("#alertbox").click();
				return 0;
			}			
		}

		function resetDetails(){
			var dataSource = {
	    	        rowCount: null, // behave as infinite scroll
	    	        getRows: function (params) {}
	    	    };
			gridOptions.api.setDatasource(dataSource);
			gridOptions.api.deselectAll();
			showtrackHide = false;
			pauseVar == true;
			    httpResponse = new Array();
			    routeLocation = new Array();
			    $("#statusButton, #start_date, #to_date, #showMarkers, #slowTime, #ignOffTime, #distanceTot, #elapsedTime").val("");
			    $("#ignEvents, #movingEvents, #slowEvents, #geoEvents, #speedEvents, #suddenEvents, #harshEvents").html("0");
			    $("#unitno").tokenInput("clear");
			    document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
			    
		}

		function refreshDetails(){
			$("#showMarkers").val("");
			gridOptions.api.deselectAll();
		    document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
		}

		function onBtShowLoading() {
			
		    gridOptions.api.showLoadingOverlay();
		}

	   function onBtHide() {
		    gridOptions.api.hideOverlay();
		}

	   var h;  
		$(document).ready(function(){  
			$( ".icon_settings_float" ).click(function() {
				  $( ".setting_float" ).toggleClass( "my_open" );
				$( ".setting_float" ).css("z-index","0");
				  if($( ".setting_float" ).hasClass("my_open")){
						$( ".setting_float" ).css("z-index","999");
				  }      				  
				});
				
				
				
			
				
$(document).ready(function(){
	h = $( document ).height()-120;
	setGridHeight();
    $(".icon_settings_down").click(function(){
        $(".search_bar").toggleClass("sro");
        if($(".search_bar").hasClass("sro")){//open
        	h = $( document ).height()-80;
        	$(".map_full iframe").css("height","82%");
        }
        else{
        	h = $( document ).height()-68;//close
        	$(".map_full iframe").css("height","90%");
        }
        setGridHeight();
    });
    $(".icon_settings_down").click();
});

				
				
				
				
			//h = $( document ).height()-175;

			$('#myGrid').on('click',".ag-row", function(evt){
				$("#contextMenu").hide();	
				var id = 0, distance = 0;
				var selectedRowsNodes = gridOptions.api.getSelectedNodes();
				var len = selectedRowsNodes.length;
				var temp = new Array(), tempSum = new Array();
				var distance = 0, predist = 0, sec = 0, sec1 = 0, sec2 = 0, sec3 = 0, total=0;
				
				selectedRowsNodes.forEach( function(selectedRow, index) {
						id = selectedRow.id;
						id = id - 1;
						
						for(var i=firstRow; i<= id; i++){
							//console.log(i);
							node = gridOptions.api.getModel().getRow(i);
							node.setSelected(true);
							//distance += parseFloat(node.data.distance);

							var seconds1 = 0,seconds2 = 0, c = 0; 
		                      dist = node.data.distance;
							  sidle = node.data.STATUS;
							  if(sidle.substring(0,4)=='Slow')
							  {
		                        var sub  =  sidle.substring(11,19);
								var pattern = /\d{2}:\d{2}:\d{2}/;
								if(sub.match(pattern)!=null)
								{
									//var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
									var a = sub.split(':'); 
									seconds1 = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
									sec = sec + seconds1;
								}
							 }

							  if(sidle.substring(0,7)=='Ign Off')
							  {
								var sub  =  sidle.substring(9,17);
								var pattern = /\d{2}:\d{2}:\d{2}/;
								if(sub.match(pattern)!=null)
								{
									seconds2 = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
									sec2 = sec2 + seconds2;
								}
							  }
							 // temp.push(dist);
							 // predist = dist;

							  if(i-1 < id-2){
					    	    	
					    	    	//var a = node[(i+1)].data.distance;
					    	    	var nodea = gridOptions.api.getModel().getRow(i+1);
					    	    	var a = nodea.data.distance;
					    	    	//console.log(cnt+"-"+index);
									var b = node.data.distance;
									if(parseFloat(a)>parseFloat(b))
									{
										c = parseFloat(a) - parseFloat(b);
										distance += c;
										//tempSum.push(c.toFixed(2));
									}
				    	    	}

							
						}

						
					});
				var date = new Date(1970,0,1);
				  date.setSeconds(sec);
				  var sidlesum = date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
					
				  var date2 = new Date(1970,0,1);
				  date2.setSeconds(sec2);
				  var ignoffsum = date2.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
				  $('#slowTime').val(sidlesum);
				  $('#ignOffTime').val(ignoffsum);
				  $("#distanceTot").val(distance.toFixed(2)); 
				if(id > 0){
					var date1 = $("#start_date").val();
					var date2 = $("#to_date").val();		
					if(httpResponse.length > 1){
						date1 = httpResponse[0].reportTime;
						date2 = httpResponse[id].reportTime;
					}					
					setElapsedTime(date1, date2);
				}
				document.getElementById('mapFrame').contentWindow.dispUptoRow(id);
				//reDrawGauge();
			 });

			$('#geo1Grid').on('click',".ag-row", function(evt){
				onSelectionChangedGeo1(evt);
			});

			/*$('#geo2Grid').on('click',".ag-row", function(evt){
				//alert();
				onSelectionChangedGeo2(evt);
			});*/


			$('body').on("mousedown",".ag-row",function(e){ 
				
			    if( e.button == 2 ) { 
			    
			      $('#contextMenu').css({position:"absolute", left:e.pageX,top:e.pageY}).slideDown();
			      e.stopImmediatePropagation(); 
			      
			      return false; 
			    } 
			    return true; 
			    
			  }); 

		});

		function selectRow(){
			gridOptions.api.deselectAll();
			var id = gridOptions.api.getFocusedCell();
			//console.log(id.rowIndex);
			var node = gridOptions.api.getModel().getRow(id.rowIndex);
			node.setSelected(true);
			firstRow = id.rowIndex;
			$("#contextMenu").hide();	
		}

		function resetRow(){
			gridOptions.api.deselectAll();
			firstRow = 0;
			$("#contextMenu").hide();	
		}
	
		function setGridHeight(){
 		//alert("height="+$( window ).height());
			//var h = $( document ).height()-510;
			$("#myGrid").css("height",h+"px");
		}

		function getStatus(Idle_time_unix, status, Idle_Start_TimeUnix){
	    	
		    var idle=(parseInt(Idle_time_unix)-parseInt(Idle_Start_TimeUnix));
	  	        		  
		   	var hours = parseInt(idle / 3600);
		   	var remainder = parseInt(idle % 3600);
		   	var minutes = parseInt(remainder / 60);
		   	var seconds = parseInt(remainder % 60);
		
		   	var disHour = hours < 10 ? "0"+hours : ""+hours;
		   	var disMinu = minutes < 10 ? "0"+minutes : ""+minutes;
		   	var disSec = seconds < 10 ? "0"+seconds : ""+seconds ;
		   	        		  
		   	var idletime =disHour+":"+disMinu+":"+disSec;
		   	status = status +" "+"("+idletime+")" ;
		   	// console.log(status);
	    	return status;
	    }

		var datatoExport = [];
		function setRowData(allOfTheData) {
	    	// give each row an id
	    	var distance = ignCount = 0, movingCount = 0, slowCount = 0, overCount = 0, geoCount = 0, harshCount = 0, suddenCount = 0, c = 0;
	    	var Event = null, Idle_Start_Time = null, Idle_Start_TimeUnix = null, Location = null, Idle_time_unix = null, idle = null, idletime = null;
			var cnt = allOfTheData.length;
    	    allOfTheData.forEach( function(data, index) {
    	    		data.id = (index + 1);
	    	    	var status = data.STATUS.replace(" ","").toLowerCase();
	    	    	//console.log(cnt-2+"-"+index-1);
	    	    	
	    	    	//distance += parseFloat(data.distance);
                    if (status.indexOf("ign") >= 0){
                    	ignCount++;
                    }
                    else if (status.indexOf("moving") >= 0){
                    	movingCount++;
                    }
                    else if (status.indexOf("idle") >= 0){
                    	slowCount++;
                    }
                    else if (status.indexOf("overspeed") >= 0){
                    	overCount++;
                    }
                    else if (status.indexOf("geoentry") >= 0){
                    	geoCount++;
                    }
                    else if (status.indexOf("harshhccel") >= 0){
                    	harshCount++;
                    }
                    else if (status.indexOf("suddenbrake") >= 0){
                    	suddenCount++;
                    }
                    if(cnt != index){
                    	if(data.statusid == "18")
                        {
                        	Idle_time_unix = data.reporttimeunix;
                        		 
                        		 if(Idle_Start_TimeUnix != null)
                        		 {
                        			 allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                        		 }
                        		 Idle_Start_TimeUnix = data.reporttimeunix;
                        }
                    	else if(data.statusid == "1" || data.statusid == "9" || data.statusid == "14" || data.statusid == "23")
                	   {
                	        Idle_time_unix = data.reporttimeunix;
                	        if(Idle_Start_TimeUnix!=null)
                	        {
                	        	allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                	        }
                	        Idle_Start_TimeUnix = null;
                	   }
                       else if(data.statusid == "19" || data.statusid == "0" || data.statusid == "14" || 
                    		   data.statusid == "2" || data.statusid == "3" || data.statusid == "4")
                       {
                           Idle_time_unix = data.reporttimeunix;
                           if(Idle_Start_TimeUnix!=null)
                           {
                        	   allOfTheData[index-1].STATUS = getStatus(Idle_time_unix, allOfTheData[index-1].STATUS, Idle_Start_TimeUnix);
                           }
                           Idle_Start_TimeUnix = null;   
                       }

                    	if(data.statusid == "0" || data.statusid == "9" || data.statusid == "14")
                	       {
                	        	Idle_Start_TimeUnix =  data.reporttimeunix;
                	       }
                    }
	    	    });
    	    httpResponse = allOfTheData;
    	    routeLocation = httpResponse;	
	    	    $("#ignEvents").html(ignCount);
	    	    $("#movingEvents").html(movingCount);
	    	    $("#slowEvents").html(slowCount);
	    	    $("#speedEvents").html(overCount);
	    	    $("#geoEvents").html(geoCount);
	    	    $("#harshEvents").html(harshCount);
	    	    $("#suddenEvents").html(suddenCount);
	    	    $("#allEvents").html(allOfTheData.length);
	    	   //console.log(allOfTheData.length);
	    	    var dataSource = {
	    	        rowCount: null, // behave as infinite scroll
	    	        getRows: function (params) {
	    	            console.log('asking for ' + params.startRow + ' to ' + params.endRow);
	    	            //alert();
	    	            
	    	            // At this point in your code, you would call the server, using $http if in AngularJS.
	    	            // To make the demo look real, wait for 500ms before returning
	    	            setTimeout(function () {
	    	            	onBtShowLoading();
	    	                // take a slice of the total rows
	    	                var dataAfterSortingAndFiltering = sortAndFilter(allOfTheData, params.sortModel, params.filterModel);
	    	                datatoExport = dataAfterSortingAndFiltering;
	    	                var rowsThisPage = dataAfterSortingAndFiltering.slice(params.startRow, params.endRow);
	    	                // if on or after the last page, work out the last row.
	    	                var lastRow = -1;
	    	                if (dataAfterSortingAndFiltering.length <= params.endRow) {
	    	                    lastRow = dataAfterSortingAndFiltering.length;
	    	                }
	    	                // call the success callback
	    	                params.successCallback(rowsThisPage, lastRow);
	    	                //applyOdoClass();
	    	                onBtHide();
	    	            }, 50);
	    	          //  onBtHide();
	    	        }
	    	    };

	    	    gridOptions.api.setDatasource(dataSource);
	    	    //setGridHeight();
	    	    //applyOdoClass();
	      }

		function sortAndFilter(allOfTheData, sortModel, filterModel) {
	          return sortData(sortModel, filterData(filterModel, allOfTheData))
	      }

	      function sortData(sortModel, data) {
	    	  return data;
	      }

	      function filterData(filterModel, data) {
	          
	          var resultOfFilter = [];
	          var dist, predist, c;
			  var temp = new Array(), tempSum = new Array();
			  var distance = 0, predist = 0, sec = 0, sec1 = 0, sec2 = 0, sec3 = 0, total=0;
			  
	          	var cnt = data.length;
		          for (var i = 0; i<data.length; i++) {
		              var item = data[i];
		              if($("#statusButton").length > 0 && $("#statusButton").val() != ""){ 
		            	  var status = item.STATUS.replace(" ","");
	                      var allowedStatus = $("#statusButton").val();
	                      var flagStatus = checkStrLoop("contains", status.toLowerCase(), allowedStatus.toLowerCase());   
	                      if(flagStatus == 1){    
		            	  	continue;
	                      }
		              }

		              dist = item.distance;
					  sidle = item.STATUS;
					  if(sidle.substring(0,4)=='Slow')
					  {
                        var sub  =  sidle.substring(11,19);
						var pattern = /\d{2}:\d{2}:\d{2}/;
						if(sub.match(pattern)!=null)
						{
							//var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
							var a = sub.split(':'); 
							var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
							sec = sec + seconds;
						}
					 }

					  if(sidle.substring(0,7)=='Ign Off')
					  {
						var sub  =  sidle.substring(9,17);
						var pattern = /\d{2}:\d{2}:\d{2}/;
						if(sub.match(pattern)!=null)
						{
							var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
							sec2 = sec2 + seconds;
						}
					  }
					  
					  if(i-1 < cnt-2){
			    	    	
			    	    	var a = data[i+1].distance;
			    	    	//console.log(cnt+"-"+index);
							var b = item.distance;
							if(parseFloat(a)>parseFloat(b))
							{
								var c = parseFloat(a) - parseFloat(b);
								distance += c;
								//tempSum.push(c.toFixed(2));
							}
		    	    	}
	                               
		              resultOfFilter.push(item);
		          }

		          var date = new Date(1970,0,1);
				  date.setSeconds(sec);
				  var sidlesum = date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
					
				  var date2 = new Date(1970,0,1);
				  date2.setSeconds(sec2);
				  var ignoffsum = date2.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
				  $('#slowTime').val(sidlesum);
				  $('#ignOffTime').val(ignoffsum);
				  $('#distanceTot').val(distance.toFixed(2));
	          return resultOfFilter;
	      }

	      function createWorksheet(){
				//	Calculate cell data types and extra class names which affect formatting
                var cellType = [], title = "Replay Route Details";
                var cellTypeClass = [];
                var cm = gridOptions.columnApi.getAllDisplayedColumns();
                var totalWidthInPixels = 0;
                var colXml = '';
                var headerXml = '';
                var cnt = cm.length;
                for (var i = 0; i < cnt; i++) {  
                    	
                        var w = cm[i].colDef.width;
                        totalWidthInPixels += w;
                        colXml += '<ss:Column ss:AutoFitWidth="1" ss:Width="' +w+ '" />';  
                        headerXml += '<ss:Cell ss:StyleID="headercell">' +
                            '<ss:Data ss:Type="String">' + cm[i].colDef.headerName + '</ss:Data>' +
                            '<ss:NamedCell ss:Name="Print_Titles" /></ss:Cell>'; 
                        
                        cellType.push("String");
                        cellTypeClass.push("");
                        
                }
                var visibleColumnCount = cellType.length;

                var result = {
                    height: 9000,
                    width: Math.floor(totalWidthInPixels * 30) + 50
                };

//              Generate worksheet header details.
                var t = '<ss:Worksheet ss:Name="' + title + '">' +
                    '<ss:Names>' +
                        '<ss:NamedRange ss:Name="Print_Titles" ss:RefersTo="=\'' + title + '\'!R1:R2" />' +
                    '</ss:Names>' +
                    '<ss:Table x:FullRows="1" x:FullColumns="1"' +
                        ' ss:ExpandedColumnCount="' + visibleColumnCount +
                        '" ss:ExpandedRowCount="' + (datatoExport.length + 2) + '">' +
                        colXml +
                        '<ss:Row ss:Height="38">' +
                            '<ss:Cell ss:StyleID="title" ss:MergeAcross="' + (visibleColumnCount - 1) + '">' +
                              '<ss:Data xmlns:html="http://www.w3.org/TR/REC-html40" ss:Type="String">' +
                                '<html:B><html:U><html:Font html:Size="15">' + title +
                                '</html:Font></html:U></html:B></ss:Data><ss:NamedCell ss:Name="Print_Titles" />' +
                            '</ss:Cell>' +
                        '</ss:Row>' +
                        '<ss:Row ss:AutoFitHeight="1">' +
                        headerXml + 
                        '</ss:Row>';
                       // console.log(t);
                       var it = datatoExport, l = datatoExport.length;
					
//              Generate the data rows from the data in the Store
                for (var i = 0; i < l; i++) {
                    t += '<ss:Row>';
                    var cellClass = (i & 1) ? 'odd' : 'even';
                    r = datatoExport[i];

                    var k = 0;
                    var recordval;
                    
                    for (var j = 0; j < cnt; j++) {
                  	  
                            var v = r[cm[j].colDef.field];
                            v = v==null ? "" : v;
                        	
                            t += '<ss:Cell ss:StyleID="' + cellClass + cellTypeClass[k] + '"><ss:Data ss:Type="' + cellType[k] + '">';
                            /*switch(cm[j].colDef.field){
								case "currentodo": t += checkOdoExcel(v, datatoExport[i].nextservice);break;
								default: t += v;break;
							}*/
							t += v;

                                
                            t +='</ss:Data></ss:Cell>'; 
                            k++;
                    }
                    t += '</ss:Row>';  
                }

                result.xml = t + '</ss:Table>' +
                    '<x:WorksheetOptions>' +
                        '<x:PageSetup>' +
                            '<x:Layout x:CenterHorizontal="1" x:Orientation="Landscape" />' + 
                            '<x:Footer x:Data="Page &amp;P of &amp;N" x:Margin="0.5" />' +
                            '<x:PageMargins x:Top="0.5" x:Right="0.5" x:Left="0.5" x:Bottom="0.8" />' +
                        '</x:PageSetup>' +
                        '<x:FitToPage />' +
                        '<x:Print>' +
                            '<x:PrintErrors>Blank</x:PrintErrors>' + 
                            '<x:FitWidth>1</x:FitWidth>' +
                            '<x:FitHeight>32767</x:FitHeight>' +
                            '<x:ValidPrinterInfo />' +
                            '<x:VerticalResolution>600</x:VerticalResolution>' +
                        '</x:Print>' +
                        '<x:Selected />' +
                        '<x:DoNotDisplayGridlines />' +
                        '<x:ProtectObjects>False</x:ProtectObjects>' +
                        '<x:ProtectScenarios>False</x:ProtectScenarios>' +
                    '</x:WorksheetOptions>' +
                '</ss:Worksheet>';
              //  console.log(t);
                return result;
            }

            function exporttoExcel(){
	              var title = "Replay Route Details";
          	  var worksheet = createWorksheet();
               // var totalWidth = this.getColumnModel().getTotalWidth(includeHidden);
                return '<\?xml version="1.0" encoding="utf-8"?>' +
                    '<ss:Workbook xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:o="urn:schemas-microsoft-com:office:office">' +
                    '<o:DocumentProperties><o:Title>' + title + '</o:Title></o:DocumentProperties>' +
                    '<ss:ExcelWorkbook>' +
                        '<ss:WindowHeight>' + worksheet.height + '</ss:WindowHeight>' +
                        '<ss:WindowWidth>' + worksheet.width + '</ss:WindowWidth>' +
                        '<ss:ProtectStructure>False</ss:ProtectStructure>' +
                        '<ss:ProtectWindows>False</ss:ProtectWindows>' +
                    '</ss:ExcelWorkbook>' +
                    '<ss:Styles>' +
                        '<ss:Style ss:ID="Default">' +
                            '<ss:Alignment ss:Vertical="Top" ss:WrapText="1" />' +
                            '<ss:Font ss:FontName="arial" ss:Size="10" />' +
                            '<ss:Borders>' +
                                '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Top" />' +
                                '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Bottom" />' +
                                '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Left" />' +
                                '<ss:Border ss:Color="#e4e4e4" ss:Weight="1" ss:LineStyle="Continuous" ss:Position="Right" />' +
                            '</ss:Borders>' +
                            '<ss:Interior />' +
                            '<ss:NumberFormat />' +
                            '<ss:Protection />' +
                        '</ss:Style>' +
                        '<ss:Style ss:ID="title">' +
                            '<ss:Borders />' +
                            '<ss:Font />' +
                            '<ss:Alignment ss:WrapText="1" ss:Vertical="Center" ss:Horizontal="Center" />' +
                            '<ss:NumberFormat ss:Format="@" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:ID="headercell">' +
                            '<ss:Font ss:Bold="1" ss:Size="10" />' +
                            '<ss:Alignment ss:WrapText="1" ss:Horizontal="Center" />' +
                            '<ss:Interior ss:Pattern="Solid" ss:Color="#A3C9F1" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:ID="even">' +
                            '<ss:Interior ss:Pattern="Solid" ss:Color="#CCFFFF" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="even" ss:ID="evendate">' +
                            '<ss:NumberFormat ss:Format="[ENG][$-409]dd\-mmm\-yyyy;@" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="even" ss:ID="evenint">' +
                            '<ss:NumberFormat ss:Format="0" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="even" ss:ID="evenfloat">' +
                            '<ss:NumberFormat ss:Format="0.00" />' +   
                        '</ss:Style>' +
                        '<ss:Style ss:ID="odd">' +
                            '<ss:Interior ss:Pattern="Solid" ss:Color="#CCCCFF" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="odd" ss:ID="odddate">' +
                            '<ss:NumberFormat ss:Format="[ENG][$-409]dd\-mmm\-yyyy;@" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="odd" ss:ID="oddint">' +
                            '<ss:NumberFormat ss:Format="0" />' +
                        '</ss:Style>' +
                        '<ss:Style ss:Parent="odd" ss:ID="oddfloat">' +
                            '<ss:NumberFormat ss:Format="0.00" />' +
                        '</ss:Style>' +
                    '</ss:Styles>' +
                    worksheet.xml +
                    '</ss:Workbook>';
            }

            function convertdata(){
	             // console.log(exporttoExcel());
          	  document.location='data:application/vnd.ms-excel;base64,' + base64_encode(exporttoExcel());
            }

	      function clickStatus(val){
		      
	    	  $("#statusButton").val(val);
	    	  document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
	    	  gridOptions.api.onFilterChanged();
	    	  
	      }
		
		function getReplayDetails(){
			buttonvalue = true;
			   var unitno = $("#unitno").val();
			   var start_date = $("#start_date").val();
			   var to_date = $("#to_date").val();
			   //alert(unitno);
			   if ($.trim(unitno) == "") {
					$("#error-msg").html("Select Ladle No.");
					$("#alertbox").click();
					return false;
				} 
				else if ($.trim(start_date) == "") {
					$("#error-msg").html("Select start date & time");
					$("#alertbox").click();
					return false;
				} 
				else if ($.trim(to_date) == "") {
					$("#error-msg").html("Select end date & time");
					$("#alertbox").click();
					return false;
				}
				else{
					
					gridOptions.api.deselectAll();
					showtrackHide = false;
				    httpResponse = new Array();
				    routeLocation = new Array();	
				    $("#statusButton").val("");
				    pauseVar = true;
					var httpRequest = new XMLHttpRequest();
					//alert('<?php echo jquery_url()?>lists/getReplaydata?unitno='+unitno+'&start_date='+start_date+'&to_date='+to_date);
				    httpRequest.open('GET', '<?php echo jquery_url()?>lists/getReplaydata?unitno='+unitno+'&start_date='+start_date+'&to_date='+to_date);
				    httpRequest.send();
				    httpRequest.onreadystatechange = function() {
					    
					   // console.log(httpRequest.readyState);
				        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
				        	//alert(httpRequest.responseText);
				            httpResponse = JSON.parse(httpRequest.responseText);
				            routeLocation = httpResponse;	
				            if(httpResponse.length > 0){
				            	onBtShowLoading();
				            	//$("#ignEvents, #movingEvents, #slowEvents, #geoEvents, #speedEvents, #suddenEvents, #harshEvents").html("0");
				            	$("#startButton, #playButton, #rewindButton, #endButton, #pauseButton, #forwardButton").prop("disabled", false);
					            setRowData(httpResponse);
					            document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
					            
					            var date1 = $("#start_date").val();
								var date2 = $("#to_date").val();
								if(httpResponse.length > 1){
									date1 = httpResponse[0].reportTime;
									date2 = httpResponse[httpResponse.length-1].reportTime;
								}
								setElapsedTime(date1, date2);	
				            }
				            else{
				            	var dataSource = {
						    	        rowCount: null, // behave as infinite scroll
						    	        getRows: function (params) {}
						    	    };
								gridOptions.api.setDatasource(dataSource);
							    $("#statusButton, #showMarkers, #slowTime, #ignOffTime, #distanceTot, #elapsedTime").val("");
							    $("#ignEvents, #movingEvents, #slowEvents, #geoEvents, #speedEvents, #suddenEvents, #harshEvents").html("0");
							    $("#startButton, #playButton, #rewindButton, #endButton, #pauseButton, #forwardButton").prop("disabled", true);
				            	document.getElementById('mapFrame').src="<?php echo base_url();?>retrac/replaymap";
				            	$("#error-msg").html("No records for the selection");
								$("#alertbox").click();
				            }						
				        }
				    };
				}
		}

		function setElapsedTime(startDate, endDate){

			var date1 = $("#start_date").val().split(" ");
			var date2 = $("#to_date").val().split(" ");		
			var dbdateyear = date1[0].split("-");
			var dbdateyear2 = date2[0].split("-");
			if(httpResponse.length > 1){
				date1 = startDate.split(" ");
				date2 = endDate.split(" ");	
				date1[0] += "-"+dbdateyear[2];
				date2[0] += "-"+dbdateyear2[2];
			}
			var SDate = date1[0].split("-");							
			var NDate = date2[0].split("-");
				
			SDate = SDate[1]+"/"+SDate[0]+"/"+SDate[2]+" "+date1[1];
			NDate = NDate[1]+"/"+NDate[0]+"/"+NDate[2]+" "+date2[1];			
			
			var a = moment(SDate,'M/D/YY hh:mm:ss');
			var b = moment(NDate,'M/D/YY hh:mm:ss');	
			var diffDays = b.diff(a, 'seconds');
			//console.log(diffDays);
	    	var hours1 = parseInt(((diffDays)/(60*60)));
			var minutes1 = parseInt((((diffDays)%(60*60))/60));
			var seconds1 =parseInt((((diffDays)%(60*60))%60));
			if(hours1<10)
				hours1 = '0'+hours1;
			if(minutes1<10)
				minutes1 = '0'+minutes1;
			if(seconds1<10)
				seconds1 = '0'+ seconds1;
			var formattedTime = (hours1)+':'+(minutes1)+':'+(seconds1);
			$("#elapsedTime").val(formattedTime);
		}

    </script>
    <script src="<?php echo asset_url(); ?>js/jquery.js"></script>
	<script src="<?php echo asset_url(); ?>js/moment.js"></script>
	<script src="<?php echo asset_url(); ?>js/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
	    var $j = jQuery.noConflict();
	    $j(document).ready(function(){
<?php $cur = $this->master_db->runQuerySql('select DATE_FORMAT(Date(NOW()), "%d-%m-%y") cur, DATE_FORMAT(NOW(), "%H:%i:00") hr');?>
		    $j.datetimepicker.setLocale('en');	

		    function getNowDateTimeStr(){
		    	 var now = new Date();
		    	// var hour = now.getHours() - (now.getHours() >= 12 ? 12 : 0);
		    	return [AddZero(now.getDate()), AddZero(now.getMonth() + 1), now.getFullYear()].join("-");
		    	}

	    	function getNowTimeStr(){
	    		var now = new Date();
		    	// var hour = now.getHours() - (now.getHours() >= 12 ? 12 : 0);
		    	//return [[AddZero(now.getDate()), AddZero(now.getMonth() + 1), now.getFullYear()].join("/"), [AddZero(hour), AddZero(now.getMinutes())].join(":"), now.getHours() >= 12 ? "PM" : "AM"].join(" ");
	    		return [AddZero(now.getHours()), AddZero(now.getMinutes()) , AddZero(now.getSeconds())].join(":");
	    	}

		    	//Pad given value to the left with "0"
		    	function AddZero(num) {
		    	    return (num >= 0 && num < 10) ? "0" + num : num + "";
		    	}	    
		    	
		   /* $j('#start_date').datetimepicker({
		    	
		    	format:'d-m-y h:i:00',
		    	formatTime:'h:i:00',
		    	formatDate:'d-m-y',
		    	step: 30,	
		    	validateOnBlur:true
		    });*/
			var dates = new Date();
			var startDateTime = getNowDateTimeStr()+' 00:00:00';
			var endDateTime = getNowDateTimeStr()+' '+getNowTimeStr();
		    <?php 
	       		//$tripstart = $this->session->userdata("tripstart");
	       		if($tripstart){?>	
	       		startDateTime = '<?php echo $tripstart;?>';
		       <?php }?>

		       <?php 
	       		//$tripend = $this->session->userdata("tripend");
	       		if($tripend){?>	
	       		endDateTime = '<?php echo $tripend;?>';
		       <?php }?>
			//alert(dates.getDate());
		    $j('#start_date').datetimepicker({
		    	  format:'d-m-y H:i:s',
		    	  formatTime:'H:i:00',
			    	formatDate:'d-m-y',
			    	step: 30,	
			    	validateOnBlur:true,
			    	value:startDateTime,
		    	  onShow:function( ct ){
		    	   this.setOptions({
		    	    maxDate:$j('#to_date').val()?$j('#to_date').val():0
		    	   })
		    	  },
		    	  onClose:function(ct,$i){
		    		  $("#to_date").val("");
		    		}
		    	 // timepicker:false
		    	 });
		    $j('#to_date').datetimepicker({
		    	  format:'d-m-y H:i:s',		    	 
		    	  formatTime:'H:i:00',
			    	formatDate:'d-m-y',
			    	step: 30,	
			    	maxDate:0,
			    	validateOnBlur:true,
			    	value:endDateTime,
		    	  onShow:function( ct ){
		    	   this.setOptions({
		    	    minDate:$j('#start_date').val()?$j('#start_date').val():0
		    	   })
		    	  },
		    	  onSelectDate:function(ct,$i){
			    	  var start_date = $j('#start_date').val();
			    	  var end_date = $j('#to_date').val();
			    	  start_date = start_date.split(" ");
			    	  end_date = end_date.split(" ");
			    	  end_date = end_date[0].split("-");
			    	  if(start_date.length > 1){
			    		  start_date = start_date[0].split("-");
			    		  var a = moment(start_date[1]+"/"+start_date[0]+"/"+start_date[2],'M/D/YY');
			    		  var b = moment(end_date[1]+"/"+end_date[0]+"/"+end_date[2],'M/D/YY');
			    		  var diffDays = b.diff(a, 'days');
			    		  if(diffDays > 6){
			    			  $("#error-msg").html("You Can Generate Up To 7 Days Report Only");
							  $("#alertbox").click();
							  $j('#to_date').val("");
							  $j('#to_date').datetimepicker('hide');
			    		  }
			    	  }
		    		}
		    	  //timepicker:false
		    	 });
	    });
	    
	    </script>
	    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">
	    google.charts.load('current', {'packages':['gauge']});
	    </script>
    
    
    
 
</html>