=== Features by WooThemes ===
Contributors: woothemes, mattyza, jameskoster, hlashbrooke
Donate link: http://woothemes.com/
Tags: features, widget, shortcode, template-tag, services
Requires at least: 3.4.2
Tested up to: 4.0
Stable tag: 1.4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show off what features your company, product or service offers, using our shortcode, widget or template tag.

== Description ==

"Features by WooThemes" is a clean and easy-to-use features showcase management system for WordPress. Load in the features your product, company or services offers, and display them via a shortcode, widget or template tag on your website.

Looking for a helping hand? [View plugin documentation](http://wordpress.org/extend/plugins/features-by-woothemes/other_notes/).

Looking to contribute code to this plugin? [Fork the repository over at GitHub](http://github.com/woothemes/features/).
(submit pull requests to the "develop" branch)

== Usage ==

To display your features via a theme or a custom plugin, please use the following code:

`<?php do_action( 'woothemes_features' ); ?>`

To add arguments to this, please use any of the following arguments, using the syntax provided below:

* 'limit' => 5 (the maximum number of items to display)
* 'orderby' => 'menu_order' (how to order the items - accepts all default WordPress ordering options)
* 'order' => 'DESC' (the order direction)
* 'id' => 0 (display a specific item)
* 'echo' => true (whether to display or return the data - useful with the template tag)
* 'size' => 50 (the pixel dimensions of the image)
* 'per_row' => 3 (when creating rows, how many items display in a single row?)
* 'link_title' => true (link the feature's title to it's permalink)
* 'custom_links_only' => true (link the feature's title only if a custom URL is set)
* 'title' => '' (an optional title)
* 'before' => '&lt;div class="widget widget_woothemes_features"&gt;' (the starting HTML, wrapping the features)
* 'after' => '&lt;/div&gt;' (the ending HTML, wrapping the features)
* 'before_title' => '&lt;h2&gt;' (the starting HTML, wrapping the title)
* 'after_title' => '&lt;/h2&gt;' (the ending HTML, wrapping the title)
* 'category' => 0 (the ID/slug of the category to filter by)

The various options for the "orderby" parameter are:

* 'none'
* 'ID'
* 'author'
* 'title'
* 'date'
* 'modified'
* 'parent'
* 'rand'
* 'comment_count'
* 'menu_order'
* 'meta_value'
* 'meta_value_num'

`<?php do_action( 'woothemes_features', array( 'limit' => 10, 'link_title' => false ) ); ?>`

The same arguments apply to the shortcode which is `[woothemes_features]` and the template tag, which is `<?php woothemes_features(); ?>`.

== Usage Examples ==

Adjusting the limit and image dimension, using the arguments in the three possible methods:

do_action() call:

`<?php do_action( 'woothemes_features', array( 'limit' => 10, 'size' => 100 ) ); ?>`

woothemes_features() template tag:

`<?php woothemes_features( array( 'limit' => 10, 'size' => 100 ) ); ?>`

[woothemes_features] shortcode:

`[woothemes_features limit="10" size="100"]`

== Installation ==

Installing "Features by WooThemes" can be done either by searching for "Features by WooThemes" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org.
1. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action( 'woothemes_features' ); ?>` in your templates, or use the provided widget or shortcode.

== Frequently Asked Questions ==

= The plugin looks unstyled when I activate it. Why is this? =

"Features by WooThemes" is a lean plugin that aims to keep it's purpose as clean and clear as possible. Thus, we don't load any preset CSS styling, to allow full control over the styling within your theme or child theme.

= How do I contribute? =

We encourage everyone to contribute their ideas, thoughts and code snippets. This can be done by forking the [repository over at GitHub](http://github.com/woothemes/features/).

= Can I make feature links open in a new window / tab? =

You sure can, just use the following snippet:

`add_filter( 'woothemes_features_disable_external_links', '__return_false' );`

== Screenshots ==

1. The features management screen within the WordPress admin.

== Upgrade Notice ==

= 1.4.0 =
* WordPress 3.8 support (3.8 is now the minimum required version).
* Adds the ability to link only features with a custom URL set.

= 1.3.1 =
* Adds filters for the single features and features archives URL slugs
* Adds a flush_rewrite_rules() call on plugin activation

= 1.3.0 =
* Adds "woothemes_features_content" filter and shortcode support. Adds "feature-category" taxonomy.

= 1.2.2 =
* Minor bugfixes to the "order" directions options and additions to the "woothemes_features_html" filter.

= 1.2.1 =
* Minor bugfix to the output of the "Features" widget.

= 1.2.0 =
* Adds basic WPML support.
* Enhancements to the widget output.
* Adds new arguments for controlling the HTML wrapping the features, as well as wrapping the title.
* Ads support for the excerpt.

= 1.1.0 =
* Adds "URL" custom field.
* Adds "link_title" option to the shortcode.
* Routine plugin maintenance.

= 1.0.0 =
* Initial release. Woo!

== Changelog ==

= 1.4.3 =
* 2014.08.18
* Tweak - Made post type args filterable (props lkraav).

= 1.4.2 =
* 2014-02-03
* Fix - Link title options in the widget.

= 1.4.1 =
* 2014-01-30
* New - Filter to set feature links to open in a new window.
* Fix - Widget image size option.
* Tweak - Better WPML integration.

= 1.4.0 =
* 2014-01-17
* UI tweaks for WordPress 3.8.
* Default args are now filterable via woothemes_features_default_args.
* Adds the ability to link only features with a custom URL set.
* Adds a new %%PERMALINK%% tag to the templating engine.
* Adjusts the 'id' parameter to cater for multipe ID values.

= 1.3.1 =
* 2013-08-01.
* Adds "woothemes_features_single_slug" as a filter for the single feature URL slug
* Adds "woothemes_features_archive_slug" as a filter for the features archive URL slug
* Adds a flush_rewrite_rules() call on plugin activation

= 1.3.0 =
* 2013-04-30.
* Adds "woothemes_features_content" filter for modifying the content of features when outputting the features list.
* Adds default filters to the "woothemes_features_content" hook, enabling shortcodes in the content or excerpt fields.
* Adds "feature-category" taxonomy and necessary logic for displaying features from a specified category.
* Adds "columns-X" class to the ".features" DIV tag, for easier styling, using the "per_row" attribute.

= 1.2.2 =
* 2013-01-03
* Fix the "order" direction options to be in capitals.
* Enhance the "woothemes_features_html" filter.
* Make sure to use the_content() if there is no custom excerpt.
* Add support for ordering by "rand" to the widget.
* Allow the "size" parameter to receive an array of dimensions.

= 1.2.1 =
* 2012-11-29
* Makes sure the ending wrapping markup for the widget is declared in the appropriate location, before calling the woothemes_features() function.

= 1.2.0 =
* 2012-11-27
* Adds basic WPML support to the get_features() method.
* Moves the "title" outside of the ".features" DIV tag.
* Adds "before" and "after" arguments for filtering the HTML for the container. Integrate the $before_widget and $after widget variables to use these parameters with the widget.
* If the "link title" option is enabled, link the image as well.
* Adds "before_title" and "after_title" arguments, for filtering the title's wrapping HTML. Integrate the $before_title and $after_title widget variables to use these parameters with the widget.
* Adds support for the excerpt.

= 1.1.0 =
* 2012-11-08
* Adds "link_title" option to the shortcode.
* Adds "URL" custom field, to use in place of linking to the permalink, if it is specified.

= 1.0.1 =
* 2012-11-06
* Tweak - first / last classes applied regardless

= 1.0.0 =
* 2012-10-23
* Initial release. Woo!