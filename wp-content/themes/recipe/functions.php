<?php
/**
 * recipe functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package recipe
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function recipe_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on recipe, use a find and replace
		* to change 'recipe' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'recipe', get_template_directory() . '/languages' );

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
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'recipe' ),
			'menu-2' => esc_html__( 'Social', 'recipe' ),
			'menu-3' => esc_html__( 'Footer', 'recipe' ),
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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'recipe_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'recipe_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function recipe_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'recipe_content_width', 640 );
}
add_action( 'after_setup_theme', 'recipe_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function recipe_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'recipe' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'recipe' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'recipe_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function recipe_scripts() {
	wp_enqueue_style( 'recipe-style', get_template_directory_uri().'/css/style.css', array(), _S_VERSION );
	wp_style_add_data( 'recipe-style', 'rtl', 'replace' );

	wp_enqueue_script( 'recipe-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'recipe-mobileToggle', get_template_directory_uri() . '/js/menuToggle.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'recipe_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function recipe_post_type() {
	register_post_type('wporg_product',
		array(
			'labels'      => array(
				'name'          => __('Recipes'),
				'singular_name' => __('recipe'),
			),
			'public'      => true,
			'has_archive' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-carrot',
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'author' ),
			'taxonomies'  => array( 'category' ),
		)
	);
}
add_action('init', 'recipe_post_type');

add_filter( 'allowed_block_types', 'recipe_allowed_block_types' );
 
function recipe_allowed_block_types( $allowed_blocks ) {
 
  return array(
    'core/image',
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/columns',
	'core/gallery',
	'core/list',
	'core/cover',
	'core/media-text',
	'core/buttons',
	'core/gallery',
	'core/latest-posts',
	'core/search',
	'core/shortcode',
	'core/group',
	'nextend/smartslider3'
  );
 
}