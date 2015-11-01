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

/**
 * Enable the usage of do_action( 'woothemes_features' ) to display features within a theme/plugin.
 *
 * @since  1.0.0
 */
add_action( 'woothemes_features', 'woothemes_features' );

if ( ! function_exists( 'woothemes_features' ) ) {
/**
 * Display or return HTML-formatted testimonials.
 * @param  string/array $args  Arguments.
 * @since  1.0.0
 * @return string
 */
function woothemes_features ( $args = '' ) {
	global $post;

	$defaults = apply_filters( 'woothemes_features_default_args', array(
		'limit' 			=> 5,
		'orderby' 			=> 'menu_order',
		'order' 			=> 'DESC',
		'id' 				=> 0,
		'echo' 				=> true,
		'size' 				=> 150,
		'per_row' 			=> 3,
		'link_title' 		=> true,
		'custom_links_only' => true,
		'title' 			=> '',
		'before' 			=> '<div class="widget widget_woothemes_features">',
		'after' 			=> '</div><!--/.widget widget_woothemes_features-->',
		'before_title' 		=> '<h2>',
		'after_title' 		=> '</h2>',
		'category' 			=> 0
	) );

	$args = wp_parse_args( $args, $defaults );

	// Allow child themes/plugins to filter here.
	$args = apply_filters( 'woothemes_features_args', $args );
	$html = '';

	do_action( 'woothemes_features_before', $args );

		// The Query.
		$query = woothemes_get_features( $args );

		// The Display.
		if ( ! is_wp_error( $query ) && is_array( $query ) && count( $query ) > 0 ) {
			$html .= $args['before'] . "\n";

			if ( '' != $args['title'] ) {
				$html .= $args['before_title'] . esc_html( $args['title'] ) . $args['after_title'] . "\n";
			}

			$html .= '<div class="features columns-' . esc_attr( intval( $args['per_row'] ) ) . '">' . "\n";

			// Begin templating logic.
			$tpl = '<div class="%%CLASS%%">%%IMAGE%%<h3 class="feature-title">%%TITLE%%</h3><div class="feature-content">%%CONTENT%%</div></div>';
			$tpl = apply_filters( 'woothemes_features_item_template', $tpl, $args );

			$i = 0;
			foreach ( $query as $post ) {
				$template = $tpl;
				$i++;

				setup_postdata( $post );

				$class = 'feature';

				if( ( 0 == $i % $args['per_row'] ) ) {
					$class .= ' last';
				} elseif ( 0 == ( $i - 1 ) % ( $args['per_row'] ) ) {
					$class .= ' first';
				}

				if( is_numeric( $args['size'] ) ){
					$image_size = array( $args['size'], $args['size'] );
				} else {
					$image_size = $args['size'];
				}

				$image_size = apply_filters( 'woothemes_features_image_size', $image_size, $post );

				$image = get_the_post_thumbnail( $post->ID, $image_size );

				$title = get_the_title();

				if ( apply_filters( 'woothemes_features_disable_external_links', true ) ) {
					$external = '';
				} else {
					$external = 'target="_blank"';
				}

				if ( true == $args['link_title'] && '' != $post->url ) {
					$image = '<a href="' . esc_url( $post->url ) . '" title="' . esc_attr( $title ) . '" ' . $external . '>' . $image . '</a>';
					$title = '<a href="' . esc_url( $post->url ) . '" title="' . esc_attr( $title ) . '" ' . $external . '>' . $title . '</a>';
				}

				// Optionally display the image, if it is available.
				if ( has_post_thumbnail() ) {
					$template = str_replace( '%%IMAGE%%', $image, $template );
				} else {
					$template = str_replace( '%%IMAGE%%', '', $template );
				}

				$template = str_replace( '%%CLASS%%', $class, $template );
				$template = str_replace( '%%TITLE%%', $title, $template );

				$template = str_replace( '%%PERMALINK%%', esc_url( get_permalink( get_the_ID() ) ), $template );

				if ( '' != $post->post_excerpt ) {
					$content = get_the_excerpt();
				} else {
					$content = get_the_content();
				}
				$content = apply_filters( 'woothemes_features_content', $content, $post );
				$template = str_replace( '%%CONTENT%%', $content, $template );

				$template = apply_filters( 'woothemes_features_template', $template, $post );

				$html .= $template;

				if( ( 0 == $i % $args['per_row'] ) ) {
					$html .= '<div class="fix"></div>' . "\n";
				}
			}

			$html .= '</div><!--/.features-->' . "\n";
			$html .= $args['after'] . "\n";

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
/**
 * The shortcode function.
 * @since  1.0.0
 * @param  array  $atts    Shortcode attributes.
 * @param  string $content If the shortcode is a wrapper, this is the content being wrapped.
 * @return string          Output using the template tag.
 */
function woothemes_features_shortcode ( $atts, $content = null ) {
	$args = (array)$atts;

	$defaults = array(
		'limit' 			=> 5,
		'orderby' 			=> 'menu_order',
		'order' 			=> 'DESC',
		'id' 				=> 0,
		'echo' 				=> true,
		'size' 				=> 150,
		'per_row' 			=> 3,
		'link_title' 		=> true,
		'custom_links_only' => false,
		'category' 			=> 0
	);

	$args = shortcode_atts( $defaults, $atts );

	// Make sure we return and don't echo.
	$args['echo'] = false;

	// Fix integers.
	if ( isset( $args['limit'] ) ) $args['limit'] = intval( $args['limit'] );
	if ( isset( $args['id'] ) ) $args['id'] = intval( $args['id'] );
	
	if ( isset( $args['size'] ) ){
		if( is_numeric( $args['size'] ) ){
			$args['size'] 		=  intval( $args['size'] );
		} else {
			$size = sanitize_title_with_dashes( $args['size'] );
			$args['size'] 		= in_array( $size, get_intermediate_image_sizes() ) ? $size : 'thumbnail';
		}
	}

	if ( isset( $args['per_row'] ) &&  ( 0 < intval( $args['per_row'] ) ) ) $args['per_row'] = intval( $args['per_row'] );
	if ( isset( $args['category'] ) && is_numeric( $args['category'] ) ) $args['category'] = intval( $args['category'] );

	// Fix booleans.
	foreach ( array( 'link_title', 'custom_links_only' ) as $k => $v ) {
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

if ( ! function_exists( 'woothemes_features_content_default_filters' ) ) {
/**
 * Adds default filters to the "woothemes_features_content" filter point.
 * @since  1.3.0
 * @return void
 */
function woothemes_features_content_default_filters () {
	add_filter( 'woothemes_features_content', 'do_shortcode' );
} // End woothemes_features_content_default_filters()

add_action( 'woothemes_features_before', 'woothemes_features_content_default_filters' );
}
?>