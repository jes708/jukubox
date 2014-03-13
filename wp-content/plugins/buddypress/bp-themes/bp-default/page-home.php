<?php get_header(); ?>


	<div id="content">

<?php if( !is_user_logged_in() ) : ?>

<a href="<?php echo get_home_url() . '/teachers'; ?>"><section class="f-part-divide black">
    <section class="f-part-wrap preamble" style="max-width: 1000px; margin: 0 auto;">
	<h1 id="Amber_header">Live-video music lessons </br>with the world's best teachers.</h1>
	<p id="White_home_p">Our faculty consists of the world's most respected instructors from the top musical conservatories.</p>
	<img style="bottom:110px; height:430px; position:relative; float:right; right:14px;" src="../../../../../wp-content/uploads/2013/11/Dicterow-Header.jpg"> 	
	<p id="Amber_p">Glenn Dicterow</br><em>Jukubox faculty</em> member</p>


<!-- registration stuff -->

<!--        <div id="content">
                <div class="padder">
-->


                <?php do_action( 'bp_before_register_page' ); ?>

                <div class="page" id="register-page">


<?php global $bp;
if(empty($bp->signup->step))
$bp->signup->step=’request-details’;
?>

                        <form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">

                        <?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>
                                <?php do_action( 'template_notices' ); ?>
                                <?php do_action( 'bp_before_registration_disabled' ); ?>

                                        <p><?php _e( 'User registration is currently not allowed.', 'buddypress' ); ?></p>

                                <?php do_action( 'bp_after_registration_disabled' ); ?>
                        <?php endif; // registration-disabled signup setp ?>

                        <?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

                                <h2><?php _e( 'Create an Account', 'buddypress' ); ?></h2>

                                <?php do_action( 'template_notices' ); ?>

                        <!--    <p><?php _e( 'Registering for this site is easy, just fill in the fields below and we\'ll get a new account set up for you in no time.', 'buddypress' ); ?></p>  -->

<!--                            <p><?php _e( 'Fill out the fields below to start working with the web\'s best musicians!', 'buddypress' ); ?></p> -->

                                <?php do_action( 'bp_before_account_details_fields' ); ?>

                                <div class="register-section" id="basic-details-section">

                                        <?php /***** Basic Account Details ******/ ?>

