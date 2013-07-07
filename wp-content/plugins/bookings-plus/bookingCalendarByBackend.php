<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );


$requiredFields = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ".bookingFormTable()." where status = 1 and type='textbox'"
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

<div class="span12 well" style="padding:10px 10px" id="headerContent">
	<img src="<?php echo plugins_url('/images/logo.png', __FILE__); ?>"/>
</div>
<div class="span12 well" style="padding:10px 10px;background:none;border:none" id="menuNav">
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">
       		<ul class="nav left-nav">
	        	<li>
	                <a id="step1Menu" class="active"><?php _e( "Step 1 : Choose Service", bookings_plus ); ?></a>
	            </li>
	            <li>
	                <a id="step2Menu"><?php _e( "Step 2 : Choose Staff", bookings_plus ); ?></a>
	            </li>
	            <li>
	            	<a id="step3Menu"><?php _e( "Step 3 : Date & Time", bookings_plus ); ?></a>
	            </li>
	            <li>
	            	<a id="step4Menu"><?php _e( "Step 4 : Your Information", bookings_plus ); ?></a>
	            </li>
	            <li>
	            	<a id="step5Menu" style="border-left:none"><?php _e( "Step 5 : Confirm Details", bookings_plus ); ?></a>
	            </li> 
           </ul>
        </div>
    </div>
