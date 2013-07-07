<?php
error_reporting(0);
/*
Plugin Name: Bookings Plus[Restricted Version]
Plugin URI: http://bookings-plus.com
Description: The Bookings Plus is an Advanced Booking Calendar Plugin that will enable Wordpress running sites to manage all their business bookings/appointments from one place.
Author: Bookings Plus
Version: 1.0.2
Author URI: http://bookings-plus.com
Copyright 2013 Bookings-Plus.com (email : info@bookings-plus.com)
*/

define( 'bookings_plus', 'bookings_plus' );
function createDatabaseHook()
 {
 	
 	require_once 'installPlugin.php';
 	$version = get_option('booking-plus-version-number');
	if($version == "")
	{
		update_option('booking-plus-version-number','1.0.1');
		royalBookingSystemInstall();
	}
	else if($version == "1.0.0")
	{
		update_option('booking-plus-version-number','1.0.1');
	}
	else if($version == "1.0.1")
	{

	}
 }

function deleteDatabaseHook()
 {
 	global $wpdb;
	$sql = "DROP TABLE " . servicesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . employeesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . services_AllocationTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . employees_TimingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . customersTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . currenciesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . countriesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . email_templatesTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . social_Media_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . payment_Gateway_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . auto_Responders_settingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . generalSettingsTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . blockTimeTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . blockDateTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . bookingTable();
    $wpdb->query($sql);
	
	$sql = "DROP TABLE " . bookingFormTable();
    $wpdb->query($sql);
	delete_option('count-employee');
	delete_option('count-services');
	delete_option('count-customer');
	delete_option('count-booking');
	delete_option('bp_AdminEmail');
	delete_option( 'booking-plus-version-number' ); 
 }
function servicesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Services';
}
function employeesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Employees_Details';
}
function services_AllocationTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Services_Allocation';
}
function employees_TimingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Employees_Timings';
}
function customersTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Customers';
}
function currenciesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Currencies';
}
function countriesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_Countries';
}
function email_templatesTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_email_templates';
}
function social_Media_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_social_media_Settings';
}
function payment_Gateway_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_payment_gateway_Settings';
}
function auto_Responders_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_auto_responders_settings';
}
function generalSettingsTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_general_settings';
}
function blockTimeTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_block_time';
}
function blockDateTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_block_date';
}
function bookingTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_booking';
}
function bookingFormTable()
{
	global $wpdb;
	return $wpdb->prefix . 'bp_booking_form';
}
function createPluginMenus() 
{
	$icon_path = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__));
    add_menu_page('Bookings Plus', 'Bookings Plus', 'manage_options', 'manageBookings', 'manageBookings', $icon_path . '/icon.png');
    $manageBookings = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'baseFunction', 'baseFunction');
	$manageEmployees = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageEmployees', 'manageEmployees');	
	$manageServices = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageServices', 'manageServices');
	$manageCustomers = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageCustomers', 'manageCustomers');
	$manageBookingForm = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageBookingForm', 'manageBookingForm');	
	$manageReports = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageReports', 'manageReports');	
	$manageSettings = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageSettings', 'manageSettings');
	$manageReportBug = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageReportBug', 'manageReportBug');		
	$manageAffiliates = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'manageAffiliates', 'manageAffiliates');
	$manageliveSupport = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'liveSupport', 'liveSupport');
	$manageQuickStart = add_submenu_page('Bookings Plus', 'Bookings Plus','', 'manage_options', 'bp_send_data', 'bp_send_data');
}
function enqueue_css_func() 
{
    wp_enqueue_style('main', plugins_url('/css/main.css', __FILE__));

}
function global_enqueue_js_func()
{
 	wp_enqueue_style('bookingForms', plugins_url('/css/bookingForms.css', __FILE__));
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-draggable');	
	wp_enqueue_script('jquery.uniform.min.js', plugins_url('/js/plugins/forms/jquery.uniform.min.js',__FILE__));
	wp_enqueue_script('jquery.maskedinput.min.js', plugins_url('/js/plugins/forms/jquery.maskedinput.min.js',__FILE__));

	wp_enqueue_script('jquery.dataTables.min.js', plugins_url('/js/plugins/tables/jquery.dataTables.min.js',__FILE__));
	wp_enqueue_script('jquery.validate.js', plugins_url('/js/plugins/forms/jquery.validate.js',__FILE__));
	wp_enqueue_script('bootstrap.min.js', plugins_url('/js/plugins/bootstrap/bootstrap.min.js',__FILE__));
	wp_enqueue_script('bootstrap-bootbox.min.js', plugins_url('/js/plugins/bootstrap/bootstrap-bootbox.min.js',__FILE__));	
	wp_enqueue_script('bootstrap-colorpicker.js', plugins_url('/js/plugins/bootstrap/bootstrap-colorpicker.js',__FILE__));
	wp_enqueue_script('fancybox', plugins_url('/source/jquery.fancybox.js',__FILE__));
	wp_enqueue_style('fancybox-css', plugins_url('/source/jquery.fancybox.css', __FILE__));
	wp_enqueue_script('jquery_ui_custom.js', plugins_url('/js/jquery_ui_custom.js',__FILE__));	
	wp_enqueue_script('jquery_pretify.js', plugins_url('/js/plugins/ui/prettify.js',__FILE__));

	
}

