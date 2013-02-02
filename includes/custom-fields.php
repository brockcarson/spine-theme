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

/*
*  4. Register your field groups
*     Field groups can be exported to PHP from the WP "Advanced Custom Fields" plugin.
*/

register_field_group(array (
'id' => 'field_group_1',
'title' => 'Page Fields',
'fields' => array(
array (
'key' => 'field_1',
'label' => 'Text',
'name' => 'text',
'type' => 'text',
'instructions' => 'Add some text please',
'required' => '0',
),
array (
'key' => 'field_2',
'label' => 'Content',
'name' => 'content',
'type' => 'wysiwyg',
'instructions' => 'Add some text please',
'required' => '1',
'default_value' => '',
'toolbar' => 'full',
'media_upload' => 'yes',
'the_content' => 'yes',
),
),
'location' => array (
'rules' => array (
array (
'param' => 'post_type',
'operator' => '==',
'value' => 'page',
'order_no' => '0',
),
),
'allorany' => 'all',
),
'options' =>
array (
'position' => 'normal',
'layout' => 'no_box',
'hide_on_screen' =>
array (
),
),
'menu_order' => 0,
));

