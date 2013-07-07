<?php
/*
Plugin Name: Edit Howdy
Plugin URI: http://wordpress.org/extend/plugins/edit-howdy/
Description: This simple plugin allows you to change the "Howdy" message on the admin screen.
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
Version: 1.0.3
License: GNU General Public License v2.0
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/*  Copyright 2011  Thomas Griffin  (email : thomas@thomasgriffinmedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
*/

add_action( 'admin_init', 'edithowdy_register_settings' );
/**
 *
 * Before we do anything, we need to register our settings, sections and fields for our options. We will go ahead and do that now.
 *
 * We register just one setting, but everything is stored in array which contains all of our data. This function will also register our
 * settings sections in each options page, as well as our settings fields for each options page.
 *
 * @since 1.0
 *
 */
function edithowdy_register_settings() {

	// For reference: register_setting( $option_group, $option_name, $sanitize_callback );
	register_setting( 'edithowdy_plugin_options', 'edithowdy_plugin_options', 'edithowdy_validate_options' );
	
	// For reference: add_settings_section( $id, $title, $callback, $page );
	add_settings_section( 'edit_howdy_message', 'Edit the Howdy Message', 'edithowdy_message_section', 'edithowdy-options' );
	
	// For reference: add_settings_field( $id, $title, $callback, $page, $section, $args );
	add_settings_field( 'edithowdy_change_message', 'New "Howdy" text:', 'edithowdy_new_text', 'edithowdy-options', 'edit_howdy_message' );

}

/**
 *
 * Before we do anything else, we need to register our default options.
 *
 * @since 1.0
 *
 */
function edithowdy_default_options() {

	$options = array(
		'edithowdy_change_message' => 'Howdy'
	);
	
	return $options;

}

register_activation_hook( __FILE__, 'edithowdy_default_options_setup' );
/**
 *
 * Let's register our options when the plugin is activated.
 *
 * @since 1.0
 *
 */
function edithowdy_default_options_setup() {

	global $edithowdy_options;
	$edithowdy_options = get_option( 'edithowdy_plugin_options' );
	
	if ( false === $edithowdy_options ) {
		$edithowdy_options = edithowdy_default_options();
	}
	
	update_option( 'edithowdy_plugin_options', $edithowdy_options );

}

add_action( 'admin_menu', 'edithowdy_plugin_page' );
/**
 *
 * The next step is to actually add in our plugin page. This will be added to the Settings tab.
 *
 * @since 1.0
 *
 */
function edithowdy_plugin_page() {

	// For reference: add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	add_options_page( 'Edit Howdy', 'Edit Howdy', 'manage_options', 'edithowdy-options', 'edithowdy_plugin_options_page' );

}

/**
 *
 * The next step is to populate our function that was just added, edithowdy_plugin_options_page
 * It's time to get busy with our stuff now!
 *
 * @since 1.0
 *
 */
function edithowdy_plugin_options_page() {

	?>

	<div id="edithowdy-options-wrapper">
		<div class="wrap">
		
			<div class="header">
			
				<div class="head-wrap">
					<div id="icon-themes" class="icon32"><br /></div>
					<h2><?php echo 'Edit Howdy Settings'; ?></h2>
				</div><!--end .head-wrap-->
					
			</div><!--end .header-->
			
			<?php ?>
			
			<div class="main-content">
				
				<form action="options.php" method="post" enctype="multipart/form-data">
				
				<?php settings_fields( 'edithowdy_plugin_options' ); ?>
				<?php do_settings_sections( 'edithowdy-options' ); ?>
				
					
      				<p class="submit">
        				<input name="edithowdy_plugin_options[submit-edithowdy-options]" type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'inline' ); ?>" />
      				</p>
      				
   				</form>
   				
			</div><!--end .main-content-->
	
		</div><!--end .wrap-->
	</div><!--end #edithowdy-options-wrapper-->

<?php }

/**
 *
 * This is the function that adds our Edit Howdy section.
 *
 * @since 1.0
 *
 */
function edithowdy_message_section() {

	echo "<p class='intro'>Enter in your new 'Howdy' message in the input field below.</p>";

}

/**
 *
 * This is the function adds the input field for our new Howdy message.
 *
 * @since 1.0
 *
 */
function edithowdy_new_text() {
	
	$options = get_option( 'edithowdy_plugin_options' );
	echo "<input id='edithowdy-message' name='edithowdy_plugin_options[edithowdy_change_message]' size='40' type='text' value='{$options['edithowdy_change_message']}' />";

}

/**
 *
 * This function sanitizes the input and returns the sanitized data.
 *
 * @since 1.0
 *
 */
function edithowdy_validate_options( $input ) {
	
	$edithowdy_options = get_option( 'edithowdy_plugin_options' );
	$validated_input = $edithowdy_options;
	
	$submit_options = ( !empty( $input['submit-edithowdy-options'] ) ? true : false ); // This sets up our save option.
	
	if ( $submit_options ) {
		
		// Validate the new Howdy message input
		$validated_input['edithowdy_change_message'] = esc_attr( trim( $input['edithowdy_change_message'] ) );
		
	}
	
	return $validated_input;

}

add_filter( 'gettext', 'edithowdy_replace_howdy' );
/**
 *
 * This function filters the Howdy text to say what you would like.
 *
 * @since 1.0
 *
 */
function edithowdy_replace_howdy( $text ) {

	if ( is_admin() ) {
		$howdy = get_option( 'edithowdy_plugin_options' ); // Defaults to 'Howdy' if no return value is specified
		$text = str_replace( 'Howdy', $howdy['edithowdy_change_message'], $text );
	}
	return $text;
	
}