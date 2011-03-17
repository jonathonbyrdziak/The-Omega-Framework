<?php
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage HTML5_Boilerplate
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.0.0
 * 
 */
?>

  <?php get_sidebar(); ?>
  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('just-above-footer') ){} ?>
  
  <footer class="clearfix">
      <p>
        <a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a>
        and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>.
        <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
      </p>
  </footer>
  
</div> <!--! end of #container -->

  <?php wp_footer(); ?>

</body>
</html>
