<?php
    $uid = $detail[0]->userId;
	$compny = $detail[0]->companyid;
	$language = $detail[0]->language;
	
	$sql = "SELECT DISTINCT(statusdesc) AS STATUS, statuscolor, s.statusid FROM units u 
                      				LEFT JOIN unitrouting ut ON  ut.unitnumber=u.unitnumber
									LEFT JOIN statuses s ON u.status=s.statusid 
								WHERE languageid=$language AND ut.companyid=$compny";
                      	$status = $this->master_db->runQuerySql($sql);
                      	//print_r($status);
                      	$colors = array();
                      	if(count($status)){ 
                      	foreach ($status as $s){$colors[$s->STATUS] = $this->grid_db->getColorClass($s->statuscolor);}
                      	}
                      	
    ?>
    
    <script src="<?php echo asset_url();?>dist/ag-grid.js?ignore=notused36"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/ag-grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>dist/styles/theme-blue.css">
    
    <script type="text/javascript">
	 
	 /* var v, obj ;
		var valpar = 1;
		var httpResponse = "", httpResponse1 = "";*/
<?php 
	/*$sql = "SELECT company_id AS companyid,columnname AS columnname,columnlable AS columnlable,sequence AS sequence,
	    width AS width, url AS url,LIST AS LIST,edit AS edit,report AS report,notify AS notify FROM companies_columns
	     WHERE is_delete IS FALSE AND company_id=$compny ORDER BY sequence";
	$headers = $this->master_db->runQuerySql($sql);
	$arr = array();
	
	$arry = $this->grid_db->getColumnFields();
	
	$actual = array("unitname","reporttime","lastreporttime","status","speed","timehours","currentodo","fuel",
	"temperature","groupname","locationname","distance","registration","loadstatus");
	$arrOrg = array(
				"unitname"=>array("headerName:'Description',field:'unitname',width:100,hide:true", "Description"),
				"reporttime"=>array("headerName:'Last Report (dd:mm:yy)',field:'reporttime',width:100,hide:true", "Last Report (dd:mm:yy)"),
				"lastreporttime"=>array("headerName:'Last Check (dd:mm:yy)',field:'lastreporttime',width:100,hide:true", "Last Check (dd:mm:yy)"),
				"status"=>array("headerName:'Status',field:'status',width:100,hide:true", "Status"),
				"speed"=>array("headerName:'Speed',field:'speed',width:100,hide:true", "Speed"),
				"timehours"=>array("headerName:'No Movement Since',field:'timehours',width:100,hide:true", "No Movement Since"),
				"currentodo"=>array("headerName:'Odo (inKm)',field:'currentodo',width:100,hide:true", "Odo (inKm)"),
				"fuel"=>array("headerName:'Fuel',field:'fuel',width:100,hide:true", "Fuel"),
				"temperature"=>array("headerName:'Temperature',field:'temperature',width:100,hide:true", "Temperature"),
				"groupname"=>array("headerName:'Department Name',field:'groupname',width:100,hide:true", "Department Name"),
				"locationname"=>array("headerName:'Location',field:'locationname',width:100,hide:true", "Location"),
				"distance"=>array("headerName:'Distance',field:'distance',width:100,hide:true", "Distance"),
				"registration"=>array("headerName:'Ladle No.',field:'registration',width:100,hide:true", "Registration"),
				"loadstatus"=>array("headerName:'Load Status',field:'loadstatus',width:100,hide:true", "Load Status")
			);
			
	
	$col = "";$existing = array();
	$userColumns = array();
	
	$userheaders = $this->master_db->getRecords('user_columns',array("user_id"=>$uid), "columnname, is_delete"); 
	//print_r($userheaders);
	foreach ($userheaders as $uh){
		$userColumns[$uh->columnname] = $uh->is_delete;
	}
	
	foreach ($headers  as $h){
		
		if(array_key_exists($h->columnname, $arry) && in_array($arry[$h->columnname], $actual)){
			$filter = $this->grid_db->getFilter($arry[$h->columnname], $colors);
			$field = $arry[$h->columnname];
			$checked = "checked"; $hide = "false";
			if(array_key_exists($h->columnname, $userColumns) && $userColumns[$h->columnname] == 1){
				$checked = "";$hide = "true";
			}
			
			$arr[] = "{headerName:'".$h->columnlable."',
					"."field:'".$field."',
					"."width:".$h->width."
					".",hide:$hide".$filter."}";
			$existing[] = $arry[$h->columnname];
			
			$col .= "<li><div class='checkbox'><label><input type='checkbox' value='$field' class='showcols' columnname='".$h->columnname."' ".$checked."> ".$h->columnlable."</label></div></li>";
		}					
	}
	
	$result = array_diff($actual, $existing); 
	//print_r($result);
	if(count($result)){
		foreach ($result as $res){
			$filter = $this->grid_db->getFilter($res, $colors);
			$arr[] = "{".$arrOrg[$res][0].$filter."}";
			//$col .= "<li><a href='#'><input type='checkbox' value='$res' class='showcols'>".$arrOrg[$res][1]."</a></li>";
			//$col .= "<li><div class='checkbox'><label><input type='checkbox' value='$res' class='showcols' > ".$arrOrg[$res][1]."</label></div></li>";
		}
	}
	
	$arr[] = "{headerName:'nextservice',field:'nextservice',width:0,hide:true}";
	$arr[] = "{headerName:'statusColor',field:'statusColor',width:0,hide:true}";
	$arr[] = "{headerName:'groupnumber',field:'groupnumber',width:0,hide:true}";
	$arr[] = "{headerName:'unitnumber',field:'unitnumber',width:0,hide:true}";
	$arr[] = "{headerName:'alerts',field:'alerts',width:0,hide:true}";
	$columnDefs = implode(",", $arr); */
	?>
	
	
	var arra = new Array();
	var res ;
    var columnDefs = [			
		  {headerName: "id", field: "id", width: 0,hide:true},		  
          {headerName: "Ladle NO", field: "registration", width:150, cellClass: 'textAlign', filter: 'text', cellStyle: function(params) {

      	   res = params.value.slice(0,4);
           
            if (res=='LOCO') {
                //mark police cells as red
                return { backgroundColor: '#4584ef'};
            }
        }},
       // {headerName: "Ladle No", field: "registration", width:100, cellClass: 'textAlignLeft', filter: 'text', suppressFilter:true},  
        {headerName: "Last Check(dd:mm:yy)", field: "lastreporttime", width:180, cellClass: 'textAlign', filter: 'text', suppressFilter:true,cellRenderer: function (params) {return formatDate(params.value);},},
        {headerName: "Status", field: "status", width:120, cellClass: 'textAlignleft', filter: 'number', suppressFilter:true, cellStyle: function(params) {

        	  var textcolor = params.value;
             
              if (textcolor=='Idle') {
                  return {color: '#FF3333'};
              }else if (textcolor=='Moving')
              {
            	  return { color: '#4C9900'};
            	  
              }
              else if (textcolor=='Ign Off')
              {
            	  return { color: '#0000FF'};
              }
              else
              {
            	  return { color: '#FF3333'};
              }

          }},
        {headerName: "Speed", field: "speed", width:80, cellClass: 'textAlign', filter: 'text', suppressFilter:true},
        {headerName: "Odo (inKm)", field: "distance", width:120, cellClass: 'textAlign', filter: 'text', suppressFilter:true},  
		{headerName: "Battery Voltage", field: "fuel", width:120, cellClass: 'textAlign', filter: 'text',suppressFilter:true},
        {headerName: "No Movement Since", field: "timehours", width:150, cellClass: 'textAlignRight', filter: 'text',suppressFilter:true,cellRenderer: function (params) {return secondsToString(params.value);},},
        {headerName: "Location", field: "locationname", width:450, cellClass: 'textAlignleft', filter: 'text',suppressFilter:true},

     
         ];
		
    var id = "", valatt = "";

			   var gridOptions = {
		                  debug: true,
		                  enableServerSideSorting: true,
		                  enableServerSideFilter: true,
		                  enableColResize: true,
		                  rowSelection: 'single',
		                  rowDeselection: true,
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

		              };

			   var ageType = 'everyone';

			   function isExternalFilterPresent() {

			       // if ageType is not everyone, then we are filtering

			       return ageType != 'everyone';

			   }

			function compareNum(valueA, valueB, nodeA, nodeB, isInverted){
				//console.log(valueA);
				//console.log(valueB);
				//console.log(nodeA);
				//console.log(nodeB);
				//console.log(isInverted);
				//if(!isInverted){//asc
				if(valueA == 'N/A' || valueA === null){
              	  valueA = 0;
                }
                if(valueB == 'N/A' || valueB === null){
              	  valueB = 0;
                }
                  	return parseFloat(valueA) - parseFloat(valueB);
                //}
                //else{//desc
                	//return parseFloat(valueB) - parseFloat(valueA);
                //}
			}

			   function doesExternalFilterPass(node) {

			       /*switch (ageType) {

			           case 'below30': return node.data.age < 30;

			           case 'between30and50': return node.data.age >= 30 && node.data.age <= 50;

			           case 'above50': return node.data.age > 50;

			           default: return true;

			       }*/
					var item = node.data;
				   if($("#keywords").val() != ""){
                 	  var flagunit = checkStrLoop("contains", item.unitname.toLowerCase(), $("#keywords").val().toLowerCase());	
                 	  var flagst = checkStrLoop("contains", item.status.toLowerCase(), $("#keywords").val().toLowerCase());	
                 	  var flagloc = checkStrLoop("contains", item.locationname.toLowerCase(), $("#keywords").val().toLowerCase());	        
							if(flagst == 1 && flagunit == 1 && flagloc == 1){
								return false;
							}
                   }

                   if($("#hrs").val() != "00"){		                    	 
                 	  var hoursearch = $("#hrs").val();
							if(parseFloat(hoursearch)<10)
								hoursearch = hoursearch; 
							//var rowData = rec.data; 
							var data1 = item.trackreporttime;
							//console.log("data1="+data1);
							var splitS=data1.split(" ");
							var dsplit=splitS[0].split("-");
							var day=dsplit[1];
							var mon=dsplit[0];
							var yr=dsplit[2];
							var Sdate = yr+"-"+mon+"-"+day;
							var SDate = Sdate+" "+splitS[1];
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
								
							var hours1 = parseInt(((stimes)/(60*60)));
								
							if(parseFloat(hours1)<10)
								hours1 = '0'+hours1;
							//console.log("track="+item.unitname+",timestamp2="+timestamp2+",timestamp1="+timestamp1);
								//console.log("hours1="+hours1+"hoursearch="+hoursearch);
							if(parseFloat(hours1) < parseFloat(hoursearch))
								return false;
								//return rec.get('trackreporttime');
                   }

                   if($("#min").val() != "00"){	
                 	  var minutesearch = $("#min").val();
							if(minutesearch<10)
								minutesearch = minutesearch;
							
							
							var hoursearch = $("#hrs").val();
							if(hoursearch<10)
								hoursearch = hoursearch; 
						
							hoursearch = hoursearch * 60;
							
							minutesearch = (parseInt(minutesearch) + parseInt(hoursearch));
								                    	 
                 	  
							var data1 = item.trackreporttime;
							var splitS=data1.split(" ");
							var dsplit=splitS[0].split("-");
							var day=dsplit[1];
							var mon=dsplit[0];
							var yr=dsplit[2];
							var Sdate = yr+"-"+mon+"-"+day;
							var SDate = Sdate+" "+splitS[1];
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
							var hours1 = parseInt(((stimes)/(60*60)));
							var minutes1 = parseInt((((stimes)%(60*60))/60));
							
							if(hours1<10)
								hours1 = '0'+hours1;

							if(minutes1<10)
								minutes1 = '0'+minutes1;
							
							minutes1 = (parseInt(hours1 * 60) + parseInt(minutes1));
								
							if(minutes1 <= minutesearch)
								return false;
                   }

                   if($("#sec").val() != "00"){	
                 	  var secondsearch = $("#sec").val();
							if(secondsearch<10)
								secondsearch = secondsearch;
							
							var sec = 0;
							var sec1 = 0;
							var minutesearch = $("#min").val();
							if(minutesearch<10)
								minutesearch = minutesearch;
							
							
							var hoursearch = $("#hrs").val();
							if(hoursearch<10)
								hoursearch = hoursearch; 
						
							var seconds = parseInt((hoursearch) * 60 * 60) + parseInt((minutesearch) * 60) + parseInt(secondsearch);
							sec = sec + seconds;

							
							var data1 = item.trackreporttime;
							var splitS=data1.split(" ");
							var dsplit=splitS[0].split("-");
							var day=dsplit[1];
							var mon=dsplit[0];
							var yr=dsplit[2];
							var Sdate = yr+"-"+mon+"-"+day;
							var SDate = Sdate+" "+splitS[1];
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
							var hours1 = parseInt(((stimes)/(60*60)));
							var minutes1 = parseInt((((stimes)%(60*60))/60));
							var seconds1 =parseInt((((stimes)%(60*60))%60));
							
							if(hours1<10)
								hours1 = '0'+hours1;

							if(minutes1<10)
								minutes1 = '0'+minutes1;
							
							if(seconds1<10)
								seconds1 = '0'+ seconds1;
							
							
						
							seconds1 = parseInt((hours1) * 60 * 60) + parseInt((minutes1) * 60) + parseInt(seconds1);
							//sec1 = sec1 + secon;
							
							//alert(seconds1 +"<<<"+ sec);
							
							if(seconds1 <= sec)
								return false;
                   }
                   return true;
			   }



			   function externalFilterChanged(newValue) {
					if($("#keywords").val() == "" && $("#hrs").val() == "00" && $("#min").val() == "00" && $("#sec").val() == "00"){
						ageType = "everyone";
					}
					else{
			       		ageType = "";
					}

			       gridOptions.api.onFilterChanged();

			   }
			   	              

			   $(document).ready(function(){
					 $('body').on('click',".ag-row", function(evt){
						// evt.stopPropagation();
						$("#contextMenu").hide();	
						//-----------------------------------------------------
						$("iframe").each(function(){
							reDrawGauge();
							var selectedRows = gridOptions.api.getSelectedRows();
							var selectedRowsString = '';
							selectedRows.forEach( function(selectedRow, index) {

								$("#temp").val(selectedRow.longitude);
								$("#temp1").val(selectedRow.latitude);
								$("#mapDirection").val(selectedRow.direction);
								$("#mapStatus").val(selectedRow.status);
								$("#mapUnitName").val(selectedRow.unitname);
								$("#mapStatusColor").val(selectedRow.statusColor);
								$("#mapLocation").val(selectedRow.locationname);
								$("#mapReporttime").val(selectedRow.reporttime);
								$("#mapSpeed").val(selectedRow.speed);
								$("#mapLastreporttime").val(selectedRow.lastreporttime);
								
							updateMap(1,0);
							});
						});
					 });

					 $('body').on('click',"#editButton", function(e){
						 $(this).hide();
						 $("#saveButton").show();
						$(".vehicleClass").prop("disabled", false);
					 });

					
					 $("#resetButton").click(function(evt){
						 setFormvalues(obj);
						 $("#unitName").blur();
					 });
					 
					 $('body').on('dblclick',".ag-row", function(e){
						//console.log("clicked");contextMenu
						
							var selectedRows = gridOptions.api.getSelectedRows();
							   var selectedRowsString = '';
							   selectedRows.forEach( function(selectedRow, index) {
								   var alert = selectedRow.alerts;
								   //contextDropDown
								  // $("#disableAlert, #enableAlert").remove();
								   $("ul#contextDropDown > :last-child").remove(); 
								   if(parseInt(alert) == 0){
										$("#contextMenu ul").append("<li id='disableAlert' onclick='disableAlerts();'>Disable Alerts</li>");
								   }
								   else{
									   $("#contextMenu ul").append("<li id='enableAlert' onclick='enableAlerts();'>Enable Alerts</li>");
								   }
							   });
							$('#contextMenu').css({position:"absolute", left:e.pageX,top:e.pageY}).slideDown();
					 });

					 $(".showcols").change(function(){
						 gridOptions.columnApi.setColumnVisible($(this).val(), $(this).is(':checked'));
						 var showcol = $(this).is(':checked') ? 0 : 1;
						 var id = $(this).attr("columnname");
						// alert(showcol);
							$.post("<?php echo base_url();?>lists/showColumns",{id:id,showcol:showcol},function(data){

							});
					});
				 });


			  
			   var winref;
			   function replayWin(){
				   $("#contextMenu").hide();
				   if(winref){
					   winref.close();
				   }
				   var selectedRowsNodes = gridOptions.api.getSelectedNodes();
					var selectedRows = gridOptions.api.getSelectedRows();
					var selectedRowsString = '';
					if(selectedRows.length){
					   selectedRows.forEach( function(selectedRow, index) {
						   var unitname = selectedRow.unitname;		
						  // alert(unitname);				  
						   $.get("<?php echo base_url();?>lists/saveReplay",{unitname:unitname},function(data){});
						   
						   winref = window.open("<?php echo base_url()?>lists/reTrac", "replayMap",
								   "menubar=no,resizable=yes,scrollbars=yes,width="
									+ (screen.width - 10)
									+ ",top=0,left=0,height="
									+ (screen.height - 100));
					   });
			   		}
					else{
						$.get("<?php echo base_url();?>lists/removeReplay",function(data){});
						winref = window.open("<?php echo base_url()?>lists/reTrac", "replayMap",
								"menubar=no,resizable=yes,scrollbars=yes,width="
								+ (screen.width - 10)
								+ ",top=0,left=0,height="
								+ (screen.height - 100));				
					}
			   }

			  

				function disableAlerts(){
					$("#contextMenu").hide();
					onBtShowLoading();
					var selectedRowsNodes = gridOptions.api.getSelectedNodes();
					var selectedRows = gridOptions.api.getSelectedRows();
					   var selectedRowsString = '';
					   selectedRows.forEach( function(selectedRow, index) {
						   var unitnumber = selectedRow.unitnumber;
							$.get("<?php echo base_url();?>lists/disableAlerts",{unitnumber:unitnumber},function(data){
								//console.log(selectedRow);
								//gridOptions.api.setDataValue(selectedRow.alerts, 1);
								selectedRowsNodes.forEach( function(selectedRowN, indexN) {
									//console.log("---------------------------------------------------------------");
									//selectedRowN.setDataValue(selectedRow.alerts, 1);
									selectedRow.alerts = 1;
									var updatedNodes = [];
									updatedNodes.push(selectedRowN);
									gridOptions.api.refreshRows(updatedNodes);
									
								});
								onBtHide();
							});
					   });
				}

				function enableAlerts(){
					$("#contextMenu").hide();
					onBtShowLoading();
					var selectedRowsNodes = gridOptions.api.getSelectedNodes();
					var selectedRows = gridOptions.api.getSelectedRows();
					   var selectedRowsString = '';
					   selectedRows.forEach( function(selectedRow, index) {
						   var unitnumber = selectedRow.unitnumber;
							$.get("<?php echo base_url();?>lists/enableAlerts",{unitnumber:unitnumber},function(data){
								selectedRowsNodes.forEach( function(selectedRowN, indexN) {
									selectedRow.alerts = 0;
									var updatedNodes = [];
									updatedNodes.push(selectedRowN);
									gridOptions.api.refreshRows(updatedNodes);									
								});
								onBtHide();
							});
					   });
				}

				function getUnitDetails(){
					$("#contextMenu").hide();
					$("#msg_box").html("");
					$("#editButton").show();
					 $("#saveButton").hide();
					onBtShowLoading();
					var selectedRowsNodes = gridOptions.api.getSelectedNodes();
					var selectedRows = gridOptions.api.getSelectedRows();
					   var selectedRowsString = '';
					   selectedRows.forEach( function(selectedRow, index) {
						   var unitnumber = selectedRow.unitnumber;
						   var fuel = selectedRow.fuel;
						   if(fuel=="N/A"){
								 $('#fuelTankdiv').hide();								
							}
							else{
								$('#fuelTankdiv').show();	
							}
						   //alert(unitnumber);
							$.get("<?php echo base_url();?>lists/getUnitDetails",{unitnumber:unitnumber},function(data){
								//alert(data);
								$(".vehicleClass").prop("disabled", true);
								onBtHide();
								data = data.slice(1, -1);
								//alert(data);
								if(data != "[]" && data != ""){
									obj = $.parseJSON( data );
									//alert(obj.unitname);
									setFormvalues(obj);
									$("#getunit").click();
								}
								else{									
									$("#error-msg").html("Invalid Unit Number");
									$("#alertbox").click();
									//alert("Invalid Unit Number");
								}
							});
					   });
				}

				function setFormvalues(obj){
					$("#unitName").val(obj.unitname);
					$("#reg").val(obj.registration);
					$("#vehType").val(obj.vehicletype);
					$("#contractorName").val(obj.contractor);
					$("#ownerName").val(obj.owner);
					$("#driverName").val(obj.drivername);
					$("#driverPh").val(obj.drivernumber);
					$("#contactPerson").val(obj.contactperson);
					$("#contactPh").val(obj.contactnumber);
					$("#nextService").val(obj.nextservice);
					$("#odometerno").val(obj.currentodo);
					$("#serialno").val(obj.unitserial);
					$("#gsmno").val(obj.gsmnumber);
					$("#lastStart").val(obj.laststart);
					$("#fuelTank").val(obj.tankcap);
					$("#remark").val(obj.remarks);
					$("#unitnum").val(obj.unitnumber);
				}

				function applyClass(params, arr){
					//console.log("value="+params.value);
					//console.log("rowIndex="+params.data.statusColor);
					
					var val = "";	
					if (params.data === undefined || params.data === null) {	
						return false;
					}
					else{		
					//return arr.indexOf(parseInt(data[params.rowIndex].statusColor)) > -1;
					return arr.indexOf(parseInt(params.data.statusColor)) > -1;
					}
					/*
						httpResponse.forEach( function(data, index) { 
	            	        if(params.value == data.status){		            	        
								val = returnClass(data.statusColor);
	            	        }
	            	    });*/
					//return val;
					
				}

				function checkStatus(params){
					//console.log(params);
					var val = "";	
					if (params.data === undefined || params.data === null) {	
						return false;
					}
					else{		
					//return arr.indexOf(parseInt(data[params.rowIndex].statusColor)) > -1;
					return arr.indexOf(parseInt(params.data.statusColor)) > -1;
						switch(params.data.statusColor){
								case "2":  reval = '<span class="moving"><span class="dot"></span>'+params.value+'</span>';break;
								case "15":  reval = '<span class="moving"><span class="dot"></span>'+params.value+'</span>';break;
								case "17":  reval = '<span class="idel"><span class="dot"></span>'+params.value+'</span>';break;
								default:  reval = '<span class="idel"><span class="dot"></span>'+params.value+'</span>';break;
							}
							return reval;
					}
				}

				
				function applyUnitClass(params, val){
					
					if (params.data === undefined || params.data === null) {	
						return false;
					}
					else{	
						if(parseInt(val) == parseInt(params.data.alerts)){	
							return true;
						}
						else{
							return false;
						}
					}
				}

				 function renderUnitName(params){
					   var unitname = params.value;
					   var alerts = params.data.alerts;
					 //  if (alerts == 0)
						   
				   }

				function checkOdo(params){
					if (params.data === undefined || params.data === null) {	
						return false;
					}
					else{
						var tempCurrentOdo = params.value;
						// console.log("ddf="+params.rowIndex);
						var tempNextService = params.data.nextservice;
						return calculateOdo(tempCurrentOdo, tempNextService);
					}
				}

				function checkLoadStatus(params){
					if (params.data === undefined || params.data === null) {	
						return false;
					}
					else{
						switch(params.value){
							case "201":  reval = '<span class="load"><span class="dot"></span>Load</span>';break;
							default:  reval = '<span class="empty"><span class="dot"></span>Empty</span>';break;
						}
						return reval;
						/*var tempCurrentOdo = params.value;
						// console.log("ddf="+params.rowIndex);
						var tempNextService = params.data.nextservice;
						return calculateOdo(tempCurrentOdo, tempNextService);*/
					}
				}

				function checkOdoExcel(val1, val2){
					return calculateOdo(val1, val2,1);
				}

				function calculateOdo(val1, val2, check){
					var tempCurrentOdo = val1;
					// console.log("ddf="+params.rowIndex);
					var tempNextService = val2;
					
					var val = "";
					var diff = ((parseFloat(tempCurrentOdo)/ parseFloat(tempNextService ))) * 100;
	        	     
	        	    if (diff > 90 && diff < 100){
	        		   var variable = parseFloat(tempCurrentOdo).toFixed(2);
	        		   if (variable.indexOf('.') > 0){
	        			   if(check == 1){
	        			   		return Math.round(variable);
	        			   }
	        			   else{
	        				   return '<div  align="right" class="odo-yellow">'+ Math.round(variable) +'</div>';
	        			   }
	        		   }
	        		   else{
	        			   if(check == 1){
	        			   		return variable + ".00"; 
	        			   }
	        			   else{
	        				   return '<div align="right" class="odo-grey">'+ variable + '.00'+ '</div>'; 
	        			   }
	        		   }
	        	   }
	        	      
	        	      if (diff > 100 ){
		        		   var variable= parseFloat(tempCurrentOdo).toFixed(2);
		        		   if (variable.indexOf('.') > 0){
		        			   if(check == 1){
		        			   		return Math.round(variable);
		        			   }
		        			   else{
		        				   return '<div class="odo-red">'+ Math.round(variable) + '</div>';
		        			   }
		        		   }
		        		   else{
		        			   if(check == 1){
		        			   		return variable + ".00";  
		        			   }
		        			   else{
		        				   return '<div class="odo-grey">'+ variable + '.00'+ '</div>';  
		        			   }
		        		   }
		        	  }
	        	      else {
	        		   var variable = parseFloat(
	        				   tempCurrentOdo)
	        				   .toFixed(2);
	        		   if (variable.indexOf('.') > 0){
	        			   return Math.round(variable);
	        		   }
	        		   else
	        			   return variable + '.00';
	        	   }
					return val;
				}

				function applyOdoClass(){
					//console.log("yellow="+$(".odo-yellow").length);
					$(".odo-yellow").each(function( index ) {	
						//	console.log($(this).parent());				  
						$(this).parent().addClass("odo-yellow");
						//console.log($(this).parent());	
					});
					
					$(".odo-grey").each(function( index ) {						  
						$(this).parent().addClass("odo-grey");
					});
					
					$(".odo-red").each(function( index ) {
						 // console.log( index + ": " + $( this ).text() );
						$(this).parent().addClass("odo-red");
					});
					
				}

			   function onBtShowLoading() {
				    gridOptions.api.showLoadingOverlay();
				}

			   function onBtHide() {
				    gridOptions.api.hideOverlay();
				}

			   function setStatus(val, param){
				   var ageFilterComponent = gridOptions.api.getFilterInstance(param);
				    ageFilterComponent.setType('equals');
				    ageFilterComponent.setFilter(val);
				    gridOptions.api.onFilterChanged();
			   }

			   function setGroup(val, param){
				   onBtShowLoading();
	                  // do http request to get our sample data - not using any framework to keep the example self contained.
	                  // you will probably use a framework like JQuery, Angular or something else to do your HTTP calls.
	                  var httpRequest = new XMLHttpRequest();
	                  //httpRequest.open('GET', '<?php echo jquery_url()?>lists/getGroupListdata?groupno='+val);
	                  
	                  if($("#group").val() == ""){
	                      httpRequest.open('GET', '<?php echo jquery_url()?>lists/getListdata');
	     			   }
	     			   else{
	     				   httpRequest.open('GET', '<?php echo jquery_url()?>lists/getGroupListdata?groupno='+$("#group").val());
	     			   }
	                  httpRequest.send();
	                  httpRequest.onreadystatechange = function() {
	                      if (httpRequest.readyState == 4 && httpRequest.status == 200) {
	                          httpResponse = JSON.parse(httpRequest.responseText);
	                          setRowData(httpResponse);
	                         /* httpResponse.forEach( function(data, index) {
		            	        data.id = (index + 1);
		            	    });
	                          gridOptions.api.setRowData(httpResponse);  
	                          applyOdoClass();*/
	                          //setStatus($("#status").val(), 'status');
		                     // setKeyword($("#keywords").val());
	                          
	                      }
	                  };
			   }

			   function setKeyword(val){
				   //gridOptions.api.setQuickFilter(val);
				   gridOptions.api.onFilterChanged();		
					//  externalFilterChanged(val);		    
			   }

			   var CCOUNT = (parseInt($("#autoreload").val()) > 0 && $("#checkAuto").is(":checked")) ? $("#autoreload").val() : -1;
			    
			    var t, count;
			    
			    function cddisplay() {
			        // displays time in span
			        if(CCOUNT >= 0){
				        if(count >= 0){
			        	$("#countdown").html(count);
				        }
			        }
			        else{
			        	$("#countdown").html("");
			        }
			    };
			    
			    function countdown() {
			        // starts countdown
			        cddisplay();
			        
			        if (count < 0) {
			            // time is up
			            if(parseInt($("#autoreload").val()) > 0 && $("#checkAuto").is(":checked")){
			            	onRefreshAll(0);
			            }
			            
			        } else {
			            count--;
			            t = setTimeout("countdown()", 1000);
			        }
			    };
			    
			    function cdpause() {
			        // pauses countdown
			        clearTimeout(t);
			    };
			    
			    function cdreset() {
			        // resets countdown				        
			        cdpause();
			        CCOUNT = (parseInt($("#autoreload").val()) > 0 && $("#checkAuto").is(":checked")) ? $("#autoreload").val() : -1;
			        count = CCOUNT;
			        cddisplay();
			        countdown();
			    };

			    function resetTimer(){
			    	$("#autoreload option[value='']").remove();
				    if(!$("#checkAuto").is(":checked")){
				    	
				    	$('#autoreload').append(new Option('', ''));
				    	$('#autoreload').val("");
				    }
				    else if($('#autoreload').val() == ""){
				    	//$("#autoreload option[value='']").remove();
				    	$('#autoreload').val("60");
				    }
			    	CCOUNT = (parseInt($("#autoreload").val()) > 0 && $("#checkAuto").is(":checked")) ? $("#autoreload").val() : -1;
			    	cdreset();
			    }

		   function onRefreshAll(res) {
			   if(res != 0){
			   	onBtShowLoading();
			   }
			   var httpRequest = new XMLHttpRequest();
			   if($("#group").val() == ""){
                 httpRequest.open('GET', '<?php echo jquery_url()?>lists/getListdata');
			   }
			   else{
				   httpRequest.open('GET', '<?php echo jquery_url()?>lists/getGroupListdata?groupno='+$("#group").val());
			   }
                 httpRequest.send();
                 httpRequest.onreadystatechange = function() {
                     if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                         //alert(httpRequest.responseText);
                         httpResponse = JSON.parse(httpRequest.responseText);
                         //$("#unitCount").html(httpResponse.length);
                         setRowData(httpResponse);
                         /*var replaySelection = gridOptions.api.getSelectedNodes();
                         //console.log(replaySelection);
                         httpResponse.forEach( function(data, index) {
	            	        data.id = (index + 1);
	            	    });
                         gridOptions.api.setRowData(httpResponse);                          
                        // console.log(gridOptions.api);
						if(replaySelection.length && res == 0){
							//console.log(replaySelection[0].childIndex);
							var actual = replaySelection[0].childIndex;
                             //replaySelection[0].setSelected(true);
                        	 var id = gridOptions.api.getFocusedCell();
                 			if(id.rowIndex == actual){
	                 			var node = gridOptions.api.getModel().getRow(id.rowIndex);
	                 			node.setSelected(true);
                 			}
                         }*/
						applyOdoClass();
	                         setStatus($("#status").val(), 'status');
	                         //setGroup($("#group").val(), 'groupnumber');
	                         setKeyword($("#keywords").val());
                         
                         //gridOptions.api.onFilterChanged();
                         $("iframe").each(function(){
                             if(res == 2){//refresh from fleet with map page
                            	 $(".hclass").val("");
                            	 gridOptions.api.deselectAll();
                            	 showtrackHide = false;
                            	 $("#trackButton").prop("disabled", true);
                            	 updateMap(1,0);
                             }
                             else{
								updateMap(0,0);
                             }
                         });
                         
                         if(res != 3){
                         	cdreset();
                         }
                         if(res != 0){
                         	onBtHide();
                         }
                     }
                 };
			    
			}

		   /*function onResetAll(){
			$("#keywords, #group, #status, #showMarkers").val("");
			$("#hrs, #min, #sec").val("00");*/
			<?php /*foreach ($actual as $e){?>
			//console.log
			//('<?php/* echo $e;*/?>//');
				//var <?php /*echo $e;*/?>
				//FilterComponent = gridOptions.api.getFilterInstance('<?php /*echo $e;*/?>');
				<?php /*echo $e;*/?>
				//FilterComponent.setType('equals'); <?php /*echo $e;*/?>
				//FilterComponent.setFilter("");
			<?php /*}*/?>
		    //var groupnumberFilterComponent = gridOptions.api.getFilterInstance('groupnumber');
		    //groupnumberFilterComponent.setType('equals'); groupnumberFilterComponent.setFilter("");
		    
			//gridOptions.api.onFilterChanged();
		    //gridOptions.api.setQuickFilter('');
		    //onRefreshAll(3);
		//}

		   function formatDate(params){				
				var value=params;
				if(value != undefined){
					//console.log("t--"+value);
	        	    var splitval=value.split(" ");
	        	    var splitdate=splitval[0];
	        	    var dateval= splitdate.split('-');
	        	    var recordval= dateval[2]+"-"+dateval[1]+"-"+dateval[0]+" "+splitval[1];
	        	    return recordval;
				}
				else{
					return "";
				}
		   }

		  

		   function numbdata(params){
				return valpar++;
		   }

		   function secondsToString(params){

			   var seconds = params;
			   var numdays = Math.floor(seconds / 86400);

			   var numhours = Math.floor((seconds % 86400) / 3600);

			   var numminutes = Math.floor(((seconds % 86400) % 3600) / 60);

			   var numseconds = ((seconds % 86400) % 3600) % 60;
			   var daytime = "";
			   if(numdays>0){
		 	          daytime=numdays + "d " + numhours + "h " + numminutes + "m " + numseconds + "s";
		 	        }
		 	        else if (numhours>0 && numdays==0){	        		
		 	           daytime=numhours + "h " + numminutes + "m " + numseconds + "s";
			 	    }
		 	        else if(numminutes>0 && numdays==0 && numhours==0){
		 	           daytime= numminutes + "m " + numseconds + "s";
				  }
		 	        else if(numminutes==0 && numdays==0 && numhours==0 && numseconds!=0){
		 	           daytime=numseconds + "s";
					 }

			   return daytime;

		   }
		    var datatoExport = [];
	              function setRowData(allOfTheData) {
	            	// give each row an id
	            	    allOfTheData.forEach( function(data, index) {
	            	        data.id = (index + 1);
	            	    });
	            	   $("#unitCount").html(allOfTheData.length);
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
	            	                applyOdoClass();
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

	              

	              function getISODateTime(d){
	            	    // padding function
	            	    var s = function(a,b){return(1e15+a+"").slice(-b)};

	            	    // default date parameter
	            	    if (typeof d === 'undefined'){
	            	        d = new Date();
	            	    };

	            	    // return ISO datetime
	            	    return d.getFullYear() + '-' +
	            	        s(d.getMonth()+1,2) + '-' +
	            	        s(d.getDate(),2) + ' ' +
	            	        s(d.getHours(),2) + ':' +
	            	        s(d.getMinutes(),2) + ':' +
	            	        s(d.getSeconds(),2);
	            	}

	              function createWorksheet(){
						//	Calculate cell data types and extra class names which affect formatting
		                  var cellType = [], title = "Fleet List Details";
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
		                          /*var fld = this.store.recordType.prototype.fields.get(cm.getDataIndex(i));
		                          switch(fld.type) {
		                              case "int":
		                                  cellType.push("Number");
		                                  cellTypeClass.push("int");
		                                  break;
		                              case "float":
		                                  cellType.push("Number");
		                                  cellTypeClass.push("float");
		                                  break;
		                              case "bool":
		                              case "boolean":
		                                  cellType.push("String");
		                                  cellTypeClass.push("");
		                                  break;
		                              case "date":
		                                  cellType.push("DateTime");
		                                  cellTypeClass.push("date");
		                                  break;
		                              default:
		                                  cellType.push("String");
		                                  cellTypeClass.push("");
		                                  break;
		                          }*/

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
		                         var it = datatoExport, l = datatoExport.length;

//		                Generate the data rows from the data in the Store
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
		                              switch(cm[j].colDef.field){
		                              	case "reporttime": t +=  formatDate(datatoExport[i].reporttime);break;
										case "lastreporttime": t +=  formatDate(datatoExport[i].lastreporttime);break;
										case "timehours": t += secondsToString(datatoExport[i].timehours);break;
										case "currentodo": t += checkOdoExcel(v, datatoExport[i].nextservice);break;
										default: t += v;break;
									}

		                                  
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
		                  return result;
		              }

		              function exporttoExcel(){
			              var title = "Fleet List Details";
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
			              //console.log(exporttoExcel());
		            	  document.location='data:application/vnd.ms-excel;base64,' + base64_encode(exporttoExcel());
		              }

	              function onBtExport() {

	            	  var params = {

	            		        skipHeader: false,		            		        
	            		        allColumns: false,		            		        
	            		        fileName: randomString(8, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')+".csv",

	            		    };
	            	  params.customHeader = 'FleetList Details\n';
	          		    
	            	  params.processHeaderCallback  = function(params) {

	                      return params.column.getColDef().headerName.toUpperCase();

	                  };
	          	            		    
	            	  params.processCellCallback = function(params) {
							//console.log(params);
							switch(params.column.colDef.field){
								case "reporttime": params.value = formatDate(params.value);break;
								case "lastreporttime": params.value = formatDate(params.value);break;
								case "timehours": params.value = secondsToString(params.value);break;
								case "currentodo": params.value = checkOdoExcel(params.value, params.node.data.nextservice);break;
								default: break;
							}
							
							return params.value;
	                     
	                  };
	          	      gridOptions.api.exportDataAsCsv(params);

					}


	              function randomString(length, chars) {
	            	    var result = '';
	            	    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
	            	    return result;
	            	}
	              
	              
</script>