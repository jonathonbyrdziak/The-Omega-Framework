<?php 
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage HTML5_Boilerplate
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.0.0
 * 
 * 
 */

defined('ABSPATH') or die("Cannot access pages directly.");

/**
 * function is used as a template code to insert a drop menu into 
 * the website
 *
 * @param unknown_type $args
 */
function omega_drop_menu( $args = array() )
{
	$defaults = array(
		'theme_location'  => 'Header Menu',
		'menu'            => 'Header Menu', 
		'container'       => '', 
		'container_class' => '', 
		'container_id'    => '', 
		'menu_class'      => 'main_nav dropdown', 
		'menu_id'         => 'menu-{menu slug}-container',
		'echo'            => true,
		'fallback_cb'     => 'omega_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0
	);
	
	$args = wp_parse_args( $args, $defaults );
	wp_nav_menu( $args );
}

