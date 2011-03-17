<?php 
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage HTML5_Boilerplate
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.0
 * 
 * 
 */

defined('ABSPATH') or die("Cannot access pages directly.");

//initializing variables
extract($args[1]);

?>
<?php echo $sidebar['before_widget']; ?>
<?php echo $params['title'];?>
<?php echo $sidebar['after_widget']; ?>