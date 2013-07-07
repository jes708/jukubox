<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
include_once 'MCAPI.class.php';
global $wpdb;


if(isset($_REQUEST['target']) && isset($_REQUEST['action']))
{
	
	if($_REQUEST['target'] == "getBookingCount")
	{
			$count = $wpdb->get_var('SELECT count(BookingId) FROM ' . bookingTable());
			echo $count;
			die();
	}
	else if($_REQUEST['target'] == "getServiceCount")
	{
			$count = $wpdb->get_var('SELECT count(ServiceId) FROM ' . servicesTable());
			echo $count;
			die();
	}
	else if($_REQUEST['target'] == "getEmployeeCount")
	{
			$count = $wpdb->get_var('SELECT count(EmployeeId) FROM ' . employeesTable());
			echo $count;
			die();
	}
    else if($_REQUEST['target'] == "addService")
	{
			$uxServiceNameEncode = html_entity_decode($_REQUEST['uxServiceNameEncode']);
			$uxServiceCost = doubleval($_REQUEST['uxServiceCost']);
			$uxServiceHours = intval($_REQUEST['uxServiceHours']);
			$uxServiceMins = intval($_REQUEST['uxServiceMins']);
			$uxServicesTotalTime = $uxServiceHours  * 60 + $uxServiceMins;
			$uxMaxBookings = intval($_REQUEST['uxMaxBookings']);
			$uxServiceType = intval($_REQUEST['uxServiceType']);
			$wpdb->query
		    (
		          	$wpdb->prepare
		            (
		                   "INSERT INTO ".servicesTable()."(ServiceName,ServiceCost,ServiceTotalTime,ServiceMaxBookings,Type) 
		                   VALUES( %s, %f, %d, %d, %d)",
		                   $uxServiceNameEncode,
		                   $uxServiceCost,
		                   $uxServicesTotalTime,
		                   $uxMaxBookings,
		                   $uxServiceType
		            )
		     );
			 $lastid = $wpdb->insert_id;
			 $wpdb->query
	     	 (
		            $wpdb->prepare
		            (
		                    "UPDATE ".servicesTable()." SET ServiceDisplayOrder = %d WHERE ServiceId = %d",
		                    $lastid,
		                    $lastid
		            )
	      	 );
			 die();
	}	
	else if($_REQUEST['target'] == "editService")
	{
			$serviceId = intval($_REQUEST['serviceId']);
			$uxServiceEdit = $wpdb->get_row
			(
					$wpdb->prepare
					(
							'SELECT ServiceName,ServiceCost,ServiceMaxBookings,Type FROM ' . servicesTable() . ' where ServiceId = %d',
							$serviceId
					)
			);
			?>
				 <div class="control-group">
		         	<label class="control-label"><?php _e( "Service Name :", bookings_plus ); ?><span class="req">*</span></label>
		         	<div class="controls"><input type="text" class="required span12" name="uxEditServiceName" id="uxEditServiceName" 
		         	value="<?php echo $uxServiceEdit->ServiceName; ?>"/></div>
		         </div>
		         
		         <div class="control-group">
		         	<label class="control-label"><?php _e( "Cost :", bookings_plus ); ?><span class="req">*</span></label>
		            <div class="controls"><input type="text" class="required span12" name="uxEditServiceCost" id="uxEditServiceCost" 
		            value="<?php echo $uxServiceEdit->ServiceCost; ?>"/></div>
		         </div>
		         <div class="control-group">
		         
	             	<label class="control-label"><?php _e( "Service Type :", bookings_plus );?>
	               		<span class="req">*</span>
	               	</label>
					<div class="controls searchDrop">
			        <?php
					if($uxServiceEdit->Type == 0)
					{
					?>
						<label class="radio">
							<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();" checked="checked"><?php _e( "Single Booking", bookings_plus );?>
						</label>
						<label class="radio">
							<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style"value="1"><?php _e( "Group Bookings", bookings_plus );?>
						</label>		
					<?php
					}
					else 
					{
					?>
						<label class="radio">
							<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();"><?php _e( "Single Booking", bookings_plus );?>
						</label>
						<label class="radio">
							<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style"value="1" checked="checked"><?php _e( "Group Bookings", bookings_plus );?>
						</label>	
					<?php
					}
					?>
				</div>
	           </div>
		       <div class="control-group" id="editMaxBooking" style="display: none;">
		         	<label class="control-label"><?php _e( "Max Bookings<br/>(Each Slot) :", bookings_plus ); ?><span class="req">*</span></label>
		            <div class="controls"><input type="text" class="required span12" name="uxEditMaxBookings" id="uxEditMaxBookings" 
		            value="<?php echo $uxServiceEdit->ServiceMaxBookings; ?>"/></div>
		       </div>
				 <input type="hidden" id="hiddenServiceId" name="hiddenServiceId" value="<?php echo $serviceId; ?>" />
				 <script>jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });</script>
			<?php
			die();	         
	} 
	else if($_REQUEST['target'] == "updateServiceTable")
	{
			$serviceId = intval($_REQUEST['serviceId']);
			$uxEditServiceName = html_entity_decode($_REQUEST['uxEditServiceName']);
			$uxEditServiceCost = doubleval($_REQUEST['uxEditServiceCost']);
			$uxEditMaxBookings = intval($_REQUEST['uxEditMaxBookings']);
			$uxEditServiceType = intval($_REQUEST['uxEditServiceType']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".servicesTable()." SET ServiceName = %s, ServiceCost = %f, ServiceMaxBookings = %d, Type = %d WHERE ServiceId = %d",
	                    $uxEditServiceName,
	                    $uxEditServiceCost,
	                    $uxEditMaxBookings,
	                    $uxEditServiceType,
	                    $serviceId
	             )
	      	);
			die();
	}
	else if($_REQUEST['target'] == 'deleteService')
	{
			$serviceId = intval($_REQUEST['uxServiceId']);
			$countServiceId = $wpdb -> get_var('SELECT count(AllocationId ) FROM ' . services_AllocationTable() . '  where ServiceId = '. '"' . $serviceId . '"');
			if($countServiceId !=0)
			{
				echo "allocated"; 
			}
			else 
			{
				$wpdb->query
				(
						$wpdb->prepare
						(
							   "DELETE FROM ".servicesTable()." WHERE serviceId = %d",
							    $serviceId
						)
				);
			}
			die();
	}
			
	else if($_REQUEST['target'] == 'addEmployee')
	{
			$uxEmployeeNameEncode = html_entity_decode($_REQUEST['uxEmployeeNameEncode']);
			$uxEmployeeEmail = esc_attr($_REQUEST['uxEmployeeEmail']);
			$uxEmployeePhone = esc_attr($_REQUEST['uxEmployeePhone']);
			$uxEmployeeColor = esc_attr($_REQUEST['uxEmployeeColor']);
			$uxEmployeeUniqueCode = intval($_REQUEST['uxEmployeeUniqueCode']);
			$wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employeesTable()."(EmployeeName,EmployeeEmail,EmployeePhone,EmployeeUniqueCode,
		                       EmployeeColorCode,Date) VALUES( %s, %s, %s, %d, %s, CURDATE())",
		                       $uxEmployeeNameEncode,
		                       $uxEmployeeEmail,
		                       $uxEmployeePhone,
		                       $uxEmployeeUniqueCode,
		                       $uxEmployeeColor
		               )
		    );
		    $lastid = $wpdb->insert_id;
		    $wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Mon",
		                       "540",
		                       "1020",
		                       "1"
		               )
		    );
			$wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Tue",
		                       "540",
		                       "1020",
		                       "1"
		               )
		    );
			$wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Wed",
		                       "540",
		                       "1020",
		                       "1"
		               )
		    );
		    $wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Thu",
		                       "540",
		                       "1020",
		                       "1"
		               )
		    );
		    $wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Fri",
		                       "540",
		                       "1020",
		                       "1"
		               )
		    );
		    $wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Sat",
		                       "540",
		                       "1020",
		                       "0"
		               )
		    );
		    $wpdb->query
		    (
		              $wpdb->prepare
		              (
		                       "INSERT INTO ".employees_TimingsTable()."(EmployeeId,Day,StartTime,EndTime,Status) VALUES( %d, %s, %d, %d, %d)",
		                       $lastid,
		                       "Sun",
		                       "540",
		                       "1020",
		                       "0"
		               )
		    );
		    die();
	}		
	else if($_REQUEST['target'] == 'employeeDdIdOnchange')
	{
			$employeeDdId = intval($_REQUEST['employeeDdId']);
			$returnDataArrayList =$wpdb->get_results
			(
					$wpdb->prepare
					(
						  'SELECT ServiceId from ' . services_AllocationTable() .' where EmployeeId = %d',
						  $employeeDdId
					)
			);
			$scriptDynamic = '<script>var oTable = jQuery("#data-table1").dataTable();';
			for($flagAllocate = 0; $flagAllocate < count($returnDataArrayList); $flagAllocate++)
			{
				$scriptDynamic.= 'jQuery("#chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .'", oTable.fnGetNodes()).each(function(){jQuery(this).attr("checked", "checked");});';
				$scriptDynamic.= 'jQuery("#uniform-chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .' span", oTable.fnGetNodes()).each(function(){jQuery(this).attr("class", "checked");});';					
			}
			$scriptDynamic .= '</script>';
			echo $scriptDynamic;
			die();
	}
	else if($_REQUEST['target'] == 'checkAllServices')
	{
			$employeeDdId = intval($_REQUEST['employeeDdId']);
			$returnDataArrayList =$wpdb->get_results
			(
					$wpdb->prepare
					(
						  'SELECT ServiceId from ' . servicesTable() 
						  
					)
			);
			$scriptDynamic = '<script>var oTable = jQuery("#data-table1").dataTable();';
			for($flagAllocate = 0; $flagAllocate < count($returnDataArrayList); $flagAllocate++)
			{
				$scriptDynamic.= 'jQuery("#chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .'", oTable.fnGetNodes()).each(function(){jQuery(this).attr("checked", "checked");});';
				$scriptDynamic.= 'jQuery("#uniform-chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .' span", oTable.fnGetNodes()).each(function(){jQuery(this).attr("class", "checked");});';					
			}
			$scriptDynamic .= '</script>';
			echo $scriptDynamic;
			die();
	}
	else if($_REQUEST['target'] == 'UnSelectAllServices')
	{
			$employeeDdId = intval($_REQUEST['employeeDdId']);
			$returnDataArrayList =$wpdb->get_results
			(
					$wpdb->prepare
					(
						  'SELECT ServiceId from ' . servicesTable() 
						  
					)
			);
			$scriptDynamic = '<script>var oTable = jQuery("#data-table1").dataTable();';
			for($flagAllocate = 0; $flagAllocate < count($returnDataArrayList); $flagAllocate++)
			{
				$scriptDynamic.= 'jQuery("#chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .'", oTable.fnGetNodes()).each(function(){jQuery(this).removeAttr("checked");});';
				$scriptDynamic.= 'jQuery("#uniform-chkAllocation' . $returnDataArrayList[$flagAllocate] -> ServiceId .' span", oTable.fnGetNodes()).each(function(){jQuery(this).removeAttr("class");});';					
			}
			$scriptDynamic .= '</script>';
			echo $scriptDynamic;
			die();
	}
	else if($_REQUEST['target'] == 'deleteAllocationEntries')
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$wpdb->query
			(
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".services_AllocationTable()." WHERE EmployeeId = %d ",
			       		 $employeeId
			   		)
			);
			die();
	}
	else if($_REQUEST['target'] == 'allocationEntries')
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$serviceId  = intval($_REQUEST['serviceId']);
			$wpdb->query
			(
				    $wpdb->prepare
				    (
				           "INSERT INTO ".services_AllocationTable()."(EmployeeId,ServiceId) VALUES(%d, %d)",
				           $employeeId,
				           $serviceId
				    )
			);
			die();
	}
	else if($_REQUEST['target'] == 'checkExistingEmailAction')
	{
			$uxEmployeeEmail = esc_attr($_REQUEST['uxEmployeeEmail']);
			$employeeEmail = $wpdb->get_var('SELECT count(EmployeeId) FROM ' . employeesTable(). ' where EmployeeEmail = ' . "'".$uxEmployeeEmail."'");
			if($employeeEmail != 0)
			{
				echo $returnEmployeeEmailCountCheck = "existingEmployeeEmail";
			}
			else 
			{
				echo $returnEmployeeEmailCountCheck = "newEmployeeEmail";		
			}
			die();
	}
	else if($_REQUEST['target'] == 'deleteEmployees')
	{
			$employeeId= intval($_REQUEST['employeeId']);
			$date = date("Y-m-d");
			$countBooking = $wpdb->get_var('SELECT count(BookingId) FROM ' . bookingTable() . ' where EmployeeId ='. $employeeId .' and Date > '."'".$date ."'");
			$countAllocation = $wpdb->get_var('SELECT count(AllocationId ) FROM ' . services_AllocationTable(). ' where EmployeeId ='.$employeeId);
			if($countBooking != 0)
			{
				echo "bookingExist";
			}
			elseif($countAllocation !=0 )
			{
				echo "allocatedToService";
			}
			else
			{
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".blockTimeTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".blockDateTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".employees_TimingsTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".services_AllocationTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".bookingTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
				$wpdb->query
				(
				        $wpdb->prepare
				        (
				                "DELETE FROM ".employeesTable()." WHERE EmployeeId = %d",
				                 $employeeId       
						)
				);
			}
			die();
	}
	else if($_REQUEST['target'] == "editEmployees")
	{
			$EmployeeId = intval($_REQUEST['employeeId']);
			$uxEmployeeEdit = $wpdb->get_row
			(
					$wpdb->prepare
					(
							'SELECT EmployeeColorCode,EmployeeName,EmployeeEmail,EmployeePhone,EmployeeUniqueCode   FROM ' . employeesTable() . ' where EmployeeId  = %d',
							$EmployeeId
					)
			);
			
			?>
				<script>
					jQuery('#uxEditEmployeeColorCode').colorpicker().on('changeColor', function(ev){
							jQuery('#picker2').css('background-color',ev.color.toHex());
							jQuery('#uxEditEmployeeColorCode').val(ev.color.toHex());
					});
					jQuery(".maskPhone").mask("(999) 999-9999");    
				</script>
			     <div class="control-group" >
		         	<label class="control-label"><?php _e( "Staff Member Code :", bookings_plus ); ?><span class="req">*</span></label>
		         	<div class="controls"><input type="text" class="required span12" name="uxEditEmployeeId" id="uxEditEmployeeId" disabled="disabled"
		         	value="<?php echo $uxEmployeeEdit->EmployeeUniqueCode ; ?>"/></div>
		         </div>
		         <div class="control-group">
		         	<label class="control-label"><?php _e( "Staff Member Color :", bookings_plus ); ?><span class="req">*</span></label>
		         	   <div class="controls">
					<div class="input-append color" data-color="rgb(255, 141, 180)" data-color-format="rgb" >
						<span class="add-on"><i id="picker2" style="background-color: <?php echo $uxEmployeeEdit->EmployeeColorCode; ?>"></i></span>
						<input type="text" value="<?php echo $uxEmployeeEdit->EmployeeColorCode; ?>"  id="uxEditEmployeeColorCode" name="uxEditEmployeeColorCode" >                                 
                    </div>
                    </div>  
		         </div>
		         <div class="control-group">
		         	<label class="control-label"><?php _e( "Staff Member Name :", bookings_plus ); ?><span class="req">*</span></label>
		            <div class="controls"><input type="text" class="required span12" name="uxEditEmployeeName" id="uxEditEmployeeName" 
		            value="<?php echo $uxEmployeeEdit->EmployeeName; ?>"/></div>
		         </div>
		         <div class="control-group">
		         	<label class="control-label"><?php _e( "Staff Member Email :", bookings_plus ); ?><span class="req">*</span></label>
		            <div class="controls"><input type="text" class="required span12" name="uxEditEmployeeEmail" id="uxEditEmployeeEmail" 
		            value="<?php echo $uxEmployeeEdit->EmployeeEmail; ?>"/></div>
		         </div>
				 <div class="control-group">
		         	<label class="control-label"><?php _e( "Staff Member Phone :", bookings_plus ); ?><span class="req">*</span></label>
		            <div class="controls"><input type="text" class="required span12 maskPhone" name="uxEditEmployeePhone" id="uxEditEmployeePhone" 
		            value="<?php echo $uxEmployeeEdit->EmployeePhone; ?>"/></div>
		         </div>
				 <input type="hidden" id="hiddenEmployeeId" name="hiddenEmployeeId" value="<?php echo $EmployeeId; ?>" />
			<?php
			die();	         
	}
	else if($_REQUEST['target'] == "updateExistingEmployee")
	{
			$uxEditEmployeeId = intval($_REQUEST['uxEmployeeId']);
			$uxEditEmployeeColorCode = esc_attr($_REQUEST['uxEditEmployeeColorCode']);
			$uxEditEmployeeName = esc_attr($_REQUEST['uxEditEmployeeName']);
			$uxEditEmployeeEmail = esc_attr($_REQUEST['uxEditEmployeeEmail']);
			$uxEditEmployeePhone = esc_attr($_REQUEST['uxEditEmployeePhone']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".employeesTable()." SET EmployeeColorCode = %s, EmployeeName = %s, EmployeeEmail = %s, 
	                    EmployeePhone = %s WHERE EmployeeId = %d",
	                    $uxEditEmployeeColorCode,
	                    $uxEditEmployeeName,
	                    $uxEditEmployeeEmail,
	                    $uxEditEmployeePhone,
	                    $uxEditEmployeeId
	             )
	      	);
			die();
	} 
	
	else if($_REQUEST['target'] == "updateGeneralSettings")
	{
			$uxDefaultcurrency = esc_attr($_REQUEST['uxDefaultcurrency']);
			$uxDefaultcountry = esc_attr($_REQUEST['uxDefaultcountry']);
			$uxDefaultTimeFormat = intval($_REQUEST['uxDefaultTimeFormat']);
			$uxDefaultDateFormat = $_REQUEST['uxDefaultDateFormat'];
			$valueTimeFormat = intval($_REQUEST['uxSlotHours']);
			$valueSlotFormat = intval($_REQUEST['uxSlotMins']);
			$default_Time_Zone = html_entity_decode($_REQUEST['default_Time_Zone']);
			$default_Time_Zone_Name = html_entity_decode($_REQUEST['default_Time_Zone_Name']);
			$totalTime = $valueTimeFormat * 60 + $valueSlotFormat;
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		          			"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName = %s",
		                    1,
		                   	$uxDefaultcurrency
		          )
		    );
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		          			"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName != %s",
		                    0,
		                   	$uxDefaultcurrency
		          )
		    );
			$wpdb->query
			(
				  $wpdb->prepare
				  (
						  "UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName = %s",
						  1,
						  $uxDefaultcountry
				  )
			);	
			$wpdb->query
			(
					$wpdb->prepare
					(
						 "UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName != %s",
						 0,
						 $uxDefaultcountry
					)
			);	
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
		                    $uxDefaultTimeFormat,
		                    "default_Time_Format"
		          )
		    );
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
		                    $totalTime,
		                    "default_Slot_Total_Time_Format"
		          )
		    );
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
		                    $uxDefaultDateFormat,
		                    "default_Date_Format"
		          )
		    );
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
		                    $default_Time_Zone,
		                    "default_Time_Zone"
		          )
		    );
		    $wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
		                    $default_Time_Zone_Name,
		                    "default_Time_Zone_Name"
		          )
		    );
			echo $valueTimeFormat,$valueSlotFormat;
			die();
	}
	else if($_REQUEST['target'] == "updatePendingConfirmationEmailTemplate")
	{
			$PendingConfirmationEmailTemplateSubject = html_entity_decode($_REQUEST['PendingConfirmationEmailTemplateSubject']);
			$PendingConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['PendingConfirmationEmailTemplateContent']);
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
		                    $PendingConfirmationEmailTemplateSubject,
		                    $PendingConfirmationEmailTemplateContent,
		                    "booking-pending-confirmation"
		          )
		    );
			die();
		
	}
	else if($_REQUEST['target'] == "updateConfirmationEmailTemplate")
	{
			$ConfirmationEmailTemplateSubject = html_entity_decode($_REQUEST['ConfirmationEmailTemplateSubject']);
			$ConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['ConfirmationEmailTemplateContent']);
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
		                    $ConfirmationEmailTemplateSubject,
		                    $ConfirmationEmailTemplateContent,
		                    "booking-confirmation"
		          )
		    );
			die();
	}
	else if($_REQUEST['target'] == "updateDeclinedEmailTemplate")
	{
			$DeclineEmailTemplateSubject = html_entity_decode($_REQUEST['DeclineEmailTemplateSubject']);
			$DeclineEmailTemplateContent = html_entity_decode($_REQUEST['DeclineEmailTemplateContent']);
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
		                    $DeclineEmailTemplateSubject,
		                    $DeclineEmailTemplateContent,
		                    "booking-disapproved"
		          )
		    );
			die();
	}
	else if($_REQUEST['target'] == "updateAdminApproveDisapproveEmailTemplate")
	{
			$AdminApproveDisapproveEmailTemplateSubject = html_entity_decode($_REQUEST['AdminApproveDisapproveEmailTemplateSubject']);
			$AdminApproveDisapproveEmailTemplateContent = html_entity_decode($_REQUEST['AdminApproveDisapproveEmailTemplateContent']);
			$wpdb->query
		    (
		          $wpdb->prepare
		          (
		                    "UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
		                    $AdminApproveDisapproveEmailTemplateSubject,
		                    $AdminApproveDisapproveEmailTemplateContent,
		                    "admin-control"
		          )
		    );
			die();
	}
	
	else if($_REQUEST['target'] == "employeesStartWorkingHours")
	{
		$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
		if($timeFormats == 0)
		{
		?>
			<option value="00">00:00 am</option>
			<option value="30">12:30 am</option>
			<option value="60">1:00 am</option>
			<option value="90">1:30 am</option>
			<option value="120">2:00 am</option>
			<option value="150">2:30 am</option>
			<option value="180">3:00 am</option>
			<option value="210">3:30 am</option>
			<option value="240">4:00 am</option>
			<option value="270">4:30 am</option>
			<option value="300">5:00 am</option>
			<option value="330">5:30 am</option>
			<option value="360">6:00 am</option>
			<option value="390">6:30 am</option>
			<option value="420">7:00 am</option>
			<option value="450">7:30 am</option>
			<option value="480" >8:00 am </option>
			<option value="510">8:30 am</option>
			<option value="540">9:00 am</option>
			<option value="570">9:30 am</option>
			<option value="600">10:00 am</option>
			<option value="630">10:30 am</option>
			<option value="660">11:00 am</option>
			<option value="690">11:30 am</option>
			<option value="720">12:00 pm</option>
			<option value="750">12:30 pm</option>
			<option value="780">1:00 pm</option>
			<option value="810">1:30 pm</option>
			<option value="840">2:00 pm</option>
			<option value="870">2:30 pm</option>
			<option value="900">3:00 pm</option>
			<option value="930">3:30 pm</option>
			<option value="960">4:00 pm</option>
			<option value="990">4:30 pm</option>
			<option value="1020">5:00 pm</option>
			<option value="1050">5:30 pm</option>
			<option value="1080">6:00 pm</option>
			<option value="1110">6:30 pm</option>
			<option value="1140">7:00 pm</option>
			<option value="1170">7:30 pm</option>
			<option value="1200">8:00 pm</option>
			<option value="1230">8:30 pm</option>
			<option value="1260">9:00 pm</option>
			<option value="1290">9:30 pm</option>
			<option value="1320">10:00 pm</option>
			<option value="1350">10:30 pm</option>
			<option value="1380">11:00 pm</option>
			<option value="1410">11:30 pm</option>
	<?php
		die();
		}
		else
		{
			?>
			<option value="00">00:00</option>
			<option value="30">00:30</option>
			<option value="60">1:00</option>
			<option value="90">1:30</option>
			<option value="120">2:00</option>
			<option value="150">2:30</option>
			<option value="180">3:00</option>
			<option value="210">3:30</option>
			<option value="240">4:00</option>
			<option value="270">4:30</option>
			<option value="300">5:00</option>
			<option value="330">5:30</option>
			<option value="360">6:00</option>
			<option value="390">6:30</option>
			<option value="420">7:00</option>
			<option value="450">7:30</option>
			<option value="480">8:00 </option>
			<option value="510">8:30</option>
			<option value="540">9:00</option>
			<option value="570">9:30</option>
			<option value="600">10:00</option>
			<option value="630">10:30</option>
			<option value="660">11:00</option>
			<option value="690">11:30</option>
			<option value="720">12:00</option>
			<option value="750">12:30</option>
			<option value="780">13:00</option>
			<option value="810">13:30</option>
			<option value="840">14:00</option>
			<option value="870">14:30</option>
			<option value="900">15:00</option>
			<option value="930">15:30</option>
			<option value="960">16:00</option>
			<option value="990">16:30</option>
			<option value="1020">17:00</option>
			<option value="1050">17:30</option>
			<option value="1080">18:00</option>
			<option value="1110">18:30</option>
			<option value="1140">19:00</option>
			<option value="1170">19:30</option>
			<option value="1200">20:00</option>
			<option value="1230">20:30</option>
			<option value="1260">21:00</option>
			<option value="1290">21:30</option>
			<option value="1320">22:00</option>
			<option value="1350">22:30</option>
			<option value="1380">23:00</option>
			<option value="1410">23:30</option>
			<?php
			die();
		}
	}
	else if($_REQUEST['target'] == "employeesEndWorkingHours")
	{
		$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
		if($timeFormats == 0)
		{
		?>
			<option value="00">00:00 am</option>
			<option value="30">12:30 am</option>
			<option value="60">1:00 am</option>
			<option value="90">1:30 am</option>
			<option value="120">2:00 am</option>
			<option value="150">2:30 am</option>
			<option value="180">3:00 am</option>
			<option value="210">3:30 am</option>
			<option value="240">4:00 am</option>
			<option value="270">4:30 am</option>
			<option value="300">5:00 am</option>
			<option value="330">5:30 am</option>
			<option value="360">6:00 am</option>
			<option value="390">6:30 am</option>
			<option value="420">7:00 am</option>
			<option value="450">7:30 am</option>
			<option value="480" >8:00 am </option>
			<option value="510">8:30 am</option>
			<option value="540">9:00 am</option>
			<option value="570">9:30 am</option>
			<option value="600">10:00 am</option>
			<option value="630">10:30 am</option>
			<option value="660">11:00 am</option>
			<option value="690">11:30 am</option>
			<option value="720">12:00 pm</option>
			<option value="750">12:30 pm</option>
			<option value="780">1:00 pm</option>
			<option value="810">1:30 pm</option>
			<option value="840">2:00 pm</option>
			<option value="870">2:30 pm</option>
			<option value="900">3:00 pm</option>
			<option value="930">3:30 pm</option>
			<option value="960">4:00 pm</option>
			<option value="990">4:30 pm</option>
			<option value="1020">5:00 pm</option>
			<option value="1050">5:30 pm</option>
			<option value="1080">6:00 pm</option>
			<option value="1110">6:30 pm</option>
			<option value="1140">7:00 pm</option>
			<option value="1170">7:30 pm</option>
			<option value="1200">8:00 pm</option>
			<option value="1230">8:30 pm</option>
			<option value="1260">9:00 pm</option>
			<option value="1290">9:30 pm</option>
			<option value="1320">10:00 pm</option>
			<option value="1350">10:30 pm</option>
			<option value="1380">11:00 pm</option>
			<option value="1410">11:30 pm</option>
	<?php
		}
		else
		{
			?>
			<option value="00">00:00</option>
			<option value="30">00:30</option>
			<option value="60">1:00</option>
			<option value="90">1:30</option>
			<option value="120">2:00</option>
			<option value="150">2:30</option>
			<option value="180">3:00</option>
			<option value="210">3:30</option>
			<option value="240">4:00</option>
			<option value="270">4:30</option>
			<option value="300">5:00</option>
			<option value="330">5:30</option>
			<option value="360">6:00</option>
			<option value="390">6:30</option>
			<option value="420">7:00</option>
			<option value="450">7:30</option>
			<option value="480">8:00 </option>
			<option value="510">8:30</option>
			<option value="540">9:00</option>
			<option value="570">9:30</option>
			<option value="600">10:00</option>
			<option value="630">10:30</option>
			<option value="660">11:00</option>
			<option value="690">11:30</option>
			<option value="720">12:00</option>
			<option value="750">12:30</option>
			<option value="780">13:00</option>
			<option value="810">13:30</option>
			<option value="840">14:00</option>
			<option value="870">14:30</option>
			<option value="900">15:00</option>
			<option value="930">15:30</option>
			<option value="960">16:00</option>
			<option value="990">16:30</option>
			<option value="1020">17:00</option>
			<option value="1050">17:30</option>
			<option value="1080">18:00</option>
			<option value="1110">18:30</option>
			<option value="1140">19:00</option>
			<option value="1170">19:30</option>
			<option value="1200">20:00</option>
			<option value="1230">20:30</option>
			<option value="1260">21:00</option>
			<option value="1290">21:30</option>
			<option value="1320">22:00</option>
			<option value="1350">22:30</option>
			<option value="1380">23:00</option>
			<option value="1410">23:30</option>
			<?php
			die();
		}
	}
	else if($_REQUEST['target'] == "employeesWorkingHours")
	{
		
			$workingDay = $_REQUEST['workingDay'];
			$uxDayOpenClosed = intval($_REQUEST['uxDayOpenClosed']);
			$uxDdlStart = intval($_REQUEST['uxDdlStart']);
			$uxDdlEnd= intval($_REQUEST['uxDdlEnd']);
			$uxDdlWorkingEmployees = intval($_REQUEST['uxDdlWorkingEmployees']);
			$wpdb->query
			(
		          $wpdb->prepare
		          (
		                    "UPDATE ".employees_TimingsTable()." SET StartTime = %d, EndTime = %d, Status = %d WHERE Day = %s and EmployeeId = %d",
		                    $uxDdlStart,
		                    $uxDdlEnd,
		                    $uxDayOpenClosed,
		                    $workingDay,
		                    $uxDdlWorkingEmployees
		          )
			);
			die();
	}
	else if($_REQUEST['target'] == "convertTime")
	{
			$employeeId = intval($_REQUEST['uxEmployeeId']);
			$workingDay = esc_attr($_REQUEST['workingDay']);
			$getTotalMins = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT StartTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d ",
					$workingDay,
					$employeeId
				)
			);
			$getStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT Status FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d ",
					$workingDay,
					$employeeId
				)
			);
			$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
			$getHours = floor($getTotalMins / 60) ;
			$getMins = $getTotalMins % 60 ;
			if($getMins==0)
			{
				$hourFormat = $getHours . ":" . "00";
				if($timeFormats == 0)
				{
					$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
				}
				else 
				{
					$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
				}
				echo $time_in_12_hour_format . "," . $getTotalMins . "," . $getStatus;
			}
			else
			{
				$hourFormat = $getHours . ":" . $getMins;
				if($timeFormats == 0)
				{
					$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
				}
				else 
				{
					$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
				}
				echo $time_in_12_hour_format . "," . $getTotalMins . "," . $getStatus;	
			}
			die();
	}
	else if($_REQUEST['target'] == "convertEndTime")
	{
			$employeeId = intval($_REQUEST['uxEmployeeId']);
			$workingDay = esc_attr($_REQUEST['workingDay']);
			$getTotalMins = $wpdb->get_var
			(
					$wpdb->prepare
					(
						"SELECT EndTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d ",
						$workingDay,
						$employeeId
					)
			);
			$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
			$getHours = floor($getTotalMins / 60) ;
			$getMins = $getTotalMins % 60 ;
			if($getMins==0)
			{
				$hourFormat = $getHours . ":" . "00";
				if($timeFormats == 0)
				{
					$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
				}
				else 
				{
					$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
				}
				echo $time_in_12_hour_format . "," . $getTotalMins;
			}
			else
			{
				$hourFormat = $getHours . ":" . $getMins;
				if($timeFormats == 0)
				{
					$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
				}
				else 
				{
					$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
				}
				echo $time_in_12_hour_format . "," . $getTotalMins;		
			}
			die();
	}
	
    else if($_REQUEST['target'] == "getCustomerCount")
    {
		 $count = $wpdb->get_var('SELECT count(CustomerId) FROM ' . customersTable());
		 echo $count;
		 die();
    }
	else if($_REQUEST['target'] == 'addCustomers')
	{
		    $uxCustomerFirstName = esc_attr($_REQUEST['uxFirstName']);
			$uxCustomerLastName = esc_attr($_REQUEST['uxLastName']);
			$CustomerEmail = esc_attr($_REQUEST['uxEmailAddress']);
			$CustomerTelephone = esc_attr($_REQUEST['uxTelephoneNumber']);
			$CustomerMobile = esc_attr($_REQUEST['uxMobileNumber']);
			$CustomerAddress1 = esc_attr($_REQUEST['uxAddress1']);
			$CustomerAddress2 = esc_attr($_REQUEST['uxAddress2']);
			$CustomerCity = esc_attr($_REQUEST['uxCity']);
			$CustomerPostalCode = esc_attr($_REQUEST['uxPostalCode']);
			$CustomerCountry = intval($_REQUEST['uxCountry']);
			$CustomerComments = esc_attr($_REQUEST['uxComments']);
			$wpdb->query
		    (
		          	$wpdb->prepare
		            (
		                   "INSERT INTO ".customersTable()."(CustomerFirstName,CustomerLastName,CustomerEmail,CustomerTelephone,
		                   CustomerMobile,CustomerAddress1,CustomerAddress2,CustomerCity,CustomerZipCode,CustomerCountry,CustomerComments,
		                   DateTime) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, CURDATE())",
		                   $uxCustomerFirstName,
		                   $uxCustomerLastName,
		                   $CustomerEmail,
		                   $CustomerTelephone,
		                   $CustomerMobile,
		                   $CustomerAddress1,
		                   $CustomerAddress2,
		                   $CustomerCity,
		                   $CustomerPostalCode,
		                   $CustomerCountry,
		                   $CustomerComments
		            )
		     );
			 echo $lastid = $wpdb->insert_id;
			 die();	
	}
	else if($_REQUEST['target'] == "editcustomers")
	{
			$customerId = intval($_REQUEST['customerId']);
			$customer = $wpdb->get_row
			(
					$wpdb->prepare
					(
								"SELECT * FROM ".customersTable()." where CustomerId = %d",
								$customerId
					)
			);
			?>
			<script>
				jQuery("select").uniform({ radioClass: 'choice' });
				jQuery(".maskPhone").mask("(999) 999-9999");     
			</script>
			
			<div class="row-fluid nested form-horizontal">
        		<div class="span6 well">
		  			<div class="body" style="padding:5px">
						<div class="control-group">
               				<label class="control-label"><?php _e( "First Name :", bookings_plus ); ?><span class="req">*</span></label>
                 			<div class="controls"><input type="text" class="required span12" name="uxEditFirstName" id="uxEditFirstName" value="<?php echo $customer->CustomerFirstName;?>"/></div>
            			</div>
		    			<div class="control-group">
	          				<label class="control-label"><?php _e( "Last Name :", bookings_plus ); ?><span class="req">*</span></label>
	        				<div class="controls"><input type="text" class="required span12" name="uxEditLastName" id="uxEditLastName" value="<?php echo $customer->CustomerLastName;?>"/></div>
	        			</div>
	        			<div class="control-group">
	          				<label class="control-label"><?php _e( "Email :", bookings_plus ); ?><span class="req">*</span></label>
	          				<div class="controls"><input type="text" class="required span12" name="uxEditEmailAddress" id="uxEditEmailAddress" value= "<?php echo $customer->CustomerEmail;?>" ></div>
	        			</div>
	 					<div class="control-group">
	         				<label class="control-label"><?php _e( "Telephone :", bookings_plus ); ?></label>
	          				<div class="controls"><input type="text" class="required span12 maskPhone" name="uxEditTelephoneNumber" id="uxEditTelephoneNumber" value="<?php echo $customer->CustomerTelephone;?>" ></div>
	       				</div>
	 	   				<div class="control-group">
	                    	<label class="control-label"><?php _e( "Mobile :", bookings_plus ); ?></label>
	                        <div class="controls"><input type="text" class="required span12 maskPhone" name="uxEditMobileNumber" id="uxEditMobileNumber" value="<?php echo $customer->CustomerMobile;?>"></div>
	                    </div>
	    				<div class="control-group">
	                         <label class="control-label"><?php _e( "Address 1 :", bookings_plus ); ?></label>
	                         <div class="controls"><input type="text" class="required span12" name="uxEditAddress1" id="uxEditAddress1" value="<?php echo $customer->CustomerAddress1;?>"></div>
	                   	</div>                         
                	</div>     
                </div>
				<div class="span6 well">
					<div class="body"  style="padding:5px">
 						<div class="control-group">
                        	 <label class="control-label"><?php _e( "Address 2 :", bookings_plus ); ?></label>
                             <div class="controls"><input type="text" class="required span12" name="uxEditAddress2" id="uxEditAddress2" value="<?php echo $customer->CustomerAddress2;?>"></div>
                        </div>    						
            			<div class="control-group">
                        	<label class="control-label"><?php _e( "City :", bookings_plus ); ?></label>
                            <div class="controls"><input type="text" class="required span12" name="uxEditCity" id="uxEditCity" value="<?php echo $customer->CustomerCity;?>"></div>
                        </div>
 						<div class="control-group">
                              <label class="control-label"><?php _e( "Post Code :", bookings_plus ); ?></label>
                              <div class="controls"><input type="text" class="required span12" name="uxEditPostalCode" id="uxEditPostalCode" value="<?php echo $customer->CustomerZipCode;?>"></div>
                        </div>
 						<div class="control-group">
                        	<label class="control-label"><?php _e( "Country :", bookings_plus ); ?></label>
                            	<div class="controls">
                              		<select name="uxEditCountry" class="style required" id="uxEditCountry">
                              		<?php
						            	$country = $wpdb->get_results
									  	(
												$wpdb->prepare
												(
														"SELECT CountryName,CountryId From ".countriesTable()." order by CountryName ASC"
												)
									    );	
										$sel_country = $wpdb->get_var
										(
												$wpdb->prepare
												(
													"SELECT CountryName From ".countriesTable()." where CountryId = ".$customer->CustomerCountry
												)
										);
									  	for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
									    {
										?>
											<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
										<?php 
										}
									   ?>                   
                              		</select>
                              		<script>jQuery('#uxEditCountry').val("<?php echo $customer->CustomerCountry;?>");
                              		jQuery('#uniform-uxEditCountry span').html("<?php echo $sel_country;?>");
                              		jQuery("select").uniform({ radioClass: 'choice' });
									jQuery(".maskPhone").mask("(999) 999-9999");  </script>
                              	</div>
                        </div>
 						<div class="control-group">
                              <label class="control-label"><?php _e( "Comments :", bookings_plus ); ?></label>
                              <div class="controls"><textarea class="required span12" name="uxEditComments" id="uxEditComments"  style="height:85px"><?php echo $customer->CustomerComments;?></textarea></div>
                        </div> 
            		</div>
                </div>
            </div>
            <input type="hidden" id="hiddenCustomerId" name="hiddenCustomerId" value="<?php echo $customer->CustomerId;?>" />
             <input type="hidden" id="hiddenCustomerName" name="hiddenCustomerName" value="<?php echo $customer->CustomerFirstName ." " . $customer->CustomerLastName ;?>" />		
            <?php
            die();		
	}
	else if($_REQUEST['target'] == "updatecustomers")
	{
			$CustomerId = intval($_REQUEST['uxEditCustomerId']);
			$uxEditFirstName=esc_attr($_REQUEST['uxEditFirstName']);
			$uxEditLastName=esc_attr($_REQUEST['uxEditLastName']);
			$uxEditEmailAddress=esc_attr($_REQUEST['uxEditEmailAddress']);
			$uxEditTelephoneNumber=esc_attr($_REQUEST['uxEditTelephoneNumber']);
			$uxEditMobileNumber=esc_attr($_REQUEST['uxEditMobileNumber']);
            $uxEditAddress1=esc_attr($_REQUEST['uxEditAddress1']);
			$uxEditAddress2=esc_attr($_REQUEST['uxEditAddress2']);
	        $uxEditCity=esc_attr($_REQUEST['uxEditCity']);
	        $uxEditPostalCode=esc_attr($_REQUEST['uxEditPostalCode']);
			$uxEditCountry=intval($_REQUEST['uxEditCountry']);
			$uxEditComments=esc_attr($_REQUEST['uxEditComments']);
			$updateComments = esc_attr($_REQUEST['comment']);
			
			if($updateComments != "no")
			{
				$wpdb->query
		     	(
		            $wpdb->prepare
		            (
		                    "UPDATE ".customersTable()." SET CustomerFirstName= %s, CustomerLastName = %s, CustomerEmail = %s,
		                    CustomerTelephone=%s, CustomerMobile = %s, CustomerAddress1=%s, CustomerAddress2=%s, CustomerCity=%s, 
		                    CustomerZipCode=%s,CustomerCountry=%d, CustomerComments=%s WHERE CustomerId = %d",
	                        $uxEditFirstName,
		                    $uxEditLastName,
		                    $uxEditEmailAddress,
		                    $uxEditTelephoneNumber,
	                        $uxEditMobileNumber,
		                    $uxEditAddress1,
		                    $uxEditAddress2,
	                        $uxEditCity,
		                    $uxEditPostalCode,
		                    $uxEditCountry,
		                    $uxEditComments,
		                    $CustomerId
		             )
		      	);
			}
			else
			{
				$bookingFormData = $wpdb->get_results('SELECT * From '.bookingFormTable());
				for($flagField = 0; $flagField < count($bookingFormData); $flagField++)
				{
					if($bookingFormData[$flagField]->status == 1)
					{
						switch($bookingFormData[$flagField]->BookingFormId)
						{
							case 1:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerEmail = %s WHERE CustomerId = %d",
		                        	$uxEditEmailAddress,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 2:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerFirstName = %s WHERE CustomerId = %d",
		                        	$uxEditFirstName,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 3:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerLastName = %s WHERE CustomerId = %d",
		                        	$uxEditLastName,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 4:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerMobile = %s WHERE CustomerId = %d",
		                        	$uxEditMobileNumber,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 5:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerTelephone = %s WHERE CustomerId = %d",
		                        	$uxEditTelephoneNumber,	                
			                   		$CustomerId
			            		)
			            	);	
							$customerPhone = $uxEditTelephoneNumber;
							break;
							case 6:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerAddress1 = %s WHERE CustomerId = %d",
		                        	$uxEditAddress1,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 7:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerAddress2 = %s WHERE CustomerId = %d",
		                        	$uxEditAddress2,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 8:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerCity = %s WHERE CustomerId = %d",
		                        	$uxEditCity,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 9:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerZipCode = %s WHERE CustomerId = %d",
		                        	$uxEditPostalCode,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							case 10:
							$wpdb->query
			     			(
			           			$wpdb->prepare
			            		(
			            			"UPDATE ".customersTable()." SET CustomerCountry = %d WHERE CustomerId = %d",
		                        	$uxEditCountry,	                
			                   		$CustomerId
			            		)
			            	);	
							break;
							
						}
						
					}
			}
		}
		die();
	}
	else if($_REQUEST['target'] == "DeleteCustomer")
	{
			$customerId = intval($_REQUEST['uxcustomerId']);
			$countBooking = $wpdb->get_var('SELECT count(BookingId) FROM ' . bookingTable() . ' where CustomerId ='. $customerId);
			if($countBooking != 0)
			{
				echo "bookingExist";
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
					   "DELETE FROM ".customersTable()." WHERE CustomerId = %d",
					    $customerId
					)
				);
			}
			die();
	}
	else if($_REQUEST['target'] == "getCountBlockDate")
	{
			$employeeId = intval($_REQUEST['empId']);
			$dateArray = $_REQUEST['dateArray'];
			$countBlockDate = $wpdb->get_var
			(
					$wpdb->prepare
					(
							"SELECT count(BlockDateId) From ". blockDateTable() ." where Day = ". '"' . $dateArray .'"'." and EmployeeId = $employeeId"
								
					)
			);
			echo $countBlockDate;
			die();
	}
	else if($_REQUEST['target'] == "dateOff")
	{
			$dateFrom = $_REQUEST['dateFrom'];
			$dateTo = $_REQUEST['dateTo'];
			$employeeId = intval($_REQUEST['employeeId']);
			for($currentdate = $dateFrom; $currentdate <= $dateTo; $currentdate=date('Y-m-d', strtotime($currentdate. ' + 1 day')))
			{
							$countBlockDate = $wpdb->get_var("SELECT count(BlockDateId) From ". blockDateTable() ." where Day = '". $currentdate ."' and EmployeeId = ".$employeeId);
							if($countBlockDate == 0)
							{
							  $wpdb->query
							  (
									$wpdb->prepare
									(
											"INSERT INTO " . blockDateTable()."(EmployeeId,Day) VALUES(%d, '$currentdate')",
											$employeeId
									)
							  );
							}  
			}
			die();
	}
	else if($_REQUEST['target'] == "addTimeOff")
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$timeOffDate = $_REQUEST['timeOffDate'];
			$timeOffStartTime = $_REQUEST['timeOffStartTime'];
			$countBlockTime = $wpdb->get_var("SELECT count(BlockTimeId) From ". blockDateTable() ." where Day = '". $currentdate ."' and EmployeeId = ".$employeeId ."' and TimeSlot = ".$timeOffStartTime);
			if($countBlockTime == 0)
			{
				$wpdb->query
		    	(
		        	$wpdb->prepare
		          	(
		              	    "INSERT INTO " . blockTimeTable()."(EmployeeId,TimeSlot,Day) VALUES(%d,'$timeOffStartTime','$timeOffDate')",
		               		$employeeId
		            )
		        );
			}
			die();
	}
	else if($_REQUEST['target'] == "bindDayOff")
	{
		$employeeId = intval($_REQUEST['employeeId']);
		?>
	
     	<div class="span5 well">
	     	<div class="navbar">
		 		<div class="navbar-inner">
		    		<h5><?php _e("Upcoming Day Off's", bookings_plus ); ?></h5>
		      	</div>
		    </div>		
			<div class="table-overflow">
				<table class="table table-striped" id="data-table-dayOffs">
					<thead>
						<tr>
							<th><?php _e( "Employee", bookings_plus ); ?></th>
							<th><?php _e( "Date", bookings_plus ); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$currentDate = date("Y-m-d");
					    $uxUpcomingDayOff = $wpdb->get_results
			            (
					    		$wpdb->prepare
					            (
							    	"SELECT " . employeesTable() . ".EmployeeId,  " . employeesTable() . ".EmployeeName,  ". blockDateTable() . ".Day, " . blockDateTable() . ".BlockDateId From " 
							        . blockDateTable() . " join " . employeesTable() . " on " . blockDateTable() . ".EmployeeId = " . employeesTable() . ".EmployeeId 
							        where " . employeesTable() . ".EmployeeId = " . $employeeId . " and " . blockDateTable() . ".Day >= ".'"'.$currentDate.'"'." order by " . blockDateTable() . ".Day" 
					            )
			            );
						for($flag=0; $flag < count($uxUpcomingDayOff); $flag++)
						{
						?>
							<tr>
								<td><?php echo $uxUpcomingDayOff[$flag] -> EmployeeName ?></td>
								<?php
								$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											
								if($dateFormat == 0)
								{
									?>
									<td><?php echo date("M d, Y", strtotime($uxUpcomingDayOff[$flag] -> Day));?></td>
									<?php
								}
								else if($dateFormat == 1)
								{
								?>
									<td><?php echo date("Y/m/d", strtotime($uxUpcomingDayOff[$flag] -> Day));?></td>
									<?php
								}	
								else if($dateFormat == 2)
								{
								?>
									<td><?php echo date("m/d/Y", strtotime($uxUpcomingDayOff[$flag] -> Day));?></td>
									<?php
								}	
								else if($dateFormat == 3)
								{
									?>
									<td><?php echo date("d/m/Y", strtotime($uxUpcomingDayOff[$flag] -> Day));?></td>
									<?php
								}
								?>
								
								<td><a class="icon-remove hovertip" data-original-title="<?php _e("Delete Day Off?", bookings_plus ); ?>" data-placement="top" onclick="deleteDayOff(<?php echo $uxUpcomingDayOff[$flag] -> BlockDateId;?>);"></a></td>
							</tr>
						<?php	
					    }		
					    ?>	
					</tbody>
				</table>
			</div>
		</div>
		 <div class="span7 well">
			 	<div class="navbar">
					<div class="navbar-inner">
						<h5><?php _e("Upcoming Time Off's", bookings_plus ); ?></h5>
					</div>
				</div>		
				<div class="table-overflow">
					<table class="table table-striped" id="data-table-TimeOffs">
						<thead>
							<tr>
								<th><?php _e( "Employee", bookings_plus ); ?></th>
								<th><?php _e( "Date", bookings_plus ); ?></th>
								<th><?php _e( "Time Slot", bookings_plus ); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php
							$currentDate = date("Y-m-d");
						    $uxUpcomingTimeOff = $wpdb->get_results
				            (
						    		$wpdb->prepare
						            (
								    		"SELECT ".employeesTable().".EmployeeId	,".  employeesTable() . ".EmployeeName,  ". blockTimeTable().".Day ,".blockTimeTable().".TimeSlot ,".blockTimeTable().".BlockTimeId 
								    		FROM ".blockTimeTable()." join ".employeesTable()." on ".blockTimeTable().".EmployeeId=".employeesTable().".EmployeeId
										    where " . employeesTable() . ".EmployeeId = " . $employeeId . " and " . blockTimeTable() . ".Day >= ".'"'.$currentDate.'"'." order by " . blockTimeTable() . ".BlockTimeId ASC" 
										    
						            )
				            );
							$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
							for($flag=0; $flag < count($uxUpcomingTimeOff); $flag++)
							{
							?>
								<tr>
									<?php
									$getHours = floor(($uxUpcomingTimeOff[$flag] -> TimeSlot)/60);
									$getMins = ($uxUpcomingTimeOff[$flag] -> TimeSlot) % 60;
			                        $hourFormat = $getHours . ":" . "00";
					                if($timeFormats == 0)
									{
										$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
									}
									else 
									{
										$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
									}
						            if($getMins!=0)
				                    {
					                	$hourFormat = $getHours . ":" . $getMins;
					                    if($timeFormats == 0)
										{
											$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
										}
										else 
										{
											$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
										}
					                }
					                ?>
					                <td><?php echo  $uxUpcomingTimeOff[$flag] -> EmployeeName ?></td>
					                <?php
								$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											
								if($dateFormat == 0)
								{
									?>
									<td><?php echo date("M d, Y", strtotime($uxUpcomingTimeOff[$flag] -> Day));?></td>
									<?php
								}
								else if($dateFormat == 1)
								{
								?>
									<td><?php echo date("Y/m/d", strtotime($uxUpcomingTimeOff[$flag] -> Day));?></td>
									<?php
								}	
								else if($dateFormat == 2)
								{
								?>
									<td><?php echo date("m/d/Y", strtotime($uxUpcomingTimeOff[$flag] -> Day));?></td>
									<?php
								}	
								else if($dateFormat == 3)
								{
									?>
									<td><?php echo date("d/m/Y", strtotime($uxUpcomingTimeOff[$flag] -> Day));?></td>
									<?php
								}
								?>
									
									<td><?php echo $time_in_12_hour_format ?></td>	
									<td><a class="icon-remove hovertip" data-original-title="<?php _e("Delete Time Off?", bookings_plus ); ?>" data-placement="top" onclick="deleteTimeOff(<?php echo $uxUpcomingTimeOff[$flag] -> BlockTimeId ;?>);"></a></td>
								</tr>
							<?php	
						    }		
						    ?>	
						</tbody>
					</table>
				</div>
		</div>
			<script>
					oTable = jQuery('#data-table-dayOffs').dataTable
					({
						"bJQueryUI": false,
						"bAutoWidth": true,
						"sPaginationType": "full_numbers",
						"sDom": 't<"datatable-footer"ip>',
						"oLanguage": 
						{
							"sLengthMenu": "<span>Show entries:</span> _MENU_"
						},
						"aaSorting": [[ 1, "asc" ]],
						"aoColumnDefs": [{ "bSortable": false, "aTargets": [2] }]
			    	});
			    	oTable = jQuery('#data-table-TimeOffs').dataTable
					({
						"bJQueryUI": false,
						"bAutoWidth": true,
						"sPaginationType": "full_numbers",
						"sDom": 't<"datatable-footer"ip>',
						"oLanguage": 
						{
							"sLengthMenu": "<span>Show entries:</span> _MENU_"
						},
						"aaSorting": [[ 1, "asc" ]],
						"aoColumnDefs": [{ "bSortable": false, "aTargets": [3] }]
			    	});  
    						jQuery('.hovertip').tooltip();
		</script>		
	<?php
	die();
	}
	else if($_REQUEST['target'] == "deleteDayOff")
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$wpdb->query
			(
					$wpdb->prepare
					(
						   "DELETE FROM ".blockDateTable()." WHERE BlockDateId = %d",
						    $employeeId
					)
			);
			die();
	}
	else if($_REQUEST['target'] == "deleteTimeOff")
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$wpdb->query
			(
					$wpdb->prepare
					(
						   "DELETE FROM ".blockTimeTable()." WHERE BlockTimeId = %d",
						    $employeeId
					)
			);
			die();
	}
	else if($_REQUEST['target'] == "getBookingCount")
	{
		
			$count = $wpdb->get_var('SELECT count(BookingId) FROM ' . bookingTable());
			echo $count;
	}
	else if($_REQUEST['target'] == "updatebooking")
	{
			$bookingId = intval($_REQUEST['bookingId']);
			$bookingDetail = $wpdb->get_row
			(
			 	$wpdb->prepare
			 	(
					"SELECT CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable().
					".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceId,"
					.employeesTable(). ".EmployeeName,".employeesTable(). ".EmployeeId,".bookingTable().".Date,". bookingTable().".TimeSlot,". bookingTable().".BookingId,
					". bookingTable().".BookingStatus,". bookingTable().".TransactionId,". bookingTable().".PaymentStatus,". bookingTable().".PaymentDate from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
					".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .employeesTable()." ON ".bookingTable().
					".EmployeeId=".employeesTable().".EmployeeId". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
					".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".BookingId =  ".$bookingId."
					ORDER BY ".bookingTable().".Date asc"
				)
		 	);
			 
			?>	
			<div class="well-smoke block"  style="margin-top:10px">
		 	   		<div class="row-fluid form-horizontal">    
						<div class="control-group">
					    	<label class="control-label"><?php _e( "Client Name :", bookings_plus ); ?>
					        </label>
					        <div class="controls">
					        	<label class="control-label" id="bookingClientName"><?php echo $bookingDetail->ClientName; ?></label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e( "Client Mobile :", bookings_plus ); ?>
						    </label>
						    <div class="controls">
					        	<label class="control-label" id="bookingClientMobile"><?php echo $bookingDetail->CustomerMobile; ?></label>
						    </div>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e( "Employee :", bookings_plus ); ?>
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
							<select name="uxDdltimeOff" class="required" id="uxDdltimeOff" onchange="funcBindEditSlots();">
	                        	<option value ="opt1"><?php _e( "Please Choose Employee", bookings_plus ); ?></option>	
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
						<div class="control-group">
							<label class="control-label"><?php _e( "Service Booked :", bookings_plus ); ?>
						    </label>
						    <div class="controls" id="servicesBind">
						    		<select name="uxDdlBookingServices" class="required" id="uxDdlBookingServices" onchange="funcBindEditSlots();">
	        						</select>							        
						    </div>
					
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e( "Booking Date :", bookings_plus ); ?>
						    </label>
						     <div class="controls">
					    		<input type="text" class="required span12" name="BookingDate" id="BookingDate" value="<?php echo date("Y-m-d", strtotime($bookingDetail->Date));?>"/>
					    						    		
					    	</div>
						    <?php
						    $blockDays = $wpdb->get_results
					     	(
					            $wpdb->prepare
					            (
									"select Day from " . employees_TimingsTable() . " where EmployeeId  = %d and Status = 0",
									$bookingDetail->EmployeeId
								)
					      	);
							$uxUpcomingDayOff = $wpdb->get_results
			           		 (
					    		$wpdb->prepare
					            (
							    	"SELECT ". blockDateTable() . ".Day From " 
							        . blockDateTable() . " where " . blockDateTable() . ".EmployeeId = " . $bookingDetail->EmployeeId  
					            )
			            	);
							$days = "[";
							if(count($blockDays) > 0)
							{
															
								for( $flagBlockDays = 0; $flagBlockDays < count($blockDays); $flagBlockDays++)
								{
									if(count($blockDays) > 1)
									{
										if($flagBlockDays <  (count($blockDays) - 1))
										{
											$days .= '['. $blockDays[$flagBlockDays]->Day .'],';
										}
										else
										{
											$days .= '['. $blockDays[$flagBlockDays]->Day .']';
										}
									}
									else 
									{
										$days .= '['. $blockDays[$flagBlockDays]->Day .']';
									}
								}
								
							}
							$days .= "]";
							$dates = "[";
							if(count($uxUpcomingDayOff) > 0)
							{
								
								for( $flagUxUpcomingDayOff = 0; $flagUxUpcomingDayOff < count($uxUpcomingDayOff); $flagUxUpcomingDayOff++)
								{
									if(count($uxUpcomingDayOff) > 1)
									{
										if($flagUxUpcomingDayOff < (count($uxUpcomingDayOff) - 1))
										{
											$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
											$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].'],';
										}
										else
										{
											$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
											$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
										}
									}
									else 
									{
											$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
											$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
									}							    
								}
								
							}
							$dates .= "]";
							$dynamic.=						    
						    '<script>
						      function nonWorkingDates(date)
						      {
						      	var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
						        var day = date.getDay();
								var currentDate = new Date();
						        var closedDates = '.$dates.';
						        var closedDays = '.$days.';
						        for (var i = 0; i < closedDays.length; i++) 
						        {
						            if (day == closedDays[i][0]) 
						            {
						                return [false];
									
						            }						
						        }
						    
						      
 								for (i = 0; i < closedDates.length; i++) {
						            if (date.getMonth() == closedDates[i][0] - 1 &&
						            date.getDate() == closedDates[i][1] &&
						            date.getFullYear() == closedDates[i][2]) {
						                return [false];
										
						            }
						        }
								if((date.getMonth() < currentDate.getMonth() || date.getFullYear() < currentDate.getFullYear()) || (date.getDate() < currentDate.getDate() && date.getMonth() == currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()))
								{
									return [false];
								}
								return [true];
							  }
						      jQuery("#BookingDate").datepicker
						      ({
						    	defaultDate: +7,
						    	showOtherMonths:true,
						    	autoSize: true,
						    	dateFormat: \'yy-mm-dd\',
						    	numberOfMonths: 3,
						    	functionCall: "getEditSlots",
						    	beforeShowDay: nonWorkingDates
						    							    	
							  });
							</script>';
									echo $dynamic;
							?>
						</div>
						<div class="control-group">
							<label class="control-label"><?php _e( "Time Slot :", bookings_plus ); ?>
						    </label>
 							<div class="controls">
					            <select name="uxStartTime" class="style required" id="uxStartTime">
						        	<option value ="opt1"><?php _e( "Please Choose Time", bookings_plus ); ?></option>	
					           </select>
					           	
							</div>
						</div>
						<input type="hidden" value="<?php echo $bookingDetail->TimeSlot; ?>" id="hdTimeSlot"/>
						<script>jQuery('#uxDdltimeOff').val("<?php echo $bookingDetail->EmployeeId; ?>");bindServices("<?php echo $bookingDetail->ServiceId; ?>","<?php echo $bookingDetail->TimeSlot; ?>");funcBindEditSlotsByService("<?php echo $bookingDetail->ServiceId; ?>","<?php echo $bookingDetail->TimeSlot; ?>");</script>

						<input type="hidden" id="bookingHideId" value="<?php echo $bookingId; ?>" />												
						<div class="control-group">
							<label class="control-label"><?php _e( "Booking Status :", bookings_plus ); ?>
						    </label>
						    <div class="controls">
					            <select name="uxBookingStaus" class="style required" id="uxBookingStaus">
					            	<?php
					            	if($bookingDetail->BookingStatus =="Pending Approval")
									  {
									  ?>
									  		<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 
											<option value="Approved" >Approved</option>
											<option value="Disapproved" >Disapproved</option>
											<option value="Cancelled" >Cancelled</option> 
									  <?php
									  }
									  elseif($bookingDetail->BookingStatus =="Approved")
									  {
									   ?>
									   		<option value="Pending Approval" >Pending Approval</option>
									  		<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 											
											<option value="Disapproved" >Disapproved</option>
											<option value="Cancelled" >Cancelled</option> 
									  <?php
									  
									  }
									   elseif($bookingDetail->BookingStatus =="Disapproved")
									  {
									   ?>
									   		<option value="Pending Approval" >Pending Approval</option>
									   		<option value="Approved" >Approved</option>
									  		<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 											
											<option value="Cancelled" >Cancelled</option> 
									  <?php
									  }
									  else
									  {
									   ?>
											<option value="Pending Approval" >Pending Approval</option>
											<option value="Approved" >Approved</option>
											<option value="Disapproved" >Disapproved</option>									   
									  		<option value="<?php echo $bookingDetail->BookingStatus; ?>" selected="selected" ><?php echo $bookingDetail->BookingStatus; ?></option> 
									  <?php
									  }
									?>						        	
					           </select>
					         
						    </div>
						</div>																													
		        	</div>		        
				</div>
				
					 
		<?php
		die();	
	}
	else if($_REQUEST['target'] == "cancelBooking")
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$wpdb->query
	    (
		            $wpdb->prepare
		            (
		                    "UPDATE ".bookingTable()." SET BookingStatus  = %s WHERE BookingId = %d",
		                    "Cancelled",
		                    $bookingId
		            )
	    );
		die();
	}
	else if($_REQUEST['target'] == "deleteBooking")
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$wpdb->query
	    (
		         $wpdb->prepare
		         (
		                "DELETE FROM ".bookingTable()." WHERE BookingId = %d",
						$bookingId
		         )
	    );
		die();
	}
	else if($_REQUEST['target'] == "updateEditBookings")
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$uxStartTime = intval($_REQUEST['uxStartTime']);
		$BookingDate = $_REQUEST['BookingDate'];
		$uxDdlBookingServices = intval($_REQUEST['uxDdlBookingServices']);
		$uxDdltimeOff = intval($_REQUEST['uxDdltimeOff']);
		$uxBookingStaus = esc_attr($_REQUEST['uxBookingStaus']);
		$wpdb->query
	    (
		         $wpdb->prepare
		         (
		                "UPDATE ".bookingTable()." SET BookingStatus  = %s , ServiceId = %d, EmployeeId = %d, TimeSlot = %d, Date = '$BookingDate'  WHERE BookingId = %d",
		                $uxBookingStaus,
		                $uxDdlBookingServices,
		                $uxDdltimeOff,
		                $uxStartTime,
		                $bookingId
		         )
	    );
		include_once 'mailmanagement.php';
		if($uxBookingStaus == "Pending Approval")
		{
			MailManagement($bookingId,"approval_pending");	
			MailManagement($bookingId,"admin");			
		}
		else if($uxBookingStaus == "Approved")
		{
			MailManagement($bookingId,"approved");			
		}
		else if($uxBookingStaus == "Disapproved")
		{
			MailManagement($bookingId,"disapproved");		
		}
		die();
	}
	else if($_REQUEST['target']== 'updateRecordsListings')
 	{
		$updateRecordsArray = $_POST['recordsArray'];
	 	$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue)
		{
	   		$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	  				"UPDATE ".servicesTable()." SET ServiceDisplayOrder  = %d WHERE ServiceId = %d",
	  				$listingCounter,
	  				$recordIDValue
				)
	      	);
			 echo  "UPDATE ".servicesTable()." set ServiceDisplayOrder =".$listingCounter." where ServiceId='" . $recordIDValue . "'";
   
			$listingCounter = $listingCounter + 1;	
		}
		die();
 	}
	else if($_REQUEST['target']== 'customerBooking')
	{
		$customerId  = intval($_REQUEST['customerId']);
		$customerNameReturn = $wpdb->get_row("SELECT CustomerFirstName,CustomerLastName  FROM ".customersTable()." where CustomerId = ".$customerId);
		$customerBookingDetail = $wpdb->get_results
	    (
	          $wpdb->prepare
	          (
					"SELECT ". servicesTable(). ".ServiceName, ".employeesTable(). ".EmployeeName,
					".bookingTable().".Date,". bookingTable().".TimeSlot,". bookingTable().".Comments,". bookingTable().".DateofBooking,
					". bookingTable().".BookingStatus,". bookingTable().".BookingId from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
					".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .employeesTable()." ON ".bookingTable().
					".EmployeeId=".employeesTable().".EmployeeId". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
					".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".CustomerId =  ".$customerId."
					ORDER BY ".bookingTable().".Date asc"
			  )
	   );
	   for($flag = 0; $flag < count($customerBookingDetail); $flag++)
	   {
		?>
		<tr>
			<td><?php echo $customerBookingDetail[$flag]->ServiceName; ?></td>
			<td><?php echo $customerBookingDetail[$flag]->EmployeeName; ?></td>
			<?php
			$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											
						if($dateFormat == 0)
						{
						?>
							<td><?php echo date("M d, Y", strtotime($customerBookingDetail[$flag]->Date));?></td>
							<?php
						}
						else if($dateFormat == 1)
						{
						?>
							<td><?php echo date("Y/m/d", strtotime($customerBookingDetail[$flag]->Date));?></td>
							<?php
						}	
						else if($dateFormat == 2)
						{
							?>
							<td><?php echo date("m/d/Y", strtotime($customerBookingDetail[$flag]->Date));?></td>
							<?php
						}	
						else if($dateFormat == 3)
						{
							?>
							<td><?php echo date("d/m/Y", strtotime($customerBookingDetail[$flag]->Date));?></td>
						<?php
						}
						?>
			
			<?php
			    	$getHours = floor(($customerBookingDetail[$flag]->TimeSlot)/60);
					$getMins = ($customerBookingDetail[$flag]->TimeSlot) % 60;
		            $hourFormat = $getHours . ":" . "00";
		            if($timeFormats == 0)
					{
						$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
					}
					else 
					{
						$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
					}
		            if($getMins!=0)
		            {
		               	$hourFormat = $getHours . ":" . $getMins;
		                if($timeFormats == 0)
						{
							$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
						}
						else 
						{
							$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
						}
		            }
			    ?>
			<td><?php echo $time_in_12_hour_format; ?></td>
			<td><?php echo $customerBookingDetail[$flag]->BookingStatus; ?></td>
			<?php
			$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											
						if($dateFormat == 0)
						{
						?>
							<td><?php echo date("M d, Y", strtotime($customerBookingDetail[$flag]->DateofBooking));?></td>
							<?php
						}
						else if($dateFormat == 1)
						{
						?>
							<td><?php echo date("Y/m/d", strtotime($customerBookingDetail[$flag]->DateofBooking));?></td>
							<?php
						}	
						else if($dateFormat == 2)
						{
							?>
							<td><?php echo date("m/d/Y", strtotime($customerBookingDetail[$flag]->DateofBooking));?></td>
							<?php
						}	
						else if($dateFormat == 3)
						{
							?>
							<td><?php echo date("d/m/Y", strtotime($customerBookingDetail[$flag]->DateofBooking));?></td>
						<?php
						}
						?>
			
			<td>
			  	<a class="icon-tag fancybox" href="#customerComments" onclick="customerBookingComments(<?php echo $customerBookingDetail[$flag]->BookingId; ?>);">
			    </a>&nbsp;&nbsp;											
			    <a class="icon-trash" onclick="deleteCustomerBooking(<?php echo $customerBookingDetail[$flag]->BookingId; ?>)">
			    </a>							               												
			</td>
		</tr>
		<?php
		}
		?>
		<input id="customernameBooKing" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . " ". $customerNameReturn->CustomerLastName ; ?>" />
		<script>
				oTable = jQuery('#data-table-customer-bookings').dataTable
				({
					"bJQueryUI": false,
					"bAutoWidth": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
					"oLanguage": 
					{
						"sLengthMenu": "<span>Show entries:</span> _MENU_"
					}
					
					
				});	
		</script>
		<?php
		die();
	}
	else if($_REQUEST['target'] == 'deleteCustomerBookings')
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$wpdb->query
		(
				$wpdb->prepare
				(
					   "DELETE FROM ".bookingTable()." WHERE BookingId = %d",
					    $bookingId
				)
		);
		die();
	}
	else if($_REQUEST['target'] == 'customerBookingCommentsId')
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$comment = $wpdb->get_var("SELECT Comments FROM ".bookingTable()." where BookingId = ".$bookingId);
		echo $comment;
		die();
	}
	else if($_REQUEST['target'] == 'updateCustomersComments')
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$uxCustomerComments = html_entity_decode($_REQUEST['uxCustomerComments']);
		$wpdb->query
	    (
		     $wpdb->prepare
		     (
		            "UPDATE ".bookingTable()." SET Comments  = %s WHERE BookingId = %d",
		            $uxCustomerComments,
		            $bookingId
		     )
	    );
		die();
	}
	else if($_REQUEST['target'] == 'getBookings')
	{
		$EmployeeId = $_REQUEST['EmployeeId'];
		$status1 = $_REQUEST['status1'];
		$status2 = $_REQUEST['status2'];
		$status3 = $_REQUEST['status3'];
		$status4 = $_REQUEST['status4'];
		$status5 = $_REQUEST['status5'];
		$status6 = $_REQUEST['status6'];
		$query = "";
		if($status1 == "true")
		{
			$query .= "( ". bookingTable().".BookingStatus = 'Pending Approval'  ";
		}
		if($status2 == "true")
		{
			if($status1 == "true")
			{
				$query .= " or ";
			}
			else 
			{
				$query .= "( ";
			}
			$query  .= bookingTable().".BookingStatus = 'Approved' ";
		}
		if($status3 == "true")
		{
			if($status1 == "true" || $status2 == "true")
			{
				$query .= " or ";
			}
			else 
			{
				$query .= "( ";
			}			
			$query  .= bookingTable().".BookingStatus = 'Disapproved' ";
		}
		if($status4 == "true")
		{
			if($status1 == "true" || $status2 == "true" || $status3 == "true")
			{
				$query .= " or ";
			}
			else 
			{
				$query .= "( ";
			}			
			$query  .= bookingTable().".BookingStatus = 'Cancelled' ";
		}
		if($status1 == "true" || $status2 == "true" || $status3 == "true"  || $status4 == "true")
		{
			$query .= " )";
		}
		if($EmployeeId == "allEmployee")
		{
			$allBookings =  $wpdb->get_results
	     	(
	            $wpdb->prepare
	            (
					"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceTotalTime, ".employeesTable(). ".EmployeeColorCode,".employeesTable(). ".EmployeeName," .bookingTable().".Date,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
					". bookingTable().".TimeSlot,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." JOIN " .employeesTable()." ON ".bookingTable().
					".EmployeeId=".employeesTable().".EmployeeId". " LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
								            	".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
					".ServiceId=".servicesTable().".ServiceId where ".$query." ORDER BY ".bookingTable().".Date ASC"
				)
	      	);
			if($status5 == "true")
			{
				$uxUpcomingDayOff = $wpdb->get_results
			    (
					$wpdb->prepare
					(
						"SELECT " . blockDateTable() . ".BlockDateId, ". employeesTable() . ".EmployeeId, " . employeesTable() . ".EmployeeName, " . employeesTable() . ".EmployeeColorCode, " . blockDateTable() . ".Day From " 
						. blockDateTable() . " join " . employeesTable() . " on " . blockDateTable() . ".EmployeeId = " . employeesTable() . ".EmployeeId 
						".  "  order by " . blockDateTable() . ".Day" 
					)
			    );
		    }
			if($status6 == "true")
			{
				$uxUpcommingTimeOff = $wpdb->get_results
			    (
					$wpdb->prepare
					(
						"SELECT ".blockTimeTable().".BlockTimeId,".employeesTable().".EmployeeId ,".employeesTable().".EmployeeName,".employeesTable().".EmployeeColorCode ," .blockTimeTable()."
						.Day ,".blockTimeTable().".TimeSlot FROM ".blockTimeTable()." join ".employeesTable()." on ".blockTimeTable().".EmployeeId=".employeesTable().".EmployeeId"
					)
			    );			
			}
		}	
		else
		{
			$allBookings =  $wpdb->get_results
	     	(
	            $wpdb->prepare
	            (
	            	"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceTotalTime, ".employeesTable(). ".EmployeeColorCode,".employeesTable(). ".EmployeeName," .bookingTable().".Date,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
					". bookingTable().".TimeSlot,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." JOIN " .employeesTable()." ON ".bookingTable().
					".EmployeeId=".employeesTable().".EmployeeId". " LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
					".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
					".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".EmployeeId = ".$EmployeeId." and ".$query." ORDER BY ".bookingTable().".Date ASC"
					
				)
	      	);
	      	if($status5 == "true")
			{
				$uxUpcomingDayOff = $wpdb->get_results
			    (
					$wpdb->prepare
					(
						"SELECT " . blockDateTable() . ".BlockDateId, ". employeesTable() . ".EmployeeId, " . employeesTable() . ".EmployeeName, " . employeesTable() . ".EmployeeColorCode, " . blockDateTable() . ".Day From " 
						. blockDateTable() . " join " . employeesTable() . " on " . blockDateTable() . ".EmployeeId = " . employeesTable() . ".EmployeeId 
						".  " where ".blockDateTable().".EmployeeId = ".$EmployeeId."  order by " . blockDateTable() . ".Day" 
					)
			    );
			}
			if($status6 == "true")
			{
				$uxUpcommingTimeOff = $wpdb->get_results
			    (
					$wpdb->prepare
					(
						"SELECT ".blockTimeTable().".BlockTimeId,".employeesTable().".EmployeeId,".employeesTable().".EmployeeName,".employeesTable().".EmployeeColorCode ," .blockTimeTable()."
						.Day ,".blockTimeTable().".TimeSlot FROM ".blockTimeTable()."
						join ".employeesTable()." on ".blockTimeTable().".EmployeeId=".employeesTable().".EmployeeId where ".blockTimeTable().".EmployeeId = ".$EmployeeId
					)
			    );
			}			
		}	
		$dynamicCalendar = "<script>jQuery('#calendar').fullCalendar( 'destroy' );jQuery('#calendar').fullCalendar
		({
			disableDragging: true,
			header: 
			{
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
		 events: [";
		 for($start = 0; $start<count($allBookings);$start++)
		 {
		 	$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->Date));
			$bdate = (explode("-",$bookingDate));
			
			$getHours = floor(($allBookings[$start]->TimeSlot)/60);
			$getEndHours = floor(($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime))/60;

			if($getHours%60!=0)
			{
				$getMins = ($allBookings[$start]->TimeSlot) % 60;
			}
			else {
				$getMins = 0;
			}
			if($getEndHours%60!=0)
			{
				$getEndMins = ($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime) % 60;
			}
			else 
			{
				$getEndMins = 0;
			}
			if($start == count($allBookings) -1)
			{
				$dynamicCalendar .= "{
					title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
					bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
					employeeName:".'"'.$allBookings[$start]->EmployeeName.'"'.",
					status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
					clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
					clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
					start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
					end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
					url:'#EditBooking',
					allDay: false				
						}";					
			}
			else 
			{
					$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
					bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
					employeeName:".'"'.$allBookings[$start]->EmployeeName.'"'.",
					status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
					clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
					clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
					start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
					end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
					url:'#EditBooking',
					allDay: false						
							},";			
			}

		}
		if(count($allBookings) > 0)
		{
			if(count($uxUpcomingDayOff) > 0)
			{
				$dynamicCalendar .=  ",";
			}
		}		
		for($startDayOff = 0; $startDayOff<count($uxUpcomingDayOff);$startDayOff++)
		{
			$DayOffDate = $uxUpcomingDayOff[$startDayOff]->Day;
			$ddate = (explode("-",$DayOffDate));
			if($startDayOff == count($uxUpcomingDayOff) -1)
			{
				$dynamicCalendar .= "{
					title: 'Day Off',
					bookingId:".'"'.$uxUpcomingDayOff[$startDayOff]->BlockDateId.'DayOff"'.",
					start: new Date($ddate[0], $ddate[1] - 1, $ddate[2]),
					end: new Date($ddate[0], $ddate[1] - 1, $ddate[2]),
					allDay: true				
				}";
			}
			else
			{
				$dynamicCalendar .= "{
					title: 'Day Off',
					bookingId:".'"'.$uxUpcomingDayOff[$startDayOff]->BlockDateId.'DayOff"'.",
					start: new Date($ddate[0], $ddate[1] - 1, $ddate[2]),
					end: new Date($ddate[0], $ddate[1] - 1, $ddate[2]),
					allDay: true				
				},";	
		
			}
		}
		if(count($uxUpcomingDayOff) > 0)
		{
			if(count($uxUpcommingTimeOff) > 0)
			{
				$dynamicCalendar .=  ",";
			}
		}
		else if(count($allBookings) > 0)
		{
			if(count($uxUpcommingTimeOff) > 0)
			{
				$dynamicCalendar .=  ",";
			}
		}
			 
		for($startTimeOff = 0; $startTimeOff<count($uxUpcommingTimeOff);$startTimeOff++)
		{
			$getHours = floor(($uxUpcommingTimeOff[$startTimeOff]->TimeSlot)/60);
			if($getHours%60!=0)
			{
				$getMins = ($uxUpcommingTimeOff[$startTimeOff]->TimeSlot) % 60;
			}
		 
			$TimeOffDate = $uxUpcommingTimeOff[$startTimeOff]->Day;
			$ddate = (explode("-",$TimeOffDate));
			if($startTimeOff == count($uxUpcommingTimeOff) -1)
			{
				$dynamicCalendar .= "{
					title: 'Time Off',
					bookingId:".'"'.$uxUpcommingTimeOff[$startTimeOff]->BlockTimeId.'TimeOff"'.",
					start: new Date($ddate[0], $ddate[1] - 1, $ddate[2],$getHours,$getMins),
					end: new Date($ddate[0], $ddate[1] - 1, $ddate[2],$getHours,$getMins),
					allDay: false			
				}";
			}
			else
			{
				$dynamicCalendar .= "{
					title: 'Time Off',
					bookingId:".'"'.$uxUpcommingTimeOff[$startTimeOff]->BlockTimeId.'TimeOff"'.",
					start: new Date($ddate[0], $ddate[1] - 1, $ddate[2],$getHours,$getMins),
					end: new Date($ddate[0], $ddate[1] - 1, $ddate[2],$getHours,$getMins),
					allDay: false				
				},";	
		
			}
		 }		 
	 		
		$dynamicCalendar .= "]});jQuery('.popover-test').popover({
		placement: 'left'
		});";
			 
         $dynamicCalendar .= "</script><style type=\"text/css\">";
		 for($start = 0; $start<count($allBookings);$start++)
		 {
		 
			$dynamicCalendar .=".fc-event".$allBookings[$start]->BookingId . "{border: 1px solid ". $allBookings[$start]->EmployeeColorCode."; color: white; display: block; font-size: 11px;
			background: ". $allBookings[$start]->EmployeeColorCode." url(../images/elements/ui/progress_overlay.png);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -moz-linear-gradient(top, ". $allBookings[$start]->EmployeeColorCode." 0%, ". $allBookings[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%,". $allBookings[$start]->EmployeeColorCode."), color-stop(100%,". $allBookings[$start]->EmployeeColorCode."));
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-linear-gradient(top,  ". $allBookings[$start]->EmployeeColorCode." 0%,". $allBookings[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -o-linear-gradient(top, ". $allBookings[$start]->EmployeeColorCode." 0%,". $allBookings[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -ms-linear-gradient(top, ". $allBookings[$start]->EmployeeColorCode." 0%,". $allBookings[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), linear-gradient(to bottom, ". $allBookings[$start]->EmployeeColorCode." 0%,". $allBookings[$start]->EmployeeColorCode." 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='". $allBookings[$start]->EmployeeColorCode."', endColorstr='". $allBookings[$start]->EmployeeColorCode."',GradientType=0 );
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
			border-radius: 2px;
			box-sizing: border-box;
			-ms-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
			}"; 
		 }
 		for($start = 0; $start<count($uxUpcomingDayOff);$start++)
		{
			$dynamicCalendar .=".fc-event".$uxUpcomingDayOff[$start]->BlockDateId."DayOff" ."{border: 1px solid ". $uxUpcomingDayOff[$start]->EmployeeColorCode."; color: white; display: block; font-size: 11px;
			background: ". $uxUpcomingDayOff[$start]->EmployeeColorCode." url(../images/elements/ui/progress_overlay.png);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -moz-linear-gradient(top, ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 0%, ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%,". $uxUpcomingDayOff[$start]->EmployeeColorCode."), color-stop(100%,". $uxUpcomingDayOff[$start]->EmployeeColorCode."));
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-linear-gradient(top,  ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 0%,". $uxUpcomingDayOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -o-linear-gradient(top, ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 0%,". $uxUpcomingDayOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -ms-linear-gradient(top, ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 0%,". $uxUpcomingDayOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), linear-gradient(to bottom, ". $uxUpcomingDayOff[$start]->EmployeeColorCode." 0%,". $uxUpcomingDayOff[$start]->EmployeeColorCode." 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='". $uxUpcomingDayOff[$start]->EmployeeColorCode."', endColorstr='". $uxUpcomingDayOff[$start]->EmployeeColorCode."',GradientType=0 );
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
			border-radius: 2px;
			box-sizing: border-box;
			-ms-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
			}"; 
		 }
		for($start = 0; $start<count($uxUpcommingTimeOff);$start++)
		{
			$dynamicCalendar .=".fc-event".$uxUpcommingTimeOff[$start]->BlockTimeId."TimeOff" ."{border: 1px solid ". $uxUpcommingTimeOff[$start]->EmployeeColorCode."; color: white; display: block; font-size: 11px;
			background: ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." url(../images/elements/ui/progress_overlay.png);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -moz-linear-gradient(top, ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 0%, ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode."), color-stop(100%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode."));
			background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-linear-gradient(top,  ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 0%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -o-linear-gradient(top, ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 0%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), -ms-linear-gradient(top, ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 0%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 100%);
			background: url(".$url."/images/elements/ui/progress_overlay.png), linear-gradient(to bottom, ". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 0%,". $uxUpcommingTimeOff[$start]->EmployeeColorCode." 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='". $uxUpcommingTimeOff[$start]->EmployeeColorCode."', endColorstr='". $uxUpcommingTimeOff[$start]->EmployeeColorCode."',GradientType=0 );
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
			border-radius: 2px;
			box-sizing: border-box;
			-ms-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
			-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
			}"; 
		 }		 
		 echo $dynamicCalendar . "</style>";
		 die();
	}
	else if($_REQUEST['target'] == "timeSlotBinding")
	{
			function find_closest ( $needle, $haystack ) 
			{ 
			    //sort the haystack 
			    sort($haystack); 
			     
			    //get the size to be used later 
			    $haystack_size = count($haystack); 
			     
			    //pre-check, is the needle less than the lowest array value 
			    if ( $needle < $haystack[0] ) 
			    { 
			        return $haystack[0]; 
			    } 
			     
			    //loop through the haystack 
			    foreach ( $haystack AS $key => $val ) 
			    { 
			        //if we have a match with the current value, return it 
			        if ( $needle == $val ) 
			        { 
			            return $val; 
			        } 
			         
			        //if we've hit the end of the array, return the max value 
			        if ( $key == $haystack_size - 1 ) 
			        { 
			            return $val; 
			        } 
			         
			        //now do the "between" check 
			        if ( $needle > $val && $needle < $haystack[$key+1] ) 
			        { 
			            //find the closest.  If they're equidistant, the higher value gets precedence 
			            if ( $needle - $val < $haystack[$key+1] - $needle ) 
			            { 
			                return $val; 
			            } 
			            else  
			            { 
			                return $haystack[$key]; 
			            } 
			        } 
			    } 
			}
		$employeeId = intval($_REQUEST['employeeId']);
		$dateTimeOff = $_REQUEST['dateTimeOff'];
		$dayName = substr(date('l', strtotime($dateTimeOff)),0,3);
		$serviceId = intval($_REQUEST['serviceId']);
		$currentTimeSlot = intval($_REQUEST['currentTimeSlot']);
		$getStartTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT StartTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$getEndTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT EndTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$hourTotalFormat = $wpdb->get_var("select GeneralSettingsValue  from ". generalSettingsTable()." where GeneralSettingsKey ='default_Slot_Total_Time_Format' ");
		$getServiceTime = $wpdb->get_var
		(
				$wpdb->prepare
				(
					"SELECT ServiceTotalTime FROM ".servicesTable()." where ServiceId = %d ",
					$serviceId
				)
		);
		$checkBookings = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". servicesTable() .".ServiceId," . servicesTable() .".ServiceTotalTime,". bookingTable() . ".TimeSlot From " . bookingTable() . " join ". servicesTable() ." on ". bookingTable() . ".ServiceId = ". servicesTable() .".ServiceId where ". bookingTable() . ".Date = ". '"' . $dateTimeOff .'"'." and ". bookingTable() . ".EmployeeId = ". $employeeId . " and (" . bookingTable() .".BookingStatus !='Disapproved' and " .bookingTable().".BookingStatus != 'Cancelled')" .
				" UNION ALL SELECT " . blockTimeTable() .".BlockTimeId," .$hourTotalFormat. "," . blockTimeTable() . ".TimeSlot From " . blockTimeTable() ." where ". blockTimeTable() . ".Day = ". '"' . $dateTimeOff .'"'." and ". blockTimeTable() . ".EmployeeId = ". $employeeId.							
				" UNION ALL SELECT " . employees_TimingsTable() .".TimingId,".  $getServiceTime . "," . employees_TimingsTable() . ".EndTime From " . employees_TimingsTable() ." where ". employees_TimingsTable() . ".EmployeeId = ". $employeeId . " and " . employees_TimingsTable() . ".Day = '" . $dayName . "'"
			)
		);
		$checkMultipleBookingsCount = $wpdb->get_results
		(
			$wpdb->prepare
			(
					"SELECT TimeSlot, COUNT(*) as Total FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId where ". bookingTable() . ".Date = ". '"' . $dateTimeOff .'"'." and ". bookingTable() . ".EmployeeId = ". $employeeId . " and " . servicesTable() .".Type = 1 and ". servicesTable() ."ServiceId = ". $serviceId. " GROUP BY TimeSlot HAVING COUNT(*) > 0 ORDER BY TimeSlot"
			)
		);
		$checkMultipleBookings = $wpdb->get_var("select Type  from ". servicesTable()." where ServiceId = " . $serviceId);
		$maxBookings = $wpdb->get_var("select ServiceMaxBookings  from ". servicesTable()." where ServiceId = " . $serviceId);
		
		
		$ServiceSlots = ceil($getServiceTime / $hourTotalFormat);
		if($ServiceSlots == 1)
		{
			$ServiceSlots = 0;
		}	
		else
		{
			$ServiceSlots = $ServiceSlots -1 ;
		}
		$new_array = array();
		$new_array1 = array();
		$multipleBookingsArray = array();
		for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
		{
			array_push($new_array1,$timeOff); 
		}
		for($flag = 0; $flag < count($checkMultipleBookingsCount); $flag++)
		{
			if($checkMultipleBookingsCount[$flag]->Total < $maxBookings)
			{
				$value = find_closest($checkMultipleBookingsCount[$flag]->TimeSlot, $new_array1);
				array_push($multipleBookingsArray,$value);	
			}	
				
		}
		if($checkMultipleBookings == 1)
		{
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
		
				$BookingSlots  =  ceil($checkBookings[$flag]->ServiceTotalTime / $hourTotalFormat) - 1;			
				$loopStart = $checkBookings[$flag]->TimeSlot - ($ServiceSlots * $hourTotalFormat);
				$loopStart = find_closest($loopStart, $new_array1);			
				$loopEnd = $checkBookings[$flag]->TimeSlot + ($BookingSlots * $hourTotalFormat);
				$loopEnd = find_closest($loopEnd, $new_array1);		
				for($loop = $loopStart; $loop <=$loopEnd; $loop = $loop + $hourTotalFormat)				
				{
					if($currentTimeSlot != $checkBookings[$flag]->TimeSlot)
					{	
						if(!in_array($loop,$multipleBookingsArray))
						{
							if(!in_array($loop,$new_array))
							{
								array_push($new_array,$loop);
							}	
						}			
					}
				}				
			}			
		}
		else
		{
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
				$BookingSlots  =  ceil($checkBookings[$flag]->ServiceTotalTime / $hourTotalFormat) - 1;			
				$loopStart = $checkBookings[$flag]->TimeSlot - ($ServiceSlots * $hourTotalFormat);
				$loopStart = find_closest($loopStart, $new_array1);			
				$loopEnd = $checkBookings[$flag]->TimeSlot + ($BookingSlots * $hourTotalFormat);
				$loopEnd = find_closest($loopEnd, $new_array1);		
				for($loop = $loopStart; $loop <=$loopEnd; $loop = $loop + $hourTotalFormat)				
				{
					if($currentTimeSlot != $checkBookings[$flag]->TimeSlot)
					{							
						if(!in_array($loop,$new_array))
						{
							array_push($new_array,$loop);
						}
					}				
				}				
			}			
		}
		if(in_array($currentTimeSlot,$new_array))
		{
			if(($key = array_search($currentTimeSlot, $new_array)) !== false) 
			{
    			unset($new_array[$key]);
			}
		}
		sort($new_array);			
		$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
		for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
		{
				if(!in_array($timeOff,$new_array))
				{
					$getHours = floor($timeOff / 60) ;
					$getMins = $timeOff % 60 ;
					$hourFormat = $getHours . ":" . $getMins;
					if($timeFormats == 0)
					{
						$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
					}
					else 
					{
						$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
					}
				?>
				<option value="<?php echo $timeOff; ?>"><?php echo $time_in_12_hour_format; ?></option>
				<?php
				}
		}
			die();
	}
	else if($_REQUEST['target'] == "timeOffBinding")
	{
	?>
	<option value ="opt1"><?php _e( "Please Choose Time", bookings_plus ); ?></option>	
	<?php
		function find_closest ( $needle, $haystack ) 
		{ 
			    //sort the haystack 
			    sort($haystack); 
			     
			    //get the size to be used later 
			    $haystack_size = count($haystack); 
			     
			    //pre-check, is the needle less than the lowest array value 
			    if ( $needle < $haystack[0] ) 
			    { 
			        return $haystack[0]; 
			    } 
			     
			    //loop through the haystack 
			    foreach ( $haystack AS $key => $val ) 
			    { 
			        //if we have a match with the current value, return it 
			        if ( $needle == $val ) 
			        { 
			            return $val; 
			        } 
			         
			        //if we've hit the end of the array, return the max value 
			        if ( $key == $haystack_size - 1 ) 
			        { 
			            return $val; 
			        } 
			         
			        //now do the "between" check 
			        if ( $needle > $val && $needle < $haystack[$key+1] ) 
			        { 
			            //find the closest.  If they're equidistant, the higher value gets precedence 
			            if ( $needle - $val < $haystack[$key+1] - $needle ) 
			            { 
			                return $val; 
			            } 
			            else  
			            { 
			                return $haystack[$key]; 
			            } 
			        } 
			    } 
		}
		$employeeId = intval($_REQUEST['employeeId']);
		$dateTimeOff = $_REQUEST['dateTimeOff'];
		$dayName = substr(date('l', strtotime($dateTimeOff)),0,3);
		$getStartTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT StartTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$getEndTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT EndTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$hourTotalFormat = $wpdb->get_var("select GeneralSettingsValue  from ". generalSettingsTable()." where GeneralSettingsKey ='default_Slot_Total_Time_Format' ");
		$checkBookings = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". servicesTable() .".ServiceId," . servicesTable() .".ServiceTotalTime,". bookingTable() . ".TimeSlot From " . bookingTable() . " join ". servicesTable() ." on ". bookingTable() . ".ServiceId = ". servicesTable() .".ServiceId where ". bookingTable() . ".Date = ". '"' . $dateTimeOff .'"'." and ". bookingTable() . ".EmployeeId = ". $employeeId . " and (" . bookingTable() .".BookingStatus !='Disapproved' and " .bookingTable().".BookingStatus != 'Cancelled')" .
				" UNION ALL SELECT " . blockTimeTable() .".BlockTimeId," .$hourTotalFormat. "," . blockTimeTable() . ".TimeSlot From " . blockTimeTable() ." where ". blockTimeTable() . ".Day = ". '"' . $dateTimeOff .'"'." and ". blockTimeTable() . ".EmployeeId = ". $employeeId.							
				" UNION ALL SELECT " . employees_TimingsTable() .".TimingId,".  $hourTotalFormat . "," . employees_TimingsTable() . ".EndTime From " . employees_TimingsTable() ." where ". employees_TimingsTable() . ".EmployeeId = ". $employeeId . " and " . employees_TimingsTable() . ".Day = '" . $dayName . "'"
			)
		);
		
		
	
			$ServiceSlots = 0;
		
			$new_array = array();
			$new_array1 = array();
			$blockTime = array();
			for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
			{
				array_push($new_array1,$timeOff); 
			}
		
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
				$BookingSlots  =  ceil($checkBookings[$flag]->ServiceTotalTime / $hourTotalFormat) - 1;
			
				$loopStart = $checkBookings[$flag]->TimeSlot - ($ServiceSlots * $hourTotalFormat);
				$loopStart = find_closest($loopStart, $new_array1);					
			
				$loopEnd = $checkBookings[$flag]->TimeSlot + ($BookingSlots * $hourTotalFormat);
				$loopEnd = find_closest($loopEnd, $new_array1);
				if($currentTimeSlot != $checkBookings[$flag]->TimeSlot)
				{		
					for($loop = $loopStart; $loop <=$loopEnd; $loop = $loop + $hourTotalFormat)				
					{
						if(!in_array($loop,$new_array))
						{
							array_push($new_array,$loop);
						}				
					}
				}
			}		
		sort($new_array);
		$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");			
		for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
		{
			if(!in_array($timeOff,$new_array))
			{
				$getHours = floor($timeOff / 60) ;
				$getMins = $timeOff % 60 ;
				$hourFormat = $getHours . ":" . $getMins;
				if($timeFormats == 0)
				{
					$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
				}
				else 
				{
					$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
				}
			?>
			<option value="<?php echo $timeOff; ?>"><?php echo $time_in_12_hour_format; ?></option>
			<?php
			}
		}
		die();
	
	}
	else if($_REQUEST['target'] == 'bindServicesForEmployee')
	{
			$employeeId = intval($_REQUEST['employeeId']);
			$services = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".servicesTable()." where ServiceId in (Select distinct(ServiceId) from ".services_AllocationTable() ." where ".services_AllocationTable() .".EmployeeId = ".$employeeId.") order by ServiceName ASC"
				)
			);
			?>
						<option value ="opt1"><?php _e( "Please Choose Service", bookings_plus ); ?></option>
	            <?php
	             	for( $flagServices = 0; $flagServices < count($services); $flagServices++)
					{
				?>
						<option value ="<?php echo $services[$flagServices] -> ServiceId;?>"><?php echo $services[$flagServices] -> ServiceName;?></option>
				<?php 
					} 
 		 die();
	}
	else if($_REQUEST['target'] == 'checkExistingCustomerEmailAction')
	{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerEmail = $wpdb->get_var('SELECT count(CustomerId) FROM ' . customersTable(). ' where CustomerEmail  = ' . "'".$uxEmailAddress."'");
			if($customerEmail != 0)
			{
				echo $returnEmployeeEmailCountCheck = "existingCustomerEmployeeEmail";
			}
			else 
			{
				echo $returnEmployeeEmailCountCheck = "newCustomerEmail";		
			}
			die();
	}
	else if($_REQUEST['target'] == 'savedBookingForm')
	{
		$fieldcompare = html_entity_decode($_REQUEST['fieldcompare']);
		$bookingRadioVisible = intval($_REQUEST['bookingRadioVisible']);
		$bookingRadiooRequired = intval($_REQUEST['bookingRadiooRequired']);
		$wpdb->query
		   (
		         $wpdb->prepare
		         (
		               "UPDATE ".bookingFormTable()." SET status = %d  WHERE BookingFormField = %s",
		               $bookingRadioVisible,
		               $fieldcompare
		         )
		   );
		if ($bookingRadioVisible == "0") 
		{
			$wpdb->query
		   (
		         $wpdb->prepare
		         (
		               "UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
		               0,
		               $fieldcompare
		         )
		   );
			
		} 
		else 
		{
			if ($bookingRadiooRequired == "1") 
			{
				$wpdb->query
		   		(
		        	 $wpdb->prepare
		        	 (
		          	     "UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
		          	     1,
		          	     $fieldcompare
		        	 )
		  		 );	
				
			} 
			else 
			{
				$wpdb->query
		   		(
		        	 $wpdb->prepare
		        	 (
		          	     "UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormField = %s",
		          	     0,
		          	     $fieldcompare
		        	 )
		  		 );
				
			}
		}
		die();
	}
	else if($_REQUEST['target'] == 'emailCustomerContent')
	{
		$customerId  = intval($_REQUEST['customerId']);
		$customerNameReturn = $wpdb->get_row("SELECT CustomerFirstName,CustomerLastName,CustomerEmail FROM ".customersTable()." where CustomerId = ".$customerId);
		?>
		<input id="hiddencustomerName" name="hiddencustomerName" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . "". $customerNameReturn->CustomerLastName ; ?>" />
		<input id="hiddencustomerEmail" name="hiddencustomerEmail" type="hidden" value="<?php echo $customerNameReturn->CustomerEmail  ; ?>" />
		<?php
		die();
	}
	
	else if($_REQUEST['target'] == "GetEmployees")
	{
	?>
		<input type="hidden" id="seridd" value="<?php echo intval($_REQUEST['serviceId']);?>"/>
			<table class="table table-striped" id="employee-data-table" >
	 			<thead>
	    			<tr>
	     				<th style="width:20%"><?php _e( "Employee Name", bookings_plus ); ?></th>
	                    <th style="width:25%"><?php _e( "Employee Email", bookings_plus ); ?></th>
	                    <th style="width:15%"><?php _e( "Employee Phone", bookings_plus ); ?></th>
			 		</tr>
				</thead>
	  			<tbody>
			    <?php
			    	$serviceId = intval($_REQUEST['serviceId']);
				    $employees = $wpdb->get_results
				    (
						$wpdb->prepare
						(
							'select '. employeesTable().'.EmployeeId,'. employeesTable().'.EmployeeName,'. employeesTable().'.EmployeeEmail,'. employeesTable().'.EmployeePhone 
							from '. services_AllocationTable().' join '. employeesTable().' on '. services_AllocationTable().'.EmployeeId = 
							'. employeesTable().'.EmployeeId where '. services_AllocationTable().'.ServiceId =  '.$serviceId
						)
					);
					for($flag=0; $flag < count($employees); $flag++)
					{
					?>
						<tr>
							<td><input id="radioEmployees<?php echo $flag;?>" class="style" title="<?php echo $employees[$flag] -> EmployeeName;?>"  name="radioEmployees" type="radio" value="<?php echo $employees[$flag] -> EmployeeId;?>"/>
								<label for="radio3"><?php echo $employees[$flag] -> EmployeeName;?></label>
								
							<td><?php echo $employees[$flag] -> EmployeeEmail;?></td>
							<td><?php echo $employees[$flag] -> EmployeePhone;?></td>
						</tr>
					<?php	
					}		
					?>	 
				</tbody>
	       </table>
			<script>
								<?php
								if(count($employees) == 1)
								{
									?>
										jQuery('#radioEmployees0').attr('checked','checked');
									<?php								
								}
									?>
			jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });
	       	oTable = jQuery('#employee-data-table').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": 't<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "<span>Show entries:</span> _MENU_"
				}
			});
	       </script>
		   
	<?php
	die();
	}
	else if($_REQUEST['target'] == "timeSlotCalendar")
	{
		function find_closest ( $needle, $haystack ) 
		{ 
			    //sort the haystack 
			    sort($haystack); 
			     
			    //get the size to be used later 
			    $haystack_size = count($haystack); 
			     
			    //pre-check, is the needle less than the lowest array value 
			    if ( $needle < $haystack[0] ) 
			    { 
			        return $haystack[0]; 
			    } 
			     
			    //loop through the haystack 
			    foreach ( $haystack AS $key => $val ) 
			    { 
			        //if we have a match with the current value, return it 
			        if ( $needle == $val ) 
			        { 
			            return $val; 
			        } 
			         
			        //if we've hit the end of the array, return the max value 
			        if ( $key == $haystack_size - 1 ) 
			        { 
			            return $val; 
			        } 
			         
			        //now do the "between" check 
			        if ( $needle > $val && $needle < $haystack[$key+1] ) 
			        { 
			            //find the closest.  If they're equidistant, the higher value gets precedence 
			            if ( $needle - $val < $haystack[$key+1] - $needle ) 
			            { 
			                return $val; 
			            } 
			            else  
			            { 
			                return $haystack[$key + 1]; 
			            } 
			        } 
			    } 
		}
		$employeeId = intval($_REQUEST['employeeId']);
		$dateTimeOff = $_REQUEST['dateTimeOff'];
		$dayName = substr(date('l', strtotime($dateTimeOff)),0,3);
		$serviceId = intval($_REQUEST['serviceId']);
		$uxUpcomingDayOff = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". blockDateTable() . ".Day From " 
				. blockDateTable() . " where " . blockDateTable() . ".EmployeeId = " . $employeeId
			)
		);
		$getStartTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT StartTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$getEndTime = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT EndTime FROM ".employees_TimingsTable()." where Day = %s and EmployeeId = %d and Status  = 1",
				$dayName,
				$employeeId
			)
		);
		$hourTotalFormat = $wpdb->get_var("select GeneralSettingsValue  from ". generalSettingsTable()." where GeneralSettingsKey ='default_Slot_Total_Time_Format' ");
		$getServiceTime = $wpdb->get_var
		(
				$wpdb->prepare
				(
					"SELECT ServiceTotalTime FROM ".servicesTable()." where ServiceId = %d ",
					$serviceId
				)
		);
		$checkBookings = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". servicesTable() .".ServiceId," . servicesTable() .".ServiceTotalTime,". bookingTable() . ".TimeSlot From " . bookingTable() . " join ". servicesTable() ." on ". bookingTable() . ".ServiceId = ". servicesTable() .".ServiceId where ". bookingTable() . ".Date = ". '"' . $dateTimeOff .'"'." and ". bookingTable() . ".EmployeeId = ". $employeeId . " and (" . bookingTable() .".BookingStatus !='Disapproved' and " .bookingTable().".BookingStatus != 'Cancelled')" .  
				" UNION ALL SELECT " . blockTimeTable() .".BlockTimeId," .$hourTotalFormat. "," . blockTimeTable() . ".TimeSlot From " . blockTimeTable() ." where ". blockTimeTable() . ".Day = ". '"' . $dateTimeOff .'"'." and ". blockTimeTable() . ".EmployeeId = ". $employeeId.							
				" UNION ALL SELECT " . employees_TimingsTable() .".TimingId,".  $getServiceTime . "," . employees_TimingsTable() . ".EndTime From " . employees_TimingsTable() ." where ". employees_TimingsTable() . ".EmployeeId = ". $employeeId . " and " . employees_TimingsTable() . ".Day = '" . $dayName . "'"
			)
		);
		$checkMultipleBookingsCount = $wpdb->get_results
		(
			$wpdb->prepare
			(
					"SELECT TimeSlot, COUNT(*) as Total FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId where ". bookingTable() . ".Date = ". '"' . $dateTimeOff .'"'." and ". bookingTable() . ".EmployeeId = ". $employeeId . " and " . servicesTable() .".Type = 1 GROUP BY TimeSlot HAVING COUNT(*) > 0 ORDER BY TimeSlot"
			)
		);
		$checkMultipleBookings = $wpdb->get_var("select Type  from ". servicesTable()." where ServiceId = " . $serviceId);
		$maxBookings = $wpdb->get_var("select ServiceMaxBookings  from ". servicesTable()." where ServiceId = " . $serviceId);
		
		
		$ServiceSlots = ceil($getServiceTime / $hourTotalFormat);
		if($ServiceSlots == 1)
		{
			$ServiceSlots = 0;
		}	
		else
		{
			$ServiceSlots = $ServiceSlots -1 ;
		}
		$new_array = array();
		$new_array1 = array();
		$multipleBookingsArray = array();
		$dayOffArray = array();
		for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
		{
			array_push($new_array1,$timeOff); 
		}
		for($flag = 0; $flag < count($uxUpcomingDayOff); $flag++)
		{
			array_push($dayOffArray,$uxUpcomingDayOff[$flag]->Day); 
		}
		for($flag = 0; $flag < count($checkMultipleBookingsCount); $flag++)
		{
			if($checkMultipleBookingsCount[$flag]->Total < $maxBookings)
			{
				$value = find_closest($checkMultipleBookingsCount[$flag]->TimeSlot, $new_array1);
				array_push($multipleBookingsArray,$value);	
			}	
				
		}
		if($checkMultipleBookings == 1)
		{
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
		
				$BookingSlots  =  ceil($checkBookings[$flag]->ServiceTotalTime / $hourTotalFormat) - 1;			
				$loopStart = $checkBookings[$flag]->TimeSlot - ($ServiceSlots * $hourTotalFormat);
				$loopStart = find_closest($loopStart, $new_array1);			
				$loopEnd = $checkBookings[$flag]->TimeSlot + ($BookingSlots * $hourTotalFormat);
				$loopEnd = find_closest($loopEnd, $new_array1);		
				for($loop = $loopStart; $loop <=$loopEnd; $loop = $loop + $hourTotalFormat)				
				{
					
					if(!in_array($loop,$multipleBookingsArray))
					{
						if(!in_array($loop,$new_array))
						{
							array_push($new_array,$loop);
						}	
					}			
				}				
			}			
		}
		else
		{
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
				$BookingSlots  =  ceil($checkBookings[$flag]->ServiceTotalTime / $hourTotalFormat) - 1;			
				$loopStart = $checkBookings[$flag]->TimeSlot - ($ServiceSlots * $hourTotalFormat);
				$loopStart = find_closest($loopStart, $new_array1);			
				$loopEnd = $checkBookings[$flag]->TimeSlot + ($BookingSlots * $hourTotalFormat);
				$loopEnd = find_closest($loopEnd, $new_array1);		
				for($loop = $loopStart; $loop <=$loopEnd; $loop = $loop + $hourTotalFormat)				
				{
		
					if(!in_array($loop,$new_array))
					{
						array_push($new_array,$loop);
					}				
				}				
			}			
		}

		
			sort($new_array);		
			$count = 0;
			$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
			if(($getStartTime != null || $getEndTime != null) && !in_array($dateTimeOff, $dayOffArray) ) 
			{		
				for($timeOff = $getStartTime; $timeOff <= $getEndTime; $timeOff += $hourTotalFormat)
				{	
					$countTotalBookings = $wpdb->get_var("select count(BookingId)  from ". bookingTable()." where ServiceId = " . $serviceId . " and EmployeeId = " . $employeeId . " and TimeSlot = " . $timeOff . " and Date = '". $dateTimeOff ."'");
					$total = $maxBookings - $countTotalBookings;									
					if(!in_array($timeOff,$new_array))
					{
						$getHours = floor($timeOff / 60) ;
						$getMins = $timeOff % 60 ;
						$hourFormat = $getHours . ":" . $getMins;
						if($timeFormats == 0)
						{
							$time_in_12_hour_format  = DATE("h:iA", STRTOTIME($hourFormat));
						}
						else 
						{
							$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
						}
						?>
						<a value="<?php echo $timeOff; ?>" href="#" class="timeCol hovertip"  data-original-title="<?php echo $total; ?> <?php _e(" Slots Left", bookings_plus ); ?>" data-placement="top"><?php echo $time_in_12_hour_format; ?></a>
						<?php
					}
					$count++;
				}
				if($count == 0)
				{
					?>
						<img src="<?php echo $url; ?>/images/sold-out.jpg" alt="<?php _e( "All Slots has been Booked.", bookings_plus ); ?>"/>
					<?php
				}
			}
			else {
				?>
					<div style="text-align:center;margin-top:50px;margin-bottom:50px;"><h4><?php _e( "Day Off of the Employee. Kindly choose another Date.", bookings_plus ); ?></h4></div>
				<?php				
			}			

			?>
			<input type="hidden" value="" id="hdTimeControl"/>
			<input type="hidden" value="" id="hdTimeControlValue"/>
			<script>jQuery('.hovertip').tooltip();</script>
			<?php
			die();
	}
	else if($_REQUEST['target'] == 'calendarBinding')
	{
		$employeeId = intval($_REQUEST['employeeId']);
		$blockDays = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"select Day from " . employees_TimingsTable() . " where EmployeeId  = %d and Status = 0",
				$employeeId
			)
		);
		$uxUpcomingDayOff = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". blockDateTable() . ".Day From " 
				. blockDateTable() . " where " . blockDateTable() . ".EmployeeId = " . $employeeId
			)
		);
		$days = "[";
		if(count($blockDays) > 0)
		{										
			for( $flagBlockDays = 0; $flagBlockDays < count($blockDays); $flagBlockDays++)
			{
				if(count($blockDays) > 1)
				{
					if($flagBlockDays <  (count($blockDays) - 1))
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .'],';
					}
					else
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .']';
					}
				}
				else 
				{
					$days .= '['. $blockDays[$flagBlockDays]->Day .']';
				}
			}
		}
		$days .= "]";
		$dates = "[";
		if(count($uxUpcomingDayOff) > 0)
		{
			for( $flagUxUpcomingDayOff = 0; $flagUxUpcomingDayOff < count($uxUpcomingDayOff); $flagUxUpcomingDayOff++)
			{
				if(count($uxUpcomingDayOff) > 1)
				{
					if($flagUxUpcomingDayOff < (count($uxUpcomingDayOff) - 1))
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].'],';
					}
					else
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
					}
				}
				else 
				{
					$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
					$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
				}							    
			}
		}
		$dates .= "]";
		$dynamic.=						    
		'<script>
		function nonWorkingDates(date)
		{
			var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
			var day = date.getDay();
			var currentDate = new Date();
			var closedDates = '.$dates.';
			var closedDays = '.$days.';
			for (var i = 0; i < closedDays.length; i++) 
			{
				if (day == closedDays[i][0]) 
				{
					return [false];
				}						
			}
			for (i = 0; i < closedDates.length; i++) 
			{
				if ((date.getMonth() == closedDates[i][0] - 1 && date.getDate() == closedDates[i][1] && date.getFullYear() == closedDates[i][2])) 
				{
					return [false];
				}
			}
			if((date.getMonth() < currentDate.getMonth() || date.getFullYear() < currentDate.getFullYear()) || (date.getDate() < currentDate.getDate() && date.getMonth() == currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()))
			{
				return [false];
			}
			return [true];
		}
		jQuery(".inlinepicker").datepicker
		({
			inline: true,
			showOtherMonths:true,
			functionCall:"getAlert1",
			beforeShowDay: nonWorkingDates						    	
		});
		</script>';
		echo $dynamic;
		die();
	}
	else if($_REQUEST['target'] == 'insertBooking')
	{
		$serviceId = intval($_REQUEST['serviceId']);
		$employeeId = intval($_REQUEST['employeeId']);
		$bookingTime = intval($_REQUEST['bookingTime']);
		$customerId = intval($_REQUEST['customerId']);
		$bookingDate = $_REQUEST['bookingDate'];
		$wpdb->query
		(
			   $wpdb->prepare
			   (
			        	"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,EmployeeId,TimeSlot,Date,BookingStatus,DateofBooking ) 
			        	VALUES(%d, %d, %d, %d,  '$bookingDate', %s,  CURDATE())",
			            $customerId,
			            $serviceId,
			            $employeeId,
			            $bookingTime,
			            "Pending Approval"
			        )
		);	
		echo $lastid = $wpdb->insert_id;
		include_once 'mailmanagement.php';
			MailManagement($lastid,"approval_pending");
			MailManagement($lastid,"admin");
	
		$customerDetails = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".customersTable()." WHERE CustomerId = %d",
					$customerId
				)
		);
		$countryName = $wpdb->get_var
		(
				$wpdb->prepare
				(
					"SELECT CountryName FROM ".countriesTable()." WHERE CountryId = %d",
					$customerDetails->CustomerCountry
				)
		);
		die();	
}
	else if($_REQUEST['target'] == 'getExistingCustomerData')
	{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerId = $wpdb->get_var('SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail  = ' . "'".$uxEmailAddress."'");
			if($customerId == 0)
			{
				echo $returnEmployeeEmailCountCheck = "newCustomer";
			}
			else 
			{
				$customer = $wpdb->get_row
				(
					$wpdb->prepare
					(
								"SELECT * FROM ".customersTable()." where CustomerId = %d",
								$customerId
					)
				);
				$requiredFields1 = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".bookingFormTable()." where status = 1 and required = 1"
					)
				);
				?>
				<script>
				<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					switch("uxTxtControl".$requiredFields1[$flagField]->BookingFormId)
					{
						case "uxTxtControl2":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerFirstName; ?>");
						<?php
						break;
						case "uxTxtControl3":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerLastName; ?>");
						<?php								
						break;
						case "uxTxtControl4":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerMobile; ?>");
						<?php								
						break;
						case "uxTxtControl5":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerTelephone; ?>");
						<?php								
						break;
						case "uxTxtControl6":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress1; ?>");
						<?php								
						break;
						case "uxTxtControl7":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress2; ?>");
						<?php								
						break;
						case "uxTxtControl8":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerCity; ?>");
						<?php								
						break;
						case "uxTxtControl9":
						?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerZipCode; ?>");
						<?php								
						break;															
					}

				}
					?>
						jQuery('#uxDdlControl10').val("<?php echo $customer->CustomerCountry; ?>");
						var countryid = "<?php echo $customer->CustomerCountry;?>";
						jQuery("#uniform-uxDdlControl10 span").html(jQuery("#uxDdlControl10 option[value="+countryid+"]").text());
						</script>
					<?php
			}
			die();
	}
	else if($_REQUEST['target'] == 'checkForUpdateCustomer')
	{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerId = $wpdb->get_var('SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail  = ' . "'".$uxEmailAddress."'");
			if($customerId != 0)
			{
				echo $customerId;
			}
			else 
			{
				echo $returnEmployeeEmailCountCheck = "newCustomerEmail";		
			}
			die();
	}
	else if($_REQUEST['target'] == 'resendBookingEmail')
	{
		$bookingId = intval($_REQUEST['bookingId']);
		$uxBookingStaus = esc_attr($_REQUEST['status']);
		include_once 'mailmanagement.php';
		if($uxBookingStaus == "Pending Approval")
		{
			MailManagement($bookingId,"approval_pending");	
			MailManagement($bookingId,"admin");			
		}
		else if($uxBookingStaus == "Approved")
		{
			MailManagement($bookingId,"approved");			
		}
		else if($uxBookingStaus == "Disapproved")
		{
			MailManagement($bookingId,"disapproved");		
		}
		die();
	}
	else if($_REQUEST['target'] == 'dirctEmailCustomer')
	{
		$EmailTemplateSubject = stripcslashes(html_entity_decode($_REQUEST['uxFrmCustomerEmailSubject']));
		$EmailTemplateContent = stripcslashes(html_entity_decode($_REQUEST['uxFrmCustomerEmailTemplate'])) ;
		$EmailId = esc_attr($_REQUEST['emailId']);
		$title=get_bloginfo('name');
		$admin_email = get_settings('admin_email');
		$headers=  "From: " .$title . " <". $admin_email . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
							
		wp_mail($EmailId,$EmailTemplateSubject,$EmailTemplateContent,$headers);
		die();
	}
	else if($_REQUEST['target'] == 'insertBookingCustomer')
	{
		$serviceId = intval($_REQUEST['serviceId']);
		$employeeId = intval($_REQUEST['employeeId']);
		$bookingTime = intval($_REQUEST['bookingTime']);
		$customerId = intval($_REQUEST['customerId']);
		$bookingDate = $_REQUEST['bookingDate'];
		$wpdb->query
		(
			   $wpdb->prepare
			   (
			        	"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,EmployeeId,TimeSlot,Date,BookingStatus,DateofBooking ) 
			        	VALUES(%d, %d, %d, %d,  '$bookingDate', %s,  CURDATE())",
			            $customerId,
			            $serviceId,
			            $employeeId,
			            $bookingTime,
			            "Approved"
			        )
		);	
		$lastid = $wpdb->insert_id;
		include_once 'mailmanagement.php';
		MailManagement($lastid,"approved");
		$customerDetails = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".customersTable()." WHERE CustomerId = %d",
					$customerId
				)
		);
		$countryName = $wpdb->get_var
		(
				$wpdb->prepare
				(
					"SELECT CountryName  FROM ".countriesTable()." WHERE CountryId = %d",
					$customerDetails->CustomerCountry
				)
		);
		
		die();
	}
	else if($_REQUEST['target'] == 'insertBookingbackend')
	{
		$serviceId = intval($_REQUEST['serviceId']);
		$employeeId = intval($_REQUEST['employeeId']);
		$bookingTime = intval($_REQUEST['bookingTime']);
		$customerId = intval($_REQUEST['customerId']);
		$bookingDate = $_REQUEST['bookingDate'];
		$wpdb->query
		(
			   $wpdb->prepare
			   (
			        	"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,EmployeeId,TimeSlot,Date,BookingStatus,DateofBooking ) 
			        	VALUES(%d, %d, %d, %d,  '$bookingDate', %s,  CURDATE())",
			            $customerId,
			            $serviceId,
			            $employeeId,
			            $bookingTime,
			            "Approved"
			        )
		);	
		$lastid = $wpdb->insert_id;
		
		include_once 'mailmanagement.php';
		MailManagement($lastid,"approved");
		$customerDetails = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".customersTable()." WHERE CustomerId = %d",
					$customerId
				)
		);
		$countryName = $wpdb->get_var
		(
				$wpdb->prepare
				(
					"SELECT CountryName FROM ".countriesTable()." WHERE CountryId = %d",
					$customerDetails->CustomerCountry
				)
		);
		$mailChimpEnable = $wpdb->get_var("SELECT AutoResponderValue FROM ".auto_Responders_settingsTable()." WHERE AutoResponderKey = 'mail-chimp-enabled'");
		if($mailChimpEnable == 0)
		{
			storeAddress($customerDetails->CustomerFirstName,$customerDetails->CustomerLastName,$customerDetails->CustomerEmail,$customerDetails->CustomerAddress1,$customerDetails->CustomerCity,$countryName,$customerDetails->CustomerZipCode);
		}
		die();
	}
	else if($_REQUEST['target'] == 'reportABug')
	{
		$uxReportEmailAddress = esc_attr($_REQUEST['uxReportEmailAddress']);
		$uxReportBug = stripcslashes(html_entity_decode($_REQUEST['uxReportBug']));
		$uxReportSubject = stripcslashes(html_entity_decode($_REQUEST['uxReportSubject']));
		$to = "support@bookings-plus.com";
		$title=get_bloginfo('name');
		
		$headers= "From: " .$title. " <". $uxReportEmailAddress . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
		$content = "
		<p>Email Address: ".$uxReportEmailAddress."
		</p><p>
		Bug: ".$uxReportBug."</p>";
		wp_mail($to,$uxReportSubject,$content,$headers);
		die();
	}
	else if($_REQUEST['target'] == 'becomeAff')
	{
		$uxReportEmailAddress = esc_attr($_REQUEST['uxReportEmailAddress']);
		$uxReportBug = stripcslashes(html_entity_decode($_REQUEST['uxReportBug']));
		$uxReportSubject = stripcslashes(html_entity_decode($_REQUEST['uxReportSubject']));
		$to = "aff@bookings-plus.com";
		$title=get_bloginfo('name');
		
		$headers= "From: " .$title. " <". $uxReportEmailAddress . ">" ."\n" .
				    	   "Content-Type: text/html; charset=\"" .
						    get_option('blog_charset') . "\n";
		$content = "
		<p>Email Address: ".$uxReportEmailAddress."
		</p><p>
		Bug: ".$uxReportBug."</p>";
		wp_mail($to,$uxReportSubject,$content,$headers);
		die();
	}
	else if($_REQUEST['target'] == 'availableDates')
	{
		$employeeId = intval($_REQUEST['employeeId']);
		$blockDays = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"select Day from " . employees_TimingsTable() . " where EmployeeId  = %d and Status = 0",
				$employeeId
			)
		);
		$uxUpcomingDayOff = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". blockDateTable() . ".Day From " 
				. blockDateTable() . " where " . blockDateTable() . ".EmployeeId = " . $employeeId
			)
		);
		$days = "[";
		if(count($blockDays) > 0)
		{										
			for( $flagBlockDays = 0; $flagBlockDays < count($blockDays); $flagBlockDays++)
			{
				if(count($blockDays) > 1)
				{
					if($flagBlockDays <  (count($blockDays) - 1))
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .'],';
					}
					else
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .']';
					}
				}
				else 
				{
					$days .= '['. $blockDays[$flagBlockDays]->Day .']';
				}
			}
		}
		$days .= "]";
		$dates = "[";
		if(count($uxUpcomingDayOff) > 0)
		{
			for( $flagUxUpcomingDayOff = 0; $flagUxUpcomingDayOff < count($uxUpcomingDayOff); $flagUxUpcomingDayOff++)
			{
				if(count($uxUpcomingDayOff) > 1)
				{
					if($flagUxUpcomingDayOff < (count($uxUpcomingDayOff) - 1))
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].'],';
					}
					else
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
					}
				}
				else 
				{
					$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
					$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
				}							    
			}
		}
		$dates .= "]";
		$dynamic.=						    
		'<script>
		function nonWorkingDates(date)
		{
			var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
			var day = date.getDay();
			var currentDate = new Date();
			var closedDates = '.$dates.';
			var closedDays = '.$days.';
			for (var i = 0; i < closedDays.length; i++) 
			{
				if (day == closedDays[i][0]) 
				{
					return [false];
				}						
			}
			for (i = 0; i < closedDates.length; i++) 
			{
				if ((date.getMonth() == closedDates[i][0] - 1 && date.getDate() == closedDates[i][1] && date.getFullYear() == closedDates[i][2])) 
				{
					return [false];
				}
			}
			if((date.getMonth() < currentDate.getMonth() || date.getFullYear() < currentDate.getFullYear()) || (date.getDate() < currentDate.getDate() && date.getMonth() == currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()))
			{
				return [false];
			}
			return [true];
		}
		var dates = jQuery( "#fromDate, #toDate" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: false,
			showOtherMonths:true,
			numberOfMonths: 3,
			dateFormat: "yy-mm-dd",
			onSelect: function( selectedDate ) 
			{
				var option = this.id == "fromDate" ? "minDate" : "maxDate",
				instance = jQuery( this ).data( "datepicker" ),
				date = jQuery.datepicker.parseDate(
				instance.settings.dateFormat ||
				jQuery.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			},
			functionCall: "getAlert",
			beforeShowDay: nonWorkingDates
	    			
		});
		</script>';
		echo $dynamic;
		die();
	}
	else if($_REQUEST['target'] == 'availableTimeOffDates')
	{
	
		$employeeId = intval($_REQUEST['employeeId']);
		$blockDays = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"select Day from " . employees_TimingsTable() . " where EmployeeId  = %d and Status = 0",
				$employeeId
			)
		);
		$uxUpcomingDayOff = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT ". blockDateTable() . ".Day From " 
				. blockDateTable() . " where " . blockDateTable() . ".EmployeeId = " . $employeeId
			)
		);
		$days = "[";
		if(count($blockDays) > 0)
		{										
			for( $flagBlockDays = 0; $flagBlockDays < count($blockDays); $flagBlockDays++)
			{
				if(count($blockDays) > 1)
				{
					if($flagBlockDays <  (count($blockDays) - 1))
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .'],';
					}
					else
					{
						$days .= '['. $blockDays[$flagBlockDays]->Day .']';
					}
				}
				else 
				{
					$days .= '['. $blockDays[$flagBlockDays]->Day .']';
				}
			}
		}
		$days .= "]";
		$dates = "[";
		if(count($uxUpcomingDayOff) > 0)
		{
			for( $flagUxUpcomingDayOff = 0; $flagUxUpcomingDayOff < count($uxUpcomingDayOff); $flagUxUpcomingDayOff++)
			{
				if(count($uxUpcomingDayOff) > 1)
				{
					if($flagUxUpcomingDayOff < (count($uxUpcomingDayOff) - 1))
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].'],';
					}
					else
					{
						$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
						$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
					}
				}
				else 
				{
					$bdate = (explode("-",$uxUpcomingDayOff[$flagUxUpcomingDayOff]->Day));
					$dates .= '['.$bdate[1].','.$bdate[2].','.$bdate[0].']';
				}							    
			}
		}
		$dates .= "]";
		$dynamic.=						    
		'<script>
		function nonWorkingDates(date)
		{
			var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
			var day = date.getDay();
			var currentDate = new Date();
			var closedDates = '.$dates.';
			var closedDays = '.$days.';
			for (var i = 0; i < closedDays.length; i++) 
			{
				if (day == closedDays[i][0]) 
				{
					return [false];
				}						
			}
			for (i = 0; i < closedDates.length; i++) 
			{
				if ((date.getMonth() == closedDates[i][0] - 1 && date.getDate() == closedDates[i][1] && date.getFullYear() == closedDates[i][2])) 
				{
					return [false];
				}
			}
			if((date.getMonth() < currentDate.getMonth() || date.getFullYear() < currentDate.getFullYear()) || (date.getDate() < currentDate.getDate() && date.getMonth() == currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()))
			{
				return [false];
			}
			return [true];
		}
		jQuery("#uxTimeDate").datepicker("destroy");
		var dates = jQuery( "#uxTimeDate" ).datepicker
		({
			
			
			showOtherMonths:true,
			functionCall2:"getAlert1",
			beforeShowDay: nonWorkingDates,				
			dateFormat: "yy-mm-dd"	    			
		});
		</script>';
		echo $dynamic;
		die();
	}
	else if($_REQUEST['target'] == 'insertAdminEmail')
	{
		$uxAdminEmail = esc_attr($_REQUEST['uxAdminEmail']);
		update_option('bp_AdminEmail',$uxAdminEmail);
		$uxChkAdminEmail = esc_attr($_REQUEST['uxChkAdminEmail']);
		
		
		$title=get_bloginfo('name');
		$siteUrl = site_url();
		$date = date('Y-m-d');
		require_once('MCAPI.class.php');
		$apikey = 'cb5674b9461afc20e099c1c13e1edb45-us6';
		$api = new MCAPI($apikey);
		
		if($uxChkAdminEmail == "true")
		{
			$mergeVars = array('DNAME'=>$title,
			'URL'=>$siteUrl,
			'DT'=>$date,
			'CHK'=>'true'
			);
			$list_id = "6dbd58d749";
		}
		else
		{
			$mergeVars = array('DNAME'=>$title,
			'URL'=>$siteUrl,
			'DT'=>$date,
			'CHK'=>'false'
			);
			$list_id = "78c3fb4a2b";
		}
		$api->listSubscribe($list_id, $uxAdminEmail, $mergeVars,false,false);
		die();
	}
}
?>