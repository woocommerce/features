<?php
if ( ! defined( 'ABSPATH' ) || ! function_exists( 'woothemes_features' ) ) exit; // Exit if accessed directly.

/**
 * WooThemes Features Widget
 *
 * A WooThemes standardized features widget.
 *
 * @package WordPress
 * @subpackage WooThemes_Features
 * @category Widgets
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * protected $woothemes_widget_cssclass
 * protected $woothemes_widget_description
 * protected $woothemes_widget_idbase
 * protected $woothemes_widget_title
 *
 * - __construct()
 * - widget()
 * - update()
 * - form()
 * - get_orderby_options()
 */
class Woothemes_Widget_Features extends WP_Widget {
	protected $woothemes_widget_cssclass;
	protected $woothemes_widget_description;
	protected $woothemes_widget_idbase;
	protected $woothemes_widget_title;

	/**
	 * Constructor function.
	 * @since  1.0.0
	 * @return  void
	 */
	public function __construct() {
		/* Widget variable settings. */
		$this->woothemes_widget_cssclass 	= 'widget_woothemes_features';
		$this->woothemes_widget_description = __( 'Recent features listed on your site.', 'woothemes-features' );
		$this->woothemes_widget_idbase 		= 'woothemes_features';
		$this->woothemes_widget_title 		= __( 'Features', 'woothemes-features' );

		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> $this->woothemes_widget_cssclass,
			'description' 	=> $this->woothemes_widget_description
			);

		/* Widget control settings. */
		$control_ops = array(
			'width' 	=> 250,
			'height' 	=> 350,
			'id_base' 	=> $this->woothemes_widget_idbase
			);

