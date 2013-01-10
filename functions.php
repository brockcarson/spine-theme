<?php
/**
 * Project Name - Short Description
 *
 * Long Description
 * Can span several lines
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/** Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/** Theme setup */
function pdw_spi_theme_setup(){

	/** Theme constants */
	define ( 'PDW_SPINE_JS_URL', trailingslashit( get_stylesheet_directory_uri() . '/foundation/javascripts/foundation' ) );

	define ( 'PDW_SPINE_INC_DIR', trailingslashit( get_stylesheet_directory() . '/includes' ) );

	define ( 'PDW_SPINE_DIR', dirname(__FILE__) );

	define( 'PDW_SPINE_VERSION', '0.1' );

	/** Template tags */
	include_once 'includes/template-tags.php';

	/** Use Foundation nav bar markup for menus */
	include_once 'includes/navbar-walker.php';

	/** Use Foundation makrup for galleries */
	include_once 'includes/gallery-shortcode.php';

	/** Include theme customizer options */
	include_once 'includes/spine-customizer.php';
	add_action('customize_register','pdw_spine_customize_register');

	/** Load main stylesheet */
	add_action( 'wp_enqueue_scripts', 'pdw_spine_load_styles' );

	/** Load the javascripts */
	add_action( 'wp_enqueue_scripts', 'pdw_spine_load_scripts' );

	/** Hybrid Core features */
	/** Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/** Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	//add_theme_support( 'hybrid-core-seo' );

	/** Add theme support for framework extensions. */
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'dev-stylesheet' );
	//add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	//add_theme_support( 'cleaner-gallery' );

	/** Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'image', 'gallery' ) );

	add_theme_support('theme-layouts', array('2c-l', '2c-r', '1c'));

	/* Add support for WordPress custom background. */
	add_theme_support(
		'custom-background',
		array(
			'default-image' => trailingslashit( get_template_directory_uri() ) . 'backgrounds/satinweave.png',
			'wp-head-callback' => 'pdw_spine_custom_background_callback'
		)
	);

	/** Add support for WordPress custom header image. */
	add_theme_support(
		'custom-header',
		array(
			'wp-head-callback' => '__return_false',
			'admin-head-callback' => '__return_false',
			'header-text' => false,
			'default-image' => 'remove-header',
			'width' => 970,
			'height' => 250
		)
	);

	add_theme_support( 'featured-header' );

	/** Set content width. */
	hybrid_set_content_width( 637 );

	//add_filter( 'wp_nav_menu_objects',  'pdw_spine_add_parent_class'  );
	add_filter( 'wp_nav_menu_objects', 'pdw_spine_add_active_class' );

	add_filter('loop_pagination_args','pdw_spine_foundation_pagination');

	/* Register Spine widgets. */
	add_action( 'widgets_init', 'pdw_spine_register_widgets' );

	/**  custom editor styles */
	if ( is_admin() ) {
		include('tinymce-kit/tinymce-kit.php');
	} // end if

	//add_filter('post_thumbnail_html', 'pdw_spine_add_thumbnail_class',10, 3 );
	add_filter('get_the_image', 'pdw_spine_add_featured_img_class',10, 1 );
}
add_action( 'after_setup_theme', 'pdw_spi_theme_setup' );


/**
 * Load the necessary CSS files
 */
function pdw_spine_load_styles() {

	/** This loads the main theme style.css */
	wp_enqueue_style( 'main', get_stylesheet_uri() );

}

/**
 * Load the necessary javascript files
 */
