<?php do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

        <?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                <?php if ( bp_profile_group_has_fields() ) : ?>

                        <?php do_action( 'bp_before_profile_field_content' ); ?>

                        <div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

                                <h4><?php bp_the_profile_group_name(); ?></h4>

                                <div class="profile-fields">

                                        <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

                                                <?php if ( bp_field_has_data() ) : ?>

                                                        <div<?php bp_field_css_class(); ?>>

                                                                <h3 class="label"><?php bp_the_profile_field_name(); ?></h3>

                                                                <div class="data"><?php
// NHF EDIT - display youtube video if requested
$field_id =  bp_get_the_profile_field_ID();

if( $field_id == 33 ) {
    $field_value = strip_tags(bp_get_the_profile_field_value() );
     if( strpos($field_value, 'youtu') !== false ) {

        if( strpos($field_value, 'youtube') !== false ) {
                $field_value_array = explode('watch?v=', $field_value) ;
                //print_r($field_value_array);
                $wanted_stuff = $field_value_array[1];
                $wanted_stuff_array = explode( '&', $wanted_stuff);
                //print_r($wanted_stuff_array);
                $youtube_code = $wanted_stuff_array[0];
        }
        else if( strpos( $field_value, 'youtu.be' ) !== false) {
                $field_value_array = explode('.be/', $field_value);
                //print_r($field_value_array);  
                $wanted_stuff = $field_value_array[1];
                $youtube_code = $wanted_stuff;
        }

?>
        <iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $youtube_code; ?>" frameborder="0" allowfullscreen></iframe> 
 <?php
    }   // end if strpos 'youtu' !== false
    else if( strpos($field_value, 'vimeo') !== false ) {
        $field_value_array = explode('vimeo.com/', $field_value);
        //print_r($field_value_array);
        $wanted_stuff = $field_value_array[1];
        $vimeo_code = $wanted_stuff;    ?>
        <iframe src="http://player.vimeo.com/video/<?php echo $vimeo_code; ?>" width="500" height="213" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php

    }   // end if strpos vimeo !== false 

    else { // not a valid youtube or vimeo link ?>
        <strong>Not a valid video link!  Please enter a valid youtube or vimeo video link!</strong>


    <?php }   // end else 
} // end if field_id = 33  
else {
        bp_the_profile_field_value();
} ?>
                                                                </div>

                                                        </div>

                                                <?php endif; ?>

                                                <?php do_action( 'bp_profile_field_item' ); ?>

                                        <?php endwhile; ?>

                                </div>
                        </div>

			<?php do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