		/* Create the widget. */
		$this->WP_Widget( $this->woothemes_widget_idbase, $this->woothemes_widget_title, $widget_ops, $control_ops );
	} // End __construct()

	/**
	 * Display the widget on the frontend.
	 * @since  1.0.0
	 * @param  array $args     Widget arguments.
	 * @param  array $instance Widget settings for this instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		/* Before widget (defined by themes). */
		$args = array();

		$args['before'] 	= $before_widget;

		/* After widget (defined by themes). */
		$args['after'] 		= $after_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) {
			$args['title'] 			= $title;
			$args['before_title'] 	= $before_title;
			$args['after_title'] 	= $after_title;
		}

		/* Widget content. */
		// Add actions for plugins/themes to hook onto.
		do_action( $this->woothemes_widget_cssclass . '_top' );

		// Integer values.
		if ( isset( $instance['limit'] ) && ( 0 < count( $instance['limit'] ) ) ) {
			$args['limit'] = intval( $instance['limit'] );
		}

		if ( isset( $instance['specific_id'] ) && ( 0 < count( $instance['specific_id'] ) ) ) {
			$args['id'] = intval( $instance['specific_id'] );
		}

		if ( isset( $instance['size'] ) && ( 0 < count( $instance['size'] ) ) ) {
			$args['size'] = intval( $instance['size'] );
		}

		if ( isset( $instance['per_row'] ) && ( 0 < count( $instance['per_row'] ) ) ) {
			$args['per_row'] = intval( $instance['per_row'] );
		}

		if ( isset( $instance['category'] ) && is_numeric( $instance['category'] ) ) {
			$args['category'] = intval( $instance['category'] );
		}

		// Boolean values.
		if ( isset( $instance['link_title'] ) && $instance['link_title'] == true && $instance['custom_links_only'] == false ) {
			$args['link_title'] = true;
			$args['custom_links_only'] = false;
		} elseif ( isset( $instance['link_title'] ) && $instance['link_title'] == true && isset( $instance['custom_links_only'] ) && $instance['custom_links_only'] == true ) {
			$args['link_title'] = true;
			$args['custom_links_only'] = true;
		} elseif ( isset( $instance['link_title'] ) && $instance['link_title'] == false && isset( $instance['custom_links_only'] ) && $instance['custom_links_only'] == false ) {
			$args['link_title'] = false;
			$args['custom_links_only'] = false;
		}

		// Select boxes.
		if ( isset( $instance['orderby'] ) && in_array( $instance['orderby'], array_keys( $this->get_orderby_options() ) ) ) {
			$args['orderby'] = $instance['orderby'];
		}

		if ( isset( $instance['order'] ) && in_array( $instance['order'], array_keys( $this->get_order_options() ) ) ) {
			$args['order'] = $instance['order'];
		}

		// Display the features.
		woothemes_features( $args );

		// Add actions for plugins/themes to hook onto.
		do_action( $this->woothemes_widget_cssclass . '_bottom' );
	} // End widget()

	/**
	 * Method to update the settings from the form() method.
	 * @since  1.0.0
	 * @param  array $new_instance New settings.
	 * @param  array $old_instance Previous settings.
	 * @return array               Updated settings.
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] 			= strip_tags( $new_instance['title'] );

		/* Make sure the integer values are definitely integers. */
		$instance['limit'] 			= intval( $new_instance['limit'] );
		$instance['specific_id'] 	= intval( $new_instance['specific_id'] );
		$instance['size'] 			= intval( $new_instance['size'] );
		$instance['per_row'] 		= intval( $new_instance['per_row'] );
		$instance['category'] 		= intval( $new_instance['category'] );

		/* The checkbox is returning a Boolean (true/false), so we check for that. */
		$instance['link_title'] 		= (bool) esc_attr( $new_instance['link_title'] );
		$instance['custom_links_only'] 	= (bool) esc_attr( $new_instance['custom_links_only'] );

		/* The select box is returning a text value, so we escape it. */
		$instance['orderby'] 	= esc_attr( $new_instance['orderby'] );
		$instance['order'] 		= esc_attr( $new_instance['order'] );

		return $instance;
	} // End update()

	/**
	 * The form on the widget control in the widget administration area.
	 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff.
	 * @since  1.0.0
	 * @param  array $instance The settings for this instance.
	 * @return void
	 */
    public function form( $instance ) {

		/* Set up some default widget settings. */
		/* Make sure all keys are added here, even with empty string values. */
		$defaults = array(
			'title' 			=> '',
			'limit' 			=> 5,
			'orderby' 			=> 'menu_order',
			'order' 			=> 'DESC',
			'specific_id' 		=> '',
			'size' 				=> 50,
			'per_row' 			=> 3,
			'category' 			=> 0,
			'link_title' 		=> true,
			'custom_links_only' => false
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'woothemes-features' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $instance['title']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>
		<!-- Widget Limit: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'woothemes-features' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>"  value="<?php echo $instance['limit']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" />
		</p>
		<!-- Widget Image Size: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image Size (in pixels):', 'woothemes-features' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'size' ); ?>"  value="<?php echo $instance['size']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" />
		</p>
		<!-- Widget Per Row: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'per_row' ); ?>"><?php _e( 'Items Per Row:', 'woothemes-features' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'per_row' ); ?>"  value="<?php echo $instance['per_row']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'per_row' ); ?>" />
		</p>
		<!-- Widget Order By: Select Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'woothemes-features' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>">
			<?php foreach ( $this->get_orderby_options() as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['orderby'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>
			</select>
		</p>
		<!-- Widget Order: Select Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order Direction:', 'woothemes-features' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
			<?php foreach ( $this->get_order_options() as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['order'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>
			</select>
		</p>
		<!-- Widget Category: Select Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'woothemes-features' ); ?></label>
			<?php
				$dropdown_args = array( 'taxonomy' => 'feature-category', 'class' => 'widefat', 'show_option_all' => __( 'All', 'woothemes-features' ), 'id' => $this->get_field_id( 'category' ), 'name' => $this->get_field_name( 'category' ), 'selected' => $instance['category'] );
				wp_dropdown_categories( $dropdown_args );
			?>
		</p>
		<!-- Widget Link Titles: Checkbox Input -->
       	<p>
        	<input id="<?php echo $this->get_field_id( 'link_title' ); ?>" name="<?php echo $this->get_field_name( 'link_title' ); ?>" type="checkbox"<?php checked( $instance['link_title'], 1 ); ?> />
        	<label for="<?php echo $this->get_field_id( 'link_title' ); ?>"><?php _e( 'Link Titles', 'woothemes-features' ); ?></label>
	   	</p>
	   	<!-- Widget Custom Links Only: Checkbox Input -->
       	<p>
        	<input id="<?php echo $this->get_field_id( 'custom_links_only' ); ?>" name="<?php echo $this->get_field_name( 'custom_links_only' ); ?>" type="checkbox"<?php checked( $instance['custom_links_only'], 1 ); ?> />
        	<label for="<?php echo $this->get_field_id( 'custom_links_only' ); ?>"><?php _e( 'Link only Titles with Custom Links', 'woothemes-features' ); ?></label>
	   	</p>
		<!-- Widget ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'specific_id' ); ?>"><?php _e( 'Specific ID (optional):', 'woothemes-features' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'specific_id' ); ?>"  value="<?php echo $instance['specific_id']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'specific_id' ); ?>" />
		</p>
		<p><small><?php _e( 'Display a specific feature, rather than a list.', 'woothemes-features' ); ?></small></p>
<?php
	} // End form()

	/**
	 * Get an array of the available orderby options.
	 * @since  1.0.0
	 * @return array
	 */
	protected function get_orderby_options () {
		return array(
					'none' 			=> __( 'No Order', 'woothemes-features' ),
					'ID' 			=> __( 'Entry ID', 'woothemes-features' ),
					'title' 		=> __( 'Title', 'woothemes-features' ),
					'date' 			=> __( 'Date Added', 'woothemes-features' ),
					'menu_order' 	=> __( 'Specified Order Setting', 'woothemes-features' ),
					'rand' 			=> __( 'Random Order', 'woothemes-features' )
					);
	} // End get_orderby_options()

	/**
	 * Get an array of the available order options.
	 * @since  1.0.0
	 * @return array
	 */
	protected function get_order_options () {
		return array(
					'ASC' 	=> __( 'Ascending', 'woothemes-features' ),
					'DESC' 	=> __( 'Descending', 'woothemes-features' )
					);
	} // End get_order_options()
} // End Class

/* Register the widget. */
add_action( 'widgets_init', create_function( '', 'return register_widget("WooThemes_Widget_Features");' ), 1 );