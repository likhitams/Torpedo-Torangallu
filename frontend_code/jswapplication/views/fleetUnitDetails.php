<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document" style="width: 1150px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Unit Vehicle Details</h4>
          </div>
          <div class="modal-body">
          <div class="row">
            <form class="form-horizontal" id="form-validate">
            
              <div class="form-group col-lg-12">
	              <label class="control-label col-lg-2">Unit Name<font style="color: red;">*</font>:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass" placeholder="Enter Unit Name" required name="unitName" id="unitName">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Registration:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass" placeholder="Enter Registration" name="reg" id="reg" maxlength="15">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Vehicle Type:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass" placeholder="Enter Vehicle Type" name="vehType" id="vehType" maxlength="15">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Contractor:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass" placeholder="Enter Contractor" name="contractorName" id="contractorName" maxlength="15">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Owner:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass onlyalpha" placeholder="Enter Owner" name="ownerName" id="ownerName">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Driver:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass onlyalpha" placeholder="Enter Driver" name="driverName" id="driverName">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Driver Ph#:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass onlynumbers" placeholder="Enter Driver Ph#" name="driverPh" id="driverPh" minlength="10" maxlength="15">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Contact Person:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass onlyalpha"  placeholder="Enter Contact Person" name="contactPerson" id="contactPerson">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Contact Ph#:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass onlynumbers" placeholder="Enter Contact Ph#" name="contactPh" id="contactPh" minlength="10" maxlength="15">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Next Service:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass floatval" placeholder="Enter Next Service" name="nextService" id="nextService">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Odometer:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass floatval" placeholder="Enter Odometer" name="odometerno" id="odometerno">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Serial:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control" disabled placeholder="Serial" id="serialno">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">GSM#:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control" disabled placeholder="GSM#" id="gsmno">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Last Start@:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control" disabled placeholder="Last Start@" id="lastStart">
	              </div>
              </div>
              
              <div class="form-group col-lg-6" id="fuelTankdiv">
	              <label class="control-label col-lg-3">Fuel tank(ltrs):</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control" disabled placeholder="Fuel tank(ltrs)" id="fuelTank">
	              </div>
              </div>
              
              <div class="form-group col-lg-6">
	              <label class="control-label col-lg-3">Unit Remark:</label>
	              <div class="col-lg-9">
	                <input type="text" class="form-control vehicleClass" placeholder="Enter Unit Remark" name="remark" id="remark">
	                <input type="hidden" name="unitnum" id="unitnum" class="vehicleClass">
	              </div>
              </div>
             
            </form>
            
            
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> CLOSE</button>
            <button type="button" id="resetButton" class="btn btn-danger"><i class="fa fa-repeat"></i> RESET</button>
            <button type="button" id="editButton" class="btn btn-primary">Edit</button>
            <button type="button" id="saveButton" style="display: none;" class="btn btn-success"><i class="fa-solid fa-check"></i> SAVE</button>
            <div id="msg_box"></div>
          </div>
        </div>
      </div>
    </div>
    
    <a data-toggle="modal" data-target="#myModal" href="#" style="display: none;" id="getunit"></a>
    <div id="contextMenu" style="z-index: 999;display: none;position: fixed;background-color: #fff;overflow: hidden;height: auto;">
    	<ul id="contextDropDown">
    		<li onclick="getUnitDetails();" >Unit Details</li>
    		<li onclick="replayWin();" >ReTrac</li>
    		<li id="disableAlert">Disable Alerts</li>
    		<?php /*?><li id="eableAlert">Enable Alerts</li>
    		<li>PNR Details</li>
    		<li>Reports</li>
    		<li>Replay</li>*/?>
    	</ul>
    </div>
    
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
    
    <div id="dialog" title="Gauge" style="width: 300px;">
	  <div class="row">
	          <div class="col-lg-6" ><div id="dvFuel"></div></div>
	          <div class="col-lg-6" ><div id="dvSpeed"></div></div>            
            </div>
	</div>
	
	<div id="distanceDialog" title="Distance(in km)" style="width: 300px;">
	  <div class="row" align="center">
	          <p><span id="distance_val">0</span></p>          
            </div>
	</div>