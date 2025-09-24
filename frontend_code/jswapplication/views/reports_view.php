<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo title; ?></title>

	<link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo asset_url(); ?>css/token-input.css" type="text/css" />
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
<style type="text/css">
	
	.m_iframe{
		border: none!important;
		overflow: auto!important;
		height:464px!important;
	}

	.dark-sidenav.mm-active{
		padding-right: 0!important;
	}
	
	#dv-refill,#dv-mttype,#dv-gflist{
		display: none;
	}
	
	.top_list_box {
		margin-top: 5px;
	}
</style>

	<?php echo $updatelogin; ?>
</head>

<body class="dark-sidenav">

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
					<button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok"><i class="far fa-check-circle"></i> &nbsp;OK</button>

				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="mgeoModal" tabindex="-1" role="dialog" aria-labelledby="mgeoModalLabel">
		<div class="modal-dialog" role="document" style="width: 90%; right: 261px;">
			<div class="modal-content" style="width: 1113px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mgeoModalLabel">Geo Modified Report</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="search_bar full_search">

								<span class="text"><strong>Unit Name :</strong> <span class="unitname"></span></span>

								<span class="text" style="margin-left: 120px;"><strong>Report Type :</strong> <span class="reportType"></span></span>
								<span class="text" style="margin-left: 100px;"><strong>Period :</strong> <span class="period"></span></span>
								<br>
								<span class="text"><strong id="georeportName">Georeport Information</strong></span>

							</div>
							<div id="geo1Grid" style="width: 100%; height: 290px ;" class="ag-blue"></div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" onclick="getExcelDetails();" class="btn btn-success">Excel</button>
					<button type="button" id="closemGeoButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>


				</div>
			</div>
		</div>
	</div>
	<button data-toggle="modal" data-target="#mgeoModal" style="display: none;" id="getgeopop"></button>


	<div class="modal fade" id="mgroupgeoModal" tabindex="-1" role="dialog" aria-labelledby="mgroupgeoModalLabel">
		<div class="modal-dialog" role="document" style="width: 90%; right: 261px;">
			<div class="modal-content" style="width: 1113px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mgroupgeoModalLabel">Group Geo Modified Report</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="search_bar full_search">

								<span class="text"><strong>Group Name :</strong> <span class="groupname"></span></span>

								<span class="text" style="margin-left: 120px;"><strong>Report Type :</strong> <span class="reportType"></span></span>
								<span class="text" style="margin-left: 100px;"><strong>Period :</strong> <span class="period"></span></span>
								<br>
								<span class="text"><strong id="geogroupreportName">Georeport Information</strong></span>

							</div>
							<div id="GroupGeoGrid" style="width: 100%; height: 290px ;" class="ag-blue"></div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" onclick="getExcelDetails();" class="btn btn-success">Excel</button>
					<button type="button" id="closemGeoButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>


				</div>
			</div>
		</div>
	</div>
	<button data-toggle="modal" data-target="#mgroupgeoModal" style="display: none;" id="getgroupgeopop"></button>


	<?php echo $header; ?>

	<div class="page-content">
		<div class="container-fluid">


			<div class="card mt-4">
				<div class="card-body">
					<form id="form-validate" method="post">

						<div class="row">
							<div class="col-12-rmv">
								<div class="top_list_box">
									<select class="form-control clearfield" name="report_wise" id="report_wise" onchange="changeUrl();" style="width:118px;">
										<option value="">Select Ladle No./Group</option>
										<option value="1">Ladle No.</option>
										<option value="2">Group</option>
									</select>
									<input type="hidden" id="hidunit" class="clearfield" value="">
								</div>

								<div class="top_list_box" id="unitdiv">
									<input type="text" id="unit" name="unit" class="form-control" autocomplete="off" style="width: 123px;">
								</div>

								<div class="top_list_box">
									<select class="form-control clearfield" name="reportType" id="reportType" onchange="hideshowValues();" style="width: 101px;">
										<option value="">Report Type</option>
									</select>
								</div>

								<div class="top_list_box">
									<div class="form-group">
										<div class='input-group date date-picker1' style="width: 138px;">
											<input type='text' class="form-control clearfield" id="start_date" name="start_date" autocomplete="off" placeholder="Start Date" />
											<span class="input-group-addon cal-icon">
												<span class="fa-regular fa-calendar"></span>
											</span>
										</div>
									</div>
								</div>

								<div class="top_list_box">
									<div class="form-group">
										<div class='input-group date date-picker1' style="width: 138px;">
											<input type='text' class="form-control clearfield" id="start_time" name="start_time" autocomplete="off" placeholder="Start Time" />
											<span class="input-group-addon cal-icon">
												<span class="fa-regular fa-clock"></span>
											</span>
										</div>
									</div>
								</div>

								<div class="top_list_box">
									<div class="form-group">
										<div class='input-group date date-picker1' style="width: 138px;">
											<input type='text' class="form-control clearfield" id="end_date" name="end_date" autocomplete="off" placeholder="End Date" />
											<span class="input-group-addon cal-icon">
												<span class="fa-regular fa-calendar"></span>
											</span>
										</div>
									</div>
								</div>

								<div class="top_list_box">
									<div class="form-group">
										<div class='input-group date date-picker1' style="width: 138px;">
											<input type='text' class="form-control clearfield" id="end_time" name="end_time" autocomplete="off" placeholder="End Time" />
											<span class="input-group-addon cal-icon">
												<span class="fa-regular fa-clock"></span>
											</span>
										</div>
									</div>
								</div>
								
								<div class="top_list_box" id="dv-gflist">
									<select class="form-control clearfield" name="gf_no" id="gf_no" style="width: 100px;">
										<option value="">ALL Gfs</option>
										<?php 
										if(isset($gf_list) && $gf_list){
											forEach($gf_list as $gf){
										?>
										<option value="<?php echo $gf->gf_no; ?>"><?php echo $gf->geofence; ?></option>
										<?php } } ?>
									</select>
								</div>
								
								<div class="top_list_box" id="dv-refill">
									<select class="form-control clearfield" name="is_refill" id="is_refill" style="width: 100px;">
										<option value="">ALL</option>
										<option value="1">With Refill</option>
										<option value="0">No Refill</option>
									</select>
								</div>
								  
								<div class="top_list_box" id="dv-mttype">
									<select class="form-control clearfield" name="mt_type" id="mt_type" style="width: 100px;">
										<option value="">ALL</option>
										<option value="5">5 MT</option>
										<option value="10">10 MT</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="full-box mt-3 col-12 text-center">
								<button type="button" class="btn btn-primary" id="getbtn" onclick="getDetails();"><i class="fa-solid fa-magnifying-glass"></i> SEARCH</button>
								<button type="button" class="btn btn-success" id="excelbtn" onclick="getExcelDetails();" style="display: none;"><i class="fa-solid fa-file-excel"></i>DOWNLOAD EXCEL</button>
								<button type="button" class="btn btn-danger btn-reset" onclick="resetDetails();"><i class="fa fa-repeat"></i> RESET</button>
							</div>
						</div>
					</form>
				 
				 <div>
						<div class="large_map">
							<iframe id="mainFrame" class="m_iframe" name="mainFrame" src="" style="display: none;overflow:hidden;" width="100%" height="100%" ></iframe>
						</div>
					</div>
					
				</div>
			</div>

		</div>
	</div>

	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	
	<script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>

	<?php echo $jsfile; ?>

	<script type="text/javascript" src="<?php echo asset_url(); ?>js/jquery.tokeninput.js"></script>
	<script src="<?php echo asset_url() ?>js/bootstrap.js"></script>


	<script>
		var urlunits = '<?php echo base_url(); ?>reports/getLadles';
		$('#token-input-unit').prop("disabled", true);

		function changeUrl() {
			$("#is_refill,#mt_type").val("");
			$("#dv-refill,#dv-mttype,#dv-gflist").hide();
			
			$("#reportType").html("<option value=''>Report Type</option>");

			setdatepicker();
			$('#token-input-unit').prop("disabled", false);
			$('#start_time, #end_time,#start_date, #end_date').prop("disabled", false);
			$('#pdfbtn, #getbtn').show();
			$("#mainFrame").attr("src", "").hide();

			$("#unitdiv").html('<input type="text" id="unit" name="unit" class="form-control" autocomplete="off" style="width: 123px;">');
			if ($("#report_wise").val() == "1") {

				urlunits = '<?php echo base_url(); ?>reports/getLadles';

				setToken(urlunits, 1);
				$('#token-input-unit').prop("disabled", true);
				$("#unit").tokenInput("clear");
				$('#token-input-unit').prop("disabled", false);
				$('#token-input-unit').prop("placeholder", "Type Ladle No.");
			} else if ($("#report_wise").val() == "2") {
				urlunits = '<?php echo base_url(); ?>reports/getGroups';
				setToken(urlunits, 2);
				$('#token-input-unit').prop("disabled", true);
				$("#unit").tokenInput("clear");
				$('#token-input-unit').prop("disabled", false);
				$('#token-input-unit').prop("placeholder", "Type Group Name");
			}
		}

		function setToken(urlunits, type) {
			var unitlist = $("#unit").tokenInput(urlunits, {
				//prePopulate: data,
				theme: "facebook",
				placeholder: 'Type Ladle No.',
				queryParam: "q",
				//hintText: "Type atleast two letters",
				//preventDuplicates: true,
				minChars: 1,
				tokenLimit: 1,
				propertyToSearch: "name",
				onDelete: function(item) {
					$("#reportType").html("<option value=''>Report Type</option>");
					$("#hidunit").val("");
				},
				onAdd: function(item) {
					$.post("<?php echo base_url(); ?>reports/getReportsCombo", {
						type: type
					}, function(data) {
						$("#reportType").html(data);
					});
					var selectedValues = $('#unit').tokenInput("get");
					//console.log(selectedValues[0].name);
					$("#hidunit").val(selectedValues[0].name);
				},
			});
		}


		$("ul.token-input-list-facebook").css("width", "100%");
		$("ul.token-input-list-facebook li input").css("width", "123px");

		function resetDetails() {
			$("#unit").tokenInput("clear");
			$("#reportType").html("<option value=''>Report Type</option>");
			$(".clearfield").val("");
			setdatepicker();
			$('#token-input-unit').prop("disabled", false);
			$('#start_time, #end_time,#start_date, #end_date').prop("disabled", false);
			$('#pdfbtn, #getbtn, #excelbtn').show();
			$('#excelbtn').hide();
			$("#mainFrame").attr("src", "").hide();
		}

		function hideshowValues() {

			var reportNo = parseInt($('#reportType').val());
			var reportTp = parseInt($(report_wise).val());
			
			if(reportNo == 302 || reportNo == 303 || reportNo == 305 || reportNo == 306){
				$("#is_refill,#mt_type").val("");
				$("#dv-refill,#dv-mttype").show();
			}else{
				$("#is_refill,#mt_type").val("");
				$("#dv-refill,#dv-mttype").hide();
			}
			
			if(reportNo == 305 || reportNo == 306){
				$("#gf_no").val("");
				$("#dv-gflist").show();
			}else{
				$("#gf_no").val("");
				$("#dv-gflist").hide();
			}
			
			setdatepicker();
			$('#token-input-group').prop("disabled", true);
			$('#start_time, #end_time,#start_date, #end_date').prop("disabled", true);
			$('#pdfbtn, #getbtn, #excelbtn').hide();

			if (parseInt($('#reportType').val()) == "") {
				$('#pdfbtn, #getbtn').show();
			}
			if (parseInt($('#reportType').val()) == 1 || parseInt($('#reportType').val()) == 2 ||
				parseInt($('#reportType').val()) == 6 || parseInt($('#reportType').val()) == 72 ||
				parseInt($('#reportType').val()) == 201 || parseInt($('#reportType').val()) == 202 ||
				parseInt($('#reportType').val()) == 203 || parseInt($('#reportType').val()) == 204 ||
				parseInt($('#reportType').val()) == 205 || parseInt($('#reportType').val()) == 206 ||
				parseInt($('#reportType').val()) == 207 || parseInt($('#reportType').val()) == 208 ||
				parseInt($('#reportType').val()) == 209 || parseInt($('#reportType').val()) == 211 ||
				parseInt($('#reportType').val()) == 42 || parseInt($('#reportType').val()) == 25 ||
				parseInt($('#reportType').val()) == 13 || parseInt($('#reportType').val()) == 31 ||
				parseInt($('#reportType').val()) == 12 || parseInt($('#reportType').val()) == 8 ||
				parseInt($('#reportType').val()) == 40 || parseInt($('#reportType').val()) == 43 ||
				parseInt($('#reportType').val()) == 44 || parseInt($('#reportType').val()) == 41 ||
				parseInt($('#reportType').val()) == 212 || parseInt($('#reportType').val()) == 213 ||
				parseInt($('#reportType').val()) == 214 || parseInt($('#reportType').val()) == 215 ||
				parseInt($('#reportType').val()) == 216 || parseInt($('#reportType').val()) == 217 ||
				parseInt($('#reportType').val()) == 218|| parseInt($('#reportType').val()) == 219|| parseInt($('#reportType').val()) == 220 || parseInt($('#reportType').val()) == 301 || parseInt($('#reportType').val()) == 302  || parseInt($('#reportType').val()) == 303 || parseInt($('#reportType').val()) == 304 || parseInt($('#reportType').val()) == 305 || parseInt($('#reportType').val()) == 306) {
				$('#pdfbtn, #getbtn').show();
				$('#start_time, #end_time,#start_date, #end_date, .timeBtns').prop("disabled", false);
			} else if (parseInt($('#reportType').val()) == 210) {
				$('#getbtn').show();
				$('#start_time, #end_time,#start_date, #end_date, .timeBtns').prop("disabled", true);
			} else if (parseInt($('#reportType').val()) == 71 || parseInt($('#reportType').val()) == 60) {
				$('#excelbtn').show();
				$('#start_date, #end_date').prop("disabled", false);
			} else if (parseInt($('#reportType').val()) == 14 || parseInt($('#reportType').val()) == 20 || parseInt($('#reportType').val()) == 66 ||
				parseInt($('#reportType').val()) == 57) {
				$('#pdfbtn, #getbtn').show();
				$('#start_time, #end_time').val("");
				$('#start_date, #end_date, #startdatebtn, #enddatebtn').prop("disabled", false);
			}

			if (parseInt($('#reportType').val()) == 10) {
				$('#excelbtn').hide();
			}

		}

		var httpResponse = [];

		function getDetails() {
			$('#excelbtn').hide();
			var str = $("#form-validate").serialize();
			$("#mainFrame").attr("src", "").hide();
			str = str + "&type=json";

			if ($("#unit").val() == "") {
				$("#error-msg").html("All Fields are Mandatory");
				$("#alertbox").click();
				return;
			}

			if ($('#reportType').val() == "") {
				$("#error-msg").html("All Fields are Mandatory");
				$("#alertbox").click();
				return;
			} else if (parseInt($('#reportType').val()) == 1 || parseInt($('#reportType').val()) == 2 || parseInt($('#reportType').val()) == 203 || parseInt($('#reportType').val()) == 6 ||
				parseInt($('#reportType').val()) == 204 || parseInt($('#reportType').val()) == 5 || parseInt($('#reportType').val()) == 7 ||
				parseInt($('#reportType').val()) == 205 || parseInt($('#reportType').val()) == 206 || parseInt($('#reportType').val()) == 207 ||
				parseInt($('#reportType').val()) == 208 || parseInt($('#reportType').val()) == 209 || parseInt($('#reportType').val()) == 72 ||
				parseInt($('#reportType').val()) == 42 || parseInt($('#reportType').val()) == 25 || parseInt($('#reportType').val()) == 211 ||
				parseInt($('#reportType').val()) == 13 || parseInt($('#reportType').val()) == 31 || parseInt($('#reportType').val()) == 12 ||
				parseInt($('#reportType').val()) == 8 || parseInt($('#reportType').val()) == 40 || parseInt($('#reportType').val()) == 41 || parseInt($('#reportType').val()) == 43 ||
				parseInt($('#reportType').val()) == 44 || parseInt($('#reportType').val()) == 212 || parseInt($('#reportType').val()) == 213 || parseInt($('#reportType').val()) == 214 || parseInt($('#reportType').val()) == 215 || parseInt($('#reportType').val()) == 216 || parseInt($('#reportType').val()) == 217|| parseInt($('#reportType').val()) == 218|| parseInt($('#reportType').val()) == 219|| parseInt($('#reportType').val()) == 220 || parseInt($('#reportType').val()) == 301 || parseInt($('#reportType').val()) == 302 || parseInt($('#reportType').val()) == 303 || parseInt($('#reportType').val()) == 304 || parseInt($('#reportType').val()) == 305 || parseInt($('#reportType').val()) == 306){

				if ($("#start_date").val() == "" || $('#start_time').val() == "" || $('#end_date').val() == "" || $('#end_time').val() == "") {
					$("#error-msg").html("All Fields are Mandatory");
					$("#alertbox").click();
					return;
				} else {
					var timeNow = new Date();
					var hours = timeNow.getHours();
					var minutes = timeNow.getMinutes();
					var tvalid = hours + ':' + minutes;

					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth() + 1;
					var y = date.getFullYear();
					var starttime = $('#start_time').val();
					var endtime = $('#end_time').val();
					var checkdate;
					if (m < 9)
						checkdate = d + '-0' + m + '-' + y;
					else
						checkdate = d + '-' + m + '-' + y;
					var str1 = $('#start_date').val();
					var str2 = $('#end_date').val();
					if (str2 == checkdate) {
						//alert(str2+"---"+str1);
						//alert(starttime +"----"+ endtime)
						if (endtime > tvalid) {
							$('#end_time').val("");
							$("#error-msg").html("End Time should be less than current time");
							$("#alertbox").click();
							return;
						} else if (str2 == str1 && starttime >= endtime) {
							$('#end_time').val("");
							$("#error-msg").html("End Time should be greater than Start Time");
							$("#alertbox").click();
							return;
						}
					}

					if (checkTimeDiff() > 7 && (parseInt($('#reportType').val()) == 1)) {
						$("#error-msg").html("You Can Generate 1 day Report Only");
						$("#alertbox").click();
						return;
					}
					if (checkTimeDiff() > 0 && (parseInt($('#reportType').val()) == 2)) {
						$("#error-msg").html("You Can Generate 1 day Report Only");
						$("#alertbox").click();
						return;
					}
					if (checkTimeDiff() > 30 && (parseInt($('#reportType').val()) == 212)) {
						$("#error-msg").html("You Can Generate 30 days Report Only");
						$("#alertbox").click();
						return;
					}
					if (checkTimeDiff() > 30 && (parseInt($('#reportType').val()) == 213)) {
						$("#error-msg").html("You Can Generate 30 days Report Only");
						$("#alertbox").click();
						return;
					}
				}

			} else if (parseInt($('#reportType').val()) == 14 || parseInt($('#reportType').val()) == 20 || parseInt($('#reportType').val()) == 66 ||
				parseInt($('#reportType').val()) == 57) {
				if ($("#start_date").val() == "" || $('#end_date').val() == "") {
					$("#error-msg").html("All Fields are Mandatory");
					$("#alertbox").click();
					return;
				}
			}


			if (parseInt($('#reportType').val()) == 24 && !$("#oneMin").is(":checked") && !$("#fiveMin").is(":checked") && !$("#tenMin").is(":checked") &&
				!$("#fifteenMin").is(":checked") && !$("#thirtyMin").is(":checked") && !$("#sixtyMin").is(":checked")) {
				$("#error-msg").html("Please Select Time Interval");
				$("#alertbox").click();
				return;
			} else if (parseInt($('#reportType').val()) == 7) {
				if (!$("#idleCheck").is(":checked")) {
					$("#error-msg").html("Please Select Idle Time");
					$("#alertbox").click();
					return;
				} else if ($('#hrs').val() == "00" && $('#min').val() == "00" && $('#sec').val() == "00") {
					$("#error-msg").html("Please Select Idle Time");
					$("#alertbox").click();
					return;
				}
			} else if ((parseInt($('#reportType').val()) == 52 || parseInt($('#reportType').val()) == 53 || parseInt($('#reportType').val()) == 55 ||
					parseInt($('#reportType').val()) == 56 || parseInt($('#reportType').val()) == 57) && $("#checkAuto").is(":checked")) {
				$("#error-msg").html("This Report is available for single group. Please select the single group");
				$("#alertbox").click();
				return;
			}

			switch (parseInt($('#reportType').val())) {
				case 1:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getMovementdata?' + str;
					var url = '<?php echo base_url() ?>reports/movement?' + str;
					$('#excelbtn').show();
					break;
				case 2:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getMovementdata?' + str;
					var url = '<?php echo base_url() ?>reports/movement_group?' + str;
					$('#excelbtn').show();
					break;
				case 6:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getGeofencedata?' + str;
					var url = '<?php echo base_url() ?>reports/geofence?' + str;
					//$('#excelbtn').show();
					break;
				case 72:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getGeofencedata?' + str;
					var url = '<?php echo base_url() ?>reports/groupgeofence?' + str;
					//$('#excelbtn').show();
					break;
				case 201:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getCycletimedata?' + str;
					var url = '<?php echo base_url() ?>reports/cycletime?' + str;
					$('#excelbtn').show();
					break;
				case 202:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getCycletimedata?' + str;
					var url = '<?php echo base_url() ?>reports/cycletimeGroup?' + str;
					$('#excelbtn').show();
					break;
			    case 216: var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getcyclecountbargraph?' + str;
          			var url = '<?php echo base_url()?>reports/cyclecountbargraph?'+str;
          			$('#excelbtn').show();
          			break; 	
          	    case 217:
          	       var httpurl='<?php echo jquery_url()?>reports_Groupdata/getChartdelayData?'+str;
          	        var url='<?php echo base_url()?>reports/delayreport?'+str;
          	        $('#excelbtn').show();
          	        break;	
          	     case 218:
          	       var httpurl='<?php echo jquery_url()?>reports_Groupdata/getsummarydata?'+str;
          	        var url='<?php echo base_url()?>reports/summaryreport?'+str;
          	        $('#excelbtn').show();
          	        break;	 
          	      case 219:
          	       var httpurl='<?php echo jquery_url()?>reports_Groupdata/getbfprod_smsreceived?'+str;
          	        var url='<?php echo base_url()?>reports/bfprod_Smsreceived?'+str;
          	        // $('#excelbtn').show();
          	        break;	
          	         case 220:
          	         var httpurl='<?php echo jquery_url()?>reports_Groupdata/gettlctracking?'+str;
          	        var url='<?php echo base_url()?>reports/tlctracking?'+str;
          	         $('#excelbtn').show();
          	        break;	       		
				case 203:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getIdleTimedata?' + str + '&circulation=1';
					var url = '<?php echo base_url() ?>reports/idletime?' + str + '&circulation=1';
					$('#excelbtn').show();
					break;
				case 204:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getIdleTimedata?' + str + '&circulation=1';
					var url = '<?php echo base_url() ?>reports/idletimeGroup?' + str + '&circulation=1';
					$('#excelbtn').show();
					break;
				case 205:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getIdleTimedata?' + str + '&circulation=0';
					var url = '<?php echo base_url() ?>reports/idletime?' + str + '&circulation=0';
					$('#excelbtn').show();
					break;
				case 206:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getIdleTimedata?' + str + '&circulation=0';
					var url = '<?php echo base_url() ?>reports/idletimeGroup?' + str + '&circulation=0';
					$('#excelbtn').show();
					break;
				case 207:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getMaintenancedata?' + str;
					var url = '<?php echo base_url() ?>reports/maintenance?' + str;
					$('#excelbtn').show();
					break;
				case 208:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getMaintenancedata?' + str;
					var url = '<?php echo base_url() ?>reports/maintenanceGroup?' + str;
					$('#excelbtn').show();
					break;
				case 209:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleConditiondata?' + str;
					var url = '<?php echo base_url() ?>reports/ladleConditionGroup?' + str;
					$('#excelbtn').show();
					break;
				case 210:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleLifedata?' + str;
					var url = '<?php echo base_url() ?>reports/ladleLifeGroup?' + str;
					$('#excelbtn').show();
					break;
				case 42:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getDistanceRun?' + str;
					var url = '<?php echo base_url() ?>reports/distancerun?' + str;
					$('#excelbtn').show();
					break;
				case 25:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getDistanceRun?' + str;
					var url = '<?php echo base_url() ?>reports/distancerunGroup?' + str;
					$('#excelbtn').show();
					break;
				case 13:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getBreakdown?' + str;
					var url = '<?php echo base_url() ?>reports/breakdownGroup?' + str;
					$('#excelbtn').show();
					break;
				case 31:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLogisticIssue?' + str;
					var url = '<?php echo base_url() ?>reports/issuesGroup?' + str;
					$('#excelbtn').show();
					break;
				case 12:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getTorpedoStatus?' + str;
					var url = '<?php echo base_url() ?>reports/statusGroup?' + str;
					$('#excelbtn').show();
					break;
				case 212:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getSMSReportdata?' + str;
					var url = '<?php echo base_url() ?>reports/SMSHM_group?' + str;
					$('#excelbtn').show();
					break;
				case 213:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getEmergencySignalReportdata?' + str;
					var url = '<?php echo base_url() ?>reports/Emergency_group?' + str;
					$('#excelbtn').show();
					break;
				case 214:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getSMSDelayReportdata?' + str;
					var url = '<?php echo base_url() ?>reports/Smsdelay_group?' + str;
					$('#excelbtn').show();
					break;
				case 215:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getWeighmentReportdata?' + str;
					var url = '<?php echo base_url() ?>reports/Weighment_group?' + str;
					$('#excelbtn').show();
					break;
				case 8:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getDumpDetails?' + str;
					var url = '<?php echo base_url() ?>reports/dumpGroup?' + str;
					$('#excelbtn').show();
					break;

				case 40:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getNonCycleDetails?' + str;
					var url = '<?php echo base_url() ?>reports/noncycleGroup?' + str;
					$('#excelbtn').show();
					break;
				case 41:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getChartData?' + str;
					var url = '<?php echo base_url() ?>reports/chartGroup?' + str;
					$('#excelbtn').show();
					break;
				case 43:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleReport?' + str;
					var url = '<?php echo base_url() ?>reports/bflaldeGroup?' + str;
					$('#excelbtn').show();
					break;
				case 44:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleStatusData?' + str;
					var url = '<?php echo base_url() ?>reports/ladlestatus_group?' + str;
					$('#excelbtn').show();
					break;
				case 301: 
					var httpurl = '<?php echo jquery_url()?>tatsummary?'+str;
					$('#excelbtn').show();
					break; 
				case 302: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/summary?'+str;
					$('#excelbtn').show();
					break; 
				case 303: 
					var httpurl = '<?php echo jquery_url()?>tatsummary?'+str;
					$('#excelbtn').show();
					break; 
				case 304: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/summary?'+str;
					$('#excelbtn').show();
					break; 
				case 305: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/breach_report?'+str;
					$('#excelbtn').show();
					break; 
				case 306: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/breach_report?'+str;
					$('#excelbtn').show();
					break; 
				default:
					var httpurl = '';
					var url = '';
					break;
			}
			
			var reportNo = parseInt($('#reportType').val());
			
			$("#error-msg").html("Please wait loading..");
			$("#alertbox").click();
			//alert(httpurl);
			// do http request to get our sample data - not using any framework to keep the example self contained.
			// you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
			
			if(reportNo != 301 && reportNo != 302 && reportNo != 303 && reportNo != 304 && reportNo != 305 && reportNo != 306){			
				var httpRequest = new XMLHttpRequest();
				httpRequest.open('GET', httpurl);
				httpRequest.send();
				httpRequest.onreadystatechange = function() {

					if (httpRequest.readyState == 4 && httpRequest.status == 200) {

						//console.log(httpRequest.responseText);
						httpResponse = JSON.parse(httpRequest.responseText);
						if (httpResponse.length > 0) {
							$("#clickok").click();
							$("#mainFrame").attr("src", url).show();
						} else {
							$('#excelbtn').hide();
							$("#error-msg").html("Reports are not available");
							//$("#alertbox").click();
						}
					}
				};
			}else{
				$("#clickok").click();
				console.log("it's here for excel");
				$("#mainFrame").attr("src", httpurl).show();
			}
		}


		function getExcelDetails() {


			if ($("#unit").val() == "") {
				$("#error-msg").html("All Fields are Mandatory");
				$("#alertbox").click();
				return;
			}

			if ($('#reportType').val() == "") {
				$("#error-msg").html("All Fields are Mandatory");
				$("#alertbox").click();
				return;
			} else if (parseInt($('#reportType').val()) == 1 || parseInt($('#reportType').val()) == 6 || parseInt($('#reportType').val()) == 72 ||
				parseInt($('#reportType').val()) == 201 || parseInt($('#reportType').val()) == 202 || parseInt($('#reportType').val()) == 2 ||
				parseInt($('#reportType').val()) == 203 || parseInt($('#reportType').val()) == 204 ||
				parseInt($('#reportType').val()) == 205 || parseInt($('#reportType').val()) == 206 ||
				parseInt($('#reportType').val()) == 42 || parseInt($('#reportType').val()) == 25 ||
				parseInt($('#reportType').val()) == 207 || parseInt($('#reportType').val()) == 208 || parseInt($('#reportType').val()) == 209 ||
				parseInt($('#reportType').val()) == 13 || parseInt($('#reportType').val()) == 31 || parseInt($('#reportType').val()) == 8 ||
				parseInt($('#reportType').val()) == 40 || parseInt($('#reportType').val()) == 41 || parseInt($('#reportType').val()) == 43 ||
				parseInt($('#reportType').val()) == 44 || parseInt($('#reportType').val()) == 212 || parseInt($('#reportType').val()) == 213 ||
				parseInt($('#reportType').val()) == 214 || parseInt($('#reportType').val()) == 215 ||
				parseInt($('#reportType').val()) == 215 || parseInt($('#reportType').val()) == 216 ||
				parseInt($('#reportType').val()) == 216 || parseInt($('#reportType').val()) == 217||
				parseInt($('#reportType').val()) == 217 || parseInt($('#reportType').val()) == 218|| parseInt($('#reportType').val()) == 219|| parseInt($('#reportType').val()) == 220) {

				if ($("#start_date").val() == "" || $('#start_time').val() == "" || $('#end_date').val() == "" || $('#end_time').val() == "") {
					$("#error-msg").html("All Fields are Mandatory");
					$("#alertbox").click();
					return;
				} else {
					var timeNow = new Date();
					var hours = timeNow.getHours();
					var minutes = timeNow.getMinutes();
					var tvalid = hours + ':' + minutes;

					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth() + 1;
					var y = date.getFullYear();
					var starttime = $('#start_time').val();
					var endtime = $('#end_time').val();
					var checkdate;
					if (m < 9)
						checkdate = d + '-0' + m + '-' + y;
					else
						checkdate = d + '-' + m + '-' + y;
					var str1 = $('#start_date').val();
					var str2 = $('#end_date').val();
					if (str2 == checkdate) {
						//alert(str2+"---"+str1);
						//alert(starttime +"----"+ endtime)
						if (endtime > tvalid) {
							$('#end_time').val("");
							$("#error-msg").html("End Time should be less than current time");
							$("#alertbox").click();
							return;
						} else if (str2 == str1 && starttime >= endtime) {
							$('#end_time').val("");
							$("#error-msg").html("End Time should be greater than Start Time");
							$("#alertbox").click();
							return;
						}
					}
					//alert(checkTimeDiff() > 0);
					//alert((parseInt($('#reportType').val()) == 94 || parseInt($('#reportType').val()) == 98))
					if (checkTimeDiff() > 7 && (parseInt($('#reportType').val()) == 1)) {
						$("#error-msg").html("You Can Generate 1 day Report Only");
						$("#alertbox").click();
						return;
					} else if (checkTimeDiff() > 0 && (parseInt($('#reportType').val()) == 2)) {
						$("#error-msg").html("You Can Generate 1 day Report Only");
						$("#alertbox").click();
						return;
					}
					//else if(checkdays() == 0){

					//}
				}

			} else if (parseInt($('#reportType').val()) == 14 || parseInt($('#reportType').val()) == 20 || parseInt($('#reportType').val()) == 66 ||
				parseInt($('#reportType').val()) == 57 || parseInt($('#reportType').val()) == 60 || parseInt($('#reportType').val()) == 71) {
				if ($("#start_date").val() == "" || $('#end_date').val() == "") {
					$("#error-msg").html("All Fields are Mandatory");
					$("#alertbox").click();
					return;
				}
			}


			if (parseInt($('#reportType').val()) == 24 && !$("#oneMin").is(":checked") && !$("#fiveMin").is(":checked") && !$("#tenMin").is(":checked") &&
				!$("#fifteenMin").is(":checked") && !$("#thirtyMin").is(":checked") && !$("#sixtyMin").is(":checked")) {
				$("#error-msg").html("Please Select Time Interval");
				$("#alertbox").click();
				return;
			} else if (parseInt($('#reportType').val()) == 7) {
				if (!$("#idleCheck").is(":checked")) {
					$("#error-msg").html("Please Select Idle Time");
					$("#alertbox").click();
					return;
				} else if ($('#hrs').val() == "00" && $('#min').val() == "00" && $('#sec').val() == "00") {
					$("#error-msg").html("Please Select Idle Time");
					$("#alertbox").click();
					return;
				}
			} else if ((parseInt($('#reportType').val()) == 52 || parseInt($('#reportType').val()) == 53 || parseInt($('#reportType').val()) == 55 ||
					parseInt($('#reportType').val()) == 56 || parseInt($('#reportType').val()) == 57) && $("#checkAuto").is(":checked")) {
				$("#error-msg").html("This Report is available for single group. Please select the single group");
				$("#alertbox").click();
				return;
			}

			var orgstr = $("#form-validate").serialize();
			var str = orgstr + "&type=json";
			switch (parseInt($('#reportType').val())) {
				case 1:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getMovementdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_data/getMovementdata?' + orgstr + '&unitname=' + $("#hidunit").val();
					break;

				case 2:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getMovementdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getMovementdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;

				case 6:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getGeoModifieddata?' + str + '&circulation=' + document.getElementById("mainFrame").contentWindow.circ + '&geoid=' + document.getElementById("mainFrame").contentWindow.geoid;
					var url = '<?php echo jquery_url() ?>reports_data/getGeoModifieddata?' + orgstr + '&unitname=' + $("#hidunit").val() + '&circulation=' + document.getElementById("mainFrame").contentWindow.circ + '&geoid=' + document.getElementById("mainFrame").contentWindow.geoid;
					break;

				case 201:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getCycletimedata?' + str;
					var url = '<?php echo jquery_url() ?>reports_data/getCycletimedata?' + orgstr + '&unitname=' + $("#hidunit").val();
					break;

				case 72:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getGeoModifieddata?' + str + '&circulation=' + document.getElementById("mainFrame").contentWindow.circ + '&geoid=' + document.getElementById("mainFrame").contentWindow.geoid;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getGeoModifieddata?' + orgstr + '&circulation=' + document.getElementById("mainFrame").contentWindow.circ + '&groupname=' + $("#hidgroup").val() + '&geoid=' + document.getElementById("mainFrame").contentWindow.geoid;
					break;

				case 202:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getCycletimedata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getCycletimedata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;	
					case 216:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getcyclecountbargraph?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getcyclecountbargraph?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;	
					case 217:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getChartdelayData?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getChartdelayData?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
					case 218:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getsummarydata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getsummarydata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
					case 219:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getbfprod_smsreceived?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getbfprod_smsreceived?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
					case 220:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/gettlctracking?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/gettlctracking?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 203:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getIdleTimedata?' + str + '&circulation=1';
					var url = '<?php echo base_url() ?>reports_data/getIdleTimedata?' + orgstr + '&unitname=' + $("#hidunit").val() + '&circulation=1';
					break;
				case 204:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getIdleTimedata?' + str + '&circulation=1';
					var url = '<?php echo base_url() ?>reports_Groupdata/getIdleTimedata?' + orgstr + '&groupname=' + $("#hidunit").val() + '&circulation=1';
					break;
				case 205:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getIdleTimedata?' + str + '&circulation=0';
					var url = '<?php echo base_url() ?>reports_data/getIdleTimedata?' + orgstr + '&unitname=' + $("#hidunit").val() + '&circulation=0';
					break;
				case 206:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getIdleTimedata?' + str + '&circulation=0';
					var url = '<?php echo base_url() ?>reports_Groupdata/getIdleTimedata?' + orgstr + '&groupname=' + $("#hidunit").val() + '&circulation=0';
					break;
				case 207:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getMaintenancedata?' + str;
					var url = '<?php echo base_url() ?>reports_data/getMaintenancedata?' + orgstr + '&unitname=' + $("#hidunit").val();
					break;
				case 208:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getMaintenancedata?' + str;
					var url = '<?php echo base_url() ?>reports_Groupdata/getMaintenancedata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 209:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleConditiondata?' + str;
					var url = '<?php echo base_url() ?>reports_Groupdata/getLadleConditiondata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 210:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleLifedata?' + str;
					var url = '<?php echo base_url() ?>reports_Groupdata/getLadleLifedata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 42:
					var httpurl = '<?php echo jquery_url() ?>reports_data/getDistanceRun?' + str;
					var url = '<?php echo jquery_url() ?>reports_data/getDistanceRun?' + orgstr + '&unitname=' + $("#hidunit").val();
					break;
				case 25:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getDistanceRun?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getDistanceRun?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 13:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getBreakdown?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getBreakdown?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 31:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLogisticIssue?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getLogisticIssue?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 12:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getTorpedoStatus?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getTorpedoStatus?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 212:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getSMSReportdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getSMSReportdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 213:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getEmergencySignalReportdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getEmergencySignalReportdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 214:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getSMSDelayReportdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getSMSDelayReportdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 215:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getWeighmentReportdata?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getWeighmentReportdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 217:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getWeighmentReportdata?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 8:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getDumpDetails?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getDumpDetails?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 40:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getNonCycleDetails?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getNonCycleDetails?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 41:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getChartData?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getChartData?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 43:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleReport?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getLadleReport?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 44:
					var httpurl = '<?php echo jquery_url() ?>reports_Groupdata/getLadleStatusData?' + str;
					var url = '<?php echo jquery_url() ?>reports_Groupdata/getLadleStatusData?' + orgstr + '&groupname=' + $("#hidunit").val();
					break;
				case 301: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportReport?'+str;
					$('#excelbtn').show();
					break; 
				case 302: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportSummaryReport?'+str;
					$('#excelbtn').show();
					break; 
				case 303: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportReport?'+str;
					$('#excelbtn').show();
					break; 
				case 304: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportSummaryReport?'+str;
					$('#excelbtn').show();
					break; 
				case 305: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportBreachReport?'+str;
					$('#excelbtn').show();
					break; 
				case 306: 
					var httpurl = '<?php echo jquery_url()?>tatsummary/exportBreachReport?'+str;
					$('#excelbtn').show();
					break; 
				default:
					var httpurl = '';
					var url = '';
					break;
			}
			$("#error-msg").html("Please wait loading..");
			$("#alertbox").click();

			// do http request to get our sample data - not using any framework to keep the example self contained.
			// you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
			
			var reportNo = parseInt($('#reportType').val());
			console.log(reportNo);
			
			if(reportNo != 301 && reportNo != 302 && reportNo != 303 && reportNo != 304 && reportNo != 305 && reportNo != 306){	
				console.log("called");
				
				var httpRequest = new XMLHttpRequest();
				//alert(httpurl);
				httpRequest.open('GET', httpurl);
				httpRequest.send();
				httpRequest.onreadystatechange = function() {

					if (httpRequest.readyState == 4 && httpRequest.status == 200) {
						// $("#clickok").click();
						//alert(httpRequest.responseText);
						//alert(httpResponse.length);
						httpResponse = JSON.parse(httpRequest.responseText);
						//alert(httpResponse);
						if (httpResponse.length > 0) {
							$("#clickok").click();
							$("#form-validate").prop("action", url);
							$("#form-validate").submit();
						} else {
							$("#error-msg").html("Reports are not available");
							//$("#alertbox").click();
						}
					}
				};
			}else{
				$("#clickok").click();
				$("#form-validate").prop("action", httpurl);
				$("#form-validate").submit();
			}
		}
	</script>

	<script src="<?php echo asset_url(); ?>js/jquery.js"></script>
	<script src="<?php echo asset_url(); ?>js/moment.js"></script>
	<script src="<?php echo asset_url(); ?>js/jquery.datetimepicker.full.js"></script>

	<script type="text/javascript">
		var $j = jQuery.noConflict();
		$j(document).ready(function() {

			$j.datetimepicker.setLocale('en');

			setdatepicker();
		});

		function checkdays() {
			var start_date = $j('#start_date').val();
			var end_date = $j('#end_date').val();
			start_date = start_date.split("-");
			end_date = end_date.split("-");
			if (start_date.length > 1) {
				var a = moment(start_date[1] + "/" + start_date[0] + "/" + start_date[2], 'M/D/YYYY');
				var b = moment(end_date[1] + "/" + end_date[0] + "/" + end_date[2], 'M/D/YYYY');
				var diffDays = b.diff(a, 'days');

				return diffDays;

			} else {
				return -1;
			}
		}

		function checkTimeDiff() {
			var start_date = $j('#start_date').val();
			var end_date = $j('#end_date').val();
			var start_time = $j('#start_time').val();
			var end_time = $j('#end_time').val();
			start_date = start_date.split("-");
			end_date = end_date.split("-");
			//start_date = start_date.split("-");
			//end_date = end_date.split("-");
			if (start_date.length > 1) {
				var a = moment(start_date[1] + "/" + start_date[0] + "/" + start_date[2] + " " + start_time, 'M/D/YYYY HH:mm');
				var b = moment(end_date[1] + "/" + end_date[0] + "/" + end_date[2] + " " + end_time, 'M/D/YYYY HH:mm');
				var diffDays = b.diff(a, 'days');
				return diffDays;

			} else {
				return 1;
			}
		}

		function setdatepicker() {

			$j('#start_date').datetimepicker({
				format: 'd-m-Y',
				formatDate: 'd-m-Y',
				timepicker: false,
				validateOnBlur: true,
				maxDate: 0,
				todayButton: true,
				value: "",
				onSelectDate: function(ct, $i) {
					$("#end_date").val("");
				}
			});
			$j('#end_date').datetimepicker({
				format: 'd-m-Y',
				formatDate: 'd-m-Y',
				timepicker: false,
				validateOnBlur: true,
				maxDate: 0,
				todayButton: true,
				value: "",
				onSelectDate: function(ct, $i) {
					var days = checkdays();
					if (days == -1 || days > 93) {
						$("#error-msg").html("You Can Generate Up To 90 Days Report Only ");
						$("#alertbox").click();
						$j('#end_date').val("");
					}
				}
			});

			$j('#start_time').datetimepicker({
				datepicker: false,
				format: 'H:i:s',
				formatTime: 'H:i:00',
				step: 30,
				validateOnBlur: true,
				defaultTime: '00:00:00',
				value: "00:00:00"
			});

			$j('#end_time').datetimepicker({
				datepicker: false,
				format: 'H:i:s',
				formatTime: 'H:i:00',
				step: 30,
				validateOnBlur: true,
				defaultTime: '00:00:00',
				value: "23:59:59"
			});
		}
	</script>

	<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

	<script type="text/javascript">
		var columnDefs = [


			//{headerName: "Entry Location", field: "tStartLoc", width:250, suppressFilter:true, cellClass: 'textAlignLeft', cellRenderer: addLink, onCellClicked: openWinMapStart},
			{
				headerName: "From Time",
				field: "tStartTime",
				width: 250,
				suppressFilter: true,
				cellClass: 'textAlign'
			},
			// {headerName: "Exit Location", field: "tEndLoc", width:250, suppressFilter:true, cellClass: 'textAlignLeft', cellRenderer: addLink, onCellClicked: openWinMapEnd},
			{
				headerName: "To Time",
				field: "tEndTime",
				width: 250,
				suppressFilter: true,
				cellClass: 'textAlign'
			},
			{
				headerName: "Geofence Area",
				field: "tGeoName",
				width: 270,
				suppressFilter: true,
				cellClass: 'textAlignLeft'
			},
			{
				headerName: "Time (min`s)",
				field: "timespent",
				width: 220,
				suppressFilter: true,
				cellClass: 'textAlign'
			},

		];

		var columnDefsGeo = [{
				headerName: "Group Name",
				field: "tGroupName",
				width: 130,
				suppressFilter: true,
				cellClass: 'textAlignLeft'
			},
			{
				headerName: "Ladle No.",
				field: "tUnitName",
				width: 130,
				suppressFilter: true,
				cellClass: 'textAlignLeft'
			},

			// {headerName: "Entry Location", field: "tStartLoc", width:220, suppressFilter:true, cellClass: 'textAlignLeft', cellRenderer: addLink, onCellClicked: openWinMapStart},
			{
				headerName: "From Time",
				field: "tStartTime",
				width: 220,
				suppressFilter: true,
				cellClass: 'textAlign'
			},
			// {headerName: "Exit Location", field: "tEndLoc", width:220, suppressFilter:true, cellClass: 'textAlignLeft', cellRenderer: addLink, onCellClicked: openWinMapEnd},
			{
				headerName: "To Time",
				field: "tEndTime",
				width: 220,
				suppressFilter: true,
				cellClass: 'textAlign'
			},
			{
				headerName: "Geofence Area",
				field: "tGeoName",
				width: 240,
				suppressFilter: true,
				cellClass: 'textAlignLeft'
			},
			{
				headerName: "Time (min`s)",
				field: "timespent",
				width: 200,
				suppressFilter: true,
				cellClass: 'textAlign'
			},

		];

		var gridOptions = {
			debug: true,
			enableServerSideSorting: true,
			enableServerSideFilter: false,
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

		var gridOptionsGeo = {
			debug: true,
			enableServerSideSorting: true,
			enableServerSideFilter: false,
			enableColResize: true,
			rowSelection: 'multiple',
			rowDeselection: true,
			overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
			columnDefs: columnDefsGeo,
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

		// setup the grid after the page has finished loading
		document.addEventListener('DOMContentLoaded', function() {
			var gridDiv = document.querySelector('#geo1Grid');
			new agGrid.Grid(gridDiv, gridOptions);

			gridDiv = document.querySelector('#GroupGeoGrid');
			new agGrid.Grid(gridDiv, gridOptionsGeo);

		});

		var datatoExport = [];

		function setRowData(allOfTheData, grid) {
			// give each row an id
			allOfTheData.forEach(function(data, index) {
				data.id = (index + 1);
			});

			var dataSource = {
				rowCount: null, // behave as infinite scroll
				getRows: function(params) {
					console.log('asking for ' + params.startRow + ' to ' + params.endRow);
					onBtShowLoading(grid);
					// At this point in your code, you would call the server, using $http if in AngularJS.
					// To make the demo look real, wait for 500ms before returning
					setTimeout(function() {
						// take a slice of the total rows
						var dataAfterSortingAndFiltering = sortAndFilter(allOfTheData, params.sortModel, params.filterModel, grid);
						datatoExport = dataAfterSortingAndFiltering;
						var rowsThisPage = dataAfterSortingAndFiltering.slice(params.startRow, params.endRow);
						// if on or after the last page, work out the last row.
						var lastRow = -1;
						if (dataAfterSortingAndFiltering.length <= params.endRow) {
							lastRow = dataAfterSortingAndFiltering.length;
						}
						// call the success callback
						params.successCallback(rowsThisPage, lastRow);

						onBtHide(grid);
					}, 50);
					onBtHide(grid);
				}
			};

			grid.api.setDatasource(dataSource);
			//setGridHeight();
			//applyOdoClass();
		}

		function onBtShowLoading(grid) {
			grid.api.showLoadingOverlay();
		}

		function onBtHide(grid) {
			grid.api.hideOverlay();
		}

		function sortAndFilter(allOfTheData, sortModel, filterModel, grid) {
			return sortData(sortModel, filterData(filterModel, allOfTheData), grid)
		}

		function sortData(sortModel, data, grid) {
			var sortPresent = sortModel && sortModel.length > 0;
			if (!sortPresent) {
				return data;
			}
			// do an in memory sort of the data, across all the fields
			var resultOfSort = data.slice();
			resultOfSort.sort(function(a, b) {
				for (var k = 0; k < sortModel.length; k++) {
					var sortColModel = sortModel[k];
					var cold = grid.columnApi.getColumn(sortColModel.colId);
					//console.log(cold.filter);
					var valueA = a[sortColModel.colId];
					var valueB = b[sortColModel.colId];
					// this filter didn't find a difference, move onto the next one
					if (valueA == valueB) {
						continue;
					}
					if (valueA === null) {
						valueA = "";
					}

					if (valueB === null) {
						valueB = "";
					}
					var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
					if (cold.filter == "number") {
						if (valueA == 'N/A' || valueA === null) {
							valueA = 0;
						}
						if (valueB == 'N/A' || valueB === null) {
							valueB = 0;
						}
						if (sortDirection == 1) {
							//  console.log("asc");
							return parseFloat(valueA) - parseFloat(valueB);
						} else if (sortDirection == -1) {
							//  console.log("desc");
							return parseFloat(valueB) - parseFloat(valueA);
						}
					} else if (valueA.toLowerCase() > valueB.toLowerCase()) {
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

		function filterData(filterModel, data) {
			return data;
		}

		function addLink(params) {
			var value = params.value;
			if (value == "") {
				return "NA";
			} else {
				return '<a align="left" title="Click to see this location on Map!" style="text-decoration:underline;color:blue">' + params.value + '</a>';
			}
		}

		function fillGrid(circulation) {
			if (circulation == 1) {
				$("#georeportName").html("Circulation Georeport Information");
			} else {
				$("#georeportName").html("Non-Circulation Georeport Information");
			}
			onBtShowLoading(gridOptions);
			$(".unitname").html($("#hidunit").val());
			$(".reportType").html($("#reportType option:selected").text());
			$(".period").html($("#start_date").val() + " " + $("#start_time").val() + " To " + $("#end_date").val() + " " + $("#end_time").val());
			var str = $("#form-validate").serialize();
			str = str + "&circulation=" + circulation + "&type=json&geoid=" + document.getElementById('mainFrame').contentWindow.geoid;
			// do http request to get our sample data - not using any framework to keep the example self contained.
			// you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
			var httpRequest = new XMLHttpRequest();
			//alert('<?php echo jquery_url() ?>reports_data/getGeoModifieddata?'+str);
			httpRequest.open('GET', '<?php echo jquery_url() ?>reports_data/getGeoModifieddata?' + str);
			httpRequest.send();
			httpRequest.onreadystatechange = function() {
				if (httpRequest.readyState == 4 && httpRequest.status == 200) {
					//console.log(httpRequest.responseText);
					httpResponse = JSON.parse(httpRequest.responseText);

					setRowData(httpResponse, gridOptions);
					// setGridHeight();            
				}
			};
		}

		function fillGroupGeoGrid(circulation) {
			if (circulation == 1) {
				$("#geogroupreportName").html("Circulation Georeport Information");
			} else {
				$("#geogroupreportName").html("Non-Circulation Georeport Information");
			}
			onBtShowLoading(gridOptionsGeo);
			$(".unitname").html($("#hidgroup").val());
			$(".reportType").html($("#reportType option:selected").text());
			$(".period").html($("#start_date").val() + " " + $("#start_time").val() + " To " + $("#end_date").val() + " " + $("#end_time").val());
			var str = $("#form-validate").serialize();
			//str = str+"&type=json&geoid="+document.getElementById('mainFrame').contentWindow.geoid;
			str = str + "&circulation=" + circulation + "&type=json&geoid=" + document.getElementById('mainFrame').contentWindow.geoid;
			// do http request to get our sample data - not using any framework to keep the example self contained.
			// you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
			var httpRequest = new XMLHttpRequest();
			//alert('<?php echo jquery_url() ?>reports_Groupdata/getGeoModifieddata?'+str);
			httpRequest.open('GET', '<?php echo jquery_url() ?>reports_Groupdata/getGeoModifieddata?' + str);
			httpRequest.send();
			httpRequest.onreadystatechange = function() {
				if (httpRequest.readyState == 4 && httpRequest.status == 200) {
					//console.log(httpRequest.responseText);
					httpResponse = JSON.parse(httpRequest.responseText);

					setRowData(httpResponse, gridOptionsGeo);
					// setGridHeight();            
				}
			};
		}

		var winref;

		function openWinMapStart(params) {
			if (winref) {
				winref.close();
			}
			var setUnit = $('#hidunit').val();
			var setReport = $("#reportType option:selected").text();
			var latArr = new Array();
			var lonArr = new Array();
			var statArr = new Array();
			var dirArr = new Array();
			var locArr = new Array();
			var statusArr = new Array();
			var unitArr = new Array();
			var reportArr = new Array();
			var selectedRow = params.data;
			//console.log(params.data);
			setUnit = selectedRow.tUnitName;
			latArr.push(selectedRow.tStartLat);
			lonArr.push(selectedRow.tStartLon);
			statArr.push("geoStart");
			//dirArr.push(selectedRow.direction);
			locArr.push(selectedRow.tStartLoc.replace(/[&]/g, "%26"));
			statusArr.push("Geo Enter");
			unitArr.push(selectedRow.tUnitName);
			reportArr.push(selectedRow.tStartTime);

			locArr.push("_");
			statusArr.push("_");
			unitArr.push("_");
			reportArr.push("_");


			winref = window.open(src = "<?php echo base_url() ?>reports/reportmap?lati=" + latArr + "&long=" + lonArr +
				"&statusid=" + statArr + "&Unitname=" + setUnit +
				"&Reportname=" + setReport + "&locArr=" + locArr +
				"&statusArr=" + statusArr + "&unitArr=" + unitArr +
				"&reportArr=" + reportArr, width = "300",
				height = "200");

		}

		function openWinMapEnd(params) {
			if (winref) {
				winref.close();
			}
			var setUnit = $('#hidunit').val();
			var setReport = $("#reportType option:selected").text();
			var latendArr = new Array();
			var lonendArr = new Array();
			var statendArr = new Array();
			var locArr = new Array();
			var statusArr = new Array();
			var unitArr = new Array();
			var reportArr = new Array();
			var selectedRow = params.data;
			//console.log(params.data);
			setUnit = selectedRow.tUnitName;
			latendArr.push(selectedRow.tEndLat);
			lonendArr.push(selectedRow.tEndLon);
			statendArr.push("geoEnd");
			//dirArr.push(selectedRow.direction);
			locArr.push(selectedRow.tEndLoc.replace(/[&]/g, "%26"));
			statusArr.push("Geo Exit");
			unitArr.push(selectedRow.tUnitName);
			reportArr.push(selectedRow.tEndTime);

			locArr.push("_");
			statusArr.push("_");
			unitArr.push("_");
			reportArr.push("_");


			winref = window.open(src = "<?php echo base_url() ?>reports/reportmap?lati=" + latendArr + "&long=" +
				lonendArr + "&statusid=" + statendArr + "&Unitname=" +
				setUnit + "&Reportname=" + setReport + "&locArr=" +
				locArr + "&statusArr=" + statusArr + "&unitArr=" +
				unitArr + "&reportArr=" + reportArr, width = "300",
				height = "200");

		}
	</script>


</body>

</html>
