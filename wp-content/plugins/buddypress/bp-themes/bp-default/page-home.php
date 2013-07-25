<?php get_header(); ?>


	<div id="content">

<?php if( !is_user_logged_in() ) : ?>

<section class="f-part-divide"> 
    <section class="f-part-wrap" style="max-width: 1000px; margin: 0 auto;"> 
	<div class="fr-page-banner" id="top-slide" style="background: url(http://jukubox.com/wp-content/uploads/2013/07/Video_Laptop.png) no-repeat left top; height: 500px; width: 700px; padding: 40px; background-size: 600px 338px; background-position: left 15%;">
		 <iframe width="444" height="264" src="//www.youtube.com/embed/C6Z0N5V9tw0" style="padding: 21px 0 0 39px;" frameborder="0" allowfullscreen></iframe>

<div id="selling-points" style="width: 300px; margin-right: -220px; float: right;">
	<h1>STUDY WITH THE BEST</h1>
	<div><i class="icon-music"></i> <p>Musical Videoconferencing</p></div>
	<div><i class="icon-volume-up"></i> <p>Amazing Audio Quality</p></div>
	<div><i class="icon-globe"></i> <p>World-Renowned Experts</p></div>
	<div><i class="icon-home"></i> <p>World-Class Convenience</p></div>	
	<button class="btn btn-large btn-primary" onclick="window.location='<?php echo get_home_url(); ?>/wp-login.php'">Sign In</button>
        <button class="btn btn-large btn-primary" onclick="window.location='<?php echo get_home_url(); ?>/register'">Sign Up</button>
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
<section class="f-part-divide grey"> 
    <section class="f-part-wrap dos">
<!--Schwarz Add-->

<div id="teach_prof_div">
	<?php $string = get_random_teachers();
	//	echo $string; ?>

			<ul>

<?php $j = 0; ?>

  <?php	   if ( bp_has_members( $string  ) ) : // NHF CODE CODE ?>

		
	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li>
			<div style="float: left; width: 33%">
			<div style="float: left;"><?php  bp_member_avatar(); ?></div>
			<div class="finchsizer">  
			<h4><?php  bp_member_name(); ?>, 
			    <?php $user_instruments_raw = bp_get_profile_field_data('field=2&user_id=' . bp_get_member_user_id() . ''); 
					$end_inst = end($user_instruments_raw); 
					foreach( $user_instruments_raw as $key => $value ) { 
						$tag = ', '; 
						if( $value == $end_inst ) {  	
							$tag = '. '; 
						} 
						echo $value .  $tag; 
						
					} 
				//print_r( $user_instruments_raw);  ?> 
			    </h4>
				<p style="margin-right: 53px;"><?php 
				$user_about = bp_get_profile_field_data('field=28&user_id=' . bp_get_member_user_id()  .   '') ;   echo finch_excerpt( $user_about, 30 );  
				  ?></p>
			</div><!-- finchsizer --> 
				<a href="<?php bp_member_permalink(); ?>profile">Read More...</a> 
			</div>
			<?php $curr_id = $all_arts_array[$j]['post_id']; //echo $curr_id; 
				$art_thumb = get_the_post_thumbnail( $curr_id, 'thumbnail' );  
			?>
		</li> 
		
		<?php $j++; ?>
		<!-- 'type=full&width=125&height=125' --> 
	<?php endwhile; ?>
<?php endif; ?>
<!--End Schwarz Add-->
    </section>
</section>


<section class="f-part-divide"> 
    <section class="f-part-wrap" style="max-width: 1000px;">
    	<h1 class="nf-big-header">Features</h1>
	<div class="gk-features gk-perspective">
	    <a href="how-it-works/" target="_blank" class="gk-rocket" data-animation="flip" data-delay="0">
		<span></span>
		The Latest Online Video Technology
	    </a>	    

	    <a href="teachers/" class="gk-badges"  data-animation="flip" data-delay="150">
		<span></span>
		The Best Teacher Network Online
	    </a>	    
	    <a href="how-it-works/" class="gk-mouse"  data-animation="flip" data-delay="300">
		<span></span>
		Easy to Use Interface
	    </a>	    
	    <a href="teachers/" class="gk-piggy"  data-animation="flip" data-delay="450">
		<span></span>
		A true free market for lessons
	    </a>	    

	</div>
    </section>
</section>

<section class="f-part-divide grey"> 
    <section class="f-part-wrap">
      <div class="vertical-column-45">
	<h3 class="nf-big-header">Built by musicians.<br />  Built for <strong>you.</strong> </h3>
	<p style="margin-right: 44px;"><small>We ARE the music community.  And we have nothing but the best teachers on the web</small></p>
      </div> <!-- end column 45 -->
      <div class="vertical-column-55">
	<div id="aboutFounders">
	    <div class="founder_wrap"> 	
		<div class="founder_div" style="text-align: center;">
		    <a href="about-us/#rachel" >
			<img id="eric" src="wp-content/uploads/2013/05/Rachel-Re.jpg" height="100" width="100" style="margin: 0 auto;" />
		    </a>	
		</div>	
		<h3>Rachel</h3>
	    </div>
	    <div class="founder_wrap"> 	
		<div class="founder_div" style="text-align: center;">
		    <a href="about-us/#eric" >
			<img id="eric" src="wp-content/uploads/2013/05/Eric-Re.jpg" height="100" width="100" style="margin: 0 auto;" />	
		    </a>
		</div>	
		<h3>Eric</h3>
	    </div>
	    <div class="founder_wrap"> 	
		<div class="founder_div" style="text-align: center;">
			<!-- <img id="eric" src="wp-content/uploads/2013/05/John-Re.jpg" height="100" width="100" style="margin: 0 auto;" /> -->
		    <a href="about-us/#jon">
			<img id="eric" src="wp-content/uploads/2013/06/Jon_HeadShot.jpg" height="100" width="100" style="margin: 0 auto;" />	
		    </a>
		</div>	
		<h3>Jon</h3>
	    </div>
	    <div class="founder_wrap"> 	
		<div class="founder_div" style="text-align: center;">
		    <a href="about-us/#nick">
			<img id="eric" src="wp-content/uploads/2013/05/Finch-Re.jpg" height="100" width="100" style="margin: 0 auto;" />	
		    </a>
		</div>	
		<h3>Nick</h3>
	    </div>
	</div><!-- end aboutFounders --> 
      </div><!-- end vertical column 55 -->
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
						<?php // NHF Code 
						if( is_teacher($user_id)===TRUE ) {
							$price = get_cur_teacher_price($user_id);
							if( !$price || $price == '' || $price==0 ) { 
								echo '<h2 align="center">You have not yet entered a price!  Do so <a href="#">here</a></h2>'; 
							} else { 
								echo '<h2 align="center">Your current lesson price is: $' . $price . ' per hour.</h2>'; 
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



	<?php if ( is_user_logged_in() ) { get_sidebar(); }  ?>


<?php get_footer(); ?>
