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
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url() ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />



	<?php echo $updatelogin;
	$role = $detail[0]->userRole;
	?>

	<style type="text/css">
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

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
					<button type="button" class="btn btn-dark" data-dismiss="modal"><i class="far fa-check-circle"></i> &nbsp;OK</button>

				</div>
			</div>
		</div>
	</div>


	<?php echo $header; ?>

	<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
					<h4 class="modal-title" id="newModalLabel">Delay Details</h4>
				</div>
				<div class="modal-body">

					<form class="form-inline" id="form-validate">


						<input type="hidden" class="form-control driverClass" name="oid" id="oid">


						<div class="form-group">
							<label class="col-md-4">Loco Number</label>
							<span class="col-md-8">
								<input type="text" class="form-control driverClass" name="loconumber" id="loconumber">
							</span>
						</div>

						<div class="form-group">
							<label class="col-md-4">Date</label>
							<span class="col-md-8">
								<div class='input-group date date-picker1'>
									<input type='text' class="form-control driverClass" name="date" id="date" />
									<span class="input-group-addon cal-icon" onclick="$('#date').focus();">
										<span class="fa-regular fa-calendar"></span>
									</span>
								</div>
							</span>
						</div>

						<div class="form-group">
							<label class="col-md-4">Shift</label>
							<span class="col-md-8">
								<input type="text" class="form-control driverClass" name="shift" id="shift">
							</span>
						</div>

						<div class="form-group">
							<label class="col-md-4">Cause of Delay</label>
							<span class="col-md-8">
								<input type="text" class="form-control driverClass" name="delaycause" id="delaycause">
							</span>
						</div>

						<div class="form-group">
							<label class="col-md-4">Duration</label>
							<span class="col-md-8">
								<input type="text" class="form-control driverClass" name="duration" id="duration">
							</span>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-dark closeButton newButton" data-dismiss="modal" id="closeButton"><i class="fa-solid fa-xmark"></i> CLOSE</button>
					<button type="button" id="resetButton" class="btn btn-danger resetButton newButton"><i class="fa fa-repeat"></i> RESET</button>
					<button type="button" id="saveButton" class="btn btn-success newButton"><i class="fa-solid fa-check"></i> SAVE</button>

					
					<button type="button" class="btn btn-dark closeButton updateButton" data-dismiss="modal" id="closeButton"><i class="fa-solid fa-xmark"></i> CLOSE</button>
					<button type="button" id="resetButton" class="btn btn-danger resetButton updateButton"><i class="fa fa-repeat"></i> RESET</button>
					<button type="button" id="esaveButton" class="btn btn-success updateButton"><i class="fa-solid fa-check"></i> SAVE</button>


					<div id="msg_box"></div>
				</div>
			</div>
		</div>
	</div>
	<button data-toggle="modal" data-target="#newModal" style="display: none;" id="editbox"></button>



	<div class="page-content">
		<div class="container-fluid">

			<div class="card mt-4">

				<div class="card-body">
					<h2>Logistic Issues Details</h2>
					<div class="table-responsive">
						<div id="myGrid" style="width: 100%; height: 450px ;" class="ag-blue"></div>
					</div>
					<?php if ($detail[0]->userRole == 'c' || $detail[0]->userRole == 'a') { ?>
						<div class="fixed_footer">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newModal" onclick="$('.newButton').show();setDatepicker();$('.updateButton').hide();"><i class="fa-solid fa-plus"></i> NEW</button>
							<button type="button" class="btn btn-info" onclick="modifyDelay();setDatepicker();"><i class="fa-solid fa-pencil"></i> MODIFY</button>
							<button type="button" class="btn btn-dark" onclick="deleteDelay();"><i class="fa-solid fa-trash"></i> DELETE</button>
							<button class="btn btn-success btn-min" type="button" title="Download Excel" onclick="convertdata();"><i class="fa-solid fa-file-excel"></i> DOWNLOAD EXCEL</button>
							<!--  <button type="button" class="btn btn-warning btn-reset" onclick="resetDetails();">RESET</button> -->
						</div>
					<?php } ?>
				</div>



				<div id="contextMenu" style="z-index: 999;display: none;position: fixed;background-color: #fff;overflow: hidden;height: auto;">
					<ul id="contextDropDown">
						<li onclick='remarks();'>View</li>
					</ul>
				</div>

			</div>
		</div>
	</div>

					</div>
			<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
			<script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
			<?php echo $jsfileone; ?>
			<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css">
			<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css">

			<script src="<?php echo asset_url(); ?>js/jquery.validationEngine.js"></script>
			<script src="<?php echo asset_url(); ?>js/jquery.validationEngine-en.js"></script>
			
			<?php echo $jsfile; ?>
           <script src="<?php echo asset_url() ?>js/bootstrap.js"></script>
           <script src="<?php echo asset_url(); ?>js/jquery.validate.min.js"></script>

			<script type="text/javascript">
				var selectedRows = new Array();

				function resetDetails() {
					gridOptions.api.deselectAll();
					selectedRows = new Array();
				}


				var empty_string = /^\s*$/;
				var h;
				$(document).ready(function() {
					h = $(document).height() - 160;
					$('#myGrid').on('click', ".ag-row", function(evt) {
						$("#contextMenu").hide();
					});

					$.validator.addMethod('onlyAlpha', function(value, element, param) {
						//Your Validation Here
						//alert(/[a-zA-Z]$/.test( value ));
						return /[a-zA-Z]$/.test(value); // return bool here if valid or not.
					}, 'Invalid Input');


					var v = $("#form-validate").validate({

						errorClass: "help-block",
						errorElement: 'span',
						onkeyup: false,
						onblur: false,
						onfocusout: function(element) {
							this.element(element);
						},
						rules: {
							contactNo: {
								number: true
							},
							altcontactNo: {
								number: true
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

					var v1 = $("#eform-validate").validate({

						errorClass: "help-block",
						errorElement: 'span',
						onkeyup: false,
						onblur: false,
						onfocusout: function(element) {
							this.element(element);
						},
						rules: {
							eunitName: 'required',
							econtactName: 'required',
							econtactNo: {
								number: true
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
					var empty_string = /^\s*$/;
					$("#saveButton").click(function(evt) {
						if (v.form()) {
							var vald = validateForm();
							if (vald) {
								$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
								var str = $("#form-validate").serialize();

								//alert(str);
								$.post("<?php echo jquery_url(); ?>maintenance/addDelay", str, function(data) {
									//alert(data);
									if (parseInt(data) == 1) {
										$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully. Please wait loading...</div>');
										window.setTimeout(function() {
											$(".closeButton").click();
										}, 1000);

										setList();
									} else {
										$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>' + data + '</div>');
									}

								});
							}


						}
					});

					function validateForm() {
						var loconumber = $("#loconumber").val();
						var date = $("#date").val();
						var shift = $("#shift").val();
						var delaycause = $("#delaycause").val();
						var duration = $("#duration").val();

						if (loconumber == "") {
							$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please Enter Loco Number</div>');
							return false;
						} else if (date == "") {
							$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please Enter Date</div>');
							return false;
						} else if (shift == "") {
							$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please Enter Shift</div>');
							return false;
						} else if (delaycause == "") {
							$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please Enter Delay Cause</div>');
							return false;
						} else if (duration == "") {
							$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please Enter Duration</div>');
							return false;
						} else {
							return true;
						}

					}

					$("#esaveButton").click(function(evt) {
						if (v.form()) {
							var vald = validateForm();
							if (vald) {
								$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
								var str = $("#form-validate").serialize();

								$.post("<?php echo jquery_url(); ?>maintenance/modifyDelay", str, function(data) {
									//alert(data);
									switch (data) {
										case "1":
											$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Modified Successfully. Please wait loading...</div>');
											window.setTimeout(function() {
												$(".closeButton").click();
											}, 1000);

											setList();
											break;

										default:
											$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>' + data + '</div>');
											break;
									}

								});
							}
						}
					});

					$(".closeButton").click(function(evt) {
						$(".resetButton").click();
						gridOptions.api.deselectAll();
						geoActualUnit = new Array();
					});

					$(".resetButton").click(function(evt) {
						$("#msg_box, #emsg_box").html('');
						$(".driverClass").val("");
						selectedRows = new Array();

						// alert(); 
					});


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
				var arra = new Array();
				var columnDefs = [{
						headerName: "id",
						field: "id",
						width: 0,
						hide: true
					},
					{
						headerName: "Loco No",
						field: "loconumber",
						width: 265,
						cellClass: 'textAlignLeft',
						filter: 'text',
						checkboxSelection: true
					},
					{
						headerName: "Date",
						field: "date",
						width: 265,
						cellClass: 'textAlign',
						filter: 'number',
						suppressFilter: true
					},
					{
						headerName: "Shift",
						field: "shift",
						width: 265,
						cellClass: 'textAlign',
						filter: 'text',
						suppressFilter: true,
						suppressSorting: true
					},
					{
						headerName: "Delay Cause",
						field: "delaycause",
						width: 265,
						cellClass: 'textAlign',
						filter: 'text',
						suppressFilter: true
					},
					{
						headerName: "Duration",
						field: "duration",
						width: 265,
						cellClass: 'textAlign',
						filter: 'text',
						suppressFilter: true
					}
				];

				var id = "",
					valatt = "";
				var gridOptions = {

					debug: true,
					enableServerSideSorting: true,
					enableServerSideFilter: true,
					enableColResize: true,
					rowSelection: 'multiple',
					rowDeselection: true,
					suppressRowClickSelection: true,
					overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
					columnDefs: columnDefs,
					rowModelType: 'infinite',
					paginationPageSize: 50,
					cacheOverflowSize: 2,
					maxConcurrentDatasourceRequests: 2,
					paginationInitialRowCount: 0,
					maxBlocksInCache: 2,
					getRowNodeId: function(item) {
						return item.id;
					},
					getRowStyle: getRowStyleScheduled
				};

				function getRowStyleScheduled(params) {
					// console.log("kkkk----"+params.data.invoice_no);
					if (params.data === undefined || params.data === null) {
						return false;
					} else if (params.data.cycleCompleted == "1") {
						return {
							'background-color': '#d6f5d6',
							//'color': '#fff'
						}
					}
					return null;


				};

				// setup the grid after the page has finished loading
				document.addEventListener('DOMContentLoaded', function() {
					var gridDiv = document.querySelector('#myGrid');
					new agGrid.Grid(gridDiv, gridOptions);
					setList();

				});

				function setGridHeight() {
					$("#myGrid").css("height", h + "px");
				}

				function onBtShowLoading() {
					gridOptions.api.showLoadingOverlay();
				}

				function onBtHide() {
					gridOptions.api.hideOverlay();
				}


				function setList() {
					onBtShowLoading();

					$.ajax({
						url: '<?php echo jquery_url() ?>maintenance/getLogisticdelay',
						dataType: 'json',
						success: function(data) {
							setRowData(data);
						}
					});

				}

				var datatoExport = [];

				function setRowData(allOfTheData) {
					// give each row an id
					/* allOfTheData.forEach( function(data, index) {
					     data.id = (index + 1);
					 });*/
					//$("#unitCount").html(allOfTheData.length);
					var dataSource = {
						rowCount: null, // behave as infinite scroll
						getRows: function(params) {
							console.log('asking for ' + params.startRow + ' to ' + params.endRow);
							onBtShowLoading();
							// At this point in your code, you would call the server, using $http if in AngularJS.
							// To make the demo look real, wait for 500ms before returning
							setTimeout(function() {
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
							onBtHide();
						}
					};

					gridOptions.api.setDatasource(dataSource);
					setGridHeight();
					//applyOdoClass();
				}

				function sortAndFilter(allOfTheData, sortModel, filterModel) {
					return sortData(sortModel, filterData(filterModel, allOfTheData))
				}

				function sortData(sortModel, data) {
					var sortPresent = sortModel && sortModel.length > 0;

					if (!sortPresent) {
						//console.log(sortPresent);
						return data;
					}
					// do an in memory sort of the data, across all the fields
					var resultOfSort = data.slice();
					// console.log(resultOfSort);
					resultOfSort.sort(function(a, b) {
						//console.log(a);
						//console.log(b);
						for (var k = 0; k < sortModel.length; k++) {
							var sortColModel = sortModel[k];
							// console.log(sortColModel);
							var cold = gridOptions.columnApi.getColumn(sortColModel.colId);
							//console.log(cold.filter);
							var valueA = a[sortColModel.colId];
							var valueB = b[sortColModel.colId];

							// console.log(valueA+"---"+valueB);
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
								if (valueA == 'N/A' || valueA === null || valueA === "") {
									valueA = 0;
								}
								if (valueB == 'N/A' || valueB === null || valueB === "") {
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

					var filterPresent = filterModel && Object.keys(filterModel).length > 0;

					var resultOfFilter = [];
					for (var i = 0; i < data.length; i++) {
						var item = data[i];

						if (filterPresent && filterModel.id) {
							var name = item.id;
							var allowedName = filterModel.id.filter;
							var flagName = checkNumLoop(filterModel.id.type, name.toLowerCase(), allowedName.toLowerCase());

							if (flagName == 1) {
								continue;
							}
						}


						resultOfFilter.push(item);
					}
					// $("#unitCount").html(resultOfFilter.length);
					return resultOfFilter;
				}


				function modifyDelay() {
					$('.newButton').hide();
					$('.updateButton').show();
					selectedRows = gridOptions.api.getSelectedRows();
					var selectedRowsString = '';
					var unitIds = new Array();

					if (selectedRows.length == 0) {
						$("#error-msg").html("Please select Loco Number to modify");
						$("#alertbox").click();
						return;
					}
					/*else if(selectedRows[0].cycleCompleted == "1"){
						$("#error-msg").html("Please select Ladle Number to modify");
						$("#alertbox").click();
						return;
					}*/
					else if (selectedRows.length == 1) {

						$("#oid").val(selectedRows[0].id);
						$("#loconumber").val(selectedRows[0].loconumber);
						$("#date").val(selectedRows[0].date);
						$("#shift").val(selectedRows[0].shift);
						$("#delaycause").val(selectedRows[0].delaycause);
						$("#duration").val(selectedRows[0].duration);
						//getSubmenu();

						$("#editbox").click();
					} else {
						$("#error-msg").html("Please select one record to modify");
						$("#alertbox").click();
					}
				}

				function deleteDelay() {
					var selectedRows = gridOptions.api.getSelectedRows();
					var selectedRowsString = '';
					var unitIds = new Array();
					if (selectedRows.length) {
						var r = confirm('Are you sure,you want to delete!');
						if (r == true) {
							//alert zapta;
							$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleting, please wait...</div>');
							selectedRows.forEach(function(selectedRow, index) {
								unitIds.push(selectedRow.id);
							});
							$.post("<?php echo base_url(); ?>maintenance/deleteDelay", {
								unitIds: unitIds
							}, function(data) {
								//alert(data);
								switch (parseInt(data)) {
									case 1:
										$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deleted Successfully.</div>');
										resetDetails();
										setList();
										break;
									default:
										$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Deletion not possible due to dependency</div>');
										break;
								}
							});
						}
					} else {
						$("#error-msg").html("Please select at least one record to delete");
						$("#alertbox").click();
					}
				}

				//Excel Import

				function createWorksheet() {
					//	Calculate cell data types and extra class names which affect formatting
					var cellType = [],
						title = "Logistic Issue Details";
					var cellTypeClass = [];
					var cm = gridOptions.columnApi.getAllDisplayedColumns();
					var totalWidthInPixels = 0;
					var colXml = '';
					var headerXml = '';
					var cnt = cm.length;
					for (var i = 0; i < cnt; i++) {

						var w = cm[i].colDef.width;
						totalWidthInPixels += w;
						colXml += '<ss:Column ss:AutoFitWidth="1" ss:Width="' + w + '" />';
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

					//		                Generate worksheet header details.
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
					var it = datatoExport,
						l = datatoExport.length;

					//		                Generate the data rows from the data in the Store
					for (var i = 0; i < l; i++) {
						t += '<ss:Row>';
						var cellClass = (i & 1) ? 'odd' : 'even';
						r = datatoExport[i];

						var k = 0;
						var recordval;

						for (var j = 0; j < cnt; j++) {

							var v = r[cm[j].colDef.field];
							v = v == null ? "" : v;

							t += '<ss:Cell ss:StyleID="' + cellClass + cellTypeClass[k] + '"><ss:Data ss:Type="' + cellType[k] + '">';
							switch (cm[j].colDef.field) {
								default:
									t += v;
									break;
							}

							t += '</ss:Data></ss:Cell>';
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
					return result;
				}

				function exporttoExcel() {
					var title = "Ladle Load Count Details";
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

				function convertdata() {
					//console.log(exporttoExcel());
					document.location = 'data:application/vnd.ms-excel;base64,' + base64_encode(exporttoExcel());
				}
			</script>

			<script src="<?php echo asset_url(); ?>js/jquery.js"></script>
			<script src="<?php echo asset_url(); ?>js/moment.js"></script>
			<script src="<?php echo asset_url(); ?>js/jquery.datetimepicker.full.js"></script>

			<script type="text/javascript">
				var $j = jQuery.noConflict();
				$j(document).ready(function() {

					$j.datetimepicker.setLocale('en');

				});


				function setDatepicker() {
					setDate();
				}

				function setDate() {

					$j('#date').datetimepicker({
						format: 'd-m-Y',
						formatDate: 'd-m-Y',
						//formatTime:'H:i',
						timepicker: false,
						validateOnBlur: true,
						maxDate: 0,
						//minDate:new Date(),
						todayButton: true,
						value: ""
					});


				}
			</script>

</body>

</html>