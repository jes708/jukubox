<?php
function cardoza_twitter_box_options_page(){
	$ctb_options = array(
			'ctb_title' => 'cardoza_tb_title',
			'ctb_username' => 'cardoza_tb_username',
			'ctb_scrollbar' => 'cardoza_tb_scrollbar',
			'ctb_live' => 'cardoza_tb_live',
			'ctb_behavior' => 'cardoza_tb_behavior',
			'ctb_loop_results' => 'cardoza_tb_loop_results',
			'ctb_tweet_interval' => 'cardoza_tb_tweet_interval',
			'ctb_no_of_tweets' => 'cardoza_tb_no_of_tweets',
			'ctb_shell_bg_color' => 'cardoza_tb_shell_bg_color',
			'ctb_shell_text_color' => 'cardoza_tb_shell_text_color',
			'ctb_tweet_bg_color' => 'cardoza_tb_tweet_bg_color',
			'ctb_tweet_text_color' => 'cardoza_tb_tweet_text_color',
			'ctb_links_color' => 'cardoza_tb_links_color',
			'ctb_width' => 'cardoza_tb_width',
			'ctb_height' => 'cardoza_tb_height',
	);
	
	if(isset($_POST['frm_submit'])){
		if(!empty($_POST['frm_title'])) update_option($ctb_options['ctb_title'], $_POST['frm_title']);
		if(!empty($_POST['frm_username'])) update_option($ctb_options['ctb_username'], $_POST['frm_username']);
		if(!empty($_POST['frm_scrollbar'])) update_option($ctb_options['ctb_scrollbar'], $_POST['frm_scrollbar']);
		if(!empty($_POST['frm_live'])) update_option($ctb_options['ctb_live'], $_POST['frm_live']);
		if(!empty($_POST['frm_behavior'])) update_option($ctb_options['ctb_behavior'], $_POST['frm_behavior']);
		if($_POST['frm_behavior'] == "default"){
			if(!empty($_POST['frm_loop_results'])) update_option($ctb_options['ctb_loop_results'], $_POST['frm_loop_results']);
			if(!empty($_POST['frm_tweet_interval'])) update_option($ctb_options['ctb_tweet_interval'], $_POST['frm_tweet_interval']);
		}
		else{
			$_POST['frm_loop_results']="";
			$_POST['frm_tweet_interval']="";
			update_option($ctb_options['ctb_loop_results'], $_POST['frm_loop_results']);
			update_option($ctb_options['ctb_tweet_interval'], $_POST['frm_tweet_interval']);
		}
		if(!empty($_POST['frm_no_of_tweets'])) update_option($ctb_options['ctb_no_of_tweets'], $_POST['frm_no_of_tweets']);
		if(!empty($_POST['frm_shell_bg_color'])) update_option($ctb_options['ctb_shell_bg_color'], $_POST['frm_shell_bg_color']);
		if(!empty($_POST['frm_shell_text_color'])) update_option($ctb_options['ctb_shell_text_color'], $_POST['frm_shell_text_color']);
		if(!empty($_POST['frm_tweet_bg_color'])) update_option($ctb_options['ctb_tweet_bg_color'], $_POST['frm_tweet_bg_color']);
		if(!empty($_POST['frm_tweet_text_color'])) update_option($ctb_options['ctb_tweet_text_color'], $_POST['frm_tweet_text_color']);
		if(!empty($_POST['frm_links_color'])) update_option($ctb_options['ctb_links_color'], $_POST['frm_links_color']);
		if(!empty($_POST['frm_width'])) update_option($ctb_options['ctb_width'], $_POST['frm_width']);
		if(!empty($_POST['frm_height'])) update_option($ctb_options['ctb_height'], $_POST['frm_height']);
?>
		<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'c3dtc_tans_domain' ); ?></strong></p></div>
<?php	
	}
	$option_value = ctb_retrieve_options($opt_val);
