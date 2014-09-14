<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php  

date_default_timezone_set('America/New_York'); 

/*
$nowie = date("l, F j, Y, g:i a e", time() ); 
echo $nowie;*/  
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php if ( current_theme_supports( 'bp-default-responsive' ) ) : ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php endif; ?>
		<meta property=”og:image” content=”<?php echo get_home_url(); ?>/wp-content/uploads/2013/07/Juku_J_logo4.jpg” /> 
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

		<?php do_action( 'bp_head' ); ?>
		
		<?php wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/carouFredSel-6.2.1/jquery.carouFredSel-6.2.1-packed.js' ); ?>
				
		<?php wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/bxslider/jquery.bxslider.min.js' ); ?>
			
		<?php wp_enqueue_style( 'bxslider_css', get_template_directory_uri() . '/bxslider/jquery.bxslider.css' ); ?>
	
		<?php /*wp_enqueue_script( 'jqueryui', get_template_directory_uri() . '/jquery-1.9.1.js' );*/  ?>
		<?php wp_enqueue_script( 'color', get_template_directory_uri() . '/jquery-color-master/jquery.color.js' ); ?>
		
		<?php wp_enqueue_script( 'price', get_template_directory_uri() . '/jquery-price-format/jquery.price_format.1.8.min.js' ); ?>
		
		<?php wp_enqueue_style( 'bootstrap_css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' ); ?>	
		<?php wp_enqueue_script( 'bootstrap_js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js' ); ?>
	<?php wp_head(); ?>
		
		
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/finch_custom_style.css" />
		 
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/jschwarz_custom_style.css" /> 
		<link rel="shortcut icon" type="image/x-icon" href="../../../../wp-content/uploads/2013/06/favicon.ico?v=2"> 
		<link rel="stylesheet" href="../../../../wp-content/plugins/buddypress/bp-themes/bp-default/font-awesome/css/font-awesome.min.css">



<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?27lEOQpllT1OqCvadmkEEHcmN4LArVql';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->



	</head>
<body <?php body_class(); ?> id="bp-default">

<?php require_once('finch_cust_func.php'); ?>
<?php require_once('finch_cust_js.php'); ?>
<?php require_once('finch_header.php'); ?>
<?php if(is_page('lesson-room')) { 

	require_once('finch_opentok_custom.php'); 


} 
?>
<?php
/* 
global $bp;
$the_user_ideeznuts = $bp->loggedin_user->userdata->ID; 
$the_user_login = $bp->loggedin_user->userdata->user_login;


$user_bio = bp_get_profile_field_data('field=6&user_id=' . $the_user_ideeznuts . '') ;

echo '<script> alert("' . $the_user_ideeznuts . ' and userlogin: ' . $the_user_login . '  and userbio: ' . $user_bio . '"); </script>'; 


$the_user_id = get_current_user_id(); 


// bp_member_latest_update();
//bp_member_   

//bp_get_profile_field_data( 'field=Biographical Information' );

$get_profile_meta = "SELECT 
				wp_bp_xprofile_data.*, 
				wp_bp_xprofile_fields.*

 			FROM
				wp_bp_xprofile_data
			INNER JOIN
				wp_bp_xprofile_fields
			ON
				wp_bp_xprofile_data.field_id = wp_bp_xprofile_fields.id
			WHERE
				wp_bp_xprofile_data.user_id = '" . $the_user_id . "'"; 
	$get_meta_query = mysql_query($get_profile_meta) or die (mysql_error()); 	while( $row = mysql_fetch_assoc($get_meta_query) ) 
	{ 
		$meta_data[] = $row; 

	} 	
echo '<pre>'; 
	print_r($meta_data); 
echo '</pre>'; */ 
?>
		<?php do_action( 'bp_before_header' ); ?>

		<div id="header">
			<div id="search-bar" role="search">
				<div class="padder">
					<h1 id="logo" role="banner"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img id="jukulogo" src="<?php echo get_home_url(); ?>/wp-content/uploads/2014/05/jukubox-logo-large.png" /><?php /*bp_site_name();*/  ?></a></h1>

						<form class="form-search" action="<?php echo bp_search_form_action(); ?>" method="post" id="search-form">
<div class="input-append"/>
							<label for="search-terms" class="accessibly-hidden"><?php _e( 'Search for:', 'buddypress' ); ?></label>
							<input class="span3 search-query" type="text" id="search-terms" placeholder="Search teacher, style or instrument" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />


<button type="submit" class="btn btn-invisible" name="search-submit" id="search-submit" value="Search">
<i class="icon-search"></i>
</button>
</div> <!-- .input_append -->
							<?php  echo bp_search_form_type_select(); ?>

							<!-- <input type="submit" name="search-submit" id="search-submit" value="<?php _e( 'Search', 'buddypress' ); ?>" /> -->

							<?php wp_nonce_field( 'bp_search_form' ); ?>

							<?php //echo bp_search_form_type_select(); ?>
							<?php //wp_nonce_field( 'bp_search_form' ); ?>

<a class="head_link" href="<?php echo get_home_url() . '/teachers'; ?>">Teachers</a>
<a class="head_link" href="<?php echo get_home_url() . '/category/articles'; ?>">Blog</a>

<?php if( ! is_user_logged_in() ) : ?>
<a id="login_head">Login</a>
<?php endif; ?>



<?php if( is_user_logged_in() ) : ?>

<!--<a class="head_link" href="<?php // echo get_home_url() . '/create-a-room'; ?>"><i class="icon-desktop icon-large"></i></a>
-->

