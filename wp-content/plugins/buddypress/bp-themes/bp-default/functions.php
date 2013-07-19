<?php
/**
 * BP-Default theme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress and BuddyPress to change core functionality.
 *
 * The first function, bp_dtheme_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails and navigation menus, and
 * for BuddyPress, action buttons and javascript localisation.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development, http://codex.wordpress.org/Child_Themes
 * and http://codex.buddypress.org/theme-development/building-a-buddypress-child-theme/), you can override
 * certain functions (those wrapped in a function_exists() call) by defining them first in your
 * child theme's functions.php file. The child theme's functions.php file is included before the
 * parent theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package BuddyPress
 * @subpackage BP-Default
 * @since 1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// If BuddyPress is not activated, switch back to the default WP theme and bail out
if ( ! function_exists( 'bp_is_active' ) ) {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	return;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 591;

if ( ! function_exists( 'bp_dtheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress and BuddyPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override bp_dtheme_setup() in a child theme, add your own bp_dtheme_setup to your child theme's
 * functions.php file.
 *
 * @global BuddyPress $bp The one true BuddyPress instance
 * @since BuddyPress (1.5)
 */
function bp_dtheme_setup() {

	// Load the AJAX functions for the theme
	require( TEMPLATEPATH . '/_inc/ajax.php' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme comes with all the BuddyPress goodies
	add_theme_support( 'buddypress' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add responsive layout support to bp-default without forcing child
	// themes to inherit it if they don't want to
	add_theme_support( 'bp-default-responsive' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'buddypress' ), // nhf custom menu attmept
//		'bottom-footer' => __('Bottom Footer', 'buddypress' ),
	) );

	// This theme allows users to set a custom background
	$custom_background_args = array(
		'wp-head-callback' => 'bp_dtheme_custom_background_style'
	);
	add_theme_support( 'custom-background', $custom_background_args );

	// Add custom header support if allowed
	if ( !defined( 'BP_DTHEME_DISABLE_CUSTOM_HEADER' ) ) {
		define( 'HEADER_TEXTCOLOR', 'FFFFFF' );

		// The height and width of your custom header. You can hook into the theme's own filters to change these values.
		// Add a filter to bp_dtheme_header_image_width and bp_dtheme_header_image_height to change these values.
		define( 'HEADER_IMAGE_WIDTH',  apply_filters( 'bp_dtheme_header_image_width',  1250 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'bp_dtheme_header_image_height', 133  ) );
		
		//define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'bp_dtheme_header_image_height', 300  ) );
		
		// We'll be using post thumbnails for custom header images on posts and pages. We want them to be 1250 pixels wide by 133 pixels tall.
		// Larger images will be auto-cropped to fit, smaller ones will be ignored.
		set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

		// Add a way for the custom header to be styled in the admin panel that controls custom headers.
		$custom_header_args = array(
			'wp-head-callback' => 'bp_dtheme_header_style',
			'admin-head-callback' => 'bp_dtheme_admin_header_style'
		);
		add_theme_support( 'custom-header', $custom_header_args );
	}

	if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button',           5 );

		// Activity button
		if ( bp_is_active( 'activity' ) )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button',  20 );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button', 20 );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button',           5 );
			add_action( 'bp_group_header_actions',     'bp_group_new_topic_button',      20 );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}
}
add_action( 'after_setup_theme', 'bp_dtheme_setup' );
endif;

if ( !function_exists( 'bp_dtheme_enqueue_scripts' ) ) :
/**
 * Enqueue theme javascript safely
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since BuddyPress (1.5)
 */
function bp_dtheme_enqueue_scripts() {

	// Enqueue the global JS - Ajax will not work without it
	wp_enqueue_script( 'dtheme-ajax-js', get_template_directory_uri() . '/_inc/global.js', array( 'jquery' ), bp_get_version() );

	// Add words that we need to use in JS to the end of the page so they can be translated and still used.
	$params = array(
		'my_favs'           => __( 'My Favorites', 'buddypress' ),
		'accepted'          => __( 'Accepted', 'buddypress' ),
		'rejected'          => __( 'Rejected', 'buddypress' ),
		'show_all_comments' => __( 'Show all comments for this thread', 'buddypress' ),
		'show_all'          => __( 'Show all', 'buddypress' ),
		'comments'          => __( 'comments', 'buddypress' ),
		'close'             => __( 'Close', 'buddypress' ),
		'view'              => __( 'View', 'buddypress' ),
		'mark_as_fav'	    => __( 'Favorite', 'buddypress' ),
		'remove_fav'	    => __( 'Remove Favorite', 'buddypress' )
	);
	wp_localize_script( 'dtheme-ajax-js', 'BP_DTheme', $params );

	// Maybe enqueue comment reply JS
	if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'bp_dtheme_enqueue_scripts' );
endif;

if ( !function_exists( 'bp_dtheme_enqueue_styles' ) ) :
/**
 * Enqueue theme CSS safely
 *
 * For maximum flexibility, BuddyPress Default's stylesheet is enqueued, using wp_enqueue_style().
 * If you're building a child theme of bp-default, your stylesheet will also be enqueued,
 * automatically, as dependent on bp-default's CSS. For this reason, bp-default child themes are
 * not recommended to include bp-default's stylesheet using @import.
 *
 * If you would prefer to use @import, or would like to change the way in which stylesheets are
 * enqueued, you can override bp_dtheme_enqueue_styles() in your theme's functions.php file.
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @see http://codex.buddypress.org/releases/1-5-developer-and-designer-information/
 * @since BuddyPress (1.5)
 */