function liveSupport() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	
?>	
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});	
	</script>
	</div>
<?php
}
function baseFunction() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'dashboard.php';
?>	
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});	
	</script>
	</div>
<?php
}
function manageBookings() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	wp_enqueue_script('jquery.fullcalendar.min.js', plugins_url('/js/plugins/ui/jquery.fullcalendar.min.js',__FILE__));
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageBookings.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";
		jQuery("#Bookings").attr("class","active");  	
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});
		jQuery('.popover-test').popover
		({
			placement: 'left'
		});	
	</script>
	</div>
<?php
}
function manageEmployees() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageEmployees.php';
?>

	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Employees").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});		
	</script>	
	</div>
	
<?php
}
function manageServices() 
{
	wp_enqueue_script('jquery-ui-sortable');		

?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageServices.php';
?>	
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Services").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});	
	</script>
	</div>
<?php
}
function manageCustomers() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	wp_enqueue_script('editor');
	add_thickbox();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('word-count');
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageCustomers.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Customers").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});				
	</script>	
	</div>
<?php
}
function manageBookingForm() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	
	wp_enqueue_script('editor');
	add_thickbox();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('word-count');
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'bookingForm.php';
	
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#BookingForm").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});		
	</script>	
	</div>
<?php
}
function manageReports() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Reports").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});				
	</script>	
	</div>
	
<?php
}

function manageSettings() 
{
?> 	
	<div class="wrapper three-columns">
<?php
	wp_enqueue_script('editor');
	add_thickbox();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('word-count');
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageSettings.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Settings").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});				
	</script>	
	</div>
	
<?php
}
function manageReportBug()
{
	?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageReportBug.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#ReportBug").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});		
	</script>	
	</div>
<?php
}
function manageAffiliates()
{
	?> 	
	<div class="wrapper three-columns">
<?php
	include_once 'header.php';
	include_once 'leftMenus.php';
	include_once 'manageAffiliates.php';
?>
	<script>
		var uri = "<?php echo $url; ?>";  	
		jQuery("#Affiliates").attr("class","active");
		jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });		
		jQuery('.hovertip').tooltip();
		jQuery('.tooltips, .table, .icons').tooltip
		({
			selector: "a[rel=tooltip]"
		});				
	</script>	
	</div>
<?php
}

function plugin_load_textdomain() 
{
	if( function_exists( 'load_plugin_textdomain' ) )
	{
		load_plugin_textdomain(bookings_plus, false, dirname( plugin_basename( __FILE__ ) ) .'/languages' );
	}

}

