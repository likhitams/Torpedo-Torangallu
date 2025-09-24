<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo asset_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>css/style.css" rel="stylesheet">
<link href="<?php echo asset_url();?>css/font-awesome.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php echo $updatelogin; ?>
    
  </head>
  <body>
  	
                
                <div id="myGrid" style="width: 100%; height: 450px ;margin-top: 2px;" class="ag-blue"></div>
                <form id="form-validate">
					<input type="hidden" name="unit" value="<?php echo $unit?>">
					<input type="hidden" name="start_date" value="<?php echo $start_date?>">
					
					<input type="hidden" name="end_date" value="<?php echo $end_date?>">
					
				</form>
   
   

    <script src="<?php echo asset_url();?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url();?>js/jquery-ui.js"></script>
    <script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
    
    <?php echo $jsfile;?>
    <script src="<?php echo asset_url();?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/theme-blue.css">
    <script type="text/javascript">

    $(document).ready(function() {   
    	
        $("#unitname").html(parent.document.getElementById("hidunit").value);
        $("#reportType").html($(parent.document.getElementById("reportType")).find(":selected").text());
        $("#period").html(parent.document.getElementById("start_date").value+""+ parent.document.getElementById("end_date").value+" ");
    });

    function onBtShowLoading(){		
	    gridOptions.api.showLoadingOverlay();
	}
	
    function onBtHide() {
	    gridOptions.api.hideOverlay();
	}

    var columnDefs = [
    	{headerName: "id", field: "id", width: 0,hide:true},		  
        {headerName: "TLC No", field: "ladleno", width:265, cellClass: 'textAlignLeft', filter: 'text'},
        {headerName: "Date", field: "date", width:265, cellClass: 'textAlign', filter: 'number', suppressFilter:true},
        {headerName: "Shift", field: "shift", width:265, cellClass: 'textAlign', filter: 'text', suppressFilter:true, suppressSorting:true},
        {headerName: "Description", field: "description", width:265, cellClass: 'textAlign', filter: 'text'},
        {headerName: "Duration", field: "duration", width:265, cellClass: 'textAlign', filter: 'text'}
	                  
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
	        paginationOverflowSize: 2,            
	        maxConcurrentDatasourceRequests: 2,
	        paginationInitialRowCount: 0,
	        maxPagesInCache: 2,
	        getRowNodeId: function(item) {
	            return item.id;
	        }
	    };
		           // setup the grid after the page has finished loading
		              document.addEventListener('DOMContentLoaded', function() {
		                  var gridDiv = document.querySelector('#myGrid');
		                  new agGrid.Grid(gridDiv, gridOptions);
		                  onBtShowLoading();

		                  var httpResponse = window.parent.httpResponse;
		                  setRowData(httpResponse);		
                          setGridHeight();      
		                  
		                  /*var str = $("#form-validate").serialize();
		                  str = str+"&type=json";
		                  // do http request to get our sample data - not using any framework to keep the example self contained.
		                  // you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
		                  var httpRequest = new XMLHttpRequest();
		                  //alert('<?php echo jquery_url()?>reports_data/getConsolidatedata?'+str);
		                  httpRequest.open('GET', '<?php echo jquery_url()?>reports_data/getMovementdata?'+str);
		                  httpRequest.send();
		                  httpRequest.onreadystatechange = function() {
		                      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
		                    	  //console.log(httpRequest.responseText);
		                          httpResponse = JSON.parse(httpRequest.responseText);
		                          
		                          setRowData(httpResponse);		
		                          setGridHeight();            
		                      }
		                  };*/

		              });
						
		              var h;  
		        		$(document).ready(function(){
		        			h = $( document ).height()-50;
		        		});
		  			
		        		function setGridHeight(){
		    				$("#myGrid").css("height",h+"px");
		        		}

		        		 var datatoExport = [];
			              function setRowData(allOfTheData) {
			            	// give each row an id
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
			                      return data;
			                  }
			                  // do an in memory sort of the data, across all the fields
			                  var resultOfSort = data.slice();
			                  resultOfSort.sort(function(a,b) {
			                      for (var k = 0; k<sortModel.length; k++) {
			                          var sortColModel = sortModel[k];
			                          var cold = gridOptions.columnApi.getColumn(sortColModel.colId);
			                         //console.log(cold.filter);
			                          var valueA = a[sortColModel.colId];
			                          var valueB = b[sortColModel.colId];
			                          // this filter didn't find a difference, move onto the next one
			                          if (valueA==valueB) {
			                              continue;
			                          }
			                          if(valueA === null){
			                        	  valueA = "";
			                          }

			                          if(valueB === null){
			                        	  valueB = "";
			                          }
			                          var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
			                          if (cold.filter == "number") {
				                          if(valueA == 'N/A' || valueA === null){
				                        	  valueA = 0;
				                          }
				                          if(valueB == 'N/A' || valueB === null){
				                        	  valueB = 0;
				                          }
				                          if(sortDirection == 1){
					                        //  console.log("asc");
			                              	  return parseFloat(valueA) - parseFloat(valueB);
				                          }
				                          else if(sortDirection == -1){
				                        	//  console.log("desc");
				                        	  return parseFloat(valueB) - parseFloat(valueA);
				                          }
			                          } 
			                          else if(valueA.toLowerCase() > valueB.toLowerCase()){
			                        	  return sortDirection;
			                          }else {
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

	
	</script>
  </body>
</html>