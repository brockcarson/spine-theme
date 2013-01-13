<?php
/**
 * Spine Theme
 *
 * Enables settings in the theme customizer
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2013, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function pdw_spine_customize_register( $wp_customize ) {

	/* Add the  section. */
	$wp_customize->add_section(
		'color_scheme',
		array(
			'title'      => esc_html__( 'Color Scheme', 'pdw-spine' ),
			'priority'   => 35,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the  setting. */
	$wp_customize->add_setting(
		'spine_theme_settings[color_scheme_select]',
		array(
			'default'           => 'default',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_html_class',
			'transport'         => 'postMessage'
		)
	);

	$schemes = pdw_spine_fetch_default_color_schemes();
	/* Add the control. */
	$wp_customize->add_control(
		'theme-color-scheme',
		array(
			'label'    => esc_html__( 'Color Scheme', 'pdw-spine' ),
			'section'  => 'color_scheme',
			'settings' => 'spine_theme_settings[color_scheme_select]',
			'type'     => 'radio',
			'choices'  => $schemes
		)
	);

	/* If viewing the customize preview screen, add a script to show a live preview. */
	//if ( $wp_customize->is_preview() && ! is_admin() )
	//	add_action( 'wp_footer', 'theme_scheme_customize_preview_script', 21 );

}

function theme_scheme_customize_preview_script() { ?>
    <script type="text/javascript">
    ( function( $ ){
        wp.customize('setting_name',function( value ) {
            value.bind(function(to) {
                $('.posttitle').css('color', to ? '#' + to : '' );
            });
        });
    } )( jQuery )
</script>
    <?php
}