
<!--	<div id="slider">
		<?php $my_query = new WP_Query("showposts=5"); while ($my_query->have_posts()) : $my_query->the_post(); ?>
			
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>	
				<img src="<?php echo $image[0];  ?>" alt="" title="<?php the_title(); ?>"  />
			</a>
		<?php endwhile; ?>
	</div>
	<br clear="all" />	
<script>
jQuery(document).ready(function() {
	alert('hello!'); 
	jQuery("#slider").nivoSlider(); 
});

</script> --> 
