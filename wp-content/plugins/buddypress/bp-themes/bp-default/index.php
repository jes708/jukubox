<?php get_header(); ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_home' ); ?>

		<?php do_action( 'template_notices' ); ?>

		<div class="page" id="blog-latest" role="main">

			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<h2 class="posttitle"><a href="<?php the_permalink(); ?>" ><!-- <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?>--><?php the_title(); ?></a></h2>
                        <!--<span class="alignright" style="margin-top: -34px;"><?php /*echo get_avatar( get_the_author_meta( 'user_email' ), '50' );*/ ?></span>-->


                        <p class="date">
                                <?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?> &middot; <?php printf( __( '%1$s <!--<span>in %2$s</span>-->', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?> &middot; <?php comments_popup_link( __( 'No Comments', 'buddypress' ), __( '1 Comment', 'buddypress' ), __( '% Comments', 'buddypress' ) ); ?>


                                <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
                        </p>
                        <div class="finchFeatureImg">
                                <a href="<?php the_permalink(); ?>">            
                                <?php
                                        if( has_post_thumbnail() ) {
                                                the_post_thumbnail('juku-thumb');
                                        }

                                ?>
                                </a>
                        </div><!-- end align center -->
                                <?php $userlink =  bp_core_get_user_domain( $post->post_author ) . "profile/" ; /*echo $userlink;*/   ?>

<!--

						<div class="author-box">
							<?php //echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
							<p><?php //printf( _x( 'by %s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ); ?></p>

							<?php //if ( is_sticky() ) : ?>
								<span class="activity sticky-post"><?php //_ex( 'Featured', 'Sticky post', 'buddypress' ); ?></span>
							<?php //endif; ?>
						</div>
-->
						<div class="post-content">
<!--							<h2 class="posttitle"><a href="<?php //the_permalink(); ?>" rel="bookmark" title="<?php //_e( 'Permanent Link to', 'buddypress' ); ?> <?php //the_title_attribute(); ?>"><?php //the_title(); ?></a></h2>

							<p class="date"><?php //printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>
-->
							<div class="entry">
								<?php the_excerpt( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							</div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ); ?>

				<?php endwhile; ?>

				<?php bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ); ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ); ?></p>

				<?php get_search_form(); ?>

			<?php endif; ?>
		</div>

		<?php do_action( 'bp_after_blog_home' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