<a class="head_link" href="<?php echo get_home_url() . '/download'; ?>"><i class="icon-download icon-large"></i></a>

<?php
      global $current_user;
      get_currentuserinfo();
      $username_for_envelope = $current_user->user_login; ?>
      <?php $head_unread_msg = messages_get_unread_count(); ?>
      <?php $head_requests = bp_friend_get_total_requests_count(); ?>








<?php if( is_teacher($user_id)===TRUE ) :
        $appointments_query = "SELECT
                                        * 
                                FROM
                                        wp_app_appointments
                                WHERE
                                        worker = " . $user_id . " 
                                AND
                                        status IN ('pending', 'paid')  
                                AND
                                        start >= NOW()
                                ";
        $appointments_array = finch_mysql_query($appointments_query, "return");
        //finch_mysql_query($appointments_query, "display"); 

        if( $appointments_array) {
	}
        
        $num_confirm_appointments = 0;
	foreach( $appointments_array as $key => $value ) {
                if( $value['status'] == 'pending') {
                        // appointment is pending - does it require payment?
                        $service_id = $value['service'];

                        if(is_paid_service($service_id) === FALSE) {
                                $add_service = TRUE;
                                $num_confirm_appointments++;
                        }
                        else {
                                $add_service = FALSE;

                                // NHF - added this in - paid services that are pending
                                        // must also be included in count
                                $num_confirm_appointments++;
                        }   // end if/else                              

                } // end if
                else  // isn't pending, must be paid
                {
                        $num_confirm_appointments++;
                }
        } // end foreach

else:
	$num_confirm_appointments = 0;
endif;

$notify_total = $head_unread_msg + $head_requests + $num_confirm_appointments;

?>











<div id="notify_nav_menu">
        <h5 class="notify_dropper"><i class="icon-bell icon-large"></i>
	<?php if($notify_total !== 0) : ?>
                <span id="notify_total"><?php echo $notify_total;?></span>
	<?php endif; ?>
<?php echo ' ' . bp_get_loggedin_user_fullname();?></h5>
	<div id="nav_menu_box">
		<ul id="menu_box_links">
			<li><a href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/profile'; ?>"><h5><i class="icon-user icon-large"></i><span class="notify_text">  Profile</span></h5></a></li>




                        <li>
                        <?php if( is_teacher($user_id)===TRUE ) : ?>

                                <a href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/appointments'; ?>">
                        <?php else : ?>
                                <a href="<?php echo get_home_url(); ?>">
                        <?php endif; ?>
                        <h5><i class="icon-calendar icon-large"></i><span class="notify_text">
                        <?php if(( is_teacher($user_id)===TRUE ) && ( $num_confirm_appointments !== 0 )) : ?>
                                <?php echo '  Lesson Requests (' . $num_confirm_appointments . ')' ; ?>
                        <?php elseif(( is_teacher($user_id)===TRUE ) && ( $num_confirm_appointments === 0 )) : ?>
                                <?php echo '  Lesson Requests'; ?>
                        <?php else : ?>
                                <?php echo '  Lessons'; ?>
                        <?php endif; ?>


                        </span></h5></a></li>





			<li><a href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/messages'; ?>"><h5><i class="icon-envelope icon-large"></i><span class="notify_text">  Messages

                        <?php if($head_unread_msg !== 0) : ?>
				(<?php echo $head_unread_msg; ?>)
			<?php endif; ?>
			</span></h5></a></li>

                        <li><a href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/friends/requests'; ?>"><h5><i class="icon-group icon-large"></i><span class="notify_text">  Studio Requests

                        <?php if($head_requests !== 0) : ?>
                                (<?php echo $head_requests; ?>)
                        <?php endif; ?>
                        </span></h5></a></li>

			<li><a href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/settings'; ?>"><h5><i class="icon-gear icon-large"></i><span class="notify_text">  Settings</span></h5></a></li>
			
			<li><a href="<?php echo wp_logout_url( wp_guess_url() ); ?>"><h5><i class="icon-eject icon large"></i><span class="notify_text">  Logout</span></h5></a></li>
	
	</ul>
</div> <!-- #nav_menu_box -->
</div> <!-- #notify_nav_menu -->
<?php endif; ?> <!--if logged in -->


						</form><!-- #search-form -->

				<?php do_action( 'bp_search_login_bar' ); ?>


				</div><!-- .padder -->
			</div><!-- #search-bar -->

			<div id="navigation" role="navigation">
			    <div id="nav_wrapper">
				<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?>
			    </div><!-- end nav_wrapper --> 
			</div> <!-- #mavigation -->
<!--<div id="loginFancyBox">
	<div class="login_padder">
	<img src="../../../../wp-content/uploads/2013/10/LoginBox2.png">
	<?php// echo do_shortcode("[sp_login_shortcode]"); ?>
	</div>
</div> -->

<div id="fade_allow">
<div id="loginCenterFancyBox">
</div>
        <div class="login_center_padder">
        	<div class="login_contain">
			<?php echo do_shortcode("[sp_login_shortcode]"); ?>
<!--			<div id="login_x_out"><p>&#10006</p></div>  -->
        	</div> <!-- #login_contain -->
	</div> <!-- #login_center_padder -->
</div> <!-- #fade_allow -->


<div id="members-only-header" style="display:none;">
</div> <!-- #members-only-header -->

			<?php do_action( 'bp_header' ); ?>

		</div><!-- #header -->

		<?php do_action( 'bp_after_header'     ); ?>
		<?php do_action( 'bp_before_container' ); ?>

		<div id="container">
