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
 * This initial function hooks into and calls our next functions
 *
 */
function omega_initialize()
{
	//initializing variables
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
	//initializing theme options
	automatic_feed_links();
	
	//register all of theme files
	wp_register_script( 'omega_html5_modernizr', get_bloginfo('template_url')."/html5-boilerplate/js/modernizr-1.5.min.js", array(), OMEGA_VERSION);
	wp_register_script( 'omega_html5_plugins', get_bloginfo('template_url')."/html5-boilerplate/js/plugins.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_script', get_bloginfo('template_url')."/html5-boilerplate/js/script.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_belatedpng', get_bloginfo('template_url')."/html5-boilerplate/js/dd_belatedpng.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_yahoo', get_bloginfo('template_url')."/html5-boilerplate/js/profiling/yahoo-profiling.min.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_yahoo_config', get_bloginfo('template_url')."/html5-boilerplate/js/profiling/config.js", array('omega_html5_yahoo'), OMEGA_VERSION, true);
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'omega_html5_modernizr' );
	wp_enqueue_script( 'omega_html5_plugins' );
	wp_enqueue_script( 'omega_html5_script' );
	wp_enqueue_script( 'omega_html5_yahoo' );
	wp_enqueue_script( 'omega_html5_yahoo_config' );
	if ($is_IE) wp_enqueue_script( 'omega_html5_belatedpng' );
	
	wp_enqueue_style( 'omega_wp_styles', get_bloginfo('template_url')."/style.css", array(), OMEGA_VERSION);
	wp_enqueue_style( 'omega_html5_styles', get_bloginfo('template_url')."/html5-boilerplate/css/style.css", array(), OMEGA_VERSION);
	wp_enqueue_style( 'omega_handheld_styles', get_bloginfo('template_url')."/html5-boilerplate/css/handheld.css", array(), OMEGA_VERSION, 'media="handheld"');
	wp_enqueue_style( 'omega_layout', get_bloginfo('template_url')."/css/layout.css", array(), OMEGA_VERSION);
	
	//actions
	add_action( 'init', 'omega_show_ajax', 100 );
	add_filter( 'wp_get_nav_menu_items', 'omega_filter_nav_menu_items', 20, 3 );
	
	//sidebars
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'before_widget' => '<section>',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widgettitle">',
			'after_title' => '</h2>',
		));
	}
}

/**
 * Filter the nav menu items
 * 
 * possible filters
 * 		wp_nav_menu_items
 * 		wp_get_nav_menu_items
 * 
 * @param unknown_type $items
 * @param unknown_type $menu
 * @param unknown_type $args
 */
function omega_filter_nav_menu_items( $items, $menu, $args = array() )
{
	//initializing variables
	$current_pagename = get_pagename();
	
	//reasons to fail
	if (!is_array($items)) return $items;
	if (!$current_pagename) return $items;
	if (!is_custom_listing()) return $items;
	
	
	foreach ($items as $key => $item)
	{
		$pagename = get_pagename_fromurl( $item->url );
		if (strcmp($current_pagename, $pagename) !== 0) continue;
		
		$items[$key]->classes[] = 'current_page_item';
		$items[$key]->classes[] = 'current-menu-item';
	}
	return $items;
}

/**
 * Add ?v=[last modified time] to style sheets
 *
 * @param unknown_type $relative_url
 * @param unknown_type $add_attributes
 */
function versioned_stylesheet($relative_url, $add_attributes="")
{
	echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

/**
 * Add ?v=[last modified time] to javascripts
 *
 * @param unknown_type $relative_url
 * @param unknown_type $add_attributes
 */
function versioned_javascript($relative_url, $add_attributes="")
{
	echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

/**
 * Add ?v=[last modified time] to a file url
 *
 * @param unknown_type $relative_url
 * @return unknown
 */
function versioned_resource($relative_url)
{
	$file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
	$file_version = "";
	
	if(file_exists($file))
	{
		$file_version = "?v=".filemtime($file);
	}
	
	return $relative_url.$file_version;
}

/**
 * Custom HTML5 Comment Markup
 *
 * @param unknown_type $comment
 * @param unknown_type $args
 * @param unknown_type $depth
 */
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}








