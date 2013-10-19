<?php do_action( 'bp_before_sidebar' ); ?>

<div id="sidebar" style="width:175px;" role="complementary">
	<div id="centerer">
	<div class="padder">
	<?php do_action( 'bp_inside_before_sidebar' ); ?>

                        <div class="item-list-tabs-side" role="navigation">

                        <?php  $instruments_query = "SELECT
                                                                name 
                                                        FROM
                                                                wp_bp_xprofile_fields
                                                        WHERE
                                                                parent_id = 2
                                                        ORDER BY 
                                                                option_order
                                                        ASC
                                                        ";
                                $instruments_array = finch_mysql_query($instruments_query, "array"); 

                                $begin_end = Array();

                                $begin_end['firsts']['Violin'] = 'Strings';
                                $begin_end['firsts']['Classical'] = 'Styles';
                                $begin_end['firsts']['Piano/Keyboard'] = 'Percussive';
                                $begin_end['firsts']['Guitar'] = 'Plucked';
                                $begin_end['firsts']['Trumpet'] = 'Brass';
                                $begin_end['firsts']['Piccolo'] = 'Woodwind';
                                $begin_end['firsts']['Voice'] = 'Other';

                                $begin_end['lasts']['Pop/Rock'] = 'y';
                                $begin_end['lasts']['Double Bass'] = 'y';
                                $begin_end['lasts']['Pitched Percussion'] = 'y';
                                $begin_end['lasts']['Harp'] = 'y';
                                $begin_end['lasts']['Baritone/Tuba'] = 'y';
                                $begin_end['lasts']['Baritone Sax'] = 'y';
                                $begin_end['lasts']['Misc'] = 'y';

//echo '<pre>'; print_r($begin_end); echo '</pre>'; 

                        ?>

                <div id="inst_holder_side">
                               <div id="side_inst_list">
                                 <?php foreach( $instruments_array as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl class="inst_expander">
                                        <dt class="now_closed" value="<?php echo $first_label; ?>"><?php echo $first_label; ?><a class="see_dd"><i class="icon-plus-sign-alt"></i></a></dt>
					<dd>
                                                <?php endif; ?>
                                        <p value="<?php echo $value['name']; ?>"><a href="<?php echo get_home_url() . '/members/?s=' . $value['name'] ?>"><?php echo $value['name']; ?></a></p> 
					<?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
					</dd>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
 
</div>

<!-- <a style="font-size:13px; float:right; position:relative; right:20px;" href="<?php // echo get_home_url() . '/teachers'?>">Remove Filters</a> -->

</div>


	<?php dynamic_sidebar( 'sidebar-3' ); ?>

	<?php do_action( 'bp_inside_after_sidebar' ); ?>

	</div><!-- .padder -->
	</div><!-- .centerer -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>
