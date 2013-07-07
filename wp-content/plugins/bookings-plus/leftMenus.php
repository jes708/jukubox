<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$costIcon = $wpdb->get_var("SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = 1");
$adminEmail = get_option('bp_AdminEmail');
if($adminEmail == "")
{
	?>
	<script>
		var ADEmail = "<?php echo $adminEmail; ?>";
		
		if(ADEmail == "")
		{
			jQuery(document).ready(function() 
			{
				jQuery("#hiddenclicker").fancybox().trigger('click');
    		});
		}
	</script>
	<?php
}
?>
<div class="sidebar" id="left-sidebar">
	<ul class="navigation standard">
		<li id="Live_help">
        	<a title="">
        		<span class="menu-errors"></span>
        		<?php _e( "Live Help", bookings_plus ); ?>
        		<strong style="background:Red;box-shadow: 0 1px 1px white, 0 1px 2px Red inset;-webkit-box-shadow: 0 1px 1px white, 0 1px 2px Red inset;
				-moz-box-shadow: 0 1px 1px white, 0 1px 2px Red inset;">New!</strong>
        	</a>
        </li>
    	<li id="Dashboard">
        	<a href="admin.php?page=baseFunction" title="">
        		<span class="menu-dashboard"></span>
        		<?php _e( "Dashboard", bookings_plus ); ?>
        	</a>
        </li>
        <li id="Bookings">
        	<a href="admin.php?page=manageBookings" title="">
        		<span class="menu-calendar"></span>
        		<?php _e( "Bookings", bookings_plus ); ?>
        		<strong id="uxBookingsCount"></strong>
        	</a>
    	</li>
        <li id="Employees">
        	<a href="admin.php?page=manageEmployees" title="">
        		<span class="menu-tables"></span>
        		<?php _e( "Staff", bookings_plus ); ?>
        		<strong id="uxEmployeesCount"></strong>
        	</a>
        </li>
        <li id="Services">
        	<a href="admin.php?page=manageServices" title="">
        		<span class="menu-files"></span>
        		<?php _e( "Services", bookings_plus ); ?>
        		<strong id="uxServiceCount"></strong>
        	</a>
        </li>
        <li id="Customers">
        	<a href="admin.php?page=manageCustomers" title="">
				<span class="menu-typo"></span>
        		<?php _e( "Clients", bookings_plus ); ?><strong id="uxCustomersCount"></strong>
        	</a>
        </li>
        <li id="BookingForm">
        	<a href="admin.php?page=manageBookingForm" title="">
        		<span class="menu-layouts"></span>
        		
        		<?php _e( "Booking Form Setup", bookings_plus ); ?>
        	</a>
        </li>
        <li id="Settings">
        	<a href="admin.php?page=manageSettings" title="">
        		<span class="menu-components"></span>
        		<?php _e( "Control Panel", bookings_plus ); ?>
        	</a>
        </li>
		<li id="ReportBug">
        	<a href="admin.php?page=manageReportBug" title="">
        		<span class="menu-messages"></span>
        		<?php _e( "Report a Bug", bookings_plus ); ?>
        	</a>
        </li> 
		<li id="Affiliates">
        	<a href="admin.php?page=manageAffiliates" title="">
        		<span class="menu-charts"></span>
        		<?php _e( "Become an Affiliate", bookings_plus ); ?>
        	</a>
        </li>
        
    </ul>
    <a href="http://bookings-plus.com/" target="_blank"><img src="<?php echo plugins_url('/images/side-banner.png', __FILE__); ?>" alt="" /></a>

</div>
<div id="addNewEmployee" style="width:700px;display:none">
	<div class="modal-header">
	
        <h5><?php _e( "Add New Staff Member", bookings_plus ); ?></h5>
    </div>
	<form id="uxFrmAddEmployees" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="addEmployeeSuccessMessage" style="display:none">
				<strong><?php _e( "Success! The Staff Member has been saved Successfully.", bookings_plus ); ?></strong>
            </div>
            <div class="note note-danger" id="errorMessageCheckEmail" style="display:none">
				<strong><?php _e( "Error! This Email already exists in our Database. Please try with new one.", bookings_plus ); ?></strong>
            </div>
	  		<p style="padding:10px 10px 0px 0px">
				<span class="label label-important"><?php _e( "Note: You will need to Assign your Employees to the respective Services in order to allow Bookings for your Clients.", bookings_plus ); ?></code>					
			</p>            
          	<div class="block well" style="margin-top:10px;">
                <div class="row-fluid form-horizontal">    
                	<div class="control-group">
                    	<?php $num = rand(1, 9999);?>
                        <label class="control-label"><?php _e( "Staff Code :", bookings_plus ); ?>
                        	<span class="req">*</span>
                        </label>
                        <div class="controls">
                        	<input type="text" disabled = "disabled" class="required span12" name="uxEmployeeUniqueCode" id="uxEmployeeUniqueCode" value="<?php echo $num; ?>"/>
                        </div>
                    </div>       
                    <div class="control-group">
                    	<label class="control-label"><?php _e( "Staff Member Color :", bookings_plus ); ?>
                    		<span class="req">*</span>
                    	</label>
                        <div class="controls">
  							<div class="input-append color" data-color="rgb(255, 141, 180)" data-color-format="rgb" >
  								<span class="add-on"><i id="picker" style="background-color: rgb(255, 146, 180)"></i></span>
                                 <input type="text" value=""  id="uxEmployeeColor" name="uxEmployeeColor" >
                                 
                            </div>                        	
                        </div>
                    </div>                 
                    <div class="control-group">
                    	<label class="control-label"><?php _e( "Staff Member Name :", bookings_plus ); ?>
                    		<span class="req">*</span>
                    	</label>
                        <div class="controls">
                        	<input type="text" class="required span12" name="uxEmployeeName" id="uxEmployeeName"/>
                        </div>
                    </div>
                    <div class="control-group" id="groupEmailAddress">
                    	<label class="control-label"><?php _e( "Staff Member Email :", bookings_plus ); ?>
                    		<span class="req">*</span>
                    	</label>
                        <div class="controls">
                        	<input type="text" class="required span12" name="uxEmployeeEmail" id="uxEmployeeEmail"/>
                        </div>
                    </div>
                    <div class="control-group">
                    	<label class="control-label"><?php _e( "Staff Member Phone :", bookings_plus ); ?>
                    		<span class="req">*</span>
                    	</label>
                        <div class="controls">
                        	<input type="text" class="required span12 maskPhone" name="uxEmployeePhone" id="uxEmployeePhone"/>
                        </div>
                    </div>                 
                </div>                  
          	</div>
            <div class="form-actions" style="padding:10px 0px 0px 0px;">
            	<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnAddNewEmployee" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
            </div>          	
		</div>
	</form>
</div>
<div id="addNewService" style="width:700px;display:none">
	<div class="modal-header">	
        <h5><?php _e( "Add New Service", bookings_plus ); ?></h5>
    </div>
	<form id="uxFrmAddServices" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="successMessage" style="display:none">
				<strong><?php _e( "Success! The Service has been saved Successfully.", bookings_plus ); ?></strong>
            </div>
   	  		<p style="padding:10px 10px 0px 0px">
				<span class="label label-important"><?php _e( "Note: You will need to Assign your Employees to the respective Services in order to allow Bookings for your Clients.", bookings_plus ); ?></code>					
			</p> 
          	<div class="block well" style="margin-top:10px;">
                <div class="row-fluid form-horizontal">                            
                	<div class="control-group">
                    	<label class="control-label">
                    		<?php _e( "Service Name :", bookings_plus ); ?><span class="req">*</span>
                    	</label>
                        <div class="controls"><input type="text" class="required span12" name="uxServiceName" id="uxServiceName"/></div>
                    </div>
                    <div class="control-group">
                    	<label class="control-label"><?php _e( "Service Cost (".$costIcon."):", bookings_plus ); ?>
                    		<span class="req">*</span>
                    	</label>
                        <div class="controls">
                        	<input type="text" class="required span12" name="uxServiceCost" id="uxServiceCost"/>
                        </div>
                    </div>
                    
                    <div class="control-group">
		         		<label class="control-label"><?php _e( "Service Type :", bookings_plus );?>
	               			<span class="req">*</span>
	               		</label>
						<div class="controls searchDrop">
			            
							<label class="radio">
								<input type="radio" id="uxServiceTypeEnable" name="uxServiceType" class="style" value="0" onclick="singleBooking();" checked="checked"><?php _e( "Single Booking", bookings_plus );?>
							</label>
							<label class="radio">
								<input type="radio" id="uxServiceTypeDisable" name="uxServiceType" onclick="groupBooking();" class="style"value="1"><?php _e( "Group Bookings", bookings_plus );?>
							</label>		
						</div>
	           		</div>
                    <div class="control-group" id="maxBooking" Style="display: none;">
                    	<label class="control-label">
                    		<?php _e( "Max Bookings<br/>(Each Slot) :", bookings_plus ); ?><span class="req">*</span>
                        </label>
                        <div class="controls">
                        	<input type="text" class="required span12" name="uxMaxBookings" id="uxMaxBookings" value="1"/>
                        </div>
                    </div>
                    <div class="control-group">
                    	<label class="control-label"><?php _e( "Service Time :", bookings_plus ); ?>
                    		<span class="req">*</span>
                        </label>
                        <div class="controls">
                        	<select name="uxServiceHours" class="style required" id="uxServiceHours" >
                            	<?php
									for ($hr = 0; $hr <= 23; $hr++) 
									{
										if ($hr < 10) 
										{
											echo "<option value=0" . $hr . " >0" . $hr . "  Hours</option>";
										}
										else 
										{
											echo "<option value=" . $hr . ">" . $hr . "  Hours</option>";
										}
									}
								?>
                            </select>
                            <select name="uxServiceMins" class="style required" id="uxServiceMins">
                            	<?php
									for ($min = 0; $min < 60; $min += 5) 
									{
										if ($min < 10) 
										{
											echo "<option value=0" . $min . ">0" . $min . " Minutes</option>";
										}
										else
										{
											echo "<option value=" . $min . ">" . $min . "  Minutes</option>";
										}
									}
								?>
                            </select>
                        </div>
                    </div>
                </div>
          	</div>
          	<div class="form-actions" style="padding:10px 0px;">
            	<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnAddNewService" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
            </div>
		</div>
	</form>
