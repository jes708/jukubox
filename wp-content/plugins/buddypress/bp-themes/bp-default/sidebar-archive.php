<?php do_action( 'bp_before_sidebar' ); ?>

<div id="sidebar" role="complementary">
	<div id="centerer">
	<div class="padder">
	<?php do_action( 'bp_inside_before_sidebar' ); ?>

	<?php if ( is_user_logged_in() ) : ?>

		<?php //do_action( 'bp_before_sidebar_me' ); ?>

<!--		<div id="sidebar-me">
			<a href="<?php //echo bp_loggedin_user_domain(); ?>">
				<?php //bp_loggedin_user_avatar( 'type=thumb&width=40&height=40' ); ?>
			</a>

			<h4><?php //echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></h4>
			<a class="btn btn-primary" href="<?php //echo wp_logout_url( wp_guess_url() ); ?>"><?php //_e( 'Log Out', 'buddypress' ); ?></a>

			<?php //do_action( 'bp_sidebar_me' ); ?>
		</div>
-->
		<?php //do_action( 'bp_after_sidebar_me' ); ?>

		<?php if ( bp_is_active( 'messages' ) ) : ?>
			<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
		<?php endif; ?>

	<?php //else : ?>

		<?php //do_action( 'bp_before_sidebar_login_form' ); ?>

		<?php //if ( bp_get_signup_allowed() ) : ?>
		
<!--			<p id="login-text">		-->

				<!--<?php //printf( __( 'Please <a href="%s" title="Create an account">create an account</a> to get started.', 'buddypress' ), bp_get_signup_page() ); ?> -->

<!--			</p>		-->

		<?php //endif; ?>


<!--
		<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php //echo site_url( 'wp-login.php', 'login_post' ); ?>" method="post">
			<label><?php //_e( 'Username', 'buddypress' ); ?><br />
			<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php //if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php //_e( 'Password', 'buddypress' ); ?><br />
			<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

			<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php //_e( 'Remember Me', 'buddypress' ); ?></label></p>

			<?php //do_action( 'bp_sidebar_login_form' ); ?>
			<button type="submit" class="btn btn-primary" name="wp-submit" id="sidebar-wp-submit" value="<?php //_e( 'Sign In', 'buddypress' ); ?>" tabindex="100">Sign In</button>
			<input type="hidden" name="testcookie" value="1" />
		</form>
		<button class="btn btn-primary" onclick="window.location='<?php //echo get_home_url(); ?>/register'">Sign Up</button>
-->		<?php //do_action( 'bp_after_sidebar_login_form' ); ?>

	<?php endif; ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  
    
    
    
   
    
   
   
   
		<div class="widget widget_recent_entries" id="recent-posts-4">
        
                <h3 class="widgettitle">Recent Articles</h3>
                <ul id="manual-recent-post">
                
                
					<?php
                        $argsp = array( 'numberposts' => '3', 'post_status' => 'publish' );
                        $recent_postso = wp_get_recent_posts( $argsp );
                        foreach( $recent_postso as $recento ){
							?>
                            <li>
                            <p><a href="<?php echo get_permalink($recento["ID"]); ?>" title="<?php echo esc_attr($recento["post_title"]); ?>" ><?php echo $recento["post_title"]; ?></a></p>

                            <p><?php echo get_the_time('F j, Y ', $recento["ID"]).' by <a href="' . get_home_url() . '/members/' . get_the_author_meta( 'user_login', $recento["post_author"]) . '" title="">'.get_the_author_meta( 'display_name', $recento["post_author"]).'</a>'; ?></p>


                            
                         
                            
                            </li>
                            
                            <?php
                        }
						
                    ?>

				</ul>
		</div>   
   
   
   
   
   
   
   
   
   
   
   
   
   
   


   
		<div class="widget widget_recent_entries" id="recent-posts-4">
        
                <h3 class="widgettitle">Latest Comments</h3>
                <ul id="manual-recent-post">
                
                
					<?php
                        
						$argsb = array(
									
									'number' => '3',
									'order' => 'DESC',
									'status' => 'approve'
								);
														
						
						$commentso = get_comments($argsb);
						foreach($commentso as $commento) :
					?>
                            <li>
                            
                            <p><a href="<?php echo get_permalink($commento->comment_post_ID); ?>" title="<?php echo($commento->comment_author); ?>" ><?php echo($commento->comment_author); ?></a></p>
                            
                            <p><a href="<?php echo get_permalink($commento->comment_post_ID); ?>" title="<?php echo($commento->comment_author); ?>" ><?php echo get_comment_excerpt( $commento->comment_ID ); ?></a></p>
							
                            </li>
                            
                        <?php
                        endforeach;
                    	?>

				</ul>
		</div>   
   
   








   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
