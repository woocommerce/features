<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * WooThemes Features Admin Class
 *
 * All admin functionality pertaining to the Features plugin.
 *
 * @package WordPress
 * @subpackage Woothemes_Features_Admin
 * @category Plugin
 * @author WooThemes
 * @since 1.5.0
 */
class Woothemes_Features_Admin {
	/**
	 * Constructor function.
	 *
	 * @access public
	 * @since 1.5.0
	 * @return void
	 */
	public function __construct() {
		// Settings hook
		add_action( 'admin_init', array( $this, 'features_settings_api_init' ) );
	} // End __construct()

	/**
	 * features_settings_api_init Registers settings and fields
	 *
	 * @access public
	 * @since  1.5.0
	 * @return void
	 */
	public function features_settings_api_init() {
	 	// Add the section to general settings
	 	add_settings_section(
			'features_setting_section',
			'Features by WooThemes Settings',
			array( $this, 'features_setting_section_callback_function' ),
			'general'
		);
	 	// Add the field to the section
	 	add_settings_field(
			'features_setting_name',
			'Preferred naming',
			array( $this, 'features_setting_callback_function' ),
			'general',
			'features_setting_section'
		);
	 	// Register the setting
	 	register_setting( 'general', 'features_setting_name' );
	 } // features_settings_api_init()

	 /**
	  * features_setting_section_callback_function Create settings intro text html
	  *
	  * @access public
	  * @since  1.5.0
	  * @return html
	  */
	 public function features_setting_section_callback_function() {
	 	echo '<p>Choose your preferred name for the Features plugin.</p>';
	 }

	 /**
	  * features_setting_callback_function Creates html dropdown
	  *
	  * @access public
	  * @since  1.5.0
	  * @return html
	  */
	 public function features_setting_callback_function() {
	 	$setting_data = get_option( 'features_setting_name', 'feature' );
	 	// The drop down
	    $html = '<select id="features_setting_name" name="features_setting_name">';
	        $html .= '<option value="feature"' . selected( $setting_data, 'features', false) . '>Features</option>';
	        $html .= '<option value="service"' . selected( $setting_data, 'services', false) . '>Services</option>';
	    $html .= '</select>';
	    echo $html;
	 }

} // End Class