</div>
<div id="allocateServices" style="width:700px;display:none">
	<div class="modal-header">
	
        <h5><?php _e( "Assign Services to Staff", bookings_plus ); ?></h5>
    </div>
	<form id="uxFrmAllocateServices" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="allocatedSuccessMessage" style="display:none">
				<strong><?php _e( "Success! The Service has been Assigned Successfully.", bookings_plus ); ?></strong>
	        </div>
			<div class="note note-danger" id="allocatedErrorMessage" style="display:none">
				<strong><?php _e( "Error! Please Choose a Staff Member to Assign Services.", bookings_plus ); ?></strong>
	        </div>
	  		<p style="padding:10px 10px 0px 0px">
				<span class="label label-important"><?php _e( "Note: Please choose Staff Member and then tick the appropriate checkbox next to each service you wish to Assign.", bookings_plus ); ?></code>					
			</p>       
	        <div class="block well" style="margin-top:10px;">
	            <div class="row-fluid form-horizontal">
	            	<div class="control-group">
                    	<label class="control-label">
                    		<?php _e( "Staff Member :", bookings_plus ); ?><span class="req">*</span>
                        </label>
                        <div class="controls">
                        	<?php
								$employees = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM ".employeesTable()." order by EmployeeName ASC"
									)
								);
							?>
							<select name="uxDdlEmployees" class="required" id="uxDdlEmployees" onchange="allocateService();">
	                        	<option value ="opt1"><?php _e( "Please Choose Staff Member", bookings_plus ); ?></option>	
	                            <?php
	                            	for( $flagEmployeeDropdown = 0; $flagEmployeeDropdown < count($employees); $flagEmployeeDropdown++)
								    {
								?>
										<option value ="<?php echo $employees[$flagEmployeeDropdown] -> EmployeeId;?>"><?php echo $employees[$flagEmployeeDropdown] -> EmployeeName;?></option>
								<?php 
									} 
								?>
                            </select>
                            <input type="hidden" id="hdEmployeeId" />	
						</div>
                    </div>
                    <div class="table-overflow">
                        <table class="table table-striped" id="data-table1">
                            <thead>
                                <tr>
                                    <th>
                                    	<input type="checkbox" class="style" id="headerCheckBox" onchange="headerCheckAll();" />
                                    </th>
                                    <th><?php _e( "Service Name", bookings_plus ); ?></th>
                                    <th><?php _e( "Service Time", bookings_plus ); ?></th>
                                    <th><?php _e( "Cost", bookings_plus ); ?></th>
                                    <th><?php _e( "Type", bookings_plus ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            		$allocatedServices = $wpdb->get_results
									(
										$wpdb->prepare
										(
											'SELECT '.servicesTable().'.ServiceId, '.servicesTable().'.ServiceName,  '.servicesTable().'.Type,
											 '.servicesTable().'.ServiceCost,'.servicesTable().'.ServiceMaxBookings, '.servicesTable().'.ServiceShortCode,
											 '.servicesTable().'.ServiceTotalTime, ' . servicesTable() . '.ServiceDisplayOrder
											 FROM '.servicesTable().'  ORDER BY ' . servicesTable() . '.ServiceDisplayOrder ASC '
										)
									);
									
									for($flagAllocate = 0; $flagAllocate < count($allocatedServices); $flagAllocate++)
									{
										$hrs = floor(($allocatedServices[$flagAllocate] -> ServiceTotalTime) / 60);
										$mins = ($allocatedServices[$flagAllocate] -> ServiceTotalTime) % 60;
								?>
		                                <tr>
		                                	<td>
	                                			<input type="checkbox" class="style" id="chkAllocation<?php echo $allocatedServices[$flagAllocate] -> ServiceId; ?>" value="<?php echo $allocatedServices[$flagAllocate] -> ServiceId; ?>" />
		                                	</td>
		                                    <td><?php echo $allocatedServices[$flagAllocate] -> ServiceName;?></td>
												<td><?php
												if($hrs == 0)
												{
													echo $mins;
													_e( " Mins", bookings_plus ); 										
												}
												else if($mins == 0)
												{
													echo $hrs;
													_e( " Hrs", bookings_plus ); 
												}
												else 
												{
													echo $hrs; 
													_e( " Hr ", bookings_plus );
													echo $mins;
													_e( " Mins", bookings_plus );
												}
												?>
												</td>
												<td><?php echo ($costIcon).$allocatedServices[$flagAllocate] -> ServiceCost;?></td>
												<td><?php 
											if($allocatedServices[$flagAllocate]->Type == 0)
											{
												echo "Single Booking";
											}
											else 
											{
												echo "Group Bookings (".$allocatedServices[$flagAllocate] -> ServiceMaxBookings .")";
											}
											?></td>
		                               	</tr>
		                        		<?php
                               		}
										?>
                            </tbody>
                        </table> 
                    </div>                            
	            </div>
	        </div>
	        <div class="form-actions" style="padding:10px 0px;">
           		<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnAssignServices" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
            </div>
	    </div>
    </form>
</div>
<div id="workingHours" style="width:900px;display:none;">
	<div class="modal-header">
		    <h5><?php _e( "Working Hours", bookings_plus ); ?></h5>
    </div>
	<form id="uxFrmWorkingHours" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="workingHoursSuccessMessage" style="display:none">
				<strong><?php _e( "Success! The Working Hours has been updated Successfully.", bookings_plus ); ?></strong>
	        </div>
			<div class="note note-danger" id="WorkingHoursErrorMessage" style="display:none">
				<strong><?php _e( "Error! Please Choose a Staff Member to save Working Hours.", bookings_plus ); ?></strong>
	        </div>			
	        <div class="block well" style="margin-top:10px;">
	            <div class="row-fluid form-horizontal">
	                <div class="control-group">
                    	<label class="control-label"><?php _e( "Staff Member :", bookings_plus ); ?>
                        	<span class="req">*</span>
                        </label>
                        <div class="controls">
                        	<?php
								$employees = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM " . employeesTable() . " order by EmployeeName ASC"
									)
								);
								?>
                            	<select name="uxDdlWorkingEmployees" class="style required" id="uxDdlWorkingEmployees" onchange="employeeWorkingHours();">
	                            	<option value ="opt1"><?php _e( "Please Choose Staff Member", bookings_plus ); ?></option>	
	                              	<?php
	                                	for( $flagEmployeeDropdown = 0; $flagEmployeeDropdown < count($employees); $flagEmployeeDropdown++)
									  	{
								  	?>
										  	<option value ="<?php echo $employees[$flagEmployeeDropdown] -> EmployeeId;?>"><?php echo $employees[$flagEmployeeDropdown] -> EmployeeName;?></option>
								  	<?php 
									 	} 
								  	?>
                              	</select>	
						</div>
                    </div>
	                <div class="table-overflow">
						<table class="table table-striped" id="data-table2">
							<style type="text/css">#data-table2 td {padding:8px 6px}</style>
							<thead>
								<tr>
									<th></th>
							     	<th><?php _e( "Monday", bookings_plus ); ?></th>
							     	<th><?php _e( "Tuesday", bookings_plus ); ?></th>
							        <th><?php _e( "Wednesday", bookings_plus ); ?></th>
							        <th><?php _e( "Thursday", bookings_plus ); ?></th>
							        <th><?php _e( "Friday", bookings_plus ); ?></th>
							        <th><?php _e( "Saturday", bookings_plus ); ?></th>
							        <th><?php _e( "Sunday", bookings_plus ); ?></th>							         
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php _e( "Open / Closed", bookings_plus ); ?></td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenMonday" name="uxDayOpenClosedMonday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedMonday" name="uxDayOpenClosedMonday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>                                     		 									
									</td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenTuesday" name="uxDayOpenClosedTuesday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedTuesday" name="uxDayOpenClosedTuesday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>
                                    </td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenWednesday" name="uxDayOpenClosedWednesday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedWednesday" name="uxDayOpenClosedWednesday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>
                                    </td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenThursday" name="uxDayOpenClosedThursday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedThursday" name="uxDayOpenClosedThursday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>
                                   	</td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenFriday" name="uxDayOpenClosedFriday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedFriday" name="uxDayOpenClosedFriday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>                                     		 	
                                    </td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenSaturday" name="uxDayOpenClosedSaturday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedSaturday" name="uxDayOpenClosedSaturday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>
                                    </td>
									<td>
	                 					<label class="radio">
	                 						<input type="radio" id="uxDayOpenSunday" name="uxDayOpenClosedSunday" class="style" value="1" checked="checked"><?php _e( "Open", bookings_plus ); ?>
	                 					</label>
										<label class="radio">
											<input type="radio" id="uxDayClosedSunday" name="uxDayOpenClosedSunday" class="style" value="0"><?php _e( "Closed", bookings_plus ); ?>
										</label>
                                    </td>
								</tr>
								<tr>
									<td><?php _e( "Start Hours", bookings_plus ); ?></td>	
									<td>
										<select name="uxDdlStartMonday" class="style required" id="uxDdlStartMonday"></select>
									</td>
									<td>
										<select name="uxDdlStartTuesday" class="style required" id="uxDdlStartTuesday"></select>										
									</td>
									<td>
										<select name="uxDdlStartWednesday" class="style required" id="uxDdlStartWednesday"></select>											
									</td>
									<td>
										<select name="uxDdlStartThursday" class="style required" id="uxDdlStartThursday"></select>											
									</td>
									<td>
										<select name="uxDdlStartFriday" class="style required" id="uxDdlStartFriday"></select>											
									</td>
									<td>
										<select name="uxDdlStartSaturday" class="style required" id="uxDdlStartSaturday"></select>											
									</td>
									<td>
										<select name="uxDdlStartSunday" class="style required" id="uxDdlStartSunday"></select>											
									</td>
								</tr>
								<tr>
									<td><?php _e( "End Hours", bookings_plus ); ?></td>
									<td>
										<select name="uxDdlEndMonday" class="style required" id="uxDdlEndMonday"></select>											
									</td>
									<td>
										<select name="uxDdlEndTuesday" class="style required" id="uxDdlEndTuesday"></select>										
									</td>
									<td>
										<select name="uxDdlEndWednesday" class="style required" id="uxDdlEndWednesday"></select>											
									</td>
									<td>
										<select name="uxDdlEndThursday" class="style required" id="uxDdlEndThursday"></select>											
									</td>
									<td>
										<select name="uxDdlEndFriday" class="style required" id="uxDdlEndFriday"></select>											
									</td>
									<td>
										<select name="uxDdlEndSaturday" class="style required" id="uxDdlEndSaturday"></select>											
									</td>
									<td>
										<select name="uxDdlEndSunday" class="style required" id="uxDdlEndSunday"></select>											
									</td>
								</tr>
							</tbody>
						</table>
					</div>
	            </div>
			</div>
			<div class="form-actions" style="padding:10px 0px 0px 0px;">
	    		<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnWorkingHours"  value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
	   		</div>  
		</div>	 		
	</form>
