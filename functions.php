<?php
/**
 * Fraise functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fraise
 */

if ( ! function_exists( 'fraise_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fraise_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Fraise, use a find and replace
		 * to change 'fraise' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fraise', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'fraise' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		/**
		 * Add support for various Jetpack features
		 *
		 * @link https://jetpack.me
		 */
		add_theme_support( 'jetpack-social-menu' );
		add_theme_support( 'featured-content', array(
			'filter'     => 'fraise_get_featured_posts',
			'max_posts'  => 3,
			'post_types' => array( 'post', 'page' )
		) );
		
		/**
		 * Add support for editor styling
		 */
		add_editor_style( array( 'inc/css/editor-style.css', fraise_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'fraise_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fraise_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fraise_content_width', 640 );
}
add_action( 'after_setup_theme', 'fraise_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fraise_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fraise' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'fraise' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fraise_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fraise_scripts() {
	wp_enqueue_style( 'fraise-google-fonts', fraise_fonts_url() );
	wp_enqueue_style( 'fraise-style', get_stylesheet_uri() );

	wp_enqueue_script( 'fraise-functions', get_theme_file_uri( '/js/fraise.js' ), array( 'jquery' ), '20151215', true );
	wp_localize_script( 'fraise-functions', 'fraiseMenuText', array(
		/* translators: this is used on the button to open the menu */
		'open'  => esc_html__( 'Menu', 'fraise' ),
		/* translators: this is used when the menu is open, to indicate that this button now closes the menu */
		'close' => esc_html__( 'Close', 'fraise' )
	) );

	/* we don't need to enqueue the fancy slider stuff if there's only one featured post */
	if ( fraise_has_featured_posts( 2 ) ) {
		wp_enqueue_style( 'slick', get_theme_file_uri( '/inc/slick/slick.css' ) );
		wp_enqueue_script( 'slick', get_theme_file_uri( '/inc/slick/slick.js' ), array( 'jquery' ), null, true );
		wp_enqueue_script( 'fraise-load-slider', get_theme_file_uri( '/js/load-slick.js' ), array( 'jquery', 'slick' ), null, true );
	}
	
	wp_enqueue_script( 'fraise-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fraise_scripts' );

/**
 * Enqueue (and dequeue) Google fonts
 */
function fraise_fonts_url() {
	$fonts = '';
	$fonts_url = '';
	
	/* translators: If there are characters in your language that aren't supported by Source Sans Pro, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'fraise' ) ) {
		$fonts[] = 'Source Sans Pro:300,300i,400,400i,700,700i,900,900i';
	}
	
	/* translators: If there are characters in your language that aren't supported by Inconsolata, translate this to 'off'. Do not translat into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'fraise' ) ) {
		$fonts[] = 'Inconsolata';
	}
	
	if ( $fonts ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => 'latin,latin-ext'
		);
		
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}
	
	return esc_url_raw( $fonts_url );
}

/**
 * Various Jetpack functions
 */
function fraise_get_featured_posts() {
	return apply_filters( 'fraise_get_featured_posts', array() );
}

function fraise_has_featured_posts( $minimum = 1 ) {
	if ( is_paged() ) {
		return false;
	}	
	
	$minimum = absint( $minimum );
	$featured_posts = fraise_get_featured_posts();
	
	if ( ! is_array( $featured_posts ) ) {
		return false;
	}
	
	if ( $minimum > count( $featured_posts ) ) {
		return false;
	}
	
	return true;
}

function fraise_slider_body_classes( $classes ) {
	if ( fraise_has_featured_posts( 2 ) && is_front_page() ) {
		$classes[] = 'has-slider';
	}
	
	return $classes;
}
add_filter( 'body_class', 'fraise_slider_body_classes' );

/**
 * We use excerpts sometimes, so let's make them more interesting
 */
function fraise_excerpt_length() {
	return 10;
}
add_filter( 'excerpt_length', 'fraise_excerpt_length' );

function fraise_excerpt_more( $more ) {
	global $post;
	
	if ( has_excerpt() ) {
		return '';
	} else {
/*
		$read_more_text = sprintf( wp_kses( __( 'Continue reading <span class="screen-reader-text">%s</span>', 'fraise' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() );
		
		return sprintf( '&hellip;<a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink() ),
			$read_more_text
		);
*/
	}
}
add_filter( 'excerpt_more', 'fraise_excerpt_more' );

/**
 * Implement the Custom Header feature.
 */
require get_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_theme_file_path( '/inc/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_theme_file_path( '/inc/jetpack.php' );
}
