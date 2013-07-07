<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;

?>
<div class="content">
	<div class="body">	
    	<div class="well-smoke block" style="margin-top:0px">
    		<div class="navbar">
    			<div class="navbar-inner">
    				 <h5>
    				 	<i class="font-hand-right"></i>
    				 	<?php _e( "Settings", bookings_plus ); ?>
    				 </h5>
            	</div>
			</div>
			<div class="body">
        		<div class="row-fluid nested">
	        		<div class="well-smoke block" style="margin-top:0px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "General Settings", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#generalSettings">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>
	            		<div class="collapse" id="generalSettings">
	            			<div class="body">
			            		<div class="note note-success" id="successDefaultSettingsMessage" style="display:none">
									<strong><?php _e( "Success! Default Settings has been saved Successfully.", bookings_plus ); ?></strong>
								</div>	            				
	                    		<form id="uxFrmGeneralSettings" class="form-horizontal" method="post" action="#">
	                    			<div class="row-fluid nested"  style="margin-top:10px">
	    								<div class="span12 well">
	    	    							<div class="navbar">
	    	    								<div class="navbar-inner">
				    	    						<h5>
				    	    							<?php _e( "Default Settings", bookings_plus ); ?>
				    	    						</h5>
	    	    								</div>
	    	    							</div>
			            					<div class="body" style="padding:0px">
						                        <div class="row-fluid form-horizontal">
							                    	<div class="control-group">
						                            	<label class="control-label"><?php _e( "Default Currency :", bookings_plus ); ?>
						                            		<span class="req">*</span>
						                            	</label>
						                            	<div class="controls">
						                                <?php
												        	$currency = $wpdb->get_col
												            (
														    	$wpdb->prepare
														        (
																   	"SELECT CurrencyName From ".currenciesTable()." order by CurrencyName ASC"
														        )
												            );	
												            $currency_code = $wpdb->get_col
												            (
														     	$wpdb->prepare
														    	(
																 	"SELECT CurrencySymbol From ".currenciesTable()." order by CurrencyName ASC"
														        )
												            );	
												            $currency_sel = $wpdb -> get_var("SELECT CurrencyName FROM ".currenciesTable(). " where CurrencyUsed = 1");
															?>
								                            <select name="uxDdlDefaultCurrency"  class="style required" id="uxDdlDefaultCurrency">
								                            <?php
														    	for ($flagCurrency = 0; $flagCurrency < count($currency); $flagCurrency++)
														        {
															    	if ($currency[$flagCurrency] == $currency_sel)
															    	{
																		$currencyCode = $currency_code[$flagCurrency];
															?>
																		<option value="<?php echo $currency[$flagCurrency];?>" selected='selected'><?php echo "(" . $currencyCode . ")  ";echo $currency[$flagCurrency];?></option>
															<?php 
																	}
															    	else
															        {
															?>
																		<option value="<?php echo $currency[$flagCurrency];?>"><?php echo "(" . $currency_code[$flagCurrency] . ")  ";echo $currency[$flagCurrency]; ?></option>
															<?php 
																	}
														    	}
														    ?>                           		 	
								                            </select>	
											            </div>
						                            </div>
							                        <div class="control-group">
						                            	<label class="control-label"><?php _e( "Default Country :", bookings_plus ); ?>
						                            		<span class="req">*</span>
						                            	</label>
						                            	<div class="controls">
								                        	<select name="uxDdlDefaultCountry" class="style required" id="uxDdlDefaultCountry">  
								                        	<?php
								                        			$country = $wpdb->get_col
											                		(
													                	$wpdb->prepare
													                	(
															            	"SELECT CountryName From ".countriesTable()."  order by CountryName ASC"
													                    )
											                        );	
											                        $sel_country = $wpdb -> get_var('SELECT CountryName  FROM ' . countriesTable() . ' where CountryUsed = 1');
												                    for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
												                    {
													                	if ($sel_country == $country[$flagCountry])
													                	{
														    ?>
														    				<option value="<?php echo $country[$flagCountry];?>" selected='selected'><?php echo $country[$flagCountry];?></option>
														    <?php 
													        			}
																		else
													                	{
														   	?>
														    				 <option value="<?php echo $country[$flagCountry];?>"><?php echo $country[$flagCountry];?></option>
														    <?php 
													        			}
												                   }
												            ?>                      		 	
								           	                </select>	
										                </div>
						          	                </div>
						          	                <div class="control-group">
						                            		<?php
							                            		$dateFormat = $wpdb -> get_var('SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Date_Format"');
															?>
						    	                           	<label class="control-label"><?php _e( "Default Date Format :", bookings_plus ); ?>
						    	                            	<span class="req">*</span>
						    	                            </label>
						                                    <div class="controls">
						                                    	<select name="uxDefaultDateFormat" class="style required" id="uxDefaultDateFormat">
																	<?php
																	$date = date('j'); 
																	$monthName = date('F');
																	$monthNumeric = date('m');
																	$year = date('Y');
																	 				                                    		
						                                    		if($dateFormat == 0)
								                            		{
								                            		?>	
						                                    			<option value="0" selected="selected"><?php echo  $monthName ." ".$date.",  ".$year; ?></option>
						                                    			<option value="1"><?php echo  $year ."/".$monthNumeric."/".$date; ?></option>
						                                    			<option value="2"><?php echo  $monthNumeric ."/".$date."/".$year; ?></option>
						                                    			<option value="3"><?php echo $date ."/".$monthNumeric."/".$year;  ?></option>
																	<?php				                                    			
						                                    		}
																	else if($dateFormat == 1)
																	{
																	?>
																		<option value="0"><?php echo  $monthName ." ".$date.",  ".$year; ?></option>
						                                    			<option value="1" selected="selected"><?php echo  $year ."/".$monthNumeric."/".$date; ?></option>
						                                    			<option value="2"><?php echo  $monthNumeric ."/".$date."/".$year; ?></option>
						                                    			<option value="3"><?php echo $date ."/".$monthNumeric."/".$year;  ?></option>
																	<?php				                                    																			
																	}
						                                    		
						                                    		else if($dateFormat == 2)
																	{
																	?>
																		<option value="0"><?php echo  $monthName ." ".$date.",  ".$year; ?></option>
						                                    			<option value="1" ><?php echo  $year ."/".$monthNumeric."/".$date; ?></option>
						                                    			<option value="2" selected="selected"><?php echo  $monthNumeric ."/".$date."/".$year; ?></option>
						                                    			<option value="3"><?php echo $date ."/".$monthNumeric."/".$year;  ?></option>
																	<?php				                                    																			
																	}
						                                    			
						                                    		else 
																	{
																	?>
																		<option value="0"><?php echo  $monthName ." ".$date.",  ".$year; ?></option>
						                                    			<option value="1" ><?php echo  $year ."/".$monthNumeric."/".$date; ?></option>
						                                    			<option value="2"><?php echo  $monthNumeric ."/".$date."/".$year; ?></option>
						                                    			<option value="3" selected="selected"><?php echo $date ."/".$monthNumeric."/".$year;  ?></option>
																	<?php				                                    																			
																	}
						                                    		?>																
						                                    	</select> 				                                   
															</div>
						                            </div>
						                            <div class="control-group">
						                            <?php
							                        	$timeFormat = $wpdb -> get_var('SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Time_Format"');
														$minuteFormat = $wpdb -> get_var('SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Slot_Minute_Format"');
							                        ?>
						    	                    <label class="control-label"><?php _e( "Default Time Format :", bookings_plus ); ?>
						    	                    <span class="req">*</span>
						    	                    </label>
						                            <div class="controls">
						                                    	<select name="uxDefaultTimeFormat" class="style required" id="uxDefaultTimeFormat">
																	<?php				                                    		
						                                    		if($timeFormat == 0)
								                            		{
								                           			?>	
						                                    			<option value="0" selected="selected"><?php _e( "12 Hours", bookings_plus ); ?></option>
						                                    			<option value="1"><?php _e( "24 Hours", bookings_plus ); ?></option>
																	<?php				                                    			
						                                    		}
																	else 
																	{
																	?>
																		<option value="0"><?php _e( "12 Hours", bookings_plus ); ?></option>
						                                    			<option value="1" selected="selected"><?php _e( "24 Hours", bookings_plus ); ?></option>
																	<?php				                                    																			
																	}
						                                    		?>															
						                                    	</select> 				                                   
															</div>
						                            </div>
						                            <div class="control-group">
						                            		<?php
							                            		$default_Time_Zone = $wpdb -> get_var('SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = "default_Time_Zone"');																
							                                ?>
						    	                           	<label class="control-label"><?php _e( "Default Time Zone :", bookings_plus ); ?>
						    	                            	<span class="req">*</span>
						    	                            </label>
						                                    <div class="controls">
						                                    	<select name="uxDefaultTimeZone" class="style required" id="uxDefaultTimeZone">
																  <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
															      <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
															      <option value="-10.0">(GMT -10:00) Hawaii</option>
															      <option value="-9.0">(GMT -9:00) Alaska</option>
															      <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
															      <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
															      <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
															      <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
															      <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
															      <option value="-3.5">(GMT -3:30) Newfoundland</option>
															      <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
															      <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
															      <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
															      <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
															      <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
															      <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
															      <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
															      <option value="3.5">(GMT +3:30) Tehran</option>
															      <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
															      <option value="4.5">(GMT +4:30) Kabul</option>
															      <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
															      <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
															      <option value="5.75">(GMT +5:45) Kathmandu</option>
															      <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
															      <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
															      <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
															      <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
															      <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
															      <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
															      <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
															      <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>													
						                                    	</select>
						                                    	<script>
						                                    		jQuery('#uxDefaultTimeZone').val("<?php echo html_entity_decode($default_Time_Zone); ?>");
						                                    	</script> 				                                   
															</div>
						                            </div>
						                            <?php
						                            $hourTotalFormat = $wpdb->get_var("select GeneralSettingsValue  from ". generalSettingsTable()." where GeneralSettingsKey ='default_Slot_Total_Time_Format' ");
						                            $getHours = floor(($hourTotalFormat)/60);
													$getMins = ($hourTotalFormat) % 60;			
													if($getMins < 10)	
													{
														$getMins = $getMins;
													}					             
						                            ?>
							                        <div class="control-group">
							                        	<label class="control-label"><?php _e( "Default Booking Slot Size :", bookings_plus ); ?>
						                                       <span class="req">*</span>
						                                </label>
						                                <div class="controls">
							                               	<select name="uxSlotHours" class="style required" id="uxSlotHours" >
									                        <?php
															for ($hr = 0; $hr <= 23; $hr++) 
															{
																if ($hr < 10 && $hr == $getHours) 
																{
																	echo "<option selected=\"selected\" value=0" . $hr . " >0" . $hr . "  Hours</option>";
																}
																else if($hr == $getHours) 
																{
																	echo "<option selected=\"selected\" value=" . $hr . " >" . $hr . "  Hours</option>";
																}
																else 
																{
																	echo "<option value=" . $hr . ">" . $hr . "  Hours</option>";
																}
															}
															?>
										                    </select>
										                    <select name="uxSlotMins" class="style required" id="uxSlotMins">
										                    <?php
															for ($min = 0; $min < 60; $min += 5) 
															{
																if ($min < 10 && $min == $getMins) 
																{
																	echo "<option selected=\"selected\" value=0" . $min . ">0" . $min . " Minutes</option>";
																}
																else if ($min == $getMins) 
																{
																	echo "<option selected=\"selected\" value=" . $min . ">" . $min . " Minutes</option>";
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
				                   		</div>
				               		</div>
					              	<div class="form-actions" style="padding:10px 0px 0px 0px;">
					               		<input type="submit" value="<?php _e( "Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
					               	</div>				            
	                   			</form>
	                   		</div>
	                	</div>    
	           		</div>	
	                <div class="well-smoke block"  style="margin-top:10px">
			        	<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Email Templates", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	    	<a class="just-icon" data-toggle="collapse" data-target="#emailTemplates">
	                    	    		<i class="font-resize-vertical">
	                    	    		</i>
	                    	        </a>
	                            </div>
	                        </div>
	                    </div>
		                <div class="collapse" id="emailTemplates">
		        	    	<div class="body">
		        				<div class="control-group">
			        				<a href="#PendingConfirmationEmailTemplate" data-toggle="modal">
			        					<span class="label label-info">
			        						<i class="font-envelope-alt" style="margin-right:10px;"></i>
			        			            	<?php _e( "Booking Pending Confirmation Email Template [Sent to Client]", bookings_plus ); ?>
			        			        </span>
			        		        </a>
			        	        </div>
			       		        <div class="control-group">
		        			    	<a href="#ConfirmationEmailTemplate" data-toggle="modal">
		        			        	<span class="label label-info">
		        			        		<i class="font-envelope-alt" style="margin-right:10px;"></i>
		        			                	<?php _e( "Booking Confirmation Email Template [Sent to Client]", bookings_plus ); ?>
		        			            </span>
		        			        </a>
		        		        </div>
			       		        <div class="control-group">
			        			    <a href="#BookingDeclinedEmailTemplate" data-toggle="modal">
			        			    	<span class="label label-info">
			        			    		<i class="font-envelope-alt" style="margin-right:10px;"></i>
			        			            	<?php _e( "Booking Disapproved Email Template [Sent to Client]", bookings_plus ); ?>
			        			        </span>
			        			    </a>
		        		        </div>
			       		        <div class="control-group">
		        			    	<a href="#AdminApproveDisapproveEmailTemplate" data-toggle="modal">
		        			        	<span class="label label-important">
		        			        		<i class="font-envelope-alt" style="margin-right:10px;"></i>
		        			                	<?php _e( "Approve/Decline Booking Email Template [Sent to Admin]", bookings_plus ); ?>
		        			            </span>
		        			        </a>
		        		        </div>	
		        		    </div>
		        		</div>
	                </div>        
	                <div class="well-smoke block"  style="margin-top:10px">
			        	<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Social Media Settings", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	    	<a class="just-icon" data-toggle="collapse" data-target="#socialMediaSettings">
	                    	    		<i class="font-resize-vertical">
	                    	    		</i>
	                    	    	</a>
	                            </div>
	                        </div>
	                    </div>
		                <div class="collapse" id="socialMediaSettings">
		        	    	<div class="body">
		        	    		<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/facebook-settings.jpg"/></a>
									</div>									
									  
		        				
		        			</div>
		        		</div>
	        		</div>
	        		<div class="well-smoke block"  style="margin-top:10px">
			    		<div class="navbar">
							<div class="navbar-inner">
	                			<h5>
	                				<?php _e( "Payment Gateway Settings", bookings_plus ); ?>
	                			</h5>
	                    		<div class="nav pull-right">
	                    			<a class="just-icon" data-toggle="collapse" data-target="#paymentGatewaySettings">
	                    				<i class="font-resize-vertical"></i>
	                    			</a>
	                    		</div>
	               			</div>
	            		</div>
		 	   			<div class="collapse" id="paymentGatewaySettings">
			 				<div class="body">	 
					        	    <a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/paypal-settings.jpg"/></a>       
			        		</div>
		        		</div>
	     			</div>
	        		<div class="well-smoke block"  style="margin-top:10px">
			   			<div class="navbar">
							<div class="navbar-inner">
	                			<h5>
	                				<?php _e( "Auto Responder Settings", bookings_plus ); ?>
	                			</h5>
	                    		<div class="nav pull-right">
	                    			<a class="just-icon" data-toggle="collapse" data-target="#autoResponderSettings">
	                    				<i class="font-resize-vertical"></i>
	                    			</a>
	                    		</div>
	                		</div>
	            		</div>
		        		<div class="collapse" id="autoResponderSettings">
			 				<div class="body">
			 					<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/mailchimp-settings.jpg"/></a>	        		
			        		</div>
		        		</div>
	        		</div>
	        	</div>
	    </div>
	 </div>	    
</div>		


<div id="PendingConfirmationEmailTemplate" style="width:850px;display:none" class="modal hide fade" role="dialog" aria-hidden="true">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h5><?php _e( "Booking Pending Confirmation Email Template [Sent to Client]",bookings_plus ); ?></h5>
</div>

	<form id="uxFrmPendingConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="PendingConfirmationSuccess" style="display:none">
				<strong>
					<?php _e( "Success! The Email has been saved Successfully.", bookings_plus ); ?>
				</strong>
	       </div>
	       <?php
	       		$result = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
						"booking-pending-confirmation"
					)
				);
			    ?>
	            <div class="block well" style="margin-top:10px;">

	                <div class="row-fluid form-horizontal">
		            	<div class="control-group">
		                	<label class="control-label">
		                		<?php _e( "Email Subject :", bookings_plus ); ?>
		                        <span class="req">*</span>
		                    </label>
		                    <div class="controls">
		                    	<input type="text" class="required span12"name="uxPendingConfirmationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxPendingConfirmationEmailTemplateSubject"/>
		                    </div>
		                </div>
		                <div class="control-group">        
    						<?php   
    						   $content = stripslashes($result->EmailContent);
							   the_editor($content, $id = 'uxPendingConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    						?>
						</div>
					</div>
				</div>
	          	<div class="form-actions" style="padding:10px 0px;">
	         		<input type="submit" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>"   class="btn btn-info pull-right">
	         	</div>
		</div>
	</form>
	<style type="text/css">
		#uxPendingConfirmationEmailTemplate_ifr{height:250px !important;}
	</style>

</div>
<div id="ConfirmationEmailTemplate" style="width:850px;display:none" class="modal hide fade" role="dialog" aria-hidden="true">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h5><?php _e( "Booking Confirmation Email Template [Sent to Client]",bookings_plus ); ?></h5>
</div>
	<form id="uxFrmConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="ConfirmationSuccess" style="display:none">
				<strong>
					<?php _e( "Success! The Email has been saved Successfully.", bookings_plus ); ?>
				</strong>
	        </div>
	        <?php
	        	$result = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
						"booking-confirmation"
					)
				);
			?>
	        <div class="block well" style="margin-top:10px;">
	     
	            <div class="row-fluid form-horizontal">
		        	<div class="control-group">
		            	<label class="control-label"><?php _e( "Email Subject :", bookings_plus ); ?>
		                    	<span class="req">*</span>
		                </label>
		                <div class="controls">
		                	<input type="text" class="required span12" name="uxConfirmationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxConfirmationEmailTemplateSubject"/>
		                </div>
		            </div>								
					<div class="control-group">        
    						<?php   
    						 	$content = stripslashes($result->EmailContent);
    							the_editor($content, $id = 'uxConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    						?>
					</div>                     
	            </div>
	    	</div>
	        <div class="form-actions" style="padding:10px 0px;">
	        	<input type="submit" value="<?php _e( "Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
	        </div>
		</div>
	</form>
	<style type="text/css">
		#uxConfirmationEmailTemplate_ifr{height:250px !important;}
	</style>

</div>
<div id="BookingDeclinedEmailTemplate" style="width:850px;display:none" class="modal hide fade" role="dialog" aria-hidden="true">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h5><?php _e( "Booking Decline Email Template [Sent to Client]",bookings_plus ); ?></h5>
</div>
	<form id="uxFrmBookingDeclinedEmailTemplate" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="BookingDeclinedSuccess" style="display:none">
				<strong><?php _e( "Success! The Email has been saved Successfully.", bookings_plus ); ?></strong>
	        </div>
	        <?php
	        	$result = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".email_templatesTable()." where EmailType = %s","booking-disapproved"
					)
				);
			?>
	        <div class="block well" style="margin-top:10px;">

	            <div class="row-fluid form-horizontal">
		        	<div class="control-group">
		            	<label class="control-label"><?php _e( "Email Subject :", bookings_plus ); ?>
		            		<span class="req">*</span>
		                </label>
		                <div class="controls">
		                	<input type="text" class="required span12" name="uxBookingDeclinedEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxBookingDeclinedEmailTemplateSubject"/>
		                </div>
		        	</div>								
					<div class="control-group">        
    				<?php   
    				 	$content = stripslashes($result->EmailContent);
    					the_editor($content, $id = 'uxBookingDeclinedEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    				?>
					</div>                 
	            </div>
	        </div>
	        <div class="form-actions" style="padding:10px 0px;">
	        	<input type="submit" value="<?php _e( "Save Changes", bookings_plus ); ?>"   class="btn btn-info pull-right">
	        </div>
		</div>
	</form>
	<style type="text/css">
		#uxBookingDeclinedEmailTemplate_ifr{height:250px !important;}
	</style>

</div>
<div id="AdminApproveDisapproveEmailTemplate" style="width:850px;display:none" class="modal hide fade" role="dialog" aria-hidden="true">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h5><?php _e( "Admin Approve/Disapprove Email Template [Sent to Admin]",bookings_plus ); ?></h5>
</div>
	<form id="uxFrmAdminApproveDisapproveEmailTemplate" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="AdminApproveDisapproveSuccess" style="display:none">
				<strong>
					<?php _e( "Success! The Email has been saved Successfully.", bookings_plus ); ?>
				</strong>
	        </div>
	        <?php
	        	$result = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT * FROM ".email_templatesTable()." where EmailType = %s",	"admin-control"
						           
						)
					);
			?>
	        <div class="block well" style="margin-top:10px;">

	            <div class="row-fluid form-horizontal">
		        	<div class="control-group">
		            	<label class="control-label"><?php _e( "Email Subject :", bookings_plus ); ?>
		                    	<span class="req">*</span>
		                </label>
		                <div class="controls">
		                	<input type="text" class="required span12" name="uxAdminApproveDisapproveEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxAdminApproveDisapproveEmailTemplateSubject"/>
		                </div>
		            </div>								
					<div class="control-group">        
    				<?php   
    				 	$content = stripslashes($result->EmailContent);
    					the_editor($content, $id = 'uxAdminApproveDisapproveEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    				?>
					</div>                       
	            </div>
	      	</div>
	        <div class="form-actions" style="padding:10px 0px;">
	        	<input type="submit" value="<?php _e( "Save Changes", bookings_plus ); ?>"   class="btn btn-info pull-right">
	        </div>
		</div>
	</form>
	<style type="text/css">
		#uxAdminApproveDisapproveEmailTemplate_ifr{height:250px !important;}
	</style>
</div>

<script type="text/javascript">

		var uri = "<?php echo $url; ?>";      
		
		jQuery("#uxFrmGeneralSettings").validate
		({
			submitHandler: function(form) 
	     	{
				var uxDefaultcurrency  = jQuery('#uxDdlDefaultCurrency').val();
	    	    var uxDefaultcountry  = jQuery('#uxDdlDefaultCountry').val();
	    	    var uxDefaultTimeFormat =   jQuery('#uxDefaultTimeFormat').val();
	    	    var uxDefaultDateFormat =   jQuery('#uxDefaultDateFormat').val();
	    	    var uxSlotHours =  jQuery('#uxSlotHours').val();
	    	    var uxSlotMins =  jQuery('#uxSlotMins').val();
	    	    var default_Time_Zone = encodeURIComponent(jQuery('#uxDefaultTimeZone').val());
	    	    var default_Time_Zone_Name =  encodeURIComponent(jQuery("#uxDefaultTimeZone option[value='"+default_Time_Zone+"']").text());

	    	    jQuery.ajax
			    ({
						type: "POST",
						data: "default_Time_Zone_Name="+default_Time_Zone_Name+"&default_Time_Zone="+ default_Time_Zone +"&uxDefaultcurrency="+uxDefaultcurrency+"&uxDefaultcountry="+uxDefaultcountry+"&uxDefaultTimeFormat="+uxDefaultTimeFormat+
						"&uxSlotHours="+uxSlotHours+"&uxDefaultDateFormat="+uxDefaultDateFormat+"&uxSlotMins="+uxSlotMins+"&target=updateGeneralSettings&action=getAjaxExecuted",
						url:  ajaxurl,
			            success: function(data) 
			            {  
			            	
			            	var format = data.split(',');
							jQuery('#uniform-uxSlotHours span').val(format[0]);
							jQuery('#uniform-uxSlotMins span').html(format[1]);
			            	jQuery('#successDefaultSettingsMessage').css('display','block');
							setTimeout(function() 
						    {
						       	jQuery('#successDefaultSettingsMessage').css('display','none');
						    }, 2000);				            	
		                }
		        });
			}
		});
		jQuery("#uxFrmPendingConfirmationEmailTemplate").validate
		({
			submitHandler: function(form) 
	     	{ 
				var PendingConfirmationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxPendingConfirmationEmailTemplateSubject").val());
				var PendingConfirmationEmailTemplateContent = encodeURIComponent(tinyMCE.get('uxPendingConfirmationEmailTemplate').getContent());
				
				jQuery.ajax
			    ({
						type: "POST",
						data: "PendingConfirmationEmailTemplateSubject="+PendingConfirmationEmailTemplateSubject+
						"&PendingConfirmationEmailTemplateContent="+PendingConfirmationEmailTemplateContent+
						"&target=updatePendingConfirmationEmailTemplate&action=getAjaxExecuted",
						url:  ajaxurl,
			            success: function(data) 
			            {  
			            	jQuery('#PendingConfirmationSuccess').css('display','block');
			            	setTimeout(function() 
						    {
						    	jQuery('#PendingConfirmationSuccess').css('display','none');
						         var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    	window.location.href = "admin.php?page="+checkPage;
						   }, 2000);
			            }
			    });
			}
		});
		
		jQuery("#uxFrmConfirmationEmailTemplate").validate
		({
			submitHandler: function(form) 
	     	{
				var ConfirmationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxConfirmationEmailTemplateSubject").val());
				var ConfirmationEmailTemplateContent = encodeURIComponent(tinyMCE.get('uxConfirmationEmailTemplate').getContent());
		     	jQuery.ajax
			    ({
						type: "POST",
						data: "ConfirmationEmailTemplateSubject="+ConfirmationEmailTemplateSubject+
						"&ConfirmationEmailTemplateContent="+ConfirmationEmailTemplateContent+"&target=updateConfirmationEmailTemplate&action=getAjaxExecuted",
						url:  ajaxurl,
			            success: function(data) 
			            {  
			            	jQuery('#ConfirmationSuccess').css('display','block');
			            	setTimeout(function() 
						    {
						    	jQuery('#ConfirmationSuccess').css('display','none');
						         var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    	window.location.href = "admin.php?page="+checkPage;
						   }, 2000);
			            }
			    });
			}
		});
		
		jQuery("#uxFrmBookingDeclinedEmailTemplate").validate
		({
			submitHandler: function(form) 
	     	{
				var DeclineEmailTemplateSubject =  encodeURIComponent(jQuery("#uxBookingDeclinedEmailTemplateSubject").val());
				var DeclineEmailTemplateContent = encodeURIComponent(tinyMCE.get('uxBookingDeclinedEmailTemplate').getContent());
		     	jQuery.ajax
			    ({
						type: "POST",
						data: "DeclineEmailTemplateSubject="+DeclineEmailTemplateSubject+
						"&DeclineEmailTemplateContent="+DeclineEmailTemplateContent+"&target=updateDeclinedEmailTemplate&action=getAjaxExecuted",
						url:  ajaxurl,
			            success: function(data) 
			            {  
			            	jQuery('#BookingDeclinedSuccess').css('display','block');
			            	setTimeout(function() 
						    {
						    	jQuery('#BookingDeclinedSuccess').css('display','none');
						         var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    	window.location.href = "admin.php?page="+checkPage;
						   }, 2000);
			            }
			    });
			}
		});
		jQuery("#uxFrmAdminApproveDisapproveEmailTemplate").validate
		({
			submitHandler: function(form) 
	     	{
				var AdminApproveDisapproveEmailTemplateSubject =  encodeURIComponent(jQuery("#uxAdminApproveDisapproveEmailTemplateSubject").val());
				var AdminApproveDisapproveEmailTemplateContent = encodeURIComponent(tinyMCE.get('uxAdminApproveDisapproveEmailTemplate').getContent());
		     	jQuery.ajax
			    ({
						type: "POST",
						data: "AdminApproveDisapproveEmailTemplateSubject="+AdminApproveDisapproveEmailTemplateSubject+
						"&AdminApproveDisapproveEmailTemplateContent="+AdminApproveDisapproveEmailTemplateContent+
						"&target=updateAdminApproveDisapproveEmailTemplate&action=getAjaxExecuted",
						url:  ajaxurl,
			            success: function(data) 
			            {  
			            	jQuery('#AdminApproveDisapproveSuccess').css('display','block');
			            	setTimeout(function() 
						    {
						    	jQuery('#AdminApproveDisapproveSuccess').css('display','none');
						         var checkPage = "<?php echo $_REQUEST['page']; ?>";
						    	window.location.href = "admin.php?page="+checkPage;
						   }, 2000);
			            }
			    });
			}
		});
		
	  
 	   jQuery('.popover-test').popover({
		placement: 'right'
		});
</script>
