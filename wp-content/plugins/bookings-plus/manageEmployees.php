<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
?>
<div class="content">
	<div class="body">
    	<div class="well-smoke block" style="margin-top:0px">
	   		<div class="navbar">
            	<div class="navbar-inner">
            		<h5><i class="font-hand-right"></i><?php _e( "Staff Members", bookings_plus ); ?></h5>
            		<div class="nav pull-right">
						<a href="#" class="dropdown-toggle just-icon" data-toggle="dropdown" style="color:#000 !important">
							<i class="font-cog"></i>
							<span style="color:#000 !important;margin-left:5px"><b class="caret"></b></span>
						</a>
                      	<ul class="dropdown-menu pull-right">
                      		<?php
                      		$countEmployee = $wpdb->get_var("SELECT count(EmployeeId) FROM ".employeesTable());
							$countEmployeeOption = get_option("count-employee");
							if($countEmployee < $countEmployeeOption)
							{
								?>
								<li>
                        			<a href="#addNewEmployee" class="fancybox"><i class="font-plus-sign"></i><?php _e( "Add New Staff Member", bookings_plus ); ?></a>
                        		</li>
								<?php
							}
                      		?>
                        	
                        	<li>
                        		<a  href="#allocateServices" class="fancybox"><i class="font-check"></i><?php _e( "Assign Services", bookings_plus ); ?></a>
                         	</li>
                         	<li>
                            	<a href="#workingHours" class="fancybox"><i class="font-time"></i><?php _e( "Working Hours", bookings_plus ); ?></a>
                         	</li>
                         	<li>
                           		<a href="#dayOffTimeOff" class="fancybox"><i class="font-plane"></i><?php _e( "Day Offs", bookings_plus ); ?></a>
                         	</li>
                         	<li>
                           		<a href="#TimeOff" class="fancybox"><i class="font-bell"></i><?php _e( "Time Offs", bookings_plus ); ?></a>
                         	</li>                         			
                      	</ul>
                	</div>
            	</div>
          	</div>
			<p style="padding:10px 10px 0px 10px">
				<span class="label label-important"><?php _e( "Note: Click on the Right Corner of the Settings icon to perform various actions viz. Add New Employees, Allocate Services etc.", bookings_plus ); ?></code>					
			</p>
			<p style="padding:0px 10px 0px 10px">
				<span class="label label-info">You will need to Add New Employees and then Allocate them to the respective Services in order to allow Bookings for your Customers.</span>
			</p>
			<div class="table-overflow">
				<table class="table table-striped" id="data-table">
 					<thead>
    			    	<tr>
     	 					<th style="width:10%"><?php _e( "Color Code", bookings_plus ); ?></th>
     	 					<th style="width:15%"><?php _e( "Staff Code", bookings_plus ); ?></th>
        					<th style="width:20%"><?php _e( "Staff Name", bookings_plus ); ?></th>
                           	<th style="width:25%"><?php _e( "Staff Email", bookings_plus ); ?></th>
                           	<th style="width:15%"><?php _e( "Staff Phone", bookings_plus ); ?></th>
		 					<th style="width:10%"></th>
						</tr>
					</thead>
  		 			<tbody>
		      		<?php
			    	$employees = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT * FROM " . employeesTable()
						)
					);
					for($flag=0; $flag < count($employees); $flag++)
					{
						$employeeColor = $employees[$flag]->EmployeeColorCode;
					?>
						<tr>
						<?php
						$empColorCode = "<label style=\"width:40px;height:15px;cursor:default;background-color:$employeeColor;color:$employeeColor\">";
						?>
							<td><?php echo $empColorCode; ?></td>
							<td><?php echo $employees[$flag] -> EmployeeUniqueCode;?></td>
							<td><?php echo $employees[$flag] -> EmployeeName;?></td>
							<td><?php echo $employees[$flag] -> EmployeeEmail;?></td>
							<td><?php echo $employees[$flag] -> EmployeePhone;?></td>
							<td>
								<a class="icon-edit fancybox hovertip" data-original-title="<?php _e("Edit Employee?", bookings_plus ); ?>" data-placement="top"  href="#EditExistingEmployee" onclick="editEmployee(<?php echo $employees[$flag]->EmployeeId;?>);"></a>&nbsp;&nbsp;
								<a class="icon-time fancybox hovertip" data-original-title="<?php _e("Show Day Off's & Time Off's", bookings_plus ); ?>" data-placement="top" href="#ExistingEmployeeOffs" onclick="employeeTimeOff(<?php echo $employees[$flag]->EmployeeId;?>);" ></a>&nbsp;&nbsp;												
								<a class="icon-remove hovertip" data-original-title="<?php _e("Delete Employee?", bookings_plus ); ?>" data-placement="top" onclick="deleteEmployee(<?php echo $employees[$flag]-> EmployeeId;?>)"></a>
							</td>
						</tr>
				  	<?php	
				  	}		
				 	?>	 
					</tbody>
            	</table>
          	</div>
      	</div>
    </div>
