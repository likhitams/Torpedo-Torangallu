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
  	
            <div class="search_bar full_search">
                	
                      <span class="text" style="display: none;">Unit Name : <span class="unitname"></span></span>
                      
                      <span class="text" style="display: none;">Report Type : <span class="reportType"></span></span>
                      <span class="text" style="display: none;">Period : <span class="period"></span></span>
                      <span class="text">Select Geofence From The Following Assigned Geofences</span>
                      <span class="group-btn" style="margin-left: 42px;">
                      <button class="btn btn-info btn-min" type="button" onclick="getDetails(1);"><i class="fa fa-list-alt" aria-hidden="true"></i> Submit</button>
                    <!--   <button class="btn btn-info btn-min" type="button" onclick="getDetails(0);"><i class="fa fa-list-alt" aria-hidden="true"></i> Non-Circulation</button>    -->
                      </span>
                      
                      
                </div>
                
                <div id="myGrid" style="width: 100%; height: 450px ;margin-top: 2px;" class="ag-blue"></div>
                <form id="form-validate">
					<input type="hidden" name="unit" value="<?php echo $unit?>">
					<input type="hidden" name="group" value="<?php echo $group?>">
					<input type="hidden" name="checkAuto" value="<?php echo $checkAuto?>">
					<input type="hidden" name="start_date" value="<?php echo $start_date?>">
					<input type="hidden" name="start_time" value="<?php echo $start_time?>">
					<input type="hidden" name="end_date" value="<?php echo $end_date?>">
					<input type="hidden" name="end_time" value="<?php echo $end_time?>">
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
    	
        $(".unitname").html(parent.document.getElementById("hidunit").value);
        $(".reportType").html($(parent.document.getElementById("reportType")).find(":selected").text());
        $(".period").html(parent.document.getElementById("start_date").value+" "+parent.document.getElementById("start_time").value+" To "+parent.document.getElementById("end_date").value+" "+parent.document.getElementById("end_time").value);
    });

    function onBtShowLoading(){		
	    gridOptions.api.showLoadingOverlay();
	}
	
    function onBtHide() {
	    gridOptions.api.hideOverlay();
	}

    var columnDefs = [
					  
	                  {headerName: "id", field: "id", width: 0,hide:true},
	    		      {headerName: "Geofence Name", field: "geofencename", width: 1300, checkboxSelection: true}
	              ];
	
    var gridOptions = {
	        debug: true,
	        rowData: null,
	        rowSelection: 'multiple',
	        enableFilter: false,
	       // enableSorting: true,
	        headerCellRenderer: headerCellRendererFunc,
	        onRowSelected: onSelectionChanged,
	        rowDeselection: true,
	        overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
	        columnDefs: columnDefs,
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
		                  gridOptions.api.setRowData(httpResponse);
                          setGridHeight();   

		              });
		              
              		
              var h;  
        		$(document).ready(function(){
        			h = $( document ).height()-15;
        		});
  			
        		function setGridHeight(){
    				$("#myGrid").css("height",h+"px");
        		}

        		function headerCellRendererFunc(params) {
		    		//console.log("dddd");
	    	        if (params.colDef.field != "geofencename")
	    	            return params.colDef.headerName;
	    	        ///console.log(params.colDef.headerName);
	    	        var cb = document.createElement('input');
	    	        cb.setAttribute('type', 'checkbox');
	    	        cb.setAttribute('id', 'myCheckbox')

	    	        var eHeader = document.createElement('label');
	    	        var eTitle = document.createTextNode(params.colDef.headerName);
	    	        eHeader.appendChild(cb);
	    	        eHeader.appendChild(eTitle);

	    	        cb.addEventListener('change', function (e) {
	    	      
	    	          if (this.checked) {
	    	              //console.log(gridOptions1.api.getModel());
	    	              gridOptions.api.getModel().forEachNode(function(node){
	    	            	  node.setSelected(true);
	    	              });
	    	          } else {
	    	        	  gridOptions.api.getModel().forEachNode(function(node){
	    	            	  node.setSelected(false);
	    	              });
	    	          }
	    	        });
	    	        
	    	        return eHeader;
	    	    }

        		function onSelectionChanged(event){
	    			
	    			var selectedRows = gridOptions.api.getSelectedRows().length;
	    			var cnt = gridOptions.api.getModel().rowsToDisplay.length;
	    			
	    			$("#myCheckbox").prop("checked", false);
	    			if(selectedRows == cnt){
						$("#myCheckbox").prop("checked", true);
	    			}
	    			
	    		}

              
              var geoid = "", circ = 0;
              
	function getDetails(cycle){
		var selectedRows = gridOptions.api.getSelectedRows();
		if(selectedRows.length > 0){
			var geoList = new Array();
			selectedRows.forEach( function(selectedRow, index) {
				var geoId = 0;
				geoId = selectedRow.id;
				geoList.push(geoId);
			});
			geoid = geoList.join(",");
			circ = cycle;
			//alert(geoid);
			window.parent.fillGrid(cycle);
			$(parent.document.getElementById("getgeopop")).click();
		}
		else{
			//console.log(parent.document);
			$(parent.document.getElementById("error-msg")).html("select any one geofence name");
			$(parent.document.getElementById("alertbox")).click();
		}
	}
	
	</script>
  </body>
</html>