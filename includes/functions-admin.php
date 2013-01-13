<?php
/**
 * Spine theme
 *
 * Theme settings
 *
 * @package    spine-theme
 * @subpackage subfolder
 * @version    1.0.2
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://paulwp.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/** Admin setup */
add_action('admin_menu','pdw_spine_theme_admin_setup');

function pdw_spine_theme_admin_setup(){

	/** Get theme prefix */
	$prefix = hybrid_get_prefix();

	/** Create a settings meta box only on the theme settings page */
	add_action('load-appearance_page_theme-settings', 'pdw_spine_settings_meta_boxes');

	/** Add a filter to validate;sanitize your settings */
	add_filter("sanitize_option_{$prefix}_theme_settings", "pdw_spine_validate_settings");
}

/** Add the metaboxes */
function pdw_spine_settings_meta_boxes(){

	/** Add a custom meta box */
	add_meta_box(
		'pdw-spine-meta-box',
		__('Spine Settings', 'pdw-spine'),
		'pdw_spine_meta_box',
		'appearance_page_theme-settings',
		'normal',
		'high'
	);
}

/**
 * Displays the meta box on the settings page
 */
function pdw_spine_meta_box(){ ?>
<?php
$schemes = pdw_spine_fetch_default_color_schemes();
	?>
		<table class="form-table">
				<!-- Dropdown select for Color Scheme -->
				<tr>
						<th>
								<label for="<?php echo hybrid_settings_field_id('color_scheme_select'); ?>"><?php _e('Color Scheme','pdw-spine'); ?></label>
						</th>
						<td>
								<p><select id="<?php echo esc_attr(hybrid_settings_field_id( 'color_scheme_select' )); ?>" name="<?php echo esc_attr(hybrid_settings_field_name( 'color_scheme_select' )); ?>">
										<?php
									foreach( $schemes as $key => $value){ ?>
                      <option value="<?php echo $key; ?>" <?php selected( hybrid_get_setting('color_scheme_select'), "{$key}" ); ?>><?php esc_html_e($value); ?></option>
								<?php } ?>

								</select></p>
						</td>
				</tr>
		</table>
<?php }

function pdw_spine_validate_settings($input){
	/** Validate the color scheme dropdown */
	$input['color_scheme_select'] = wp_filter_nohtml_kses($input['color_scheme_select']);

	return $input;
}

function pdw_spine_fetch_default_color_schemes(){
	$defaults = array(
		'default' => __('Default', 'pdw-spine'),
		'blue' => __('Blue', 'pdw-spine'),
		'red' => __('Red', 'pdw-spine'),
		'green' => __('Green', 'pdw-spine'),
	);

	return apply_filters('pdw_spine_default_color_schemes', $defaults);
}