</div>
<div id="EditExistingEmployee" style="width:700px;display:none">
	<div class="modal-header">	
        <h5><?php _e( "Update Existing Staff Member", bookings_plus ); ?></h5>
    </div>	
	<form id="uxFrmEditEmployees" class="form-horizontal" method="post" action="#">
		<div class="body">
	    	<div class="note note-success" id="editEmployeeSuccessMessage" style="display:none">
		    	<strong><?php _e( "Success! The Staff Member has been updated Successfully.", bookings_plus ); ?></strong>
            </div>
          	<div class="block well" style="margin-top:10px;">

                <div class="row-fluid form-horizontal" id="bindEditControls"></div>  
                <input type="hidden" id="EmployeeId" name="EmployeeId" value="" /> 
            </div>
        </div>
        <div class="form-actions" style="padding:0px 10px 10px 10px">
           	<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnEditEmployee" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
        </div>        
    </form>
</div>
<div id="dayOffTimeOff" style="width:650px;display:none">
	<div class="modal-header">	
        <h5><?php _e( "Day Off Settings", bookings_plus ); ?></h5>
    </div>
	<form id="uxFrmDayOffTimeOff" class="form-horizontal" method="post" action="#">
    	<div class="body">
			<div class="note note-success" id="dayOffSuccessMessage" style="display:none">
				<strong><?php _e( "Success! The Day Off has been saved Successfully.", bookings_plus ); ?></strong>
	        </div>
            <div class="note note-danger" id="errorMessageDayOff" style="display:none">
				<strong><?php _e( "Error! Please choose Staff Member to take Day Off.", bookings_plus ); ?></strong>
            </div>			
        	<div class="well-smoke block"  style="margin-top:10px">
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
				            <select name="uxDdlDayOffEmployees" class="style required" id="uxDdlDayOffEmployees" onchange="AvailableDates();">
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
					<div class="control-group">
						<label class="control-label"><?php _e( "Start Date :", bookings_plus ); ?>
							<span class="req">*</span>
					    </label>
					    <div class="controls">
					    	<input type="text" class="required span12" name="fromDate" id="fromDate"/>
					    </div>
					</div>	        							   	        							
					<div class="control-group">
						<label class="control-label"><?php _e( "End Date :", bookings_plus ); ?>
							<span class="req">*</span>
					    </label>
					    <div class="controls">
					    	<input type="text" class="required span12" name="toDate" id="toDate"/>
					    </div>
					</div>
					<div id="scriptDynamic">
					
						
					</div>					
	        	</div>		        
			</div>	 	   				
		</div>	
		<div class="form-actions" style="padding:0px 10px 10px 15px">
			<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnDayOff" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
		</div>
	</form>	                              
</div>
<div id="TimeOff" style="width:650px;display:none">
    <div class="modal-header">	
		<h5><?php _e( "Time Off Settings", bookings_plus ); ?></h5>
    </div>
	<form id="uxTimeOff" class="form-horizontal" method="post" action="#">
    	<div class="body">
			<div class="note note-success" id="TimeOffSuccessMessage" style="display:none">
				<strong><?php _e( "Success! The Time Off has been done Successfully.", bookings_plus ); ?></strong>
	        </div>
           <div class="note note-danger" id="errorMessageTimeOff" style="display:none">
				<strong><?php _e( "Error! Please choose Staff Member to take Time Off.", bookings_plus ); ?></strong>
            </div>
            <div class="note note-danger" id="errorMessageStartTime" style="display:none">
				<strong><?php _e( "Error! Please choose Time Slot to take Time Off.", bookings_plus ); ?></strong>
            </div>				
           		
        	<div class="well-smoke block"  style="margin-top:10px">
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
				            <select name="uxDdltimeOff" class="style required" id="uxDdltimeOff" onchange="callFunction();">
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
				            <div id="dynamicTimeOffScript"></div>	
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><?php _e( "Date :", bookings_plus ); ?>
							<span class="req">*</span>
					    </label>
					    <div class="controls">
					    	<input type="text" class="required span12" name="uxTimeDate" id="uxTimeDate"/>
					    </div>
					</div>
					<div class="control-group">
				    	<label class="control-label"><?php _e( "Time Slot :", bookings_plus ); ?>
				    		<span class="req">*</span>
				        </label>
				        <div class="controls">
				            <select name="uxStartTime" class="style required" id="uxStartTime">
					        	<option value ="opt1"><?php _e( "Please Choose Time", bookings_plus ); ?></option>	
				           </select>	
						</div>
					</div>
				</div>		        
			</div>	 	   				
		</div>	
		<div class="form-actions" style="padding:0px 10px 10px 15px">
			<input data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnTimeOff" type="submit" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
		</div>
	</form>	                              
