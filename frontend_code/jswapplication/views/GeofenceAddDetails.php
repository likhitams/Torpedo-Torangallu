<div class="modal fade" id="geoModal" tabindex="-1" role="dialog" aria-labelledby="geoModalLabel">
      <div class="modal-dialog" role="document" style="width: 650px;">
        <div class="modal-content">
          <div class="modal-header">
            
            <h4 class="modal-title" id="geoModalLabel">Geofence Details</h4>
          </div>
          <div class="modal-body"> 
            <form class="form-horizontal" id="form-validate" name="geoForm">
            <input type="hidden" class="form-control vehicleClass" required name="geoType" id="geoType">
            <div class="row">
              <div class="form-group col-lg-12">
              <div class="row">
	              <label class="control-label col-lg-4"><span id="trackname">Geofence Name</span> <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval" placeholder="Enter Name" required name="geoName" id="geoName" maxlength="60">
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 circle rect">
              <div class="row">
	              <label class="control-label col-lg-4">Latitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Latitude" name="geoLatitude" id="geoLatitude" >
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 circle rect">
              <div class="row">
	              <label class="control-label col-lg-4">Longitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Longitude" name="geoLongitude" id="geoLongitude">
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 rect">
              <div class="row">
	              <label class="control-label col-lg-4">Latitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Latitude" name="geoLatitude2" id="geoLatitude2" >
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 rect">
              <div class="row">
	              <label class="control-label col-lg-4">Longitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Longitude" name="geoLongitude2" id="geoLongitude2">
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 circle">
              <div class="row">
	              <label class="control-label col-lg-4">Radius at Location(in mts):</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Radius at Location" name="geoRadius" id="geoRadius">
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 rect">
              <div class="row">
	              <label class="control-label col-lg-4">Max Speed in Zone (in km/h) <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval" required placeholder="Enter Max Speed in Zone" name="geoMaxSpeed" id="geoMaxSpeed" maxlength="50">
	              </div>
              </div>
              </div>
              
              <div class="form-group col-lg-12 poly">
              <div class="row">
	              <label class="control-label col-lg-4">Latitude,Longitude:</label>
	              <div class="col-lg-8">
	                <input type="hidden" class="form-control vehicleClass" name="geoPolyLatLong" required id="geoPolyLatLong">
	                <div style="width: 130px;" id="geoPolyLatLongdiv"></div>
	              </div>
              </div>
              </div>
              </div>
            </form>
            
             
          </div>
          <div class="modal-footer">
            <button type="button" id="closeButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resetButton" onclick="resetGeofence();" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="saveButton" onclick="submitGeofence();" class="btn btn-success"><i class="fa-solid fa-check"></i> SAVE</button>
            <div id="msg_box"></div>
          </div>
        </div>
      </div>
    </div>
    <a data-toggle="modal" data-target="#geoModal" href="#" style="display: none;" id="getunit"></a>
    
    
    <div class="modal fade" id="locModal" tabindex="-1" role="dialog" aria-labelledby="locModalLabel">
      <div class="modal-dialog" role="document" style="width: 650px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="locModalLabel">Add Location</h4>
          </div>
          <div class="modal-body">
          <div class="row">
            <form class="form-horizontal" id="form-validateloc" name="locForm">
            
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Location Name <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval" placeholder="Enter Location Name" required name="locName" id="locName" maxlength="100">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Description <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval" placeholder="Enter Description" required name="locDes" id="locDes" maxlength="60">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Latitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Latitude" name="locLatitude" id="locLatitude" >
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Longitude:</label>
	              <div class="col-lg-8">
	                <input type="text" readonly="readonly" class="form-control vehicleClass" required placeholder="Enter Longitude" name="locLongitude" id="locLongitude">
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Radius at Location(in mts) <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval floatval" required placeholder="Enter Radius at Location(in mts)" name="locRadius" id="locRadius" >
	              </div>
              </div>
              
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-4">Radius Refer Location(in mts) <font style="color: red;">*</font>:</label>
	              <div class="col-lg-8">
	                <input type="text" class="form-control vehicleClass resetval floatval" required placeholder="Enter Radius Refer Location(in mts)" name="locRefRadius" id="locRefRadius">
	              </div>
              </div>
             
            </form>
            
            
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="closeLocButton" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resetLocButton" onclick="resetLocation();" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="saveLocButton" onclick="submitLocation();" class="btn btn-success"><i class="fa-solid fa-check"></i> SAVE</button>
            <div id="locmsg_box"></div>
          </div>
        </div>
      </div>
    </div>
    <a data-toggle="modal" data-target="#locModal" href="#" style="display: none;" id="getAddLocation"></a>
    