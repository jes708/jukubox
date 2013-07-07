		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

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
