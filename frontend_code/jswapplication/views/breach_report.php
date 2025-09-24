<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title><?php echo title; ?></title>
      <link href="<?php echo asset_url();?>css/bootstrap.css" rel="stylesheet">
      <link href="<?php echo asset_url();?>css/style.css" rel="stylesheet">
      <link href="<?php echo asset_url();?>css/font-awesome.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	  
	  <?php echo $updatelogin; ?>
	  <style>
	  #dvReport {
		overflow-x: scroll;
		width: 100%;;
	  }

	  .tbl-dvdr:last-child {
		border-bottom: none;
	  }
	  
	  #lbl-sts {
			font-size: 17px;
			text-align: center;
			font-weight: 500;
	  }
	  
	  .tbl-rprt th{
		  background: #5b9bd5;
		  color: white;
		  border: 1px solid #9bc2e6 !important;
		  white-space: nowrap;
		  padding: 10px !important;
	  }
	  
	  .tbl-rprt td{
		  border: 1px solid #9bc2e6 !important;
		  white-space: nowrap;
		  padding: 10px !important;
	  }
  
	  .td-hdn{
		  display: none;
	  }
	  
	  .hdn{
		  display: none !important;
	  }
	  </style>
   </head>
   <body class="dark-sidenav">
      
	  <div class="container-fluid">
		<div id='lbl-sts'></div>
		<br><div id="myGrid" style="height: 400px ;" class="ag-blue"></div>
	  </div> 
	 
 	  <input type="hidden" id="unit" value="<?php echo isset($ladle_no)?$ladle_no:""; ?>" />
 	  <input type="hidden" id="start_date" value="<?php echo isset($start_date)?$start_date:""; ?>" />
	  <input type="hidden" id="end_date" value="<?php echo isset($end_date)?$end_date:""; ?>" />
	  <input type="hidden" id="start_time" value="<?php echo isset($start_time)?$start_time:""; ?>" />
	  <input type="hidden" id="end_time" value="<?php echo isset($end_time)?$end_time:""; ?>" />
	  <input type="hidden" id="is_refill" value="<?php echo isset($is_refill)?$is_refill:""; ?>" />
	  <input type="hidden" id="mt_type" value="<?php echo isset($mt_type)?$mt_type:""; ?>" />
	  <input type="hidden" id="gf_no" value="<?php echo isset($gf_no)?$gf_no:""; ?>" />
	  	  
      <script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	  <script src="<?php echo asset_url(); ?>dist/ag-grid.js?ignore=notused36"></script>
	  <script>
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
				headerName: "Breached Geofence",
				field: "geofence",
				width: 110,
				cellStyle: {justifyContent: "left"},
			},
			{
				headerName: "Entry Time",
				field: "entry_time",
				width: 130,
				cellStyle: {justifyContent: "left"},
			},
			{
				headerName: "Exit Time",
				field: "exit_time",
				width: 130,
				cellStyle: {justifyContent: "left"},
			},
			{
				headerName: "Time in Geofence (Min.)",
				field: "timein_gf",
				width: 145,
				cellStyle: {justifyContent: "left"},
			},
			{
				headerName: "Threshold Time(Min.)",
				field: "theshold_time",
				width: 135,
				cellStyle: {justifyContent: "left"},
			},
			{
				headerName: "Breached Duration (Min.)",
				field: "breached_time",
				width: 160,
				cellStyle: {justifyContent: "left"},
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
			var ladle      = $("#unit").val().trim();
			
			var start_date = $("#start_date").val().trim();
			var end_date   = $("#end_date").val().trim();
			
			var start_time = $("#start_time").val().trim();
			var end_time   = $("#end_time").val().trim();
			
			var is_refill  = $("#is_refill").val().trim();
			var mt_type    = $("#mt_type").val().trim();
			
			var gf_no      = $("#gf_no").val().trim();
			
			$("#lbl-sts").html("Processing please wait ... <i class='fa fa-spinner fa-spin'></i>").css("color","orange");
								
			$.ajax({
				type: "POST",
				//async: false,
				url: '<?php echo jquery_url();?>tatsummary/getBreachReport',
				// url: '<?= base_url("tatsummary/getReport"); ?>',
				data: {
					'ladle_no':ladle,
					'start_date':start_date,
					'end_date':end_date,
					'start_time':start_time,
					'end_time':end_time,
					'is_refill':is_refill,
					'mt_type':mt_type,
					'gf_no':gf_no
				},
				beforeSend: function() {
				},
				dataType: 'json',
				success: function(res) {
					$("#lbl-sts").html("").css("color","black");					
					if(!res.length){
						$("#lbl-sts").html("No data found").css("color","red");
					}
					setRowData(res);
				},
				complete: function (data) {
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
	});	  
	</script>
   </body>
</html>