</div>
<div id="addNewCustomer" style="width:900px;display:none">
	<div class="modal-header">	
	    <h5><?php _e( "Add New Client", bookings_plus ); ?></h5>	    	
    </div>
	<div class="note note-success" id="coustomerSuccessMessage" style="display:none;margin:10px">
		<strong>
			<?php _e( "Success! The Client has been saved Successfully.", bookings_plus ); ?>
		</strong>
	</div>
	<div class="note note-danger" id="errorCustomerMessageCheckEmail" style="display:none;margin:10px">
		<strong><?php _e( "Error! This Email Address already exists in our Database. Please try with new one.", bookings_plus ); ?></strong>
     </div>
  	<form id="uxFrmCustomers" class="form-horizontal" method="post" action="#">	
		<div class="block well" style="margin:10px">
	        <div class="body">	        	
	        	<div class="row-fluid nested form-horizontal">
	        		<div class="span6 well">
						<div class="body" style="padding:5px">
					
	                    	<div class="control-group">
	                        	<label class="control-label"><?php _e( "First Name :", bookings_plus ); ?>
	                            	<span class="req">*</span>
	                            </label>
	                            <div class="controls">
	                            	<input type="text" class="required span12" name="uxFirstName" id="uxFirstName"/>
	                            </div>
	                        </div>
			                <div class="control-group">
		                    	<label class="control-label"><?php _e( "Last Name :", bookings_plus ); ?>
		                       		<span class="req">*</span>
		                        </label>
		                        <div class="controls">
		                        	<input type="text" class="required span12" name="uxLastName" id="uxLastName"/>
		                        </div>
		                    </div>
		                    <div class="control-group" id="groupCustomerEmailAddress">
		                    	<label class="control-label">
		                    		<?php _e( "Email :", bookings_plus ); ?>
		                    		<span class="req">*</span>
		                    	</label>
		                        <div class="controls">
		                        	<input type="text" class="required span12" name="uxEmailAddress" id="uxEmailAddress" />
		                        </div>
		                    </div>
		 					<div class="control-group">
		                    	<label class="control-label">
		                    		<?php _e( "Telephone :", bookings_plus ); ?>
		                        </label>
		                        <div class="controls">
		                        	<input type="text" class="required span12 maskPhone" name="uxTelephone" id="uxTelephoneNumber" />
		                        </div>
		                    </div>
		 					<div class="control-group">
		                    	<label class="control-label">
		                    		<?php _e( "Mobile :", bookings_plus ); ?>
		                        </label>
		                        <div class="controls">
		                        	<input type="text" class="required span12 maskPhone" name="uxMobileNumber" id="uxMobileNumber" />
		                        </div>
		                    </div>
		    				<div class="control-group">
		                    	<label class="control-label">
		                    		<?php _e( "Address 1 :", bookings_plus ); ?>
		                        </label>
		                        <div class="controls">
		                        	<input type="text" class="required span12" name="uxAddress1" id="uxAddress1" />
		                        </div>
		                    </div>                          
	                	</div>     
	                </div>
					<div class="span6 well">
						<div class="body"  style="padding:5px">
	 						<div class="control-group">
	                        	<label class="control-label">
	                        		<?php _e( "Address 2 :", bookings_plus ); ?>
	                            </label>
	                            <div class="controls">
	                            	<input type="text" class="required span12" name="uxAddress2" id="uxAddress2" />
	                            </div>
	                        </div>   				  			
	            			<div class="control-group">
	                       		<label class="control-label">
	                       			<?php _e( "City :", bookings_plus ); ?>
	                            </label>
	                            <div class="controls">
	                            	<input type="text" class="required span12" name="uxCity" id="uxCity" />
	                            </div>
	                        </div>
	 						<div class="control-group">
	                        	<label class="control-label">
	                        		<?php _e( "Post Code :", bookings_plus ); ?>	                    
	                            </label>
	                            <div class="controls">
	                            	<input type="text" class="required span12" name="uxPostalCode" id="uxPostalCode" />
	                            </div>
	                        </div>
	 						<div class="control-group">
	                        	<label class="control-label">
	                        		<?php _e( "Country :", bookings_plus ); ?>	                            		
	                            </label>                           
		                        <div class="controls">
				                	<select name="uxCountry" class="style required" id="uxCountry">  
				                    	<?php
				                            $country = $wpdb->get_results
							               	(
									        	$wpdb->prepare
									            (
											    	"SELECT CountryName,CountryId From ".countriesTable()." order by CountryName ASC"
											    )
							                );	
							                $sel_country = $wpdb -> get_var('SELECT CountryName  FROM ' . countriesTable() . ' where CountryUsed = 1');
								           	for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
								            {
									        	if ($sel_country == $country[$flagCountry]->CountryName)
									            {
									        ?>
												    <option value="<?php echo $country[$flagCountry]->CountryId;?>" selected='selected'><?php echo $country[$flagCountry]->CountryName;?></option>
										    <?php 
									            }
									            else
									           	{
									        ?>
										   	 		<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
									       	<?php 
									            }
								            }
								            ?>                      		 	
				                    </select>
		                        </div>
		                    </div>
		 					<div class="control-group">
		                    	<label class="control-label">
		                        	<?php _e( "Comments :", bookings_plus ); ?>
		                        </label>
		                        <div class="controls">
		                        	<textarea class="required span12" name="uxComments" id="uxComments" style="height:80px"></textarea>
		                        </div>
		                    </div> 
	            		</div>
	                </div>              
	    		</div>
			</div>
		</div>
	    <div class="form-actions" style="padding:0px 10px 10px 0px;">
			<input type="submit" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnAddClient" class="btn btn-info pull-right">
		</div>  
    </form>	
</div>
<div id="EditBooking" style="width:650px;display:none">
	<form id="uxEditBooking" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="uxEditBookingMessage" style="display:none">
				<strong><?php _e( "Success! The Booking has been updated Successfully.", bookings_plus ); ?></strong>
		    </div>
	        <div id="bookingDetails"></div>   				
		</div>	
		<input type="hidden" id="bookingId" value="" />
		<div class="form-actions" style="padding:0px 15px 10px 15px">
			<input type="submit" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
		</div>
	</form>	             	
</div>
<a id="hiddenclicker" href="#adminEmailId" class="fancybox" ></a>
<div id="adminEmailId" style="display: none;width:650px;">
	<div class="modal-header">	
 		<h5><?php _e( "Admin Notification Settings", bookings_plus ); ?></h5>	    	
    </div>
	<form id="uxFrmAdminEmail" class="form-horizontal" method="post" action="#">	
		<div class="block well" style="margin:10px">
	        <div class="body">
	        	<div class="note note-success" id="uxAdminEmailMessage" style="display:none">
					<strong><?php _e( "Success! Admin Notifications Saved", bookings_plus ); ?></strong>				
		    	</div>
		    	<p style="padding:10px 10px 0px 0px">
					<span class="label label-info"><?php _e( "Note: To receive notifications of your client bookings, kindly fill in the email address.", bookings_plus ); ?></span>					
					<span class="label label-important" style="margin-top:5px;"><?php _e( "Note: Without Email Address, the system won't work as expected.", bookings_plus ); ?></span>
				</p>   
	        	<div class="row-fluid form-horizontal">  
		        	<div class="control-group">
		                 <label class="control-label"><?php _e( "Email Address :", bookings_plus ); ?>
		                   <span class="req">*</span>
		                 </label>
		                 <div class="controls">
		                      <input type="text" class="required span12" name="uxAdminEmail" id="uxAdminEmail"/>
		                 </div>
		           </div>
		           <div class="control-group">
		                <div class="controls">
		                      <input type="checkbox" class="style" id="uxChkAdminEmail" name="uxChkAdminEmail" checked="checked" />
		                      <?php _e( "Yes, I may consider buying Full Version at later stage.", bookings_plus ); ?>
		                </div>
		           </div>
		       	</div>
	       	</div>
	    </div>
	    <div class="form-actions" style="padding:0px 10px 10px 0px;">
			<input type="submit" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnAdminEmail" class="btn btn-info pull-right">
		</div>  
	</form>
