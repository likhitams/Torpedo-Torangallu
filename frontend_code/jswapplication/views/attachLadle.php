<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo title;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
  <?php echo $updatelogin;
  $role = $detail[0]->userRole;
  ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
   
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
            <h2>Attach/Detach</h2>
              
              
        </div>
       
       <div class="full_body"> 
        <div class="table-responsive">
    		<div id="myGrid" style="width: 100%; height: 450px ;" class="ag-blue"></div>
    	</div>
        
       </div>
    </div>
    
    <script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
    
    <script src="<?php echo asset_url();?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/theme-blue.css">
	
	<?php echo $jsfile;?>	
    
    <script type="text/javascript">

    var empty_string = /^\s*$/;
    var h;  
	$(document).ready(function(){  
		h = $( document ).height()-130;
	});
	var arra = new Array();

	<?php if($detail[0]->userRole == 'c' || $detail[0]->userRole == 'a'){?>
    var columnDefs = [			
					  {headerName: "id", field: "id", width: 0,hide:true},	
					  {headerName: "id", field: "oldregistration", width: 0,hide:true},		  
	                  {headerName: "Laddle Car", field: "unitname", width:675, cellClass: 'textAlignLeft', filter: 'text'},
	                  {headerName: "Laddle No", field: "registration", editable: true, width:670, cellClass: 'textAlignLeft', cellEditor: DimensionBox, filter: 'number',
	                	  cellRenderer: function(params) {
				                 switch(params.value){
				                 	case "-1": reval = "";break;
				                 	default: reval = params.value;break;
				                 }
		                      	return reval;
		                  		}},
	            		                  	                  
	              ];
    var id = "", valatt = "";
    var gridOptions = {

    		debug: true,
            enableServerSideSorting: true,
            enableServerSideFilter: true,
            enableColResize: true,
            rowSelection: 'multiple',
            rowDeselection: true,
            suppressRowClickSelection:true,
            overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
            columnDefs: columnDefs,
            rowModelType: 'infinite',
            paginationPageSize: 50,
            cacheOverflowSize: 2,
            editType: 'fullRow',
            maxConcurrentDatasourceRequests: 2,
            paginationInitialRowCount: 0,
            maxBlocksInCache: 2,
            getRowNodeId: function(item) {
                return item.id;
            },
            onRowValueChanged: function(event) {
                
                var data = event.data;
              //console.log(event.newValue);return;
              //console.log(data);
                var index = event.node.rowIndex;
                var id = data.id, url = "", unitname = data.unitname, registration = data.registration, oldregistration = data.oldregistration;
               
                   // alert(id+"-----"+$.isNumeric(id));
                   url = "<?php echo jquery_url();?>operations/updateLadleDetails";
                    //alert(types);
                	$.post(url,{id: id, registration: registration},function(data1){
    					//alert(data1);
    					var node = gridOptions.api.getModel().getRow(index);
    					if(!$.isNumeric(data1)){
    						$("#error-msg").html(data1);
							$("#alertbox").click();							
							gridOptions.api.setFocusedCell(index, 'unitname');
							node.updateData({id:id, oldregistration:oldregistration, unitname:unitname, registration:oldregistration});
							//gridOptions.api.updateRowData({updateIndex: index, update: {id:id, name:oldname, status:status}});
    					}
    					else{
    						
    					}
                	});
                
                    
            },
	    };
    <?php }
    else {?>

    var columnDefs = [			
		  {headerName: "id", field: "id", width: 0,hide:true},	
		  {headerName: "id", field: "oldregistration", width: 0,hide:true},		  
        {headerName: "Laddle Car", field: "unitname", width:675, cellClass: 'textAlignLeft', filter: 'text'},
        {headerName: "Laddle No", field: "registration", editable: false, width:670, cellClass: 'textAlignLeft', cellEditor: DimensionBox, filter: 'number',
      	  cellRenderer: function(params) {
	                 switch(params.value){
	                 	case "-1": reval = "";break;
	                 	default: reval = params.value;break;
	                 }
                	return reval;
            		}},
  		                  	                  
    ];
var id = "", valatt = "";
var gridOptions = {

debug: true,
enableServerSideSorting: true,
enableServerSideFilter: true,
enableColResize: true,
rowSelection: 'multiple',
rowDeselection: true,
suppressRowClickSelection:true,
overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
columnDefs: columnDefs,
rowModelType: 'infinite',
paginationPageSize: 50,
cacheOverflowSize: 2,
editType: 'fullRow',
maxConcurrentDatasourceRequests: 2,
paginationInitialRowCount: 0,
maxBlocksInCache: 2,
getRowNodeId: function(item) {
  return item.id;
},
onRowValueChanged: function(event) {
  
  var data = event.data;
//console.log(event.newValue);return;
//console.log(data);
  var index = event.node.rowIndex;
  var id = data.id, url = "", unitname = data.unitname, registration = data.registration, oldregistration = data.oldregistration;
 
     // alert(id+"-----"+$.isNumeric(id));
     url = "<?php echo jquery_url();?>operations/updateLadleDetails";
      //alert(types);
  	$.post(url,{id: id, registration: registration},function(data1){
			//alert(data1);
			var node = gridOptions.api.getModel().getRow(index);
			if(!$.isNumeric(data1)){
				$("#error-msg").html(data1);
				$("#alertbox").click();							
				gridOptions.api.setFocusedCell(index, 'unitname');
				node.updateData({id:id, oldregistration:oldregistration, unitname:unitname, registration:oldregistration});
				//gridOptions.api.updateRowData({updateIndex: index, update: {id:id, name:oldname, status:status}});
			}
			else{
				
			}
  	});
  
      
},
};
<?php }?>
    $.ajax({
        url:  '<?php echo jquery_url()?>operations/getLaddleNodata',
        dataType: 'json',
        success: function(data){
	        // console.log("88888888888888888888");	
       	 
       	 arra = data;
       	//console.log(arra);
        }
    });
    
 // setup the grid after the page has finished loading
    document.addEventListener('DOMContentLoaded', function() {
        var gridDiv = document.querySelector('#myGrid');
        new agGrid.Grid(gridDiv, gridOptions);
		  setList();
        
    });

    function setGridHeight(){
		$("#myGrid").css("height",h+"px");
	}

    function onBtShowLoading() {
	    gridOptions.api.showLoadingOverlay();
	}

   function onBtHide() {
	    gridOptions.api.hideOverlay();
	}
  
   
	function setList(){
		onBtShowLoading();	
	
	  $.ajax({
	         url:  '<?php echo jquery_url()?>operations/getListdata',
	         dataType: 'json',
	         success: function(data){	
	      	   setRowData(data);
	         }
	     });
	
	}

 // function to act as a class
    function DimensionBox () {}
    
    // gets called once before the renderer is used
    DimensionBox.prototype.init = function(params) {
        // create the cell
        this.eInput = document.createElement('select');
        var val = params.value;
        this.eInput.value = val;
        //console.log(this.eInput);
        //this.eInput.setAttribute("c", "selected");
        valatt = val;
        
        id =  "val"+Math.floor((Math.random() * 10000) + 1);
        this.eInput.id = id;
        //console.log(this.eInput);
        inpt = this.eInput;
		/*
      //Create and append select lists
        var selectList = document.createElement("select");
        selectList.setAttribute("id", "mySelect");
        myDiv.appendChild(selectList);*/

        //Create and append the options
        if(arra.length > 0){
            if(val == ""){
            	var option = document.createElement("option");
                option.setAttribute("value", "");
                
                option.text = "";
                inpt.appendChild(option);
            }
            else{
            	var option = document.createElement("option");
                option.setAttribute("value", "-1");
                
                option.text = "Unassign";
                inpt.appendChild(option);
            }
        }
        else{
        	var option = document.createElement("option");
            option.setAttribute("value", "");
            
            option.text = "";
            inpt.appendChild(option);
        }
	     arra.forEach( function(data, index) { 
	    	 var option = document.createElement("option");
	            option.setAttribute("value", data.ladleno);
	            if(val == data.ladleno){
	            	option.setAttribute("selected", "selected");
	            }
	            option.text = data.ladleno;
	            inpt.appendChild(option);
	     });
        /*for (var i = 0; i < array.length; i++) {
            var option = document.createElement("option");
            option.setAttribute("value", array1[i]);
            if(val == array1[i]){
            	option.setAttribute("selected", "selected");
            }
            option.text = array[i];
            this.eInput.appendChild(option);
        }*/
        
       
    };

    // gets called once when grid ready to insert the element
    DimensionBox.prototype.getGui = function() {
        return this.eInput;
    };

    // focus and select can be done after the gui is attached
    DimensionBox.prototype.afterGuiAttached = function() {
        this.eInput.focus();
        
    };
    
    // returns the new value after editing
    DimensionBox.prototype.getValue = function() {
        return this.eInput.value;
    };

    // any cleanup we need to be done here
    DimensionBox.prototype.destroy = function() {
        // but this example is simple, no cleanup, we could
        // even leave this method out as it's optional
    };

    DimensionBox.prototype.focusIn = function () {
       //var eInput = this.getGui();
       // eInput.focus();
    };

    // if true, then this editor will appear in a popup
    DimensionBox.prototype.isPopup = function() {
        // and we could leave this method out also, false is the default
        return false;
    };


    var datatoExport = [];
    function setRowData(allOfTheData) {
  	// give each row an id
  	   /* allOfTheData.forEach( function(data, index) {
  	        data.id = (index + 1);
  	    });*/
  	   //$("#unitCount").html(allOfTheData.length);
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
        resultOfSort.sort(function(a,b) {
        	//console.log(a);
        	//console.log(b);
            for (var k = 0; k<sortModel.length; k++) {
                var sortColModel = sortModel[k];
               // console.log(sortColModel);
                var cold = gridOptions.columnApi.getColumn(sortColModel.colId);
               //console.log(cold.filter);
                var valueA = a[sortColModel.colId];
                var valueB = b[sortColModel.colId];

               // console.log(valueA+"---"+valueB);
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
                    if(valueA == 'N/A' || valueA === null || valueA === ""){
                  	  valueA = 0;
                    }
                    if(valueB == 'N/A' || valueB === null || valueB === ""){
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
        
        var filterPresent = filterModel && Object.keys(filterModel).length > 0;
   
        var resultOfFilter = [];
        for (var i = 0; i<data.length; i++) {
            var item = data[i];
						
			  if (filterPresent && filterModel.unitname) {
          	  var name = item.unitname;
                var allowedName = filterModel.unitname.filter;
                var flagName = checkStrLoop(filterModel.unitname.type, name.toLowerCase(), allowedName.toLowerCase());
                
				if(flagName == 1){
					continue;
				}
            }

			  if (filterPresent && filterModel.registration) {
          	  var contactno = item.registration;
                var allowedName = filterModel.registration.filter;
                var flagName = checkStrLoop(filterModel.registration.type, contactno.toLowerCase(), allowedName.toLowerCase());
                
				if(flagName == 1){
					continue;
				}
            }

            resultOfFilter.push(item);
        }
       // $("#unitCount").html(resultOfFilter.length);
        return resultOfFilter;
    }


    
    </script>
    
  </body>
</html>