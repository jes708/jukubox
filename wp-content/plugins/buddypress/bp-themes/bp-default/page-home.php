<?php get_header(); ?>


	<div id="content">

<?php if( !is_user_logged_in() ) : ?>

<a href="<?php echo get_home_url() . '/teachers'; ?>"><section class="f-part-divide black">
    <section class="f-part-wrap preamble" style="max-width: 1000px; margin: 0 auto;">
	<h1 id="Amber_header">Live-video music lessons </br>with the world's best teachers.</h1>
	<p id="White_home_p">Our faculty consists of the world's most respected instructors from the top musical conservatories and orchestras.</p>
	<img style="bottom:110px; height:430px; position:relative; float:right; right:14px;" src="../../../../../wp-content/uploads/2013/11/Dicterow-Header.jpg"> 	
	<p id="Amber_p">Glenn Dicterow</br><em>Jukubox faculty</em> member</p>
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
                 <iframe width="444" height="265" src="//www.youtube.com/embed/C6Z0N5V9tw0" style="padding: 26px 0 0 79px; position:relative; z-index:10" frameborder="0" allowfullscreen></iframe>

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
							$price = get_cur_teacher_price($user_id);
							if( !$price || $price == '' || $price==0 ) { 
								echo '<h2 align="center">Enter your price <a href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price">here</a>!</h2>';
							} else { 
								echo '<h2 align="center">Your current rate is:<a id="homepage_price" href="' . get_home_url() . '/members/' . $current_user->user_login . '/appointments/name-your-price"> $' . $price . '/hour.</a></h2>'; 
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
