<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;

?>
<div class="content">
	<div class="body">    	
    	<div class="well-smoke block" style="margin-top:0px">
        	<div class="navbar">
        		<div class="navbar-inner">
             		 <h5><i class="font-hand-right"></i><?php _e("Report a Bug", bookings_plus); ?></h5>
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
			          				<label class="control-label"><?php _e("Bug / Issue :", bookings_plus); ?>
		                 				<span class="req">*</span>
		                 			</label>
									<div class="controls">
										
										<?php 
    				  						the_editor($content, $id = 'uxReportBug', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
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
						#uxReportBug_ifr{height:250px !important;}
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
		uxReportBug: 
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
	    	var uxReportBug  = encodeURIComponent(tinyMCE.get('uxReportBug').getContent());
	    	
	     	var uxReportSubject = encodeURIComponent(jQuery('#uxReportSubject').val());
	     	jQuery.ajax
		    ({
					type: "POST",
					data: "uxReportEmailAddress="+uxReportEmailAddress+"&uxReportBug="+uxReportBug+"&uxReportSubject="+uxReportSubject+"&target=reportABug&action=getAjaxExecuted",
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