<div class="widget widget_recent_entries" id="recent-posts-4">

    <form id="customsform" method="post" action="<?php echo get_site_url(); ?>" style="padding-top:15px; padding-bottom:10px;">
        
        <input type="text" name="s" class="search-teacher" id="notback1" placeholder="Search Blog" />
        <button class="cus-button" type="submit" id="notback2" name="search"><i class="icon-search"></i></button>
        
        <!--<input type="hidden" value="32b8ce28b5" name="_wpnonce" id="_wpnonce"><input type="hidden" value="/welcome-to-jukubox-beta/" name="_wp_http_referer">-->
    
    </form>

<script type="text/javascript">

$(document).ready(function(e) {
    
setInterval(function(){
$('#customsform .search-teacher').css({'background-color': 'transparent', 'background-color': 'none', 'border': 'none', 'border-style': 'none', 'box-shadow': 'none', 'transition': 'none', 'font-family': "'Open Sans', sans-serif", 'color':'#666', 'height': '29px', 'position': 'relative', 'line-height':'normal', 'width': '77%', '-webkit-border-radius': '6px 0 0 6px', '-moz-border-radius': '6px 0 0 6px', 'border-radius': '6px 0 0 6px', 'background-color': '#FFF', 'border': 'none', 'border-style': 'none', '-webkit-box-shadow': 'inset 0 1px 0 0 #666', '-moz-box-shadow': 'inset 0 1px 0 0 #666', 'box-shadow': 'inset 0 1px 0 0 #666', 'transition':'none', 'margin': '0 0 0 0', 'padding':'2px 5px'});

	$('#customsform .cus-button').css({'height': '33px', 'position': 'relative', 'width': '17%', '-webkit-border-radius': '0 6px 6px 0', '-moz-border-radius': '0 6px 6px 0', 'border-radius': '0 6px 6px 0', 'background-color': '#FFF', 'border-style':'solid', '-webkit-box-shadow': 'inset 0 1px 0 0 #666', '-moz-box-shadow': 'inset 0 1px 0 0 #666', 'box-shadow': 'inset 0 1px 0 0 #666', 'margin-left':'-10px', 'border': '0', 'cursor':'pointer', 'padding': '0 0 0 0', 'line-height': 'normal', 'background': '#FFF'});
}, 0);

});

</script>

   
   
   

</div>   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
<div class="widget widget_recent_entries" id="recent-posts-4">
                <h3 class="widgettitle">Archives</h3>
  
                <div class="time-select">
                
                    <div class="custom-drop1">
                            <div class="custom-drop-text">
                            <div style="line-height:29px; height:35px; overflow:hidden; width:300px;"></div>
                            </div>
                            
                            <div class="custom-drop2">
				<i class="icon-caret-down icon-large"></i>
                            </div>
                    </div>
                    
                    
                    <div class="custom-second">
                    
                    <ul class="dropdown-side">
                        <?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 20 ) ); ?>
                    </ul>
             		</div>
    
    
			</div>


  
    
		<script>
        
        
        //(function($){
            
        $(document).ready(function(e) {
            var flip = 0;
            $('.time-select *').click(function(e){$('.time-select .custom-second').toggle();});
            $('.time-select *').hover(function(){flip = 1;},function(){flip = 0;});
            $('*').click(function(event) {event.stopImmediatePropagation();
                if(flip==0){$('.time-select .custom-second'	).fadeOut();}
            });	
            
            //$('.time-select .dropdown-side')
            $('.time-select .custom-drop-text div').text($('.time-select .dropdown-side li:first-child a').text());
                    
        });
        
        //}), (jQuery);
        
        </script>
   
</div>  
  
  

   
   
   
   



  
  
   
   
   
   
    
    

	<?php /* Show forum tags on the forums directory */
	if ( bp_is_active( 'forums' ) && bp_is_forums_component() && bp_is_directory() ) : ?>
		<div id="forum-directory-tags" class="widget tags">
			<h3 class="widgettitle"><?php _e( 'Forum Topic Tags', 'buddypress' ); ?></h3>
			<div id="tag-text"><?php bp_forums_tag_heat_map(); ?></div>
		</div>
	<?php endif; ?>

	<?php dynamic_sidebar( 'sidebar-5' ); ?>

	<?php do_action( 'bp_inside_after_sidebar' ); ?>

	</div><!-- .padder -->
	</div><!-- .centerer -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>
