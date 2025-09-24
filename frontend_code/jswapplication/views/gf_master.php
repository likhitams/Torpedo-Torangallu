<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php echo title; ?></title>

		<link href="<?php echo asset_url() ?>css/style.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
		<link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>css/jquery-ui.min.css" rel="stylesheet" />
		<link href="<?php echo asset_url() ?>css/icons.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>css/app.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/jquery.datetimepicker.css" />
		<link href="<?php echo asset_url() ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo asset_url() ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/ag-grid.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>dist/styles/theme-blue.css" />
		<?php 
			echo $updatelogin;
			$role = $detail[0]->userRole; 
		?>
		<style>
		.ag-row .ag-cell {
		  display: flex;
		  justify-content: center; /* align horizontal */
		  align-items: center;
		}
		</style>
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

		<div class="page-content">
			<div class="container-fluid">
				<div class="card mt-4">
					<form id="frm">
						<div class="card-body">
							<h4  align="center">Update Geofence Threshold Interval & Is Entry-Exit : </h4>
							<div id="myGrid" style="height: 400px ;" class="ag-blue"></div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
		<script src="<?php echo asset_url() ?>js/bootstrap.js"></script>
		<?php echo $jsfile; ?>
		<script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<?php echo $jsfileone; ?>
		<script type="text/javascript">
		var h;
		$(document).ready(function() {
            h = $(document).height() - 170;
			
			var columnDefs = [
				{
					headerName: "SL No.",
					valueGetter: "node.rowIndex + 1",
					width: 50,
					cellStyle: {justifyContent: "right"},
				},
				{
					headerName: "Geofence",
					field: "geofence",
					//width: 675,
					cellStyle: {justifyContent: "left"},
				},
				{
					headerName: "Threshold Time",
					field: "threashold",
					//width: 675,
					cellClass: 'textAlignLeft',
					cellRenderer: (data) => { 
						var inpThreashold = "<input name='threashold[]' value='"+data.value+"' min='0' placeholder='Threashold Interval in Min.' type='number' class='form-control inp_ti'>"
						return inpThreashold;
					}
				},
				{
					headerName: "Entry / Exit ?",
					field: "entry_exit",
					width: 85,
					cellClass: 'textAlign',
					cellRenderer: (data) => { 
						var chk = parseInt(data.value) == 1?"checked":"";
						var inpEntryExit = "<label><input name='entry_exit[]' "+chk+" type='checkbox' value='1' class='inp_ee'>&nbsp;&nbsp;Yes</label>";
						return inpEntryExit;
					}
				},
				{
					headerName: "Action",
					field: "gf_no",
					width: 80,
					cellClass: 'textAlign',
					cellRenderer: (data) => { 
						return "<input type='hidden' name='gf_no[]' value='"+data.value+"'><button dt-gfn='"+data.value+"' type='button' class='btn btn-sm btn-success btnUpdateInd'>Update</button>";
					}
				}
			];
			
			var gridOptions = {
				debug: true,
				enableServerSideSorting: true,
				enableServerSideFilter: false,
				enableColResize: true,
				//rowSelection: 'multiple',
				rowDeselection: true,
				overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
				columnDefs: columnDefs,
				rowModelType: 'infinite',
				paginationPageSize: 100,
				paginationOverflowSize: 2,
				maxConcurrentDatasourceRequests: 2,
				paginationInitialRowCount: 0,
				maxPagesInCache: 2,
				getRowNodeId: function(item) {
					return item.id;
				}
			};
			gridOptions.rowHeight = 45;
			
			var gridDiv = document.querySelector('#myGrid');
            new agGrid.Grid(gridDiv, gridOptions);
            
			setList();
			
			function setList() {
				$.ajax({
					// url: '<?= base_url("maintenance/get_gfList"); ?>',
					url:"<?php echo jquery_url();?>maintenance/get_gfList",

					dataType: 'json',
					success: function(data) {
						setRowData(data);
					}
				});
			}
			
			var datatoExport = [];

			function setRowData(allOfTheData) {
				// give each row an id
				allOfTheData.forEach(function(data, index) {
					data.id = (index + 1);
				});

				var dataSource = {
					rowCount: null, // behave as infinite scroll
					getRows: function(params) {
						console.log('asking for ' + params.startRow + ' to ' + params.endRow);
						//onBtShowLoading();
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

							//onBtHide();
						}, 50);
						//onBtHide();
					}
				};

				gridOptions.api.setDatasource(dataSource);
				setGridHeight();
			}
			
			function setGridHeight() {
				$("#myGrid").css("height", h + "px");
			}
			
			function sortAndFilter(allOfTheData, sortModel, filterModel) {
				return sortData(sortModel, filterData(filterModel, allOfTheData))
			}

			function sortData(sortModel, data) {
				var sortPresent = sortModel && sortModel.length > 0;
				if (!sortPresent) {
					return data;
				}
				// do an in memory sort of the data, across all the fields
				var resultOfSort = data.slice();
				resultOfSort.sort(function(a, b) {
					for (var k = 0; k < sortModel.length; k++) {
						var sortColModel = sortModel[k];
						var cold = gridOptions.columnApi.getColumn(sortColModel.colId);
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
			
			$(document).on("click",".btnUpdateInd",function(e){
				var currRow 		= $(this).closest(".ag-row");
				var gf_no           = $(this).attr("dt-gfn");
				var threashold_time = currRow.find(".inp_ti").val().trim() == ""?0:currRow.find(".inp_ti").val().trim();
				var is_entry_exit   = currRow.find(".inp_ee").is(":checked")?1:0;
				
				threashold_time     = parseInt(threashold_time);
				
				if(is_entry_exit && threashold_time <= 0){
					$.notify("Enter Threashold Interval","error");
				}else{
					$.ajax({
						type: "POST",
						//url: '<?= base_url("maintenance/updateGfData"); ?>',
                                        	url:"<?php echo jquery_url();?>maintenance/updateGfData",

						data: {"gf_no":gf_no,"threashold_time":threashold_time,"entry_exit":is_entry_exit},
						dataType: 'json',
						success: function(res) {
							if(res.status == "success"){
								$.notify(res.message,"success");
							}else{								
								$.notify(res.message,"error");
							}
						}
					});
				} 
			});
			
			$(document).on("click","#btnUpdateBlk",function(e){
				let rowData = [];
				gridOptions.api.forEachNode(node => rowData.push(node.data));
				
				var formData = $("#frm").serialize();
				var ind 	 = 0;
				var extraPar = "";
				rowData.forEach(function(i,obj){
					var ee = $(".inp_ee:nth-child("+ind+")").is(":checked")?1:0;
					extraPar += "&entry_exit[]="+ee;
					
					ind++;
				});
				
				$.ajax({
					type: "POST",
					url: '<?= base_url("maintenance/updateGfDataBulk"); ?>',
					data: formData+extraPar,
					dataType: 'json',
					success: function(res) {
						if(res.status == "success"){
							$.notify(res.message,"success");
						}else{								
							$.notify(res.message,"error");
						}
					}
				}); 
			});
        });
		</script>
	</body>
</html>