function bookingShortCode( $atts, $content = null ) {
   extract(shortcode_atts(array(
	"color" => 'blue',
        "size" => '14px',
        "padding" => '0px',
		"service" => '',
	), $atts));   
  return bp_send_data($service,$color,$padding,$size,$content);
}  
function bp_send_data($service_clicked,$color,$padding,$size,$content) 
{
	$url = plugins_url('', __FILE__);
?>
	
	<script>
		
		jQuery(document).ready(function()
		{
			jQuery('.fancybox').fancybox();
			jQuery(".ui-datepicker-month, .style, .dataTables_length, select").uniform({ radioClass: 'choice' });
		});
		
		oTable = jQuery('#services-table-grid').dataTable
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
	
	</script>
	
	<?php
		if($service_clicked == null)
		{
			?>
			
			<div id="bookingLink" style="display:none;width:800px;">
				<?php
				global $wpdb;
			$countBooking = $wpdb->get_var("SELECT count(BookingId) FROM ".bookingTable());	
			$countBookingsOption = get_option("count-booking");
 			if($countBooking < $countBookingsOption)
 			{
 				include_once (plugin_dir_path(__FILE__).'bookingCalendar.php');		
			}
			else
			{
				?>
				<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/buy-now.png"/></a>
				<?php
			}
			?>
			</div>
			<?php	
			$data = "<a class=\"fancybox\" href='#bookingLink' style='color:$color; padding: $padding; font-size: $size;'>$content</a>";
			
			return $data;
		}
		else 
		{
			?>
			
			<div id="bookingLink2" style="display:none;width:800px;" >
			<?php 
			$countBookingsOption = get_option("count-booking");
 			if($countBooking < $countBookingsOption)
 			{
 				include_once (plugin_dir_path(__FILE__).'bookingCalendarByService.php');	
			}
			else
			{
				?>
				<a href="http://bookings-plus.com/" target="_blank"><img id="screenshot" src="<?php echo $url;?>/images/buy-now.png"/></a>
				<?php		
			}
				?>		
			</div>
			<?php	
			$data = "<a class=\"fancybox\" href='#bookingLink2' style='color:$color; padding: $padding; font-size: $size;'>$content</a>";
			return $data;
		}

}

if(!function_exists('add_my_quicktags'))
{
    function add_my_quicktags()
    {
	?>
        <script type="text/javascript">
        /* Add custom Quicktag buttons to the editor Wordpress ver. 3.3 and above only
         *
         * Params for this are:
         * - Button HTML ID (required)
         * - Button display, value="" attribute (required)
         * - Opening Tag (required)
         * - Closing Tag (required)
         * - Access key, accesskey="" attribute for the button (optional)
         * - Title, title="" attribute (optional)
         * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
         */
       if ( typeof QTags != 'undefined' )
	   {
			QTags.addButton( 'Bookings+ ShortCode', 'Bookings+ ShortCode', '[booking color=#aec71e size=30px padding=5px]BOOK NOW[/booking]');
       }
        </script>
    <?php 
	}
    // We can attach it to 'admin_print_footer_scripts' (for admin-only) or 'wp_footer' (for front-end only)
    add_action('admin_print_footer_scripts',  'add_my_quicktags');
}


function getAjaxExecuted()
{
	global $wpdb;
	include_once 'functions.php'; 
}
	
	function add_button1() 
	{  
		if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
		{  
			add_filter('mce_external_plugins', 'add_plugin1');  
			add_filter('mce_buttons', 'register_button1');  
		}  
	}
    function register_button1($buttons) 
	{  
       array_push($buttons, "quote");  
       return $buttons;  
    }  
	function add_plugin1($plugin_array) 
	{  
       $plugin_array['quote'] = plugins_url('/js/customcodes.js',__FILE__);  
       return $plugin_array;  
    }  
add_action('init', 'add_button1');    
register_activation_hook(__FILE__, 'createDatabaseHook');
register_uninstall_hook(__FILE__, 'deleteDatabaseHook');
add_action('admin_menu', 'createPluginMenus');

add_action('plugins_loaded', 'plugin_load_textdomain');
add_action('init', 'global_enqueue_js_func');
add_action('admin_init', 'enqueue_css_func');
add_shortcode('booking', 'bookingShortCode' );
add_action('admin_init', 'getAjaxExecuted');
?>
