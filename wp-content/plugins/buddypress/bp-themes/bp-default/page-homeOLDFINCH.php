<?php get_header(); ?>


	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h2 class="pagetitle"><?php the_title(); ?></h2>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">
			 <table id="tophometable"><tbody><tr><td>		
					<div id="feature_div" style="/*width: 350px; margin: 0 auto;*/ "> <h1 align="center">Features</h1>
						<ul id="feature_list">
							<li>Take <span class="highlighty">private lessons</span> without paying a penny until you find a teacher you like!</li>
							<li>Study <span class="highlighty">any musical subject</span> with experts all over the planet.</li>
							<li>Apply your musical knowledge and <span class="highlighty">teach</span> students around the globe.</li>
							<li>Earn <span class="highlighty">publicity</span> and <span class="highlighty">share your music</span> with the world.</li>
						</ul>
					 </div> <!-- feature_div -->
				 </td><td>
<?php if( !is_user_logged_in() ):  ?>
<div id="first_content" > 
		<h1>Study with the World</h1>
		<p>Welcome to <strong>Jukubox!</strong>  Jukubox helps you find the best music teachers <strong>ANYWHERE</strong> in the world with the click of a mouse!</p>
		<p>Study with them any time from home with a webcam.</p>
		<a href="<?php echo get_home_url(); ?>/teachers" ><h2>Find your teacher right now!</h2></a>
</div> 
<?php endif; ?>
</td></tr></tbody></table>  
				<?php if( is_user_logged_in() )  { ?>
					<div id="loggedin_div">
						
		<?php  $av_args = array('item_id' => $user_id, 'type' => 'full'); 
			echo bp_core_fetch_avatar($av_args);  ?>
			<div id="homeLoggedTitles">
						<h2 id="toploghome" style="font-size: 37px; text-align: center;  line-height: 1em;">Welcome,  <?php echo $finch_user_name; ?>!</h2>
						
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
							echo '<h3 align="center">Lessons to teach</h3>';
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
<?php wp_reset_query(); ?>



<?php // get latest articles
	$article_args = array( 
		'showposts' => 4, 
		'orderby' => 'date',
		'order' => 'DESC'
	); 

	$get_articles = new WP_Query($article_args);
	$get_articles = objectToArray($get_articles); 
//echo'<pre>';	print_r($get_articles); echo '</pre>';  
	$all_arts = $get_articles['posts']; 
	$all_arts_array = Array();
	$n = 0;  
	foreach( $all_arts as $key => $value ) { 
		$post_id = $value['ID']; 
		$text = $value['post_content']; 
		$title = $value['post_title']; 
		$author_id = $value['post_author']; 
		$link = $value['guid']; 
		
		$all_arts_array[$n]['author_id'] = $author_id;  	
		$all_arts_array[$n]['title'] = $title; 
		$all_arts_array[$n]['text'] = $text; 	
		$all_arts_array[$n]['link'] = $link;  
		$all_arts_array[$n]['post_id'] = $post_id; 

		$n++;  
	} 
wp_reset_query();
//	echo '<pre>'; print_r($all_arts_array); echo '</pre>'; 
?>
	<?php get_sidebar(); ?>

<?php if( !is_user_logged_in() ) : ?>

<div id="bottom_stuff">

<div align="center">
		<?php  /*echo do_shortcode("[nivoslider id='182']");*/ /* echo do_shortcode("[slider_pro id='4']");*/   //echo slider_pro(2);    ?>
		
</div>

<table><tbody>
	<tr><td class="teach_prof">
	
<div id="teach_prof_div">
	<?php $string = get_random_teachers();
	//	echo $string; ?>


	
			<h2 style="float: left; width: 50%;">Featured Teachers</h2>
			<h2 style="float:right; width: 50%;">Today's Articles</h2>
			<ul class="bxslider">

<?php $j = 0; ?>
<?php	   if ( bp_has_members( $string  ) ) : // NHF CODE CODE ?>

		
	<?php while ( bp_members() ) : bp_the_member(); ?>
		<li>
			 <?php  bp_member_avatar(); ?>
			<div style="float: left; width: 50%">
			<div class="finchsizer">  
			<h4><?php  bp_member_name(); ?></h4>
				<p style="margin-right: 53px;"><?php 
				$user_bio = bp_get_profile_field_data('field=6&user_id=' . bp_get_member_user_id()  .   '') ;   echo finch_excerpt( $user_bio, 30 );  
				  ?></p>
			</div><!-- finchsizer --> 
				<a href="<?php bp_member_permalink(); ?>profile">Read More...</a> 
			</div>
			<div style="float: left; "></div>
			<div style="float: right: width: 50%; ">
				<div class="finchsizer"> 	
				<h4><?php echo $all_arts_array[$j]['title']; ?>!</h4>
				<p><?php echo finch_excerpt($all_arts_array[$j]['text'], 30 ); ?> </p>
			</div><!-- finchsizer --> 
				<a href="<?php echo $all_arts_array[$j]['link']; ?>">Read More...</a>
			</div>
		</li> 
		
		<?php $j++; ?>
		<!-- 'type=full&width=125&height=125' --> 
	<?php endwhile; ?>
<?php endif; ?>
		 
			</ul>
			</div>
		
                 </div><!-- teach_prof_div --> 
	    </td>
	    </tr>
	
	</tbody></table>
</div> <!-- bottom_stuff -->
<?php endif; // end if user isn't logged in  ?> 
<script> 
	jQuery('.bx-viewport').each(function() { 
	var height2 = jQuery(this).height(); 
	//alert(height2); 
	}); 
	jQuery('.bx-viewport').each(function() { 
		jQuery(this).height(height2);
	}); // end each
</script> 
<?php get_footer(); ?>
