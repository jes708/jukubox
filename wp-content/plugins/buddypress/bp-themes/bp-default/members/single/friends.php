<?php

/**
 * BuddyPress - Users Friends
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>

		<?php if ( !bp_is_current_action( 'requests' ) ) : ?>

			<li id="members-order-select" class="last filter">

				<label for="members-friends"><?php _e( 'Sort:', 'buddypress' ); ?></label>
				<select id="members-friends">
					<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
					<option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>
					<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

					<?php do_action( 'bp_member_blog_order_options' ); ?>

				</select>
			</li>

		<?php endif; ?>

	</ul>
</div>

<div class="friPag">

<?php

if ( bp_is_current_action( 'requests' ) ) :
        echo '<h3 class="friPag">Requests</h3>';
	 locate_template( array( 'members/single/friends/requests.php' ), true );
else :
	do_action( 'bp_before_member_friends_content' ); ?>
        <h3 class="friPag">Connections</h3>
	<div class="members friends">

		<?php locate_template( array( 'members/members-loop.php' ), true ); ?>

	</div><!-- .members.friends -->

	<?php do_action( 'bp_after_member_friends_content' ); ?>

<?php endif; ?>

</div>
