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
 * The omega page menu makes sure that the omega_drop_menu is in the 
 * proper format upon default display of the pages
 *
 * @param unknown_type $args
 * @return unknown
 */
function omega_page_menu( $args )
{
	$defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
	'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '',
	'depth' => 0, 'walker' => '', 'theme_location' => '' );

	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;
	
	$nav_menu = $items = '';

	$show_container = false;
	if ( $args->container ) {
		$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		if ( in_array( $args->container, $allowed_tags ) ) {
			$show_container = true;
			$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
			$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
			$nav_menu .= '<'. $args->container . $id . $class . '>';
		}
	}
	
	$wp_list_pages = array(
		'depth'        => 0,
		'show_date'    => '',
		'date_format'  => get_option('date_format'),
		'child_of'     => 0,
		'exclude'      => '',
		'include'      => '',
		'title_li'     => '',
		'echo'         => false,
		'authors'      => '',
		'sort_column'  => 'menu_order, post_title',
		'link_before'  => '',
		'link_after'   => '',
		'walker' => '' 
	);
	
	$items = wp_list_pages( $wp_list_pages );
	
	//adding required classes
	require_once dirname(__file__).DS."simple_html_dom.php";
	$html = str_get_html('<div id="omega_page_menu">'.$items.'</div>');
	$count = $count2 = 0;
	
	$lis = $html->find('li');
	if ($first = $html->find('li', 0))
	{
		$first->class = $first->class.' omega-first-li-item';
	}
	foreach ($html->find('li') as $li)
	{
		if ($li->parent()->id == "omega_page_menu")
			$count++;
	}
	foreach ($html->find('li') as $li)
	{
		if ($li->parent()->id == "omega_page_menu")
		{
			$count2++;
			if ($count == $count2)
			{
				$li->class = $li->class.' omega-last-li-item';
			}
		}
	}
	$div = $html->find('div[id=omega_page_menu]',0);
	$items = $div->innertext;
	
	// Attributes
	$slug = 'menu-omega_drop_menu';
	$menu_id_slugs[] = $slug;
	$attributes = ' id="' . $slug . '"';
	$attributes .= $args->menu_class ? ' class="'. $args->menu_class .'"' : '';

	$nav_menu .= '<ul'. $attributes .'>';

	// Allow plugins to hook into the menu to add their own <li>'s
	$items = apply_filters( 'wp_nav_menu_items', $items, $args );
	$items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );
	$nav_menu .= $items;
	
	$nav_menu .= '</ul>';

	if ( $show_container )
		$nav_menu .= '</' . $args->container . '>';
	
	$nav_menu = apply_filters( 'wp_nav_menu', $nav_menu, $args );

	if ( $args->echo )
		echo $nav_menu;
	else
		return $nav_menu;
}

/**
 * This initial function hooks into and calls our next functions
 *
 */
function omega_initialize()
{
	//initializing theme options
	automatic_feed_links();
	
	//actions
	add_action( 'init', 'omega_show_ajax', 100 );
	add_action( 'init', 'omega_scripts' );
	add_action( 'init', 'omega_sidebars' );
	add_filter( 'wp_get_nav_menu_items', 'omega_filter_nav_menu_items', 20, 3 );
	
}

/**
 * This is the initialization for the front end
 *
 */
