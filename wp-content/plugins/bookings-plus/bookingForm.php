<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;


?>
<div class="content">
	<div class="body">    	
    	<div class="well-smoke block" style="margin-top:0px">
        	<div class="navbar">
        		<div class="navbar-inner">
             		 <h5><i class="font-hand-right"></i><?php _e( "Booking Form Setup", bookings_plus ); ?></h5>
            	</div>
			</div>
        	<div class="body">
        		<div class="note note-success" id="bookingFieldsSuccessMessage" style="display:none">
					<strong><?php _e( "Success! The Booking Fields has been updated Successfully.", bookings_plus ); ?></strong>
	        	</div>
  				<div class="row-fluid nested">
					<div class="well-smoke block" style="margin-top:10px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Booking Form Fields", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#bookingFormFields">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>
	            		<div class="collapse in" id="bookingFormFields">
	            			<div class="body"> 
	            				<form id="uxFrmbookingFormFields" class="form-horizontal" method="post" action="#">        		
					           	<div class="row-fluid nested form-horizontal">
					        		<div class="span12 well">
								   		<div class="table-overflow">
									    	<table class="table table-striped" id="data-table-clients">
									           	<thead>
									              	<tr>
									            	   	<th><?php _e( "Field Name", bookings_plus ); ?></th>
									                	<th><?php _e( "Visibility", bookings_plus ); ?></th>
									                    <th><?php _e( "Validation", bookings_plus ); ?></th>
										            </tr>
									            </thead>
									  		 	<tbody>
									  		 	<?php
									  		 	$bookingFeild = $wpdb->get_results
												(
													$wpdb->prepare
													(
													     "SELECT * FROM ".bookingFormTable()
													)
												);
												for ($flag = 0; $flag < count($bookingFeild); $flag++) 
												{
													$bookingFeildName = $bookingFeild[$flag]->BookingFormField ;
													$bookingStatus = $bookingFeild[$flag]->status;
													$BookingRequired = $bookingFeild[$flag]->required;
													$checked = "";
													$check = "";
													if ($bookingStatus == 1) 
													{
														$checked = "checked=\"checked\"";
													} 
													else 
													{
														$check = "checked=\"checked\"";
													}
													$check1 = "";
													$check0 = "";
													if ($BookingRequired == 1) 
													{
														$check1 = "checked=\"checked\"";
													} 
													else 
													{
														$check0 = "checked=\"checked\"";
													}
													?>
													<tr>
													    <td><?php echo $bookingFeildName;?><input type="hidden" id="bookingFeildNameHidden<?php echo $flag;?>" value="<?php echo $bookingFeildName;?>"/></td>	
													   	<?php
													   	if($bookingFeildName != "First Name :" && $bookingFeildName != "Email :" )													
														{
														?>
														   	<td>
											                	<label class="radio">
											                		<input type="radio" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> />  <?php _e( "Visible", bookings_plus ); ?>
											                 	</label>
																<label class="radio">
																	<input type="radio" id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> />  <?php _e( "Invisible", bookings_plus ); ?>
																</label>                                     		 									
															</td>
															<td>
						                 						<label class="radio">
						                 							<input type="radio" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /> <?php _e( "Required", bookings_plus ); ?>
						                 						</label>	
																<label class="radio">
																	<input type="radio" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /> <?php _e( "Not Required", bookings_plus ); ?>
																</label>
					                                    	</td>
					                                    <?php
					                                    }
														else 
														{
														?>
															<td>
										                		<label class="radio">
										                			<input type="radio" disabled="disabled" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> />  <?php _e( "Visible", bookings_plus ); ?>
										                		</label>
																<label class="radio">
																	<input type="radio" disabled="disabled"id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> />  <?php _e( "Invisible", bookings_plus ); ?>
																</label>                                     		 									
														   	</td>
														   	<td>
						                 						<label class="radio">
						                 							<input type="radio" disabled="disabled" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /> <?php _e( "Required", bookings_plus ); ?>
						                 						</label>	
																<label class="radio">
																	<input type="radio" disabled="disabled" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /> <?php _e( "Not Required", bookings_plus ); ?>
																</label>
					                                       	</td>
															<?php
														}
					                                    ?>
													</tr>
								 					<?php
												}
												?>
							
												</tbody>
									      </table>
								    	</div>
								 	</div>							
					            </div>
								<div class="form-actions" style="padding:10px 0px 0px 10px;">
									<input type="submit" data-loading-text="<?php _e( "Processing Data...", bookings_plus ); ?>" id="btnSaveFields" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>" class="btn btn-info pull-right">
								</div>
							</form>					            		
					        </div>		
						</div>
					</div>	  					
	        		<div class="well-smoke block" style="margin-top:10px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Booking Form Short Codes For Front End", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#bookingFormShortCodes">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>
	            		<div class="collapse" id="bookingFormShortCodes">
	            			<div class="body"> 
									
									<div class="row-fluid form-horizontal">
										<div class="control-group">
											<label class="control-label"><?php _e( "Calendar Embed :", bookings_plus ); ?></label>
												<div class="controls">
												<?php 
													$iframeLink = "<iframe src='$url/bookingCalendarByIframe.php' style='width: 800px; height:700px' scrolling='no'></iframe>";
												?>
													<textarea readonly="readonly" id="iframeCode" rows="3" style="width:100%"><?php echo $iframeLink; ?></textarea>
													<a id="linkCopyiframe" class="btn-link pull-right" style="padding-right:0px;text-decoration:underline;font-size:11px"><?php _e( "Copy to Clipboard", bookings_plus ); ?></a>						        	
												</div>
									 </div>
										<div class="control-group">
											<label class="control-label"><?php _e( "Booking Link Code (Single Services) :", the_royal_bookings_system ); ?>
											</label>
											<div class="controls">
												<textarea readonly="readonly"  id="singleServiceCode" rows="2"  style="width:100%">[booking service = 1 fore-color=red background-color=green]Book Now[/booking]</textarea>
												<a  id="linkCopySingleService" class="btn-link pull-right" style="padding-right:0px;text-decoration:underline;font-size:11px"><?php _e( "Copy to Clipboard", the_royal_bookings_system ); ?></a>							        	
											</div>
										</div>
										<?php
										   $bookingImageName = $wpdb -> get_var('SELECT GeneralSettingsValue FROM ' . generalSettingsTable().' where GeneralSettingsKey = "booking_image"'); 	
										?>						   
										<div class="control-group">
											<label class="control-label"><?php _e( "Booking Link Code (All Services) :", the_royal_bookings_system ); ?>
												
											</label>
											<div class="controls">
												<textarea readonly="readonly"  id="allServicesCode" rows="2"  style="width:100%">[booking link fore-color=red background-color=green]Book Now[/booking]</textarea>
												<a  id="linkCopyAllServices" class="btn-link pull-right" style="padding-right:0px;text-decoration:underline;font-size:11px"><?php _e( "Copy to Clipboard", the_royal_bookings_system ); ?></a>							        	
											</div>
										</div>						   
										<div class="control-group">
											<label class="control-label"><?php _e( "Image Link Code :", the_royal_bookings_system ); ?>
												
											</label>
											<div class="controls">
												<?php
												$imageBookingLink = "<a href=\"#bookingLink\" class=\"fancybox\"><img src=\"$url/images/bookingImages/$bookingImageName\" />[booking link fore-color=red background-color=green][/booking]</a>";
												?>
												<textarea readonly="readonly"  id="imageCode" rows="3"  style="width:100%"><?php echo $imageBookingLink; ?></textarea>						        	
												<a  id="linkCopyImageCode" class="btn-link pull-right" style="padding-right:0px;text-decoration:underline;font-size:11px"><?php _e( "Copy to Clipboard", the_royal_bookings_system ); ?></a>	
											</div>
										</div>
										<div class="control-group">
											<label class="control-label"><?php _e( "Custom Image :", the_royal_bookings_system ); ?>
												
											</label>
											<div class="controls">
												
												<img  src="<?php echo plugins_url('/images/bookingImages/'.$bookingImageName, __FILE__);?>" style="width: 130px;"/>				        	
											</div>
										</div>
										<form  method="POST" enctype="multipart/form-data" id="formBookingImage" action="<?php echo $url;?>/upload_Bookinglink_Image.php">
										<div class="control-group">
											<label class="control-label"><?php _e( "Upload Custom Image :", the_royal_bookings_system ); ?>
												
											</label>
											<div class="controls">
												<input type="file" name="file" id="file" />					        	
											</div>
										</div>
										<div class="control-group">
											<div class="form-actions" style="padding:0px;">
												<input type="submit" value="<?php _e( "Save Changes", the_royal_bookings_system ); ?>"  class="btn btn-info pull-right">
											</div>
										</div>									   					   
									</div>
							</form>								
							</div>
						</div>
					</div>
					<div class="well-smoke block" style="margin-top:10px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Booking Form Header", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#bookingFormHeader">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>

	            		<div class="collapse" id="bookingFormHeader">
	            			<div class="body"> 
	            					<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/booking-form-header.jpg"/></a>				
							</div>
						</div>
					</div>
	        		<div class="well-smoke block" style="margin-top:10px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Booking Form Footer", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#bookingFormFooter">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>
	            		
	            		<div class="collapse" id="bookingFormFooter">
	            			<div class="body">
	            			            					<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/booking-form-footer.jpg"/></a>							
							</div>
						</div>
					</div>					
	        		<div class="well-smoke block" style="margin-top:10px">
			   			<div class="navbar">
					    	<div class="navbar-inner">
	                	    	<h5>
	                	    		<?php _e( "Booking Form Thank you Message", bookings_plus ); ?>
	                	    	</h5>
	                            <div class="nav pull-right">
	                    	        <a class="just-icon" data-toggle="collapse" data-target="#bookingFormThankyou">
	                    	        	<i class="font-resize-vertical"></i>
	                    	        </a>
	                    	    </div>
	                		</div>
	            		</div>
	            		<div class="collapse" id="bookingFormThankyou">
	            			<div class="body">
								<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/booking-form-thankyou.jpg"/></a>
	            			</div>
						</div>
					</div>	
				</div>	
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
 jQuery("#linkCopyiframe").each(function() 
  {
  		var clip = new ZeroClipboard.Client();
		var lastTd = jQuery(this);
        var parentRow = lastTd.parent("code");
		clip.glue(lastTd[0]);
		var txt = jQuery.trim(jQuery("#iframeCode").text()) ;
       	clip.setText(txt);
		clip.addEventListener('complete', function(client, text)
		{
        	bootbox.alert("<?php _e( "Thank you for copying the Short Code.", bookings_plus ); ?>");
        });
   });
   jQuery("#linkCopySingleService").each(function() 
   {
   	
  		var clip = new ZeroClipboard.Client();
		var lastTd = jQuery(this);
        var parentRow = lastTd.parent("code");
		clip.glue(lastTd[0]);
		var txt = jQuery.trim(jQuery("#singleServiceCode").text()) ;
       	clip.setText(txt);
		clip.addEventListener('complete', function(client, text)
		{
        	bootbox.alert("<?php _e( "Thank you for copying the Short Code.", bookings_plus ); ?>");
        });
    });
    jQuery("#linkCopyAllServices").each(function() 
    {
  		var clip = new ZeroClipboard.Client();
		var lastTd = jQuery(this);
        var parentRow = lastTd.parent("code");
		clip.glue(lastTd[0]);
		var txt = jQuery.trim(jQuery("#allServicesCode").text()) ;
       	clip.setText(txt);
		clip.addEventListener('complete', function(client, text)
		{
        	bootbox.alert("<?php _e( "Thank you for copying the Short Code.", bookings_plus ); ?>");
        });
    });
    jQuery("#linkCopyImageCode").each(function() 
    {
  		var clip = new ZeroClipboard.Client();
		var lastTd = jQuery(this);
        var parentRow = lastTd.parent("code");
		clip.glue(lastTd[0]);
		var txt = jQuery.trim(jQuery("#imageCode").text()) ;
       	clip.setText(txt);
		clip.addEventListener('complete', function(client, text)
		{
        	bootbox.alert("<?php _e( "Thank you for copying the Short Code.", bookings_plus ); ?>");
        });
    });
	function setaction(e) 
	{
		var t = e.id;
		
		var radioid = t.split("_");
		value = e.value;
		
		if(value == 0) 
		{
			//alert(radioid[1]);
			jQuery('#uniform-bookingRequiredOpen' + radioid[1] + ' span').removeAttr("class", "checked");
			jQuery('#uniform-bookingRequiredClose' + radioid[1] + ' span').attr("class", "checked");
			jQuery('#bookingRequiredClose' + radioid[1]).attr("checked", "checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).removeAttr("checked");
		} 
		else if(value == 1)
		{
			jQuery('#uniform-bookingRequiredOpen' + radioid[1]  + ' span').attr("class", "checked");
			jQuery('#uniform-bookingRequiredClose' + radioid[1]  + ' span').removeAttr("class", "checked");
			jQuery('#bookingRequiredClose' + radioid[1]).removeAttr("checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).attr("checked", "checked");
		}
	}
	
	jQuery("#uxFrmbookingFormFields").validate
	({
		rules:
		{
			
		},
		submitHandler: function(form) 
	    { 
			<?php $bookingFeilds = $wpdb->get_var('SELECT count(BookingFormId) FROM ' . bookingFormTable());?>
			var countbBokingFields = "<?php echo $bookingFeilds;?>";
			for(var flag=0; flag<countbBokingFields; flag++)
			{
				var bookingRadioVisible;
				var bookingRadiooRequired;
				var radios = document.getElementsByName('bookingStatusSaved'+flag);
				for (var j = 0; j < radios.length; j++) 
				{
					if(radios[j].type == 'radio' && radios[j].checked)
					{
						bookingRadioVisible = radios[j].value;
						break;
					}
				}
				var radioss = document.getElementsByName('bookingRequiredSaved'+flag);
				for (var k = 0; k < radioss.length; k++) 
				{
					if (radioss[k].type == 'radio' && radioss[k].checked)
					{
						bookingRadiooRequired = radioss[k].value;
						break;
					}
				}	
				var fieldname= jQuery("#bookingFeildNameHidden"+flag).val();
				var field_name = encodeURIComponent(fieldname);
				jQuery.ajax
				({
					type: "POST",
					data: "fieldcompare="+field_name+"&bookingRadioVisible="+bookingRadioVisible+"&bookingRadiooRequired="+bookingRadiooRequired+"&target=savedBookingForm&action=getAjaxExecuted",
					url:  ajaxurl,
					success: function(data)
					{
						jQuery('#bookingFieldsSuccessMessage').css('display','block');
						setTimeout(function() 
			            {
		    	        	jQuery('#bookingFieldsSuccessMessage').css('display','none');
		        	    }, 2000);
					}
				});
			}
		}
	});
	function selectImage()
	{
		var imageName = jQuery('#file').val();
		if(imageName !="")
		{
			jQuery("#formBookingImage").submit();
		}
		else
		{
			bootbox.alert("<?php _e( "Please choose the Image to be uploaded.", bookings_plus ); ?>")
		}
	}
</script>
