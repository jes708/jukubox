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
                        <?php _e( "Customers", bookings_plus ); ?>
                    </h5>
                    <div class="nav pull-right">
				    	<a href="#" class="dropdown-toggle just-icon" data-toggle="dropdown">
				        	<i class="font-cog"></i>
							<span style="color:#000 !important;margin-left:5px">
								<b class="caret"></b>
							</span>				                		
				        </a>
                        <ul class="dropdown-menu pull-right">
                        <?php
                        $countCustomer = $wpdb->get_var("SELECT count(CustomerId) FROM ".customersTable());
						$countCustomerOption = get_option("count-customer");
						if($countCustomer < $countCustomerOption)
						{
							?>
							<li>
                            	<a class="fancybox" href="#addNewCustomer">
                                	<i class="font-plus-sign"></i>
                                	<?php _e( "Add New Customer",bookings_plus ); ?>
                                </a>
                            </li>
							<?php
						}
                        	?>
                        </ul>
                    </div>
                </div>
            </div>
			<p style="padding:10px 10px 0px 10px">
				<span class="label label-important"><?php _e( "Note: Click on the Right Corner of the Settings icon to perform various actions viz. Add New Customer, Export Customers.", bookings_plus ); ?></code>					
			</p>
            <div class="table-overflow">
            	<table class="table table-striped" id="data-table-clients1">
                	<thead>
                    	<tr>
     	                   	<th style="width:15%"><?php _e( "First Name", bookings_plus ); ?></th>
     	                   	<th style="width:15%"><?php _e( "Last Name", bookings_plus ); ?></th>
                           	<th style="width:15%"><?php _e( "Email Address", bookings_plus ); ?></th>
                           	<th style="width:15%"><?php _e( "Mobile", bookings_plus ); ?></th>
                           	<th style="width:10%"><?php _e( "City", bookings_plus ); ?></th>
		                   	<th style="width:15%"><?php _e( "Country", bookings_plus ); ?></th>
		                	<th style="width:18%"></th>
	                    </tr>
                    </thead>
  		 	        <tbody>
  		 		   	<?php
  		 		   		
			      		$customers = $wpdb->get_results
				  		(
						   	$wpdb->prepare
						   	(
						    	"SELECT * FROM ".customersTable()." LEFT OUTER JOIN ".countriesTable()." on ".customersTable().".CustomerCountry = ".countriesTable().".CountryId " 
						    )
				        );
				        for($flag=0; $flag < count($customers); $flag++)
				        {
				        ?>
							<tr>
								<td><?php echo $customers[$flag] -> CustomerFirstName;?></td>
							    <td><?php echo $customers[$flag] -> CustomerLastName;?></td>
							    <td><?php echo $customers[$flag] -> CustomerEmail;?></td>
							    <td><?php echo $customers[$flag] -> CustomerMobile;?></td>
							    <td><?php echo $customers[$flag] -> CustomerCity;?></td>
							    <td><?php echo $customers[$flag] -> CountryName;?></td>
								<td>
							    	<a class="icon-edit fancybox hovertip"  data-original-title="<?php _e("Edit Client?", bookings_plus ); ?>" data-placement="top" href="#EditCustomer" onclick="editCustomers(<?php echo $customers[$flag]->CustomerId;?>);"></a>&nbsp;&nbsp;
							      	<a class="icon-envelope hovertip"  data-original-title="<?php _e("Email Client?", bookings_plus ); ?>" data-placement="top" href="#customerEmail" onclick="emailCustomer(<?php echo $customers[$flag]->CustomerId;?>);" data-toggle="modal"></a>&nbsp;&nbsp;
							      	<a class="icon-calendar fancybox hovertip" data-original-title="<?php _e("Booking Details", bookings_plus ); ?>" data-placement="top"  href="#manageBookings" onclick="customerBookingdetails(<?php echo $customers[$flag]->CustomerId;?>)" ></a>&nbsp;&nbsp;							                		
							      	<a class="icon-plus-sign fancybox hovertip" data-original-title="<?php _e("Book a Service", bookings_plus ); ?>" data-placement="top"  href='#bookingLink' onclick="customerData('<?php echo $customers[$flag]->CustomerEmail;?>')" ></a>&nbsp;&nbsp;
							       	<a class="icon-trash hovertip" data-original-title="<?php _e("Delete Client", bookings_plus ); ?>" data-placement="top"   onclick="deleteCustomer(<?php echo $customers[$flag]->CustomerId;?>)"></a>							                									                		
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
<div id="EditCustomer" style="width:900px;display:none">
	<div class="modal-header">	
	    <h5><?php _e( "Edit Customer ", bookings_plus ); ?> - <span id="editCustomerName"></span></h5>
    </div>
    <div class="note note-success" id="UpdatesuccessMessage" style="display:none;margin:10px;">
		<strong>
			<?php _e( "Success! The Customer has been Updated Successfully.", bookings_plus ); ?>
		</strong>
	</div>   	
	<form id="uxFrmEditCustomers" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
            <div class="body" id="bindEditCustomer"></div>
	    </div>
	    <input type="hidden" id="CustomerId" value="" />
	    <div class="form-actions" style="padding:0px 10px 10px 0px;">
	   		<input type="submit" data-loading-text="<?php _e("Processing Data...", bookings_plus);?>" id="btnEditClient" value="<?php _e( "Submit & Save Changes", bookings_plus ); ?>"class="btn btn-info pull-right">
	    </div>	    
	</form>
</div>	
<div id="manageBookings" style="width:900px;display:none">
	<div class="modal-header">	
	    <h5><?php _e( "Customer Bookings", bookings_plus ); ?> - <span id="CustomerBookingsSchedule"></span></h5>	    	
    </div>	
	<form id="uxFrmManageBookings" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
            <div class="body" style="padding:0px;">
				<div class="table-overflow">
					<table class="table table-striped" id="data-table-customer-bookings">
						<thead>
							<tr>
								<th><?php _e( "Service", bookings_plus ); ?></th>
								<th><?php _e( "Employee", bookings_plus ); ?></th>
								<th><?php _e( "Date", bookings_plus ); ?></th>
								<th><?php _e( "Time Slot", bookings_plus ); ?></th>
								<th><?php _e( "Status", bookings_plus ); ?></th>
								<th><?php _e( "Date of Booking", bookings_plus ); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody id="bindCustomerBookings"></tbody>
					</table>
				</div>
	    	</div> 
	    </div>	      
	</form>
</div>

<div id="customerEmail" style="width:900px;display:none"  class="modal hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">
		 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>	
	   <h5> <?php _e( "Email to Customer", bookings_plus ); ?> - <span id="CustomerSendEmail"></span></h5> 	
    </div>	
	<form id="uxFrmCustomerDirectEmail" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="uxCustomerDirectEmail" style="display:none">
				<strong>
					<?php _e( "Success! Email has been sent Successfully.", bookings_plus ); ?>
				</strong>
	        </div>
	        <div class="block well" style="margin-top:10px;">
	   			<div class="row-fluid form-horizontal">
		        	<div class="control-group">
		            	<label class="control-label"><?php _e( "Email Subject :", bookings_plus ); ?>
		                    	<span class="req">*</span>
		                </label>
		                <div class="controls">
		                	<input type="text" class="required span12" name="uxFrmCustomerEmailSubject" value="" id="uxFrmCustomerEmailSubject"/>
		                </div>
		            </div>								
					<div class="control-group">        
    				<?php 
    				  
    				 	the_editor($content, $id = 'uxFrmCustomerEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    				?>
					</div>                      
	            </div>
	        </div>
	        <input type="hidden" id="CustomerEmailHidden" value="" />
	        <div class="form-actions" style="padding:10px 0px;">
	        	<input type="submit" value="<?php _e( "Send Email", bookings_plus ); ?>"   class="btn btn-info pull-right">
	        </div>
		</div>
	</form>
	<style type="text/css">
		#uxFrmCustomerEmailTemplate_ifr{height:250px !important;}
	</style>
   
</div>
<div id="customerComments" style="width:700px;display:none">
	<div class="modal-header">	
	    <h5><?php _e( "Customer Comments", bookings_plus ); ?></h5>	    	
    </div>	
	<form id="uxFrmcustomerComments" class="form-horizontal" method="post" action="#">
		<div class="body">
			<div class="note note-success" id="CustomerCommentsSuccess" style="display:none">
				<strong>
					<?php _e( "Success! The Comments has been saved Successfully.", bookings_plus ); ?>
				</strong>
	        </div>
	        
	        <div class="block well" style="margin-top:10px;">
	            <div class="row-fluid form-horizontal">
		        	<div class="control-group">
		            	<label class="control-label"><?php _e( "Comments:", bookings_plus ); ?>
		                	<span class="req">*</span>
		                </label>
		                <div class="controls">
		                	<textarea id="uxCustomerComments" name="uxCustomerComments" rows="5" cols="95" ></textarea>
                   		</div>
                   		<input type="hidden" id="hiddenBookingId" value="" />
		            </div>								
				</div>
	        </div>
	        <div class="form-actions" style="padding:10px 0px;">
	        	<input type="submit" value="<?php _e( "Save Changes", bookings_plus ); ?>"   class="btn btn-info pull-right">
	        </div>
		</div>
	</form>
</div>
<div id="bookingLink" style="display:none;width:800px;">
	<?php
	$countBookingsOption = get_option("count-booking");
 	if($countBooking < $countBookingsOption)
 	{	
		 include_once (plugin_dir_path(__FILE__).'bookingCalendarByCustomer.php');
	}	 
	?>	
</div>
<script type="text/javascript">
	jQuery('#btnEditClient').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
	    }, 1000);
	});
	  
	oTable = jQuery('#data-table-clients1').dataTable
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
	
   	function editCustomers(CustomerId)
	{
		jQuery.ajax
		({
			type: "POST",
			data: "customerId="+CustomerId+"&target=editcustomers&action=getAjaxExecuted",
			url:  ajaxurl,
			success: function(data) 
			{  	
				jQuery("#bindEditCustomer").html(data);
	        	jQuery.fancybox.update();
	        	jQuery('#CustomerId').val(jQuery('#hiddenCustomerId').val());
	        	jQuery('#editCustomerName').html(jQuery('#hiddenCustomerName').val());
	        }
		});
	}
	jQuery(".ui-datepicker-month, .style, .dataTables_length select").uniform({ radioClass: 'choice' });
	jQuery("#uxFrmEditCustomers").validate
	({
		rules: 
		{
			uxEditFirstName: "required",
			uxEditLastName: "required",
			uxEditEmailAddress:
			{
				required:true,
				email:true
			},
			uxEditTelephoneNumber:
			{
				required:false
			},
			uxEditMobileNumber:
			{
				required:false
			},
			uxEditAddress1:
			{
				required:false
			},
			uxEditAddress2:
			{
				required:false
			},
			uxEditCity:
			{
				required:false
			},
			uxEditPostalCode:
			{
				required:false
			},
			uxEditCountry:
			{
					required:false
				},
				uxEditComments:
				{
					required:false
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
	            var CustomerId = jQuery('#CustomerId').val();
		     	var uxEditFirstName = jQuery('#uxEditFirstName').val();
             	var uxEditLastName = jQuery('#uxEditLastName').val();
		     	var uxEditEmailAddress = jQuery('#uxEditEmailAddress').val();
		     	var uxEditTelephoneNumber = jQuery('#uxEditTelephoneNumber').val();
		     	var uxEditMobileNumber = jQuery('#uxEditMobileNumber').val();
		     	var uxEditAddress1 = jQuery('#uxEditAddress1').val();
		     	var uxEditAddress2 = jQuery('#uxEditAddress2').val();
		     	var uxEditCity = jQuery('#uxEditCity').val();
		     	var uxEditPostalCode = jQuery('#uxEditPostalCode').val();
		     	var uxEditCountry = jQuery('#uxEditCountry').val();
		     	var uxEditComments = jQuery('#uxEditComments').val();
		     	jQuery.ajax
		        ({
		        	type: "POST",
		        	data: "uxEditCustomerId="+CustomerId+"&uxEditFirstName="+uxEditFirstName+"&uxEditLastName="+uxEditLastName+
		         	"&uxEditEmailAddress="+uxEditEmailAddress+
		        	"&uxEditTelephoneNumber="+uxEditTelephoneNumber+"&uxEditMobileNumber="+uxEditMobileNumber+"&uxEditAddress1="
		       		+uxEditAddress1+"&uxEditAddress2="+uxEditAddress2+"&uxEditCity="+uxEditCity+"&uxEditPostalCode="+uxEditPostalCode
		       		+"&uxEditCountry="+uxEditCountry+"&uxEditComments="+uxEditComments+"&target=updatecustomers&action=getAjaxExecuted",
		        	url:  ajaxurl,
		        	success: function(data) 
		       		{  

		       			jQuery('#UpdatesuccessMessage').css('display','block');
		            	setTimeout(function() 
		            	{
		                	jQuery('#UpdatesuccessMessage').css('display','none');
		                	var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
		                }, 2000);	
		            }   
		        });  
		    }
		});
		function deleteCustomer(CustomerId) 
	 	{
			bootbox.confirm("Are you sure you want to delete this Client?", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
			        ({
			        	type: "POST",
			        	data: "uxcustomerId="+CustomerId+"&target=DeleteCustomer&action=getAjaxExecuted",
				   		url:  ajaxurl,
				     	success: function(data) 
			        	{  
			        		var checkExist = jQuery.trim(data);
			        		if(checkExist == "bookingExist")
			        		{
			        			bootbox.alert("<?php _e( "You cannot delete this Customer until all Bookings have been deleted.", bookings_plus ); ?>");
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
		
		function customerBookingdetails(id)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "customerId="+id+"&target=customerBooking&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{  
			    	jQuery('#bindCustomerBookings').html(data);

			    	jQuery('#CustomerBookingsSchedule').html(jQuery('#customernameBooKing').val());
			    	jQuery.fancybox.update();
			    }
			});
		}
		
		
		function deleteCustomerBooking(bookingId)
		{
			bootbox.confirm("<?php _e( "Are you sure you want to delete this Booking?", bookings_plus ); ?>", function(confirmed)
			
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.ajax
					({
						type: "POST",
						data: "bookingId="+bookingId+"&target=deleteCustomerBookings&action=getAjaxExecuted",
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
		function customerBookingComments(bookingId)
		{
			jQuery.ajax
			({
				type: "POST",
				data: "bookingId="+bookingId+"&target=customerBookingCommentsId&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{  
					jQuery('#hiddenBookingId').val(bookingId);
					jQuery('#uxCustomerComments').val(data);
				}
			});
		}
		jQuery("#uxFrmcustomerComments").validate
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
	            var uxCustomerComments = jQuery('#uxCustomerComments').val();
	            var uxCustomerbookingComments  = encodeURIComponent(uxCustomerComments);
	            var bookingId = jQuery('#hiddenBookingId').val();
	           	jQuery.ajax
		        ({
		        	type: "POST",
		         	data: "uxCustomerComments="+uxCustomerbookingComments+"&bookingId="+bookingId+"&target=updateCustomersComments&action=getAjaxExecuted",
		        	url:  ajaxurl,
		        	success: function(data) 
		       		{  
		            	jQuery('#CustomerCommentsSuccess').css('display','block');
		            	setTimeout(function() 
		            	{
		                	jQuery('#CustomerCommentsSuccess').css('display','none');
		                	var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
		                }, 2000);
		                		
		            }   
		       });  
		    }
		});
		function emailCustomer(id)
		{
			jQuery.ajax
		    ({
		       	type: "POST",
		       	data: "customerId="+id+"&target=emailCustomerContent&action=getAjaxExecuted",
		       	url:  ajaxurl,
		       	success: function(data) 
		    	{
		    		
					jQuery('body').append(data);
		    		jQuery('#CustomerSendEmail').html(jQuery('#hiddencustomerName').val());
		    		jQuery('#CustomerEmailHidden').val(jQuery('#hiddencustomerEmail').val());
		    		
		    		
		    	}
		    });  
		}
		jQuery("#uxFrmCustomerDirectEmail").validate
		({
			rules: 
			{
				uxFrmCustomerEmailSubject:"required",
				uxFrmCustomerEmailTemplate:"required"	
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
				var uxFrmCustomerEmailSubject =  encodeURIComponent(jQuery("#uxFrmCustomerEmailSubject").val());
				var uxFrmCustomerEmailTemplate = encodeURIComponent(tinyMCE.get('uxFrmCustomerEmailTemplate').getContent());
				//alert(uxFrmCustomerEmailTemplate);
				jQuery.ajax
			    ({
			       	type: "POST",
			       	data: "uxFrmCustomerEmailSubject="+uxFrmCustomerEmailSubject+"&uxFrmCustomerEmailTemplate="+uxFrmCustomerEmailTemplate+
			       	"&emailId="+jQuery('#CustomerEmailHidden').val()+"&target=dirctEmailCustomer&action=getAjaxExecuted",
			       	url:  ajaxurl,
			       	success: function(data) 
			    	{
			    		jQuery('#uxCustomerDirectEmail').css('display','block');
			    		setTimeout(function() 
			    		{
			        		jQuery('#uxCustomerDirectEmail').css('display','none');
			        		var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
			        	}, 2000);
			    	}
			    });
		     	
			}
		});	
		jQuery('#btnNextStep').live('click',function()
		{
			var block = 'block';
			var step1Action = jQuery('#serviceGrid').css('display');
			var step2Action = jQuery('#staffGrid').css('display');
			var step3Action = jQuery('#calendarGrid').css('display');
			var step4Action = jQuery('#formGrid').css('display');
			var step5Action = jQuery('#confirmGrid').css('display');
			
			switch(block)
			{
				case step1Action:
					if(!nextSelectEmployee())
					{
						break;						
					}
					else
					{										
						jQuery('#serviceGrid').css('display','none');			
						jQuery('#staffGrid').css('display','block');
						jQuery('#step1Menu').removeAttr('class');					
						jQuery('#step2Menu').attr('class','active');
						jQuery('#btnBackStep').css('display','block');
						jQuery.fancybox.update();		
					}					
						break;
				case step2Action:
				
						var employeeId = jQuery('input:radio[name=radioEmployees]:checked').val();
						if(employeeId != undefined)
						{
							jQuery('#staffGrid').css('display','none');			
							jQuery('#calendarGrid').css('display','block');
							jQuery('#step2Menu').removeAttr('class');					
							jQuery('#step3Menu').attr('class','active');
							CalendarBind();
							var date = new Date();
							if(employeeId != jQuery('#hdEmployeeId').val())
							{
								funcBindTime(date.getFullYear()+'-'+(date.getMonth() + 1)+'-'+date.getDate());
								
							}
						}										
						else
						{
							bootbox.alert("<?php _e( "Please choose atleast one Staff Member.", bookings_plus ); ?>");
							return false;
						}						
						break;
						
				case step3Action:
						
						if(jQuery("#hdDate").val() == "")
						{
								bootbox.alert("<?php _e( "Please choose atleast Booking Date.", bookings_plus ); ?>");
								return false;
						}
						else if(jQuery("#hdTimeControlValue").val() == "")
						{
								bootbox.alert("<?php _e( "Please choose atleast Booking Time.", bookings_plus ); ?>");
								return false;
						}
						else
						{
								jQuery('#calendarGrid').css('display','none');			
								jQuery('#formGrid').css('display','block');
								jQuery('#step3Menu').removeAttr('class');					
								jQuery('#step4Menu').attr('class','active');
								jQuery.fancybox.update();	
								
						}
													
						break;
						
				case step4Action:
				
						_validator = jQuery("#uxBookingFrm").valid();   
						if(_validator)
						{		
							jQuery('#formGrid').css('display','none');			
							jQuery('#confirmGrid').css('display','block');
							jQuery('#step4Menu').removeAttr('class');					
							jQuery('#step5Menu').attr('class','active');
							
						}
						jQuery.fancybox.update();								
							break;
							
							
				case step5Action:
						insertCustomer();					
						jQuery('#confirmGrid').css('display','none');
						jQuery('#thankyouGrid').css('display','block');
						jQuery('#btnBackStep').css('display','none');
						jQuery('#btnNextStep').css('display','none');					
						jQuery('#navBookNow').css('display','none');
						jQuery('#navThankyou').css('display','block');
						break;
			}		
		});
			
		jQuery('#btnBackStep').live('click',function()
		{
			var block = 'block';
			var step1Action = jQuery('#serviceGrid').css('display');
			var step2Action = jQuery('#staffGrid').css('display');
			var step3Action = jQuery('#calendarGrid').css('display');
			var step4Action = jQuery('#formGrid').css('display');
			var step5Action = jQuery('#confirmGrid').css('display');
			
			switch(block)
			{
	
				case step2Action:
						
						jQuery('#staffGrid').css('display','none');			
						jQuery('#serviceGrid').css('display','block');
						jQuery('#step2Menu').removeAttr('class');					
						jQuery('#step1Menu').attr('class','active');
						jQuery('#btnBackStep').css('display','none');
						jQuery.fancybox.update();					
						break;
				case step3Action:
						jQuery('#calendarGrid').css('display','none');			
						jQuery('#staffGrid').css('display','block');
						jQuery('#step3Menu').removeAttr('class');					
						jQuery('#step2Menu').attr('class','active');
						jQuery.fancybox.update();								
						break;
				case step4Action:
						jQuery('#formGrid').css('display','none');			
						jQuery('#calendarGrid').css('display','block');
						jQuery('#step4Menu').removeAttr('class');					
						jQuery('#step3Menu').attr('class','active');
						jQuery.fancybox.update();								
						break;		
				case step5Action:
						jQuery('#formGrid').css('display','block');
						jQuery('#confirmGrid').css('display','none');
						jQuery('#step5Menu').removeAttr('class');					
						jQuery('#step4Menu').attr('class','active');
						jQuery.fancybox.update();							
						break;
			}		
		});    
	jQuery('.timeCol').live('click',function()
	{
		jQuery(".timeCol").each(function()
		{
			jQuery(this).attr('style','');
	
		});
		jQuery(this).attr('style','background-color:rgb(174, 199, 30) !important;color:#fff !important');
		jQuery('#hdTimeControl').val(jQuery(this).html());
		jQuery('#hdTimeControlValue').val(jQuery(this).attr('value'));
		
	});
	oTable = jQuery('#services-table-grid2').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": 't<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "<span>Show entries:</span> _MENU_"
		},
		"aaSorting": [[ 3, "asc" ]]
		
	});
	function customerData(email)
	{
		
		jQuery('#uxTxtControl1').val(email);
		jQuery('#uxTxtControl1').attr('disabled','disabled');
		checkExistingCustomerBooking();
		
	}
</script>    	