function bp_dtheme_enqueue_styles() {

	// Register our main stylesheet
	wp_register_style( 'bp-default-main', get_template_directory_uri() . '/_inc/css/default.css', array(), bp_get_version() );

	// If the current theme is a child of bp-default, enqueue its stylesheet
	if ( is_child_theme() && 'bp-default' == get_template() ) {
		wp_enqueue_style( get_stylesheet(), get_stylesheet_uri(), array( 'bp-default-main' ), bp_get_version() );
	}

	// Enqueue the main stylesheet
	wp_enqueue_style( 'bp-default-main' );

	// Default CSS RTL
	if ( is_rtl() )
		wp_enqueue_style( 'bp-default-main-rtl',  get_template_directory_uri() . '/_inc/css/default-rtl.css', array( 'bp-default-main' ), bp_get_version() );

	// Responsive layout
	if ( current_theme_supports( 'bp-default-responsive' ) ) {
		wp_enqueue_style( 'bp-default-responsive', get_template_directory_uri() . '/_inc/css/responsive.css', array( 'bp-default-main' ), bp_get_version() );

		if ( is_rtl() ) {
			wp_enqueue_style( 'bp-default-responsive-rtl', get_template_directory_uri() . '/_inc/css/responsive-rtl.css', array( 'bp-default-responsive' ), bp_get_version() );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bp_dtheme_enqueue_styles' );
endif;

if ( !function_exists( 'bp_dtheme_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in bp_dtheme_setup().
 *
 * @since 1.2
 */
function bp_dtheme_admin_header_style() {
?>
	<style type="text/css">
		#headimg {
			position: relative;
			color: #fff;
			background: url(<?php header_image(); ?>);
			-moz-border-radius-bottomleft: 6px;
			-webkit-border-bottom-left-radius: 6px;
			-moz-border-radius-bottomright: 6px;
			-webkit-border-bottom-right-radius: 6px;
			margin-bottom: 20px;
			height: 133px;
		}

		#headimg h1{
			position: absolute;
			bottom: 15px;
			left: 15px;
			width: 44%;
			margin: 0;
			font-family: Arial, Tahoma, sans-serif;
		}
		#headimg h1 a{
			color:#<?php header_textcolor(); ?>;
			text-decoration: none;
			border-bottom: none;
		}
		#headimg #desc{
			color:#<?php header_textcolor(); ?>;
			font-size:1em;
			margin-top:-0.5em;
		}

		#desc {
			display: none;
		}

		<?php if ( 'blank' == get_header_textcolor() ) { ?>
		#headimg h1, #headimg #desc {
			display: none;
		}
		#headimg h1 a, #headimg #desc {
			color:#<?php echo HEADER_TEXTCOLOR; ?>;
		}
		<?php } ?>
	</style>
<?php
}
endif;

if ( !function_exists( 'bp_dtheme_custom_background_style' ) ) :
/**
 * The style for the custom background image or colour.
 *
 * Referenced via add_custom_background() in bp_dtheme_setup().
 *
 * @see _custom_background_cb()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_custom_background_style() {
	$background = get_background_image();
	$color = get_background_color();
	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $style && !$background ) {
		$style .= ' background-image: none;';

	} elseif ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
?>
	<style type="text/css">
		body { <?php echo trim( $style ); ?> }
	</style>
<?php
}
endif;

if ( !function_exists( 'bp_dtheme_header_style' ) ) :
/**
 * The styles for the post thumbnails / custom page headers.
 *
 * Referenced via add_custom_image_header() in bp_dtheme_setup().
 *
 * @global WP_Query $post The current WP_Query object for the current post or page
 * @since 1.2
 */
function bp_dtheme_header_style() {
	global $post;

	$header_image = '';

	if ( is_singular() && current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );

		// $src, $width, $height
		if ( !empty( $image ) && $image[1] >= HEADER_IMAGE_WIDTH )
			$header_image = $image[0];
		else
			$header_image = get_header_image();

	} else {
		$header_image = get_header_image();
	}
?>

	<style type="text/css">
		<?php if ( !empty( $header_image ) ) : ?>
			#header { background-image: url(<?php echo $header_image ?>); }
		<?php endif; ?>

		<?php if ( 'blank' == get_header_textcolor() ) { ?>
		#header h1, #header #desc { display: none; }
		<?php } else { ?>
		#header h1 a, #desc { color:#<?php header_textcolor(); ?>; }
		<?php } ?>
	</style>

<?php
}
endif;

if ( !function_exists( 'bp_dtheme_widgets_init' ) ) :
/**
 * Register widgetised areas, including one sidebar and four widget-ready columns in the footer.
 *
 * To override bp_dtheme_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since BuddyPress (1.5)
 */
