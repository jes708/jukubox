<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__);


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
		"SELECT * FROM ".bookingFormTable()." where status = 1"
	)
);
?>
<link rel='stylesheet' href="<?php echo $url;?>/css/main.css" type="text/css"/>
<script type="text/javascript" src="<?php echo $url?>/js/plugins/forms/jquery.uniform.min.js"></script>
<style type="text/css">
html, body, div, span, legend
{
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	vertical-align: baseline;
}
body{clear: both;padding:1px; font-size: 12px; line-height: 22px; color: #5f5f5f; height: 100%;}

img { border: none; }
textarea { overflow: auto; }
textarea, input, input[type=text], input[type=password] { font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
button, input[type=submit], input[type=button] { font-family: Arial, Helvetica, sans-serif; cursor: pointer; }
ol, ul { list-style: none; }
blockquote, q { quotes: none; }
blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
a { text-decoration: none; }
*, * focus { outline: none; margin: 0; padding: 0; }
input::-moz-focus-inner { border:0; padding:0 }
.hideControl{display: none !important}



p { margin: 0 0 10px; }
small { font-size: 85%; }
strong { font-weight: bold; }
em { font-style: italic; }
cite { font-style: normal; }
.muted { color: #999999; }
.text-warning { color: #c09853; }
.text-error { color: #b94a48; }
.text-info { color: #3a87ad; }
.text-success { color: #468847; }

h1, h2, h3, h4, h5, h6 { margin: 10px 0; font-family: inherit; font-weight: bold; color: inherit; text-rendering: optimizelegibility; }
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-weight: normal; line-height: 1; color: #999999; margin-left: 12px; }
h1 { font-size: 36px; line-height: 40px; }
h2 { font-size: 30px; line-height: 40px; }
h3 { font-size: 24px; line-height: 40px; }
h4 { font-size: 18px; }
h5 { font-size: 14px; }
h6 { font-size: 12px; }
h1 small { font-size: 24px; }
h2 small { font-size: 18px; }
h3 small { font-size: 14px; }
h4 small { font-size: 14px; }

dt, dd { line-height: 20px; }
dt { font-weight: bold; }
dd { margin-left: 10px; }
.dl-horizontal { *zoom: 1; }
.dl-horizontal:before, .dl-horizontal:after { display: table; content: ""; line-height: 0; }
.dl-horizontal:after { clear: both; }
.dl-horizontal dt { float: left; width: 160px; clear: left; text-align: right; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dl-horizontal dd { margin-left: 180px; }
hr { margin: 20px 0; border: 0; border-top: 1px solid #eeeeee; border-bottom: 1px solid #ffffff; }
abbr[title] { cursor: help; border-bottom: 1px dotted #999999; }
abbr.initialism { font-size: 90%; text-transform: uppercase; }
blockquote { padding: 0 0 0 15px; border-left: 5px solid #eeeeee; }
blockquote p { margin-bottom: 0; font-size: 14px; }
blockquote small { display: block; line-height: 20px; color: #999999; }
blockquote small:before { content: '\2014 \00A0'; }
blockquote.pull-right { float: right; padding-right: 15px; padding-left: 0; border-right: 5px solid #eeeeee; border-left: 0; }
blockquote.pull-right p, blockquote.pull-right small { text-align: right; }
blockquote.pull-right small:before { content: ''; }
blockquote.pull-right small:after { content: '\00A0 \2014'; }
q:before, q:after, blockquote:before, blockquote:after { content: ""; }
code, pre { padding: 0 3px 2px; font-family: Monaco, Menlo, Consolas, "Courier New", monospace; font-size: 12px; color: #333333; }
code { padding: 2px 6px; color: #ca3131; background-color: #f7f7f9; border: 1px solid #e1e1e8; font-size: 11px; }
pre { display: block; padding: 8px; font-size: 12px; line-height: 20px; word-break: break-all; word-wrap: break-word; white-space: pre; white-space: pre-wrap; background-color: #f5f5f5; border: 1px solid #ccc; border: 1px solid rgba(0, 0, 0, 0.15); -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; }
pre code { padding: 0; color: inherit; background-color: transparent; border: 0; }
.pre-scrollable { max-height: 340px; overflow-y: scroll; }

table { max-width: 100%; background-color: transparent; border-collapse: collapse; border-spacing: 0; }
.table { width: 100%; }
.table th, .table td { padding: 8px 12px; line-height: 20px; vertical-align: middle; border-top: 1px solid #e2e2e2; }
.table td { background: #fefefe; }
.table th { font-weight: bold; text-align: left; }
.table thead th { background-color: #f8f8f8; }




fieldset { padding: 0; margin: 0; border: 0; }
legend { display: block; width: 100%; padding: 0; font-size: 16px; line-height: 40px; color: #5F5F5F; border: 0; border-bottom: 1px solid #E5E5E5; box-shadow: 0 1px 0 white; -webkit-box-shadow: 0 1px 0 white; -moz-box-shadow: 0 1px 0 white; font-weight: bold; }
legend small { font-size: 15px; color: #999999; }
label {display: inline-block; }
select, textarea, 
input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"], 
.uneditable-input  { display: inline-block; padding: 8px 7px; font-size: 11px; color: #5F5F5F; font-family: Arial, Helvetica, sans-serif; -webkit-appearance: none !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; -moz-border-radius: 0 !important;  }

input[type="search"] { -webkit-border-radius: 0; -moz-border-radius: 0; -webkit-appearance: none; }
input[disabled], select[disabled], textarea[disabled], input[readonly], select[readonly], textarea[readonly] { cursor: not-allowed; background-color: #f5f5f5; color: #999999; }
input[type=submit][disabled], input[type=button][disabled] { color: #fff; }
input[type="radio"][disabled], input[type="checkbox"][disabled], input[type="radio"][readonly], input[type="checkbox"][readonly] { background-color: transparent; }
textarea { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; -ms-box-sizing: border-box; }
select { width: 220px; height: 30px; padding: 6px; border: 1px solid #cccccc; background-color: #ffffff; }
select:focus { box-shadow: none; -webkit-box-shadow: none; -moz-box-shadow: none; }

textarea, 
input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"], 
.uneditable-input  { background-color: #ffffff; border: 1px solid #dadada; 
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
}

input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"] { height: 30px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; -ms-box-sizing: border-box; }

input[class*="span"], 
select[class*="span"], 
textarea[class*="span"], 
.uneditable-input[class*="span"], 
.row-fluid input[class*="span"], 
.row-fluid select[class*="span"], 
.row-fluid textarea[class*="span"], 
.row-fluid .uneditable-input[class*="span"] { float: none; margin-left: 0; }

.input-append input[class*="span"], 
.input-append .uneditable-input[class*="span"], 
.input-prepend input[class*="span"], 
.input-prepend .uneditable-input[class*="span"], 
.row-fluid input[class*="span"], 
.row-fluid select[class*="span"], 
.row-fluid textarea[class*="span"], 
.row-fluid .uneditable-input[class*="span"], 
.row-fluid .input-prepend [class*="span"], 
.row-fluid .input-append [class*="span"] { display: inline-block; }

input[type="radio"], input[type="checkbox"] { *margin-top: 0; margin-top: 1px \9; line-height: normal; cursor: pointer; }
input[type="file"], input[type="image"], input[type="submit"], input[type="reset"], input[type="button"], input[type="radio"], input[type="checkbox"] { width: auto; }

.uneditable-input, .uneditable-textarea { color: #999999; background-color: #fcfcfc; border-color: #cccccc; -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); cursor: not-allowed; }
.uneditable-input { overflow: hidden; white-space: nowrap; }
.uneditable-textarea { width: auto; height: auto; }

</style>
<div class="span12 well" style="padding:10px 10px" id="headerContent">
	<?php 
			$bookingHeader = $wpdb -> get_var('SELECT GeneralSettingsValue  FROM ' .generalSettingsTable().' where GeneralSettingsKey = "booking-header-message"');
			echo stripslashes($bookingHeader);
	?>
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
		<?php 
			$bookingHeader = $wpdb -> get_var('SELECT GeneralSettingsValue  FROM ' .generalSettingsTable().' where GeneralSettingsKey = "booking-Footer-message"');
			echo stripslashes($bookingHeader);
		?>
	</div>
</div>
<script>
	var uri = "<?php echo $url; ?>";
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';     
	function nextSelectEmployee()
	{
		var serviceId = jQuery('input:radio[name=radioservice]:checked').val();
		if(serviceId != undefined)
		{
			jQuery.ajax
			({
					type: "POST",
					data: "serviceId="+serviceId+"&target=GetEmployees&action=getAjaxExecuted",
					url:ajaxurl,
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
			       		+"&uxEditCountry="+uxCountry+"&target=updatecustomers&comment=no&action=getAjaxExecuted",
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
				data: "serviceId="+serviceId+"&employeeId="+employeeId+"&customerId="+customerId+"&bookingTime="+bookingTime+"&bookingDate="+bookingDate+
				"&target=insertBooking&action=getAjaxExecuted",
				url:  ajaxurl,
				success: function(data) 
				{	
						setTimeout(function() 
						{
							window.location.reload(true);
						}, 3000);
						
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
