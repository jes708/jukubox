<?php
   /*
   Plugin Name: Twitter Tweets Box
   Plugin URI: http://www.vinojcardoza.com/cardoza-twitter-box/
   Description: Twitter Tweets Box enables you to display the tweets in your website.
   Version: 1.3
   Author: Vinoj Cardoza
   Author URI: http://www.vinojcardoza.com/about-me/
   License: GPL2
   */
   
wp_enqueue_style('ctbox-css', plugin_dir_url(__FILE__). 'includes/cardoza_twitter_profile.css');
wp_enqueue_script('ctbox-handle','http://widgets.twimg.com/j/2/widget.js');
wp_enqueue_script('ctbox-js-handle', plugin_dir_url(__FILE__). 'includes/cardoza_twitter_profile.js',array('jquery'));
add_action("plugins_loaded", "cardoza_twitter_box_init");
add_action("admin_menu", "cardoza_twitter_box_options");
add_shortcode("cardoza_twitter_box", "cardoza_twitter_box_sc");

require('includes/cardoza_twitter_profile_forms.php');
require('includes/cardoza_twitter_profile_functions.php');

//The following function will retrieve all the avaialable 
//options from the wordpress database

function cardoza_twitter_box_options(){
	add_menu_page(
		__('Twitter Box'), 
		'Twitter Box', 
		'manage_options', 
		'slug_for_twitter_box', 
		'cardoza_twitter_box_options_page',
		plugin_dir_url(__FILE__).'includes/twitter.png');
}


function cardoza_twitter_box_init(){
	register_sidebar_widget(__('Twitter Tweets Box'), 'widget_cardoza_twitter_box');
}

function cardoza_twitter_box_sc(){
    ob_start();
    $option_value = ctb_retrieve_options($opt_val);
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
		scrollbar: <?php echo $option_value['ctb_scrollbar'];?>,
		loop: <?php echo $option_value['ctb_loop_results'];?>,
		live: <?php echo $option_value['ctb_live'];?>,
		behavior: '<?php echo $option_value['ctb_behavior'];?>'
	  }
	}).render().setUser('<?php echo $option_value['ctb_username'];?>').start();
	</script>
<?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
?>