function bp_dtheme_widgets_init() {

	// Area 1, located in the sidebar. Empty by default.
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar-1',
		'description'   => __( 'The sidebar widget area', 'buddypress' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
	) );

	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'buddypress' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'buddypress' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'buddypress' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'buddypress' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
	// NHF - added bottom footer widget area
	// Area 6, bottom footer menu .
	register_sidebar( array(
		'name' => __( ' Footer Bottom Widget Area', 'buddypress' ),
		'id' => 'bottom-footer-widget-area',
		'description' => __( 'The bottom footer widget area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( ' Footer Bottom CP Area', 'buddypress' ),
		'id' => 'bottom-footer-cp-area',
		'description' => __( 'The bottom footer copyrite area', 'buddypress' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'bp_dtheme_widgets_init' );
endif;

if ( !function_exists( 'bp_dtheme_blog_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bp_dtheme_blog_comments(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @param mixed $comment Comment record from database
 * @param array $args Arguments from wp_list_comments() call
 * @param int $depth Comment nesting level
 * @see wp_list_comments()
 * @since 1.2
 */
function bp_dtheme_blog_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type )
		return false;

	if ( 1 == $depth )
		$avatar_size = 50;
	else
		$avatar_size = 25;
	?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-avatar-box">
			<div class="avb">
				<a href="<?php echo get_comment_author_url(); ?>" rel="nofollow">
					<?php if ( $comment->user_id ) : ?>
						<?php echo bp_core_fetch_avatar( array( 'item_id' => $comment->user_id, 'width' => $avatar_size, 'height' => $avatar_size, 'email' => $comment->comment_author_email ) ); ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, $avatar_size ); ?>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<div class="comment-content">
			<div class="comment-meta">
				<p>
					<?php
						/* translators: 1: comment author url, 2: comment author name, 3: comment permalink, 4: comment date/timestamp*/
						printf( __( '<a href="%1$s" rel="nofollow">%2$s</a> said on <a href="%3$s"><span class="time-since">%4$s</span></a>', 'buddypress' ), get_comment_author_url(), get_comment_author(), get_comment_link(), get_comment_date() );
					?>
				</p>
			</div>

			<div class="comment-entry">
				<?php if ( $comment->comment_approved == '0' ) : ?>
				 	<em class="moderate"><?php _e( 'Your comment is awaiting moderation.', 'buddypress' ); ?></em>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div>

			<div class="comment-options">
					<?php if ( comments_open() ) : ?>
						<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
					<?php endif; ?>

					<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<?php printf( '<a class="button comment-edit-link bp-secondary-action" href="%1$s" title="%2$s">%3$s</a> ', get_edit_comment_link( $comment->comment_ID ), esc_attr__( 'Edit comment', 'buddypress' ), __( 'Edit', 'buddypress' ) ); ?>
					<?php endif; ?>

			</div>

		</div>

<?php
}
endif;

if ( !function_exists( 'bp_dtheme_page_on_front' ) ) :
/**
 * Return the ID of a page set as the home page.
 *
 * @return false|int ID of page set as the home page
 * @since 1.2
 */
function bp_dtheme_page_on_front() {
	if ( 'page' != get_option( 'show_on_front' ) )
		return false;

	return apply_filters( 'bp_dtheme_page_on_front', get_option( 'page_on_front' ) );
}
endif;

if ( !function_exists( 'bp_dtheme_activity_secondary_avatars' ) ) :
/**
 * Add secondary avatar image to this activity stream's record, if supported.
 *
 * @param string $action The text of this activity
 * @param BP_Activity_Activity $activity Activity object
 * @package BuddyPress Theme
 * @return string
 * @since 1.2.6
 */
function bp_dtheme_activity_secondary_avatars( $action, $activity ) {
	switch ( $activity->component ) {
		case 'groups' :
		case 'friends' :
			// Only insert avatar if one exists
			if ( $secondary_avatar = bp_get_activity_secondary_avatar() ) {
				$reverse_content = strrev( $action );
				$position        = strpos( $reverse_content, 'a<' );
				$action          = substr_replace( $action, $secondary_avatar, -$position - 2, 0 );
			}
			break;
	}

	return $action;
}
add_filter( 'bp_get_activity_action_pre_meta', 'bp_dtheme_activity_secondary_avatars', 10, 2 );
endif;

if ( !function_exists( 'bp_dtheme_show_notice' ) ) :
/**
 * Show a notice when the theme is activated - workaround by Ozh (http://old.nabble.com/Activation-hook-exist-for-themes--td25211004.html)
 *
 * @since 1.2
 */
function bp_dtheme_show_notice() {
	global $pagenow;

	// Bail if bp-default theme was not just activated
	if ( empty( $_GET['activated'] ) || ( 'themes.php' != $pagenow ) || !is_admin() )
		return;

	?>

	<div id="message" class="updated fade">
		<p><?php printf( __( 'Theme activated! This theme contains <a href="%s">custom header image</a> support and <a href="%s">sidebar widgets</a>.', 'buddypress' ), admin_url( 'themes.php?page=custom-header' ), admin_url( 'widgets.php' ) ); ?></p>
	</div>

	<style type="text/css">#message2, #message0 { display: none; }</style>

	<?php
}
add_action( 'admin_notices', 'bp_dtheme_show_notice' );
endif;

if ( !function_exists( 'bp_dtheme_main_nav' ) ) :
/**
 * wp_nav_menu() callback from the main navigation in header.php
 *
 * Used when the custom menus haven't been configured.
 *
 * @param array Menu arguments from wp_nav_menu()
 * @see wp_nav_menu()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_main_nav( $args ) {
	$pages_args = array(
		'depth'      => 0,
		'echo'       => false,
		'exclude'    => '',
		'title_li'   => ''
	);
	$menu = wp_page_menu( $pages_args );
	$menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<ul id="nav">', '</ul><!-- #nav -->' ), $menu );
	echo $menu;

	do_action( 'bp_nav_items' );
}
endif;

if ( !function_exists( 'bp_dtheme_page_menu_args' ) ) :
/**
 * Get our wp_nav_menu() fallback, bp_dtheme_main_nav(), to show a home link.
 *
 * @param array $args Default values for wp_page_menu()
 * @see wp_page_menu()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bp_dtheme_page_menu_args' );
endif;

if ( !function_exists( 'bp_dtheme_comment_form' ) ) :
/**
 * Applies BuddyPress customisations to the post comment form.
 *
 * @param array $default_labels The default options for strings, fields etc in the form
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_comment_form( $default_labels ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$fields    =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'buddypress' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'buddypress' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'buddypress' ) . '</label>' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$new_labels = array(
		'comment_field'  => '<p class="form-textarea"><textarea name="comment" id="comment" cols="60" rows="10" aria-required="true"></textarea></p>',
		'fields'         => apply_filters( 'comment_form_default_fields', $fields ),
		'logged_in_as'   => '',
		'must_log_in'    => '<p class="alert">' . sprintf( __( 'You must be <a href="%1$s">logged in</a> to post a comment.', 'buddypress' ), wp_login_url( get_permalink() ) )	. '</p>',
		'title_reply'    => __( 'Leave a Comment', 'buddypress' )
	);

	return apply_filters( 'bp_dtheme_comment_form', array_merge( $default_labels, $new_labels ) );
}
add_filter( 'comment_form_defaults', 'bp_dtheme_comment_form', 10 );
endif;

if ( !function_exists( 'bp_dtheme_before_comment_form' ) ) :
/**
 * Adds the user's avatar before the comment form box.
 *
 * The 'comment_form_top' action is used to insert our HTML within <div id="reply">
 * so that the nested comments comment-reply javascript moves the entirety of the comment reply area.
 *
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_before_comment_form() {
?>
	<div class="comment-avatar-box">
		<div class="avb">
			<?php if ( bp_loggedin_user_id() ) : ?>
				<a href="<?php echo bp_loggedin_user_domain(); ?>">
					<?php echo get_avatar( bp_loggedin_user_id(), 50 ); ?>
				</a>
			<?php else : ?>
				<?php echo get_avatar( 0, 50 ); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="comment-content standard-form">
<?php
}
add_action( 'comment_form_top', 'bp_dtheme_before_comment_form' );
endif;

if ( !function_exists( 'bp_dtheme_after_comment_form' ) ) :
/**
 * Closes tags opened in bp_dtheme_before_comment_form().
 *
 * @see bp_dtheme_before_comment_form()
 * @see comment_form()
 * @since BuddyPress (1.5)
 */
function bp_dtheme_after_comment_form() {
?>

	</div><!-- .comment-content standard-form -->

<?php
}
add_action( 'comment_form', 'bp_dtheme_after_comment_form' );
endif;

if ( !function_exists( 'bp_dtheme_sidebar_login_redirect_to' ) ) :
/**
 * Adds a hidden "redirect_to" input field to the sidebar login form.
 *
 * @since BuddyPress (1.5)
 */
function bp_dtheme_sidebar_login_redirect_to() {
	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	$redirect_to = apply_filters( 'bp_no_access_redirect', $redirect_to ); ?>

	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />

<?php
}
add_action( 'bp_sidebar_login_form', 'bp_dtheme_sidebar_login_redirect_to' );
endif;

if ( !function_exists( 'bp_dtheme_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @global WP_Query $wp_query
 * @param string $nav_id DOM ID for this navigation
 * @since BuddyPress (1.5)
 */
function bp_dtheme_content_nav( $nav_id ) {
	global $wp_query;

	if ( !empty( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) : ?>

		<div id="<?php echo $nav_id; ?>" class="navigation">
			<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ); ?></div>
		</div><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}
endif;

/**
 * Adds the no-js class to the body tag.
 *
 * This function ensures that the <body> element will have the 'no-js' class by default. If you're
 * using JavaScript for some visual functionality in your theme, and you want to provide noscript
 * support, apply those styles to body.no-js.
 *
 * The no-js class is removed by the JavaScript created in bp_dtheme_remove_nojs_body_class().
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see bp_dtheme_remove_nojs_body_class()
 */
function bp_dtheme_add_nojs_body_class( $classes ) {
	$classes[] = 'no-js';
	return array_unique( $classes );
}
add_filter( 'bp_get_the_body_class', 'bp_dtheme_add_nojs_body_class' );

/**
 * Dynamically removes the no-js class from the <body> element.
 *
 * By default, the no-js class is added to the body (see bp_dtheme_add_no_js_body_class()). The
 * JavaScript in this function is loaded into the <body> element immediately after the <body> tag
 * (note that it's hooked to bp_before_header), and uses JavaScript to switch the 'no-js' body class
 * to 'js'. If your theme has styles that should only apply for JavaScript-enabled users, apply them
 * to body.js.
 *
 * This technique is borrowed from WordPress, wp-admin/admin-header.php.
 *
 * @package BuddyPress
 * @since BuddyPress (1.5).1
 * @see bp_dtheme_add_nojs_body_class()
 */
function bp_dtheme_remove_nojs_body_class() {
?><script type="text/javascript">//<![CDATA[
(function(){var c=document.body.className;c=c.replace(/no-js/,'js');document.body.className=c;})();
//]]></script>
<?php
}
add_action( 'bp_before_header', 'bp_dtheme_remove_nojs_body_class' );

?>

<?php 
/*
function finch_mysql_query($QueryString, $display_or_return) {

        $make_query = mysql_query($QueryString) or die(mysql_error());
        while ( $row = mysql_fetch_assoc($make_query) ) {
                $all_rows_array[] = $row;

        }
} */


// NHF - this makes certain services free
// free services are First lessons, make up lessons (ids 2 and 3) 

function reset_price( $price, $service, $worker, $user ) {
// Replace 3 with your free service ID
if ( 2 == $service || 3 == $service   )
$price = 0;
return $price;
}
add_filter( 'app_paypal_amount', 'reset_price', 10, 4 );
add_filter( 'app_get_price', 'reset_price', 10, 4 );


//NHF CUSTOM AJAX FUNCTIONS
 
function cancelAppointment() { 
	$lessons_to_cancel = $_POST['LessonIdsToCancel']; 
	$canceller = $_POST['canceller'];
	$cancellation_notice = htmlentities(stripslashes(urldecode($_POST['cancelnotice']))); 

	$stuffback['lessons to cancel'] = $lessons_to_cancel;
	$stuffback['canceller'] = $canceller;
	$stuffback['cancellation notice'] = $cancellation_notice; 
        $cancel_lessons_array = explode(',', $lessons_to_cancel); 
	
	$cancel_stuff = cancellation_email($canceller, $lessons_to_cancel, $cancellation_notice); 
	
	$change_query = "UPDATE
				wp_app_appointments
			SET
				status = 'removed'
			WHERE 
				ID IN ( " . $lessons_to_cancel . " ) 
			"; 
	
	$cancel = finch_mysql_noreturn_query($change_query);  
	//$stuffback[] = $cancel;
	//$test[] = "one"; 
	//$test[] = "two";
 
	$json_stuffback = json_encode($stuffback);
	
	//$json_stuffback = json_encode($cancel_stuff);
	//$json_stuffback = "This is a string";  
	echo $json_stuffback;   
	//$string = implode(',', $stuffback); 
	//die($string)
	die(); 
}
// create ajax call

add_action( 'wp_ajax_nopriv_cancelAppointment', 'cancelAppointment' );  
add_action( 'wp_ajax_cancelAppointment', 'cancelAppointment' );

function requestLessonApproval() { 

	$cell = $_POST['AppCell']; 
	$appID = $_POST['AppId']; 
	$appService = stripslashes(urldecode($_POST['AppService']));

	$cell_array = explode(':', $cell); 

	$new_lesson = $appID; 

	$test_array[] = $appService; 
  
	$lesson_query = "SELECT 
                                xprofile0.ID,
				xprofile0.start, 
                                xprofile1.value AS user_name,
				xprofile15.user_email AS user_email, 
                                xprofile2.value AS worker_name,
				xprofile3.user_email AS worker_email    
                        FROM 
                                wp_app_appointments xprofile0
                        INNER JOIN
                                wp_bp_xprofile_data xprofile1
                        ON 
                                xprofile0.user = xprofile1.user_id
                        INNER JOIN
                                wp_bp_xprofile_data xprofile2
                        ON
                                xprofile0.worker = xprofile2.user_id	
			INNER JOIN
				wp_users xprofile3
			ON
				xprofile0.worker = xprofile3.ID
			INNER JOIN
				wp_users xprofile15
			ON
				xprofile0.user = xprofile15.ID 
			WHERE
				xprofile0.id = " . $new_lesson . "
			AND
				xprofile1.field_id = 1
			AND
				xprofile2.field_id = 1
			";  


	$lessons_array = finch_mysql_query($lesson_query, "return"); 

	$client_name = $lessons_array[0]['user_name']; 
	$client_email = $lessons_array[0]['user_email']; 
	$worker_name = $lessons_array[0]['worker_name']; 
	$worker_email = $lessons_array[0]['worker_email'];
	$lesson_type = $appService;

	$lesson_start = $lessons_array[0]['start']; 
	$lesson_start_timestamp = strtotime($lesson_start);
	
		// NHF - put these in later to format time properly! 
		/*$finch_tz = new DateTimeZone('America/New_York'); 
	
		$finch_date = new DateTime();
		$finch_date->setTimestamp($start); 
		$finch_date->setTimeZone($finch_tz); 
		$finch_start_date = $finch_date->format('l, F j, Y, g:i a T');  */ 

 
	$lesson_start_readable = date("l, F j, Y, g:i a", $lesson_start_timestamp); 
  

	$fromEmail = "Jukubox <jukubox@jukubox.com>"; 
	$subjectTag = "[Jukubox]"; 	
	$clientTo = $client_name . ' <' .  $client_email . '>'; 
	$workerTo = $worker_name . ' <' . $worker_email . '>';

	$clientSubject = $subjectTag . " You have requested a " . $lesson_type . " with " . $worker_name; 
	$workerSubject = $subjectTag . " New " .  $lesson_type . " request from " . $client_name . "!"; 

	$fromheader = "From: " . $fromEmail . ""; 
	$bccheader = "Bcc: " . $fromEmail . "";

	$headers[] = $fromheader; 
	$headers[] = $bccheader; 

	$message = "Greetings " . $worker_name . ", 

" . $client_name . " has requested a " . $lesson_type . " with you on

	" . $lesson_start_readable . " EDT

To confirm or deny this appointment, log in to http://www.jukubox.com - You'll see a button on the homepage to confirm the appointment, or click on the 'Confirm Appointments' menu item.  

Sincerely,
The Jukubox Team
";   

	$clientMessage = "Below is a copy of what was sent to your prospective teacher


"; 
	$clientMessage .= $message;  

	$workerMessage = $message; 
	wp_mail( $clientTo, $clientSubject, $clientMessage, $headers );
	 
	wp_mail( $workerTo, $workerSubject, $workerMessage, $headers  );
 

	$json_array[] = $test_array;  
	$finaljson_array = json_encode($json_array); 
	echo $finaljson_array; 
	die(); 

}  

add_action( 'wp_ajax_nopriv_requestLessonApproval', 'requestLessonApproval' );  
add_action( 'wp_ajax_requestLessonApproval', 'requestLessonApproval' );


function finchJsonTest() { 
	$json_array[] = 'This is something!'; 
	$finaljson_array = json_encode($json_array); 
	echo $finaljson_array; 
	die(); 

}  

add_action( 'wp_ajax_nopriv_finchJsonTest', 'finchJsonTest' );  
add_action( 'wp_ajax_finchJsonTest', 'finchJsonTest' );


function getNewRoomKey() { 
	
	
	$pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
	
	$make_new_room = "INSERT INTO
				wp_juku_newrooms(
					room_key,
					created_date)
				VALUES(
					'" . $pass . "', 
					NOW() 
				)"; 
	
	finch_mysql_noreturn_query($make_new_room); 	
	

	$json_array['passcode'] = $pass; 
	$finaljson_array = json_encode($json_array); 
	echo $finaljson_array; 
	die(); 

}  

add_action( 'wp_ajax_nopriv_getNewRoomKey', 'getNewRoomKey' );  
add_action( 'wp_ajax_getNewRoomKey', 'getNewRoomKey' );


function cancellation_email($CancellerId, $lessons_to_cancel, $cancellation_notice='') { 


 $lesson_query = "SELECT 
                                xprofile0.*, 
                                xprofile1.value AS user_name,
                                xprofile2.value AS worker_name
                        FROM 
                                wp_app_appointments xprofile0
                        INNER JOIN
                                wp_bp_xprofile_data xprofile1
                        ON 
                                xprofile0.user = xprofile1.user_id
                        INNER JOIN
                                wp_bp_xprofile_data xprofile2
                        ON
                                xprofile0.worker = xprofile2.user_id
			WHERE
				xprofile0.worker = " . $CancellerId . "
			AND
				xprofile0.id = " . $lessons_to_cancel . "
			AND
				xprofile1.field_id = 1
			AND
				xprofile2.field_id = 1
			";

	$lessons_array = finch_mysql_query($lesson_query, "return");  

	$get_worker_email = "SELECT
					user_email
				FROM
					wp_users
				WHERE
					ID = " . $CancellerId . "
				"; 
	$workeremailarray = finch_mysql_query($get_worker_email, "return");

	

	$worker_email = $workeremailarray[0]['user_email'];
	//echo $worker_email;  
	$client_email = $lessons_array[0]['email']; 
	$start_tstamp = strtotime($lessons_array[0]['start']);
	$start_date = date("l, F j, Y, g:i a", $start_tstamp); 
	$worker_name = $lessons_array[0]['worker_name']; 
	$client_name = $lessons_array[0]['user_name']; 
	$lesson_status = $lessons_array[0]['status']; 
	$service_id = $lessons_array[0]['service'];
	$lesson_id_number = $lessons_array[0]['ID'];  

	// get the service name
	$service_name = "SELECT
				ID,name
			FROM
				wp_app_services
			WHERE
				ID = " . $service_id . "
			"; 
	$service_name_array = finch_mysql_query($service_name, "return"); 

	$service_real_name = $service_name_array[0]['name']; 
	$service_id = $service_name_array[0]['ID'];  
 
	$clientTo = $client_name . ' <' . $client_email . '>'; 
	$workerTo = $worker_name . ' <' . $worker_email . '>'; 
	$subject_tag = "[Jukubox]"; 
	$cancelReason= $cancellation_notice; 	
	if( $lesson_status != "confirmed" ) {
		 
		$workerSubject = $subject_tag . " Your " . $service_real_name . " (ID: " . $lesson_id_number . ") denial for " . $client_name . "";
		$subject = $subject_tag . " Your " . $service_real_name . " (ID: " . $lesson_id_number . ") request with " . $worker_name . " has been denied. ";
		$message = "Greetings " . $client_name . ",

Your request for a " . $service_real_name . " with " . $worker_name . " on " . $start_date . " EDT was denied, for the following reason -
 
\"" . $cancelReason . "\"
 
Please feel free to contact " . $worker_name . " or Jukubox if you have any further questions or concerns."; 
if( ($service_id == 1) && ($lesson_status != 'pending')  ) { $message .="

A refund for this " . $service_real_name . " will be issued to you."; 
} 
$message.= " 

			
Sincerely,
Jukubox";  
			
	} 
	else {
		 
		$workerSubject = $subject_tag . " Your " . $service_real_name . " cancellation for " . $client_name . " (ID: " . $lesson_id_number . ")";
		$subject = $subject_tag . " Your " . $service_real_name . " with " . $worker_name . " has been cancelled.  (ID: " . $lesson_id_number . ")" ;
		 
		$message = "Greetings " . $client_name . ",

Your " . $service_real_name . " with " . $worker_name . " on 

" . $start_date . " EDT

was cancelled, for the following reason -

\"" . $cancelReason . "\"

Please feel free to contact " . $worker_name . " or Jukubox if you have any further questions or concerns, or to schedule a make-up lesson if applicable.

If this has happened many times without make-ups and you have questions about our refund policies, please contact us at www.jukubox.com.  

Sincerely,
Jukubox";  
	} 
	//echo $message; 
		$worker_refund_msg = "Your student will be refunded


"; 
		$workerMessage = "Below is a copy of what what sent to your client
		

";
	if( $service_id == 1) { // if this is a paymetn lesson that was confirmed and paid for
		$workerMessage .= $worker_refund_msg; 	
/*		$studentMessage = "A refund will be issued regarding the cancellation below: 

"; 
		$studentMessage .= $message; 	
		$message = $studentMessage;  */ 
	
		$headersWorker[] = "Cc: refunds@jukubox.com"; 
	
		$headersStudent[] = "Content-Description: Stuff"; 	
	} 
	else
	{ 
		$headersWorker[] = "From: Jukubox <jukubox@jukubox.com>";
		 $headersStudent[] = "From: Jukubox <jukubox@jukubox.com>";
	} 
		$workerMessage .= 
$message;  
	wp_mail( $clientTo, $subject, $message, $headersStudent  );
	 
	wp_mail( $workerTo, $workerSubject, $workerMessage, $headersWorker );

	//return $lessons_array;  
} 

function bp_is_my_friend( $worker_id) {
global $user_id; 
global $bp;

if ( ‘is_friend’ == friends_check_friendship_status( $user_id,$worker_id) ){ 

	return true;
} 
else { 
return false;
} 

} 

  
function finch_mysql_query($QueryString, $display_or_return) { 

	$make_query = mysql_query($QueryString) or die(mysql_error()); 
	while ( $row = mysql_fetch_assoc($make_query) ) { 
		$all_rows_array[] = $row; 

	} 

	$all_rows_html = '<pre>' . print_r($all_rows_array, TRUE) . '</pre>'; 
	
	if( $display_or_return == "display" ) 
	{ 
		echo $all_rows_html; 
	} 
	else
	{ 
		return $all_rows_array;
	}  

}


function finch_mysql_noreturn_query($QueryString) { 

	$make_query = mysql_query($QueryString) or die(mysql_error());
	return 'success';  

}

// get all teacher ids that are a certain role and play a certain instrument
function filter_by_role_and_instrument($Role, $Instrument) { 

	$get_all_cellists_query = "SELECT DISTINCT
					xprofile1.*, xprofile3.value AS role, xprofile2.value AS instruments
				FROM
					wp_bp_xprofile_data xprofile1
				INNER JOIN
					wp_bp_xprofile_data xprofile2
				ON
					xprofile1.user_id = xprofile2.user_id
				INNER JOIN
					wp_bp_xprofile_data xprofile3
				ON
					xprofile1.user_id = xprofile3.user_id
				WHERE
					xprofile1.field_id = 1
				AND
					xprofile2.field_id = 2
				AND
					xprofile2.value LIKE '%" . $Instrument .  "%' 
				AND
					xprofile3.value LIKE '" . $Role .  "'
				"; 
	$get_all_cellists_array = finch_mysql_query($get_all_cellists_query, "return");
	// finch_mysql_query($get_all_cellists_query, "display"); 
	$addtostring = array(); 
	if( $get_all_cellists_array ) { 
		foreach($get_all_cellists_array as $key => $value) { 
			$addtostring[] = $value['user_id']; 
		} 

		$addtostring_string = implode(',', $addtostring);
		return $addtostring_string; 
	} 
	else { 
		return false; 
	}    
}

function fixed_order_by_rating( $string ) { 

	$string_array = explode(',', $string); 
	//echo '<pre>'; print_r($string_array); echo '</pre>'; 
	foreach( $string_array as $key => $value ) { 
		$all_num_array[$value] = ''; 
	} 
	//echo '<pre>'; print_r($all_num_array); echo '</pre>'; 
	$result_array = finch_mysql_query("SELECT AVG(star) AS average,usercheck FROM wp_bp_activity WHERE  type = 'Member_review' AND usercheck IN( " . $string. ") GROUP BY usercheck ORDER BY average DESC", "return" );//finch_mysql_query("SELECT AVG(star) AS average,usercheck FROM wp_bp_activity WHERE  type = 'Member_review' AND usercheck IN( " . $string. ") GROUP BY usercheck ORDER BY average DESC", "display" );
	foreach( $result_array as $key => $value ) { 
		$key_new = $value['usercheck']; 
		$all_rate_string_array[] = $key_new; 
		$all_rate_array[$key_new] = ''; 	

	} 
//	echo '<pre>All Rate Array'; print_r($all_rate_array); echo '</pre>';
	foreach( $all_num_array as $key => $value ) { 
		if( !isset($all_rate_array[$key]) ) { 
			$noRated[$key] = '';
			$noRated_string_array[] = $key;  	
		} 
	}  
//	echo '<pre>'; print_r($noRated); echo '</pre>';
	$rated_string = implode(',', $all_rate_string_array); 
//	echo 'Rated String: ' . $rated_string; 
	$noRated_string = implode(',', $noRated_string_array); 
//	echo 'No Rated String: ' . $noRated_string;
	$fullString = $rated_string; 
	if( $noRated_string ) { 
		$fullString .= ',' . $noRated_string;
	}  
//	echo 'Full String: ' . $fullString;
	return $fullString;   
 
} 

function order_by_rating( $string ) {
	$string_array = explode(',', $string); 
	print_r($string_array);
	$reviewed = Array(); 
	$theRest = Array(); 
 
	foreach( $string_array as $key => $value ) {  
//	 $check_content_loop = $wpdb->get_results("SELECT AVG(star) AS Average,usercheck FROM " . $wpdb->prefix . "bp_activity WHERE  type = 'Member_review' AND usercheck = '" . $value . "'");
		$result_array = finch_mysql_query("SELECT AVG(star) AS Average,usercheck FROM wp_bp_activity WHERE  type = 'Member_review' AND usercheck = '" . $value . "'", "return" );
		$actual_result = $result_array[0]; 
		$actual_result['ID'] = $value; 
		echo '<pre>'; 
		print_r($actual_result); 
		echo '</pre>'; 
		if( empty($actual_result['Average']) ) {  
			$theRest[ $actual_result['Average'] ] = $actual_result; 
 		} 
		/*echo '<pre>'; 
		print_r($check_content_loop); 
		echo '</pre>'; */ 
	//	echo '<h1>Hello' . $string . '</h1>'; 
		echo 'hello!'; 
	}  
	print_r($theRest); 
}  

function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    
    $widget_name = wp_specialchars($widget_name);
    
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','widget'); 


function get_random_teachers() { 

	$rand_teach_query = "SELECT
				user_id
			FROM
				wp_bp_xprofile_data
			WHERE
				value = 'Teacher'
			ORDER BY
				RAND() 
			LIMIT
				4
			"; 

	$rand_array = finch_mysql_query($rand_teach_query, "return"); 
	foreach ($rand_array as $key => $value ) { 
		$id = $value['user_id']; 
		$id_array[] = $id;  
	} 

	$id_string = implode(',', $id_array); 
	return 'include=' . $id_string; 

} 

function finch_excerpt( $passage, $number ) { 

 $words_array = explode(' ', $passage);
                                $words_number = count($words_array);
                                //echo $words_number;  
                                //print_r($words_array); 
                                $excerpt = /*get_the_content(); */ implode(' ', array_slice($words_array, 0, $number)); // this is like 'get_the_excerpt' except it will allow html to come through, needed for the youtube video
		 if( $words_number > $number ) {
                                        $excerpt .="...";
                                }

		return $excerpt; 
	

}

function objectToArray($d) {
                if (is_object($d)) {
                        // Gets the properties of the given object
                        // with get_object_vars function
                        $d = get_object_vars($d);
                }

                if (is_array($d)) {
                        /*
                        * Return array converted to object
                        * Using __FUNCTION__ (Magic constant)
                        * for recursive call
                        */
                        return array_map(__FUNCTION__, $d);
                }
                else {
                        // Return array
                        return $d;
                }
}
               
// change image height
add_image_size( 'category-finch', 9999, 300); 

function wps_admin_bar_removeWP() { 
	global $wp_admin_bar; 
	$wp_admin_bar->remove_menu('wp-logo'); 
} 

add_action( 'wp_before_admin_bar_render', 'wps_admin_bar_removeWP' ); 

add_image_size('juku-thumb', 670, 300, true); 

// change "howdy" 

add_action( 'admin_bar_menu', 'voodoo_welcome_swap', 11 );

function voodoo_welcome_swap( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('%1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}

// end change howdy


// check to see if student already has an appointment pending

function checkPendingAppointment() {
	$worker_id = $_POST['workerId'];
	$student_id = $_POST['studentId']; 

	$check_pending_lessons_query = "SELECT 
						ID 
					FROM
						wp_app_appointments
					WHERE
						user = '" . $student_id . "'
					AND 
						worker = '" . $worker_id . "'
					AND 
						status = 'pending'
					";  
	$check_pending_array = finch_mysql_query($check_pending_lessons_query, "return"); 
	if(!$check_pending_array) { 
		$check_pending_array = 0; 
	}
	else { 
		$check_pending_array = 1; 
	}   	
						 
	$json_array[] = $check_pending_array; 
	$finaljson_array = json_encode($json_array); 
	echo $finaljson_array; 
	die(); 

}  

add_action( 'wp_ajax_nopriv_checkPendingAppointment', 'checkPendingAppointment' );  
add_action( 'wp_ajax_checkPendingAppointment', 'checkPendingAppointment' );



// end appointment pending

// remove site title, back end link for non-admin users
function remove_admin_bar_links() {
	global $wp_admin_bar;
	if( !current_user_can( 'administrator' ) ) { 
		$wp_admin_bar->remove_menu('site-name');
	//	$wp_admin_bar->remove_menu('my-account');
	} 
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
// end remove site title

function isCurrency($number)
{
  return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
} 

function had_first_lesson($user_id, $worker_id) { 
	$had_free_lesson_query = "
		SELECT
			*
		FROM
			wp_app_appointments
		WHERE
			service = 2
		AND
			user = " . $user_id . "
		AND
			worker = " . $worker_id . "
		AND
			start <= NOW()
		AND
			status = 'completed' 
		"; 
	$had_free_lesson_array = finch_mysql_query($had_free_lesson_query, "return"); 	
	if( empty($had_free_lesson_array) ) { 
		return false; 
	} 
	else { 
		return true; 
	} 

}



    function test_head() { 
	
	  echo'  
		<div class="generic-button friend_slab_' . bp_get_member_user_id() . '" id="test-button"><a href="' . get_home_url() . '/test-appointment/?app_provider_id=' . bp_get_member_user_id() . '&app_service_id=1" title="Schedule a private lesson with this user." class="send-message">Schedule a Lesson!</a></div>'; 

	  

    } 

    //add_action('bp_directory_members_actions', 'test_head');

// to ad a button to members header
//   add_action('bp_member_header_actions', 'test_head');
  register_sidebar(array(
    'name' => 'Name of Widgetized Area',
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
); 


function get_cur_teacher_price($user_id) { 
        $get_price = "SELECT
                                price
                        FROM
                                wp_app_workers
                        WHERE
                                ID = " . $user_id . "
                        ";
        $get_price_array = finch_mysql_query($get_price, "return");
                                                        
        $price = $get_price_array[0]['price'];                  
        return $price;                                  
}

function get_halfhour_price($worker) {
	$get_halfhour_sql = "SELECT
					price_half_hour
				FROM
					wp_app_workers
				WHERE
					ID='" . $worker . "'
				"; 
	$get_halfhour_array = finch_mysql_query($get_halfhour_sql, "return"); 

	$halfhour_price = $get_halfhour_array[0]['price_half_hour']; 
	return $halfhour_price; 

}
// generate hashes for possible lessons
function serivces_hash($Total_or_worker, $userId='') { 
    if($Total_or_worker == "total" ) { 
	$avail_serv_query = "SELECT 
					ID, name
				FROM
					wp_app_services
			     "; 
	$avail_serv_array = finch_mysql_query($avail_serv_query, "return"); 
	foreach( $avail_serv_array as $key => $value ) { 
		$avail_serv_hash[ $value['ID'] ] = 'service';   
	}
	$avail_serv_both['array'] = $avail_serv_array; 
	$avail_serv_both['hash'] = $avail_serv_hash; 
	//print_r($avail_serv_hash);
	return $avail_serv_both; 
    } 
    else if($Total_or_worker == "worker" ){ 
	$get_services = "SELECT
				services_provided
			FROM
				wp_app_workers
			WHERE
				ID=" . $userId . " 
			"; 
	$get_services_query = finch_mysql_query($get_services, "return");  
	$services_string = $get_services_query[0]['services_provided'];

	
	$services_garray = explode(':', $services_string);
	array_pop($services_garray); 
	array_shift($services_garray);  
	//print_r($services_garray); 
	foreach( $services_garray as $key => $value ) { 
		$service_hash[$value] = 'element'; 
	}  
	//print_r($service_hash); 
	return $serivce_hash; 
    } 					

    
	 
} 

function get_user_services_hash($userId) { 

	 $get_services = "SELECT
				services_provided
			FROM
				wp_app_workers
			WHERE
				ID=" . $userId . " 
			"; 
	$get_services_query = finch_mysql_query($get_services, "return");  
	$services_string = $get_services_query[0]['services_provided'];

	
	$services_garray = explode(':', $services_string);
	array_pop($services_garray); 
	array_shift($services_garray);  
	foreach( $services_garray as $key => $value ) { 
		$service_hash[$value] = 'element'; 
	}    

	return $service_hash; 
} 

// get buttons to toggle lessons
function generate_lessontoggle($userId, $services='') { 

	
	$avail_serv = serivces_hash('total', '');
	$avail_serv_array = $avail_serv['array']; 
	$avail_serv_hash = $avail_serv['hash'];  
	
	$service_hash = get_user_services_hash($userId); 	
	
	// proces submitting new service form
	if( !empty($services) ) { 
		// generate new lesson string
		//$new_lesson_string = implode(':', $services); 
		//array_unshift($new_lesson_string, ':'); 
		//$new_lesson_string[] = ':'; 
		//echo $new_lesson_string; 

	 
	} 

	echo '<h4>Services I Teach</h4>';
	echo '<form method="post" id="serviceForm" action="">'; 
	echo '<input type="hidden" name="serviceToggled" value="" />';  		
	foreach( $avail_serv_array as $key => $value ) {
		if( !empty( $service_hash[$value['ID']] ) ) { 
			$checkedOrNo = "checked"; 
		} else { 
			$checkedOrNo = ""; 
		}   
		echo '<input type="checkbox" name="services[' . $value['ID'] . ']" value="' . $value['ID'] . '" ' . $checkedOrNo . ' /> <strong>' . $value['name'] . '</strong><br />'; 
		
	} 
	echo '<input type="submit" value="Change My Services" />';  
	echo '</form>'; 
}  
