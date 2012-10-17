<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'woothemes_get_features' ) ) {
/**
 * Wrapper function to get the testimonials from the WooDojo_Testimonials class.
 * @param  string/array $args  Arguments.
 * @since  1.0.0
 * @return array/boolean       Array if true, boolean if false.
 */
function woothemes_get_features ( $args = '' ) {
	global $woothemes_features;
	return $woothemes_features->get_features( $args );
} // End woothemes_get_features()
}

if ( ! function_exists( 'woothemes_features' ) ) {
/**
 * Display or return HTML-formatted testimonials.
 * @param  string/array $args  Arguments.
 * @since  1.0.0
 * @return string
 */
function woothemes_features ( $args = '' ) {
	global $post;

	$defaults = array(
		'limit' => 5, 
		'orderby' => 'menu_order', 
		'order' => 'DESC', 
		'id' => 0, 
		'echo' => true, 
		'size' => 50, 
		'per_row' => 3, 
		'link_title' => true
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	// Allow child themes/plugins to filter here.
	$args = apply_filters( 'woothemes_features_args', $args );
	$html = '';

	do_action( 'woothemes_features_before', $args );
		
		// The Query.
		$query = woothemes_get_features( $args );

		// The Display.
		if ( ! is_wp_error( $query ) && is_array( $query ) && count( $query ) > 0 ) {

			$html .= '<div class="features">' . "\n";
			
			$i = 0;
			foreach ( $query as $post ) {
				$i++;

				setup_postdata( $post );
				
				$class = 'feature';
				 if( ( 0 == $i % $args['per_row'] ) || count( $query ) == $i ) { $class .= ' last'; }
				$html .= '<div class="' . esc_attr( $class ) . '">';

				// Optionally display the image, if it is available.
				if ( isset( $post->image ) && ( '' != $post->image ) ) {
					$html .= $post->image;
				}

				$title = get_the_title();
				if ( true == $args['link_title'] ) {
					$title = '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" title="' . esc_attr( $title ) . '">' . $title . '</a>';
				}

				$html .= '<h3 class="feature-title">' . $title . '</h3>' . "\n";
				$html .= '<div class="feature-content">' . get_the_content() . '</div>' . "\n";
				$html .= '</div><!--/.feature-->' . "\n";
			}
			$html .= '</div><!--/.features-->' . "\n";

			wp_reset_postdata();
		}
		
		// Allow child themes/plugins to filter here.
		$html = apply_filters( 'woothemes_features_html', $html, $query, $args );
		
		if ( $args['echo'] != true ) { return $html; }
		
		// Should only run is "echo" is set to true.
		echo $html;
		
		do_action( 'woothemes_features_after', $args ); // Only if "echo" is set to true.
} // End woothemes_features()
}

if ( ! function_exists( 'woothemes_features_shortcode' ) ) {
function woothemes_features_shortcode ( $atts, $content = null ) {
	$args = (array)$atts;

	$defaults = array(
		'limit' => 5, 
		'orderby' => 'menu_order', 
		'order' => 'DESC', 
		'id' => 0, 
		'echo' => true, 
		'size' => 50, 
		'per_row' => 3
	);

	$args = shortcode_atts( $defaults, $atts );

	// Make sure we return and don't echo.
	$args['echo'] = false;

	// Fix integers.
	if ( isset( $args['limit'] ) ) $args['limit'] = intval( $args['limit'] );
	if ( isset( $args['id'] ) ) $args['id'] = intval( $args['id'] );
	if ( isset( $args['size'] ) &&  ( 0 < intval( $args['size'] ) ) ) $args['size'] = intval( $args['size'] );
	if ( isset( $args['per_row'] ) &&  ( 0 < intval( $args['per_row'] ) ) ) $args['per_row'] = intval( $args['per_row'] );

	// Fix booleans.
	foreach ( array( 'link_title' ) as $k => $v ) {
		if ( isset( $args[$v] ) && ( 'true' == $args[$v] ) ) {
			$args[$v] = true;
		} else {
			$args[$v] = false;
		}
	}

	return woothemes_features( $args );
} // End woothemes_features_shortcode()
}

add_shortcode( 'woothemes_features', 'woothemes_features_shortcode' );
?>