</div>
<script type="text/javascript">
var uri = "<?php echo $url; ?>";  	
	jQuery(document).ready(function() {
	    jQuery("#uxMaxBookings").keydown(function(event) {
	        // Allow: backspace, delete, tab, escape, and enter
	        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
	             // Allow: Ctrl+A
	            (event.keyCode == 65 && event.ctrlKey === true) || 
	             // Allow: home, end, left, right
	            (event.keyCode >= 35 && event.keyCode <= 39)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        else {
	            // Ensure that it is a number and stop the keypress
	            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                event.preventDefault(); 
	            }   
	        }
	    });
	});
	jQuery('#uxEmployeeColor').colorpicker().on('changeColor', function(ev){
			jQuery('#picker').css('background-color',ev.color.toHex());
			jQuery('#uxEmployeeColor').val(ev.color.toHex());
	});
  	          
	jQuery(".maskPhone").mask("(999) 999-9999");      
	jQuery.ajax
	({
		type: "POST",
		data: "target=getServiceCount&action=getAjaxExecuted",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxServiceCount").html(data);
			jQuery("#uxDashboardServiceCount").html(data);									
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getEmployeeCount&action=getAjaxExecuted",
		url:  ajaxurl,
		success: function(data) 
		{
			jQuery("#uxEmployeesCount").html(data);
			jQuery("#uxDashboardEmployeesCount").html(data);														
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getCustomerCount&action=getAjaxExecuted",
		url:  ajaxurl,
		success: function(data) 
		{
			
			jQuery("#uxCustomersCount").html(data);
			jQuery("#uxDashboardCustomersCount").html(data);									
		}
	});
	jQuery.ajax
	({
		type: "POST",
		data: "target=getBookingCount&action=getAjaxExecuted",
		url:  ajaxurl,
		success: function(data) 
		{
			
			jQuery("#uxBookingsCount").html(data);
			jQuery("#uxDashboardBookingsCount").html(data);
									
		}
	});
	function checkExistingEmail(label)
	{
		var uxEmployeeEmail = jQuery('#uxEmployeeEmail').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeEmail="+uxEmployeeEmail+"&target=checkExistingEmailAction&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{  	
				var checkEmailEmployee = jQuery.trim(data);
				if(checkEmailEmployee == "existingEmployeeEmail")
				{
			    	jQuery('#errorMessageCheckEmail').css('display','block');
			    	jQuery('#groupEmailAddress').attr('class','control-group errors');
			    	label
		    		.text('Email already exists!').addClass('errors')
		    		.closest('.control-group').addClass('errors');
		        }
		        else
		        {
		        	jQuery('#errorMessageCheckEmail').css('display','none');
			    	jQuery('#groupEmailAddress').attr('class','control-group valid');
			    	label
	    			.text('Success!').addClass('valid')
	    			.closest('.control-group').addClass('success');
		        }
			}
		});
	}		
	
	jQuery.validator.addMethod("notEqualTo", function(value, element, param) 
	{
 		return this.optional(element) || value != param;
 	},"");		
 	
 	jQuery("#uxFrmAdminEmail").validate
	({
		rules: 
		{
			
			uxAdminEmail:
			{
				required : true,
				email:true
			},
			
		},			
	    highlight: function(label) 
	    {	    	
	    	if(jQuery(label).closest('.control-group').hasClass('success'))
	    	{
	    		jQuery(label).closest('.control-group').removeClass('success');
	    	}
	    	jQuery(label).closest('.control-group').addClass('errors');
	    },
		success: function(label) 
		{
	    	
	    		label
	    		.text('Success!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    	
	   	},
	    submitHandler: function(form) 
	   	{
	   		var uxAdminEmail = jQuery('#uxAdminEmail').val();
	   		var uxChkAdminEmail = jQuery("#uxChkAdminEmail").prop('checked');
	   		
	   		jQuery.ajax
			({
				type: "POST",
				data: "uxAdminEmail="+uxAdminEmail+"&uxChkAdminEmail="+uxChkAdminEmail+"&target=insertAdminEmail&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					jQuery('#uxAdminEmailMessage').css('display','block');
					setTimeout(function() 
					{
					   	jQuery('#uxAdminEmailMessage').css('display','none');
					   	var checkPage = "<?php echo $_REQUEST['page']; ?>";
					   	window.location.href = "admin.php?page="+checkPage;
					}, 2000);	
				}
			});  
		}
	});
 	
 	
	jQuery("#uxFrmAddEmployees").validate
	({
		rules: 
		{
			uxEmployeeName: "required",
			uxEmployeeEmail:
			{
				required : true,
				email:true
			},
			uxEmployeePhone: "required"
		},			
	    highlight: function(label) 
	    {	    	
	    	if(jQuery(label).closest('.control-group').hasClass('success'))
	    	{
	    		jQuery(label).closest('.control-group').removeClass('success');
	    	}
	    	jQuery(label).closest('.control-group').addClass('errors');
	    },
		success: function(label) 
		{
	    	if (label.attr('for') == "uxEmployeeEmail") 
	    	{
	    		checkExistingEmail(label);
	    	}
	    	else
	    	{
	    		label
	    		.text('Success!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    	}
	   	},
	    submitHandler: function(form) 
	   	{
	   		var uxEmployeeName = jQuery('#uxEmployeeName').val();
			var uxEmployeeNameEncode  = encodeURIComponent(uxEmployeeName);
			var uxEmployeeEmail = jQuery('#uxEmployeeEmail').val();
			var uxEmployeePhone = jQuery('#uxEmployeePhone').val();
			var uxEmployeeUniqueCode = jQuery('#uxEmployeeUniqueCode').val();
			var uxEmployeeColor = jQuery('#uxEmployeeColor').val();
			jQuery.ajax
			({
				type: "POST",
				data: "uxEmployeeEmail="+uxEmployeeEmail+"&target=checkExistingEmailAction&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					var checkEmailEmployee = jQuery.trim(data);
					if(checkEmailEmployee == "existingEmployeeEmail")
			    	{
			    		jQuery('#errorMessageCheckEmail').css('display','block');
			    	}
			    	else
			    	{  	
				    	jQuery.ajax
						({
							type: "POST",
							data: "uxEmployeeNameEncode="+uxEmployeeNameEncode+"&uxEmployeeEmail="+uxEmployeeEmail+"&uxEmployeePhone="+uxEmployeePhone+
							"&uxEmployeeUniqueCode="+uxEmployeeUniqueCode+"&uxEmployeeColor="+uxEmployeeColor+"&target=addEmployee&action=getAjaxExecuted",
							url:  ajaxurl,
							success: function(data) 
							{  
						    	jQuery('#errorMessageCheckEmail').css('display','none');
						    	jQuery('#addEmployeeSuccessMessage').css('display','block');
						   		setTimeout(function() 
						    	{
						        	jQuery('#addEmployeeSuccessMessage').css('display','none');
						        	var checkPage = "<?php echo $_REQUEST['page']; ?>";
						        	window.location.href = "admin.php?page="+checkPage;
						        }, 2000);	
						    }   
						});
					}
				}
			});  
		}
	});
	jQuery(document).ready(function()
	{
		jQuery('.fancybox').fancybox();		
	});
	jQuery('#btnAddNewEmployee').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	jQuery('#btnAddNewService').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	jQuery('#btnAddClient').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	jQuery('#btnWorkingHours').click(function ()
	{
		var employeeDdId = jQuery('#uxDdlWorkingEmployees').val();
		if(employeeDdId == "opt1")
		{
			jQuery('#WorkingHoursErrorMessage').css('display','block');
		}
		else
		{
			jQuery('#WorkingHoursErrorMessage').css('display','none');
		}
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});		
	jQuery('#btnAssignServices').click(function ()
	{
		var employeeDdId = jQuery('#uxDdlEmployees').val();
		if(employeeDdId == "opt1")
		{
			jQuery('#allocatedErrorMessage').css('display','block');
		}
		else
		{
			jQuery('#allocatedErrorMessage').css('display','none');
		}
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	
	jQuery('#uxServiceMins').val(30);
	jQuery("#uxFrmAddServices").validate
	({
		rules: 
		{
			uxServiceName: "required",
			uxServiceCost: 
			{
				required: true,
				number: true
			},
			uxMaxBookings: 
			{
				required: true,
				digits: true
			},
			uxServiceHours:
			{
				required : true,
			},
			uxServiceMins:
			{
				required : true,
			}
		},			
		highlight: function(label) 
		{	    	
			if(jQuery(label).closest('.control-group').hasClass('success'))
			{
		    	jQuery(label).closest('.control-group').removeClass('success');
		    }
		    jQuery(label).closest('.control-group').addClass('errors');
		},
		success: function(label) 
		{
			label
			.text('Success!').addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) 
		{
			var uxServiceName = jQuery('#uxServiceName').val();
			var uxServiceNameEncode  = encodeURIComponent(uxServiceName);
			var uxServiceCost = jQuery('#uxServiceCost').val();
			var uxServiceHours = jQuery('#uxServiceHours').val();
			var uxServiceMins = jQuery('#uxServiceMins').val();
			var uxMaxBookings = jQuery('#uxMaxBookings').val();
			var uxServiceType = jQuery('input:radio[name=uxServiceType]:checked').val();
			if(uxServiceType == 1 && uxMaxBookings > 1)
			{
				jQuery.ajax
				({
					type: "POST",
					data: "uxServiceNameEncode="+uxServiceNameEncode+"&uxServiceCost="+uxServiceCost+"&uxServiceHours="+uxServiceHours+
					"&uxServiceMins="+uxServiceMins+"&uxMaxBookings="+uxMaxBookings+"&uxServiceType="+uxServiceType+"&target=addService&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
					{  
				    	jQuery('#successMessage').css('display','block');
				    	setTimeout(function() 
				    	{
				        	jQuery('#successMessage').css('display','none');
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
				        }, 2000);	
				    }   
				});
			}
			else if(uxServiceType == 0)
		   	{
		   		jQuery.ajax
				({
					type: "POST",
					data: "uxServiceNameEncode="+uxServiceNameEncode+"&uxServiceCost="+uxServiceCost+"&uxServiceHours="+uxServiceHours+
					"&uxServiceMins="+uxServiceMins+"&uxMaxBookings="+uxMaxBookings+"&uxServiceType="+uxServiceType+"&target=addService&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
					{  
				    	jQuery('#successMessage').css('display','block');
				    	setTimeout(function() 
				    	{
				        	jQuery('#successMessage').css('display','none');
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
				        }, 2000);	
				    }   
				});
		   	}
			else
			{
				bootbox.alert("<?php _e( "Please Insert Correct Max Bookings Value", bookings_plus ); ?>");
			}    
		}
	});
	function allocateService()
	{
		var employeeDdId = jQuery('#uxDdlEmployees').val();
		jQuery('#hdEmployeeId').val(employeeDdId);
		jQuery('#allocatedErrorMessage').css('display','none');
		jQuery.ajax
		({
			type: "POST",
			data: "employeeDdId="+employeeDdId+"&target=employeeDdIdOnchange&action=getAjaxExecuted",
			url: ajaxurl,
			success: function(data) 
			{  	
				var oTable = jQuery('#data-table1').dataTable();
				jQuery("span", oTable.fnGetNodes()).each(function()
				{
					jQuery(this).removeAttr("class");
				});
				jQuery("#allocateServices").append(data);
		 	}
		});
	}
	function headerCheckAll()
	{
		var headerCheck = jQuery("#uniform-headerCheckBox span").attr("class");	
		
		if(headerCheck !="checked")
		{		
			jQuery.ajax
			({
				type: "POST",
				data: "&target=checkAllServices&action=getAjaxExecuted",
				url:ajaxurl,
				success: function(data) 
				{  	

					jQuery("#allocateServices").append(data);
			 	}
			});
		}
		else
		{
			jQuery.ajax
			({
				type: "POST",
				data: "target=UnSelectAllServices&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{  	
					jQuery("#allocateServices").append(data);
			 	}
			});
		}
		
	}
	jQuery("#uxFrmAllocateServices").validate
	({
		rules: 
		{
			uxDdlEmployees: 
			{
				required: true,
				notEqualTo : "opt1"
			}
		},			
		highlight: function(label) 
		{	
				
		},
		success: function(label) 
		{
				
		},
		submitHandler: function(form) 
		{
			var employeeId = jQuery('#uxDdlEmployees').val();
			jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+employeeId+"&target=deleteAllocationEntries&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					var oTable = jQuery('#data-table1').dataTable();
					jQuery(".checked input", oTable.fnGetNodes()).each(function()
					{
						var serviceId = jQuery(this).val();
						jQuery.ajax
						({
							type: "POST",
							data: "employeeId="+employeeId+"&serviceId="+serviceId+"&target=allocationEntries&action=getAjaxExecuted",
							url:  ajaxurl,
							success: function(data) 
							{
							
							}
						});
					});
					jQuery('#allocatedSuccessMessage').css('display','block');
					setTimeout(function() 
					{
						jQuery('#allocatedSuccessMessage').css('display','none');
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);				
				}
			});
		}
	});					    
	oTable = jQuery('#data-table1').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": 't<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "<span>Show entries:</span> _MENU_"
		},
		
		
	});
	jQuery(document).ready(function() 
	{
		<?php
		$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
		if($timeFormats ==0)
		{
		?>
		jQuery.ajax
		({
			type: "POST",
			data: "target=employeesStartWorkingHours&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery('#uxDdlStartMonday').html(data);
				jQuery('#uniform-uxDdlStartMonday span').html("9:00 am");
				jQuery('#uxDdlStartTuesday').html(data);
				jQuery('#uniform-uxDdlStartTuesday span').html("9:00 am");
				jQuery('#uxDdlStartWednesday').html(data);
				jQuery('#uniform-uxDdlStartWednesday span').html("9:00 am");
				jQuery('#uxDdlStartThursday').html(data);
				jQuery('#uniform-uxDdlStartThursday span').html("9:00 am");
				jQuery('#uxDdlStartFriday').html(data);
				jQuery('#uniform-uxDdlStartFriday span').html("9:00 am");
				jQuery('#uxDdlStartSaturday').html(data);
				jQuery('#uniform-uxDdlStartSaturday span').html("9:00 am");
				jQuery('#uxDdlStartSunday').html(data);
				jQuery('#uniform-uxDdlStartSunday span').html("9:00 am");
			}
		});  
		jQuery.ajax
		({
			type: "POST",
			data: "target=employeesEndWorkingHours&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery('#uxDdlEndMonday').html(data);
				jQuery('#uniform-uxDdlEndMonday span').html("5:00 pm");
				jQuery('#uxDdlEndTuesday').html(data);
				jQuery('#uniform-uxDdlEndTuesday span').html("5:00 pm");
				jQuery('#uxDdlEndWednesday').html(data);
				jQuery('#uniform-uxDdlEndWednesday span').html("5:00 pm");
				jQuery('#uxDdlEndThursday').html(data);
				jQuery('#uniform-uxDdlEndThursday span').html("5:00 pm");
				jQuery('#uxDdlEndFriday').html(data);
				jQuery('#uniform-uxDdlEndFriday span').html("5:00 pm");
				jQuery('#uxDdlEndSaturday').html(data);
				jQuery('#uniform-uxDdlEndSaturday span').html("5:00 pm");
				jQuery('#uxDdlEndSunday').html(data);
				jQuery('#uniform-uxDdlEndSunday span').html("5:00 pm");
				            	
			}
		});
		<?php
		}
		else
		{
		?>
		jQuery.ajax
		({
			type: "POST",
			data: "target=employeesStartWorkingHours&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery('#uxDdlStartMonday').html(data);
				jQuery('#uniform-uxDdlStartMonday span').html("09:00");
				jQuery('#uxDdlStartTuesday').html(data);
				jQuery('#uniform-uxDdlStartTuesday span').html("09:00");
				jQuery('#uxDdlStartWednesday').html(data);
				jQuery('#uniform-uxDdlStartWednesday span').html("09:00");
				jQuery('#uxDdlStartThursday').html(data);
				jQuery('#uniform-uxDdlStartThursday span').html("09:00");
				jQuery('#uxDdlStartFriday').html(data);
				jQuery('#uniform-uxDdlStartFriday span').html("09:00");
				jQuery('#uxDdlStartSaturday').html(data);
				jQuery('#uniform-uxDdlStartSaturday span').html("09:00");
				jQuery('#uxDdlStartSunday').html(data);
				jQuery('#uniform-uxDdlStartSunday span').html("09:00");
			}
		});  
		jQuery.ajax
		({
			type: "POST",
			data: "target=employeesEndWorkingHours&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery('#uxDdlEndMonday').html(data);
				jQuery('#uniform-uxDdlEndMonday span').html("17:00");
				jQuery('#uxDdlEndTuesday').html(data);
				jQuery('#uniform-uxDdlEndTuesday span').html("17:00");
				jQuery('#uxDdlEndWednesday').html(data);
				jQuery('#uniform-uxDdlEndWednesday span').html("17:00");
				jQuery('#uxDdlEndThursday').html(data);
				jQuery('#uniform-uxDdlEndThursday span').html("17:00");
				jQuery('#uxDdlEndFriday').html(data);
				jQuery('#uniform-uxDdlEndFriday span').html("17:00");
				jQuery('#uxDdlEndSaturday').html(data);
				jQuery('#uniform-uxDdlEndSaturday span').html("17:00");
				jQuery('#uxDdlEndSunday').html(data);
				jQuery('#uniform-uxDdlEndSunday span').html("17:00");
				            	
			}
		});
		<?php	
		}
		?>  
	});	
	jQuery("#uxFrmWorkingHours").validate
	({
		rules: 
		{		
			uxDdlWorkingEmployees: 
			{
				required: true,
				notEqualTo : "opt1"
			}					
		},			
		highlight: function(label) 
		{	    	
			if(jQuery(label).closest('.control-group').hasClass('success'))
			{
		    	jQuery(label).closest('.control-group').removeClass('success');
			}
			jQuery(label).closest('.control-group').addClass('errors');
		},
		success: function(label) 
		{
			label
			.text('Success!').addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) 
		{
			var uxDayOpenClosedMonday = jQuery('input:radio[name=uxDayOpenClosedMonday]:checked').val();
			var uxDdlStartMonday = jQuery('#uxDdlStartMonday').val();
			var uxDdlEndMonday = jQuery('#uxDdlEndMonday').val();
			var workingDayMonday = "Mon";
			var uxDdlWorkingEmployees = jQuery('#uxDdlWorkingEmployees').val();
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedMonday+"&uxDdlStart="+uxDdlStartMonday+"&uxDdlEnd="+uxDdlEndMonday+
				"&workingDay="+workingDayMonday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					
				}
			});
			var uxDayOpenClosedTuesday = jQuery('input:radio[name=uxDayOpenClosedTuesday]:checked').val();
			var uxDdlStartTuesday = jQuery('#uxDdlStartTuesday').val();
		 	var uxDdlEndTuesday = jQuery('#uxDdlEndTuesday').val();
			var workingDayTuesday = "Tue";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedTuesday+"&uxDdlStart="+uxDdlStartTuesday+"&uxDdlEnd="+uxDdlEndTuesday+
				"&workingDay="+workingDayTuesday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
							
				}
			});
			var uxDayOpenClosedWednesday = jQuery('input:radio[name=uxDayOpenClosedWednesday]:checked').val();
			var uxDdlStartWednesday = jQuery('#uxDdlStartWednesday').val();
		 	var uxDdlEndWednesday = jQuery('#uxDdlEndWednesday').val();
			var workingDayWednesday = "Wed";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedWednesday+"&uxDdlStart="+uxDdlStartWednesday+"&uxDdlEnd="+uxDdlEndWednesday+
				"&workingDay="+workingDayWednesday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
						        	
				}
			});
			var uxDayOpenClosedThursday = jQuery('input:radio[name=uxDayOpenClosedThursday]:checked').val();
		 	var uxDdlStartThursday = jQuery('#uxDdlStartThursday').val();
		  	var uxDdlEndThursday = jQuery('#uxDdlEndThursday').val();
			var workingDayThursday = "Thu";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedThursday+"&uxDdlStart="+uxDdlStartThursday+"&uxDdlEnd="+uxDdlEndThursday+
				"&workingDay="+workingDayThursday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
						        	
				 }
			});
			var uxDayOpenClosedFriday = jQuery('input:radio[name=uxDayOpenClosedFriday]:checked').val();
		  	var uxDdlStartFriday = jQuery('#uxDdlStartFriday').val();
			var uxDdlEndFriday = jQuery('#uxDdlEndFriday').val();
			var workingDayFriday = "Fri";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedFriday+"&uxDdlStart="+uxDdlStartFriday+"&uxDdlEnd="+uxDdlEndFriday+
				"&workingDay="+workingDayFriday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
						        	
				}
			});
			var uxDayOpenClosedSaturday = jQuery('input:radio[name=uxDayOpenClosedSaturday]:checked').val();
		 	var uxDdlStartSaturday = jQuery('#uxDdlStartSaturday').val();
		 	var uxDdlEndSaturday = jQuery('#uxDdlEndSaturday').val();
		 	var workingDaySaturday = "Sat";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedSaturday+"&uxDdlStart="+uxDdlStartSaturday+"&uxDdlEnd="+uxDdlEndSaturday+
				"&workingDay="+workingDaySaturday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
						        	
				}
			});
			var uxDayOpenClosedSunday = jQuery('input:radio[name=uxDayOpenClosedSunday]:checked').val();
			var uxDdlStartSunday = jQuery('#uxDdlStartSunday').val();
			var uxDdlEndSunday = jQuery('#uxDdlEndSunday').val();
			var workingDaySunday = "Sun";
			jQuery.ajax
			({
				type: "POST",
				data: "uxDayOpenClosed="+uxDayOpenClosedSunday+"&uxDdlStart="+uxDdlStartSunday+"&uxDdlEnd="+uxDdlEndSunday+
				"&workingDay="+workingDaySunday+"&uxDdlWorkingEmployees="+uxDdlWorkingEmployees+"&target=employeesWorkingHours&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					jQuery('#workingHoursSuccessMessage').css('display','block');
					setTimeout(function() 
					{
						jQuery('#workingHoursSuccessMessage').css('display','none');
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
				}
			});
		}
	});
	function employeeWorkingHours()
	{	
		var uxEmployeeId = jQuery('#uxDdlWorkingEmployees').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay=Mon&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				
				var format = data.split(',');
				jQuery('#uxDdlStartMonday').val(format[1]);
				jQuery('#uniform-uxDdlStartMonday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedMonday').attr('checked','checked');
					jQuery('#uxDayOpenClosedMonday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenMonday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedMonday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedMonday').attr('checked','checked');
					jQuery('#uxDayOpenMonday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedMonday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenMonday span').removeAttr('class');
				}
			}
		});
		var workingDayTue = "Tue";
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayTue+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartTuesday').val(format[1]);
				jQuery('#uniform-uxDdlStartTuesday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedTuesday').attr('checked','checked');
					jQuery('#uxDayOpenClosedTuesday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenTuesday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedTuesday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedTuesday').attr('checked','checked');
					jQuery('#uxDayOpenTuesday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedTuesday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenTuesday span').removeAttr('class');
				}
			}
		});
		var workingDayWed = "Wed";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayWed+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartWednesday').val(format[1]);
				jQuery('#uniform-uxDdlStartWednesday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedWednesday').attr('checked','checked');
					jQuery('#uxDayOpenClosedWednesday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenWednesday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedWednesday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedWednesday').attr('checked','checked');
					jQuery('#uxDayOpenWednesday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedWednesday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenWednesday span').removeAttr('class');
				}
			}
		});
		var workingDayThu = "Thu";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayThu+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartThursday').val(format[1]);
				jQuery('#uniform-uxDdlStartThursday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedThursday').attr('checked','checked');
					jQuery('#uxDayOpenClosedThursday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenThursday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedThursday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedThursday').attr('checked','checked');
					jQuery('#uxDayOpenThursday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedThursday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenThursday span').removeAttr('class');
				}
			}
		});
		var workingDayFri = "Fri";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayFri+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartFriday').val(format[1]);
				jQuery('#uniform-uxDdlStartFriday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenFriday').attr('checked','checked');
					jQuery('#uxDayClosedFriday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenFriday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedFriday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedFriday').attr('checked','checked');
					jQuery('#uxDayOpenFriday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedFriday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenFriday span').removeAttr('class');
				}
			}
		});
		var workingDaySat = "Sat";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDaySat+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartSaturday').val(format[1]);
				jQuery('#uniform-uxDdlStartSaturday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedSaturday').attr('checked','checked');
					jQuery('#uxDayOpenClosedSaturday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenSaturday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedSaturday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedSaturday').attr('checked','checked');
					jQuery('#uxDayOpenSaturday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedSaturday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenSaturday span').removeAttr('class');
				}
			}
		});
		var workingDaySun = "Sun";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDaySun+"&target=convertTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlStartSunday').val(format[1]);
				jQuery('#uniform-uxDdlStartSunday span').html(format[0]);
				if(format[2]==1)
				{
					jQuery('#uxDayOpenClosedSunday').attr('checked','checked');
					jQuery('#uxDayOpenClosedSunday').removeAttr('checked');
					jQuery('#uniform-uxDayOpenSunday span').attr('class','checked');
					jQuery('#uniform-uxDayClosedSunday span').removeAttr('class');
				}
				else
				{
					jQuery('#uxDayClosedSunday').attr('checked','checked');
					jQuery('#uxDayOpenSunday').removeAttr('checked');
					jQuery('#uniform-uxDayClosedSunday span').attr('class','checked');
					jQuery('#uniform-uxDayOpenSunday span').removeAttr('class');
				}
			}
		});
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay=Mon&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndMonday').val(format[1]);
				jQuery('#uniform-uxDdlEndMonday span').html(format[0]);
			}
		});
		var workingDayTue = "Tue";
	   	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayTue+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndTuesday').val(format[1]);
				jQuery('#uniform-uxDdlEndTuesday span').html(format[0]);
			}
		});
		var workingDayWed = "Wed";
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayWed+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndWednesday').val(format[1]);
				jQuery('#uniform-uxDdlEndWednesday span').html(format[0]);
			}
		});
		var workingDayThu = "Thu";
	 	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayThu+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndThursday').val(format[1]);
				jQuery('#uniform-uxDdlEndThursday span').html(format[0]);
			}
		});
		var workingDayFri = "Fri";
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDayFri+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndFriday').val(format[1]);
				jQuery('#uniform-uxDdlEndFriday span').html(format[0]);
			}
		});
		var workingDaySat = "Sat";
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDaySat+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndSaturday').val(format[1]);
				jQuery('#uniform-uxDdlEndSaturday span').html(format[0]);
			}
		});
		var workingDaySun = "Sun";
	 	jQuery.ajax
		({
			type: "POST",
			data: "uxEmployeeId="+uxEmployeeId+"&workingDay="+workingDaySun+"&target=convertEndTime&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				var format = data.split(',');
				jQuery('#uxDdlEndSunday').val(format[1]);
				jQuery('#uniform-uxDdlEndSunday span').html(format[0]);
			}
		});
	}
	function checkCustomerExistingEmail(label)
	{
		var uxEmailAddress = jQuery('#uxEmailAddress').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmailAddress="+uxEmailAddress+"&target=checkExistingCustomerEmailAction&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{  	
				var check = jQuery.trim(data);
				if(check == "existingCustomerEmployeeEmail")
				{
			    	jQuery('#errorCustomerMessageCheckEmail').css('display','block');
			    	jQuery('#groupCustomerEmailAddress').attr('class','control-group errors');
			    	label
		    		.text('Email already exists!').addClass('errors')
		    		.closest('.control-group').addClass('errors');
		    		
		        }
		        else
		        {
		        	jQuery('#errorCustomerMessageCheckEmail').css('display','none');
			    	jQuery('#groupCustomerEmailAddress').attr('class','control-group valid');
			    	label
	    			.text('Success!').addClass('valid')
	    			.closest('.control-group').addClass('success');
	    			
		        }
			}
		});
	}			    	    
	jQuery("#uxFrmCustomers").validate
	({
		rules: 
		{
			uxFirstName: "required",
			uxLastName: "required",
			uxEmailAddress:
			{
				required:true,
				email:true
			},
			uxTelephone:
			{
				required:false
			},
			uxMobileNumber:
			{
				required:false
			},
			uxAddress1:
			{
				required:false
			},
			uxAddress2:
			{
				required:false
			},
			uxCity:
			{
				required:false
			},
			uxPostalCode:
			{
				required:false
			},
			uxCountry:
			{
				required:false
			},
			uxComments:
			{
				required:false
			}																									
					
		},				
		highlight: function(label) 
		{	    	
			if(jQuery(label).closest('.control-group').hasClass('success'))
			{
		    	jQuery(label).closest('.control-group').removeClass('success');
			}
			jQuery(label).closest('.control-group').addClass('errors');
		},
		success: function(label) 
		{
		
	    	if (label.attr('for') == "uxEmailAddress") 
	    	{
	    		checkCustomerExistingEmail(label);
	    	}
	    	else
	    	{
	    		label
	    		.text('Success!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    		 jQuery.fancybox.update();
	    	}
	  	},
		submitHandler: function(form) 
		{
			var uxFirstName = jQuery('#uxFirstName').val();
	    	var uxLastName = jQuery('#uxLastName').val();
			var uxEmailAddress = jQuery('#uxEmailAddress').val();
			var uxTelephoneNumber = jQuery('#uxTelephoneNumber').val();
			var uxMobileNumber = jQuery('#uxMobileNumber').val();
			var uxAddress1 = jQuery('#uxAddress1').val();
			var uxAddress2 = jQuery('#uxAddress2').val();
			var uxCity = jQuery('#uxCity').val();
			var uxPostalCode = jQuery('#uxPostalCode').val();
			var uxCountry = jQuery('#uxCountry').val();
			var uxComments = jQuery('#uxComments').val();
			
			jQuery.ajax
			({
				type: "POST",
				data: "uxEmailAddress="+uxEmailAddress+"&target=checkExistingCustomerEmailAction&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					var check = jQuery.trim(data);
			    	if(check == "existingCustomerEmployeeEmail")
			    	{
			    		jQuery('#errorCustomerMessageCheckEmail').css('display','block');
			    	}
			    	else
			    	{  	
							jQuery.ajax
							({
								type: "POST",
								data: "uxFirstName="+uxFirstName+"&uxLastName="+uxLastName+"&uxEmailAddress="+uxEmailAddress+"&uxTelephoneNumber="
								+uxTelephoneNumber+"&uxMobileNumber="+uxMobileNumber+"&uxAddress1="+uxAddress1+"&uxAddress2="+uxAddress2+
								"&uxCity="+uxCity+"&uxPostalCode="+uxPostalCode+"&uxCountry="+uxCountry+"&uxComments="+uxComments+
								"&target=addCustomers&action=getAjaxExecuted",
								url:  ajaxurl,
								success: function(data) 
								{  			                
									jQuery('#errorCustomerMessageCheckEmail').css('display','none');
							    	jQuery('#coustomerSuccessMessage').css('display','block');
							    	setTimeout(function() 
							    	{
							    		jQuery('#coustomerSuccessMessage').css('display','none');
										var checkPage = "<?php echo $_REQUEST['page']; ?>";
										window.location.href = "admin.php?page="+checkPage;
							       	}, 2000);	
							    }   
							}); 
					}
				}
			}); 
		}
	});
	function deleteDayOff(employeeId)
	{
		bootbox.confirm("<?php _e( "Are you sure you want to delete this Day Off?", bookings_plus ); ?>", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type: "POST",
					data: "employeeId="+employeeId+"&target=deleteDayOff&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
					{
						setTimeout(function() 
						{
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					}
				});
			}
		});
	}
	function deleteTimeOff(employeeId)
	{
		bootbox.confirm("<?php _e( "Are you sure you want to delete this Time Off?", bookings_plus ); ?>", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type: "POST",
					data: "employeeId="+employeeId+"&target=deleteTimeOff&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
					{
						setTimeout(function() 
						{
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					}
				});
			}
		});
	}
  function editBooking(e)
    {
    	bookingId = e;
    	jQuery.ajax
		({
			type: "POST",
			data: "bookingId="+bookingId+"&target=updatebooking&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				jQuery('#bookingDetails').html(data);
				jQuery.fancybox.update();
			}	
		});  	
    }    	

    function cancellBooking(bookingId)
    {
    	bootbox.confirm("<?php _e( "Are you sure you want to Cancel this Booking?", bookings_plus ); ?>", function(confirmed)
    	{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type: "POST",
					data: "bookingId="+bookingId+"&target=cancelBooking&action=getAjaxExecuted",
				 	url:  ajaxurl,
					success: function(data) 
				    {  
				    	var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
				    }
				});
			}
		});
    }
    function deleteBooking(bookingId)
    {
    	bootbox.confirm("<?php _e( "Are you sure you want to delete this Booking?", bookings_plus ); ?>", function(confirmed)
    	{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.ajax
				({
					type: "POST",
					data: "bookingId="+bookingId+"&target=deleteBooking&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
				    {  
				    	var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
				    }
				});
			}
		});
    }
    jQuery("#uxEditBooking").validate
	({
		rules: 
		{
				
		},			
		highlight: function(label) 
		{	    	
			if(jQuery(label).closest('.control-group').hasClass('success'))
			{
				jQuery(label).closest('.control-group').removeClass('success');
		    }
		    jQuery(label).closest('.control-group').addClass('errors');
	    },
		success: function(label) 
		{
			label
			.text('Success!').addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) 
		{
			
			var uxDdltimeOff = jQuery('#uxDdltimeOff').val();	
			var uxDdlBookingServices = jQuery('#uxDdlBookingServices').val();	
			var BookingDate = jQuery('#BookingDate').val();	
			var uxStartTime = jQuery('#uxStartTime').val();	
			var uxBookingStaus = jQuery('#uxBookingStaus').val();	
			var bookingId = jQuery('#bookingHideId').val();
			jQuery.ajax
			({
				type: "POST",
				data: "bookingId="+bookingId+"&bookingClientName="+bookingClientName+"&bookingClientMobile="+bookingClientMobile+
				"&uxStartTime="+uxStartTime+"&BookingDate="+BookingDate+"&uxDdlBookingServices="+uxDdlBookingServices+
				"&uxDdltimeOff="+uxDdltimeOff+"&uxBookingStaus="+uxBookingStaus+"&target=updateEditBookings&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{  	
					
					jQuery('#uxEditBookingMessage').css('display','block');
			    	setTimeout(function() 
			    	{
			        	jQuery('#uxEditBookingMessage').css('display','none');
			        	var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
			        }, 2000);
			    }
		   	});
		}
	});
	function getAlert(dateTimeOff)
	{			
		var employeeId = jQuery('#uxDdltimeOff').val();
		if(employeeId != "opt1")
		{
			jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+employeeId+"&dateTimeOff="+dateTimeOff+"&target=timeOffBinding&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					jQuery('#uxStartTime').html(data);
				}
			});
		}
	}
	
	function funcBindEditSlots(dateTimeOff)
	{
		if(dateTimeOff == undefined)
		{
			dateTimeOff = jQuery("#BookingDate").val();
		}
		
		var uxDdlBookingServices = 	jQuery("#uxDdlBookingServices").val();
		var employeeId = jQuery("#uxDdltimeOff").val();
		var timeSlot = jQuery('#hdTimeSlot').val();
	
		jQuery.ajax
				({
						type: "POST",
						data: "serviceId="+uxDdlBookingServices+"&employeeId="+employeeId+"&dateTimeOff="+dateTimeOff+"&currentTimeSlot="+timeSlot+"&target=timeSlotBinding&action=getAjaxExecuted",
						url:  ajaxurl,
						success: function(data) 
						{

							jQuery('#uxStartTime').html(data);
							 var foption = jQuery('#uxStartTime option:first');
   							 var soptions = jQuery('#uxStartTime option:not(:first)').sort(function(a, b) 
   							 {
      							 return parseInt(a.value) == parseInt(b.value) ? 0 : parseInt(a.value) < parseInt(b.value) ? -1 : 1
    						 });
   							jQuery('#uxStartTime').html(soptions).prepend(foption);
   					
							jQuery('#uxStartTime').val(timeSlot);
							jQuery("#uniform-uxStartTime span").html(jQuery("#uxStartTime option[value="+timeSlot+"]").text());
							jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });
						}
				});
	}
	function funcBindEditSlotsByService(serviceId,timeSlot)
	{
		var dateTimeOff = jQuery("#BookingDate").val();
		var employeeId = jQuery("#uxDdltimeOff").val();
		
		
		jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+serviceId+"&employeeId="+employeeId+"&dateTimeOff="+dateTimeOff+"&currentTimeSlot="+timeSlot+"&target=timeSlotBinding&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{

				jQuery('#uxStartTime').html(data);
				var foption = jQuery('#uxStartTime option:first');
   				var soptions = jQuery('#uxStartTime option:not(:first)').sort(function(a, b) 
   				{
      				return parseInt(a.value) == parseInt(b.value) ? 0 : parseInt(a.value) < parseInt(b.value) ? -1 : 1
    			});
   				jQuery('#uxStartTime').html(soptions).prepend(foption);
   				jQuery('#uxStartTime').val(timeSlot);
				jQuery("#uniform-uxStartTime span").html(jQuery("#uxStartTime option[value="+timeSlot+"]").text());
				jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });
			}
		});
	}
	function bindServices(serviceId,timeSlot)
	{
		var employeeId = jQuery("#uxDdltimeOff").val();
		jQuery.ajax
		({
			type: "POST",
			data: "employeeId="+employeeId+"&target=bindServicesForEmployee&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{  	
				jQuery("#uxDdlBookingServices").html(data);				
				jQuery("#uxDdlBookingServices").val(serviceId);
				jQuery("#uniform-uxDdlBookingServices span").html(jQuery("#uxDdlBookingServices option[value="+serviceId+"]").text());
				
		 	}
		});
	}
	// Simple Set Clipboard System
