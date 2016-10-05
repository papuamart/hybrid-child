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

	/* Load any translation files for the user. */
	load_child_theme_textdomain( 'hybrid-child', get_stylesheet_directory() );
	
	/* Load shortcodes file. */
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/shortcodes.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/core.php' );
	require_once( trailingslashit( CHILD_THEME_DIR ) . 'functions/entries.php' );

	/* Load admin functions. */
	if ( is_admin() )
		require_once( trailingslashit( CHILD_THEME_DIR ) . 'includes/admin.php' );

	
	/* Example action. */
	add_theme_support( 'hybrid-core-menus', array( 'primary','secondary', 'subsidiary', ) );
	add_theme_support( 'entry-views');
 	
	/* Register shortcodes. */
	add_action( 'init', 'news_register_shortcodes' );
	
	/* Register additional widgets. */
	add_action( 'widgets_init', 'hybrid_news_register_widgets' );
	
	/* Register additional menus. */
	add_action( 'init', 'hybrid_news_register_menus', 11 );
	
	/* Register additional sidebars. */
	add_action( 'init', 'hybrid_news_register_sidebars', 11 );
	
		/* Register additional js script for scoll up. */
	add_action( 'init', 'hybrid_news_enqueue_script', 11 );
	
	/* Perform specific functions for the front page template. */
	add_action( 'template_redirect', 'hybrid_news_front_page_template' );

	add_action( "{$prefix}_before_header", 'hybrid_get_ygma_header_menu' );
	
	/* Remove theme 'primary-menu  afterh_eader' and set it into before_header. */
	remove_action( "{$prefix}_after_header", 'hybrid_get_primary_menu' );
	add_action( "{$prefix}_before_header", 'hybrid_get_primary_menu' );
	
	/* Add the additional  posttypes menu after the header primary-menu. */	
	add_action( "{$prefix}_after_primary_menu", 'hybrid_get_posttypes_menu' );

	/* Add the secondary menu after the header. */
	add_action( "{$prefix}_after_header", 'hybrid_get_secondary_menu' ); 

	/* Add the header sidebar to the header. */
	add_action( "{$prefix}_header", 'hybrid_news_get_utility_header', 11 );
	
	/* Set up the theme settings meta box. */
	add_action( 'admin_menu', 'hybrid_news_create_meta_box' );

	/* Additional sidebar to secondary sidebar. */
	add_action( "{$prefix}_after_container", 'hybrid_news_get_tertiary' );

	/* Add the title, byline, and entry meta before and after the entry. */
	remove_action( "{$prefix}_before_entry", 'hybrid_byline' );
	add_action( "{$prefix}_before_entry", 'hybrid_news_byline' );
	remove_action( "{$prefix}_after_entry", 'hybrid_entry_meta' );
	add_action( "{$prefix}_after_entry", 'hybrid_news_entry_meta' );
	
	/*Before sidebar to have postformats menu. */
	add_action( "{$prefix}_before_sidebar", 'hybrid_get_postformats_menu' ); 	

	/* Add the subsidiary, ygma-footer menu beforeer and after the footer. */
	add_action( "{$prefix}_after_footer", 'hybrid_get_subsidiary_menu' );
	add_action( "{$prefix}_after_footer", 'hybrid_get_ygma_footer_menu' );
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
}

/**
 * Loads the theme JavaScript files.
 *
 * @since 0.1.0
 */
function hybrid_news_enqueue_script() {
	wp_register_script( 'jquery-scrolltopcontrol', esc_url( apply_atomic( 'scrolltop_scripts', trailingslashit( CHILD_THEME_URI ) . 'js/scrolltopcontrol.js' ) ), array( 'jquery' ), '1.1', true );
	wp_enqueue_script( 'jquery-scrolltopcontrol' );
	wp_register_script( 'comment-ajax-scripts', esc_url( apply_atomic( 'comment_ajax_scripts',  get_bloginfo('stylesheet_directory') .'/js/comments-ajax.js' ) ), array( 'jquery' ), '1.3', true );
	wp_enqueue_script( 'comment-ajax-scripts' );	
  	
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'news-theme', CHILD_THEME_URI . '/js/news-theme.js', array( 'jquery' ), '1.4.8', true );

} /*hybrid_news_enqueue_script*/
 
