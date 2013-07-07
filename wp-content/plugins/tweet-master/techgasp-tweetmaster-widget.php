<?php
//Load Shortcode Framework

//Hook Widget
add_action( 'widgets_init', 'techgasp_tweetmaster_widget' );
//Register Widget
function techgasp_tweetmaster_widget() {
register_widget( 'techgasp_tweetmaster_widget' );
}

class techgasp_tweetmaster_widget extends WP_Widget {
	function techgasp_tweetmaster_widget() {
	$widget_ops = array( 'classname' => 'Tweet Master', 'description' => __('With Tweet Master plugin you can display your latest tweets, favorite twitter lists and tweet button inside any widget position of your wordpress template. ', 'Tweet Master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'techgasp_tweetmaster_widget' );
	$this->WP_Widget( 'techgasp_tweetmaster_widget', __('Tweet Master', 'tweet master'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		//Our variables from the widget settings.
		$name = "Tweet Master";
		$title = isset( $instance['title'] ) ? $instance['title'] :false;
		$tweetspacer ="'";
		$show_tweetbutton = isset( $instance['show_tweetbutton'] ) ? $instance['show_tweetbutton'] :false;
		$twitteruser = $instance['twitteruser'];
		echo $before_widget;
		
		// Display the widget title
	if ( $title )
		echo $before_title . $name . $after_title;
	//Display Latest Tweets

	//Display Tweet Button
	if ( $show_tweetbutton )
			echo '<br/><a href="https://twitter.com/share" class="twitter-share-button" data-via="'.$twitteruser.'" data-related="'.$twitteruser.'" data-hashtags="'.$twitteruser.'">Tweet</a>' .
				'<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'.$tweetspacer.'http'.$tweetspacer.':'.$tweetspacer.'https'.$tweetspacer.';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'.$tweetspacer.'://platform.twitter.com/widgets.js'.$tweetspacer.';fjs.parentNode.insertBefore(js,fjs);}}(document, '.$tweetspacer.'script'.$tweetspacer.', '.$tweetspacer.'twitter-wjs'.$tweetspacer.');</script>';
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_tweetbutton'] = $new_instance['show_tweetbutton'];
		$instance['twitteruser'] = $new_instance['twitteruser'];
		return $instance;
	}
	function form( $instance ) {
	//Set up some default widget settings.
	$defaults = array( 'name' => __('Tweet Master', 'Tweet master'), 'title' => true, 'show_tweetbutton' => false, 'twitteruser' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<b>Check the buttons to be displayed:</b>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['title'], true ); ?> id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><b><?php _e('Display Widget Title', 'tweet master'); ?></b></label></br>
	</p>
	<hr>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['show_tweetbutton'], true ); ?> id="<?php echo $this->get_field_id( 'show_tweetbutton' ); ?>" name="<?php echo $this->get_field_name( 'show_tweetbutton' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_tweetbutton' ); ?>"><b><?php _e('Tweet Share Button', 'tweet master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'twitteruser' ); ?>"><?php _e('insert your twitter Username:', 'tweet master'); ?></label></br>
	<input id="<?php echo $this->get_field_id( 'twitteruser' ); ?>" name="<?php echo $this->get_field_name( 'twitteruser' ); ?>" value="<?php echo $instance['twitteruser']; ?>" style="width:auto;" />
	</p>
	<hr>
	<p><b>Tweet Master Advanced Version:</b> contains Display or hide Widget Title, Display Tweet Button with bubble count, Display your latest Tweets, Shortcode Framework publish widget inside pages and posts.</p>
	<p><a class="button-primary" href="http://wordpress.techgasp.com/tweet-master/" target="_blank" title="Tweet Master Advanced Version">Tweet Master Advanced Version</a></p>
	<?php
	}
 }
?>
