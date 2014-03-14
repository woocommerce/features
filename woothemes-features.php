<?php
/**
 * Plugin Name: Features
 * Plugin URI: http://woothemes.com/
 * Description: Hi, I'm your feature showcase plugin for WordPress. Show off what features your company, product or service offers, using our shortcode, widget or template tag.
 * Author: WooThemes
 * Version: 1.4.3
 * Author URI: http://woothemes.com/
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
$woothemes_features->version = '1.4.3';