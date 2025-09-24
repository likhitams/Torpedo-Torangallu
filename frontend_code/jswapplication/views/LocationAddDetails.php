<style>
/*#gaugeModal {
    position: absolute!important;
    top: auto!important;
    right: auto!important;
    bottom: auto!important;
    left: auto!important;
}*/

</style>

<div class="modal fade" id="mlocModal" tabindex="-1" role="dialog" aria-labelledby="mlocModalLabel">
      <div class="modal-dialog" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="mlocModalLabel">Manage Location</h4>
          </div>
          <div class="modal-body">
          <div class="row">
          <div class="col-lg-5">
          		<div id="locGrid" style="width: 100%; height: 350px ;" class="ag-blue"></div>
          </div>
          <div class="col-lg-7">
          		<form class="form-horizontal" id="form-validatemloc" name="mlocForm">            
	              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Location Name <font style="color: red;">*</font>:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass resetval" placeholder="Enter Location Name" required name="mlocName" id="mlocName" maxlength="100">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Description <font style="color: red;">*</font>:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass resetval" placeholder="Enter Description" required name="mlocDes" id="mlocDes" maxlength="60">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Latitude:</label>
	              <div class="col-lg-9">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Latitude" name="mlocLatitude" id="mlocLatitude" >
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Longitude:</label>
	              <div class="col-lg-9">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Longitude" name="mlocLongitude" id="mlocLongitude">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Radius at Location(in mts) <font style="color: red;">*</font>:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass resetval floatval" required placeholder="Enter Radius at Location(in mts)" name="mlocRadius" id="mlocRadius" >
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-3">Radius Refer Location(in mts) <font style="color: red;">*</font>:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass resetval floatval" required placeholder="Enter Radius Refer Location(in mts)" name="mlocRefRadius" id="mlocRefRadius">
	              </div>
              </div>
             
            </form>
          </div>
            
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="closemLocButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resetmLocButton" onclick="resetmLocation();" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="savemLocButton" onclick="submitmLocation();" class="btn btn-success">Update</button>
            <button type="button" id="deleteLocButton" onclick="deleteLocation();" class="btn btn-dark"><i class="fa-solid fa-trash"></i> DELETE</button>
            <div id="mlocmsg_box"></div>
          </div>
        </div>
      </div>
    </div>
    
    <a data-toggle="modal" data-target="#mlocModal" href="#" style="display: none;" id="getlocpop"></a>
    
    
    <div class="modal fade" id="mgeoModal" tabindex="-1" role="dialog" aria-labelledby="mgeoModalLabel">
      <div class="modal-dialog modal-xl" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            
            <h4 class="modal-title" id="mgeoModalLabel">Manage Geofence</h4>
          </div>
          <div class="modal-body">
          <div class="row">
          <div class="col-lg-6">
          		<div id="geo1Grid" style="width: 100%; height: 220px ;" class="ag-blue"></div>
          </div>
          <div class="col-lg-6">
          	<form class="form-horizontal" id="form-validatemgeo" name="mgeoForm">           
	          <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Geofence Type:</label>
	              <div class="col-lg-8">
	                <label id="geoFormType"></label>
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Geofence Name:</label>
	              <div class="col-lg-8">
	                <label id="geoFormName"></label>
	              </div>
              </div>             
            </form>
          </div>
            
            </div>
            
            <div class="row">
          <div class="col-lg-6">
          		<div id="geo2Grid" style="width: 100%; height: 220px ;" class="ag-blue"></div>
          </div>
          
          <div class="col-lg-6">
          		<div id="geo3Grid" style="width: 100%; height: 220px ;" class="ag-blue"></div>
          </div>
          
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="closemGeoButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resetmGeoButton" onclick="resetmGeofence();" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="savemGeoButton" onclick="submitmGeofence();" class="btn btn-success"><i class="fa-solid fa-check"></i> UPDATE</button>
            <button type="button" id="deleteGeoButton" onclick="deleteGeofence();" class="btn btn-dark"><i class="fa-solid fa-trash"></i> DELETE</button>
            <div id="mgeomsg_box"></div>
          </div>
        </div>
      </div>
    </div>
    
    <a data-toggle="modal" data-target="#mgeoModal" href="#" style="display: none;" id="getgeopop"></a>
    
    
     <div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="trackModalLabel">
      <div class="modal-dialog modal-xl" role="document" style="width: 1000px;">
        <div class="modal-content">
          <div class="modal-header">
            
            <h4 class="modal-title" id="trackModalLabel">Manage Track</h4>
          </div>
          <div class="modal-body">
          <div class="row">
          <div class="col-lg-6">
          		<div id="trackGrid" style="width: 100%; height: 220px ;" class="ag-blue"></div>
          </div>
          <div class="col-lg-6">
          	<form class="form-horizontal" id="form-validatetrack" name="trackForm"> 
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Track Name:</label>
	              <div class="col-lg-8">
	                <label id="trackFormName"></label>
	              </div>
              </div>             
            </form>
          </div>
            
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" id="closetrackButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resettrackButton" onclick="resettrack();" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="deleteGeoButton" onclick="deleteTrack();" class="btn btn-dark"><i class="fa-solid fa-trash"></i> DELETE</button>
            <div id="trackmsg_box"></div>
          </div>
        </div>
      </div>
    </div>
    
    <a data-toggle="modal" data-target="#trackModal" href="#" style="display: none;" id="gettrackpop"></a>
    
   <?php /*?> <div class="modal fade" id="gaugeModal" tabindex="-1" role="dialog" aria-labelledby="gaugeModalLabel">
      <div class="modal-dialog gaugeModal_d" role="document" style="width: 300px;">
        <div class="modal-content gaugeModal_c">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="gaugeModalLabel">Gauge</h4>
          </div>
          <div class="modal-body">
          <div class="row">
	          <div class="col-lg-6" ><div id="dvFuel"></div></div>
	          <div class="col-lg-6" ><div id="dvSpeed"></div></div>            
            </div>
            
          </div>
          
        </div>
      </div>
    </div>
    
    <a data-toggle="modal" data-target="#gaugeModal" data-backdrop="static" data-keyboard="false" href="#" style="display: none;" id="getgaugepop"></a>
    <?php */?>
    
    <div id="dialog" title="Gauge" style="width: 300px;">
	  <div class="row">
	          <div class="col-lg-6" ><div id="dvFuel"></div></div>
	          <div class="col-lg-6" ><div id="dvSpeed"></div></div>            
            </div>
	</div>
	
	<div id="distanceDialog" title="Distance(in km)" style="width: 300px;">
	  <div align="center">
	          <span id="distance_val">0</span>          
            </div>
	</div>
	
    