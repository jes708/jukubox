<?php

if (!defined('PROREVS_ROOT')) {
    return;
}

global $wpdb;

$wpdb->query("ALTER TABLE {$wpdb->prefix}bp_activity ADD star int(11)");
$wpdb->query("ALTER TABLE {$wpdb->prefix}bp_activity ADD usercheck int(11)");
$wpdb->query("ALTER TABLE {$wpdb->prefix}bp_activity ADD anonymous int(11)");
$wpdb->query("ALTER TABLE {$wpdb->prefix}bp_activity ADD INDEX usercheck (usercheck)");

function prorevs_add_review($user_id, $component, $type, $action, $content,
    $primary_link, $item_id, $secondary_item_id, $date_recorded, $hide_sitewide,
    $mptt_left, $mptt_right, $star, $usercheck, $anonymous)
{
    global $wpdb; 
    $wpdb->query($wpdb->prepare(
        "
            INSERT INTO {$wpdb->prefix}bp_activity
            ( user_id, component, type ,action, content, primary_link,
              item_id, secondary_item_id, date_recorded, hide_sitewide,
              mptt_left, mptt_right, star, usercheck, anonymous)
            VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d)
        ",
        array(
            $user_id,
            $component,
            $type,
            $action,
            $content,
            $primary_link,
            $item_id,
            $secondary_item_id,
            $date_recorded,
            $hide_sitewide,
            $mptt_left,
            $mptt_right,
            $star,
            $usercheck,
            $anonymous
        )
    ));
}

$options = get_option('reviews_options');