/**
 * Loads the menu-primary.php template.
 *
 * @since 0.8.0
 * @uses get_template_part() Checks for template in child and parent theme.
 */
function hybrid_get_secondary_menu() {
	get_template_part( 'menu', 'secondary' );
}

function hybrid_get_subsidiary_menu() {
	get_template_part( 'menu', 'subsidiary' );
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
 * Loads the sidebar-header.php template, which loads the Utility: Header sidebar.
 *
 * @since 0.3.0
 */
function hybrid_news_get_utility_header() {
	get_sidebar( 'header' );
}
/**
 * Loads the sidebar-tertiary.php template, which displays the Tertiary sidebar.
 *
 * @since 0.3.0
 */
function hybrid_news_get_tertiary() {
	get_sidebar( 'tertiary' );
}

function hybrid_get_ygma_header_menu() {
	locate_template( array( 'menu-ygma-header.php', 'menu.php' ), true );
}

function hybrid_get_ygma_footer_menu() {
	locate_template( array( 'menu-ygma-footer.php', 'menu.php' ), true );
}

function hybrid_get_postformats_menu() {
	locate_template( array( 'menu-postformats.php', 'menu.php' ), true );
}

function hybrid_get_posttypes_menu() {
	locate_template( array( 'menu-posttypes.php', 'menu.php' ), true );
}

/**
function hybrid_news_byline() {
echo hybrid_news_posted_on (); // hybrid_after_entry  
}*/
/**
 * Default entry byline for posts.
 *
 * @since 0.5.0
 */
function hybrid_news_byline() {

	$byline = '';

	if ( 'post' == get_post_type() && 'link_category' !== get_query_var( 'taxonomy' ) )
		$byline = '<p class="byline">' . __( 'By [entry-author] on [entry-date-published] [entry-views before=" | Views: "] [entry-edit-link before=" | "]', 'hybrid-news' ) . '</p>';

	echo apply_atomic_shortcode( 'byline', $byline );
}

/**
 * Displays the default entry metadata.
 *
 * @since 0.5.0
 */
function hybrid_news_entry_meta() {

echo apply_atomic_shortcode( 'entry_meta', '<div class="segment">' . __( '[entry-cats-with-count] [entry-tags-with-count] [entry-words-count] [last-modified]', 'hybrid-news' ) . '</div>' ); 

}
#Theme Functions
function string_limit_words($string, $word_limit)
{
$words = explode(' ', $string, ($word_limit + 1));
if(count($words) > $word_limit)
array_pop($words);
return implode(' ', $words);
}

if ( ! function_exists( 'short_title' ) ) :
// to control the post title length
function short_title() {
 $title = get_the_title();
 $count = strlen($title);
 if ($count >= 65) {
 $title = substr($title, 0, 55);
 $title .= '...';
 }
 echo $title;
}
add_shortcode( 'short-title', 'short_title' );
endif;

/*
Plugin Name: Admin User Information
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
/***********************************
Getting User Information
*************************************/
function user_info($what) {
	global $current_user;
    get_currentuserinfo();
	print $current_user->$what;
}
function J_ShowAbout() { ?>
<div class="">
<h2 class="archiveheader">About</h2>
<div class="sidebarheader">
<h2 class="home">
<a href="<?php home_url('home'); ?>"><img  width="170" height="25" border="0" alt="Google" align="left" src="<?php bloginfo('stylesheet_directory'); ?>/images/doopm.gif">
</a><br clear="all">
<span style="font-size:16px;"><strong>Salam Jumpa! @PAPUApost.com</strong></span><br>
<span class="middle-headline">PAPUA Merdeka! News</span> <br /> <span class="small-headline">Bersuara Karena & Untuk KEBENARAN!</span></h2>		
Layanan WPNews Group Online. Sebagai Berita Tangan Pertama Keempat, Langsung dari Rimba Raya New Guinea Melayani untuk West Papua yang Merdeka dan Berdaulat di Luar NKRI. Bersuara sejak 1 Desember 2004.
</div></div>
<?php }

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
	
?>