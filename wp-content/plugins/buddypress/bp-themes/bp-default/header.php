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
					<h1 id="logo" role="banner"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img id="jukulogo" src="<?php echo get_home_url(); ?>/wp-content/uploads/2013/10/jukubox-logo-fixed-beta.png" /><?php /*bp_site_name();*/  ?></a></h1>

						<form class="form-search" action="<?php echo bp_search_form_action(); ?>" method="post" id="search-form">
<div class="input-append"/>
							<label for="search-terms" class="accessibly-hidden"><?php _e( 'Search for:', 'buddypress' ); ?></label>
							<input class="span3 search-query" type="text" id="search-terms" placeholder="Search teacher, style or instrument" name="search-terms" value="<?php echo isset( $_REQUEST['s'] ) ? esc_attr( $_REQUEST['s'] ) : ''; ?>" />


<button type="submit" class="btn btn-invisible" name="search-submit" id="search-submit" value="Search">
<i class="icon-search"></i>
</button>
</div>
							<?php  echo bp_search_form_type_select(); ?>

							<!-- <input type="submit" name="search-submit" id="search-submit" value="<?php _e( 'Search', 'buddypress' ); ?>" /> -->

							<?php wp_nonce_field( 'bp_search_form' ); ?>

							<?php //echo bp_search_form_type_select(); ?>
							<?php //wp_nonce_field( 'bp_search_form' ); ?>


<?php if( is_user_logged_in() ) :
      global $current_user;
      get_currentuserinfo();
      $username_for_envelope = $current_user->user_login; ?>

<a id="header_messages" href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/messages'; ?>"<i class="icon-envelope icon-2x"></i>

<?php $head_unread_msg = messages_get_unread_count();
if($head_unread_msg !== 0) :
 ?>

<div id="header_unread"><?php echo $head_unread_msg; ?></div>

<?php endif; ?>

</a>


<a id="header_friends" href="<?php echo get_home_url() . '/members/' . $username_for_envelope . '/friends/requests'; ?>"<i class="icon-user icon-2x"></i>

<?php $head_requests = bp_friend_get_total_requests_count();
if( $head_requests !== 0) :
 ?>

<div id="header_requested"><?php echo $head_requests; ?></div>

<?php endif; ?>

</a>




<?php endif; ?>

</div>
						</form><!-- #search-form -->

				<?php do_action( 'bp_search_login_bar' ); ?>

				</div><!-- .padder -->
			</div><!-- #search-bar -->

			<div id="navigation" role="navigation">
			    <div id="nav_wrapper">
				<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?>
			    </div><!-- end nav_wrapper --> 
			</div>

<div id="login_fancy">
	<?php echo do_shortcode("[sp_login_shortcode]"); ?>
</div>

<div id="members-only-header" style="display:none;">
</div>

			<?php do_action( 'bp_header' ); ?>

		</div><!-- #header -->

		<?php do_action( 'bp_after_header'     ); ?>
		<?php do_action( 'bp_before_container' ); ?>

		<div id="container">
