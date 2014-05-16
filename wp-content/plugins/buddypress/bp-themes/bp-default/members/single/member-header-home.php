<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>

<div id="item-header-avatar">
	<a href="<?php bp_loggedin_user_link(); ?>">

		<?php bp_loggedin_user_avatar( 'type=full' ); ?>

	</a>
</div><!-- #item-header-avatar -->

<!-- FINCH CUSTOM CODE -->
<?php $logi_user_id = bp_loggedin_user_id();  $logi_user_name = bp_get_profile_field_data('field=1&user_id=' . $logi_user_id . '') ;
 ?>
<!-- END FINCH CUSTOM CODE -->
<div id="item-header-content">

	<h2>
		<a href="<?php bp_loggedin_user_link(); ?>"><?php bp_loggedin_user_fullname(); ?></a>	
	</h2>

<!--	<span class="user-nicename">@<?php // bp_loggedin_user_username(); ?></span> -->
	<span class="activity"><?php bp_last_activity( bp_loggedin_user_id() ); ?></span>

	<?php do_action( 'bp_before_member_header_meta' ); ?>

	<div id="item-meta">

<!--		<?php //  if ( bp_is_active( 'activity' ) ) : ?>

			<div id="latest-update">

				<?php // bp_activity_latest_update( bp_loggedin_user_id() ); ?>

			</div>

		<?php // endif; ?>
-->
	<div id="rates_instruments">
		<div id="r_i_rates">
		                  <?php $hour_rates_raw = get_fullhour_price($logi_user_id);
                                if(!empty($hour_rates_raw)) : 
				 ?><p class="hour_rates_p"><?php echo "$" . $hour_rates_raw . "/hour";

                                ?>
                            </p>
				<?php endif; ?>
                                  <?php $half_rates_raw = get_halfhour_price($logi_user_id);
                                if(!empty($half_rates_raw)) :                               
				 ?><p class="half_rates_p"><?php echo "($" . $half_rates_raw . "/half hour)";

                                ?>
                            </p>
				<?php endif; ?>

		</div>
		<div id="r_i_inst">
		                        <p class="inst_ital"
<?php if((empty($hour_rates_raw)) || (empty($half_rates_raw))) : ?>
style="top:13px;"
<?php endif; ?>
> <?php $user_instruments_raw = bp_get_profile_field_data('field=2&user_id=' . bp_loggedin_user_id() . '');
                                        $user_instruments_raw = array_slice( $user_instruments_raw, 0, 8);
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
	</div>

		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );

		 ?>

	</div><!-- #item-meta -->

</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>
