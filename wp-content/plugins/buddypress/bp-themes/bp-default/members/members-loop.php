<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>


<?php $newvar = $_GET['inst_filter']; ?>
	<?php /* NHF test */ //   $_POST['field_2'][0] = "cello"; $_POST['field_20'] = "teacher"; $_POST['bp_profile_search'] = true; $_POST['num'] = 9999;  ?> 
<?php do_action( 'bp_before_members_loop' ); ?>
<?php 	// get the instrument name - had to edit _inc/global.js and ajax.php to make this work
	// do this again to add other parameters to search - epic coding win! 

	$string = bp_ajax_querystring( 'members');
//	echo '<h1>' . $string . '</h1>';

	$string_first_array = explode('&', $string); 
	array_pop($string_first_array); 
	$string_first_array[] = 'per_page=1000'; 
	$string = implode('&', $string_first_array); 
	
  
if( isset($_REQUEST['instrument']) ) { 
//echo '<h1>' . $_POST['instrument'] . '</h1>'; 
	$instrument = mysql_real_escape_string(htmlentities($_REQUEST['instrument'])); 
	$string_array = explode('&', $string); 
//	print_r($string_array);
	unset($string_array[0]);  // get rid of first two exclude statements
	unset($string_array[1]);

/*	array_pop($string_array); 
	$string_array[] = 'per_page=1000';*/  

// these next options are ncessary to filter by price
	//unset($string_array[2]); 
	//unset($string_array[3]); 
// end by price

	$string = implode('&', $string_array);  
	// $string = 'include=1,4,5&' . $string; 
	//echo '<h1>' . $string . '</h1>'; 


	$select_teachers = filter_by_role_and_instrument('Teacher', $instrument); // returns string of teacher ids spearated by comma, '1,2,3' etc.   
// echo '<h1>Select Teachers: ' . $select_teachers . '</h1>';  
if( $select_teachers == '' ) { 

}  
//$new_order =  fixed_order_by_rating( $select_teachers ); 	 
//echo $new_order;
//$new_order = '3,2,1';  	
	$string = 'include=' . $select_teachers . '&' . $string;
//	echo '<h1> STring - ' . $string . '</h1>'; 
?>
<script>
jQuery('#search-by-instrument').ready(function() { 
	jQuery('#search-by-instrument optgroup option[value="<?php echo $instrument; ?>"]').attr('selected', 'selected'); 

}); // end ready
</script>
<?php  } // end if isset  ?>
<?php if( isset($_POST['instrument']) && isset($_POST['rating_filter'])  ) { 
	// this is for later if we can filter by rating and price
 } // end if isset 
 
?>
<?php // if ( bp_has_members( bp_ajax_querystring( 'members' )  ) ) : // ORIGINAL CODE ?>
<?php if( $instrument == 'none' ) : ?>

	<div id="message" class="info">
		<p><?php _e( "Select an instrument to begin your search!", 'buddypress' ); ?></p>
	</div>
<?php elseif( empty($select_teachers) &&  !empty($instrument) && ($instrument != 'notApplicable')  ) : // if no teachers are availble for a certian instrument/spciality ?>

	<div id="message" class="info">
		<h3 class="no_inst"><?php echo $instrument; ?></h3>
		<p><?php _e( "Hold tight (like a fermata). More teachers coming soon!", 'buddypress' ); ?></p>
	</div>

<?php  elseif ( bp_has_members( $string  ) ) : // NHF CODE CODE ?>

	<?php  if( !is_user_logged_in() ) : // hide friendship buttons when logged out, but not from user profiles NHF  ?>
		 <style>
			.friendship-button:not(.lesson-button-wrapper):not(.lesson-button) { display: none; } 
		</style>   
	<?php  endif; ?>
	
<?php bp_member_user_id(); ?>
<?php if( $instrument != 'notApplicable' ) : ?>
               <?php // echo $instrument;?>
          <?php endif; ?>

	<div id="pag-top" class="pagination">
		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

<!--		<div class="pagination-links" id="member-dir-pag-top">

			<?php // bp_members_pagination_links(); ?>

		</div> -->

	</div>

	<?php do_action( 'bp_before_directory_members_list' ); ?>
	<ul id="members-list" class="item-list" role="main">
<!-- <h1>HELLO!  <?php //echo $string . '<br />'; print_r($string_array); 
		echo $instrument; 
?> </h1>--> 
	<?php while ( bp_members() ) : bp_the_member(); ?>
<?php // $newId = bp_get_member_user_id(); echo  $newId; echo bp_get_profile_field_data('field=7&user_id=' . $newId . '') ;//is_teacher_two($newId) ; ?>
		<li>
	<?php // if( !is_teacher( bp_get_member_user_id() ) ): ?>
	<!--	<style>
			.friend_slab_<?php echo bp_get_member_user_id(); ?> { display: none; } 
		</style>  --> 
	<?php // endif; ?>
			<div class="item-avatar">
				<a href="<?php bp_member_permalink(); ?>profile"><?php bp_member_avatar(); ?></a>
			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php bp_member_permalink(); ?>profile"><?php bp_member_name(); ?></a>

					<?php if ( bp_get_member_latest_update() ) : ?>

						<span class="update"> <?php bp_member_latest_update(); ?></span>

					<?php endif; ?>

				</div>

				<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>

				<?php do_action( 'bp_directory_members_item' ); ?>

				<?php
				 /***
				  * If you want to show specific profile fields here you can,
				  * but it'll add an extra query for each member in the loop
				  * (only one regardless of the number of fields you show):
				  *
				  * bp_member_profile_data( 'field=the field name' );
				  */
				?>
			</div>

			<div class="action">

				<?php do_action( 'bp_directory_members_actions' ); ?>

			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<h1><?php //echo $string; ?></h1>
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>
