<?php 
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage Total Widget Control
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.5.5
 * 
 * @example 
<pre>
register_multiwidget(array(
	'id' => 'first-custom-widget',	// Must be slug compatible, and unique, it's used a lot
	'title' => __('aaaFirst Widget'),	
	'description' => __('This is my description'),	
	'classname' => 'st-custom-wi',	
	'show_view' => 'first_widget',	//This is the unique filename within the views folder, the theme is checked first, then defaults to the plugin
	'fields' => array(
	array(
		'name' => 'Text box',
		'desc' => 'Enter something here',
		'id' => 'text',
		'type' => 'text',
		'std' => 'Default value 1'
	),
	array(
		'type' => 'custom',
		'std' => '<hr/>'
	),
	array(
		'name' => 'Textarea',
		'desc' => 'Enter big text here',
		'id' => 'textarea',
		'type' => 'textarea',
		'std' => 'Default value 2'
	),
	array(
		'name' => 'Select box',
		'id' => 'select',
		'type' => 'select',
		'options' => array('Option 1', 'Option 2', 'Option 3')
	),
	array(
		'name' => 'Radio',
		'id' => 'radio',
		'type' => 'radio',
		'options' => array(
		array('name' => 'Name 1', 'value' => 'Value 1'),
		array('name' => 'Name 2', 'value' => 'Value 2')
		)
	),
	array(
		'name' => 'Checkbox',
		'id' => 'checkbox',
		'type' => 'checkbox'
	),
	
	)
));
</pre>
 * 
 * 
 */

defined('ABSPATH') or die("Cannot access pages directly.");

/**
 * 
 */
register_multiwidget(array(
	'id' => 'omega-slider-text',
	'title' => __('Omega Slide - Text'),	
	'description' => __('This widget is specifically for the omega slider sidebar. It will display plain text'),	
	'classname' => 'omega-slide-text',	
	'show_view' => 'omega-slide-text',
	'fields' => array(
	
	array(
		'name' => __('Title'),
		'id' => 'title',
		'type' => 'text',
		'std' => ''
	),
	
	)
));

/**
 * 
 */
register_multiwidget(array(
	'id' => 'omega-slider-portfolio',
	'title' => __('Omega Slide - Portfolio'),	
	'description' => __('This widget is specifically for the omega slider sidebar. This widget will display a large image with text and call to action buttons.'),	
	'classname' => 'omega-slide-portfolio',	
	'show_view' => 'omega-slide-portfolio',
	'fields' => array(
	
	array(
		'name' => __('Title'),
		'id' => 'title',
		'type' => 'text',
		'std' => ''
	),
	array(
		'name' => __('Description'),
		'id' => 'description',
		'type' => 'textarea',
		'std' => ''
	),
	
	array(
		'name' => __('Image Source'),
		'id' => 'img_src',
		'type' => 'text',
		'std' => ''
	),
	array(
		'name' => __('Link To'),
		'id' => 'ahref',
		'type' => 'text',
		'std' => ''
	),
	
	array(
		'name' => __('Button Text'),
		'id' => 'button',
		'type' => 'text',
		'std' => ''
	),
	
	)
));




