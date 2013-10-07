<?php do_action( 'bp_before_blog_search_form' ); ?>

<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<div class="input-append">
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
	<input type="submit" class="btn btn-primary" id="searchsubmit" value="<?php _e( 'Search', 'buddypress' ); ?>" />

	<?php do_action( 'bp_blog_search_form' ); ?>
	</div>
</form>

<?php do_action( 'bp_after_blog_search_form' ); ?>
