<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo title; ?></title>
	<link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
	<link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<?php echo $updatelogin;
	$role = $detail[0]->userRole;
	?>

	<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">
	<style>
		.search_bar {
			margin-top: -53px;
			transition: 0.5s;
			-moz-transition: 0.5s;
			-webkit-transition: 0.5s;
			-ms-transition: 0.5s;
			-o-transition: 0.5s;
			position: relative;
		}

		.sro {
			margin-top: 0px !important;
		}


		.pop_container {
			background-color: #fff;
			float: left;
			margin-top: 0;
			padding: 20px;
			width: 100%;
			height: 100%;
		}

		body {
			background: #fff;
		}


		.large_map {
			height: 100%;
			overflow: hidden;
			position: relative;
			width: 100%;
		}

		.large_map iframe {
			height: 82%;
			position: fixed;
			width: 100%;
		}
	</style>

</head>

<body class="dark-sidenav">

	<?php echo $header; ?>

	<?php echo $GeofenceAddDetails; ?>
	<?php echo $LocationAddDetails; ?>

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

	<div class="page-content">
		<div class="container-fluid">

			<div class="card mt-4">

				<div class="card-body">
			<div class="table-responsive">
				<div class="col-md-5 po" style="display: none;">
					<div id="myGrid" style="width: 100%; height: 450px ;" class="ag-blue"></div>
				</div>
				<div class="col-md-12 po">
				<div class="embed-responsive embed-responsive-16by9">

						<iframe  class="embed-responsive-item" id="mapFrame" name="mapFrame" src="" style="overflow:hidden;"  frameborder="0" style="border:0"></iframe>
					</div>
				</div>
			</div>
			<form name="dataGridFrom" id="dataGridFrom" action="datagrid" method="POST" validate="true">

				<input type="hidden" id="bounds" name="bounds" value="">
				<input type="hidden" id="ureports" name="ureports" value="" />
			</form>
			<?php if ($detail[0]->userRole == 'c' || $detail[0]->userRole == 'a') { ?>
				<div class="fixed_footer">
					<button type="button" class="btn btn-primary" onclick="addGeofence();"><i class="fa-solid fa-plus"></i> Add Geofence</button>
					<button type="button" class="btn btn-info" onclick="manageGeofence();"><i class="fa-solid fa-pencil"></i> Manage Geofence</button>
					<button type="button" class="btn btn-warning" onclick="showGeofence();"><i class="fa-solid fa-eye"></i> Show/Hide Geofence</button>

					<button type="button" class="btn btn-primary" onclick="addTrack();"><i class="fa-solid fa-plus"></i> Add Track</button>
					<button type="button" class="btn btn-info" onclick="manageTrack();"><i class="fa-solid fa-pencil"></i> Manage Track</button>
					<button type="button" class="btn btn-warning" onclick="showTrack();"><i class="fa-solid fa-eye"></i> Show/Hide Track</button>

				</div>
			<?php } ?>
		</div>
	</div>
		</div>
	</div>
			</div>

	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	<script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
	<?php echo $jsfileone; ?>

	<script>
		<?php /*?>// Jquery draggable
		    $('.gaugeModal_d').draggable({
		    	handle: ".gaugeModal_c"
		    });*/ ?>
		$(function() {
			$("#dialog, #distanceDialog").dialog({
				autoOpen: false,
				show: {
					effect: "blind",
					duration: 100
				},
				hide: {
					//effect: "explode",
					duration: 100
				}
			});

			$("#distanceDialog").on("dialogclose", function(event, ui) {
				closeDistance();
			});
			$(".ui-dialog-titlebar-close").html("x");
		});
	</script>

	<script src="<?php echo asset_url(); ?>js/jquery.validationEngine.js"></script>
	<script src="<?php echo asset_url(); ?>js/jquery.validationEngine-en.js"></script>
	<script src="<?php echo asset_url(); ?>js/jquery.validate.min.js"></script>



	

	<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.tokeninput.js"></script>

	<script>
		$.validator.addMethod("greaterThan", function(value, element, param) {
			var $otherElement = $(param);
			//alert(parseFloat(value) > parseFloat($otherElement.val()));
			// alert(value);
			// alert($otherElement.val());
			return parseFloat(value) > parseFloat($otherElement.val());
		});

		var v = $("#form-validate").validate({

			errorClass: "help-block",
			errorElement: 'span',
			onkeyup: false,
			onblur: false,
			onfocusout: function(element) {
				this.element(element);
			},
			rules: {
				geoName: 'required',
				geoMaxSpeed: 'required'
			},

			errorElement: 'span',
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error');
			}
		});

		var v1 = $("#form-validateloc").validate({

			errorClass: "help-block",
			errorElement: 'span',
			onkeyup: false,
			onblur: false,
			onfocusout: function(element) {
				this.element(element);
			},
			rules: {
				locName: 'required',
				locDes: 'required',
				locRefRadius: {
					greaterThan: "#locRadius"
				},
			},
			messages: {

				locRefRadius: {
					greaterThan: "radius refer location should be greater than the radius at location"
				}
			},
			errorElement: 'span',
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error');
			}
		});

		var v2 = $("#form-validatemloc").validate({

			errorClass: "help-block",
			errorElement: 'span',
			onkeyup: false,
			onblur: false,
			onfocusout: function(element) {
				this.element(element);
			},
			rules: {
				mlocName: 'required',
				mlocDes: 'required',
				mlocRefRadius: {
					greaterThan: "#mlocRadius"
				},
			},
			messages: {

				mlocRefRadius: {
					greaterThan: "radius refer location should be greater than the radius at location"
				}
			},
			errorElement: 'span',
			highlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error');
			}
		});

		var resetGeo = false,
			latestGeo = false,
			latestLineGeo = false,
			firstRow = 0,
			buttonvalue = false,
			showtrackHide = false,
			IsLocShowHide = false,
			IsShowHide = false;
		var routeLocHide = false,
			replyLocHide = false,
			replyGeoHide = false,
			replyshowTrac = false,
			replyLocAllHide = false;
		var circularGeoStore = new Array(),
			rectangularGeoStore = new Array(),
			locationStore = new Array(),
			polygonGeoStore = new Array(),
			polylineGeoStore = new Array();
		var circularGeoLatestStore = new Array(),
			rectangularGeoLatestStore = new Array(),
			polygonGeoLatestStore = new Array(),
			polylineGeoLatestStore = new Array(),
			locationLatestStore = new Array();
		var pauseVar = true,
			mapCircleVar;

		function updateMap(val, track) {
			document.getElementById('mapFrame').contentWindow.refreshMarkers(val, track);
		}

		function showTrack() {
			if (showtrackHide) {
				document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
				showtrackHide = false;
			} else {
				//IsShowHide = true;
				document.getElementById('mapFrame').contentWindow.showLinePath();
			}

		}

		function addGeofence() {
			//$("#error-msg").html("Select geofence type from bottom right corner menu");
			$("#error-msg").html("Draw line to create Geofence.");
			$("#alertbox").click();
			document.getElementById('mapFrame').contentWindow.setPolyMode();
			IsShowHide = true;
		}

		function addTrack() {
			$("#error-msg").html("Please draw a line to create Track.");
			$("#alertbox").click();
			document.getElementById('mapFrame').contentWindow.setPolylineMode();
			showtrackHide = true;
		}

		function showGeofence() {
			replyGeoHide = true;
			// show and hide geofence
			//alert(IsShowHide);
			if (IsShowHide) {
				document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
				IsShowHide = false;
			} else {
				//IsShowHide = true;
				document.getElementById('mapFrame').contentWindow.showCircleGeo();
			}
		}



		function routeLocations() {
			// show and hide location
			routeLocHide = true;
			if (IsLocShowHide) {
				// document.getElementById('mapFrame').contentWindow.initialize();
				document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
			} else {

				document.getElementById('mapFrame').contentWindow.showLocation1();

			}
		}

		function showDistance() {
			$("#distanceDialog").dialog("open");
			$("#distance_val").html(0.00);
			document.getElementById('mapFrame').contentWindow.callDistancePoly();
		}

		function showGauge() {
			var selectedRows = gridOptions.api.getSelectedRows();
			var selectedRowsString = '';
			var fuel = 0,
				speed = 0,
				next = 0,
				capacity = 0;
			reDrawGauge();
			$("#dialog").dialog("open");
		}

		function reDrawGauge() {
			var selectedRows = gridOptions.api.getSelectedRows();
			var selectedRowsString = '';
			var fuel = 0,
				speed = 0,
				next = 150,
				capacity = 0;
			google.charts.setOnLoadCallback(drawChart);
			google.charts.setOnLoadCallback(drawChart1);
			if (selectedRows.length) {
				var cnt = selectedRows.length - 1;
				fuel = selectedRows[cnt].fuel;
				speed = selectedRows[cnt].speed;
				capacity = selectedRows[cnt].fuelCapacity;

				var expr = new RegExp("^[-]?[0-9]*[\.]?[0-9]*$");
				var num = expr.test(fuel);
				if (fuel < 0) {
					fuel = 0;
					speed = 0;
					next = 150;
				} else if (fuel == 0) {
					fuel = 0;
					next = 150;
				} else if (num == false) {
					fuel = 0;
					next = 150;
				} else if (fuel > 0) {
					var next = Math.round(capacity);
				}
			}
			drawChart(fuel, next);
			drawChart1(parseInt(speed));
		}

		function drawChart(fuel, next) {

			var fuelmeter;
			if (fuel == '[object Event]') {
				fuelmeter = 0;

				var data = google.visualization.arrayToDataTable([

					['Label', 'Value'],
					['Fuel', fuelmeter]


				]);
				gaugeOptions = {
					width: 400,
					height: 120,
					min: 0,
					max: 150,
					greenFrom: (150 * 0.8),
					greenTo: 150,
					yellowFrom: (150 * 0.5),
					yellowTo: (150 * 0.8),
					redFrom: 0,
					redTo: (150 * 0.5)

				};
				new google.visualization.Gauge(document.getElementById('dvFuel')).draw(data, gaugeOptions);

			} else if (fuel != '[object Event]') {
				//alert(next);
				fuelmeter = next - fuel;
				var label = fuel;
				var data = google.visualization.arrayToDataTable([

					['Label', 'Value'],
					['"' + fuelmeter + '"', label]


				]);
				gaugeOptions = {
					width: 400,
					height: 120,
					min: 0,
					max: next,
					greenFrom: (next * 0.8),
					greenTo: next,
					yellowFrom: (next * 0.5),
					yellowTo: (next * 0.8),
					redFrom: 0,
					redTo: (next * 0.5)

				};
				new google.visualization.Gauge(document.getElementById('dvFuel')).draw(data, gaugeOptions);
			}
		}

		function drawChart1(speed) {
			var sp;

			if (speed == '[object Event]') {
				sp = 0;

				var data1 = google.visualization.arrayToDataTable([

					['Label', 'Value'],
					['Speed', sp]
				]);
				gaugeOptions = {
					width: 400,
					height: 120,
					min: 0,
					max: 140,
					greenFrom: 0,
					greenTo: (140 * 0.5),
					yellowFrom: (140 * 0.5),
					yellowTo: (140 * 0.8),
					redFrom: (140 * 0.8),
					redTo: 140


				};
				new google.visualization.Gauge(document.getElementById('dvSpeed')).draw(data1, gaugeOptions);

			} else if (speed != '[object Event]') {
				sp = speed;
				var data1 = google.visualization.arrayToDataTable([

					['Label', 'Value'],
					['Speed', sp]
				]);
				gaugeOptions = {
					width: 400,
					height: 120,
					min: 0,
					max: 140,
					greenFrom: 0,
					greenTo: 70,
					yellowFrom: 70,
					yellowTo: 90,
					redFrom: 90,
					redTo: 140


				};
				new google.visualization.Gauge(document.getElementById('dvSpeed')).draw(data1, gaugeOptions);



			}
		}

		function closeDistance() {
			//$("#distance_label").hide();
			document.getElementById('mapFrame').contentWindow.hideDistancePoly();
		}

		function showLocation() {
			// show and hide location
			replyLocHide = true;
			if (IsLocShowHide) {
				document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
			} else {
				document.getElementById('mapFrame').contentWindow.showLocation();
			}
		}

		function addLocation() {
			$("#error-msg").html("Click on map to create location");
			$("#alertbox").click();
			// set the cursor to create location
			document.getElementById('mapFrame').contentWindow.addClickListener();
			document.getElementById('mapFrame').contentWindow.map
				.setOptions({
					draggableCursor: 'crosshair'
				});
			IsLocShowHide = true;
		}

		function showAddLocation(lat, lon) {
			$("#getAddLocation").click();
			$(".vehicleClass").val("");
			$("#locLatitude").val(lat);
			$("#locLongitude").val(lon);
		}

		function showGeoWin(mapCircle, type) {
			mapCircleVar = mapCircle;
			$("#getunit").click();
			$(".circle, .rect, .poly").hide();
			$(".vehicleClass").val("");
			//alert(type);
			$("#geoType").val(type);
			//alert($("#geoType").val());

			switch (type) {
				case 1:
					$("#geoLatitude").val(mapCircle.getCenter().lat().toFixed(7));
					$("#geoLongitude").val(mapCircle.getCenter().lng().toFixed(7));
					$("#geoRadius").val(mapCircle.getRadius().toFixed(2));
					$("#trackname").html("Geofence Name");
					$("#geoModalLabel").html("Geofence Details");
					$(".circle").show();
					break;
				case 2:
					$("#geoLatitude").val(mapCircle.getBounds().getSouthWest().lat().toFixed(7));
					$("#geoLongitude").val(mapCircle.getBounds().getSouthWest().lng().toFixed(7));
					$("#geoLatitude2").val(mapCircle.getBounds().getNorthEast().lat().toFixed(7));
					$("#geoLongitude2").val(mapCircle.getBounds().getNorthEast().lng().toFixed(7));
					$("#trackname").html("Geofence Name");
					$("#geoModalLabel").html("Geofence Details");
					$(".rect").show();
					break;
				case 3:
					var latpoly = "";
					var j = 0;
					for (var i = 0; i < mapCircle.getPath().getArray().length; i++) {
						latpoly = latpoly + "(" + mapCircle.getPath().getAt(i).lat().toFixed(7) + "," + mapCircle.getPath().getAt(i).lng().toFixed(7) + ")" + ":";
					}
					$("#geoPolyLatLong").val(latpoly);
					$("#geoPolyLatLongdiv").html(latpoly);
					$("#trackname").html("Geofence Name");
					$("#geoModalLabel").html("Geofence Details");
					$(".poly").show();
					break;
				case 4:
					var latpoly = "";
					var j = 0;
					for (var i = 0; i < mapCircle.getPath().getArray().length; i++) {
						latpoly = latpoly + "(" + mapCircle.getPath().getAt(i).lat().toFixed(7) + "," + mapCircle.getPath().getAt(i).lng().toFixed(7) + ")" + ":";
					}
					$("#geoPolyLatLong").val(latpoly);
					$("#geoPolyLatLongdiv").html(latpoly);
					$("#trackname").html("Track Name");
					$("#geoModalLabel").html("Track Details");
					$(".poly").show();
					break;
			}
		}

		function resetGeofence() {
			locationLatestStore = new Array(), circularGeoLatestStore = new Array(), rectangularGeoLatestStore = new Array(), polygonGeoLatestStore = new Array(), polylineGeoLatestStore = new Array();
			$(".resetval").val("");
		}

		function submitGeofence() {
			if (v.form()) {
				$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
				var str = $("#form-validate").serialize();
				var geoType = $("#geoType").val();
				//str = str+"&unitnumber=0";
				//alert(str);
				$.post("<?php echo base_url(); ?>lists/saveGeoDetails", str, function(data) {
					//alert(data);
					if (parseInt(data) == 1) {
						$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
						resetGeofence();
						$("#closeButton").click();
						if (geoType != "4") {
							$.ajax({
								url: '<?php echo base_url(); ?>lists/getLatestReplayGeofence?type=' + geoType,
								dataType: 'json',
								success: function(data) {
									switch (geoType) {
										case "1":
											circularGeoLatestStore = data;
											break;
										case "2":
											rectangularGeoLatestStore = data;
											break;
										case "3":
											polygonGeoLatestStore = data;
											break;
										default:
											break;
									}
									latestGeo = true;
									document.getElementById('mapFrame').contentWindow.initialize();
									latestGeo = false;
								}
							});
						}

						$.ajax({
							url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=' + geoType,
							dataType: 'json',
							success: function(data) {
								switch (geoType) {
									case "1":
										circularGeoStore = data;
										break;
									case "2":
										rectangularGeoStore = data;
										break;
									case "3":
										polygonGeoStore = data;
										break;
									default:
										break;
								}
							}
						});
						if (geoType == "4") {
							$.ajax({
								url: '<?php echo base_url(); ?>lists/getTrackLatest',
								dataType: 'json',
								success: function(data) {
									polylineGeoLatestStore = data;

									latestGeo = true;
									document.getElementById('mapFrame').contentWindow.initialize();
									latestGeo = false;
								}
							});
						}

						$.ajax({
							url: '<?php echo base_url(); ?>lists/getTrack',
							dataType: 'json',
							success: function(data) {
								polylineGeoStore = data;
							}
						});
						setManageGeofence();
						setManageTrack();

					} else {
						$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
					}
				});
			}
		}

		function submitLocation() {
			//alert(v1.form());
			if (v1.form()) {
				$("#locmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
				var str = $("#form-validateloc").serialize();

				$.post("<?php echo base_url(); ?>lists/saveLocDetails", str, function(data) {
					//alert(data);
					if (parseInt(data) == 1) {
						$("#locmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
						resetGeofence();
						$("#closeLocButton").click();
						$.ajax({
							url: '<?php echo base_url(); ?>lists/getLatestReplayLocation',
							dataType: 'json',
							success: function(data) {
								locationLatestStore = data;
								latestGeo = true;
								document.getElementById('mapFrame').contentWindow.initialize();
								latestGeo = false;
							}
						});

						setLocationDetails();
					} else {
						$("#locmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
					}
				});
			}
		}

		function setLocationDetails() {
			$.ajax({
				url: '<?php echo base_url(); ?>lists/getReplayLocation',
				dataType: 'json',
				success: function(data) {
					locationStore = data;
					//setRowDataLoc(locationStore);
				}
			});
		}

		function submitmLocation() {
			//alert(v1.form());
			if (v2.form()) {

				var str = $("#form-validatemloc").serialize();
				var selectedRows = gridOptionsLoc.api.getSelectedRows();
				var selectedRowsString = '';
				if (selectedRows.length) {
					$("#mlocmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
					selectedRows.forEach(function(selectedRow, index) {
						selectedRowsString = selectedRow.locationNumber;
					});
					str = str + "&locid=" + selectedRowsString;
					$.post("<?php echo base_url(); ?>lists/updateLocDetails", str, function(data) {
						//alert(data);
						if (parseInt(data) == 1) {
							$("#mlocmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
							setLocationDetails();
						} else {
							$("#mlocmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please fill the required details.</div>');
						}
					});
				} else {
					alert("Please select Location");
				}
			}
		}

		function deleteLocation() {
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			var selectedRowsString = '';
			if (selectedRows.length) {
				$("#mlocmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
				selectedRows.forEach(function(selectedRow, index) {
					selectedRowsString = selectedRow.locationNumber;
					$.post("<?php echo base_url(); ?>lists/deleteLocDetails", {
						latitude: selectedRow.latitude,
						longitude: selectedRow.longitude
					}, function(data) {
						//alert(data);
						if (parseInt(data) == 1) {
							$("#mlocmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
							gridOptionsLoc.api.deselectAll();
							setLocationDetails();
							$(".vehicleClass").val("");
							$(".vehicleClass").html("");
						} else {
							$("#mlocmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Location.</div>');
						}
					});
				});
			} else {
				alert("Please select Location");
			}
		}

		function deleteGeofence() {
			var selectedRows = gridOptionsGeo1.api.getSelectedRows();
			var selectedRowsString = '';
			if (selectedRows.length) {
				var r = confirm('Do You want to delete "' + selectedRows[0].geofenceName + '" geofence\n and respective alerts(If configured)');
				if (r == true) {
					$("#mgeomsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleting, please wait...</div>');
					switch (selectedRows[0].geofenceType) {
						case "1":
							$.post("<?php echo base_url(); ?>lists/deleteCircleGeo", {
								latitude: selectedRows[0].latitude,
								longitude: selectedRows[0].longitude
							}, function(data) {
								//alert(data);
								if (parseInt(data) == 1) {
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();
								} else {
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
						case "2":
							$.post("<?php echo base_url(); ?>lists/deleteRectGeo", {
								latitude: selectedRows[0].latitude,
								longitude: selectedRows[0].longitude,
								latitude1: selectedRows[0].latitude1,
								longitude1: selectedRows[0].longitude1
							}, function(data) {
								//alert(data);
								if (parseInt(data) == 1) {
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();
								} else {
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
						case "3":
							$.post("<?php echo base_url(); ?>lists/deletePolyGeo", {
								geofenceNumber: selectedRows[0].geofenceNumber
							}, function(data) {
								//alert(data);
								if (parseInt(data) == 1) {
									$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
									resetmGeofence();
									setManageGeofence();
								} else {
									$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Geofence.</div>');
								}
							});
							break;
						default:
							break;
					}
					setGeo();
				}
			} else {
				alert("Please select Geofence");
			}
		}

		function deleteTrack() {
			var selectedRows = gridOptionsTrack.api.getSelectedRows();
			var selectedRowsString = '';
			if (selectedRows.length) {
				var r = confirm('Do You want to delete "' + selectedRows[0].geofenceName + '" Track');
				if (r == true) {
					$("#trackmsg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleting, please wait...</div>');
					$.post("<?php echo base_url(); ?>lists/deleteTrack", {
						geofenceNumber: selectedRows[0].geofenceNumber
					}, function(data) {
						//alert(data);
						if (parseInt(data) == 1) {
							$("#trackmsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully</div>');
							resettrack();
							setManageTrack();
							setTrack();
						} else {
							$("#trackmsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in deleting the Track.</div>');
						}
					});
				}
			} else {
				alert("Please select Track");
			}
		}

		function submitmGeofence() {
			var selectedRows = gridOptionsGeo1.api.getSelectedRows();
			var selectedRowsString = '';
			if (selectedRows.length == 0) {
				$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Select a geofence</div>');
			} else {
				var geoUnitArr = new Array();
				var geoUnitGrid = gridOptionsGeo3.api.getSelectedNodes();
				geoUnitGrid.forEach(function(selectedRow, index) {
					//alert(selectedRow.id);
					geoUnitArr.push(selectedRow.id);
				});

				/*for(var i=0;i<geoConfigUnitStore.getCount();i++){
	       		 geoConfigUnitArr.push(geoConfigUnitStore.getAt(i).get('unitnumber'))
	       	 }*/
				selectedRows.forEach(function(selectedRow, index) {

					$.post("<?php echo base_url(); ?>lists/updateManageGeo", {
						geoUnitArr: geoUnitArr.join(","),
						geoActualUnit: geoActualUnit.join(","),
						geofenceNumber: selectedRow.geofenceNumber
					}, function(data) {
						//alert(data);
						if (parseInt(data) == 1) {
							$("#mgeomsg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully</div>');
							resetmGeofence();
						} else {
							$("#mgeomsg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Error in Updating Geofence.</div>');
						}
					});
				});
			}
		}


		function setinputbox(id, data) {
			$("#" + id).tokenInput('<?php echo base_url(); ?>lists/getUnits', {

				prePopulate: data,
				theme: "facebook",
				placeholder: 'Type Unitname',
				queryParam: "q",
				hintText: "Type atleast two letters",
				//preventDuplicates: true,
				minChars: 2,
				tokenLimit: 1,
				propertyToSearch: "name",
				onDelete: function(item) {

				}
			});

			$("ul.token-input-list-facebook").css("width", "20%");
		}

		function setGeo() {
			$.ajax({
				url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=1',
				dataType: 'json',
				success: function(data) {

					circularGeoStore = data;
				}
			});

			$.ajax({
				url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=2',
				dataType: 'json',
				success: function(data) {
					rectangularGeoStore = data;
				}
			});

			$.ajax({
				url: '<?php echo base_url(); ?>lists/getReplayGeofence?type=3',
				dataType: 'json',
				success: function(data) {
					polygonGeoStore = data;
				}
			});
		}


		function setTrack() {
			$.ajax({
				url: '<?php echo base_url(); ?>lists/getTrack',
				dataType: 'json',
				success: function(data) {
					polylineGeoStore = data;
				}
			});

		}


		$(document).ready(function() {

			$("#geoModal").on("hidden.bs.modal", function() {
				resetGeofence();
				$("#msg_box").html("");
				if (typeof mapCircleVar !== 'undefined') {
					// the variable is defined
					document.getElementById('mapFrame').contentWindow.draw.setDrawingMode(null);
					mapCircleVar.setVisible(false);
				}
			});

			$("#locModal").on("hidden.bs.modal", function() {
				resetGeofence();
				$("#locmsg_box").html("");
				document.getElementById('mapFrame').contentWindow.map.setOptions({
					draggableCursor: 'pointer'
				});
			});

			$("#mlocModal").on("hidden.bs.modal", function() {
				$(".vehicleClass").val("");
				$(".vehicleClass").html("");
				$("#mlocmsg_box").html("");
				gridOptionsLoc.api.deselectAll();
				setLocationDetails();
				document.getElementById('mapFrame').src = "<?php echo base_url() ?>lists/replaymap";
			});

			$("#mgeoModal").on("hidden.bs.modal", function() {
				$("#mgeomsg_box").html("");
				resetmGeofence();
				document.getElementById('mapFrame').src = "<?php echo base_url() ?>lists/replaymap";
			});
			setGeo();
			setTrack();




			setLocationDetails();

			<?php
			$replayUnit = $this->session->userdata("replayUnit");
			$tripstart = $this->session->userdata("tripstart");
			$tripend = $this->session->userdata("tripend");
			if ($replayUnit) { ?>
				// Get all the products

				$.ajax({
					url: '<?php echo base_url(); ?>lists/getUnits?q=<?php echo $replayUnit; ?>',
					dataType: 'json',
					success: function(data) {
						setinputbox('unitno', data);
						<?php
						if ($tripstart && $tripend && $replayUnit) { ?>
							getReplayDetails();
						<?php }
						?>
					}
				});
			<?php } else {
			?>
				setinputbox('unitno', '');
			<?php } ?>

		});
	</script>

	<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

	<script type="text/javascript">
		var httpResponse = new Array(),
			routeLocation = new Array();

		var columnDefsLoc = [{
			headerName: "Location",
			field: "locationName",
			width: 440,
			filter: 'text',
			filterParams: {
				apply: true,
				newRowsAction: 'keep'
			}
		}];

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

		var columnDefsGeo1 = [{
			headerName: "Geofence",
			field: "geofenceName",
			width: 450,
			filter: 'text',
			filterParams: {
				apply: true,
				newRowsAction: 'keep'
			}
		}];

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

		var columnDefsTrack = [{
			headerName: "Track Name",
			field: "geofenceName",
			width: 450,
			filter: 'text',
			filterParams: {
				apply: true,
				newRowsAction: 'keep'
			}
		}];

		var gridOptionsTrack = {
			debug: true,
			enableServerSideSorting: true,
			enableServerSideFilter: true,
			enableColResize: true,
			rowSelection: 'single',
			// onRowSelected: onSelectionChangedGeo1,
			rowDeselection: true,
			overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
			columnDefs: columnDefsTrack,
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

		var columnDefsGeo2 = [{
				headerName: "id",
				field: "id",
				width: 0,
				hide: true,
				filter: 'text',
				filterParams: {
					apply: true,
					newRowsAction: 'keep'
				}
			},
			{
				headerName: "Groups",
				field: "groupname",
				width: 450,
				checkboxSelection: true,
				filter: 'text',
				filterParams: {
					apply: true,
					newRowsAction: 'keep'
				}
			}

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

			cb.addEventListener('change', function(e) {

				if (this.checked) {
					//console.log(gridOptions1.api.getModel());
					gridOptionsGeo2.api.getModel().forEachNode(function(node) {
						node.setSelected(true);
					});
				} else {
					gridOptionsGeo2.api.getModel().forEachNode(function(node) {
						node.setSelected(false);
					});
				}
			});

			return eHeader;
		}

		var columnDefsGeo3 = [{
				headerName: "id",
				field: "id",
				width: 0,
				hide: true,
				filter: 'text',
				filterParams: {
					apply: true,
					newRowsAction: 'keep'
				}
			},
			{
				headerName: "Units",
				field: "unitname",
				width: 450,
				checkboxSelection: true,
				filter: 'text',
				filterParams: {
					apply: true,
					newRowsAction: 'keep'
				}
			}

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

		function onSelectionChangedGeo3(event) {
			var selectedRows = gridOptionsGeo3.api.getSelectedRows().length;
			var cnt = gridOptionsGeo3.api.getModel().rowsToDisplay.length;

			$("#myCheckboxunit").prop("checked", false);
			if (selectedRows == cnt) {
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

			cb.addEventListener('change', function(e) {

				if (this.checked) {
					//console.log(gridOptions1.api.getModel());
					gridOptionsGeo3.api.getModel().forEachNode(function(node) {
						node.setSelected(true);
					});
				} else {
					gridOptionsGeo3.api.getModel().forEachNode(function(node) {
						node.setSelected(false);
					});
				}
			});

			return eHeader;
		}

		var columnDefs = [

			{
				headerName: "Report Time",
				field: "reportTime",
				width: 90,
				suppressFilter: true
			},
			{
				headerName: "Speed",
				field: "speed",
				width: 27,
				suppressFilter: true
			},
			{
				headerName: "Fuel",
				field: "fuel",
				width: 38,
				suppressFilter: true,
				hide: true
			},
			{
				headerName: "Distance",
				field: "distance",
				width: 50,
				suppressFilter: true
			},
			{
				headerName: "Status",
				field: "STATUS",
				width: 100,
				suppressFilter: true,
				cellClassRules: {
					'user-moving': function(params) {
						return applyClass(params, [2]);
					},
					'user-ignoff': function(params) {
						return applyClass(params, [1]);
					},
					'user-sudden': function(params) {
						return applyClass(params, [3, 18, 19, 20]);
					},
					'user-illegal': function(params) {
						return applyClass(params, [6]);
					},
					'user-ignon': function(params) {
						return applyClass(params, [12]);
					},
					'user-overspeed': function(params) {
						return applyClass(params, [13]);
					},
					'user-slowidle': function(params) {
						return applyClass(params, [15, 17]);
					},
					'user-unreachable': function(params) {
						return applyClass(params, [21]);
					}
				}
			},
			{
				headerName: "Location",
				field: "location",
				width: 250,
				suppressFilter: true
			}
		];

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

			document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";

			var gridDivloc = document.querySelector('#locGrid');
			new agGrid.Grid(gridDivloc, gridOptionsLoc);

			var gridDivgeo1 = document.querySelector('#geo1Grid');
			new agGrid.Grid(gridDivgeo1, gridOptionsGeo1);

			gridDivgeo1 = document.querySelector('#trackGrid');
			new agGrid.Grid(gridDivgeo1, gridOptionsTrack);
			setManageTrack();

			gridDivgeo1 = document.querySelector('#geo2Grid');
			new agGrid.Grid(gridDivgeo1, gridOptionsGeo2);
			setManageGeofence();

			gridDivgeo1 = document.querySelector('#geo3Grid');
			new agGrid.Grid(gridDivgeo1, gridOptionsGeo3);
			gridOptionsGeo3.api.setRowData([]);
			gridOptionsGeo3.api.hideOverlay();
		});


		var geoActualUnit = new Array(),
			groupselect = new Array();

		function setManageGeofence() {
			$.ajax({
				url: '<?php echo base_url(); ?>lists/getAllGeoData',
				dataType: 'json',
				success: function(data) {
					setRowDataGeo1(data);
				}
			});
			var httpRequest = new XMLHttpRequest();
			httpRequest.open('GET', '<?php echo base_url(); ?>lists/getManageGeoGroup');
			httpRequest.send();
			httpRequest.onreadystatechange = function() {
				if (httpRequest.readyState == 4 && httpRequest.status == 200) {
					httpResultGeoGroup = JSON.parse(httpRequest.responseText);
					gridOptionsGeo2.api.setRowData(httpResultGeoGroup);
				}
			};
		}

		function setManageTrack() {
			$.ajax({
				url: '<?php echo base_url(); ?>lists/getTrack',
				dataType: 'json',
				success: function(data) {
					setRowDataTrack(data);
				}
			});
		}

		function onSelectionChangedGeo1(event) {
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
			selectedRows.forEach(function(selectedRow, index) {
				//console.log(selectedRow.id);
				var config_geo = new Array();
				$("#geoFormType").html(arr[selectedRow.geofenceType]);
				$("#geoFormName").html(selectedRow.geofenceName);
				$.ajax({
					url: '<?php echo base_url(); ?>lists/getConfigGeo?type=' + selectedRow.geofenceNumber,
					dataType: 'json',
					success: function(data) {
						config_geo = data;
						var grpselect = new Array();
						groupselect = new Array();
						geoActualUnit = new Array();
						config_geo.forEach(function(data, index) {
							geoActualUnit.push(data.unitnumber);
							grpselect.push(data.groupnumber);
							groupselect.push(data.groupnumber);

						});
						if (groupselect.length > 0) {
							$.map(httpResultGeoGroup, function(val, index) {

								if (groupselect.indexOf(val.id) > -1) {
									var node = gridOptionsGeo2.api.getModel().getRow(index);
									node.setSelected(true);
								}
							});

							$.ajax({
								url: '<?php echo base_url(); ?>lists/getGroupUnits?groups=' + groupselect.join(","),
								dataType: 'json',
								success: function(data1) {
									httpUnitsResponse = data1;
									//console.log(httpUnitsResponse);
									gridOptionsGeo3.api.setRowData(data1);
									$.map(httpUnitsResponse, function(val, index) {
										if (geoActualUnit.indexOf(val.id) > -1) {
											var node = gridOptionsGeo3.api.getModel().getRow(index);
											node.setSelected(true);
										}
									});
								}
							});
						} else {
							gridOptionsGeo3.api.setRowData([]);
						}
					}
				});

			});


		}


		function onSelectionChangedTrack(event) {

			var selectedRows = gridOptionsTrack.api.getSelectedRows();

			var selectedRowsString = '';
			selectedRows.forEach(function(selectedRow, index) {
				$("#trackFormName").html(selectedRow.geofenceName);
			});


		}

		var httpUnitsResponse = new Array();

		function onSelectionChangedGeo2(event) {

			var selectedRows = gridOptionsGeo2.api.getSelectedRows();

			clearGridFilter3("unitname");
			gridOptionsGeo3.api.setRowData([]);
			gridOptionsGeo3.api.showLoadingOverlay();
			var grpselect = [];
			selectedRows.forEach(function(selectedRow, index) {
				grpselect.push(selectedRow.id);

			});

			if (grpselect.length > 0 && resetGeo == false) {
				//console.log("selected");
				//console.log(grpselect);
				$.ajax({
					url: '<?php echo base_url(); ?>lists/getGroupUnits?groups=' + grpselect.join(),
					dataType: 'json',
					success: function(data) {
						httpUnitsResponse = data;
						gridOptionsGeo3.api.setRowData(data);
						$.map(httpUnitsResponse, function(val, index) {
							//console.log(val.id +"-"+ val.groupnumber);
							if (geoActualUnit.indexOf(val.id) > -1) {
								//console.log(val.id);
								//console.log(data.groupnumber);
								var node = gridOptionsGeo3.api.getModel().getRow(index);
								node.setSelected(true);
								//console.log(gridOptionsGeo2.);
							} else if (groupselect.indexOf(val.groupnumber) == -1 && grpselect.indexOf(val.groupnumber) > -1) {
								//console.log(grpselect.indexOf(val.id));
								var node = gridOptionsGeo3.api.getModel().getRow(index);
								node.setSelected(true);
							}
						});
					}
				});
			} else {
				gridOptionsGeo3.api.setRowData([]);
			}

		}

		function setRowDataGeo1(allOfTheData) {
			// give each row an id
			//console.log("data is here");
			//console.log(allOfTheData);
			allOfTheData.forEach(function(data, index) {
				data.id = (index + 1);
			});

			var dataSource = {
				rowCount: null, // behave as infinite scroll
				getRows: function(params) {
					console.log('asking for ' + params.startRow + ' to ' + params.endRow);
					onBtShowLoading();
					// At this point in your code, you would call the server, using $http if in AngularJS.
					// To make the demo look real, wait for 500ms before returning
					setTimeout(function() {
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

		function setRowDataTrack(allOfTheData) {
			// give each row an id
			//console.log("data is here");
			//console.log(allOfTheData);
			allOfTheData.forEach(function(data, index) {
				data.id = (index + 1);
			});

			var dataSource = {
				rowCount: null, // behave as infinite scroll
				getRows: function(params) {
					console.log('asking for ' + params.startRow + ' to ' + params.endRow);
					onBtShowLoading();
					// At this point in your code, you would call the server, using $http if in AngularJS.
					// To make the demo look real, wait for 500ms before returning
					setTimeout(function() {
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

			gridOptionsTrack.api.setDatasource(dataSource);
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
			resultOfSort.sort(function(a, b) {
				for (var k = 0; k < sortModel.length; k++) {

					var sortColModel = sortModel[k];
					var valueA = a[sortColModel.colId];
					var valueB = b[sortColModel.colId];

					// this filter didn't find a difference, move onto the next one
					if (valueA == valueB) {
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
			for (var i = 0; i < data.length; i++) {
				var item = data[i];

				if (filterPresent && filterModel.geofenceName) {
					var geoname = item.geofenceName;
					var allowedLName = filterModel.geofenceName.filter;
					var flagLName = checkStrLoop(filterModel.geofenceName.type, geoname.toLowerCase(), allowedLName.toLowerCase());
					/// console.log(flagLName);
					if (flagLName == 1) {
						continue;
					}
				}

				resultOfFilter.push(item);
			}

			return resultOfFilter;
		}

		function manageLocation() {
			//onBtShowLoading();
			gridOptionsLoc.api.deselectAll();
			$("#getlocpop").click();
		}

		function manageGeofence() {
			gridOptionsGeo1.api.deselectAll();
			$("#getgeopop").click();
		}

		function manageTrack() {
			gridOptionsTrack.api.deselectAll();
			$("#gettrackpop").click();
		}

		function onSelectionChanged() {
			//console.log("ggg");
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			var selectedRowsString = '';
			selectedRows.forEach(function(selectedRow, index) {
				$("#mlocName").val(selectedRow.locationName);
				$("#mlocDes").val(selectedRow.description);
				$("#mlocLatitude").val(selectedRow.latitude);
				$("#mlocLongitude").val(selectedRow.longitude);
				$("#mlocRadius").val(selectedRow.radius);
				$("#mlocRefRadius").val(selectedRow.radiusRefer);
			});
		}

		function resetmLocation() {
			var selectedRows = gridOptionsLoc.api.getSelectedRows();
			if (selectedRows.length) {
				onSelectionChanged();
			} else {
				alert("Please select the Location");
			}
		}

		function resetmGeofence() {
			resetGeo = true;

			clearGridFilter2("groupname");
			clearGridFilter1("geofenceName");
			clearGridFilter3("unitname");
			geoActualUnit = new Array(), groupselect = new Array();

			gridOptionsGeo3.api.setRowData([]);
			$("#geoFormType, #geoFormName").html("");
			resetGeo = false;
		}

		function resettrack() {
			$("#trackFormName").html("");
		}

		function clearGridFilter1(param) {
			gridOptionsGeo1.api.deselectAll();
			var ageFilterComponent = gridOptionsGeo1.api.getFilterInstance(param);
			ageFilterComponent.setType('contains');
			ageFilterComponent.setFilter("");
			gridOptionsGeo1.api.onFilterChanged();
		}

		function clearGridFilter2(param) {
			gridOptionsGeo2.api.deselectAll();
			var ageFilterComponent = gridOptionsGeo2.api.getFilterInstance(param);
			ageFilterComponent.setType('contains');
			ageFilterComponent.setFilter("");
			gridOptionsGeo2.api.onFilterChanged();
		}

		function clearGridFilter3(param) {
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
			allOfTheData.forEach(function(data, index) {
				data.id = (index + 1);
			});

			var dataSource = {
				rowCount: null, // behave as infinite scroll
				getRows: function(params) {
					console.log('asking for ' + params.startRow + ' to ' + params.endRow);
					onBtShowLoading();
					// At this point in your code, you would call the server, using $http if in AngularJS.
					// To make the demo look real, wait for 500ms before returning
					setTimeout(function() {
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
			resultOfSort.sort(function(a, b) {
				for (var k = 0; k < sortModel.length; k++) {

					var sortColModel = sortModel[k];
					var valueA = a[sortColModel.colId];
					var valueB = b[sortColModel.colId];

					// this filter didn't find a difference, move onto the next one
					if (valueA == valueB) {
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
			for (var i = 0; i < data.length; i++) {
				var item = data[i];

				if (filterPresent && filterModel.locationName) {
					var locationname = item.locationName;
					var allowedLName = filterModel.locationName.filter;
					var flagLName = checkStrLoop(filterModel.locationName.type, locationname.toLowerCase(), allowedLName.toLowerCase());
					/// console.log(flagLName);
					if (flagLName == 1) {
						continue;
					}
				}

				resultOfFilter.push(item);
			}

			return resultOfFilter;
		}

		function applyClass(params, arr) {
			var val = "";
			if (params.data === undefined || params.data === null) {
				return false;
			} else {
				//console.log(params.data.statusColor);	
				return arr.indexOf(parseInt(params.data.statusColor)) > -1;
			}
		}

		var tinterval = 1000;
		var myintr1;

		function playTrack() {
			if (httpResponse.length > 0) {
				if (pauseVar == true) {
					pauseVar = false;

					var replaySelection = gridOptions.api.getSelectedNodes();
					if (replaySelection.length == 0) {
						document.getElementById('mapFrame').contentWindow.hideAllNode();
					}
					//gridOptions.api.deselectAll();
					myintr1 = setInterval(replayMap, tinterval);
				} else {
					$("#error-msg").html("wait...");
					$("#alertbox").click();
				}
			} else {
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
			if (httpResponse.length > 0) {
				var replaySelection = gridOptions.api.getSelectedNodes();
				$("#startButton, #playButton, #rewindButton, #endButton, #forwardButton").prop("disabled", true);
				if (replaySelection.length == 0) {
					node = gridOptions.api.getModel().getRow(0);
					node.setSelected(true);
					//console.log(node.data.id);
					document.getElementById('mapFrame').contentWindow.dispNextNode(0);
				} else if (replaySelection.length != httpResponse.length) {
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
				} else {
					pauseMap();
				}
			} else {
				$("#error-msg").html("No records for the selection");
				$("#alertbox").click();
				pauseMap();
			}
		}

		function startMap() {

			if (checkPause()) {
				gridOptions.api.deselectAll();
				node = gridOptions.api.getModel().getRow(0);
				node.setSelected(true);
				document.getElementById('mapFrame').contentWindow.hideAllNode();
				document.getElementById('mapFrame').contentWindow.dispNextNode(0);
				gridOptions.api.ensureIndexVisible(0);
			}
			//playVar = false;
		}

		var tintervalend = 1000;
		var myintrend;
		var virtualcnt = 100,
			startcnt = 0;

		function lastrowMap() {
			virtualcnt = 100, startcnt = 0;
			if (checkPause()) {
				//console.log("start");
				document.getElementById('mapFrame').contentWindow.dispAllNode(gridOptions.api.getSelectedNodes().length);
				var len = httpResponse.length;
				if (virtualcnt >= len) {
					virtualcnt = len;
				}
				myintrend = setInterval(endMap, tintervalend);
			}
		}


		function resetDetails() {
			var dataSource = {
				rowCount: null, // behave as infinite scroll
				getRows: function(params) {}
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
			document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";

		}

		function refreshDetails() {
			$("#showMarkers").val("");
			gridOptions.api.deselectAll();
			document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
		}

		function onBtShowLoading() {

			//gridOptions.api.showLoadingOverlay();
		}

		function onBtHide() {
			//gridOptions.api.hideOverlay();
		}

		var h;
		$(document).ready(function() {


			//h = $( document ).height()-175;

			$('#myGrid').on('click', ".ag-row", function(evt) {
				$("#contextMenu").hide();
				var id = 0,
					distance = 0;
				var selectedRowsNodes = gridOptions.api.getSelectedNodes();
				var len = selectedRowsNodes.length;
				var temp = new Array(),
					tempSum = new Array();
				var distance = 0,
					predist = 0,
					sec = 0,
					sec1 = 0,
					sec2 = 0,
					sec3 = 0,
					total = 0;

				selectedRowsNodes.forEach(function(selectedRow, index) {
					id = selectedRow.id;
					id = id - 1;

					for (var i = firstRow; i <= id; i++) {
						//console.log(i);
						node = gridOptions.api.getModel().getRow(i);
						node.setSelected(true);
						//distance += parseFloat(node.data.distance);

						var seconds1 = 0,
							seconds2 = 0,
							c = 0;
						dist = node.data.distance;
						sidle = node.data.STATUS;
						if (sidle.substring(0, 4) == 'Slow') {
							var sub = sidle.substring(11, 19);
							var pattern = /\d{2}:\d{2}:\d{2}/;
							if (sub.match(pattern) != null) {
								//var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
								var a = sub.split(':');
								seconds1 = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
								sec = sec + seconds1;
							}
						}

						if (sidle.substring(0, 7) == 'Ign Off') {
							var sub = sidle.substring(9, 17);
							var pattern = /\d{2}:\d{2}:\d{2}/;
							if (sub.match(pattern) != null) {
								seconds2 = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
								sec2 = sec2 + seconds2;
							}
						}
						// temp.push(dist);
						// predist = dist;

						if (i - 1 < id - 2) {

							//var a = node[(i+1)].data.distance;
							var nodea = gridOptions.api.getModel().getRow(i + 1);
							var a = nodea.data.distance;
							//console.log(cnt+"-"+index);
							var b = node.data.distance;
							if (parseFloat(a) > parseFloat(b)) {
								c = parseFloat(a) - parseFloat(b);
								distance += c;
								//tempSum.push(c.toFixed(2));
							}
						}


					}


				});
				var date = new Date(1970, 0, 1);
				date.setSeconds(sec);
				var sidlesum = date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");

				var date2 = new Date(1970, 0, 1);
				date2.setSeconds(sec2);
				var ignoffsum = date2.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
				$('#slowTime').val(sidlesum);
				$('#ignOffTime').val(ignoffsum);
				$("#distanceTot").val(distance.toFixed(2));
				if (id > 0) {
					var date1 = $("#start_date").val();
					var date2 = $("#to_date").val();
					if (httpResponse.length > 1) {
						date1 = httpResponse[0].reportTime;
						date2 = httpResponse[id].reportTime;
					}
					setElapsedTime(date1, date2);
				}
				document.getElementById('mapFrame').contentWindow.dispUptoRow(id);
				reDrawGauge();
			});

			$('#geo1Grid').on('click', ".ag-row", function(evt) {
				onSelectionChangedGeo1(evt);
			});

			$('#trackGrid').on('click', ".ag-row", function(evt) {
				onSelectionChangedTrack(evt);
			});

			/*$('#geo2Grid').on('click',".ag-row", function(evt){
				//alert();
				onSelectionChangedGeo2(evt);
			});*/


			$('body').on("mousedown", ".ag-row", function(e) {

				if (e.button == 2) {

					$('#contextMenu').css({
						position: "absolute",
						left: e.pageX,
						top: e.pageY
					}).slideDown();
					e.stopImmediatePropagation();

					return false;
				}
				return true;

			});

		});



		function setGridHeight() {
			//alert("height="+$( window ).height());
			//var h = $( document ).height()-510;
			$("#myGrid").css("height", h + "px");
		}

		var datatoExport = [];

		function setRowData(allOfTheData) {
			// give each row an id
			var distance = ignCount = 0,
				movingCount = 0,
				slowCount = 0,
				overCount = 0,
				geoCount = 0,
				harshCount = 0,
				suddenCount = 0,
				c = 0;
			var Event = null,
				Idle_Start_Time = null,
				Idle_Start_TimeUnix = null,
				Location = null,
				Idle_time_unix = null,
				idle = null,
				idletime = null;
			var cnt = allOfTheData.length;
			allOfTheData.forEach(function(data, index) {
				data.id = (index + 1);
				var status = data.STATUS.replace(" ", "").toLowerCase();
				//console.log(cnt-2+"-"+index-1);

				//distance += parseFloat(data.distance);
				if (status.indexOf("ign") >= 0) {
					ignCount++;
				} else if (status.indexOf("moving") >= 0) {
					movingCount++;
				} else if (status.indexOf("slow/idle") >= 0) {
					slowCount++;
				} else if (status.indexOf("overspeed") >= 0) {
					overCount++;
				} else if (status.indexOf("geoentry") >= 0) {
					geoCount++;
				} else if (status.indexOf("harshhccel") >= 0) {
					harshCount++;
				} else if (status.indexOf("suddenbrake") >= 0) {
					suddenCount++;
				}
				if (cnt != index) {
					if (data.statusid == "18") {
						Idle_time_unix = data.reporttimeunix;

						if (Idle_Start_TimeUnix != null) {
							allOfTheData[index - 1].STATUS = getStatus(Idle_time_unix, allOfTheData[index - 1].STATUS, Idle_Start_TimeUnix);
						}
						Idle_Start_TimeUnix = data.reporttimeunix;
					} else if (data.statusid == "1" || data.statusid == "9" || data.statusid == "14" || data.statusid == "23") {
						Idle_time_unix = data.reporttimeunix;
						if (Idle_Start_TimeUnix != null) {
							allOfTheData[index - 1].STATUS = getStatus(Idle_time_unix, allOfTheData[index - 1].STATUS, Idle_Start_TimeUnix);
						}
						Idle_Start_TimeUnix = null;
					} else if (data.statusid == "19" || data.statusid == "0" || data.statusid == "14" ||
						data.statusid == "2" || data.statusid == "3" || data.statusid == "4") {
						Idle_time_unix = data.reporttimeunix;
						if (Idle_Start_TimeUnix != null) {
							allOfTheData[index - 1].STATUS = getStatus(Idle_time_unix, allOfTheData[index - 1].STATUS, Idle_Start_TimeUnix);
						}
						Idle_Start_TimeUnix = null;
					}

					if (data.statusid == "0" || data.statusid == "9" || data.statusid == "14") {
						Idle_Start_TimeUnix = data.reporttimeunix;
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
				getRows: function(params) {
					console.log('asking for ' + params.startRow + ' to ' + params.endRow);
					//alert();

					// At this point in your code, you would call the server, using $http if in AngularJS.
					// To make the demo look real, wait for 500ms before returning
					setTimeout(function() {
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
			var temp = new Array(),
				tempSum = new Array();
			var distance = 0,
				predist = 0,
				sec = 0,
				sec1 = 0,
				sec2 = 0,
				sec3 = 0,
				total = 0;

			var cnt = data.length;
			for (var i = 0; i < data.length; i++) {
				var item = data[i];
				if ($("#statusButton").val() != "") {
					var status = item.STATUS.replace(" ", "");
					var allowedStatus = $("#statusButton").val();
					var flagStatus = checkStrLoop("contains", status.toLowerCase(), allowedStatus.toLowerCase());
					if (flagStatus == 1) {
						continue;
					}
				}

				dist = item.distance;
				sidle = item.STATUS;
				if (sidle.substring(0, 4) == 'Slow') {
					var sub = sidle.substring(11, 19);
					var pattern = /\d{2}:\d{2}:\d{2}/;
					if (sub.match(pattern) != null) {
						//var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
						var a = sub.split(':');
						var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
						sec = sec + seconds;
					}
				}

				if (sidle.substring(0, 7) == 'Ign Off') {
					var sub = sidle.substring(9, 17);
					var pattern = /\d{2}:\d{2}:\d{2}/;
					if (sub.match(pattern) != null) {
						var seconds = new Date('1970-01-01T' + sub + 'Z').getTime() / 1000;
						sec2 = sec2 + seconds;
					}
				}

				if (i - 1 < cnt - 2) {

					var a = data[i + 1].distance;
					//console.log(cnt+"-"+index);
					var b = item.distance;
					if (parseFloat(a) > parseFloat(b)) {
						var c = parseFloat(a) - parseFloat(b);
						distance += c;
						//tempSum.push(c.toFixed(2));
					}
				}

				resultOfFilter.push(item);
			}

			var date = new Date(1970, 0, 1);
			date.setSeconds(sec);
			var sidlesum = date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");

			var date2 = new Date(1970, 0, 1);
			date2.setSeconds(sec2);
			var ignoffsum = date2.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
			$('#slowTime').val(sidlesum);
			$('#ignOffTime').val(ignoffsum);
			$('#distanceTot').val(distance.toFixed(2));
			return resultOfFilter;
		}

		function getReplayDetails() {
			buttonvalue = true;
			var unitno = $("#unitno").val();
			var start_date = $("#start_date").val();
			var to_date = $("#to_date").val();
			//alert(unitno);
			if ($.trim(unitno) == "") {
				$("#error-msg").html("Select Unitname");
				$("#alertbox").click();
				return false;
			} else if ($.trim(start_date) == "") {
				$("#error-msg").html("Select start date & time");
				$("#alertbox").click();
				return false;
			} else if ($.trim(to_date) == "") {
				$("#error-msg").html("Select end date & time");
				$("#alertbox").click();
				return false;
			} else {

				gridOptions.api.deselectAll();
				showtrackHide = false;
				httpResponse = new Array();
				routeLocation = new Array();
				$("#statusButton").val("");
				pauseVar = true;
				var httpRequest = new XMLHttpRequest();
				//alert('<?php echo jquery_url() ?>lists/getReplaydata?unitno='+unitno+'&start_date='+start_date+'&to_date='+to_date);
				httpRequest.open('GET', '<?php echo jquery_url() ?>lists/getReplaydata?unitno=' + unitno + '&start_date=' + start_date + '&to_date=' + to_date);
				httpRequest.send();
				httpRequest.onreadystatechange = function() {

					// console.log(httpRequest.readyState);
					if (httpRequest.readyState == 4 && httpRequest.status == 200) {
						//alert(httpRequest.responseText);
						httpResponse = JSON.parse(httpRequest.responseText);
						routeLocation = httpResponse;
						if (httpResponse.length > 0) {
							onBtShowLoading();
							//$("#ignEvents, #movingEvents, #slowEvents, #geoEvents, #speedEvents, #suddenEvents, #harshEvents").html("0");
							$("#startButton, #playButton, #rewindButton, #endButton, #pauseButton, #forwardButton").prop("disabled", false);
							setRowData(httpResponse);
							document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";

							var date1 = $("#start_date").val();
							var date2 = $("#to_date").val();;
							if (httpResponse.length > 1) {
								date1 = httpResponse[0].reportTime;
								date2 = httpResponse[httpResponse.length - 1].reportTime;
							}
							setElapsedTime(date1, date2);
						} else {
							var dataSource = {
								rowCount: null, // behave as infinite scroll
								getRows: function(params) {}
							};
							gridOptions.api.setDatasource(dataSource);
							$("#statusButton, #showMarkers, #slowTime, #ignOffTime, #distanceTot, #elapsedTime").val("");
							$("#ignEvents, #movingEvents, #slowEvents, #geoEvents, #speedEvents, #suddenEvents, #harshEvents").html("0");
							$("#startButton, #playButton, #rewindButton, #endButton, #pauseButton, #forwardButton").prop("disabled", true);
							document.getElementById('mapFrame').src = "<?php echo base_url(); ?>lists/replaymap";
							$("#error-msg").html("No records for the selection");
							$("#alertbox").click();
						}
					}
				};
			}
		}
	</script>

</body>

</html>