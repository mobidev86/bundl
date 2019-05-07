<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'bundl_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own bundl_setup() function to override in a child theme.
	 *
	 * @since Twenty Sixteen 1.0
	 */
	function bundl_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/bundl
		 * If you're building a theme based on Twenty Sixteen, use a find and replace
		 * to change 'bundl' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'bundl' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 *  @since Twenty Sixteen 1.2
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 240,
				'width'       => 240,
				'flex-height' => true,
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'bundl' ),
				'category_menu' => __( 'Category Menu', 'bundl' ),
				'social'  => __( 'Social Links Menu', 'bundl' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', bundl_fonts_url() ) );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Dark Gray', 'bundl' ),
					'slug'  => 'dark-gray',
					'color' => '#1a1a1a',
				),
				array(
					'name'  => __( 'Medium Gray', 'bundl' ),
					'slug'  => 'medium-gray',
					'color' => '#686868',
				),
				array(
					'name'  => __( 'Light Gray', 'bundl' ),
					'slug'  => 'light-gray',
					'color' => '#e5e5e5',
				),
				array(
					'name'  => __( 'White', 'bundl' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => __( 'Blue Gray', 'bundl' ),
					'slug'  => 'blue-gray',
					'color' => '#4d545c',
				),
				array(
					'name'  => __( 'Bright Blue', 'bundl' ),
					'slug'  => 'bright-blue',
					'color' => '#007acc',
				),
				array(
					'name'  => __( 'Light Blue', 'bundl' ),
					'slug'  => 'light-blue',
					'color' => '#9adffd',
				),
				array(
					'name'  => __( 'Dark Brown', 'bundl' ),
					'slug'  => 'dark-brown',
					'color' => '#402b30',
				),
				array(
					'name'  => __( 'Medium Brown', 'bundl' ),
					'slug'  => 'medium-brown',
					'color' => '#774e24',
				),
				array(
					'name'  => __( 'Dark Red', 'bundl' ),
					'slug'  => 'dark-red',
					'color' => '#640c1f',
				),
				array(
					'name'  => __( 'Bright Red', 'bundl' ),
					'slug'  => 'bright-red',
					'color' => '#ff675f',
				),
				array(
					'name'  => __( 'Yellow', 'bundl' ),
					'slug'  => 'yellow',
					'color' => '#ffef8e',
				),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // bundl_setup
add_action( 'after_setup_theme', 'bundl_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function bundl_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bundl_content_width', 840 );
}
add_action( 'after_setup_theme', 'bundl_content_width', 0 );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Sixteen 1.6
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function bundl_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'bundl-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'bundl_resource_hints', 10, 2 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function bundl_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'bundl' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'bundl' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
			array(
				'name'          => __( 'Footer Antwerp Office', 'bundl' ),
				'id'            => 'sidebar-2',
				'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'bundl' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
		
	register_sidebar(
		array(
			'name'          => __( 'Footer Menu', 'bundl' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'bundl' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer Social Links', 'bundl' ),
			'id'            => 'sidebar-4',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'bundl' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);	
}
add_action( 'widgets_init', 'bundl_widgets_init' );
if ( ! function_exists( 'bundl_fonts_url' ) ) :
	/**
	 * Register Google fonts for Twenty Sixteen.
	 *
	 * Create your own bundl_fonts_url() function to override in a child theme.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function bundl_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'bundl' ) ) {
			$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
		}

		/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'bundl' ) ) {
			$fonts[] = 'Montserrat:400,700';
		}

		/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'bundl' ) ) {
			$fonts[] = 'Inconsolata:400';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				),
				'https://fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function bundl_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'bundl_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function bundl_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'bundl-fonts', bundl_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'bundl-style', get_stylesheet_uri() );

	// Theme block stylesheet.
	//wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array( 'bundl-style' ), '20181230' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css');
	wp_enqueue_style( 'custom-demo', get_stylesheet_directory_uri() . '/css/custom-demo.css');
	wp_enqueue_style( 'Font Awesome', get_stylesheet_directory_uri() . '/css/font-awesome.css');
	wp_enqueue_style( 'bundl-block-style', get_template_directory_uri() . '/css/blocks.css', array( 'bundl-style' ), '20181230' );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'bundl-ie', get_template_directory_uri() . '/css/ie.css', array( 'bundl-style' ), '20160816' );
	wp_style_add_data( 'bundl-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'bundl-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'bundl-style' ), '20160816' );
	wp_style_add_data( 'bundl-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'bundl-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'bundl-style' ), '20160816' );
	wp_style_add_data( 'bundl-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	
	//wp_enqueue_script( 'jquery-waypoints-js', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array('jquery'));
	//wp_enqueue_script( 'inview.min-js', get_template_directory_uri() . '/js/inview.min.js', array('jquery'));
	wp_enqueue_script( 'tweenmax-min-js', get_template_directory_uri() . '/js/TweenMax.min.js', array());
	wp_enqueue_script( 'scrollmagic-js', get_template_directory_uri() . '/js/ScrollMagic.min.js', array('jquery'));
	wp_enqueue_script( 'animation-gsap-js', get_template_directory_uri() . '/js/animation.gsap.js', array('jquery'));
	wp_enqueue_script( 'debug-addIndicators-min-js', get_template_directory_uri() . '/js/debug.addIndicators.min.js', array('jquery'));
	
	wp_enqueue_script( 'morphext-js', get_template_directory_uri() . '/js/morphext.js', array('jquery'));
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'));
	wp_enqueue_script( 'slider-js', get_template_directory_uri() . '/js/ScrollMagic1.js', array('jquery'));
	wp_enqueue_script( 'bundl-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'bundl-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'bundl-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'bundl-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	}

	wp_enqueue_script( 'bundl-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20181230', true );

	wp_localize_script(
		'bundl-script',
		'screenReaderText',
		array(
			'expand'   => __( 'expand child menu', 'bundl' ),
			'collapse' => __( 'collapse child menu', 'bundl' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bundl_scripts' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Twenty Sixteen 1.6
 */
function bundl_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'bundl-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20181230' );
	// Add custom fonts.
	wp_enqueue_style( 'bundl-fonts', bundl_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'bundl_block_editor_styles' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function bundl_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'bundl_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function bundl_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function bundl_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 840 <= $width ) {
		$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	}

	if ( 'page' === get_post_type() ) {
		if ( 840 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	} else {
		if ( 840 > $width && 600 <= $width ) {
			$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		} elseif ( 600 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'bundl_content_image_sizes_attr', 10, 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function bundl_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'bundl_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function bundl_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}

//custome type post
function cptui_register_my_cpts_portfolio() {

	/**
	 * Post Type: portfolio.
	 */

	$labels = array(
		"name" => __( "portfolio", "twentyseventeen" ),
		"singular_name" => __( "portfolio", "twentyseventeen" ),
		"menu_name" => __( "Portfolio", "twentyseventeen" ),
		"view_item" => __( "Home page", "twentyseventeen" ),
		"view_items" => __( "Home page", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "portfolio", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		//"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats", "portfolio" ),
		//"taxonomies" => array( "category", "post_tag" ),
	);

	register_post_type( "portfolio", $args );
}
add_action( 'init', 'cptui_register_my_cpts_portfolio' );


//custome type post
function cptui_register_my_cpts_career() {
/**
	 * Post Type: Career
	 */

	$labels = array(
		"name" => __( "career", "twentyseventeen" ),
		"singular_name" => __( "career", "twentyseventeen" ),
		"menu_name" => __( "Career", "twentyseventeen" ),
		"view_item" => __( "Home page", "twentyseventeen" ),
		"view_items" => __( "Home page", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "career", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		//"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats", "career" ),
		//"taxonomies" => array( "category", "post_tag" ),
	);

	register_post_type( "career", $args );
}

add_action( 'init', 'cptui_register_my_cpts_career' );


if ( ! function_exists( 'career_cat_callback' ) ) {

// Register Custom Taxonomy
function career_cat_callback() {

	$labels = array(
		'name'                       => _x( 'Career categories', 'Taxonomy General Name', 'twentyseventeen' ),
		'singular_name'              => _x( 'Career category', 'Taxonomy Singular Name', 'twentyseventeen' ),
		'menu_name'                  => __( 'Career category', 'twentyseventeen' ),
		'all_items'                  => __( 'All Career category', 'twentyseventeen' ),
		'parent_item'                => __( 'Parent Career category', 'twentyseventeen' ),
		'parent_item_colon'          => __( 'Parent Career category:', 'twentyseventeen' ),
		'new_item_name'              => __( 'New Item Name', 'twentyseventeen' ),
		'add_new_item'               => __( 'Add New Item', 'twentyseventeen' ),
		'edit_item'                  => __( 'Edit Item', 'twentyseventeen' ),
		'update_item'                => __( 'Update Item', 'twentyseventeen' ),
		'view_item'                  => __( 'View Item', 'twentyseventeen' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'twentyseventeen' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'twentyseventeen' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'twentyseventeen' ),
		'popular_items'              => __( 'Popular Items', 'twentyseventeen' ),
		'search_items'               => __( 'Search Items', 'twentyseventeen' ),
		'not_found'                  => __( 'Not Found', 'twentyseventeen' ),
		'no_terms'                   => __( 'No items', 'twentyseventeen' ),
		'items_list'                 => __( 'Items list', 'twentyseventeen' ),
		'items_list_navigation'      => __( 'Items list navigation', 'twentyseventeen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'career_cat', array( 'career' ), $args );

}
add_action( 'init', 'career_cat_callback', 0 );

}

add_filter( 'widget_tag_cloud_args', 'bundl_widget_tag_cloud_args' );
require get_template_directory() . '/elementor-widget/blog-display-main.php';
require get_template_directory() . '/custom-functions/functions.php';