</div>     
<div class="span12 well" style="padding:10px 0px 0px 0px;margin:0px 0px 10px 0px;" id="bodyContent">
	<div class="body">	
    	<div class="well-smoke block" style="margin-top:0px" >
    		<div class="navbar">
    			<div class="navbar-inner" id="navBookNow">
    				 <h5>
    				 	<i class="font-hand-right"></i>
    				 	<?php _e( "Book an Appointment Now", bookings_plus ); ?>
								
    				 </h5>
            	</div>
            	<div class="navbar-inner" id="navThankyou" style="display:none">
    				 <h5>
    				 	<i class="font-hand-right"></i>
    				 	<?php _e( "Thank you for Booking.", bookings_plus ); ?>
								
    				 </h5>
            	</div>
				<div class="table-overflow" id="serviceGrid" style="display:block;">
	         	 		<table class="table table-striped" id="services-table-grid">
							<thead>
		     					<tr>
		        					<th style="width:20%"><?php _e( "Choose Service", bookings_plus ); ?></th>
		         					<th style="width:17%"><?php _e( "Service Duration", bookings_plus ); ?></th>
		         					<th style="width:10%"><?php _e( "Cost", bookings_plus ); ?></th>
		
									<th style="display: none;"><?php _e( "Service Display Order", bookings_plus ); ?></th>
								</tr>
							</thead>
		  		 			<tbody>
					      		<?php
					      		$currencyIcon = $wpdb->get_var("Select CurrencySymbol from ".currenciesTable()." where CurrencyUsed = 1");
						       	$service = $wpdb->get_results
						       	(
									$wpdb->prepare
									(
										 'SELECT '.servicesTable().'.ServiceId, '.servicesTable().'.ServiceName, 
										 '.servicesTable().'.ServiceCost,
										 '.servicesTable().'.ServiceMaxBookings, '.servicesTable().'.ServiceShortCode,
										 '.servicesTable().'.ServiceTotalTime, '.servicesTable().'.ServiceDisplayOrder
										 FROM '.servicesTable().' ORDER BY '.servicesTable().'.ServiceDisplayOrder ASC '
									)
								);
								for($flag=0; $flag < count($service); $flag++)
								{
									
									$hrs = floor(($service[$flag] -> ServiceTotalTime) / 60);
									$mins = ($service[$flag] -> ServiceTotalTime) % 60;
									?>
									<tr>
										<td>									
											<input id="radioService<?php echo $flag;?>"  class="style"  name="radioservice" type="radio" title="<?php echo $service[$flag] -> ServiceName;?>" value="<?php echo $service[$flag] -> ServiceId;?>"/><?php echo $service[$flag] -> ServiceName;?>
																			
										<td>
											<?php
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
										<td><?php echo $currencyIcon. $service[$flag] -> ServiceCost;?></td>
										<td style="display: none;"><?php echo $service[$flag] -> ServiceDisplayOrder;?></td>
									</tr>
									
									<?php	
								}		
							?>	 
							</tbody>
							<script>
								<?php
								if(count($service) == 1)
								{
									?>
										jQuery('#radioService0').attr('checked','checked');
									<?php								
								}
									?>
								
							</script>
	            		</table>
	         	 	</div>
	         	 	<div class="table-overflow" id="staffGrid" style="display:none;">
	         	 	</div>         	 	 	         	 	           		
	         	 	<div id="calendarGrid" style="display:none;padding:10px;">
	         			<div class="row-fluid nested">
	         				<div class="span3 well" style="border:none;background:none">
			         	 		<div class="inlinepicker" style="width:200px;"></div>
			         	 		<div id="scriptCalendar"></div>
			         	 		<input type="hidden" id="hdEmployeeId" value=""/>
			         	 		<input type="hidden" id="hdServiceId" value=""/>
			         	 	</div>
	         	 			<div class="span8 well" style="margin-left:34px;width:545px;">
								<?php
									$default_Time_Zone_Name = $wpdb -> get_var('SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Time_Zone_Name"');																
							    ?>	
	         	 				<div style="background-color:#f2f2f2;padding:5px;border-bottom: 1px solid #ddd;">
	         	 					<?php _e( "Calendar Time Zone:", bookings_plus ); ?> <strong><?php echo html_entity_decode($default_Time_Zone_Name) ?></strong>
	         	 				</div>
	         	 					<div style="width:545px;padding:5px;" id="timingsGrid">				         	 		
									</div>
								
								<input type="hidden" id="hdDate" value=""/>
							</div>
	         	 		</div>
	         	 	</div>
	         	 	<div id="formGrid" style="display:none;">
						<div class="span8 well" style="border:none;background:none">
							<form id="uxBookingFrm" class="form-horizontal" method="post" action="#">	
		    			 		<div class="row-fluid form-horizontal">
		    			 			<div id="scriptExistingCustomer"></div>
		    			 			<?php
		    			 				$bookingFeild = $wpdb->get_results
										(
											$wpdb->prepare
											(
												"SELECT * FROM ".bookingFormTable()." where status = 1"
											)
										);
										for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
										{
											if($bookingFeild[$flagField]->type == "textbox")
											{
												
											?>
					         					<div class="control-group" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
						            	   			<label class="control-label"><?php echo $bookingFeild[$flagField]->BookingFormField;?>
						            	   	<?php
							            	   	if($bookingFeild[$flagField]->required == 1)
												{
						            	   	?>
						               				<span class="req">*</span>
						               		<?php
												}
						               		?>
						               				</label>
						                 			<div class="controls searchDrop">
						                 				<input type="text" class="required span12" name="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""/>	
										 			</div>
						              			</div>
						              		<?php
						              			if($bookingFeild[$flagField]->validation == "maskPhone")
												{
											?>
						              				<script>jQuery("#uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>").addClass('maskPhone')</script>										
											<?php
												}
											}
											else if($bookingFeild[$flagField]->type == "dropdown")
											{
												?>
												<div class="control-group" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
						            	   			<label class="control-label"><?php echo $bookingFeild[$flagField]->BookingFormField;?>
												<?php
							            	   	if($bookingFeild[$flagField]->required == 1)
												{
						            	   		?>
						               				<span class="req">*</span>
						               			<?php
												}
												?>					               					
						               				</label>
						                 			<div class="controls searchDrop">
						                 				<select name="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" class="style required">					                 					
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
						              			<?php	
											}
											if($bookingFeild[$flagField]->validation == "email")
											{
												?>
												 	<script>jQuery("#uxTxtControl1").attr("onBlur","checkExistingCustomerBooking();");</script> 
												<?php
											}	
										}
		    			 			?>
		    			 				 <script>jQuery(".maskPhone").mask("(999) 999-9999");</script>  			 		
		         	 			</div>
		         	 			
		         	 		</form>
	         	 		</div>
	         	 	</div>        	 	
	         	 	<div id="confirmGrid" style="display:none;">
	         	 		<div class="span8 well" style="border:none;background:none">
							
		    			 		<div class="row-fluid form-horizontal">
		    			 			<div class="control-group">
						           		<label class="control-label"> <?php _e( " Appointment :", bookings_plus ) ?>
			               				</label>
			               				<div class="controls">
						                 	<label id="uxLblControlApp" value=""></label>
										</div>
									</div>
		    			 			<?php
		    			 				$bookingFeild = $wpdb->get_results
										(
											$wpdb->prepare
											(
												"SELECT * FROM ".bookingFormTable()." where status = 1"
											)
										);
										for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
										{
											?>
					         					<div class="control-group" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
						            	   			<label class="control-label"><?php echo $bookingFeild[$flagField]->BookingFormField;?>
	
						               				</label>
						                 			<div class="controls">
						                 				<label id="uxLblControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""></label>
										 			</div>
						              			</div>
						              		<?php										
										}
		    			 			?>
  			 		
		         	 			</div>		         	 		
	         	 		</div>
	         	 	</div>
	   		        <div id="thankyouGrid" style="display:none;">
	   		        	<div style="padding:10px;">
	   		        <?php 
						$bookingHeader = $wpdb -> get_var('SELECT GeneralSettingsValue  FROM ' .generalSettingsTable().' where GeneralSettingsKey = "booking-ThankYou-message"');
						echo stripslashes($bookingHeader);
					?>	
	         	 	</div>	         	 	</div>
            	</div>
			</div>
		<div class="form-actions" style="padding:10px 0px 0px 0px;">
	    	<input type="button" id="btnBackStep" value="<?php _e( "Back Step", bookings_plus ); ?>" class="btn btn-inverse pull-left" style="display:none">
	    	<input type="button" id="btnNextStep" value="<?php _e( "Next Step", bookings_plus ); ?>" class="btn btn-inverse pull-right">
       	</div>			
	</div>