<!--                                    <h4><?php _e( 'Account Details', 'buddypress' ); ?></h4> -->

                                        <label for="signup_username"><?php _e( 'Username', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                        <?php do_action( 'bp_signup_username_errors' ); ?>
                                        <input type="text" name="signup_username" id="signup_username" value="<?php bp_signup_username_value(); ?>" />



<script>
jQuery("input#signup_username").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

$('input#signup_username').bind('keypress', function (event) {
    var regex = new RegExp("^[^\.]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});

</script>




                                        <!-- NHF edit - included statement about parents if under the age of 14 -->
                                        <label for="signup_email"><?php _e( 'Email Address', 'buddypress' ); ?> <?php _e( '(required - parent\'s email if under age 14)', 'buddypress' ); ?></label>
                                        <?php do_action( 'bp_signup_email_errors' ); ?>
                                        <input type="text" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" />
<div id="su_pw">
                                        <label for="signup_password"><?php _e( 'Choose a Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                        <?php do_action( 'bp_signup_password_errors' ); ?>
                                        <input type="password" name="signup_password" id="signup_password" value="" />
</div>
<div id="su_pw_cf">
                                        <label for="signup_password_confirm"><?php _e( 'Confirm Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                        <?php do_action( 'bp_signup_password_confirm_errors' ); ?>
                                        <input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" />
</div>
                                </div><!-- #basic-details-section -->

                                <?php do_action( 'bp_after_account_details_fields' ); ?>

                                <?php /***** Extra Profile Details ******/ ?>

                                <?php if ( bp_is_active( 'xprofile' ) ) : ?>

                                        <?php do_action( 'bp_before_signup_profile_fields' ); ?>

                                        <div class="register-section" id="profile-details-section">

<!--                                            <h4><?php _e( 'Profile Details', 'buddypress' ); ?></h4> -->

                                                <?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
                                                <?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( 'profile_group_id=1' ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                                <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

                                                        <div class="editfield">

                                                                <?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>

                                                                        <label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
                                                                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                        <input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" />

                                                                <?php endif; ?>

                                                                <?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>

                                                                        <label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
                                                                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                        <textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_edit_value(); ?></textarea>

                                                                <?php endif; ?>

                                                                <?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>

                                                                        <label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
                                                                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                        <select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>">
                                                                                <?php bp_the_profile_field_options(); ?>
                                                                        </select>

                                                                <?php endif; ?>

                                                                <?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>

                                                                        <label for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
                                                                        <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                        <select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" multiple="multiple">
                                                                                <?php bp_the_profile_field_options(); ?>
                                                                        </select>

                                                                <?php endif; ?>

                                                                <?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

                                                                        <div class="radio">
                                                                                <span class="label"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></span>

                                                                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                                <?php bp_the_profile_field_options(); ?>

                                                                                <?php if ( !bp_get_the_profile_field_is_required() ) : ?>
                                                                                        <a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name(); ?>' );"><?php _e( 'Clear', 'buddypress' ); ?></a>
                                                                                <?php endif; ?>
                                                                        </div>

                                                                <?php endif; ?>

                                                                <?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

                                                                        <div class="checkbox">
                                                                                <span class="label"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></span>

                                                                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>
                                                                                <?php bp_the_profile_field_options(); ?>
                                                                        </div>

                                                                <?php endif; ?>

                                                                <?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>

                                                                        <div class="datebox">
                                                                                <label for="<?php bp_the_profile_field_input_name(); ?>_day"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'buddypress' ); ?><?php endif; ?></label>
                                                                                <?php do_action( 'bp_' . bp_get_the_profile_field_input_name() . '_errors' ); ?>

                                                                                <select name="<?php bp_the_profile_field_input_name(); ?>_day" class="span1" id="<?php bp_the_profile_field_input_name(); ?>_day">
                                                                                        <?php bp_the_profile_field_options( 'type=day' ); ?>
                                                                                </select>

                                                                                <select name="<?php bp_the_profile_field_input_name(); ?>_month" class="span2" id="<?php bp_the_profile_field_input_name(); ?>_month">
                                                                                        <?php bp_the_profile_field_options( 'type=month' ); ?>
                                                                                </select>

                                                                                <select name="<?php bp_the_profile_field_input_name(); ?>_year" class="span2" id="<?php bp_the_profile_field_input_name(); ?>_year">
                                                                                        <?php bp_the_profile_field_options( 'type=year' ); ?>
                                                                                </select>
                                                                        </div>

                                                                <?php endif; ?>

                                                                <?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
                                                                        <p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
                                                                                <?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', 'buddypress' ), bp_get_the_profile_field_visibility_level_label() ) ?> <a href="#" class="visibility-toggle-link">Change</a>
                                                                        </p>

                                                                        <div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
                                                                                <fieldset>
                                                                                        <legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

                                                                                        <?php bp_profile_visibility_radio_buttons() ?>

                                                                                </fieldset>
                                                                                <a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>

                                                                        </div>
                                                                <?php else : ?>
                                                                        <p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
                                                                                <?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', 'buddypress' ), bp_get_the_profile_field_visibility_level_label() ) ?>
                                                                        </p>
                                                                <?php endif ?>


                                                                <?php do_action( 'bp_custom_profile_edit_fields' ); ?>

                                                                <p class="description"><?php bp_the_profile_field_description(); ?></p>

                                                        </div>

                                                <?php endwhile; ?>

                                                <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_group_field_ids(); ?>" />

                                                <?php endwhile; endif; endif; ?>

                                        </div><!-- #profile-details-section -->

                                        <?php do_action( 'bp_after_signup_profile_fields' ); ?>

                                <?php endif; ?>

                                <?php if ( bp_get_blog_signup_allowed() ) : ?>

                                        <?php do_action( 'bp_before_blog_details_fields' ); ?>

                                        <?php /***** Blog Creation Details ******/ ?>

                                        <div class="register-section" id="blog-details-section">

                                                <h4><?php _e( 'Blog Details', 'buddypress' ); ?></h4>

                                                <p><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes, I\'d like to create a new site', 'buddypress' ); ?></p>

                                                <div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

                                                        <label for="signup_blog_url"><?php _e( 'Blog URL', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                                        <?php do_action( 'bp_signup_blog_url_errors' ); ?>

                                                        <?php if ( is_subdomain_install() ) : ?>
                                                                http:// <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" /> .<?php bp_blogs_subdomain_base(); ?>
                                                        <?php else : ?>
                                                                <?php echo site_url(); ?>/ <input type="text" name="signup_blog_url" id="signup_blog_url" value="<?php bp_signup_blog_url_value(); ?>" />
                                                        <?php endif; ?>

                                                        <label for="signup_blog_title"><?php _e( 'Site Title', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                                        <?php do_action( 'bp_signup_blog_title_errors' ); ?>
                                                        <input type="text" name="signup_blog_title" id="signup_blog_title" value="<?php bp_signup_blog_title_value(); ?>" />

                                                        <span class="label"><?php _e( 'I would like my site to appear in search engines, and in public listings around this network.', 'buddypress' ); ?>:</span>
                                                        <?php do_action( 'bp_signup_blog_privacy_errors' ); ?>

                                                        <label><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="public"<?php if ( 'public' == bp_get_signup_blog_privacy_value() || !bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes', 'buddypress' ); ?></label>
                                                        <label><input type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="private"<?php if ( 'private' == bp_get_signup_blog_privacy_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'No', 'buddypress' ); ?></label>

                                                </div>

                                        </div><!-- #blog-details-section -->

                                        <?php do_action( 'bp_after_blog_details_fields' ); ?>

                                <?php endif; ?>

                                <?php do_action( 'bp_before_registration_submit_buttons' ); ?>

                                <div class="submit">
                                        <div class="subtext">By clicking Complete Registration, I agree to the Jukubox <a href="http://jukubox.com/terms-of-use/">Terms of Use</a>, including the <a href="http://jukubox.com/privacy-policy/">Privacy Policy</a> and <a href="http://jukubox.com/teachers-manual/">Teacher's Manual</a></div>
                                        <button type="submit" name="signup_submit" class="btn btn-large btn-primary" id="signup_submit"><?php _e( 'Complete Registration', 'buddypress' ); ?></button>
                                </div>

                                <?php do_action( 'bp_after_registration_submit_buttons' ); ?>

                                <?php wp_nonce_field( 'bp_new_signup' ); ?>

                        <?php endif; // request-details signup step ?>

                        <?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

                                <h2><?php _e( 'Sign Up Complete!', 'buddypress' ); ?></h2>

                                <?php do_action( 'template_notices' ); ?>
                                <?php do_action( 'bp_before_registration_confirmed' ); ?>

                                <?php if ( bp_registration_needs_activation() ) : ?>
                                        <p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'buddypress' ); ?></p>
                                <?php else : ?>
                                        <p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'buddypress' ); ?></p>
                                <?php endif; ?>

                                <?php do_action( 'bp_after_registration_confirmed' ); ?>

                        <?php endif; // completed-confirmation signup step ?>

                        <?php do_action( 'bp_custom_signup_steps' ); ?>

                        </form>

                </div>

                <?php do_action( 'bp_after_register_page' ); ?>

               <!--</div>--> <!-- .padder -->
        <!--</div>--><!-- #content -->

        <script type="text/javascript">
                jQuery(document).ready( function() {
                        if ( jQuery('div#blog-details').length && !jQuery('div#blog-details').hasClass('show') )
                                jQuery('div#blog-details').toggle();

                        jQuery( 'input#signup_with_blog' ).click( function() {
                                jQuery('div#blog-details').fadeOut().toggle();
                        });
                });
        </script>


<!-- end registration -->




    </section>
</section></a>
<section class="f-part-divide"> 
    <section class="f-part-wrap" style="max-width: 1049px; margin: 0 auto; position:relative; left:22px;"> 
	<div class="fr-page-banner" id="top-slide" style="background: url(http://jukubox.com/wp-content/uploads/2013/07/Video_Laptop.png) no-repeat left top; height: 350px; width: 100%; margin-top: 35px; margin-bottom: 25px; background-size: 600px 338px; background-position: right 15%;">

<div id="selling-points" style="width: 400px; margin-right: -220px; float: left;">
	<h2>What is Jukubox?</h2>
	<div><i class="icon-music icon-large"></i> <p>1-on-1 music lessons via videoconferencing</p></div>
	<div><i class="icon-headphones icon-large"></i> <p>Professional-grade audio quality</p></div>
	<div><i class="icon-globe icon-large"></i> <p>A roster of world-renowned experts</p></div>
	<div><i class="icon-home icon-large"></i> <p>Convenience and accessibility</p></div>
	<div><i class="icon-wrench icon-large"></i> <p>Built by musicians, for musicians</p></div>	
	<button class="btn btn-large btn-primary login-callup">Sign In</button>
        <button class="btn btn-large btn-primary" onclick="window.location='<?php echo get_home_url(); ?>/register'">Register</button>

</div>

<div id="home-vid" style="float:right; margin-right: 77px;">
                 <iframe width="444" height="265" src="//www.youtube.com/embed/vN0OzvCTj7k" style="padding: 26px 0 0 79px; position:relative; z-index:10" frameborder="0" allowfullscreen></iframe>

</div>

<!--    	<div style="background:/*url('wp-content/uploads/2013/05/Backdrop4CroppedColoredRe.jpg')*/   url('wp-content/uploads/2013/07/Backdrop4CroppedColoredRe-1Lower.jpg') no-repeat center top; height: 400px; /*height: 650px;*/  /*background-position: 0% 20%;*/  padding: 40px; margin: 0 auto; background-size: 1500px; background-position: right 43%;" id="top_slide">
	    <div style="width: 1000px; margin: 0 auto;" >
		<h1 style="color: white; font-size: 34px; margin-top: 15px;">Welcome to Jukubox!</h1>
		<h3 style="color: white; width: 390px; line-height: 1.2em; margin-bottom: 0px;">Study music online with your browser and a webcam.</h3>
	        <a href="teachers" id="teacherLink"><h2 style="color: /*#1fb3dd;*/ red; font-weight: bold; background-color: rgba(0,0,0, 0.7);">Find Your Teacher Right Now</h2></a> 
		
	<a href="wp-login.php" class="btn1" id="firstBtn1">Log in<img src="wp-content/uploads/2013/06/Arrow.png" /></a>
	<a href="register/" class="btn1">Sign Up<img src="wp-content/uploads/2013/06/Arrow.png" /></a>
	<a href="teachers" class="btn1" id="firstBtn1">Find Your Teacher<img src="wp-content/uploads/2013/06/Arrow.png" /></a>
	<br />
	<a href="#" class="btn1">Become a Teacher</a> --> 
	

<script> 
	jQuery('.bx-viewport').each(function() { 
	var height2 = jQuery(this).height(); 
	//alert(height2); 
	}); 
	jQuery('.bx-viewport').each(function() { 
		jQuery(this).height(height2);
	}); // end each
</script>
 
	</div>
    </section>
</section>
<section class="f-part-divide grey"> 
    <section class="f-part-wrap dos">
<!--Schwarz Add-->
<h2 class="jes-big-header">Featured Teachers</h2>
<div id="teach_prof_div">
<div class="container-fluid">
                <div class="row-fluid">

			<ul>

<?php $j = 0; ?>

  <?php	   if ( bp_has_members( 'include=67' ) ) : // NHF CODE CODE ?>

		
	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li>
			<div class="span4" style="float: left;">
			<div class="finchsizer">
                        <a href="<?php bp_member_permalink(); ?>profile"><img class="fTeachImage" src="../../../../wp-content/uploads/2013/10/christine-lamprea-feature.jpg"></a>                        
				<div class="featured-about">
				                        <div class="featured-info">
			<a href="<?php bp_member_permalink(); ?>profile"> <h4><?php  bp_member_name(); ?></h4> </a>
                        <p class="inst_ital"> <?php $user_instruments_raw = bp_get_profile_field_data('field=2&user_id=' . bp_get_member_user_id() . '');
                                        $user_instruments_raw = array_slice( $user_instruments_raw, 0, 4);                                        
					$end_inst = end($user_instruments_raw);
                                        foreach( $user_instruments_raw as $key => $value ) {
                                                $tag = ', ';
                                                if( $value == $end_inst ) {
                                                $tag = '';
                                        }
						?> <a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value ?>"><?php echo $value;?></a><?php echo $tag;?>
<?php

                                        }
                                //print_r( $user_instruments_raw);  ?> 
                            </p>
                        </div>
				<p class="feat_bio"><?php 
				$user_about = bp_get_profile_field_data('field=6&user_id=' . bp_get_member_user_id()  .   '') ;   echo substr( $user_about, 0, 165 ) . "...";  
				  ?></p>
				<a href="<?php bp_member_permalink(); ?>profile" class="home_view_profile">View Profile</a>
				</div>
			</div><!-- finchsizer --> 
			</div>
		</li> 
		
		<?php $j++; ?>
		<!-- 'type=full&width=125&height=125' --> 
	<?php endwhile; ?>
<?php endif; ?>

  <?php    if ( bp_has_members( 'include=31' ) ) : // NHF CODE CODE ?>


        <?php while ( bp_members() ) : bp_the_member(); ?>
                <li>
                        <div class="span4" style="float: left;">
                        <div class="finchsizer">
                        <a href="<?php bp_member_permalink(); ?>profile"><img class="fTeachImage" src="../../../../wp-content/uploads/2013/10/David-Feature-small.jpg"></a>
                                <div class="featured-about">
                                                        <div class="featured-info">
                        <a href="<?php bp_member_permalink(); ?>profile"> <h4><?php  bp_member_name(); ?></h4> </a>
                        <p class="inst_ital"> <?php $user_instruments_raw = bp_get_profile_field_data('field=2&user_id=' . bp_get_member_user_id() . '');
                                        $user_instruments_raw = array_slice( $user_instruments_raw, 0, 4);                                        
					$end_inst = end($user_instruments_raw);
                                        foreach( $user_instruments_raw as $key => $value ) {
                                                $tag = ', ';
                                                if( $value == $end_inst ) {
                                                $tag = '';
                                        }
					?>	<a href="<?php echo get_home_url() . '/teachers/instrument=' . $value ?>"><?php echo $value;?></a><?php echo $tag;?>
<?php

                                        }
                                //print_r( $user_instruments_raw);  ?> 
                            </p>
                        </div>
                                <p class="feat_bio"><?php 
                                $user_about = bp_get_profile_field_data('field=6&user_id=' . bp_get_member_user_id()  .   '') ;   echo substr( $user_about, 0, 165 ) . "...";
                                  ?></p>
                                <a href="<?php bp_member_permalink(); ?>profile" class="home_view_profile">View Profile</a>
                                </div>
                        </div><!-- finchsizer -->
                        </div>
                </li>

                <?php $j++; ?>
                <!-- 'type=full&width=125&height=125' -->
        <?php endwhile; ?>
<?php endif; ?>

  <?php    if ( bp_has_members( 'include=406' ) ) : // NHF CODE CODE ?>


        <?php while ( bp_members() ) : bp_the_member(); ?>
                <li>
                        <div class="span4" style="float: left;">
                        <div class="finchsizer">
                        <a href="<?php bp_member_permalink(); ?>profile"><img class="fTeachImage" src="../../../../wp-content/uploads/2013/10/Bob_Ferrel.jpg"></a>
                                <div class="featured-about">
                                                        <div class="featured-info">
                        <a href="<?php bp_member_permalink(); ?>profile"> <h4><?php  bp_member_name(); ?></h4> </a>
                        <p class="inst_ital"> <?php $user_instruments_raw = bp_get_profile_field_data('field=2&user_id=' . bp_get_member_user_id() . '');
                                        $user_instruments_raw = array_slice( $user_instruments_raw, 0, 4);
					$end_inst = end($user_instruments_raw);
                                        foreach( $user_instruments_raw as $key => $value ) {
                                                $tag = ', ';
                                                if( $value == $end_inst ) {
                                                $tag = '';
                                        }
                                               ?> <a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value ?>"><?php echo $value;?></a><?php echo $tag;?>
<?php
                                        }
                                //print_r( $user_instruments_raw);  ?> 
                            </p>
                        </div>
                                <p class="feat_bio"><?php 
                                $user_about = bp_get_profile_field_data('field=6&user_id=' . bp_get_member_user_id()  .   '') ;   echo substr( $user_about, 0, 165 ) . "...";
                                  ?></p>
                                <a href="<?php bp_member_permalink(); ?>profile" class="home_view_profile">View Profile</a>
                                </div>
                        </div><!-- finchsizer -->
                        </div>
                </li>

                <?php $j++; ?>
                <!-- 'type=full&width=125&height=125' -->
        <?php endwhile; ?>
<?php endif; ?>


</ul>

</div>
</div>
</div>

<!-- End Schwarz Add -->
    </section>
</section>


<section class="f-part-divide"> 
    <section class="f-part-wrap" style="max-width: 1000px;">
	<div id="testimonials">
    	<h1 class="jes-big-header-2">Testimonials</h1>
	<div class="gk-features gk-perspective">
		<h4>Coming Soon!</h4>
		<p> Email general@jukubox.com if you would like your endorsement of Jukubox featured on our homepage!</p>
	</div>
	</div>
<!--    </section>
</section> -->

<!-- <section class="f-part-divide grey"> 
    <section class="f-part-wrap"> -->
<div id="LatestBlog">
        <p class="HomeBlogHead">Latest from the Blog</p>
                <div class="container-fluid">
                <div class="row-fluid">


<?php // get latest articles
        $article_args = array(
                'showposts' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
        );

        $get_articles = new WP_Query($article_args);
        $get_articles = objectToArray($get_articles);
//      print_r($get_articles);  
        $all_arts = $get_articles['posts'];
        $all_arts_array = Array();
        $n = 0;
        foreach( $all_arts as $key => $value ) {                $post_id = $value['ID'];
                $text = $value['post_content'];
                $title = $value['post_title'];
                $author_id = $value['post_author'];
                $link = $value['guid'];
		$p_date = $value['post_date'];

                $all_arts_array[$n]['author_id'] = $author_id;
                $all_arts_array[$n]['title'] = $title;                $all_arts_array[$n]['text'] = $text;
                $all_arts_array[$n]['link'] = $link;
                $all_arts_array[$n]['post_id'] = $post_id;
		$all_arts_array[$n]['p_date'] = $p_date;
		

                $n++;
        }
wp_reset_query();
//      echo '<pre>'; print_r($all_arts_array); echo '</pre>'; 
?>

<ul>

<?php $j = 0; ?>
<!--  <?php    if ( bp_has_members( 'include=9' ) ) : // NHF CODE CODE ?> -->

		
	<?php while ($j <=2): ?>
		<li>
			<?php $curr_id = $all_arts_array[$j]['post_id']; //echo $curr_id; 
				$art_thumb = get_the_post_thumbnail( $curr_id, 'medium' );  
			?>
			<a href="<?php echo $all_arts_array[$j]['link']; ?>"><p class="homeartnames"><?php echo $all_arts_array[$j]['title']; ?></p></a>
                        <a href="<?php bp_member_permalink(); ?>profile"> <h1><?php  bp_member_name(); ?></h1> </a>

<?php $userlink =  bp_core_get_user_domain( $all_arts_array[$j][author_id] ) . "profile/" ; /*echo $userlink;*/
   ?>  

<p class="date-2"><?php printf( __( '%s', 'buddypress' ), mysql2date('M j Y', $all_arts_array[$j][p_date]) ); printf( _x( ' by %s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $all_arts_array[$j][author_id] ) ); ?></p> 

			<!--	<div class="finchsizer"> -->	
<!--						</div> -->


		</li> 
		
		<?php $j++; ?>
		<!-- 'type=full&width=125&height=125' --> 
	<?php endwhile; ?>
<!-- <?php endif; ?> -->
		 
			</ul>
			</div>
		
                 </div>

    
	</div>
</div>
    </section>
</section>



<?php endif; ?>
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h2 class="pagetitle"><?php the_title(); ?></h2>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">



<?php if( is_user_logged_in() )  { ?>
					<div id="loggedin_div">
		<a href="<?php echo bp_loggedin_user_domain(); ?>profile">
		<?php  $av_args = array('item_id' => $user_id, 'type' => 'full'); 
			echo bp_core_fetch_avatar($av_args);  ?>
		</a>
			<div id="homeLoggedTitles">
						<h2 id="toploghome" style="font-size: 37px; text-align: center;  line-height: 1em;"><a href="<?php echo bp_loggedin_user_domain(); ?>profile">Welcome,  <?php echo $finch_user_name; ?>!</a></h2>
						
						<h2 class="toploghome2" align="center" >Account Type: <span id="accTypeText">  
							<?php if( is_teacher($user_id)===TRUE ) { 
									$userType = "Teacher"; 
								}  
							      else { 
									$userType = "Student";
								} 
								echo $userType; 
							 ?>
						</span></h2></div><!--  --> 
					</div><!-- loggedin_div --> 	
						<?php 						
							get_upcoming_lessons($user_id, 15, "Student");
							if( is_teacher($user_id)===TRUE ) {   
								get_upcoming_lessons($user_id, 15, "Teacher"); 
							}
							
							
							if( is_teacher($user_id) === TRUE ) {  
								appointments_to_confirm_as_teacher($user_id);
							}

						?>
					<br />

<!-- Schwarz Edit -->

                                                <?php // NHF Code 
                                                if( is_teacher($user_id)===TRUE ) {

$hour_rate_raw = get_fullhour_price($user_id);
$half_rate_raw = get_halfhour_price($user_id);
$us_serv_str = get_us_services($user_id);
$pos_hour = false;
$pos_half = false;
if (strpos($us_serv_str, ":3:") !== false) { //servnumedit
        $pos_hour = true;
}
if (strpos($us_serv_str, ":5:") !== false) { //servnumedit
        $pos_half = true;
}

							if ( !$pos_hour && !$pos_half) {
                                                                echo '<h2 align="center">Enter your price <a href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price">here</a>!</h2>';
                                                        } elseif ( $pos_hour && $pos_half ) {
                                                                echo '<h2 align="center">Your current rate is:<a id="homepage_price" href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price"> $' . $half_rate_raw . '/30min</a> and <a id="homepage_price_2" href="' 
. get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price">$' . $hour_rate_raw . '/hour</a>.</h2>';
                                                        } elseif ($pos_hour) {
                                                                echo '<h2 align="center">Your current rate is:<a id="homepage_price" href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price"> $' . $hour_rate_raw . '/hour</a>.</h2>';
                                                        } elseif ($pos_half) {
                                                                echo '<h2 align="center">Your current rate is:<a id="homepage_price" href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price"> $' . $half_rate_raw . '/30min</a>.</h2>';
                                                        }

							echo '<p class="homePlaceHold"></p>';   
							echo '<h3 align="center">Lessons To Teach</h3>';
							echo '<div id="teacher_apps">';  
						        echo do_shortcode('[app_my_appointments provider=1 _allow_confirm=1 status="confirmed,pending,paid" provider_id=' . $user_id . ' order_by="start ASC" ]');
							// _allow_confirm=1
							echo '</div><!-- end teacher_apps -->';  
						 } // end if , end NHF Code
						?>
					
						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>
<?php } // endif ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						<?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>
			
			<!-- NHF custom javascript to edit forms --> 
			<script>
				//var text = jQuery('.my-appointments-confirm').text(); 
				//alert(text); 
				jQuery('.my-appointments-confirm').text('Cancel?');
				jQuery('.submit input[name="app_bp_settings_submit"]').attr("value", "Cancel Lesson"); 
				jQuery('input[name="app_bp_settings_submit"]').hide();
				
				jQuery('.worker .app_status').each(function() { 
					var statusy = jQuery(this).text(); 
					if( statusy != 'confirmed') { 
						jQuery(this).parent('tr').remove(); 
					} 					
				}); // end each 
			 
				jQuery('.app_confirm').click(function() { 
					//alert('Submited');
					//var stuff = jQuery(this).serialize(); 
					//alert(stuff);
					
					/*if( jQuery(this).hasClass('worker') ) { 
						var canceller = 'worker'; 
					} 
					else
					{ 
						var canceller = 'user'; 
					} 

					//alert(canceller); 
					var allCancelled = []; 
					jQuery('input[type=checkbox]:checked', this).each(function() { 
						var value = jQuery(this).attr("name"); 
						//alert( value );
						var valueArray = value.match(/\[(.*?)\]/);
						if( valueArray ) { 
							var subValue = valueArray[1]; 
						} 
						//alert(subValue);  
						allCancelled.push(subValue); 	
  					}); 
					//console.log(allCancelled);
					var cancelString = allCancelled.join(); 
					//alert(cancelString);
					//alert('length of array is ' +  allCancelled.length); 
					if( allCancelled.length === 0) {  
						alert('no cancellations!'); 
						return false;  
					} */ 

					
					var value = jQuery(this).attr("name"); 
					var valueArray = value.match(/\[(.*?)\]/);
					var subValue = valueArray[1]; 	
					//alert(subValue); 
					
					var cancelString = subValue; 								
					//alert(cancelString); 	
					var specialnotice = prompt('Please let the student know why you are cancelling');
					if( specialnotice == null ) { 
						return false;
					} 

				 	var URLnotice = encodeURIComponent(specialnotice); 
	
					var ConfirmCancel = confirm("Are you sure you want to cancel?"); 
					if( ConfirmCancel == false ) {
						 
						jQuery(this).prop('checked', false);   
						return false;
					} 
	 
					var PostQueryString = 'LessonIdsToCancel=' + cancelString +'&canceller=<?php echo $user_id; ?>&cancelnotice=' + URLnotice + ''; 
					//alert(PostQueryString)
				// 		url: '<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php',  
					 jQuery.ajax({  
  						type: 'POST',  
						dataType: 'JSON', 
  						url: '<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php',  
  						data: 'action=cancelAppointment&' + PostQueryString + '',  
  						success: process_cancel,  
  						error: function(MLHttpRequest, textStatus, errorThrown){  
  							alert(errorThrown);  
  						}  
  					});  					

/*jQuery.post('<?php echo get_template_directory_uri(); ?>/finch_custom_ajax/cancel_appointment.php', PostQueryString, process_cancel, "json");*/  
					function process_cancel(response) { 
						console.log(response); 
						alert('Lesson successfully cancelled!');
						window.location.href = window.location.href;  
					} 
					return false; 

				}); // end submit 

			</script>  
			<!-- end NHF Script --> 

			<?php /*comments_template();*/  ?>

			<?php endwhile; endif; ?>
			
	<!--	<div style="width: 300px; text-align: center;">
			<ul class="bxslider">
  				<li>Hola</li>
  				<li>Como</li>
  				<li>Estas</li>
			</ul>
		</div> -->
 
		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

		</div><!-- .padder -->

	</div><!-- #content -->
<?php //wp_reset_query(); ?>



	<?php //if ( is_user_logged_in() ) { get_sidebar(); }  ?>


<?php get_footer(); ?>
