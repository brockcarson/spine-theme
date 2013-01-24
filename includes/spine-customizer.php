<?php
/**
 * Functions for registering and setting theme settings that tie into the WordPress theme customizer.
 * This file loads additional classes and adds settings to the customizer for the built-in Hybrid Core
 * settings.
 *
 * @package    HybridCore
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2008 - 2012, Justin Tadlock
 * @link       http://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom sections, settings, and controls. */
add_action( 'customize_register', 'pdw_spine_customize_register' );

/* Add the footer content Ajax to the correct hooks. */
//add_action( 'wp_ajax_pdw_spine_customize_footer_content', 'pdw_spine_customize_footer_content_ajax' );
//add_action( 'wp_ajax_nopriv_pdw_spine_customize_footer_content', 'pdw_spine_customize_footer_content_ajax' );



/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 1.4.0
 * @access private
 * @param object $wp_customize
 */
function pdw_spine_customize_register( $wp_customize ) {

	/* Get the theme prefix. */
	$prefix = hybrid_get_prefix();


		/* Add the footer section. */
		$wp_customize->add_section(
			'spine-scheme',
			array(
				'title'      => esc_html__( 'Color Scheme', 'spine' ),
				'priority'   => 200,
				'capability' => 'edit_theme_options'
			)
		);

		/* Add the 'footer_insert' setting. */
		$wp_customize->add_setting(
			"{$prefix}_theme_settings[color_scheme_select]",
			array(
				'default'              => 'default',
				'type'                 => 'option',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'pdw_spine_customize_sanitize',
				'sanitize_js_callback' => 'pdw_spine_customize_sanitize',
				'transport'            => 'postMessage',
			)
		);

	$schemes = array(
		'default' => __('Default', 'spine'),
		'blue' => __('Blue', 'spine'),
		'red' => __('Red', 'spine'),
		'green' => __('Green', 'spine'),
	);

$wp_customize->add_control( 'spine_color_scheme', array(
'label' => __( 'Color Scheme', 'spine' ),
'section'=> 'spine-scheme',
'settings'=> "{$prefix}_theme_settings[color_scheme_select]",
'type'=> 'radio',
'choices'=> $schemes
) );

		/* If viewing the customize preview screen, add a script to show a live preview. */
	//	if ( $wp_customize->is_preview() && !is_admin() )
	//		add_action( 'wp_footer', 'pdw_spine_customize_preview_script', 21 );
}

/**
 * Sanitizes the footer content on the customize screen.  Users with the 'unfiltered_html' cap can post
 * anything.  For other users, wp_filter_post_kses() is ran over the setting.
 *
 * @since 1.4.0
 * @access public
 * @param mixed $setting The current setting passed to sanitize.
 * @param object $object The setting object passed via WP_Customize_Setting.
 * @return mixed $setting
 */
function pdw_spine_customize_sanitize( $setting, $object ) {

	/* Get the theme prefix. */
	$prefix = hybrid_get_prefix();

	/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( "{$prefix}_theme_settings[footer_insert]" == $object->id && !current_user_can( 'unfiltered_html' )  )
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );

	/* Return the sanitized setting and apply filters. */
	return apply_filters( "{$prefix}_customize_sanitize", $setting, $object );
}

/**
 * Runs the footer content posted via Ajax through the do_shortcode() function.  This makes sure the
 * shortcodes are output correctly in the live preview.
 *
 * @since 1.4.0
 * @access private
 */
function pdw_spine_customize_footer_content_ajax() {

	/* Check the AJAX nonce to make sure this is a valid request. */
	check_ajax_referer( 'pdw_spine_customize_footer_content_nonce' );

	/* If footer content has been posted, run it through the do_shortcode() function. */
	if ( isset( $_POST['footer_content'] ) )
		echo do_shortcode( wp_kses_stripslashes( $_POST['footer_content'] ) );

	/* Always die() when handling Ajax. */
	die();
}

/**
 * Handles changing settings for the live preview of the theme.
 *
 * @since 1.4.0
 * @access private
 */
function pdw_spine_customize_preview_script() {

	/* Create a nonce for the Ajax. */
	$nonce = wp_create_nonce( 'pdw_spine_customize_footer_content_nonce' );

	?>
<script type="text/javascript">
	wp.customize(
			'<?php echo pdw_spine_get_prefix(); ?>_theme_settings[footer_insert]',
			function( value ) {
				value.bind(
						function( to ) {
							jQuery.post(
									'<?php echo admin_url( 'admin-ajax.php' ); ?>',
									{
										action: 'pdw_spine_customize_footer_content',
										_ajax_nonce: '<?php echo $nonce; ?>',
										footer_content: to
									},
									function( response ) {
										jQuery( '.footer-content' ).html( response );
									}
							);
						}
				);
			}
	);
</script>
<?php
}

?>