<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo title; ?></title>
	<link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
	<link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
		.ll_check {
			display: inline-block;

		}

		.search_bar.full_search .form-control {
			height: 36px !important;
			padding: 3px 11px !important;
			width: auto !important;
			display: inline;
		}

		.search_bar {
			width: 100%;
			padding-right: 15px;
		}
	</style>
</head>

<body class="dark-sidenav">

	<?php echo $header; ?>

	<div class="page-content">
		<div class="container-fluid">

			<div class="card mt-4">
				<div class="card-body">

					<div class="top_list_box mb-3">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search By Keywords" id="keywords" onpaste="setKeyword(this.value)" ; oninput="setKeyword(this.value);" onchange="setKeyword(this.value);" onchange="setKeyword(this.value);" onkeydown="setKeyword(this.value);" onkeyup="setKeyword(this.value);">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
							</span>
						</div>
					</div>

		
					<div class="top_list_box mb-3">
						<input type="hidden" name="group" id="group" value="">


					</div>

				


					<div class="table-responsive">
						<div id="myGrid" style="width: 100%; height: 350px ;" class="ag-blue"></div>
					</div>

					<div class="fixed_footer">

						<div class="search_bar full_search ftm" align="center">
							<div class="checkbox ll_check">
								<label>
									<input type="checkbox" class="form-control" name="checkAuto" id="checkAuto" checked="checked" onchange="resetTimer();"> Autoreload
								</label>
							</div>

							<select class="form-control" name="autoreload" id="autoreload" onchange="resetTimer();">
								<option value="30" selected="selected">30</option>
								<option value="45">45</option>
								<option value="60">60</option>
								<option value="90">90</option>
								<option value="120">120</option>
								<option value="180">180</option>
								<option value="240">240</option>
								<option value="300">300</option>
							</select>
							<span class="text">Sec : <span id="countdown">0</span></span>

							<button type="button" class="btn btn-danger btn-reset" onclick="onResetAll(1);"><i class="fa fa-repeat"></i> RESET</button>
							<button class="btn btn-success btn-min" type="button" title="Download Excel" onclick="convertdata();"><i class="fa-solid fa-file-excel"></i> DOWNLOAD EXCEL</button>

						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
	</div>
	</div>
	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	<script src="<?php echo asset_url() ?>js/bootstrap.js"></script>

	<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

	<?php echo $jsfile; ?>

	<?php echo $smsJS; ?>

	<script type="text/javascript">
		function updateMap(val, track) {

		}


		function filterData(filterModel, data) {

			var filterPresent = filterModel && Object.keys(filterModel).length > 0;
			/*if (!filterPresent) {
		                	  $("#unitCount").html(data.length);
		                      return data;
		                  }*/

			var resultOfFilter = [];
			for (var i = 0; i < data.length; i++) {
				var item = data[i];

				if ($("#keywords").val() != "") {
					var flagunit = checkStrLoop("contains", item.unitname.toLowerCase(), $("#keywords").val().toLowerCase());
					var flagreg = checkStrLoop("contains", item.registration.toLowerCase(), $("#keywords").val().toLowerCase());
					var flagst = checkStrLoop("contains", item.status.toLowerCase(), $("#keywords").val().toLowerCase());
					var flagloc = checkStrLoop("contains", item.locationname.toLowerCase(), $("#keywords").val().toLowerCase());
					if (flagst == 1 && flagunit == 1 && flagloc == 1 && flagreg == 1) {
						continue;
					}
				}

				if ($("#hrs").val() != "00") {
					var hoursearch = $("#hrs").val();
					if (parseFloat(hoursearch) < 10)
						hoursearch = hoursearch;
					//var rowData = rec.data; 
					var data1 = item.trackreporttime;
					//console.log("data1="+data1);
					var splitS = data1.split(" ");
					var dsplit = splitS[0].split("-");
					var day = dsplit[1];
					var mon = dsplit[0];
					var yr = dsplit[2];
					var Sdate = yr + "-" + mon + "-" + day;
					var SDate = Sdate + " " + splitS[1];
					var dt = new Date();
					var NDate = getISODateTime(dt);
					var tsDtr = SDate;
					var teDtr = NDate;


					var match = tsDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

					var match1 = teDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat1 = new Date(match1[1], match1[2] - 1, match1[3], match1[4], match1[5], match1[6]);

					var timestamp1 = (dat.getTime() / 1000);
					var timestamp2 = (dat1.getTime() / 1000);

					var stimes = timestamp2 - timestamp1;

					var hours1 = parseInt(((stimes) / (60 * 60)));

					if (parseFloat(hours1) < 10)
						hours1 = '0' + hours1;
					//console.log("track="+item.unitname+",timestamp2="+timestamp2+",timestamp1="+timestamp1);
					//console.log("hours1="+hours1+"hoursearch="+hoursearch);
					if (parseFloat(hours1) < parseFloat(hoursearch))
						continue;
					//return rec.get('trackreporttime');
				}

				if ($("#min").val() != "00") {
					var minutesearch = $("#min").val();
					if (minutesearch < 10)
						minutesearch = minutesearch;


					var hoursearch = $("#hrs").val();
					if (hoursearch < 10)
						hoursearch = hoursearch;

					hoursearch = hoursearch * 60;

					minutesearch = (parseInt(minutesearch) + parseInt(hoursearch));


					var data1 = item.trackreporttime;
					var splitS = data1.split(" ");
					var dsplit = splitS[0].split("-");
					var day = dsplit[1];
					var mon = dsplit[0];
					var yr = dsplit[2];
					var Sdate = yr + "-" + mon + "-" + day;
					var SDate = Sdate + " " + splitS[1];
					var dt = new Date();
					var NDate = getISODateTime(dt);
					var tsDtr = SDate;
					var teDtr = NDate;


					var match = tsDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

					var match1 = teDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat1 = new Date(match1[1], match1[2] - 1, match1[3], match1[4], match1[5], match1[6]);

					var timestamp1 = (dat.getTime() / 1000);
					var timestamp2 = (dat1.getTime() / 1000);

					var stimes = timestamp2 - timestamp1;
					var hours1 = parseInt(((stimes) / (60 * 60)));
					var minutes1 = parseInt((((stimes) % (60 * 60)) / 60));

					if (hours1 < 10)
						hours1 = '0' + hours1;

					if (minutes1 < 10)
						minutes1 = '0' + minutes1;

					minutes1 = (parseInt(hours1 * 60) + parseInt(minutes1));

					if (minutes1 <= minutesearch)
						continue;
				}

				if ($("#sec").val() != "00") {
					var secondsearch = $("#sec").val();
					if (secondsearch < 10)
						secondsearch = secondsearch;

					var sec = 0;
					var sec1 = 0;
					var minutesearch = $("#min").val();
					if (minutesearch < 10)
						minutesearch = minutesearch;


					var hoursearch = $("#hrs").val();
					if (hoursearch < 10)
						hoursearch = hoursearch;

					var seconds = parseInt((hoursearch) * 60 * 60) + parseInt((minutesearch) * 60) + parseInt(secondsearch);
					sec = sec + seconds;


					var data1 = item.trackreporttime;
					var splitS = data1.split(" ");
					var dsplit = splitS[0].split("-");
					var day = dsplit[1];
					var mon = dsplit[0];
					var yr = dsplit[2];
					var Sdate = yr + "-" + mon + "-" + day;
					var SDate = Sdate + " " + splitS[1];
					var dt = new Date();
					var NDate = getISODateTime(dt);
					var tsDtr = SDate;
					var teDtr = NDate;


					var match = tsDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

					var match1 = teDtr.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
					var dat1 = new Date(match1[1], match1[2] - 1, match1[3], match1[4], match1[5], match1[6]);

					var timestamp1 = (dat.getTime() / 1000);
					var timestamp2 = (dat1.getTime() / 1000);

					var stimes = timestamp2 - timestamp1;
					var hours1 = parseInt(((stimes) / (60 * 60)));
					var minutes1 = parseInt((((stimes) % (60 * 60)) / 60));
					var seconds1 = parseInt((((stimes) % (60 * 60)) % 60));

					if (hours1 < 10)
						hours1 = '0' + hours1;

					if (minutes1 < 10)
						minutes1 = '0' + minutes1;

					if (seconds1 < 10)
						seconds1 = '0' + seconds1;



					seconds1 = parseInt((hours1) * 60 * 60) + parseInt((minutes1) * 60) + parseInt(seconds1);
					//sec1 = sec1 + secon;

					//alert(seconds1 +"<<<"+ sec);

					if (seconds1 <= sec)
						continue;
				}

				if (filterPresent && filterModel.unitname) {
					var unitname = item.unitname;
					var allowedName = filterModel.unitname.filter;
					var flagName = checkStrLoop(filterModel.unitname.type, unitname.toLowerCase(), allowedName.toLowerCase());

					if (flagName == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.registration) {
					var unitname = item.registration;
					var allowedName = filterModel.registration.filter;
					var flagName = checkNumLoop(filterModel.registration.type, unitname, allowedName);

					if (flagName == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.status) {
					var status = item.status;
					var allowedStatus = filterModel.status.filter;
					var flagStatus = checkStrLoop(filterModel.status.type, status.toLowerCase(), allowedStatus.toLowerCase());
					//console.log(status+"-----"+flagStatus);
					if (flagStatus == 1) {
						continue;
					}
				}
				/*
							  if (filterPresent && filterModel.loadstatus) {
		                    	  var loadstatus = item.loadstatus;
		                          var allowedStatus = filterModel.loadstatus.filter;
		                          var flagStatus = checkStrLoop(filterModel.loadstatus.type, loadstatus.toLowerCase(), allowedStatus.toLowerCase());
		                          console.log(loadstatus+"-----"+flagStatus);
								if(flagStatus == 1){
									continue;
								}
		                      }*/

				if (filterPresent && filterModel.groupname) {
					var groupname = item.groupname;
					var allowedGName = filterModel.groupname.filter;
					var flagGName = checkStrLoop(filterModel.groupname.type, groupname.toLowerCase(), allowedGName.toLowerCase());

					if (flagGName == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.locationname) {
					var locationname = item.locationname;
					var allowedLName = filterModel.locationname.filter;
					var flagLName = checkStrLoop(filterModel.locationname.type, locationname.toLowerCase(), allowedLName.toLowerCase());

					if (flagLName == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.currentodo) {
					var currentodo = parseFloat(item.currentodo);
					var allowedOdo = parseFloat(filterModel.currentodo.filter);
					var flagCurrentodo = checkNumLoop(filterModel.currentodo.type, currentodo, allowedOdo);
					//console.log(currentodo+"-"+allowedOdo+"-"+flagCurrentodo+"-"+filterModel.currentodo.type);
					if (flagCurrentodo == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.speed) {
					var speed = parseFloat(item.speed);
					var allowedSpeed = parseFloat(filterModel.speed.filter);
					var flagSpeed = checkNumLoop(filterModel.speed.type, speed, allowedSpeed);

					if (flagSpeed == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.groupnumber) {
					var groupnumber = parseFloat(item.groupnumber);
					var allowedGroupNum = parseFloat(filterModel.groupnumber.filter);
					var flagGroupNum = checkNumLoop(filterModel.groupnumber.type, groupnumber, allowedGroupNum);

					if (flagGroupNum == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.fuel) {
					var fuel = parseFloat(item.fuel);
					var allowedFuel = parseFloat(filterModel.fuel.filter);
					var flagFuel = checkNumLoop(filterModel.fuel.type, fuel, allowedFuel);

					if (flagFuel == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.distance) {
					var distance = parseFloat(item.distance);
					var allowedDistance = parseFloat(filterModel.distance.filter);
					var flagDistance = checkNumLoop(filterModel.distance.type, distance, allowedDistance);

					if (flagDistance == 1) {
						continue;
					}
				}

				if (filterPresent && filterModel.temperature) {
					var temperature = parseFloat(item.temperature);
					var allowedTemperature = parseFloat(filterModel.temperature.filter);
					var flagTemperature = checkNumLoop(filterModel.temperature.type, temperature, allowedTemperature);

					if (flagTemperature == 1) {
						continue;
					}
				}



				resultOfFilter.push(item);
			}
			$("#unitCount").html(resultOfFilter.length);
			return resultOfFilter;
		}

		// setup the grid after the page has finished loading
		document.addEventListener('DOMContentLoaded', function() {
			var gridDiv = document.querySelector('#myGrid');
			new agGrid.Grid(gridDiv, gridOptions);
			onBtShowLoading();
			// do http request to get our sample data - not using any framework to keep the example self contained.
			// you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
			var httpRequest = new XMLHttpRequest();
			httpRequest.open('GET', '<?php echo jquery_url() ?>sms/getListdata');
			httpRequest.send();
			httpRequest.onreadystatechange = function() {
				if (httpRequest.readyState == 4 && httpRequest.status == 200) {
					httpResponse = JSON.parse(httpRequest.responseText);
					setRowData(httpResponse);
					/*httpResponse.forEach( function(data, index) {
			            	        data.id = (index + 1);
			            	    });
		                          gridOptions.api.setRowData(httpResponse);  */
					applyOdoClass();
					$("#unitCount").html(httpResponse.length);
					cdreset();
				}
			};

		});


		var h;
		$(document).ready(function() {
			$(".icon_settings_float").click(function() {
				$(".setting_float").toggleClass("my_open");
				$(".setting_float").css("z-index", "0");
				if ($(".setting_float").hasClass("my_open")) {
					$(".setting_float").css("z-index", "999");
				}
			});
			h = $(document).height() - 175;
		});

		function setGridHeight() {
			//alert("height="+$( window ).height());
			//var h = $( document ).height()-510;
			$("#myGrid").css("height", h + "px");
		}
	</script>

</body>

</html>