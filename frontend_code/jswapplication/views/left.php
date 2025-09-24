<style>
.ovr {
    height: 342px;
    overflow: auto;
}
</style>

<?php $active=$this->uri->segment(1);

$active1=$this->uri->segment(2); 

$active2=$this->uri->segment(3);

?>
			<div class="left_menu">
            	<ul>
            	<?php 
            	$dashboard = $this->master_db->getRecords("submenus_dashboard",array("user_id"=>$detail[0]->userId),"is_usage,is_top10,is_fleet_listDB,is_eventViewer,is_groupusage");
            	if($detail[0]->udashboard == 1 && count($dashboard) && 
            		($dashboard[0]->is_usage == 1 || $dashboard[0]->is_top10 == 1 || $dashboard[0]->is_fleet_listDB == 1 || $dashboard[0]->is_eventViewer == 1 || $dashboard[0]->is_groupusage == 1)){
            	
            		?>
                	<li><a href="#" class="active"><i class="icon_sub_contractors"></i></a>
                    	<ul class="mini_menu">
                        	<div class="ovr">
                            <?php if($dashboard[0]->is_usage == 1){?><li><a href="usage.html">Usage</a></li><?php }?>
                            <?php if($dashboard[0]->is_top10 == 1){?><li><a href="top_10.html">Top 10</a></li><?php }?>
                            <?php if($dashboard[0]->is_fleet_listDB == 1){?><li><a href="fleet_list_db.html">Fleet list DB</a></li><?php }?>
                            <?php if($dashboard[0]->is_eventViewer == 1){?><li><a href="event_viewer.html">Event Viewer</a></li><?php }?>
                            <?php if($dashboard[0]->is_groupusage == 1){?><li><a href="group_usage.html">Group Usage</a></li><?php }?>
                            </div>
                        </ul>
                    </li>
                    <?php }?>
                    
                    <?php 
            	$fleetview = $this->master_db->getRecords("submenus_fleetview",array("user_id"=>$detail[0]->userId),"is_fleetlist, is_fleetmap, is_fleetinfo");
            	if($detail[0]->ufleetview == 1 && count($fleetview) && 
            		($fleetview[0]->is_fleetlist == 1 || $fleetview[0]->is_fleetmap == 1 || $fleetview[0]->is_fleetinfo == 1 )){
            	
            		?>
                    <li><a href="#"><i class="icon_truck_data_base"></i></a>
                    	<ul class="mini_menu">
                          <div class="ovr">
                            <?php if($fleetview[0]->is_fleetlist == 1){?><li><a href="<?php echo base_url();?>fleet_view">Fleet List</a></li><?php }?>
                            <?php if($fleetview[0]->is_fleetmap == 1){?><li><a href="<?php echo base_url();?>fleet_view/fleet_with_map">Fleet with Map</a></li><?php }?>
                            <?php if($fleetview[0]->is_fleetinfo == 1){?><li><a href="<?php echo base_url();?>fleet_view/fleet_info">Fleet Info</a></li><?php }?>
                          </div>
                        </ul>
                    </li>
                    <?php }?>
                    <li><a href="#"><i class="icon_reports"></i></a>
                    	<ul class="mini_menu">
                          <div class="ovr">
                        	<li><a href="<?php echo base_url();?>reports">Reports</a></li>
                           </div>
                        </ul>
                    </li>
                    <li><a href="#"><i class="icon_working_zone"></i></a>
                    	<ul class="mini_menu">
                          <div class="ovr">
                            <li><a href="driver_scheduling">Driver Scheduling</a></li>
                            <li><a href="geofence.html">Geofence</a></li>
                            <li><a href="location.html">Location</a></li>
                            <li><a href="route.html">Route</a></li>
                            <li><a href="route_schedule.html">Route Schedule</a></li>
                            <li><a href="pnr.html">PNR</a></li>
                            <li><a href="student_config.html">Student Config</a></li>
                           </div>
                        </ul>
                    </li>
                    <li><a href="#"><i class="icon_permit_generator"></i></a>
                    	<ul class="mini_menu">
                          <div class="ovr">
                            <li><a href="alerts.html">Alerts</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="driver_config.html">Driver Config</a></li>
                            <li><a href="unit_groups.html">Unit Groups</a></li>
                            <li><a href="user.html">User</a></li>
                            <li><a href="consolidate_report.html">Consolidate report</a></li>
                            <li><a href="follow_me.html">Follow Me</a></li>
                            <li><a href="insurance_expiry.html">Insurance Expiry</a></li>
                            <li><a href="no_movement.html">No Movement</a></li>
                           </div>
                        </ul>
                    </li>
                    
                </ul>
            </div>
