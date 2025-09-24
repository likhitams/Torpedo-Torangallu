<!DOCTYPE html>
<html>
<head>

   <!-- Bootstrap -->
    <link href="<?php echo asset_url()?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/style.css" rel="stylesheet"> 
    <link href="<?php echo asset_url()?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo asset_url()?>css/bootstrap-datepicker.css" rel="stylesheet">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
th{
background-color:blue;
font-weight: bold;
}
</style>
</head>
<body>

<?php $active=$this->uri->segment(1);
$active1=$this->uri->segment(2);
$active2=$this->uri->segment(3);
?>
 <?php echo $updatelogin;
    $uid = $detail[0]->userId;
  $compny = $detail[0]->companyid;
  $language = $detail[0]->language;
    ?>

  <body onload="getData();">
  <!-- <span class="refresh"  title="Refresh" onclick="refreshMarkers();"><i class="fa fa-refresh" aria-hidden="true"></i></span> -->
   <?php echo $header;?>
    
     <button data-toggle="modal" data-target="#errorModal" style="display: none;" id="alertbox"></button>
      <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 800px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="errorModalLabel">Notification Alerts</h4>
            </div>
            <div class="modal-body">
              <p id="error-msg"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>
              
            </div>
          </div>
        </div>
      </div>
    
  <button data-toggle="modal" data-target="#errorModal4" style="display: none;" id="alertbox"></button>  
    <div class="modal fade" id="errorModal4" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel4">
      <div class="modal-dialog" role="document" style="width: 800px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#closeList').click();"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="errorModalLabel4">Empty Torpedo Signal Alert</h4>
          </div>
            <div class="modal-body">
              <p id="error-msg4"></p>
            </div>
          <div class="modal-footer">
       <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>    
        </div>
     </div>
      </div>
    </div>
      
      <button data-toggle="modal" data-target="#errorModal1" style="display: none;" id="alertbox"></button>
      <div class="modal fade" id="errorModal1" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 1200px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="errorModalLabel">HOURLY REPORT(MT) </h4>
            </div>
            <div class="modal-body">
              <p id="error-msg1"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>
              
            </div>
          </div>
        </div>
      </div>
      
      
        <button data-toggle="modal" data-target="#errorModal2" style="display: none;" id="alertbox"></button>
      <div class="modal fade" id="errorModal2" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
        <div class="modal-dialog" role="document" style="width: 1200px;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#clickok').click();"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="errorModalLabel">HOURLY REPORT(SMS)</h4>
            </div>
            <div class="modal-body">
              <p id="error-msg2"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-dismiss="modal" id="clickok">OK</button>
              
            </div>
          </div>
        </div>
      </div>

<h2>TOTAL CIRCULATION</h2>

<table>
  <tr>
    <th>NAME   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp LOCATION</th> 
      <div class="text-right f-r"><a href="<?php echo base_url()?>dashboard"><button class="btn btn-primary " type="button" >Back</button></a></div>
  </tr>

  <tr>
        <li  role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2" hidden="hidden"><strong>Maintenance</strong> <span class="count orn_c monospace"><?php echo count($resmain = $this->master_db->runQuerySql("SELECT lm.LOAD_STATUS, lm.id, REPLACE(CONCAT(lm.ladleno,' ->',u.location),'*','') as unitname FROM ladle_master lm LEFT JOIN units u ON u.registration=lm.ladleno where 1 and lm.cycle=0 and lm.companyid = $compny order by lm.id"));?></span>
        
             <?php if(count($resmain)){?>
                <div class="collapse" id="collapseExample2">
                  <div class="well">
                  <?php foreach ($resmain as $r2){ ?>
                    
                   <tr><td><li style="padding: 3px 9px !important;"><span class="maintenance"><span class="dot"></span><?php echo $r2->unitname;?></span></li></td></tr>
                  <?php  
                  }?>
                  </div>
                </div>
                <?php }?>
    
    
  </tr>
  
 
</table>

<script src="<?php echo asset_url()?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url()?>js/bootstrap.js"></script>
<script src="<?php echo asset_url();?>js/infobox.js" type="text/javascript"></script>
    <script src="<?php echo asset_url();?>js/mapLabel.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>



</body>
</html>

