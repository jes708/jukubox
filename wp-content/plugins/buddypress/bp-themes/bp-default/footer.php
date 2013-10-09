		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

                        <div id="violintestlink">
<?php $select_teachers = filter_by_role_and_instrument('Teacher', 'violin') ?>                                
<a style="position:absolute; z-index:99999999999999;" href="http://jukubox.com/teachers">violin</a>

                        <div class="footer-instruments" role="navigation">

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

				$instruments_array_length = count($instruments_array);

//echo '<pre>'; print_r($begin_end); echo '</pre>'; 

$foot_col_2 = array_slice($instruments_array, 3, 11);
$foot_col_3 = array_slice($instruments_array, 14, 14);
$foot_col_4 = array_slice($instruments_array, 28, 14);

                        ?>

                <div style="overflow:hidden; width:450px; height:370px; left:430px; bottom:5px; color:white; position:absolute; z-index:9999999;" id="inst_footer">
                        <p>Browse by Instrument<p>
                               <div style="float:left; margin-right:60px;" id="foot_col_2">
                                 <?php foreach( $foot_col_2 as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl>
                                        <dt value="<?php echo $first_label; ?>"><?php echo $first_label; ?></dt>
                                                <?php endif; ?>
                                        <dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd>
                                        <?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
                        <div id="foot_col_3" style="float:left; margin-right:60px;">
                                 <?php foreach( $foot_col_3 as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl>
                                        <dt value="<?php echo $first_label; ?>"><?php echo $first_label; ?></dt>
                                                <?php endif; ?>
                                        <dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd>
                                        <?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
                        <div id="foot_col_4" style="float:left;">
                                <?php foreach( $foot_col_4 as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl>
                                        <dt value="<?php echo $first_label; ?>"><?php echo $first_label; ?></dt>
                                                <?php endif; ?>
                                        <dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd>
                                        <?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
		</div> <!-- end inst_holder -->

                <div style="width:120px; height:200px; left:910px; bottom:175px; color:white; position:absolute; z-index:9999999;" id="style_footer">
                        <p>Browse by Style<p>
                                <?php foreach( array_slice($instruments_array, 0, 3) as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name]; ?>
                                        <ul>
					<li value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></li>
                                        <?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </ul>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                </div> <!-- end inst_holder -->


                        </div>


			<div id="site-generator" role="contentinfo">
				<?php do_action( 'bp_dtheme_credits' ); ?>
				 <p><?php printf( __( 'Proudly powered by <a href="%1$s">WordPress</a> and <a href="%2$s">BuddyPress</a>.', 'buddypress' ), 'http://wordpress.org', 'http://buddypress.org' ); ?></p> 
				
				<p><?php printf( __( ' &copy; 2013, The Jukubox Team (Rachel Lee, Jonathan Schwarz, Eric Silberger).  Designed and developed by Nicholas Finch of NHF Digital.', 'buddypress' ), 'http://wordpress.org', 'http://buddypress.org' ); ?></p>

			</div>
		 
		<?php //if ( is_active_sidebar( 'bottom-footer-widget-area' ) ) : ?>
			<!-- <div id="footer-menu" role="contentinfo">
				<?php //dynamic_sidebar( 'bottom-footer-widget-area' ); ?>
			</div> --> <!-- end footer menu -->
		<?php //endif; ?> 
			<?php do_action( 'bp_footer' ); ?>

		</div><!-- #footer -->

		<?php do_action( 'bp_after_footer' ); ?>

		<?php wp_footer(); ?>

	</body>

</html>