function omega_scripts()
{
	//reasons to fail
	if (is_admin()) return false;
	
	//initializing variables
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
	//register all of theme files
	wp_register_script( 'omega_html5_modernizr', get_bloginfo('template_url')."/html5-boilerplate/js/modernizr-1.5.min.js", array(), OMEGA_VERSION);
	wp_register_script( 'omega_html5_plugins', get_bloginfo('template_url')."/html5-boilerplate/js/plugins.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_script', get_bloginfo('template_url')."/html5-boilerplate/js/script.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_belatedpng', get_bloginfo('template_url')."/html5-boilerplate/js/dd_belatedpng.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_yahoo', get_bloginfo('template_url')."/html5-boilerplate/js/profiling/yahoo-profiling.min.js", array(), OMEGA_VERSION, true);
	wp_register_script( 'omega_html5_yahoo_config', get_bloginfo('template_url')."/html5-boilerplate/js/profiling/config.js", array('omega_html5_yahoo'), OMEGA_VERSION, true);
	
	wp_register_script( 'omega_jquery_dropmenu', get_bloginfo('template_url')."/dropmenu/js/jquery/jquery.dropdown.js", array('jquery'), OMEGA_VERSION, true);
	wp_register_script( 'omega_mootools_dropmenu', get_bloginfo('template_url')."/dropmenu/js/mootools/mootools.dropdown.js", array('mootools'), OMEGA_VERSION, true);
	wp_register_script( 'omega_scriptaculous_dropmenu', get_bloginfo('template_url')."/dropmenu/js/scriptaculous/mootools.scriptaculous.js", array('scriptaculous'), OMEGA_VERSION, true);
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'omega_jquery_dropmenu' );
	wp_enqueue_script( 'omega_html5_modernizr' );
	wp_enqueue_script( 'omega_html5_plugins' );
	wp_enqueue_script( 'omega_html5_script' );
	wp_enqueue_script( 'omega_html5_yahoo' );
	wp_enqueue_script( 'omega_html5_yahoo_config' );
	
	if ($is_IE)
	{
		wp_enqueue_script( 'omega_html5_belatedpng' );
		wp_enqueue_script( 'omega_jquery_dropmenu' );
	}
	
	wp_register_style( 'omega_dropmenu_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.css", array(), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-limited_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.limited.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-linear_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.linear.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-linear-columnar_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.linear.columnar.css", array('omega_dropmenu-linear_styles'), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-upward_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.upward.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-vertical_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.vertical.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
	wp_register_style( 'omega_dropmenu-vertical-rtl_styles', get_bloginfo('template_url')."/dropmenu/css/dropdown.vertical.rtl.css", array('omega_dropmenu-vertical_styles'), OMEGA_VERSION, 'all');
	
	wp_enqueue_style( 'omega_dropmenu_styles' );
	wp_enqueue_style( 'omega_wp_styles', get_bloginfo('template_url')."/style.css", array(), OMEGA_VERSION);
	wp_enqueue_style( 'omega_html5_styles', get_bloginfo('template_url')."/html5-boilerplate/css/style.css", array(), OMEGA_VERSION);
	wp_enqueue_style( 'omega_handheld_styles', get_bloginfo('template_url')."/html5-boilerplate/css/handheld.css", array(), OMEGA_VERSION, 'handheld');
	
	//check to see if any custom themes have been added to the dropmenu
	switch($omega_dropmenu_style = get_option('omega_dropmenu_style', ''))
	{
		default: break;
		case 'basic':
			wp_enqueue_style( 'omega_dropmenu-basic', get_bloginfo('template_url')."/dropmenu/css/themes/basic/default.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
			break;
		case 'adobe':
			wp_enqueue_style( 'omega_dropmenu-adobe.com-helper', get_bloginfo('template_url')."/dropmenu/css/themes/adobe.com/helper.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
			wp_enqueue_style( 'omega_dropmenu-adobe.com-default', get_bloginfo('template_url')."/dropmenu/css/themes/adobe.com/default.css", array('omega_dropmenu-adobe.com-helper'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-adobe.com-default-advanced', get_bloginfo('template_url')."/dropmenu/css/themes/adobe.com/default.advanced.css", array('omega_dropmenu-adobe.com-default'), OMEGA_VERSION, 'all');
			break;
		case 'default':
			wp_enqueue_style( 'omega_dropmenu-default-helper', get_bloginfo('template_url')."/dropmenu/css/themes/default/helper.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
			wp_enqueue_style( 'omega_dropmenu-default-default', get_bloginfo('template_url')."/dropmenu/css/themes/default/default.css", array('omega_dropmenu-default-helper'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-default-default-advanced', get_bloginfo('template_url')."/dropmenu/css/themes/default/default.advanced.css", array('omega_dropmenu-default-default'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-default-default-linear', get_bloginfo('template_url')."/dropmenu/css/themes/default/default.linear.css", array('omega_dropmenu-default-default'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-default-default-ultimate', get_bloginfo('template_url')."/dropmenu/css/themes/default/default.ultimate.css", array('omega_dropmenu-default-default'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-default-default-ultimate-linear', get_bloginfo('template_url')."/dropmenu/css/themes/default/default.ultimate.linear.css", array('omega_dropmenu-default-default-ultimate'), OMEGA_VERSION, 'all');
			break;
		case 'flickr':
			wp_enqueue_style( 'omega_dropmenu-flickr.com-helper', get_bloginfo('template_url')."/dropmenu/css/themes/flickr.com/helper.css", array('omega_dropmenu_styles'), OMEGA_VERSION, 'all');
			wp_enqueue_style( 'omega_dropmenu-flickr.com-default', get_bloginfo('template_url')."/dropmenu/css/themes/flickr.com/default.css", array('omega_dropmenu-flickr.com-helper'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-flickr.com-default-ultimate', get_bloginfo('template_url')."/dropmenu/css/themes/flickr.com/default.ultimate.css", array('omega_dropmenu-flickr.com-default'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-flickr.com-default-ultimate-linear', get_bloginfo('template_url')."/dropmenu/css/themes/flickr.com/default.ultimate.linear.css", array('omega_dropmenu-flickr.com-default-ultimate'), OMEGA_VERSION, 'all');
			wp_register_style( 'omega_dropmenu-flickr.com-default-ultimate-upward', get_bloginfo('template_url')."/dropmenu/css/themes/flickr.com/default.ultimate.upward.css", array('omega_dropmenu-flickr.com-default-ultimate'), OMEGA_VERSION, 'all');
			break;
	}
}

/**
 * Registering the sidebars
 *
 * @return unknown
 */
function omega_sidebars()
{
	//reasons to fail
	if ( !function_exists('register_sidebar') ) return false;
	
	register_sidebar(array(
		'name'          => __('Primary Menu'),
		'id'            => 'primary-menu',
		'description'   => __('Adding widgets to this sidebar will hide the menu.'),
		'before_widget' => '<section id="%1$s" class="widget primary-menu-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
	register_sidebar(array(
		'name'          => __('Omega Slider'),
		'id'            => 'omega-slider',
		'description'   => __('Widgets added here will display in the slider'),
		'before_widget' => '<section id="%1$s" class="slide %2$s"><div class="omega-padded">',
		'after_widget' 	=> '</div></section>',
		'before_title' 	=> '',
		'after_title' 	=> '',
	));
	register_sidebar(array(
		'name'          => __('Featured Content'),
		'id'            => 'featured-content',
		'description'   => __('These items display above the content and below the header'),
		'before_widget' => '<section id="%1$s" class="widget featured-content-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
	register_sidebar(array(
		'name'          => __('Left Sidebar'),
		'id'            => 'left-sidebar',
		'description'   => __('Adding widgets just above the footer.'),
		'before_widget' => '<section id="%1$s" class="widget left-sidebar-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
	register_sidebar(array(
		'name'          => __('After Content'),
		'id'            => 'after-content',
		'description'   => __('These items display after the content and before the footer'),
		'before_widget' => '<section id="%1$s" class="widget after-content-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
	register_sidebar(array(
		'name'          => __('Right Sidebar'),
		'id'            => 'sidebar-right',
		'description'   => __('This sidebar is to the far right of the content area.'),
		'before_widget' => '<section id="%1$s" class="widget sidebar-right-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
	register_sidebar(array(
		'name'          => __('Just Above Footer'),
		'id'            => 'just-above-footer',
		'description'   => __('Adding widgets just above the footer.'),
		'before_widget' => '<section id="%1$s" class="widget just-above-footer-widget %2$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h2 class="widgettitle">',
		'after_title' 	=> '</h2>',
	));
}

/**
 * Displays the 'omega-slider' sidebar slider
 *
 */
function omega_slider()
{
	//reasons to fail
	if ( !function_exists('twc_initialize') )
	{
		_e('<p>Omega Slider requires the <a href="http://www.totalwidgetcontrol.com">Total Widget Control</a> Plugin.</p>');
		return false;
	}
	if ( !function_exists('dynamic_sidebar')) return false;
	if ( !$slides = twc_get_sidebar('omega-slider') ) return false;
	
	$slider = versioned_stylesheet('slider/css/omega-slider.css')
	.'<div id="omega-slider" class="omega-height omega-width">'
		.'<div id="omega-left" class="omega-height" style="display:none;"><span>&lt;</span></div>'
		.'<div id="omega-inside" class="omega-height omega-width" style="display:none;">'
			.'<div id="omega-insider" class="omega-height">'.$slides.'</div>'
		.'</div>'
		.'<div id="omega-right" class="omega-height" style="display:none;"><span>&gt;</span></div>'
	.'</div>'
	.versioned_javascript('slider/js/omega-slider.js');
	
	switch ($omega_slider_theme = get_option('omega-slider-theme', 'default'))
	{
		default:
			echo versioned_stylesheet('slider/css/themes/default/default.css');
			break;
	}
	
	echo $slider;
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
	$count = $count2 = 0;
	
	//reasons to fail
	if (!is_array($items)) return $items;
	if (!$current_pagename) return $items;
	if (!is_custom_listing()) return $items;
	
	
	foreach ($items as $key => $item)
	{
		$count++;
		$pagename = get_pagename_fromurl( $item->url );
		if (strcmp($current_pagename, $pagename) !== 0) continue;
		
		$items[$key]->classes[] = 'current_page_item';
		$items[$key]->classes[] = 'current-menu-item';
	}
	foreach ($items as $key => $item)
	{
		$count2++;
		if ($count2 == 1)
		{
			$items[$key]->classes[] = 'omega-first-li-item';
		}
		if ($count != $count2) return false;
		$items[$key]->classes[] = 'omega-last-li-item';
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
	return '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

/**
 * Add ?v=[last modified time] to javascripts
 *
 * @param unknown_type $relative_url
 * @param unknown_type $add_attributes
 */
function versioned_javascript($relative_url, $add_attributes="")
{
	return '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

/**
 * Add ?v=[last modified time] to a file url
 *
 * @param unknown_type $relative_url
 * @return unknown
 */
function versioned_resource($relative_url)
{
	$file = dirname(dirname(__file__)).DS.$relative_url;
	$file_version = "";
	
	if(file_exists($file))
	{
		$file_version = "?v=".filemtime($file);
	}
	
	return get_bloginfo('template_url').'/'.$relative_url.$file_version;
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