if ($options['profile'] == "profile") {
    add_action('bp_before_member_header_meta','prorevs_add_star_loop_header');
    add_action('bp_directory_members_actions','prorevs_add_star_loop_content');

    function prorevs_add_star_loop_header()
    {
        return prorevs_add_star_loop(2);
    }

    function prorevs_add_star_loop_content()
    {
        return prorevs_add_star_loop(1);
    }

    function prorevs_add_star_loop($checkitem)
    {
        global $wpdb;
        if ($checkitem == 1) {
            $check_content_loop = $wpdb->get_results("SELECT AVG(star) AS Average FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_get_member_user_id() . "'");
            $check_content_loop_count = $wpdb->get_col("SELECT star FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_get_member_user_id() . "'");
        } else {




//Schwarz Add
			if (bp_displayed_user_id()) {



//end Schwarz
            $check_content_loop = $wpdb->get_results("SELECT AVG(star) AS Average FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_displayed_user_id() . "'");
            $check_content_loop_count = $wpdb->get_col("SELECT star FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_displayed_user_id() . "'");


// Schwarz Add
} else {
            $check_content_loop = $wpdb->get_results("SELECT AVG(star) AS Average FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_loggedin_user_id() . "'");
            $check_content_loop_count = $wpdb->get_col("SELECT star FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck='" . bp_loggedin_user_id() . "'");
}
//end Schwarz

        }
        if ($check_content_loop[0]->Average != "") {
            $check_show_star_loop = $check_content_loop[0]->Average;
            $demss = 0;
            echo '<span class="rating-top" style="position:relative;top:20px"> ';
            for ($dem = 1; $dem < 6 ; $dem ++){
                if ($dem <= $check_show_star_loop) {
                    echo '<img alt="1 star" src="'.DEPROURL.'/images/star.png">';
                } else {
                    $demss++;
                    if (ceil($check_show_star_loop)- $check_show_star_loop > 0 and $demss == 1) {
                            echo '<img alt="1 star" src="'.DEPROURL.'/images/star_half.png">';
                    } else {
                        echo '<img alt="1 star" src="'.DEPROURL.'/images/star_off.png">';
                    }
                }
            }
            echo ' ('.count($check_content_loop_count).')</span>';
        } else {
            echo '<span class="rating-top" style="position:relative;top:22px;font-weight:bold">No Reviews</span>';
        }
    }

    function prorevs_member_header()
    {
       /* if ($GLOBALS['bp']->current_component == "reviews") {
            return false;
        } else { */ 
            ?>
            <div class="generic-button" style="float:left;position:relative;/*top:-5px*/">
               <!--  <a class="add-reviews button" title="Add reviews for this user." --> 
		<a class="btn btn-primary add-reviews" title="Add reviews for this user."
                    href="<?php /*bp_get_displayed_user_link()*/ // hack to make button work
				$curr_url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; 
				//echo $curr_url; 
				$curr_end = explode("members/", $curr_url); 
				//print_r($curr_end);
				$end_tag = $curr_end[1]; 
				$last_url_bits = explode("/", $end_tag); 
				//print_r($last_url_bits);
				$member_slug = $last_url_bits[0];
				$member_id = get_userdatabylogin($member_slug); 
				$member_id_num = $member_id->ID;
				echo get_home_url() . '/members/' . $member_slug . '/';   
				// NHF EDIT - review button not going to the proper place.  
				 ?>reviews/" id="add_review_<?php echo  $member_id_num; ?>">Add Review</a>
            </div>
            <?php
       /* } */ 
    }
//    add_action('bp_member_header_actions', 'prorevs_member_header');

    //
    // Add the "reviews" tab
    //

    function prorevs_profile_nav()
    {
        function prorevs_reviews_tab()
        {
            function prorevs_reviews_tab_title()
            {
                echo 'Reviews';
            }

            function prorevs_reviews_tab_content()
            {
                require(PROREVS_ROOT . '/css/customstylemembertwo.php');
                require(PROREVS_ROOT . '/includes/postreviewform.php');
            }

            add_action('bp_template_title', 'prorevs_reviews_tab_title');
            add_action('bp_template_content', 'prorevs_reviews_tab_content');
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        }

        bp_core_new_nav_item(array(
            'name' => 'Reviews',
            'slug' => 'reviews',
            'screen_function' => 'prorevs_reviews_tab',
            'position' => 40,
            'item_css_id' => 'prorevs-reviews-tab'
        ));
    }
    add_action('bp_setup_nav', 'prorevs_profile_nav');

    //
    // Process and add a review
    //

    function prorevs_review_limit_exceeded(&$options, $user_id, $usercheck) {
        global $wpdb;

        if ($options['limit'] == 0)
            return false;
$wpdb->show_errors();
        $n_reviews = $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}bp_activity WHERE user_id = %d AND usercheck = %d", array($user_id, $usercheck))
            );

        return $n_reviews >= $options['limit'];
    }

    if (isset($_POST['review_member_submit'])) {
        $current_user = wp_get_current_user();
        $user_reviewd = $_POST['rating_member_id'];
	$user_allInfo = get_userdata($user_reviewd); 
	$user_reviewd_login = $user_allInfo->user_login; 
        $user_reviewd_name = $_POST['rating_member_name'];
        $avartar_reviewd = "";
        $link_set = get_bloginfo('home')."/members/".$current_user->user_login;

        if (!prorevs_review_limit_exceeded($options, $current_user->ID, $user_reviewd)) {
            if (isset($_POST['review_member_content']) and $_POST['review_member_content'] != "") {
                add_action('template_notices','prorevs_add_title_here_success');

                $rating_member = $_POST['rating_member'];
                $contentss .= '<span class="ratingtop">';
                for ($dem = 1; $dem < 6 ; $dem ++) {
                    if ($dem <= $rating_member ) {
                        $contentss .= '<img alt="1 star" src="'.DEPROURL.'/images/star.png">';
                    } else {
                        $contentss .= '<img alt="1 star" src="'.DEPROURL.'/images/star_off.png">';
                    }
                }
                $contentss.='</span>';
                $user_id = $current_user->ID;
                $component = "Members";
                $type = "Member_review";
                $action = "<a href='".$link_set."' title='".$current_user->user_login."'>".$current_user->display_name."</a> posted a review ".$avartar_reviewd." on <a href='".get_bloginfo('home')."/members/".$user_reviewd_login. /*$user_reviewd_name.*/ "'>".$user_reviewd_name."</a>";
                $content = $contentss . htmlspecialchars($_POST['review_member_content']);
                $primary_link = $link_set ;
                $item_id = "";
                $secondary_item_id = "";
                $date_recorded = date('Y-m-d H:i:s ');
                $hide_sitewide = 0;
                $mptt_left = 0;
                $mptt_right = 0;
                $star  = $rating_member;
                $usercheck = $user_reviewd;
                $anonymous = ($options['anonymous'] && isset($_POST['anonymous']) && $_POST['anonymous'] ? 1 : 0);

                prorevs_add_review($user_id, $component, $type, $action, $content, $primary_link,
                    $item_id, $secondary_item_id, $date_recorded, $hide_sitewide, $mptt_left,
                    $mptt_right, $star, $usercheck, $anonymous);

                $setcheckoption = $user_id."-".$usercheck;
                $checkfirst = get_option($setcheckoption);
                if ($checkfirst) {
                    update_option($setcheckoption, $checkfirst + 1);
                } else {
                    add_option($setcheckoption, 1, '', 'yes');
                }
            } else {
                add_action('template_notices', 'prorevs_add_title_here_error_no_content');
            }
        } else {
            add_action('template_notices', 'prorevs_add_title_here_error_limit');
        }
    }

    function prorevs_add_title_here_success()
    {
        echo '
            <div id="message" class="updated">
                <p>Your review was posted successfully!</p>
            </div>
        ';
    }

    function prorevs_add_title_here_error_no_content()
    {
        echo '
            <div id="message" class="error" style="display: block;">
                <p>Please enter some content to post.</p>
            </div>
        ';
    }

    function prorevs_add_title_here_error_limit()
    {
        $options = get_option('reviews_options');
        echo '
            <div id="message" class="error" style="display: block;">
                <p>You can\'t post more than ' . $options['limit'] . ' review(s) for a single user.</p>
            </div>
        ';
    }
}
