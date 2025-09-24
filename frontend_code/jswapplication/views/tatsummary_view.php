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
	  
	  .tbl-dvdr {
		border-bottom: dashed 1px gray;
		margin-bottom: 15px;
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
	  
	  .select2-container .select2-selection--single {
		  height: 37px;
	  }
	  
	  .select2-container--default .select2-selection--single .select2-selection__arrow {
		  top: 5px;
	  }
	  
	  .select2-container .select2-selection--single .select2-selection__rendered {
		  padding-top: 5px;
	  }
	  
	  .td-hdn{
		  display: none;
	  }
	  
	  .td-breached, .th-breached{
		  background: red !important;
		  color: white !important;
	  }
	  
	  .hdn{
		  display: none !important;
	  }
	  
	  .th-yl{
		  background: yellow !important;
		  color: black !important;
	  }
	  
	  .th-gr{
		  background: green !important;
		  color: white !important;
	  }
	  
	  .th-or{
			background: #602f2f !important;
			color: white !important;
	  }
	  
	  .th-sl {
		 background: silver !important;
		 color: black !important;
	  }
	  </style>
   </head>
   <body class="dark-sidenav">
      
	  <div class="container-fluid">
		<div id='lbl-sts'></div>
		<div class="col-12" id="dvReport"></div> 
	  </div> 
	 
 	  <input type="hidden" id="unit" value="<?php echo isset($ladle_no)?$ladle_no:""; ?>" />
 	  <input type="hidden" id="start_date" value="<?php echo isset($start_date)?$start_date:""; ?>" />
	  <input type="hidden" id="end_date" value="<?php echo isset($end_date)?$end_date:""; ?>" />
	  <input type="hidden" id="start_time" value="<?php echo isset($start_time)?$start_time:""; ?>" />
	  <input type="hidden" id="end_time" value="<?php echo isset($end_time)?$end_time:""; ?>" />
	  <input type="hidden" id="is_refill" value="<?php echo isset($is_refill)?$is_refill:""; ?>" />
	  <input type="hidden" id="mt_type" value="<?php echo isset($mt_type)?$mt_type:""; ?>" />
	  
      <script src="<?php echo asset_url() ?>js/jquery.min.js"></script>	
	  <script>
	  $(document).ready(function() {
		  getReport();
		  $(document).on("click","#btnGetReport",function(e){
			  checkBreach();
		  });
		  
		  function getReport(){
			
			var ladle      = $("#unit").val().trim();
			
			var start_date = $("#start_date").val().trim();
			var end_date   = $("#end_date").val().trim();
			
			var start_time = $("#start_time").val().trim();
			var end_time   = $("#end_time").val().trim();
			
			var is_refill  = $("#is_refill").val().trim();
			var mt_type    = $("#mt_type").val().trim();
			
			$("#dvReport").html("");
			$("#lbl-sts").html("Processing please wait ... <i class='fa fa-spinner fa-spin'></i>").css("color","orange");
								
			$.ajax({
				type: "POST",
				//async: false,
				url: '<?php echo jquery_url();?>tatsummary/getReport',
				// url: '<?= base_url("tatsummary/getReport"); ?>',
				data: {
					'ladle_no':ladle,
					'start_date':start_date,
					'end_date':end_date,
					'start_time':start_time,
					'end_time':end_time,
					'is_refill':is_refill,
					'mt_type':mt_type
				},
				beforeSend: function() {
				},
				dataType: 'json',
				success: function(res) {
					if(res.length){
						$("#lbl-sts").html("").css("color","black");
						
						var tHtml   = "";						
						var brchArr = [];
						
						var tCount  = 1;
						res.forEach(function(obj){
							var headers = [];
							var values  = [];
														
							$.each(obj, function(key,val){
								headers.push(key);
								values.push(val);
							});
														
							tHtml += "<small>Trip #</small>"+tCount;
							tHtml += "<table class='table tbl-rprt table-bordered'>";
								tHtml += "<thead>";
									tHtml += "<tr class='tr-head'>";	
									var cc = 1;
									$.each(headers, function(ind,header){
										var hdrs = header.split('$$');
										
										if(hdrs.length == 2){
											if($.trim(hdrs[1]) != "BREACH_TIME"){
												tHtml += "<th>";
													tHtml += $.trim(hdrs[1]);													
												tHtml += "</th>";
											}else{
												tHtml += "<th class='td-hdn'>";
												tHtml += "</th>";
											}
										}else{												
											tHtml += "<th>";
												tHtml += $.trim(hdrs[0]);											
											tHtml += "</th>";										
										}
										
										cc++;
									});									
									tHtml += "</tr>";
								tHtml += "</thead>";
								
								tHtml += "<tbody>";
									tHtml += "<tr class='tr-data'>";									
									$.each(values, function(ind,value){
										if(!value.toString().includes("BREACH_TIME")){											
											tHtml += "<td class=''>";
												tHtml += value;
											tHtml += "</td>";
										}else{
											var vals = value.split('BREACH_TIME');
											
											tHtml += "<td class='td-hdn td-aftbrc'>";
												tHtml += vals[1];
											tHtml += "</td>";
										}
									});								
									tHtml += "</tr>";
								tHtml += "</tbody>";
							tHtml += "</table>";
							tHtml += "<div class='tbl-dvdr'></div>";
						
							tCount++;
						});
						
						$("#dvReport").html(tHtml);
					}else{						
						$("#lbl-sts").html("No data found").css("color","red");
					}
				},
				complete: function (data) {
				  checkBreach();
			    }
			});
		  
			return;
		  }
	  
		  $("#unit").select2();
	  });
	  
	  function checkBreach(){
		  console.log("called");
		  $('.tr-data').each(function(i, obj) {
			var tdc = 0;
			$(this).find("td").each(function(ind,td){
				console.log($(this).html());
				var temp = $(this).html().split('_');
				
				if($(this).hasClass("td-aftbrc") && parseInt(temp[0]) >0){
					$(this).closest("tr").find("td:nth-child("+(tdc)+")").addClass("td-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
					$(this).closest("tr").find("td:nth-child("+(tdc-1)+")").addClass("td-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
					$(this).closest("tr").find("td:nth-child("+(tdc-2)+")").addClass("td-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
					
					$(this).closest("table").find("th:nth-child("+(tdc)+")").addClass("th-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
					$(this).closest("table").find("th:nth-child("+(tdc-1)+")").addClass("th-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
					$(this).closest("table").find("th:nth-child("+(tdc-2)+")").addClass("th-breached").attr("title","Threshold Interval : "+temp[1]+" | Breach Time : "+temp[0]);
				}

				tdc++;
			});			
		  });
		  
		  $(".th-breached").closest("tr").find("th").css("border-top","solid red 2px");
		  
		  $('th:contains("LOAD WEIGHMENT WB")').addClass("th-yl");
		  $('th:contains("EMPTY WEIGHMENT WB - END")').html("EMPTY WEIGHMENT WB");
		  $('th:contains("EMPTY WEIGHMENT WB")').addClass("th-yl");
		  
		  $('th:contains("IRON MAKING CYCLE")').addClass("th-or");
		  $('th:contains("STEEL MAKING CYCLE")').addClass("th-sl");
		  $('th:contains("TOTAL TAT")').addClass("th-gr");
		  
		  $('.tr-head').each(function(i, obj) {
			var tdc = 0;
			$(this).find("th").each(function(ind,td){
				if($(this).hasClass("th-yl")){
					$(this).closest("table").find(".tr-data").find("td:nth-child("+(tdc+1)+")").addClass("th-yl");
				}
				
				if($(this).hasClass("th-gr")){
					$(this).closest("table").find(".tr-data").find("td:nth-child("+(tdc+1)+")").addClass("th-gr");
				}
				
				if($(this).hasClass("th-or")){
					$(this).closest("table").find(".tr-data").find("td:nth-child("+(tdc+1)+")").addClass("th-or");
				}
				
				if($(this).hasClass("th-sl")){
					$(this).closest("table").find(".tr-data").find("td:nth-child("+(tdc+1)+")").addClass("th-sl");
				}
				
				tdc++;
			});
		  })
	  }
	</script>
   </body>
</html>


