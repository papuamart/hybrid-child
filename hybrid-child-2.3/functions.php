<?php
/**
 * This is your child theme functions file.  In general, most PHP customizations should be placed within this
 * file.  Sometimes, you may have to overwrite a template file.  However, you should consult the theme 
 * documentation and support forums before making a decision.  In most cases, what you want to accomplish
 * can be done from this file alone.  This isn't a foreign practice introduced by parent/child themes.  This is
 * how WordPress works.  By utilizing the functions.php file, you are both future-proofing your site and using
 * a general best practice for coding.
 *
 * All style/design changes should take place within your style.css file, not this one.
 *
 * The functions file can be your best friend or your worst enemy.  Always double-check your code to make
 * sure that you close everything that you open and that it works before uploading it to a live site.
 *
 * @package HybridChild
 * @subpackage Functions
 */

/* Uncomment the below line to use the child theme setup function. */
add_action( 'after_setup_theme', 'hybrid_child_theme_setup', 11 );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since 0.1
 */
function hybrid_child_theme_setup() {

	/* Get the theme prefix ("prototype"). */
	$prefix = hybrid_get_prefix();


	/* Load shortcodes file. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/entries.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/shortcodes.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/shortcodes-papua.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/core.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/hooks-filters.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/postnotes.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/swc_shortcodes.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'extensions/subtitler.php' );

	/* Example action. */
	add_theme_support( 'hybrid-core-menus', array( 'primary','secondary', 'subsidiary', ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary', 'subsidiary', 'after-content', 'after-singular' ) );
	add_theme_support( 'front-page-template' ); /* this is to load /functions/widgets-papua.php */
	//add_theme_support( 'devnews-home-template' ); /* this is to load /functions/widgets-papua.php */
	add_theme_support( 'custom-header-image' ); /* this is to load /functions/widgets-papua.php */
	add_theme_support( 'entry-views' ); /* this is to load /functions/widgets-popular-tabs.php */
	add_theme_support( 'popular-inthis' ); /* this is to load /exetnsions/popinthis-tag/cat.php */
	add_theme_support( 'papua-sidebar-widgets' ); /* this is to load /includes/widgets-papua.php */
	add_theme_support( 'loop-pagination');
	
	/*
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );
	
	/* Register shortcodes. */
	add_action( 'init', 'news_register_shortcodes' );
		
	/* Register additional widgets. */
	add_action( 'widgets_init', 'hybrid_news_register_widgets' );
	
	/* Register additional menus. */
	add_action( 'init', 'hybrid_news_register_menus', 11 );
	
	/* Register additional sidebars. */
	add_action( 'init', 'hybrid_news_register_sidebars', 11 );	

	/* Disables widget areas. 
	add_filter( 'sidebars_widgets', 'hybrid_news_theme_remove_sidebars' );
*/
	/* Register additional js script for scoll up. */
	add_action( 'init', 'hybrid_news_enqueue_script', 11 );	
	
	/* Perform specific functions for the front page template. */
	add_action( 'template_redirect', 'hybrid_news_front_page_template' );
	add_action( 'template_redirect', 'hybrid_news_home_page_template' );

	/* Load the primary, secondary, ygma-header, posttypes menu. */
	add_action( "{$prefix}_before_header", 'hybrid_get_ygma_header_menu' );
	
	/* Add the header sidebar to the header. */
	add_action( "{$prefix}_before_header", 'hybrid_news_get_utility_header_meta', 11 );
		
	/* Remove theme 'primary-menu  afterh_eader' and set it into before_header. */
	remove_action( "{$prefix}_after_header", 'hybrid_get_primary_menu' );
	add_action( "{$prefix}_before_header", 'hybrid_get_primary_menu' );
	
	/* Add the additional  posttypes menu after the header primary-menu. */	
	add_action( "{$prefix}_after_primary_menu", 'hybrid_get_posttypes_menu' );

	/* Add the secondary menu after the header. */
	add_action( "{$prefix}_after_header", 'hybrid_get_secondary_menu' ); 	

	/* Add the title, byline, and entry meta before and after the entry. */
	remove_action( "{$prefix}_before_entry", 'hybrid_entry_title' );
	add_action( "{$prefix}_before_entry", 'hybrid_child_entry_title' );

	/* Add the title, byline, and entry meta before and after the entry. */
	remove_action( "{$prefix}_before_entry", 'hybrid_byline' );
	add_action( "{$prefix}_before_entry", 'news_posted_on' );
	remove_action( "{$prefix}_after_entry", 'hybrid_entry_meta' );
	add_action( "{$prefix}_after_entry", 'news_posted_in' );
	
	/* Set up the theme settings meta box.
	add_action( 'admin_menu', 'hybrid_news_create_meta_box' );
	 */
	/*Before sidebar to have postformats menu. */
	add_action( "{$prefix}_before_sidebar", 'hybrid_get_postformats_menu' ); 

	
	/* Additional sidebar to secondary sidebar. */
	add_action( "{$prefix}_before_primary", 'hybrid_child_before_primary' );
	add_action( "{$prefix}_after_container", 'hybrid_news_get_tertiary' );
	
	/* Add the subsidiary, ygma-footer menu beforeer and after the footer. */
	add_action( "{$prefix}_after_footer", 'hybrid_get_subsidiary_menu' );
	add_action( "{$prefix}_after_footer", 'hybrid_get_ygma_footer_menu' );

	/* Save the theme settings meta box settings. */
	add_filter( "sanitize_option_{$prefix}_theme_settings", 'hybrid_news_save_meta_box' );
	
	/* Load admin functions. */
	if ( is_admin() )
		require_if_theme_supports('devnews-home-template', trailingslashit( CHILD_THEME_DIR ) . 'admin/devnews-admin.php');
		require_if_theme_supports('front-page-template', trailingslashit( CHILD_THEME_DIR ) . 'admin/admin.php');
		require_if_theme_supports('custom-header-image', trailingslashit( CHILD_THEME_DIR ) . 'admin/header-function.php');
		
	}
 
/**
 * Loads the menu-secondary.php template.
 *
 * @since 0.8.0
 * @uses get_template_part() Checks for template in child and parent theme.
 */
function hybrid_get_secondary_menu() {
	get_template_part( 'menu', 'secondary' );
}
	
/**
 * Displays the post title.
 *
 * @since 0.5.0
 */
function hybrid_child_entry_title() {
	echo apply_atomic_shortcode( 'entry_title', '[entry-title]' );
	echo '<span class="entry-subtitle">';
	echo apply_atomic_shortcode( 'entry_subtitle', '[entry-subtitle]' );
	echo '</span>';
}

/**
 * Register additional menus.
 *
 * @since 0.1.0
 */

function hybrid_news_register_menus() {
	register_nav_menus(
		array(
			'posttypes' => __( 'Post Types Menu', hybrid_get_textdomain() ),
			'postformats' => __( 'Post Formats Menu', hybrid_get_textdomain() )
		)
	);
}
 
/**
 * Loads extra widget files and registers the widgets.
 * 
 * @since 0.1.0
 */
function hybrid_news_register_widgets() {
	
	/* Load the newsletter widget. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/widget-about.php' );
	register_widget( 'about_widget' );
	
	/* Load the newsletter widget. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/single-bottom-widget.php' );
	register_widget( 'PMNews_Widget_Post_Navigation' );	
	
	/* Load the newsletter widget. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/beeb-widget.php' );
	register_widget( 'PMThemeList' );
	register_widget( 'PMThemeLatestList' );
	register_widget( 'PMThemeCatLight' );
	register_widget( 'PMThemeThumbs' );
	register_widget( 'PMThemeVideo' );	
	register_widget( 'PMThemeComments' );	
	
	/* Load the popular tabs widget. */
	if ( current_theme_supports( 'entry-views' ) ) {
		require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/widget-popular-tabs.php' );
		register_widget( 'News_Widget_Popular_Tabs' );
	}

	/* Load the image stream widget. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/widget-image-stream.php' );
	register_widget( 'News_Widget_Image_Stream' );

	/* Load the newsletter widget. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/widget-newsletter.php' );
	register_widget( 'News_Widget_Newsletter' );
	
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/widgets-papua.php' );
	
}

/**
 * Removes all widget areas on the No Widgets page/post template.  No widget templates should come in
 * the form of $post_type-no-widgets.php.  This function also provides backwards compatibility with the old
 * no-widgets.php template.
 *
 * @since 0.9.0

function hybrid_news_theme_remove_sidebars( $sidebars_widgets ) {

	if ( is_page() ) {
		$post = get_queried_object();

		if ( hybrid_has_post_template( 'no-widgets.php' ) || hybrid_has_post_template( "{$post->post_type}-no-widgets.php" ) || !is_page_template("page-front-page.php") )
			$sidebars_widgets = array( false );
	}

	return $sidebars_widgets;
}
 */
function hybrid_child_byline() {
	$childbyline = '';

	if ( 'post' == get_post_type() && 'link_category' !== get_query_var( 'taxonomy' ) )
		$childbyline = '<p class="byline">' . __( 'By [entry-author after=" / "] on [entry-published] [entry-views before="/ Views "] [entry-edit-link before=" / "] [entry-comments-link  before=" / "]', hybrid_get_textdomain() ) . '</p>';

	echo apply_atomic_shortcode( 'hybrid_child_byline', $childbyline );
}
function hybrid_child_entry_meta() {

	$childmeta = '';

	if ( 'post' == get_post_type() )
		$childmeta = '<p id="" class="entry-meta">' . __( '[entry-cats-with-count after=" / "] [entry-tags-with-count after=" / "] [last-modified ]', hybrid_get_textdomain() ) . '</p>';

	elseif ( is_page() && current_user_can( 'edit_page', get_the_ID() ) )
		$childmeta = '<p class="entry-meta"> [entry-tag-with-count] [entry-edit-link]</p>';

	echo apply_atomic_shortcode( 'entry_meta', $childmeta );
}

/**
 * Loads the theme JavaScript files.
 *
 * @since 0.1.0
 */
function hybrid_news_enqueue_script() {
	wp_register_script( 'jquery-scrolltopcontrol', esc_url( apply_atomic( 'pmnews_scrolltop_scripts', trailingslashit( CHILD_THEME_URI ) . 'js/scrolltopcontrol.js' ) ), array( 'jquery' ), '1.1', true );
	wp_enqueue_script( 'jquery-scrolltopcontrol' );
	wp_register_script( 'comment-ajax-scripts', esc_url( apply_atomic( 'pmnews_comment_ajax_scripts',  get_bloginfo('stylesheet_directory') .'/js/comments-ajax.js' ) ), array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'comment-ajax-scripts' );
  	
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'news-theme', CHILD_THEME_URI . '/js/news-theme.js', array( 'jquery' ), '1.4.8', true );
}
 

/**
 * Register additional widget areas
 *
 * @since 0.3.0
 */
function hybrid_news_register_sidebars() {
	register_sidebar( array( 'name' => __( 'Tertiary', 'hybrid-child' ), 'id' => 'tertiary', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Utility: Header Meta', 'hybrid-child' ), 'id' => 'utilityheader', 'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">', 'after_widget' => '</div></div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>' ) );
}

/**
 * Loads the sidebar-header-meta.php template, which loads the Utility: Header sidebar.
 *
 * @since 0.3.0
 */
function hybrid_news_get_utility_header_meta() {
	get_sidebar( 'header-meta' );
}

/**
 * Loads the sidebar-tertiary.php template, which displays the Tertiary sidebar.
 *
 * @since 0.3.0
 */
function hybrid_news_get_tertiary() {
	get_sidebar( 'tertiary' );
}

/**
 * Loads the menu-ygma-header.php template, which displays the Menu YGMA Header.
 *
 * @since 0.3.0
 */
function hybrid_get_ygma_header_menu() {
	locate_template( array( 'menu-ygma-header.php', 'menu.php' ), true );
}

/**
 * Loads the menu-ygma-footer.php template, which displays the Menu YGMA Footer.
 *
 * @since 0.3.0
 */
function hybrid_get_ygma_footer_menu() {
	locate_template( array( 'menu-ygma-footer.php', 'menu.php' ), true );
}

/**
 * Loads the menu-postformats.php template, which displays the Postformats Menu.
 *
 * @since 0.3.0
 */
function hybrid_get_postformats_menu() {
	locate_template( array( 'menu-postformats.php', 'menu.php' ), true );
}

/**
 * Loads the menu-posttypes.php template, which displays the Post Types Menu.
 *
 * @since 0.3.0
 */
function hybrid_get_posttypes_menu() {
	locate_template( array( 'menu-posttypes.php', 'menu.php' ), true );
}

/*
* This is additional loop-navigation on the side before hybrid_before_primary
* hybrid_sidebar_loop_nav
*/
function hybrid_child_before_primary() {
locate_template( array( 'loop-nav-sidebar.php', 'loop-nav.php' ), true );
}

/**
 * Adds JavaScript and CSS to Front Page page template.
 * Also removes the breadcrumb menu.
 *
 * @since 0.3.0
 */
function hybrid_news_front_page_template() {

	/* If we're not looking at the front page template, return. */
	if ( !is_page_template( 'page-front-page.php' ) )
		return;

	/* Load the jQuery Cycle plugin JavaScript and custom JavaScript for it. */
	wp_enqueue_script( 'slider', get_stylesheet_directory_uri() . '/js/jquery.cycle.js', array( 'jquery' ), 0.1, true );

	/* Load the front page stylesheet. */
	wp_enqueue_style( 'front-page', get_stylesheet_directory_uri() . '/css/front-page.css', false, '0.1', 'screen' );

	/* Remove the breadcrumb trail. */
	add_filter( 'breadcrumb_trail', '__return_false' );
}

function hybrid_news_home_page_template() {
if (current_theme_supports('devnews-home-template') ) 
	//wp_deregister_script( 'news-theme' );
	wp_deregister_style( 'devnews-home-page' );
	wp_register_style('devnews-home-page', esc_url( apply_atomic( 'devnews_home_csss', trailingslashit( get_stylesheet_directory_uri()) . 'css/devnews-home-page.css') ), false);	
	//wp_register_script( 'news-theme', esc_url( apply_atomic( 'hybrid_news_theme_js', get_stylesheet_directory_uri() .'/library/js/news-theme.js' ) ), array( 'jquery' ), '1.4.8', true );
	//wp_enqueue_script( 'news-theme' );
	wp_enqueue_style( 'devnews-home-page' ); 
}
	 
?>