// Author: Joseph Huckaby
var ZeroClipboard = {
	
	version: "1.0.4",
	clients: {}, // registered upload clients on page, indexed by id
	moviePath: uri + '/ZeroClipboard.swf', // URL to movie
	nextId: 1, // ID of next movie
	
	$: function(thingy) {
		// simple DOM lookup utility function
		if (typeof(thingy) == 'string') thingy = document.getElementById(thingy);
		if (!thingy.addClass) {
			// extend element with a few useful methods
			thingy.hide = function() { this.style.display = 'none'; };
			thingy.show = function() { this.style.display = ''; };
			thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
			thingy.removeClass = function(name) {
				this.className = this.className.replace( new RegExp("\\s*" + name + "\\s*"), " ").replace(/^\s+/, '').replace(/\s+$/, '');
			};
			thingy.hasClass = function(name) {
				return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
			}
		}
		return thingy;
	},
	
	setMoviePath: function(path) {
		// set path to ZeroClipboard.swf
		this.moviePath = path;
	},
	
	dispatch: function(id, eventName, args) {
		// receive event from flash movie, send to client		
		var client = this.clients[id];
		if (client) {
			client.receiveEvent(eventName, args);
		}
	},
	
	register: function(id, client) {
		// register new client to receive events
		this.clients[id] = client;
	},
	
	getDOMObjectPosition: function(obj) {
		// get absolute coordinates for dom element
		var info = {
			left: 0, 
			top: 0, 
			width: obj.width ? obj.width : obj.offsetWidth, 
			height: obj.height ? obj.height : obj.offsetHeight
		};

		while (obj) {
			info.left += obj.offsetLeft;
			info.top += obj.offsetTop;
			obj = obj.offsetParent;
		}

		return info;
	},
	
	Client: function(elem) {
		// constructor for new simple upload client
		this.handlers = {};
		
		// unique ID
		this.id = ZeroClipboard.nextId++;
		this.movieId = 'ZeroClipboardMovie_' + this.id;
		
		// register client with singleton to receive flash events
		ZeroClipboard.register(this.id, this);
		
		// create movie
		if (elem) this.glue(elem);
	}
};

