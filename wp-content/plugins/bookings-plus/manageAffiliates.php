<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
?>
<div class="content">
	<div class="body">    	
    	<div class="well-smoke block" style="margin-top:0px">
        	<div class="navbar">
        		<div class="navbar-inner">
             		 <h5><i class="font-hand-right"></i><?php _e("Become an Affiliate", bookings_plus); ?></h5>
            	</div>
			</div>
			<div class="note note-success" id="SuccessReportBug" style="display:none">
				<strong>
					<?php _e("Success! The Email has been sent Successfully.", bookings_plus); ?>
				</strong>
	        </div>
			<div class="well-smoke block"  style="margin:10px">
				<form id="uxFrmReportABug" class="form-horizontal" method="post" action="#">
				<div class="body" style="padding:0px">
				<p style="padding:10px 10px 0px 10px">
				<span class="label label-important"><?php _e( "Are you interested becoming an Affiliate of our Product? Shoot us an email by filling the form below, and we will setup a discussion call.", bookings_plus ); ?>
					 				
			</p>
			<p style="padding:0px 10px 0px 10px">
				<span class="label label-important"><?php _e( "Refer/Sell it to your contacts, and if they purchase from us, we will give you 40% of our Profits straight away.	", bookings_plus ); ?>
					
			</p>
					
					
			      			<div class="row-fluid form-horizontal">
			         			<div class="control-group" >
			          				<label class="control-label">
		                 				<?php _e("Your Email Address :", bookings_plus); ?>
		                 				<span class="req">*</span>
		                 			</label>
									<div class="controls">
										<input type="text" class="required span12" name="uxReportEmailAddress" id="uxReportEmailAddress" value=""/>
									</div>
		          				</div>
			          			<div class="control-group" >
			          				<label class="control-label"><?php _e("Subject :", bookings_plus); ?>
		                 				<span class="req">*</span>
		                 			</label>
									<div class="controls">
										<input type="text" class="required span12" name="uxReportSubject" id="uxReportSubject" value=""/>
									</div>
		          	  			</div>		          				
			          			<div class="control-group" >
			          				<label class="control-label"><?php _e("Message :", bookings_plus); ?>
		                 				<span class="req">*</span>
		                 			</label>
									<div class="controls">
										
										<?php 
    				  						the_editor($content, $id = 'uxAffiliate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
    									?>
									</div>
		          	  			</div>          	

			          		</div>    
 
				
							   			
		   				<div class="form-actions" style="padding:10px">
		    				<input type="submit" value="<?php _e("Send Email", bookings_plus); ?>" class="btn btn-info pull-right">
		   				</div> 
	           	</div>
	           		</form>
	           		<style type="text/css">
						#uxAffiliate_ifr{height:250px !important;}
					</style>
	         </div>
		</div>
	</div>
</div>
<script>
	jQuery("#uxFrmReportABug").validate
({
	rules:
	{
		uxReportEmailAddress: 
		{
			required: true,
			email:true
		},
		uxAffiliate: 
		{
			required:true
		},	
		uxReportSubject:"required"
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
	  	    var uxReportEmailAddress = jQuery('#uxReportEmailAddress').val();
	    	var uxReportBug  = encodeURIComponent(tinyMCE.get('uxAffiliate').getContent());
	     	var uxReportSubject = encodeURIComponent(jQuery('#uxReportSubject').val());
	     	jQuery.ajax
		    ({
					type: "POST",
					data: "uxReportEmailAddress="+uxReportEmailAddress+"&uxReportBug="+uxReportBug+"&uxReportSubject="+uxReportSubject+"&target=becomeAff&action=getAjaxExecuted",
					url:  ajaxurl,
		            success: function(data) 
		            {  
		            	jQuery('#SuccessReportBug').css('display','block');
						setTimeout(function() 
					    {
					       	jQuery('#SuccessReportBug').css('display','none');
					      	var checkPage = "<?php echo $_REQUEST['page']; ?>
								";
								window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					}
			});
		}
	});
</script>
