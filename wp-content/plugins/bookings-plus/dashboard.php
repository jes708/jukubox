<div class="content">
	<div class="body">    			
		<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/dashboard-screenshot.jpg"/></a>
	</div>
</div>

<script type="text/javascript">

	jQuery("#Dashboard").attr("class","active"); 
	if(screen.width > 1366)
	{
		jQuery("#screenshot").attr("width",screen.width - 400);
	}
	else
	{
		jQuery("#screenshot").attr("width",screen.width - 285);
	}    
	
</script> 		
