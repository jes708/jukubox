<?php
/* Function to retrieve the options value from the database*/
function ctb_retrieve_options($opt_val){
	$opt_val = array(
			'ctb_title' => stripslashes(get_option('cardoza_tb_title')),
			'ctb_username' => stripslashes(get_option('cardoza_tb_username')),
			'ctb_scrollbar' => stripslashes(get_option('cardoza_tb_scrollbar')),
			'ctb_live' => stripslashes(get_option('cardoza_tb_live')),
			'ctb_behavior' => stripslashes(get_option('cardoza_tb_behavior')),
			'ctb_loop_results' => stripslashes(get_option('cardoza_tb_loop_results')),
			'ctb_tweet_interval' => stripslashes(get_option('cardoza_tb_tweet_interval')),
			'ctb_no_of_tweets' => stripslashes(get_option('cardoza_tb_no_of_tweets')),
			'ctb_shell_bg_color' => stripslashes(get_option('cardoza_tb_shell_bg_color')),
			'ctb_shell_text_color' => stripslashes(get_option('cardoza_tb_shell_text_color')),
			'ctb_tweet_bg_color' => stripslashes(get_option('cardoza_tb_tweet_bg_color')),
			'ctb_tweet_text_color' => stripslashes(get_option('cardoza_tb_tweet_text_color')),
			'ctb_links_color' => stripslashes(get_option('cardoza_tb_links_color')),
			'ctb_width' => stripslashes(get_option('cardoza_tb_width')),
			'ctb_height' => stripslashes(get_option('cardoza_tb_height')),
	); 
	return $opt_val;
}

function widget_cardoza_twitter_box($args){
	$option_value = ctb_retrieve_options($opt_val);
	extract($args);
	echo $before_widget;
	echo $before_title;
	if(empty($option_value['ctb_title'])) $option_value['ctb_title'] = "Twitter";
	echo $option_value['ctb_title'];
	echo $after_title;
	?>
	<script>
	new TWTR.Widget({
		version: 2,
	  	type: 'profile',
		rpp: <?php echo $option_value['ctb_no_of_tweets'];?>,
	  	interval: <?php echo $option_value['ctb_no_of_tweets']*1000;?>,
	  	width: <?php echo $option_value['ctb_width'];?>,
	  	height: <?php echo $option_value['ctb_height'];?>,
	  	theme: {
		shell: {
		  background: '<?php echo $option_value['ctb_shell_bg_color'];?>',
		  color: '<?php echo $option_value['ctb_shell_text_color'];?>'
		},
		tweets: {
		  background: '<?php echo $option_value['ctb_tweet_bg_color'];?>',
		  color: '<?php echo $option_value['ctb_tweet_text_color'];?>',
		  links: '<?php echo $option_value['ctb_links_color'];?>'
		}
	  },
	  features: {
		scrollbar: true,
		loop: true,
		live: <?php echo $option_value['ctb_live'];?>,
		behavior: '<?php echo $option_value['ctb_behavior'];?>'
	  }
	}).render().setUser('<?php echo $option_value['ctb_username'];?>').start();
	</script>
<?php
	global $wpdb;
	echo $after_widget;
}

?>