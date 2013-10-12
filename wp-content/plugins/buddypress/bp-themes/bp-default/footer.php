		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

                        <div style="width:1000px; margin:0 auto; position:relative;" id="footer_sizer">

			<div id="foot_col_1" style="float:left; position:relative; z-index:100;">
			<div id="foot_men">
				<a href="<?php echo get_home_url() . '/teachers'; ?>">Find a Teacher</a>
                                <br>
				<a href="<?php echo get_home_url() . '/category/articles'; ?>">Blog</a>
                                <br>
				<a href="<?php echo get_home_url() . '/about-us'; ?>">About Jukubox</a>
                                <br>
				<a href="<?php echo get_home_url() . '/become-a-teacher'; ?>">Become a Teacher</a>
                                <br>
				<a href="<?php echo get_home_url() . '/troubleshooting'; ?>">Troubleshooting/FAQ</a>
                                <br>
				<a href="<?php echo get_home_url() . '/terms-of-use'; ?>">Legal</a>
			</div>
			<div id="foot_follow">
				<p>Follow us</p>
				<div id="foot_buttons">
				<a href="https://www.facebook.com/JukuboxOfficial"><img src="../../../../wp-content/uploads/2013/10/FBButton.png"></a>
                                <a href="https://twitter.com/jukuboxofficial"><img src="../../../../wp-content/uploads/2013/10/TwitterButton.png"></a>
                                <a href="http://www.youtube.com/jukuboxofficial"><img src="../../../../wp-content/uploads/2013/10/YoutubeButton.png"></a>
				</div>
			</div>
			<div id="jukucopyright">
			<p>Copyright © 2013 Jukubox LLC.</p>
			<br>
			<p>All rights reserved.</p>
			</div>
			</div>

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

                <div style="overflow:hidden; width:460px; height:370px; left:260px; bottom:25px; color:white; position:relative; z-index:9999999;" id="inst_footer">
                        <p>Browse by Instrument<p>
                               <div style="float:left; margin-right:60px;" id="foot_col_2">
                                 <?php foreach( $foot_col_2 as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl>
                                        <dt value="<?php echo $first_label; ?>"><?php echo $first_label; ?></dt>
                                                <?php endif; ?>
					<a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value['name'] ?>"><dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd></a>                                       
 					<?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
                        <div id="foot_col_3" style="float:left; margin-right:85px;">
                                 <?php foreach( $foot_col_3 as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name];
                                                if(!empty( $first_label ) ) : ?>
                                        <dl>
                                        <dt value="<?php echo $first_label; ?>"><?php echo $first_label; ?></dt>
                                                <?php endif; ?>
                                 <a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value['name'] ?>"><dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd></a>
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
                                       <a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value['name'] ?>"><dd value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?><dd></a>
					 <?php $last_label = $begin_end['lasts'];
                                                if(!empty( $last_label[$instrument_name] ) ) : ?>
                                        </dl>
                                                <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
		</div> <!-- end inst_holder -->

                <div style="width:120px; height:200px; left:910px; bottom:195px; color:white; position:absolute; z-index:9999999;" id="style_footer">
                        <p>Browse by Style<p>
                                <?php foreach( array_slice($instruments_array, 0, 3) as $key => $value ): ?>
                                        <?php  $instrument_name = $value['name'];
                                               $first_label = $begin_end['firsts'][$instrument_name]; ?>
                                        <ul>
					<a href="<?php echo get_home_url() . '/teachers/?instrument=' . $value['name'] ?>"><li value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></li></a>
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
