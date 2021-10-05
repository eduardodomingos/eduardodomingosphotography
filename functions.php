<?php
/**
 * Eduardo Domingos Photography functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eduardo_Domingos_Photography
 */

define('LESSON_CATEGORIES', array('lessons' => 'aulasonline', 'workshops' => 'workshops') );

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'edp_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function edp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Eduardo Domingos Photography, use a find and replace
		 * to change 'edp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'edp', get_template_directory() . '/languages' );

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
				'menu-1' => esc_html__( 'Principal', 'edp' ),
				'menu-2' => esc_html__( 'Redes Sociais Footer', 'edp' ),
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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Disable the new WordPress widget
		remove_theme_support( 'widgets-block-editor' );
	}
endif;
add_action( 'after_setup_theme', 'edp_setup' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function edp_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'edp-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'edp_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function edp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'edp_content_width', 640 );
}
add_action( 'after_setup_theme', 'edp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'edp' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'edp' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Header', 'edp' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'edp' ),
			'before_widget' => '',
			'after_widget'  => ''
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'edp' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add widgets here.', 'edp' ),
			'before_widget' => '',
			'after_widget'  => ''
		)
	);
}
add_action( 'widgets_init', 'edp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function edp_scripts() {
	wp_enqueue_style( 'edp-fonts', '//fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;1,400&display=swap' );

	wp_enqueue_style( 'edp-style', get_stylesheet_uri(), array(), _S_VERSION );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'edp_scripts' );

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

/**
 * Disable Editor.
 */
require get_template_directory() . '/inc/disable-editor.php';

/**
 * BEM Menus.
 */
require get_template_directory() . '/inc/wp_bem_menu.php';

/**
 * Load custom widgets
 */
require get_template_directory() . "/widgets/recent-posts-enhanced.php";

/**
 * Modules for this theme.
 */
require get_template_directory() . '/inc/modules.php';