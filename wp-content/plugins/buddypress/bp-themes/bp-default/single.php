<?php get_header(); ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
			<h2 class="posttitle"><?php the_title(); ?>
			<!--<span class="alignright"><?php /*echo get_avatar( get_the_author_meta( 'user_email' ), '50' );*/ ?></span>--></h2>
			
			
			<p class="date">
				<?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?> &middot; <?php printf( __( '%1$s <!--<span>in %2$s</span>-->', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?> &middot; <?php comments_number('No comments', 'One comment', '% Comments'); ?>
				 
				<span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
			</p>
			<div class="finchFeatureImg">	
				<a href="<?php the_permalink(); ?>">		
				<?php
					if( has_post_thumbnail() ) { 
						/*the_post_thumbnail('medium');*/ 
						the_post_thumbnail('juku-thumb'); 
					} 

				?>
				</a>
			</div><!-- end align center --> 
			<!--		<div class="author-box">
						<?php //echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php //printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
					</div> --> 

					<div class="post-content">


						<div class="entry">
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>

							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						</div>

						<p class="postmetadata"> <?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>
				    <div id="finchBottom">
						<div class="alignleft"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'buddypress' ) . '</span> %title' ); ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'buddypress' ) . '</span>' ); ?></div> </p> 
					</div>
				    </div> <!-- end finchBottom --> 
				</div>
<div id="comm_box">
			<?php comments_template(); ?>
</div>
			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