ZeroClipboard.Client.prototype = {
	
	id: 0, // unique ID for us
	ready: false, // whether movie is ready to receive events or not
	movie: null, // reference to movie object
	clipText: '', // text to copy to clipboard
	handCursorEnabled: true, // whether to show hand cursor, or default pointer cursor
	cssEffects: true, // enable CSS mouse effects on dom container
	handlers: null, // user event handlers
	
	glue: function(elem) {
		// glue to DOM element
		// elem can be ID or actual DOM element object
		this.domElement = ZeroClipboard.$(elem);
		
		// float just above object, or zIndex 99 if dom element isn't set
		var zIndex = 99;
		if (this.domElement.style.zIndex) {
			zIndex = parseInt(this.domElement.style.zIndex) + 1;
		}
		
		// find X/Y position of domElement
		var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
		
		// create floating DIV above element
		this.div = document.createElement('div');
		var style = this.div.style;
		style.position = 'absolute';
		style.left = '' + box.left + 'px';
		style.top = '' + box.top + 'px';
		style.width = '' + box.width + 'px';
		style.height = '' + box.height + 'px';
		style.zIndex = zIndex;
		
		// style.backgroundColor = '#f00'; // debug
		
		var body = document.getElementsByTagName('body')[0];
		body.appendChild(this.div);
		
		this.div.innerHTML = this.getHTML( box.width, box.height );
	},
	
	getHTML: function(width, height) {
		// return HTML for movie
		var html = '';
		var flashvars = 'id=' + this.id + 
			'&width=' + width + 
			'&height=' + height;
			
		if (navigator.userAgent.match(/MSIE/)) {
			// IE gets an OBJECT tag
			var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
			html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
		}
		else {
			// all other browsers get an EMBED tag
			html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
		}
		return html;
	},
	
	hide: function() {
		// temporarily hide floater offscreen
		if (this.div) {
			this.div.style.left = '-2000px';
		}
	},
	
	show: function() {
		// show ourselves after a call to hide()
		this.reposition();
	},
	
	destroy: function() {
		// destroy control and floater
		if (this.domElement && this.div) {
			this.hide();
			this.div.innerHTML = '';
			
			var body = document.getElementsByTagName('body')[0];
			try { body.removeChild( this.div ); } catch(e) {;}
			
			this.domElement = null;
			this.div = null;
		}
	},
	
	reposition: function(elem) {
		// reposition our floating div, optionally to new container
		// warning: container CANNOT change size, only position
		if (elem) {
			this.domElement = ZeroClipboard.$(elem);
			if (!this.domElement) this.hide();
		}
		
		if (this.domElement && this.div) {
			var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
			var style = this.div.style;
			style.left = '' + box.left + 'px';
			style.top = '' + box.top + 'px';
		}
	},
	
	setText: function(newText) {
		// set text to be copied to clipboard
		this.clipText = newText;
		if (this.ready) this.movie.setText(newText);
	},
	
	addEventListener: function(eventName, func) {
		// add user event listener for event
		// event types: load, queueStart, fileStart, fileComplete, queueComplete, progress, error, cancel
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
		if (!this.handlers[eventName]) this.handlers[eventName] = [];
		this.handlers[eventName].push(func);
	},
	
	setHandCursor: function(enabled) {
		// enable hand cursor (true), or default arrow cursor (false)
		this.handCursorEnabled = enabled;
		if (this.ready) this.movie.setHandCursor(enabled);
	},
	
	setCSSEffects: function(enabled) {
		// enable or disable CSS effects on DOM container
		this.cssEffects = !!enabled;
	},
	
	receiveEvent: function(eventName, args) {
		// receive event from flash
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
				
		// special behavior for certain events
		switch (eventName) {
			case 'load':
				// movie claims it is ready, but in IE this isn't always the case...
				// bug fix: Cannot extend EMBED DOM elements in Firefox, must use traditional function
				this.movie = document.getElementById(this.movieId);
				if (!this.movie) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 1 );
					return;
				}
				
				// firefox on pc needs a "kick" in order to set these in certain cases
				if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 100 );
					this.ready = true;
					return;
				}
				
				this.ready = true;
				this.movie.setText( this.clipText );
				this.movie.setHandCursor( this.handCursorEnabled );
				break;
			
			case 'mouseover':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('hover');
					if (this.recoverActive) this.domElement.addClass('active');
				}
				break;
			
			case 'mouseout':
				if (this.domElement && this.cssEffects) {
					this.recoverActive = false;
					if (this.domElement.hasClass('active')) {
						this.domElement.removeClass('active');
						this.recoverActive = true;
					}
					this.domElement.removeClass('hover');
				}
				break;
			
			case 'mousedown':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('active');
				}
				break;
			
			case 'mouseup':
				if (this.domElement && this.cssEffects) {
					this.domElement.removeClass('active');
					this.recoverActive = false;
				}
				break;
		} // switch eventName
		
		if (this.handlers[eventName]) {
			for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
				var func = this.handlers[eventName][idx];
			
				if (typeof(func) == 'function') {
					// actual function reference
					func(this, args);
				}
				else if ((typeof(func) == 'object') && (func.length == 2)) {
					// PHP style object + method, i.e. [myObject, 'myMethod']
					func[0][ func[1] ](this, args);
				}
				else if (typeof(func) == 'string') {
					// name of function
					window[func](this, args);
				}
			} // foreach event handler defined
		} // user defined handler for event
	}
};
function singleBooking()
{
	jQuery('#maxBooking').css('display','none');
}
function groupBooking()
{
	jQuery('#maxBooking').css('display','block');
}		
</script>
<style type="text/css">
	.fancybox-custom .fancybox-skin
	 {
		 box-shadow: 0 0 50px #222;
	 }
</style>
