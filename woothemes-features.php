<?php
/**
 * Plugin Name: Features
 * Plugin URI: https://woocommerce.com/
 * Description: Hi, I'm your feature showcase plugin for WordPress. Show off what features your company, product or service offers, using our shortcode, widget or template tag.
 * Author: WooThemes
 * Version: 1.5.0
 * Author URI: https://woocommerce.com/
 * Text Domain: features-by-woothemes
 *
 * @package WordPress
 * @subpackage Woothemes_Features
 * @author Matty
 * @since 1.0.0
 */

require_once( 'classes/class-woothemes-features.php' );
require_once( 'classes/class-woothemes-features-taxonomy.php' );
require_once( 'woothemes-features-template.php' );
require_once( 'classes/class-woothemes-widget-features.php' );
global $woothemes_features;
$woothemes_features = new Woothemes_Features( __FILE__ );
$woothemes_features->version = '1.5.0';