function pdw_spine_load_scripts() {

	//wp_enqueue_script( 'foundation-cookie', PDW_SPINE_JS_URL . 'jquery.cookie.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-event-move', PDW_SPINE_JS_URL . 'jquery.event.move.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-event-swipe', PDW_SPINE_JS_URL . 'jquery.event.swipe.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-accordion', PDW_SPINE_JS_URL . 'jquery.foundation.accordion.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-alerts', PDW_SPINE_JS_URL . 'jquery.foundation.alerts.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-buttons', PDW_SPINE_JS_URL . 'jquery.foundation.buttons.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-clearing', PDW_SPINE_JS_URL . 'jquery.foundation.clearing.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-forms', PDW_SPINE_JS_URL . 'jquery.foundation.forms.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-joyride', PDW_SPINE_JS_URL . 'jquery.foundation.joyride.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-magellan', PDW_SPINE_JS_URL . 'jquery.foundation.magellan.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-mq-toggle', PDW_SPINE_JS_URL . 'jquery.foundation.mediaQueryToggle.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-navigation', PDW_SPINE_JS_URL . 'jquery.foundation.navigation.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-orbit', PDW_SPINE_JS_URL . 'jquery.foundation.orbit.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-reveal', PDW_SPINE_JS_URL . 'jquery.foundation.reveal.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-tabs', PDW_SPINE_JS_URL . 'jquery.foundation.tabs.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-tooltips', PDW_SPINE_JS_URL . 'jquery.foundation.tooltips.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-topbar', PDW_SPINE_JS_URL . 'jquery.foundation.topbar.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-offcanvas', PDW_SPINE_JS_URL . 'jquery.offcanvas.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-placeholder', PDW_SPINE_JS_URL . 'jquery.placeholder.js', array( 'jquery' ), PDW_SPINE_VERSION, true );

	/** This is the main javascript file */
	wp_enqueue_script( 'foundation-app', PDW_SPINE_JS_URL . 'app.js', array( 'jquery' ), PDW_SPINE_VERSION, true );

}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.
 *
 * @since 0.1.0
 * @link http://core.trac.wordpress.org/ticket/16919
 */
function pdw_spine_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

	?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

function pdw_spine_hasSub( $menu_item_id, $items ) {
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent == $menu_item_id ) {
			return true;
		}
	}
	return false;
}

/*function pdw_spine_add_parent_class( $items ) {
	foreach ( $items as $item ) {
		if ( pdw_spine_hasSub( $item->ID, $items ) ) {
			$item->classes[] = 'has-flyout'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
		}
	}
	return $items;
}*/

function pdw_spine_add_active_class( $items ) {
	foreach ( $items as $item ) {
		$current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );
		$current_class           = array_intersect( $current_element_markers, $item->classes );
		if ( ! empty( $current_class ) ) {
			$item->classes[] = 'active'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
		}
	}
	return $items;
}

/** Customize loop pagination extension */
function pdw_spine_foundation_pagination($args){
	$args['before'] = '<div class="loop-pagination">';

	$args['type'] = 'list';

	return $args;
}

function pdw_spine_register_widgets(){
	/** Customize Nav Menu Widget */
	include_once  'includes/widget-nav-menu.php';

	/* Register the nav menu widget. */
	register_widget( 'Spine_Widget_Nav_Menu' );
}

function pdw_spine_add_featured_img_class($img_html){
	/** Only do this is there's an image */
	if(!empty($img_html))
		$img_html = '<a class="th" href="' . get_permalink( get_the_ID() ) . '" title="' . esc_attr( get_post_field( 'post_title', get_the_ID() ) ) . '">' . $img_html . '</a>';

	return $img_html;
}

function pdw_spine_fetch_bg_images(){
	$directory = PDW_SPINE_DIR . '/backgrounds/';
	//get all image files with a .jpg extension.
	$images = glob($directory . "*.jpg");

	return $images;
}


function pdw_spine_fetch_content_grid_classes(){

	/** Set the grid column span */
	$span_cols = apply_filters('spine_content_span_cols', 'nine columns');
 /** Layout logic  */
  $layout = get_post_layout( get_the_ID() );
switch($layout){
	case 'default' :
		$content_classes = $span_cols;
		break;
	case '1c' :
		$content_classes = "twelve columns";
		break;
	case '2c-r':
		$content_classes = $span_cols;
		break;
	case '2c-l':
		$content_classes = $span_cols . " push-three";
		break;
	default:
		$content_classes = $span_cols;
		break;
}
return $content_classes;
}

function pdw_spine_fetch_sidebar_grid_classes(){
	$span_cols = apply_filters('spine_sidebar_span_cols', 'three columns');
	/** Layout logic  */
	$layout = get_post_layout( get_the_ID() );
	switch($layout){
		case 'default' :
			$sidebar_classes = $span_cols;
			break;
		case '1c' :
			$sidebar_classes = "twelve columns";
			break;
		case '2c-r':
			$sidebar_classes = $span_cols;
			break;
		case '2c-l':
			$sidebar_classes = $span_cols . " pull-nine";
			break;
		default:
			$sidebar_classes = $span_cols;
			break;
	}
return $sidebar_classes;
}