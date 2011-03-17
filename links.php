<?php
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage HTML5_Boilerplate
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.0.0
 * 
 * Template Name: Links
 */

?>

<?php get_header(); ?>

<div class="main eighty left">

  <h2>Links:</h2>
  <ul>
    <?php wp_list_bookmarks(); ?>
  </ul>

</div>

<?php get_footer(); ?>