?>
	<div class="wrap">
		<h2><?php _e("Cardoza Twitter Box Options", "ctb_tans_domain");?></h2><br />
		<!-- Administration panel form -->
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<h3>General Settings</h3>
		<div id="ctb_title">Title:</div>
		<div id="ctb_input"><input type="text" name="frm_title" size="50" value="<?php echo $option_value['ctb_title'];?>"/>(Title of the twitter box)</div>
		<div id="ctb_title">Username:</div>
		<div id="ctb_input"><input type="text" name="frm_username" size="50" value="<?php echo $option_value['ctb_username'];?>"/>(Username for your twitter account)</div>
		<div style="clear:both;"></div>
		
		<h3>Preferences</h3>
			<div id="ctb_title">Include scrollbar:</div>
			<div id="ctb_input">
				<select name="frm_scrollbar">
					<option value="true" <?php if($option_value['ctb_scrollbar']=="true") echo "selected='selected'";?>>Yes</option>
					<option value="false" <?php if($option_value['ctb_scrollbar']=="false") echo "selected='selected'";?>>No</option>
				</select>
				(Select "Yes" to enable scollbar)
			</div>
			<div id="ctb_title">Live:</div>
			<div id="ctb_input">
				<select name="frm_live">
					<option value="true" <?php if($option_value['ctb_live']=="true") echo "selected='selected'";?>>Yes</option>
					<option value="false" <?php if($option_value['ctb_live']=="false") echo "selected='selected'";?>>No</option>
				</select>
				(Select "Yes" to enable scollbar)
			</div>
			<div id="ctb_title">Behavior:</div>
			<div id="ctb_input">
				<select name="frm_behavior" onchange="javascript:show_loop(this.value)">
					<option value="default" <?php if($option_value['ctb_behavior']=="default") echo "selected='selected'";?>>Timed Interval</option>
					<option value="all" <?php if($option_value['ctb_behavior']=="all") echo "selected='selected'";?>>Load all tweets</option>
				</select>
			</div>
			<div id="loop_r">
				<div id="ctb_title">Loop results?:</div>
					<div id="ctb_input">
						<select name="frm_loop_results">
							<option value="true" <?php if($option_value['ctb_loop_results']=="true") echo "selected='selected'";?>>Yes</option>
							<option value="false" <?php if($option_value['ctb_loop_results']=="false") echo "selected='selected'";?>>No</option>
						</select>
					</div>
				<div id="ctb_title">Tweet Interval:</div>
				<div id="ctb_input"><input type="text" name="frm_tweet_interval" size="5" value="<?php echo $option_value['ctb_tweet_interval'];?>"/> seconds</div>
			</div>
			<div id="ctb_title">Number of Tweets:</b></div>
        	<div id="ctb_input"><input type="text" name="frm_no_of_tweets" value="<?php echo $option_value['ctb_no_of_tweets'];?>"/>(Default number of tweets to be displayed)</div>
		<div style="clear:both;"></div>
		
		<h3>Appearance</h3>
		<div id="ctb_title">Shell background color:</b></div>
		<div id="ctb_input"><input type="text" name="frm_shell_bg_color" size="20" value="<?php echo $option_value['ctb_shell_bg_color'];?>"/>(Should be an hex value like #000)</div>
		<div id="ctb_title">Shell text color:</b></div>
		<div id="ctb_input"><input type="text" name="frm_shell_text_color" size="20" value="<?php echo $option_value['ctb_shell_text_color'];?>"/>(Should be an hex value like #000)</div>
		<div id="ctb_title">Tweet background color:</b></div>
		<div id="ctb_input"><input type="text" name="frm_tweet_bg_color" size="20" value="<?php echo $option_value['ctb_tweet_bg_color'];?>"/>(Should be an hex value like #000)</div>
		<div id="ctb_title">Tweet text color:</b></div>
		<div id="ctb_input"><input type="text" name="frm_tweet_text_color" size="20" value="<?php echo $option_value['ctb_tweet_text_color'];?>"/>(Should be an hex value like #000)</div>
		<div id="ctb_title">Links color:</b></div>
		<div id="ctb_input"><input type="text" name="frm_links_color" size="20" value="<?php echo $option_value['ctb_links_color'];?>"/>(Should be an hex value like #000)</div>
		
		<h3>Dimensions</h3>
		<div id="ctb_title">Width:</b></div>
		<div id="ctb_input"><input type="text" name="frm_width" size="20" value="<?php echo $option_value['ctb_width'];?>"/>px</div>
		<div id="ctb_title">Height</b></div>
		<div id="ctb_input"><input type="text" name="frm_height" size="20" value="<?php echo $option_value['ctb_width'];?>"/>px</div>
		
		<input type="submit" name="frm_submit" value="Update Options" style="margin-left:15%;background-color:#CCCCCC;font-weight:bold;"/>
		</form>
	</div>
<?php
}
?>