</div>
<div class="span12 well" style="padding:10px 0px;background:none;border:none">
	<div class="body" style="padding:5px 10px;text-align:center"  id="footerContent">
			Booking Calendar Powered By : <a href="#">Bookings-Plus.com</a>
	</div>
</div>
<script>
	var uri = "<?php echo $url; ?>";
 
	function nextSelectEmployee()
	{
		var serviceId = jQuery('input:radio[name=radioservice]:checked').val();
		if(serviceId != undefined)
		{
			jQuery.ajax
			({
					type: "POST",
					data: "serviceId="+serviceId+"&target=GetEmployees&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data)
					{					
						jQuery('#staffGrid').html(data);
						jQuery.fancybox.update();
					}
			});
			return true;
		}
		else
		{
			bootbox.alert("<?php _e( "Please choose atleast one Service.", bookings_plus ); ?>");
			return false;
		}
		
	}

	function funcBindTime(dateTimeOff)
	{
		var uxDdlBookingServices =  jQuery('input:radio[name=radioservice]:checked').val();
		var employeeId = jQuery('input:radio[name=radioEmployees]:checked').val();
		jQuery('#hdTimeControl').val("");
		jQuery('#hdTimeControlValue').val("");
		jQuery.ajax
		({
			type: "POST",
			data: "serviceId="+uxDdlBookingServices+"&employeeId="+employeeId+"&dateTimeOff="+dateTimeOff+"&target=timeSlotCalendar&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				//alert(data);
				jQuery('#timingsGrid').html(data);
				jQuery('.ui-datepicker-today').attr('class','');
				//jQuery('.ui-state-active').attr('class','');
				jQuery('#hdDate').val(dateTimeOff);
				jQuery.fancybox.update();	
			}
		});
				
	}
	function CalendarBind()
	{
		
		var employeeId = jQuery('input:radio[name=radioEmployees]:checked').val();
		var serviceId = jQuery('input:radio[name=radioservice]:checked').val();
		if(employeeId != undefined)
		{
			jQuery.ajax
					({
							type: "POST",
							data: "employeeId="+employeeId+"&target=calendarBinding&action=getAjaxExecuted",
							url:  ajaxurl,
							success: function(data) 
							{
							
								if(employeeId != jQuery('#hdEmployeeId').val())
								{
									jQuery('.inlinepicker').datepicker('destroy');
									jQuery('#scriptCalendar').html(data);
									jQuery('#hdEmployeeId').val(employeeId);
								}
								if(serviceId != jQuery('#hdServiceId').val())
								{
									jQuery('#hdServiceId').val(serviceId);
								}
							}
					});
		}
	
	}
	jQuery("#uxBookingFrm").validate
	({
		rules: 
		{
			<?php
				
				$dynamic = "";
				for($flagField = 0; $flagField < count($requiredFields); $flagField++)
				{

					if($requiredFields[$flagField]->type == "textbox")
					{
						if($requiredFields[$flagField]->required == 1)
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :true';
							if($requiredFields[$flagField]->validation == "email")
							{
								$dynamic .= ", email : true }";
							}
							else
							{
								$dynamic .= "}";
							}
						}
						else 
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :false}';
						}
					}
					if(count($requiredFields) > 1 && $flagField < count($requiredFields) - 1)
					{
						$dynamic .= ",";	
					}	
				}
				echo $dynamic;
			 ?>																					
					
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
			
				<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					if($requiredFields[$flagField]->type == "textbox")
					{					
					?>					
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());
					<?php
	
					}
					else
					{
					?>
						
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxDdlControl<?php echo $requiredFields1[$flagField]->BookingFormId;?> option:selected').html());
					<?php
					}
			
				}
				?>
					label
		    		.text('Success!').addClass('valid')
		    		.closest('.control-group').addClass('success');
		    		 jQuery.fancybox.update();
		    		 var serviceName = jQuery('input:radio[name=radioservice]:checked').attr('title');
		    		 var employeeName = jQuery('input:radio[name=radioEmployees]:checked').attr('title')
		    		 var dateTime = jQuery('#hdDate').val().replace(/'/g,"").split('-');
		    	<?php
					$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');											
					if($dateFormat == 0)
					{
				?>
						var formattedDate = jQuery.datepicker.formatDate('MM dd, yy',new Date(dateTime[0],dateTime[1] - 1,dateTime[2]));
				<?php
					}
					else if($dateFormat == 1)
					{
				?>
						var formattedDate = jQuery.datepicker.formatDate('yy/mm/dd',new Date(dateTime[0],dateTime[1] - 1,dateTime[2]));
				<?php
					}	
			    	else if($dateFormat == 2)
					{
				?>		var formattedDate = jQuery.datepicker.formatDate('mm/dd/yy',new Date(dateTime[0],dateTime[1] - 1,dateTime[2]));
				<?php
					}
					else if($dateFormat == 3)
					{
				?>		var formattedDate = jQuery.datepicker.formatDate('dd/mm/yy',new Date(dateTime[0],dateTime[1] - 1,dateTime[2]));
				<?php
					}
				?>
		    		 
		    		 var time = jQuery('#hdTimeControl').val();
		    		 
		    		 jQuery('#uxLblControlApp').html("For <b>" + serviceName + "</b> with <b>"+ employeeName +"</b> on <b>" + formattedDate + "</b> at <b>" + time + "</b>");

	  	},
		submitHandler: function(form)
		{
		
		}
	});
	function insertCustomer()
	{
		var uxFirstName = jQuery('#uxTxtControl2').val();
	    var uxLastName = jQuery('#uxTxtControl3').val() == undefined ? "" : jQuery('#uxTxtControl3').val();
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		var uxTelephoneNumber = jQuery('#uxTxtControl5').val() == undefined ? "" : jQuery('#uxTxtControl5').val();
		var uxMobileNumber = jQuery('#uxTxtControl4').val() == undefined ? "" : jQuery('#uxTxtControl4').val();
		var uxAddress1 = jQuery('#uxTxtControl6').val() == undefined ? "" : jQuery('#uxTxtControl6').val();
		var uxAddress2 = jQuery('#uxTxtControl7').val() == undefined ? "" : jQuery('#uxTxtControl7').val();
		var uxCity = jQuery('#uxTxtControl8').val() == undefined ? "" : jQuery('#uxTxtControl8').val();
		var uxPostalCode = jQuery('#uxTxtControl9').val() == undefined ? "" : jQuery('#uxTxtControl9').val();
		var uxCountry = jQuery('#uxDdlControl10').val() == undefined ? "" : jQuery('#uxDdlControl10').val();
		var uxComments = jQuery('#uxComments').val() == undefined ? "" : jQuery('#uxComments').val();
		
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmailAddress="+uxEmailAddress+"&target=checkForUpdateCustomer&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{  	
				
				if(jQuery.trim(data) == "newCustomerEmail")
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
										
										var customerId = jQuery.trim(data);
										insertBooking(customerId);
									}   
					});
				}
				else
				{
					var customerId = jQuery.trim(data);
					
					jQuery.ajax
			        ({
			        	type: "POST",
			        	data: "uxEditCustomerId="+customerId+"&uxEditFirstName="+uxFirstName+"&uxEditLastName="+uxLastName+
			         	"&uxEditEmailAddress="+uxEmailAddress+
			        	"&uxEditTelephoneNumber="+uxTelephoneNumber+"&uxEditMobileNumber="+uxMobileNumber+"&uxEditAddress1="
			       		+uxAddress1+"&uxEditAddress2="+uxAddress2+"&uxEditCity="+uxCity+"&uxEditPostalCode="+uxPostalCode
			       		+"&uxEditCountry="+uxCountry+"&target=updatecustomers&action=getAjaxExecuted&comment=no",
			        	url:  ajaxurl,
			        	success: function(data) 
			       		{  
			       			insertBooking(customerId);
			            }   
			        }); 
				}
			}
		}); 
	}
	function insertBooking(customerId)
	{
		var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		var employeeId = jQuery('input:radio[name=radioEmployees]:checked').val();
		var bookingTime =  jQuery('#hdTimeControlValue').val();
		var bookingDate = jQuery('#hdDate').val().replace(/'/g,"");
		jQuery.ajax
		({
				type: "POST",
				data: "serviceId="+serviceId+"&employeeId="+employeeId+"&customerId="+customerId+"&bookingTime="+bookingTime+
				"&bookingDate="+bookingDate+"&target=insertBookingbackend&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{	
					
					setTimeout(function() 
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 4000);	
				} 			       
		});
	}
	function checkExistingCustomerBooking()
	{
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		jQuery.ajax
		({
			type: "POST",
			data: "uxEmailAddress="+uxEmailAddress+"&target=getExistingCustomerData&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{
				
				if(jQuery.trim(data) != "newCustomer")
				{
					jQuery("#scriptExistingCustomer").html(data);
		        }
		        else
		        {		        	
		        	jQuery("#uxBookingFrm").each(function(){
 						 this.reset();
					});
		        	jQuery('#uxTxtControl1').val(uxEmailAddress);
		        }
			}
		});
	}
		
</script>