</div>
<div id="ExistingEmployeeOffs" style="width:850px;display:none">
	<div class="modal-header">
		<h5><?php _e( "Staff Member Day Off's & Time Off's", bookings_plus ); ?></h5>
	</div>
	<div class="note note-success" id="deleteDayTimeEmployeeSuccessMessage" style="display:none">
		<strong><?php _e( "Success! The Staff Member Day/Time Off deleted Successfully.", bookings_plus ); ?></strong>
    </div>
	<form id="uxFrmExistEmployeesShowTimeOff" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
	        <div class="body">	        	
                	<div class="row-fluid nested form-horizontal" id="bindExistEmployeesShowDayOffControls">
					</div>
			</div>                  
        </div>           
    </form>
</div>
<script type="text/javascript">
	jQuery('#btnDayOff').click(function ()
	{
		var employeeDdId = jQuery('#uxDdlDayOffEmployees').val();
		if(employeeDdId == "opt1")
		{
			jQuery('#errorMessageDayOff').css('display','block');
		}
		else
		{
			jQuery('#errorMessageDayOff').css('display','none');
		}
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	jQuery('#btnEditEmployee').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	jQuery('#btnTimeOff').click(function ()
	{
		var employeeDdId = jQuery('#uxDdltimeOff').val();
		var uxStartTime = jQuery("#uxStartTime").val();
		var uxEndTime = jQuery("#uxEndTime").val();
		if(employeeDdId == "opt1")
		{
			jQuery('#errorMessageTimeOff').css('display','block');
			jQuery('#errorMessageStartTime').css('display','none');
						
		}		
		else if(uxStartTime == "opt1")
		{
			jQuery('#errorMessageStartTime').css('display','block');
			jQuery('#errorMessageTimeOff').css('display','none');
						
		}
		else
		{
			jQuery('#errorMessageTimeOff').css('display','none');
			jQuery('#errorMessageStartTime').css('display','none');
		}
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});	
		var uri = "<?php echo $url; ?>";      
		oTable = jQuery('#data-table').dataTable
		({
			"bJQueryUI": false,
			"bAutoWidth": true,
			"sPaginationType": "full_numbers",
			"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
			"oLanguage": 
			{
				"sLengthMenu": "<span>Show entries:</span> _MENU_"
			},
			"aaSorting": [[ 2, "asc" ]],
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [0] },{ "bSortable": false, "aTargets": [5] }]
    	});

    	jQuery(".ui-datepicker-month, .style, .dataTables_length select").uniform({ radioClass: 'choice' });
	 	function deleteEmployee(employeeId) 
	 	{
	 		bootbox.confirm("<?php _e( "Are you sure you want to delete this Employee?", bookings_plus ); ?>", function(confirmed)
	 		{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
			    	({
			    		type: "POST",
			       	 	data: "employeeId="+employeeId+"&target=deleteEmployees&action=getAjaxExecuted",
			        	url:  ajaxurl,
			        	success: function(data) 
			        	{  
			        		var CheckExist = jQuery.trim(data);
			        		if(CheckExist == "bookingExist")
			        		{
			        			bootbox.alert("<?php _e("You cannot delete this Employee until all Bookings have been deleted.", bookings_plus ); ?>");
			        		}
			        		else if(CheckExist == "allocatedToService")
			        		{
			        			bootbox.alert("<?php _e("You cannot delete this Employee until all Allocated Services are de-allocated.", bookings_plus ); ?>");
			        		}
			        		else
			        		{
			        			var checkPage = "<?php echo $_REQUEST['page']; ?>";
						       	window.location.href = "admin.php?page="+checkPage;
			        		}
			        	}
			    	});
		    	}
			});
		}    	
		jQuery.validator.addMethod("notEqualTo", function(value, element, param) 
		{
 			return this.optional(element) || value != param;
 		},	 "This has to be different...");
 
		jQuery("#uxFrmEditEmployees").validate 
		({
			rules: 
			{
				uxEditEmployeeName:
				{
					required:true

				},
				uxEditEmployeeEmail: 
				{
					required: true,
					email:true
				},
				uxEditEmployeePhone: 
				{
					required: true,
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
		     	var uxEmployeeId = jQuery('#EmployeeId').val();	
		     	var uxEditEmployeeColorCode= jQuery('#uxEditEmployeeColorCode').val();
		     	var uxEditEmployeeName = jQuery('#uxEditEmployeeName').val();
			    var uxEditEmployeeEmail = jQuery('#uxEditEmployeeEmail').val();
			    var uxEditEmployeePhone = jQuery('#uxEditEmployeePhone').val();
			    jQuery.ajax
			    ({
					type: "POST",
				    data: "uxEmployeeId="+uxEmployeeId+"&uxEditEmployeeColorCode="+uxEditEmployeeColorCode+"&uxEditEmployeeName="+uxEditEmployeeName
				    +"&uxEditEmployeeEmail="+uxEditEmployeeEmail+"&uxEditEmployeePhone="+uxEditEmployeePhone+"&target=updateExistingEmployee&action=getAjaxExecuted",
				    url:  ajaxurl,
				    success: function(data) 
				    {  	
				    	jQuery('#editEmployeeSuccessMessage').css('display','block');
			            setTimeout(function() 
			            {
			            	jQuery('#editEmployeeSuccessMessage').css('display','none');
			                var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    window.location.href = "admin.php?page="+checkPage;
			            }, 2000);
			        }
		   		});
		   }
		});
		function editEmployee(EmployeeId)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+EmployeeId+"&target=editEmployees&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
			    {  	
			    	jQuery("#bindEditControls").html(data);
		        	jQuery.fancybox.update();
		       	    var Employee_Id = jQuery('#hiddenEmployeeId').val();
		            jQuery('#EmployeeId').val(Employee_Id);
		        }
		                
		   	});
		}
		function AvailableDates()
		{
			var employeeId = jQuery('#uxDdlDayOffEmployees').val();
		   	jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+employeeId+"&target=availableDates&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
			    {
					
					jQuery("#scriptDynamic").html(data);
		       	}
		                
		   	});		
		}
		jQuery("#uxFrmDayOffTimeOff").validate
		({
			rules: 
			{
				uxDdlDayOffEmployees:
				{
					required:true,
					notEqualTo:"opt1"
				},
				fromDate:
				{
					required:true
				},
				toDate:
				{
					required:true
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
	     		var dateFrom = jQuery('#fromDate').val();	
	     		var dateTo = jQuery('#toDate').val();	
	     		var employeeId = jQuery('#uxDdlDayOffEmployees').val();
	     		jQuery.ajax
				({
					type: "POST",
					data: "dateFrom="+dateFrom+"&dateTo="+dateTo+"&employeeId="+employeeId+"&target=dateOff&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data) 
					{
	
							jQuery('#dayOffSuccessMessage').css('display','block');
				            setTimeout(function() 
				            {
				            	jQuery('#dayOffSuccessMessage').css('display','none');
				               var checkPage = "<?php echo $_REQUEST['page']; ?>";
						   	   window.location.href = "admin.php?page="+checkPage;
				            }, 2000);
					}
				});
	     	}
		});	
	
		jQuery("#uxTimeOff").validate
		({
			rules: 
			{				
				uxDdltimeOff:
				{
					required:true,
					notEqualTo : "opt1"
				},
				uxTimeDate:
				{
					required:true
				},
				uxStartTime:
				{
					required:true,
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
	     		var employeeId = jQuery('#uxDdltimeOff').val();
	     		var timeOffDate = jQuery('#uxTimeDate').val();
	     		var timeOffStartTime = jQuery('#uxStartTime').val();
	     		jQuery.ajax
				({
						type: "POST",
						data: "&employeeId="+employeeId+"&timeOffDate="+timeOffDate+"&timeOffStartTime="+timeOffStartTime+"&target=addTimeOff&action=getAjaxExecuted",
						url:  ajaxurl,
						success: function(data) 
						{
							jQuery('#TimeOffSuccessMessage').css('display','block');
				            setTimeout(function() 
				            {
				            	jQuery('#TimeOffSuccessMessage').css('display','none');
				                var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    	window.location.href = "admin.php?page="+checkPage;
				            }, 2000);
						}
				});	
	     	}
		});
		function employeeTimeOff(employeeId)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+employeeId+"&target=bindDayOff&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{
					
					jQuery('#bindExistEmployeesShowDayOffControls').html(data);
					jQuery.fancybox.update();
				}
			});
		}
		function callFunction()
		{
			var employeeId = jQuery('#uxDdltimeOff').val();
		   	jQuery.ajax
			({
				type: "POST",
				data: "employeeId="+employeeId+"&target=availableTimeOffDates&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
			    {

					jQuery("#dynamicTimeOffScript").html(data);
		       	}
		                
		   	});		
		}
		
</script>
