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

function pdw_spine_customize_register($wp_customize) {
	/** Add a new customizer section under the defaults */
	$wp_customize->add_section(
		'spine_color_scheme',
		array(
			'title'    => __( 'color scheme', 'pdw-spine' ),
			'priority' => 35,
		)
	);

	/** Declare a new setting */
	$wp_customize->add_setting(
		'spine_theme_options[color_scheme]',
		array(
			'default' => 'blue',
			'type' => 'option',
			'capability' => 'edit_theme_options'
		)
	);
}