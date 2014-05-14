<?php get_header(); ?>
<?php
// FINCH customization to get appointments to spit out properly

$worker_id = mysql_real_escape_string(htmlentities($_GET['app_provider_id'])) ; 

$worker_name = bp_get_profile_field_data('field=1&user_id=' . $worker_id . '') ;
?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<h2 class="pagetitle"><?php the_title(); ?></h2>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php // this function tells us if we're friends with this person
					// if it returns 'is_friend'
					// echo friends_check_friendship_status( $user_id,$worker_id); ?>
	
					<a href="<?php echo bp_core_get_user_domain($worker_id); ?>profile"><?php echo bp_core_fetch_avatar ( array( 'item_id' => $worker_id, 'type' => 'full' ) ); ?></a>
					<script>
						jQuery('.user-<?php echo $worker_id; ?>-avatar').css("float","right"); 
					</script>		
					<div class="entry">
					<!-- nhf fix link --> 
					<h3><span style="color: rgb(35, 63, 150); font-weight: 800;">Teacher: </span><a href="<?php echo bp_core_get_user_domain($worker_id); ?>profile"><span class="appWo"><?php echo $worker_name; ?></span></a></h3>


			<?php if(!is_user_logged_in() ) { ?>
				
						<h2 style="width: 63%; line-height: 1.3em;">Feel free to check out this teacher's schedule, but you must be logged in to schedule a lesson.  Log in or register <a href="<?php echo get_home_url(); ?>/wp-login.php" >here</a>!</h2>
			<?php } else {  ?>
				<?php // if you're friends, you can book a lesson
					// if not you can only see their schedule ?>

					<?php if(friends_check_friendship_status( $user_id,$worker_id) == 'is_friend' ) { ?>
 						<?php  
							$serv_remove = get_deletable_services( $worker_id ); 
							
						?>
						<!-- remove options not authorized --> 
						<script>
							jQuery('app_select_services').ready(function() { 
							<?php foreach($serv_remove as $key => $value) : ?>
								 jQuery('.app_select_services option[value="<?php echo $key; ?>"]').remove();
							<?php endforeach; ?>
							}); // end ready
						</script>
						
							<?php if( had_first_lesson($user_id, $worker_id) ) { ?>
								<script>
									// commented this out for now - depends on toggling
									jQuery('.app_select_services').ready( function() { 	
									//	jQuery('.app_select_services option[value="2"]').remove();
									}); // end ready  
								</script>  
							<?php } 
							else {  	
								?>
								 
								<script>
									jQuery('.app_select_services').ready( function() { 
										//jQuery('.app_select_services option[value="3"]').remove(); 
										//jQuery('.app_select_services option[value="2"]').attr("selected", "selected");
									}); // end ready  
								</script> 
								<?php  //$_REQUEST['app_service_id'] = 2;   ?>
						<?php } // end ifelse had_first_lesson ?>
						<?php   // NHF - commented this out, don't want people choosing different providers on 
							// page for one provider
							// echo do_shortcode('[app_service_providers ]');  ?>
					<?php } else { // user isn't friends ?>
						<?php if( $user_id == $worker_id ) { // you're viewing your own schedule ?>
							<h3 style="width: 63%">This is your schedule as others see it.</h3>
						<?php } else { // viewing someone else's schedule but you're not friends ?>
							<!-- <h3 style="width: 63%">You are not yet friends with <?php echo $worker_name; ?>: Send a message and request friendship to be able to book a lesson!</h3> --> 
							<?php 
									
//								$_REQUEST['app_service_id'] = 2;
								//echo 	$_REQUEST['app_service_id'];  
								// user is logged in but not friends w worker
								// they can only book a free lesson	
								$avail_serv = serivces_hash('total', '');
								$avail_serv_hash = $avail_serv['hash'];  
							?> 
								
								<!-- remove options not authorized --> 
							<script>
								jQuery('app_select_services').ready(function() { 
							<?php foreach($avail_serv_hash as $key => $value ) : ?>
							    <?php if($key > 2) : ?>
								 	jQuery('.app_select_services option[value="<?php echo $key; ?>"]').remove();
							    <?php endif; ?>
							<?php endforeach; ?>
								}); // end ready
							</script>
						<?php } // end if-else user_id = worker_id ?>	
					<?php } // end ifelse ?>

				
				<?php if( (is_user_logged_in()) && ( $user_id != $worker_id ) ) { 	
					echo do_shortcode('[app_services]');  
				} 
				?>
			<?php } // end if user_not_logged_in ?>	
 
						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>
					
					<?php   
						if( (is_user_logged_in()) && ( $user_id != $worker_id ) ) { 	
						// for now - don't need to be friends for this to come up 
						// if( friends_check_friendship_status( $user_id,$worker_id) == 'is_friend' )  { ?>
						
						<?php echo do_shortcode('[app_confirmation button_text = "Make Appointment" city="Time zone" ]');  ?>  
						<?php echo do_shortcode('[app_paypal ]');  ?> 
					<?php } // endif ?>  

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						<?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>

			<?php //comments_template(); ?>

			<?php endwhile; endif; ?>

		</div><!-- .page -->
		<script>
			// NHF custom script to enable confirm button to send request email 
		</script>
		<?php do_action( 'bp_after_blog_page' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php //get_sidebar(); ?>

<?php get_footer(); ?>
