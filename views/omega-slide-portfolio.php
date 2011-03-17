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
	<div class="info">
		<h2><a href="<?php echo $params['ahref']; ?>">
			<?php echo $params['title']; ?></a></h2>
		<p>
			<?php echo $params['description']; ?>
			<a href="<?php echo $params['ahref']; ?>">
			Read More</a>
		</p>
		<a href="<?php echo $params['ahref']; ?>" class="nextproject">
			<?php echo $params['button']; ?></a>
		
		<?php /* ?>
		<a href="http://yourfolio.themedemo.net/category/my-portfolio/" class="view">
			View Complete Portfolio</a>
		<?php */ ?>
	</div>
	
	<div class="project_screen">
		<?php if ($params['img_src']): ?>
		<a href="<?php echo $params['ahref']; ?>">
			<img src="<?php echo $params['img_src']; ?>" alt="">
		</a>
		
		<?php else: ?>
		
		<?php endif; ?>
	</div>
<?php echo $sidebar['after_widget']; ?>